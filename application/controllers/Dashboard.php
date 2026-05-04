<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    public function index()
    {
        $role = $this->current_user['role'] ?? '';
        $hospital_id = $this->current_user['hospital_id'] ?? NULL;

        // Kita gunakan array filter agar query lebih bersih
        $filter = [];
        if ($role !== 'admin') {
            // Jika hospital_id tidak ditemukan, kita set ke -1 agar tidak menampilkan data orang lain (NULL)
            $filter['hospital_id'] = ($hospital_id) ? $hospital_id : -1;
        }

        // 1. Hitung Total Alat (Semua status)
        $data['total_count'] = $this->db->where($filter)->count_all_results('equipment_requests');

        // 2. Hitung Sedang Diproses (Filter status pending/processing)
        $data['processing_count'] = $this->db->where($filter)
            ->where_in('status', ['pending', 'processing'])
            ->count_all_results('equipment_requests');

        // 3. Hitung Selesai Validasi
        $data['completed_count'] = $this->db->where($filter)
            ->where('status', 'completed')
            ->count_all_results('equipment_requests');

        // 4. Ambil 5 pengajuan terakhir
        $data['recent_requests'] = $this->db->where($filter)
            ->order_by('id', 'DESC')
            ->limit(5)
            ->get('equipment_requests')
            ->result_array();

        $this->render_glass_view('dashboard/index', $data);
    }
}
