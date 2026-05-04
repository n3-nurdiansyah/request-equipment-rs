<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{

    public function check_user($username)
    {
        // Ambil satu baris user berdasarkan username
        $this->db->where('username', $username);
        return $this->db->get('users')->row_array();
    }
}
