<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct() {
		parent::__construct();
		cek_login($this);
	}

	public function index()
	{
        $data['title'] = 'Worker Dashboard';
		$user_nik = $this->session->userdata('nik');

		$data['ticket_aktif'] = $this->db->query("
            SELECT COUNT(*) as total
            FROM tickets
            WHERE developer_nik = ?
            AND status IN ('assigned', 'listed', 'on progress')
        ", [$user_nik])->row()->total;

        $data['ticket_on_progress'] = $this->db->query("
            SELECT COUNT(*) as total
            FROM tickets
            WHERE developer_nik = ?
            AND status = 'on progress'
        ", [$user_nik])->row()->total;

        $data['ticket_done'] = $this->db->query("
            SELECT COUNT(*) as total
            FROM tickets
            WHERE developer_nik = ?
            AND status = 'done'
        ", [$user_nik])->row()->total;

        $data['ticket_closed'] = $this->db->query("
            SELECT COUNT(*) as total
            FROM tickets
            WHERE developer_nik = ?
            AND status = 'closed'
        ", [$user_nik])->row()->total;

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
            WHERE t.developer_nik = ?
            ORDER BY t.created_at DESC
            LIMIT 5
        ", [$user_nik])->result_array();

		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/worker/dashboard');
		$this->load->view('layouts/app/footer');
	}
}
