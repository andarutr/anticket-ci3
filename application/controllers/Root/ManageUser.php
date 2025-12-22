<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ManageUser extends CI_Controller {
	public function index()
	{
        $data['title'] = 'Manage User';
        
		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/root/manage-user');
		$this->load->view('layouts/app/footer');
	}

    public function getData()
    {
        $query = "
            SELECT 
                id,
                nik,
                name,
                email,
                role
            FROM users
            ORDER BY id DESC
        ";

        $data = $this->db->query($query)->result();

        echo json_encode(['data' => $data]);
    }

    public function resetAccount($id = null)
    {
        if (!$id || !is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'ID user tidak valid.']);
            return;
        }

        $new_password = 'anticket123';
        $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);

        $sql = "UPDATE users SET password = ? WHERE id = ?";
        $query = $this->db->query($sql, [$hashed_new_password, $id]);

        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Password berhasil direset.']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Gagal mereset password atau tidak ada perubahan.']);
        }
    }

    public function blockAccount($id = null)
    {
        if (!$id || !is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'ID user tidak valid.']);
            return;
        }

        $sql = "UPDATE users SET role = 'blocked' WHERE id = ?";
        $query = $this->db->query($sql, [$id]);

        if ($this->db->affected_rows() > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Akun berhasil diblokir.']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Gagal memblokir akun atau tidak ada perubahan.']);
        }
    }
}
