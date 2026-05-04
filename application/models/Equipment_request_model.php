<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Equipment_request_model extends MY_Model
{

    // Memberitahu MY_Model tabel apa yang diakses
    protected $table = 'equipment_requests';

    // Membuat kode pengajuan unik otomatis
    public function generate_request_code()
    {
        return 'REQ-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 5));
    }

    public function submit_request($hospital_id, $data)
    {
        $this->db->trans_start(); // Mulai Transaksi Database

        $insert_data = [
            'hospital_id'    => $hospital_id,
            'request_code'   => $this->generate_request_code(),
            'equipment_name' => $data['equipment_name'],
            'serial_number'  => $data['serial_number'],
            'request_date'   => date('Y-m-d'),
            'status'         => 'pending'
        ];

        // Insert menggunakan fungsi dari MY_Model
        $this->insert($insert_data);

        $this->db->trans_complete(); // Selesaikan Transaksi

        // Cek jika terjadi kegagalan query
        if ($this->db->trans_status() === FALSE) {
            log_message('error', 'Gagal memproses request pengajuan alat untuk RS ID: ' . $hospital_id);
            return FALSE;
        }

        return TRUE;
    }
}
