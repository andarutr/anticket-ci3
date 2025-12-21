<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends CI_Controller {
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
			echo json_encode(['status' => 'success', 'message' => 'Schedule updated successfully.']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Failed to update schedule.']);
		}
	}
}
