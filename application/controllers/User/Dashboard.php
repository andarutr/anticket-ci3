<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct() {
        parent::__construct();
        cek_login($this);
    }
	
	public function index()
	{
        $data['title'] = 'User Dashboard';
		$user_nik = $this->session->userdata('nik');

		$data['ticket_aktif'] = $this->db->query("
			SELECT COUNT(*) as total
			FROM tickets
			WHERE requestor_nik = ?
			AND status NOT IN ('closed', 'reject')
		", [$user_nik])->row()->total;
		
		$data['ticket_proses'] = $this->db->query("
			SELECT COUNT(*) as total
			FROM tickets
			WHERE requestor_nik = ?
			AND status IN ('on progress')
		", [$user_nik])->row()->total;
		
		$data['ticket_menunggu'] = $this->db->query("
			SELECT COUNT(*) as total
			FROM tickets
			WHERE requestor_nik = ?
			AND status IN ('waiting approval')
		", [$user_nik])->row()->total;
		
		$data['ticket_selesai'] = $this->db->query("
			SELECT COUNT(*) as total
			FROM tickets
			WHERE requestor_nik = ?
			AND status IN ('done', 'closed', 'reject')
		", [$user_nik])->row()->total;

		$data['ticket_terbaru'] = $this->db->query("
			SELECT 
				t.id, 
				t.no_ticket,
				t.system_id,
				t.status, 
				t.developer_nik as worker, 
				t.requestor_nik,
				t.created_at,
				s.id,
				s.name as system_name
			FROM tickets t
			JOIN systems s ON s.id = t.system_id
			WHERE t.requestor_nik = ?
			ORDER BY t.created_at DESC
			LIMIT 5
		", [$user_nik])->result_array();

		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/user/dashboard');
		$this->load->view('layouts/app/footer');
	}
}
