<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MappingTask extends CI_Controller {
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
            WHERE t.status IN ('approved')
            ORDER BY t.id DESC
        ";

        $data = $this->db->query($query)->result();

        echo json_encode(['data' => $data]);
    }
    
	public function index()
	{
        $data['title'] = 'Admin Mapping Task';
        
		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/admin/mapping-task');
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

    public function getWorkers()
    {
        $query_str = "
            SELECT id, name, nik
            FROM users
            WHERE role = 'worker'
        ";

        $query = $this->db->query($query_str);

        if ($query && $query->num_rows() > 0) {
            echo json_encode(['status' => 'success', 'data' => $query->result()]);
        } else {
            echo json_encode(['status' => 'success', 'data' => []]);
        }
    }

    public function assignTask()
    {
        if ($this->input->method() !== 'post') {
            show_404();
        }

        $ticketId = $this->input->post('ticket_id', TRUE);
        $userId = $this->input->post('user_id', TRUE);

        $ticketId = $this->db->escape($ticketId);
        $userId = $this->db->escape($userId);

        $user_query_str = "
            SELECT name, nik 
            FROM users
            WHERE id = $userId
            LIMIT 1
        ";

        $user_query = $this->db->query($user_query_str);

        if (!$user_query || $user_query->num_rows() <= 0) {
            echo json_encode(['status' => 'error', 'message' => 'Worker tidak ditemukan.']);
            return;
        }

        $userData = $user_query->row(); 

        $developerName = $this->db->escape($userData->name);
        $developerNik = $this->db->escape($userData->nik); 

        $update_query_str = "
            UPDATE tickets 
            SET developer_name = $developerName,
                developer_nik = $developerNik,
                status = 'assigned'
            WHERE id = $ticketId
        ";

        $update_result = $this->db->query($update_query_str);

        if ($update_result && $this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Berhasil assign task.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal assign task.']);
        }
    }
}
