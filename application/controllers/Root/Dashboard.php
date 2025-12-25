<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct() {
        parent::__construct();
        cek_login($this);
    }
	
	public function index()
	{
        $data['title'] = 'Admin Dashboard';
        $user_nik = $this->session->userdata('nik');

        $data['total_users'] = $this->db->query("SELECT COUNT(*) as total FROM users")->row()->total;
        $data['active_users'] = $this->db->query("SELECT COUNT(*) as total FROM users WHERE role NOT IN ('blocked')")->row()->total;
        $data['blocked_users'] = $this->db->query("SELECT COUNT(*) as total FROM users WHERE role IN ('blocked')")->row()->total;

        $data['users'] = $this->db->query("
            SELECT 
                nik,
                name,
                email,
                role,
                created_at
            FROM users
            ORDER BY created_at DESC
			LIMIT 5
        ")->result_array();

		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/root/dashboard');
		$this->load->view('layouts/app/footer');
	}
}
