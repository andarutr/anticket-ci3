<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function v_register()
	{
		$data['title'] = 'Register'; 
        $data['content'] = 'pages/auth/register';

        $this->load->view('layouts/auth/header', $data);
        $this->load->view('layouts/auth/navbar');
        $this->load->view('pages/auth/register');
        $this->load->view('layouts/auth/footer');
	}

    public function b_register()
    {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name', 'Nama', 'required|min_length[3]|max_length[50]');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('nik', 'NIK', 'required|numeric|is_unique[users.nik]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

            if ($this->form_validation->run() === FALSE) {
                $errors = $this->form_validation->error_array();
                echo json_encode(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $errors]);
            } else {
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $nik = $this->input->post('nik');
                $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

                $query = "INSERT INTO users (name, email, nik, password) VALUES (?, ?, ?, ?)";
                $result = $this->db->query($query, [$name, $email, $nik, $password]);

                if ($result) {
                    echo json_encode(['status' => 'success', 'message' => 'Registrasi berhasil']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal mendaftar']);
                }
            }
        } else {
            show_404();
        }
    }
}
