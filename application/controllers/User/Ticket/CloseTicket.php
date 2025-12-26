<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CloseTicket extends CI_Controller {
    public function __construct() {
        parent::__construct();
        cek_login($this);
    }
    
    public function getData()
    {
        $nik = $this->session->userdata('nik');

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
            WHERE t.status = 'done' AND t.requestor_nik = ?
            ORDER BY t.id DESC
        ";

        $data = $this->db->query($query, [$nik])->result();

        echo json_encode(['data' => $data]);
    }

    public function index()
	{
        $data['title'] = 'User Request System';
        $data['users'] = $this->db->query("SELECT name, nik FROM users")->result();

		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/user/ticket/close-ticket');
		$this->load->view('layouts/app/footer');
	}

    public function getById($id)
    {
        $id = $this->security->xss_clean($id);
        if (!is_numeric($id)) {
            show_404();
        }

        $escaped_id = $this->db->escape($id);
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
            WHERE t.id = $escaped_id
            LIMIT 1
        ";

        $result = $this->db->query($query);

        if ($result && $result->num_rows() > 0) {
            echo json_encode(['status' => 'success', 'data' => $result->row()]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Ticket not found.']);
        }
    }

    public function close($id)
    {
        $name = $this->session->userdata('name');
        $nik = $this->session->userdata('nik');
        $email = $this->session->userdata('email');
        $at = date("Y-m-d H:i:s");
        $status = 'closed';
        
        $query = "
        UPDATE tickets
        SET 
            closed_name = ?,
			closed_nik = ?,
			closed_at = ?,
            status = ? 
        WHERE id = ?
        ";

        $result = $this->db->query($query, [$name, $nik, $at, $status, $id]);

        if ($result) {
            $email_data = [
                'name' => $name,
            ];
            
            $message = $this->load->view('emails/close_ticket_success', $email_data, TRUE);

            $this->email->from('andarutr@anticket.test', 'Andaru Anticket');
            $this->email->to($email); 
            $this->email->subject('Berhasil Close Ticket!');
            $this->email->message($message);

            $this->email->send();

			echo json_encode(['status' => 'success', 'message' => 'Berhasil close ticket']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Gagal close ticket.']);
		}
    }
}
