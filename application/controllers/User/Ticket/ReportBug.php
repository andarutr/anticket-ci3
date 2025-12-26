<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportBug extends CI_Controller {
    public function __construct() 
    {
		parent::__construct();
		$this->load->helper(['url', 'form']);
		$this->load->library('upload');
        cek_login($this);

	}
    
	public function index()
	{
        $data['title'] = 'User Report Bug';
        $data['systems'] = $this->db->query("SELECT id, name FROM systems")->result();

		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/user/ticket/report-bug', $data);
		$this->load->view('layouts/app/footer');
	}

    public function store()
    {
        $config['upload_path'] = FCPATH . 'uploads/';
        $config['allowed_types'] = 'png|jpg|jpeg'; 
        $config['max_size'] = 2048;
        $config['encrypt_name'] = TRUE;

        $this->upload->initialize($config);

        $uploaded_files = [];
        $files = $_FILES['files']['name'] ?? []; 

        if (!empty($files)) { 
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
                    $uploaded_data = $this->upload->data();
                    $uploaded_files[] = $uploaded_data['file_name']; // Ambil nama file yang dienkripsi
                }
            }
        } 

        $system_id = $this->input->post('system_id');
        $prioritas = $this->input->post('prioritas');
        $urls = $this->input->post('urls');
        $deskripsi = $this->input->post('deskripsi');

        $user_id = $this->session->userdata('user_id');

        $user_query = $this->db->query("SELECT name, nik FROM users WHERE id = ?", [$user_id])->row_array();
        if (!$user_query) {
            echo json_encode(['status' => 'error', 'message' => 'Data pengguna tidak ditemukan']);
            return;
        }

        $requestor_name = $user_query['name'];
        $requestor_nik = $user_query['nik'];

        $date_part = date('ymd');
        $last_ticket = $this->db->query("SELECT MAX(id) as last_id FROM tickets")->row()->last_id;
        $counter = str_pad(($last_ticket ? $last_ticket : 0) + 1, 3, '0', STR_PAD_LEFT);
        $no_ticket = "RB{$date_part}{$counter}";

        $query_tickets = "INSERT INTO tickets (system_id, no_ticket, category, priority, status, description, requestor_name, requestor_nik, requested_at, urls) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";
        $result_ticket = $this->db->query($query_tickets, [
            $system_id,
            $no_ticket,
            'bug', 
            $prioritas,
            'waiting approval',
            $deskripsi,
            $requestor_name,
            $requestor_nik,
            $urls
        ]);

        if ($result_ticket) {
            $this->email->from('andarutr@anticket.test', 'Andaru Anticket');
            $this->email->to($email); 
            $this->email->subject('Berhasil Report Bug!');
            $this->email->message("
                <p>Bila ticket anda sudah di approval, anda akan mendapatkan info melalui email. Terimakasih.</p>
                <p>Salam,<br><em>Anticket</em></p>
            ");

            $this->email->send();

            $ticket_id = $this->db->insert_id();

            if (!empty($uploaded_files)) {
                foreach ($uploaded_files as $file) {
                    $query_document = "INSERT INTO documents (ticket_id, name_file) VALUES (?, ?)";
                    $this->db->query($query_document, [$ticket_id, $file]);
                }
            }

            echo json_encode(['status' => 'success', 'message' => 'Laporan bug berhasil dikirim']);
        } else {
            foreach ($uploaded_files as $file) {
                $path = FCPATH . 'uploads/' . $file;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data ticket']);
        }
    }
}
