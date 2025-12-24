<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {
	public function __construct() {
        parent::__construct();
        cek_login($this);
    }
	
    public function getChatDetail()
    {
        $id_ticket = $this->input->get('id');
        
        $query = "
        SELECT * FROM chats 
        WHERE ticket_id = ?
        ";
        $data = $this->db->query($query,[$id_ticket])->result();

        echo json_encode($data);
    }

	public function index()
	{
        $data['title'] = 'Chat Worker';
        $nik = $this->session->userdata('nik');

        $query = "SELECT 
            t.no_ticket,
            t.developer_name,
            t.updated_at,
            s.id as id_ticket,
            s.name as system_name
        FROM tickets t
        JOIN systems s ON t.system_id = s.id
        WHERE t.requestor_nik = ? AND t.developer_name IS NOT NULL";

        $data['tickets'] = $this->db->query($query, [$nik])->result();

		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/user/chat/message');
		$this->load->view('layouts/app/footer');
	}
}
