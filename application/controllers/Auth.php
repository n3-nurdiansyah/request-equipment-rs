<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load library dan helper yang dibutuhkan
        $this->load->library('session');
        $this->load->library('form_validation');
        // Asumsi Anda sudah membuat Auth_model, jika belum, kita akan buat logikanya sebentar lagi
        $this->load->model('Auth_model');
    }

    public function login()
    {
        // Jika user sudah login, langsung arahkan ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        // Tampilkan view login (yang sudah kita buat sebelumnya)
        $this->load->view('auth/login');
    }

    public function do_login()
    {
        // Validasi input form (Security Best Practice)
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/login');
        }

        // Ambil data POST (XSS Clean aktif jika di-setting di config)
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        // Cek ke database melalui Model
        $user = $this->Auth_model->check_user($username);

        if ($user) {
            // Verifikasi password hash (Karena kita mendesain database dengan password_hash)
            if (password_verify($password, $user['password_hash'])) {

                // Set Session Data
                $session_data = [
                    'id'          => $user['id'],
                    'username'    => $user['username'],
                    'role'        => strtolower($user['role']), // Memastikan lowercase untuk konsistensi
                    'logged_in'   => TRUE
                ];

                // Jika role hospital, ambil ID RS-nya (asumsi query JOIN/terpisah)
                if (strtolower($user['role']) == 'hospital') {
                    $hospital = $this->db->get_where('hospitals', ['user_id' => $user['id']])->row_array();
                    // Pastikan hospital_id tersimpan. Jika NULL, dashboard akan menampilkan 0 karena filter -1
                    $session_data['hospital_id'] = isset($hospital['id']) ? $hospital['id'] : NULL;
                } else {
                    $session_data['hospital_id'] = NULL;
                }

                $this->session->set_userdata($session_data);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Password yang Anda masukkan salah.');
                redirect('auth/login');
            }
        } else {
            $this->session->set_flashdata('error', 'Username tidak ditemukan di sistem.');
            redirect('auth/login');
        }
    }

    public function logout()
    {
        // Hancurkan semua session dan kembalikan ke halaman login
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
