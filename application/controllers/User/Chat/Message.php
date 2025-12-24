<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends CI_Controller {
	public function __construct() {
        parent::__construct();
        cek_login($this);
    }
	
	public function index()
	{
        $data['title'] = 'Chat Worker';
        
		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/user/chat/message');
		$this->load->view('layouts/app/footer');
	}
}
