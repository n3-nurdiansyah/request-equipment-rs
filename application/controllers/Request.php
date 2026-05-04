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
        $hospital_id = $this->current_user['hospital_id'];
        $this->load->library('pagination');

        // Konfigurasi Pagination
        $config['base_url']    = site_url('request/index');
        $config['total_rows']  = $this->db->where('hospital_id', $hospital_id)->count_all_results('equipment_requests');
        $config['per_page']    = 10;
        $config['uri_segment'] = 3;

        // Styling Pagination Tailwind agar sesuai dengan UI Glassmorphism
        $config['full_tag_open']   = '<div class="flex items-center gap-1">';
        $config['full_tag_close']  = '</div>';
        $config['num_tag_open']    = '';
        $config['num_tag_close']   = '';
        $config['cur_tag_open']    = '<button class="px-3 py-1.5 rounded-lg bg-indigo-600 text-white text-sm font-medium shadow-sm">';
        $config['cur_tag_close']   = '</button>';
        $config['next_link']       = 'Next';
        $config['prev_link']       = 'Prev';
        $config['first_link']      = 'First';
        $config['last_link']       = 'Last';

        // Menambahkan class Tailwind ke setiap link <a>
        $config['attributes'] = array('class' => 'px-3 py-1.5 rounded-lg border border-white/60 bg-white/50 text-slate-600 hover:bg-white/80 text-sm font-medium transition-colors');

        $this->pagination->initialize($config);

        // Ambil data dengan limit dan offset dari URL
        $data['requests'] = $this->db->order_by('id', 'DESC')
            ->limit($config['per_page'], $offset)
            ->get_where('equipment_requests', ['hospital_id' => $hospital_id])
            ->result_array();

        $data['pagination'] = $this->pagination->create_links();
        $data['total_rows'] = $config['total_rows'];
        $data['start']      = $offset;
        $data['per_page']   = $config['per_page'];

        $this->render_glass_view('request/index', $data);
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
        $request = $this->req_model->get_by_id($id);

        // Proteksi: pastikan data milik RS yang login dan status masih pending
        if (!$request || $request['hospital_id'] !== $this->current_user['hospital_id']) {
            show_404();
        }

        if ($request['status'] !== 'pending') {
            $this->session->set_flashdata('error', 'Data tidak dapat diubah karena sudah masuk tahap proses.');
            redirect('request');
        }

        $data['request'] = $request;
        $this->render_glass_view('request/edit', $data);
    }

    public function update($id)
    {
        $request = $this->req_model->get_by_id($id);
        if (!$request || $request['hospital_id'] !== $this->current_user['hospital_id'] || $request['status'] !== 'pending') {
            redirect('request');
        }

        $this->form_validation->set_rules('equipment_name', 'Nama Alat', 'required|trim');
        $this->form_validation->set_rules('serial_number', 'Nomor Seri', 'required|trim|alpha_numeric_spaces');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('request/edit/' . $id);
        }

        $update_data = [
            'equipment_name' => $this->input->post('equipment_name', TRUE),
            'serial_number'  => $this->input->post('serial_number', TRUE)
        ];

        if ($this->req_model->update($id, $update_data)) {
            $this->session->set_flashdata('success', 'Pengajuan berhasil diperbarui.');
        } else {
            $this->session->set_flashdata('error', 'Gagal memperbarui data.');
        }

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
}
