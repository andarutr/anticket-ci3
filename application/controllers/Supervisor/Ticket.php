<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends CI_Controller {
    public function __construct() {
        parent::__construct();
        cek_login($this);
    }

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
            WHERE t.status NOT IN ('reject','approved')
            ORDER BY t.id DESC
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

    public function approve($id)
    {
        $id = $this->security->xss_clean($id);
        if (!is_numeric($id)) {
            show_404();
        }

        $escaped_id = $this->db->escape($id);

        $check_query = "SELECT deadline FROM tickets WHERE id = $escaped_id LIMIT 1";
        $check_result = $this->db->query($check_query);

        if (!$check_result || $check_result->num_rows() == 0) {
            echo json_encode(['status' => 'error', 'message' => 'Ticket tidak ditemukan.']);
            return;
        }

        $ticket = $check_result->row();

        if ($ticket->deadline === '0000-00-00' || $ticket->deadline === null) {
             echo json_encode(['status' => 'error', 'message' => 'Tidak bisa approve ticket. Atur deadline terlebih dahulu.']);
             return;
        }

        $update_query = "UPDATE tickets SET status = 'approved' WHERE id = $escaped_id";

        $update_result = $this->db->query($update_query);

        if ($update_result && $this->db->affected_rows() > 0) {
            $query = "
                SELECT t.id, t.requestor_nik, u.name, u.email, u.nik
                FROM tickets t
                JOIN users u ON t.requestor_nik = u.nik
                WHERE t.id = ?
            ";

            $ticket_data = $this->db->query($query, [$id])->row_array();

            if (!$ticket_data) {
                echo json_encode(['status' => 'error', 'message' => 'Ticket tidak ditemukan.']);
                return;
            }
            
            $requestor_nik = $ticket_data['requestor_nik'];
            $email = $ticket_data['email'];
            $name = $ticket_data['name'];

            $email_data = [
                'name' => $name,
            ];
            
            $message = $this->load->view('emails/approve_ticket_success', $email_data, TRUE);

            $this->email->from('andarutr@anticket.test', 'Andaru Anticket');
            $this->email->to($email); 
            $this->email->subject('Ticket diapprove!');
            $this->email->message($message);

            $this->email->send();

            echo json_encode(['status' => 'success', 'message' => 'Berhasil approve ticket.']);
        } else {
             echo json_encode(['status' => 'error', 'message' => 'Error.']);
        }
    }

    public function reject($id)
    {
        $id = $this->security->xss_clean($id);
        if (!is_numeric($id)) {
            show_404();
        }

        $query = "
            SELECT t.id, t.requestor_nik, u.name, u.email, u.nik
            FROM tickets t
            JOIN users u ON t.requestor_nik = u.nik
            WHERE t.id = ?
        ";

        $ticket_data = $this->db->query($query, [$id])->row_array();

        if (!$ticket_data) {
            echo json_encode(['status' => 'error', 'message' => 'Ticket tidak ditemukan.']);
            return;
        }

        $update_query = "UPDATE tickets SET status = 'reject' WHERE id = ?";
        $result = $this->db->query($update_query, [$id]);

        if ($result) {
            $requestor_nik = $ticket_data['requestor_nik'];
            $email = $ticket_data['email'];
            $name = $ticket_data['name'];

            $email_data = [
                'name' => $name,
            ];
            
            $message = $this->load->view('emails/reject_ticket_success', $email_data, TRUE);

            $this->email->from('andarutr@anticket.test', 'Andaru Anticket');
            $this->email->to($email); 
            $this->email->subject('Ticket ditolak!');
            $this->email->message($message);

            $this->email->send();

            echo json_encode(['status' => 'success', 'message' => 'Berhasil reject ticket.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal reject ticket.']);
        }
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

    public function update()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $id = isset($data['id']) ? $this->security->xss_clean($data['id']) : null;
        $priority = isset($data['priority']) ? $this->security->xss_clean($data['priority']) : null;
        $deadline = isset($data['deadline']) ? $this->security->xss_clean($data['deadline']) : null;

        if (!is_numeric($id) || empty($priority) || empty($deadline)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid input data.']);
            return;
        }

        $date_check = DateTime::createFromFormat('Y-m-d', $deadline);
        if (!$date_check || $date_check->format('Y-m-d') !== $deadline) {
             echo json_encode(['status' => 'error', 'message' => 'Invalid date format.']);
             return;
        }

        $escaped_id = $this->db->escape($id);
        $escaped_priority = $this->db->escape($priority);
        $escaped_deadline = $this->db->escape($deadline);

        $query = "UPDATE tickets SET priority = $escaped_priority, deadline = $escaped_deadline WHERE id = $escaped_id";
        $result = $this->db->query($query);

        if ($result && $this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Ticket updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update ticket. It might not exist or no changes were made.']);
        }
    }
}
