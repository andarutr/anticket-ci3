<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct() {
        parent::__construct();
        cek_login($this);
    }
	
	public function index()
	{
        $data['title'] = 'Supervisor Dashboard';
        
		$user_nik = $this->session->userdata('nik');

        $data['ticket_waiting'] = $this->db->query("
            SELECT COUNT(*) as total
            FROM tickets
            WHERE status = 'waiting approval'
        ")->row()->total;

        $data['ticket_approved'] = $this->db->query("
            SELECT COUNT(*) as total
            FROM tickets
            WHERE status = 'approved'
        ")->row()->total;

        $data['ticket_rejected'] = $this->db->query("
            SELECT COUNT(*) as total
            FROM tickets
            WHERE status = 'reject'
        ")->row()->total;

        $data['ticket_total'] = $this->db->query("
            SELECT COUNT(*) as total
            FROM tickets
            WHERE MONTH(created_at) = MONTH(CURDATE())
            AND YEAR(created_at) = YEAR(CURDATE())
        ")->row()->total;

        $data['ticket_terbaru'] = $this->db->query("
            SELECT 
                t.id,
                t.no_ticket,
                t.system_id,
                t.status,
                t.developer_nik as worker,
                t.requestor_nik,
                t.priority,
                t.deadline,
                t.created_at,
                s.name as system_name,
                u.name as requestor_name
            FROM tickets t
            JOIN systems s ON s.id = t.system_id
            JOIN users u ON u.nik = t.requestor_nik
            WHERE t.status = 'waiting approval'
            ORDER BY t.created_at DESC
            LIMIT 5
        ")->result_array();

		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/supervisor/dashboard');
		$this->load->view('layouts/app/footer');
	}
}
