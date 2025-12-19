<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends CI_Controller {
    public function getData()
    {
        $query = "
            SELECT 
                t.id, 
                t.system_id, 
                t.no_ticket, 
                t.category, 
                t.urls, 
                t.priority, 
                t.status, 
                t.description, 
                t.deadline,
                t.requestor_name,
                t.requestor_nik,
                t.requested_at,
                s.name AS system_name 
            FROM tickets t
            LEFT JOIN systems s ON t.system_id = s.id 
        ";

        $data = $this->db->query($query)->result();

        echo json_encode(['data' => $data]);
    }

	public function index()
	{
        $data['title'] = 'List Ticket';
        
		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/supervisor/ticket');
		$this->load->view('layouts/app/footer');
	}
}
