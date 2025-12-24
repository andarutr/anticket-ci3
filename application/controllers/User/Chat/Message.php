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
        
        $query = "SELECT 
            c.id,
            c.ticket_id,
            c.user_id,
            c.message,
            c.created_at,
            t.id,
            t.developer_name,
            u.id,
            u.name AS name_sender
        FROM chats c
        JOIN tickets t ON c.ticket_id = t.id
        JOIN users u ON c.user_id = u.id
        WHERE c.ticket_id = ?";

        $data = $this->db->query($query,[$id_ticket])->result_array();

        header('Content-Type: application/json');
        echo json_encode($data);
    }

	public function index()
	{
        $data['title'] = 'Chat Worker';
        $nik = $this->session->userdata('nik');
        $data['nameuser'] = $this->session->userdata('name');

        $query = "SELECT 
            t.id as id_ticket,
            t.no_ticket,
            t.developer_name,
            t.updated_at,
            s.id as id_system,
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

    public function send()
    {
        $id_ticket = $this->input->post('id');
        $user_id = $this->session->userdata('user_id');
        $message = $this->input->post('message');

        // Pastikan user_id tidak kosong
        if (!$user_id) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Anda belum login.'
            ]);
            return;
        }

        $query = "INSERT INTO chats (ticket_id, user_id, message) VALUES (?, ?, ?)";

        $result = $this->db->query($query, [$id_ticket, $user_id, $message]);

        if ($result) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Berhasil mengirim pesan!'
            ]);
        } else {
            // Tambahkan error reporting untuk debugging
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal mengirim pesan.',
                'db_error' => $this->db->error() // Menampilkan error dari database
            ]);
        }
    }
}
