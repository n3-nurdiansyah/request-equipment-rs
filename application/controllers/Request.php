<?php
class Request extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load model dan library validasi
        $this->load->model('Equipment_request_model', 'req_model');
        $this->load->library('form_validation');
    }

    public function index($offset = 0)
    {
        $this->load->library('pagination');

        // Parameter pencarian dari URL (GET)
        $search = $this->input->get('search', TRUE);
        $status = $this->input->get('status', TRUE);

        // Styling Pagination Tailwind
        $config['base_url']    = site_url('request/index');
        $config['per_page']    = 10;
        $config['uri_segment'] = 3;
        $config['reuse_query_string'] = TRUE; // PENTING: Membawa ?search=... ke halaman 2, 3, dst
        $config['full_tag_open']   = '<div class="flex items-center gap-1 mt-4">';
        $config['full_tag_close']  = '</div>';
        $config['num_tag_open']    = '';
        $config['num_tag_close']   = '';
        $config['cur_tag_open']    = '<button class="px-3 py-1.5 rounded-lg bg-indigo-600 text-white text-sm font-medium shadow-sm">';
        $config['cur_tag_close']   = '</button>';
        $config['next_link']       = 'Next';
        $config['prev_link']       = 'Prev';
        $config['first_link']      = 'First';
        $config['last_link']       = 'Last';
        $config['attributes']      = array('class' => 'px-3 py-1.5 rounded-lg border border-white/60 bg-white/50 text-slate-600 hover:bg-white/80 text-sm font-medium transition-colors');

        // Fungsi bantuan (Closure) untuk menerapkan filter agar tidak menulis ulang query
        $apply_filters = function () use ($search, $status) {
            if (!empty($status) && $status !== 'all') {
                $this->db->where('equipment_requests.status', $status);
            }
            if (!empty($search)) {
                $this->db->group_start();
                $this->db->like('equipment_requests.request_code', $search);
                $this->db->or_like('equipment_requests.equipment_name', $search);
                $this->db->or_like('equipment_requests.serial_number', $search);
                $this->db->or_like('hospitals.hospital_name', $search);
                $this->db->group_end();
            }
        };

        if ($this->current_user['role'] == 'admin') {

            // --- LOGIKA ADMIN (Server-Side Filter) ---
            $this->db->join('hospitals', 'hospitals.id = equipment_requests.hospital_id', 'left');
            $apply_filters(); // Terapkan pencarian
            $config['total_rows'] = $this->db->count_all_results('equipment_requests');

            $this->pagination->initialize($config);

            $this->db->select('equipment_requests.*, hospitals.hospital_name');
            $this->db->join('hospitals', 'hospitals.id = equipment_requests.hospital_id', 'left');
            $apply_filters(); // Terapkan pencarian lagi untuk get data
            $this->db->order_by('equipment_requests.id', 'DESC');
            $this->db->limit($config['per_page'], $offset);

            $data['requests'] = $this->db->get('equipment_requests')->result_array();

            // Kirim parameter ke view agar nilai input tidak hilang setelah submit
            $data['search'] = $search;
            $data['status'] = $status;
            $data['pagination'] = $this->pagination->create_links();

            $this->render_glass_view('admin/request_index', $data);
        } else {
            // --- LOGIKA USER (Tetap sama) ---
            $hospital_id = $this->current_user['hospital_id'];

            $config['total_rows'] = $this->db->where('hospital_id', $hospital_id)->count_all_results('equipment_requests');
            $this->pagination->initialize($config);

            $data['requests'] = $this->db->order_by('id', 'DESC')
                ->limit($config['per_page'], $offset)
                ->get_where('equipment_requests', ['hospital_id' => $hospital_id])
                ->result_array();

            $data['pagination'] = $this->pagination->create_links();
            $this->render_glass_view('request/index', $data);
        }
    }

    public function view($id)
    {
        $data['req'] = $this->req_model->get_request_secure($id, $this->current_user['hospital_id']);

        if (!$data['req']) {
            show_404(); // Jika data tidak ada atau bukan milik RS tersebut
        }

        $this->render_glass_view('request/view', $data);
    }

    public function create()
    {
        // Hanya role 'hospital' yang boleh membuat pengajuan
        if ($this->current_user['role'] !== 'hospital') {
            $this->session->set_flashdata('error', 'Akses ditolak. Hanya Rumah Sakit yang dapat mengajukan.');
            redirect('dashboard');
        }

        $this->render_glass_view('request/create');
    }

    public function store()
    {
        // 1. Validasi Input
        $this->form_validation->set_rules('equipment_name', 'Nama Alat', 'required|trim');
        $this->form_validation->set_rules('serial_number', 'Nomor Seri', 'required|trim|alpha_numeric_spaces');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('request/create');
        }

        // 2. Ambil data dengan XSS Clean (TRUE)
        $post_data = [
            'equipment_name' => $this->input->post('equipment_name', TRUE),
            'serial_number'  => $this->input->post('serial_number', TRUE)
        ];

        // 3. Simpan via Model (Menggunakan Transactions)
        $hospital_id = $this->current_user['hospital_id'];
        $insert = $this->req_model->submit_request($hospital_id, $post_data);

        if ($insert) {
            $this->session->set_flashdata('success', 'Pengajuan alat kesehatan berhasil dikirim!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data. Terjadi kesalahan sistem.');
        }

        // 4. Kembalikan ke halaman daftar pengajuan
        redirect('request');
    }

    public function edit($id)
    {
        $data['req'] = $this->req_model->get_request_secure($id, $this->current_user['hospital_id']);

        if (!$data['req'] || !in_array($data['req']['status'], ['pending', 'rejected'])) {
            $this->session->set_flashdata('error', 'Data tidak dapat diedit pada status ini.');
            redirect('request');
        }

        $this->render_glass_view('request/edit', $data);
    }

    public function update($id)
    {
        $req = $this->req_model->get_request_secure($id, $this->current_user['hospital_id']);
        if (!$req) show_404();

        // Validasi input
        $post_data = [
            'equipment_name' => $this->input->post('equipment_name', TRUE),
            'serial_number'  => $this->input->post('serial_number', TRUE),
            'status'         => 'pending' // Kembalikan ke pending jika sebelumnya rejected
        ];

        $this->req_model->update_request($id, $post_data);
        $this->session->set_flashdata('success', 'Data pengajuan berhasil diperbarui.');
        redirect('request');
    }

    public function delete($id)
    {
        $request = $this->req_model->get_by_id($id);
        // Batalkan/Hapus hanya jika status masih pending
        if (!$request || $request['hospital_id'] !== $this->current_user['hospital_id'] || $request['status'] !== 'pending') {
            $this->session->set_flashdata('error', 'Gagal membatalkan pengajuan.');
            redirect('request');
        }

        if ($this->db->delete('equipment_requests', ['id' => $id])) {
            $this->session->set_flashdata('success', 'Pengajuan berhasil dibatalkan.');
        } else {
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat menghapus data.');
        }
        redirect('request');
    }

    // Fitur Admin: Memproses sertifikat (menggunakan library DomPDF/Mpdf)
    public function generate_certificate($request_id)
    {
        if ($this->current_user['role'] !== 'admin') show_404();

        // Logika generate PDF (DomPDF)
        // Update tabel check_results dengan path PDF
        // Update status equipment_requests menjadi 'completed'
    }

    public function cancel($id)
    {
        $req = $this->req_model->get_request_secure($id, $this->current_user['hospital_id']);

        if ($req && $req['status'] == 'pending') {
            $this->req_model->delete_request($id);
            $this->session->set_flashdata('success', 'Pengajuan berhasil dibatalkan dan dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Pengajuan tidak dapat dibatalkan.');
        }
        redirect('request');
    }

    public function download_cert($id)
    {
        $req = $this->req_model->get_request_secure($id, $this->current_user['hospital_id']);

        if (!$req || $req['status'] != 'completed') {
            show_404();
        }

        // Panggil namespace Dompdf
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true); // Penting jika PDF memuat gambar dari URL/Tailwind CDN
        $dompdf = new \Dompdf\Dompdf($options);

        // Desain HTML Sertifikat (Bisa juga diload dari file View terpisah)
        $html = "
            <div style='text-align: center; font-family: sans-serif; border: 5px solid #4f46e5; padding: 40px;'>
                <h1 style='color: #1e293b;'>SERTIFIKAT KALIBRASI ALAT KESEHATAN</h1>
                <hr style='border: 1px solid #cbd5e1; margin: 20px 0;'>
                <p style='color: #64748b;'>Diberikan kepada: <strong>RS Medika Utama</strong></p>
                <p>Menyatakan bahwa alat dengan rincian berikut:</p>
                <h2 style='color: #4f46e5; margin-bottom: 5px;'>{$req['equipment_name']}</h2>
                <p style='margin-top: 0; color: #475569;'>Nomor Seri: {$req['serial_number']} | Kode Request: {$req['request_code']}</p>
                <br>
                <h3 style='background-color: #10b981; color: white; display: inline-block; padding: 10px 20px; border-radius: 5px;'>LULUS UJI KALIBRASI</h3>
                <br><br>
                <p style='text-align: right; margin-top: 50px;'>
                    Dikeluarkan pada: " . date('d M Y') . "<br>
                    <strong>BPAFK Jakarta</strong>
                </p>
            </div>
        ";

        $dompdf->loadHtml($html);

        // Atur ukuran kertas
        $dompdf->setPaper('A4', 'landscape');

        // Render HTML menjadi PDF
        $dompdf->render();

        // Output file PDF ke browser (Attachment = false agar PDF terbuka di tab baru, bukan langsung download)
        $dompdf->stream("Sertifikat_{$req['request_code']}.pdf", ["Attachment" => false]);
    }

    public function update_status($id, $status)
    {
        // Proteksi ketat: Hanya admin yang boleh mengeksekusi ini
        if ($this->current_user['role'] !== 'admin') {
            show_404();
        }

        $valid_statuses = ['pending', 'processing', 'completed', 'rejected'];

        if (in_array($status, $valid_statuses)) {
            $this->req_model->update_request($id, ['status' => $status]);
            $this->session->set_flashdata('success', "Status pengajuan berhasil diubah menjadi " . strtoupper($status));
        } else {
            $this->session->set_flashdata('error', 'Status tidak valid.');
        }

        redirect('request');
    }
}
