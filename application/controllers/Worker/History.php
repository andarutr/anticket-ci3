<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class History extends CI_Controller {
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
				t.execute_at,
                t.requestor_name,
                t.requestor_nik,
                t.requested_at,
				t.developer_nik,
                s.name AS system_name 
            FROM tickets t
            LEFT JOIN systems s ON t.system_id = s.id 
            WHERE t.developer_nik = ?
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
        $data['title'] = 'Worker History';
        
		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/worker/history');
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
}
