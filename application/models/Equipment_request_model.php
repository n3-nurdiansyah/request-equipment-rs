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

    // Tambahkan di dalam class Equipment_request_model

    // Mengambil 1 data dengan validasi kepemilikan (IDOR Protection)
    public function get_request_secure($id, $hospital_id)
    {
        return $this->db->get_where($this->table, [
            'id' => $id,
            'hospital_id' => $hospital_id
        ])->row_array();
    }

    public function update_request($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete_request($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    // Mengambil semua data pengajuan beserta nama RS untuk Admin
    public function get_all_with_hospital()
    {
        $this->db->select('equipment_requests.*, hospitals.hospital_name');
        $this->db->from($this->table);
        $this->db->join('hospitals', 'hospitals.id = equipment_requests.hospital_id', 'left');
        $this->db->order_by('equipment_requests.created_at', 'DESC');
        return $this->db->get()->result_array();
    }
}
