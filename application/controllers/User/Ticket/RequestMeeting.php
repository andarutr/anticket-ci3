<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RequestMeeting extends CI_Controller {
    public function __construct() 
    {
		parent::__construct();
		$this->load->helper(['url', 'form']);
		$this->load->library('upload');
        cek_login($this);
	}
    
	public function index()
	{
        $data['title'] = 'User Request Meeting';
        $data['systems'] = $this->db->query("SELECT id, name FROM systems")->result();

		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/user/ticket/request-meeting', $data);
		$this->load->view('layouts/app/footer');
	}

    public function store()
    {
        $system_id = $this->input->post('system_id');
        $prioritas = $this->input->post('prioritas');
        $deskripsi = $this->input->post('deskripsi');
        $tanggal = $this->input->post('tanggal');

        $user_id = $this->session->userdata('user_id');

        $user_query = $this->db->query("SELECT name, nik FROM users WHERE id = ?", [$user_id])->row_array();
        if (!$user_query) {
            echo json_encode(['status' => 'error', 'message' => 'Data pengguna tidak ditemukan']);
            return;
        }

        $requestor_name = $user_query['name'];
        $requestor_nik = $user_query['nik'];

        $date_part = date('ymd');
        $last_ticket = $this->db->query("SELECT MAX(id) as last_id FROM tickets")->row()->last_id;
        $counter = str_pad(($last_ticket ? $last_ticket : 0) + 1, 3, '0', STR_PAD_LEFT);
        $no_ticket = "RM{$date_part}{$counter}";

        $query_tickets = "INSERT INTO tickets (system_id, no_ticket, category, priority, status, description, requestor_name, requestor_nik, requested_at, date_meeting) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
        $result_ticket = $this->db->query($query_tickets, [
            $system_id,
            $no_ticket,
            'meeting', 
            $prioritas,
            'waiting approval',
            $deskripsi,
            $requestor_name,
            $requestor_nik,
            $tanggal
        ]);

        if ($result_ticket) {
            echo json_encode(['status' => 'success', 'message' => 'Laporan bug berhasil dikirim']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data ticket']);
        }
    }
}
