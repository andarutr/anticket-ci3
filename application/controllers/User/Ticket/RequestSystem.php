<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RequestSystem extends CI_Controller {
	public function __construct() 
    {
		parent::__construct();
		$this->load->helper(['url', 'form']);
		$this->load->library('upload');
	}

    public function index()
	{
        $data['title'] = 'User Request System';
        
		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/user/ticket/request-system');
		$this->load->view('layouts/app/footer');
	}

    public function store() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;

        $this->upload->initialize($config);

        $uploaded_files = [];

        $files = $_FILES['files']['name'];
        if (!empty($files[0])) {
            $total_files = count($files);

            for ($i = 0; $i < $total_files; $i++) {
                $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                if (!$this->upload->do_upload('file')) {
                    echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors('', '')]);
                    return;
                } else {
                    $uploaded_files[] = $this->upload->data('file_name');
                }
            }
        }

        $judul = $this->input->post('judul');
        $prioritas = $this->input->post('prioritas');
        $dept = $this->input->post('dept');
        $pic_name = $this->input->post('pic_name');
        $deskripsi = $this->input->post('deskripsi');
        $files_json = json_encode($uploaded_files);

        $user_id = $this->session->userdata('user_id'); 

        $query_user = "SELECT nik AS pic_nik FROM users WHERE name = ?";
        $user_data = $this->db->query($query_user, [$pic_name])->row_array();

        if (!$user_data) {
            echo json_encode(['status' => 'error', 'message' => 'PIC tidak ditemukan di database']);
            return;
        }

        $pic_nik = $user_data['pic_nik'];
        
        $query_systems = "INSERT INTO systems (user_id, name, status, dept, pic_name, pic_nik) VALUES (?, ?, ?, ?, ?, ?)";

        $result = $this->db->query($query_systems, [
            $user_id,
            $judul,
            'listing',
            $dept,
            $pic_name,
            $pic_nik
        ]);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Request berhasil dikirim']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
        }
    }
}
