<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Base Controller
 * Handles global authentication, session validation, and layout rendering.
 */
class MY_Controller extends CI_Controller
{
    protected $current_user;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->check_auth();
    }

    protected function check_auth()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        // Ambil data user secara eksplisit agar bersih dari metadata session CI
        $this->current_user = [
            'id'          => $this->session->userdata('id'),
            'username'    => $this->session->userdata('username'),
            'role'        => $this->session->userdata('role'),
            'hospital_id' => $this->session->userdata('hospital_id'),
            'logged_in'   => $this->session->userdata('logged_in')
        ];
    }

    /**
     * View Renderer with Layout Wrapper
     */
    protected function render_glass_view($view, $data = [])
    {
        $data['user'] = $this->current_user;
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view($view, $data);
        $this->load->view('layout/footer', $data);
    }
}
