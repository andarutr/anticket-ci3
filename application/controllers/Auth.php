<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
	public function register()
	{
		$data['title'] = 'Register'; 
        $data['content'] = 'pages/auth/register';

        $this->load->view('layouts/auth/header', $data);
        $this->load->view('layouts/auth/navbar');
        $this->load->view('pages/auth/register');
        $this->load->view('layouts/auth/footer');
	}
}
