<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Base Model for Enterprise CI3 Application
 * Handles basic CRUD to avoid repetition.
 */
class MY_Model extends CI_Model
{
    protected $table = '';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all($conditions = [])
    {
        if (!empty($conditions)) {
            $this->db->where($conditions);
        }
        return $this->db->get($this->table)->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, [$this->primary_key => $id])->row_array();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where($this->primary_key, $id);
        return $this->db->update($this->table, $data);
    }
}
