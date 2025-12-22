<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	public function index()
	{
        $data['title'] = 'Profile';
        
		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/auth/profile');
		$this->load->view('layouts/app/footer');
	}

    public function update()
    {
        $userId = $this->input->post('user_id');
        $name = $this->input->post('name');
        $nik = $this->input->post('nik'); 
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $update_data = [
            'name' => $name,
            'email' => $email,
            'nik' => $nik
        ];

        if (!empty($password)) {
            $update_data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $set_clause_parts = [];
        $params = [];

        foreach ($update_data as $key => $value) {
            $set_clause_parts[] = "$key = ?";
            $params[] = $value;
        }

        $set_clause = implode(', ', $set_clause_parts);
        $sql = "UPDATE users SET $set_clause WHERE id = ?"; 
        $params[] = $userId;

        $query = $this->db->query($sql, $params);

        if ($this->db->affected_rows() > 0) {
            $session_data = [
                'name' => $name,
                'email' => $email
            ];
            $this->session->set_userdata($session_data);

            echo json_encode(['status' => 'success', 'message' => 'Profil berhasil diperbarui.']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Tidak ada perubahan atau gagal memperbarui profil.']);
        }
    }
}
