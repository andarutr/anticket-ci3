<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends CI_Controller {
    public function __construct() {
		parent::__construct();
		cek_login($this);
	}
    
	public function getDataBacklog()
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
				t.developer_nik,
                s.name AS system_name 
            FROM tickets t
            LEFT JOIN systems s ON t.system_id = s.id 
            WHERE t.status = 'assigned' AND t.developer_nik = ?
            ORDER BY t.id DESC
        ";

        $data = $this->db->query($query, [$nik])->result();

        echo json_encode(['data' => $data]);
    }
	
	public function getDataList()
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
				t.execute_at,
                t.requestor_name,
                t.requestor_nik,
                t.requested_at,
				t.developer_nik,
                s.name AS system_name 
            FROM tickets t
            LEFT JOIN systems s ON t.system_id = s.id 
            WHERE t.status = 'listed' AND t.developer_nik = ?
            ORDER BY t.id DESC
        ";

        $data = $this->db->query($query, [$nik])->result();

        echo json_encode(['data' => $data]);
    }
	
	public function getDataInProgress()
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
				t.execute_at,
                t.requestor_name,
                t.requestor_nik,
                t.requested_at,
				t.developer_nik,
                s.name AS system_name 
            FROM tickets t
            LEFT JOIN systems s ON t.system_id = s.id 
            WHERE t.status = 'on progress' AND t.developer_nik = ?
            ORDER BY t.id DESC
        ";

        $data = $this->db->query($query, [$nik])->result();

        echo json_encode(['data' => $data]);
    }
	
	public function getDataDone()
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
				t.done_at,
                t.requestor_name,
                t.requestor_nik,
                t.requested_at,
				t.developer_nik,
                s.name AS system_name 
            FROM tickets t
            LEFT JOIN systems s ON t.system_id = s.id 
            WHERE t.status = 'done' AND t.developer_nik = ?
            ORDER BY t.id DESC
        ";

        $data = $this->db->query($query, [$nik])->result();

        echo json_encode(['data' => $data]);
    }
	
	public function getDataReject()
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
				t.reject_at,
                t.requestor_name,
                t.requestor_nik,
                t.requested_at,
				t.developer_nik,
                s.name AS system_name 
            FROM tickets t
            LEFT JOIN systems s ON t.system_id = s.id 
            WHERE t.status = 'reject' AND t.developer_nik = ?
            ORDER BY t.id DESC
        ";

        $data = $this->db->query($query, [$nik])->result();

        echo json_encode(['data' => $data]);
    }

	public function index()
	{
        $data['title'] = 'Worker Ticket';
        
		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/worker/ticket');
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

	public function updateSchedule()
	{
		$id = $this->input->post('id');
		$execution_date = $this->input->post('execution_date');

		if (!$id || !$execution_date) {
			echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
			return;
		}

		$id = $this->security->xss_clean($id);
		$execution_date = $this->security->xss_clean($execution_date);
		$status = 'listed';

		$query = "UPDATE tickets SET 
			execute_at = ?,
			status = ?
		WHERE id = ?";
		$result = $this->db->query($query, [$execution_date, $status, $id]);

		if ($result) {
            $query = "
                SELECT t.id, t.requestor_nik, t.developer_name, u.name, u.email, u.nik
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
            $developer_name = $ticket_data['developer_name'];

            $execution_timestamp = strtotime($execution_date);

            $email_data = [
                'name' => $name,
                'developer_name' => $developer_name,
                'execution_date' => $execution_timestamp,
            ];
            
            $message = $this->load->view('emails/scheduled_ticket_success', $email_data, TRUE);

            $this->email->from('andarutr@anticket.test', 'Andaru Anticket');
            $this->email->to($email); 
            $this->email->subject('Ticket Schedule Execution!');
            $this->email->message($message);

            $this->email->send();

			echo json_encode(['status' => 'success', 'message' => 'Schedule updated successfully.']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to update schedule.']);
		}
	}

	public function updateToInProgress()
	{
		$id = $this->input->post('id');

		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'Ticket ID harus ada']);
			return;
		}

		$id = $this->security->xss_clean($id);
		$new_status = 'on progress';
		$nik = $this->session->userdata('nik');
		$name = $this->session->userdata('name');
		$at = date('Y-m-d H:i:s');

		$query = "UPDATE tickets SET 
			status = ?, 
			in_progress_name = ?,
			in_progress_nik = ?,
			in_progress_at = ?
		WHERE id = ?";
		$result = $this->db->query($query, [$new_status, $name, $nik, $at, $id]);

		if ($result) {
            $query = "
                SELECT t.id, t.requestor_nik, t.developer_name, u.name, u.email, u.nik
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
            $developer_name = $ticket_data['developer_name'];

            $email_data = [
                'name' => $name,
                'developer_name' => $developer_name
            ];
            
            $message = $this->load->view('emails/inprogress_ticket_success', $email_data, TRUE);

            $this->email->from('andarutr@anticket.test', 'Andaru Anticket');
            $this->email->to($email); 
            $this->email->subject('Ticket In Progress!');
            $this->email->message($message);

            $this->email->send();

			echo json_encode(['status' => 'success', 'message' => 'Berhasil update status ticket']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Gagal update status ticket.']);
		}
	}
	
	public function updateToDone()
	{
		$id = $this->input->post('id');

		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'Ticket ID harus ada']);
			return;
		}

		$id = $this->security->xss_clean($id);
		$new_status = 'done';
		$nik = $this->session->userdata('nik');
		$name = $this->session->userdata('name');
		$at = date('Y-m-d H:i:s');

		$query = "UPDATE tickets SET 
			status = ?, 
			done_name = ?,
			done_nik = ?,
			done_at = ?
		WHERE id = ?";
		$result = $this->db->query($query, [$new_status, $name, $nik, $at, $id]);

		if ($result) {
            $query = "
                SELECT t.id, t.requestor_nik, t.developer_name, u.name, u.email, u.nik
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
            $developer_name = $ticket_data['developer_name'];

            $email_data = [
                'name' => $name,
                'developer_name' => $developer_name
            ];
            
            $message = $this->load->view('emails/done_ticket_success', $email_data, TRUE);

            $this->email->from('andarutr@anticket.test', 'Andaru Anticket');
            $this->email->to($email); 
            $this->email->subject('Ticket Done!');
            $this->email->message($message);

            $this->email->send();

			echo json_encode(['status' => 'success', 'message' => 'Berhasil menyelesaikan ticket']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Gagal menyelesaikan ticket.']);
		}
	}
	
	public function updateToReject()
	{
		$id = $this->input->post('id');
		$reason = $this->input->post('reason');

		if (!$id) {
			echo json_encode(['status' => 'error', 'message' => 'Ticket ID harus ada']);
			return;
		}

		$id = $this->security->xss_clean($id);
		$new_status = 'reject';
		$nik = $this->session->userdata('nik');
		$name = $this->session->userdata('name');
		$at = date('Y-m-d H:i:s');

		$query = "UPDATE tickets SET 
			status = ?, 
			reject_name = ?,
			reject_nik = ?,
			reject_at = ?,
			reject_reason = ?
		WHERE id = ?";
		$result = $this->db->query($query, [$new_status, $name, $nik, $at, $reason, $id]);

		if ($result) {
            $query = "
                SELECT t.id, t.requestor_nik, t.developer_name, u.name, u.email, u.nik
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
            $developer_name = $ticket_data['developer_name'];

            $email_data = [
                'name' => $name,
                'reason' => $reason
            ];
            
            $message = $this->load->view('emails/reject_from_worker_ticket_success', $email_data, TRUE);

            $this->email->from('andarutr@anticket.test', 'Andaru Anticket');
            $this->email->to($email); 
            $this->email->subject('Ticket ditolak!');
            $this->email->message($message);

            $this->email->send();

			echo json_encode(['status' => 'success', 'message' => 'Berhasil reject ticket']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Gagal reject ticket.']);
		}
	}
}
