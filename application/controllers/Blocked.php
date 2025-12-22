<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blocked extends CI_Controller {
	public function index()
	{
        $data['title'] = 'Blocked';
        
		$this->load->view('pages/auth/blocked');
	}
}
