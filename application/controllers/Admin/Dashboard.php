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
        
		 $data['ticket_approved'] = $this->db->query("
            SELECT COUNT(*) as total
            FROM tickets
            WHERE status = 'approved'
            AND developer_nik IS NULL
        ")->row()->total;

        $data['ticket_assigned'] = $this->db->query("
            SELECT COUNT(*) as total
            FROM tickets
            WHERE developer_nik IS NOT NULL
            AND status != 'closed'
        ")->row()->total;

        $data['ticket_assigned_month'] = $this->db->query("
            SELECT COUNT(*) as total
            FROM tickets
            WHERE developer_nik IS NOT NULL
            AND MONTH(created_at) = MONTH(CURDATE())
            AND YEAR(created_at) = YEAR(CURDATE())
        ")->row()->total;

        $data['ticket_terbaru'] = $this->db->query("
            SELECT 
                t.id,
                t.no_ticket,
                t.system_id,
                t.status,
                t.priority,
                t.deadline,
                t.created_at,
                s.name as system_name,
                u.name as requestor_name
            FROM tickets t
            JOIN systems s ON s.id = t.system_id
            JOIN users u ON u.nik = t.requestor_nik
            WHERE t.status = 'approved'
            AND t.developer_nik IS NULL
            ORDER BY t.created_at DESC
            LIMIT 5
        ")->result_array();

        $data['programmers'] = $this->db->query("
            SELECT nik, name
            FROM users
            WHERE role = 'worker'
        ")->result_array();

		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/admin/dashboard');
		$this->load->view('layouts/app/footer');
	}
}
