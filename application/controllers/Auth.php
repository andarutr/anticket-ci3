<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['captcha']);
    }

	public function v_register()
	{
		$data['title'] = 'Register'; 

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
                    $email_data = [
                        'name' => $name,
                        'email' => $email,
                    ];

                    $message = $this->load->view('emails/register_ticket_success', $email_data, TRUE);

                    $this->email->from('andarutr@anticket.test', 'Andaru Anticket');
                    $this->email->to($email); 
                    $this->email->subject('Selamat Datang di Anticket!');
                    $this->email->message($message);

                    $this->email->send();

                    echo json_encode(['status' => 'success', 'message' => 'Registrasi berhasil']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Gagal mendaftar']);
                }
            }
        } else {
            show_404();
        }
    }

    // Login
    public function v_login()
	{
		$data['title'] = 'Login'; 
        $data['captcha'] = $this->generate_captcha();

        $this->load->view('layouts/auth/header', $data);
        $this->load->view('layouts/auth/navbar');
        $this->load->view('pages/auth/login');
        $this->load->view('layouts/auth/footer');
	}

    private function generate_captcha()
    {
        $vals = array(
            'img_path'      => './captcha/',
            'img_url'       => base_url('captcha/'),
            'img_width'     => 150,
            'img_height'    => 50,
            'expiration'    => 7200,
            'word_length'   => 6,
            'font_size'     => 16,
            'img_id'        => 'captcha_img',
            'pool'          => 'andaruganteng831',
        );

        $cap = create_captcha($vals);
        $this->session->set_userdata('captcha', $cap['word']);
        return $cap;
    }

    public function refresh_captcha()
    {
        $cap = $this->generate_captcha();
        echo $cap['image'];
    }

    public function b_login()
    {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('nik', 'NIK', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('captcha', 'Captcha', 'required|callback_validate_captcha');

            if ($this->form_validation->run() === FALSE) {
                $errors = $this->form_validation->error_array();
                if ($this->form_validation->error('captcha')) {
                    $errors['captcha'] = $this->form_validation->error('captcha', false);
                }
                echo json_encode(['status' => 'error', 'message' => 'Validasi gagal.', 'errors' => $errors]);
            } else {
                $nik = $this->input->post('nik');
                $password = $this->input->post('password');

                $query = "SELECT id, name, email, nik, role, password FROM users WHERE nik = ?";
                $result = $this->db->query($query, [$nik])->row();

                if ($result && password_verify($password, $result->password)) {
                    $this->session->unset_userdata('captcha');

                    $session_data = [
                        'user_id' => $result->id,
                        'name' => $result->name,
                        'email' => $result->email,
                        'nik' => $result->nik,
                        'role' => $result->role
                    ];

                    $this->session->set_userdata($session_data);

                    echo json_encode(['status' => 'success', 'message' => 'Login berhasil', 'role' => $result->role]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'NIK atau password salah']);
                }
            }
        } else {
            show_404();
        }
    }

    public function validate_captcha($str)
    {
        $word = $this->session->userdata('captcha');
        if (strtolower($str) == strtolower($word)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('validate_captcha', 'Kode captcha salah.');
            return FALSE;
        }
    }

    public function b_logout()
    {
        $this->session->sess_destroy();

        redirect('auth/login', 'refresh');
    }
}
