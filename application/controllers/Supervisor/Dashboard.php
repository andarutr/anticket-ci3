<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	public function __construct() {
        parent::__construct();
        cek_login($this);
    }
	
	public function index()
	{
        $data['title'] = 'Supervisor Dashboard';
        
		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/supervisor/dashboard');
		$this->load->view('layouts/app/footer');
	}
}
