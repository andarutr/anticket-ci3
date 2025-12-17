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
        $data['users'] = $this->db->query("SELECT name, nik FROM users")->result();

		$this->load->view('layouts/app/header', $data);
		$this->load->view('layouts/app/sidebar');
		$this->load->view('layouts/app/navbar');
		$this->load->view('pages/user/ticket/request-system');
		$this->load->view('layouts/app/footer');
	}

    // public function store() {
    //     $config['upload_path'] = './uploads/';
    //     $config['allowed_types'] = 'pdf';
    //     $config['max_size'] = 2048; // 2MB
    //     $config['encrypt_name'] = TRUE;

    //     $this->upload->initialize($config);

    //     $uploaded_files = [];

    //     $files = $_FILES['files']['name'];
    //     if (!empty($files[0])) {
    //         $total_files = count($files);

    //         for ($i = 0; $i < $total_files; $i++) {
    //             $_FILES['file']['name'] = $_FILES['files']['name'][$i];
    //             $_FILES['file']['type'] = $_FILES['files']['type'][$i];
    //             $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
    //             $_FILES['file']['error'] = $_FILES['files']['error'][$i];
    //             $_FILES['file']['size'] = $_FILES['files']['size'][$i];

    //             if (!$this->upload->do_upload('file')) {
    //                 echo json_encode(['status' => 'error', 'message' => $this->upload->display_errors('', '')]);
    //                 return;
    //             } else {
    //                 $uploaded_files[] = $this->upload->data('file_name');
    //             }
    //         }
    //     }

    //     $judul = $this->input->post('judul');
    //     $prioritas = $this->input->post('prioritas');
    //     $dept = $this->input->post('dept');
    //     $pic_name = $this->input->post('pic_name');
    //     $deskripsi = $this->input->post('deskripsi');
    //     $files_json = json_encode($uploaded_files);

    //     $user_id = $this->session->userdata('user_id'); 

    //     $query_user = "SELECT nik AS pic_nik FROM users WHERE name = ?";
    //     $user_data = $this->db->query($query_user, [$pic_name])->row_array();

    //     if (!$user_data) {
    //         echo json_encode(['status' => 'error', 'message' => 'PIC tidak ditemukan di database']);
    //         return;
    //     }

    //     $pic_nik = $user_data['pic_nik'];
        
    //     $query_systems = "INSERT INTO systems (user_id, name, status, dept, pic_name, pic_nik) VALUES (?, ?, ?, ?, ?, ?)";

    //     $result = $this->db->query($query_systems, [
    //         $user_id,
    //         $judul,
    //         'listing',
    //         $dept,
    //         $pic_name,
    //         $pic_nik
    //     ]);

    //     if ($result) {
    //         echo json_encode(['status' => 'success', 'message' => 'Request berhasil dikirim']);
    //     } else {
    //         echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
    //     }

    //     // buatkan ticket 
    //     // 1. system_id = ambil id nya$result
    //     // 2. no_ticket buat format menjadi ANTRS251217001
    //     // 3. category = system
    //     // 4. priority
    //     // 5. status = waiting approval
    //     // 6.description
    //     // 7. requestor_name = session name
    //     // 8. requestor_nik = session nik
    //     // 9. requested_at = now()
    //     $query_tickets = ;

    //     // buatkan document
    //     // 1. ticket_id = ambil id ticket
    //     // 2. name_file
    //     $query_document = ;
    // }

    public function store() 
    {
        $config['upload_path'] = FCPATH . 'uploads/';  // Gunakan FCPATH agar lebih aman
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

        // Ambil data user untuk requestor_name dan requestor_nik
        $user_query = $this->db->query("SELECT name, nik FROM users WHERE id = ?", [$user_id])->row_array();
        if (!$user_query) {
            echo json_encode(['status' => 'error', 'message' => 'Data pengguna tidak ditemukan']);
            return;
        }

        $requestor_name = $user_query['name'];
        $requestor_nik = $user_query['nik'];

        $query_user = "SELECT nik AS pic_nik FROM users WHERE name = ?";
        $user_data = $this->db->query($query_user, [$pic_name])->row_array();

        if (!$user_data) {
            echo json_encode(['status' => 'error', 'message' => 'PIC tidak ditemukan di database']);
            return;
        }

        $pic_nik = $user_data['pic_nik'];

        // Insert ke tabel systems
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
            $system_id = $this->db->insert_id(); // Ambil ID dari sistem yang baru disimpan

            // Buat nomor tiket
            $date_part = date('ymd'); // Format YYMMDD
            $last_ticket = $this->db->query("SELECT MAX(id) as last_id FROM tickets")->row()->last_id;
            $counter = str_pad(($last_ticket ? $last_ticket : 0) + 1, 3, '0', STR_PAD_LEFT);
            $no_ticket = "ANTRS{$date_part}{$counter}";

            // Insert ke tabel tickets
            $query_tickets = "INSERT INTO tickets (system_id, no_ticket, category, priority, status, description, requestor_name, requestor_nik, requested_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
            $result_ticket = $this->db->query($query_tickets, [
                $system_id,
                $no_ticket,
                'system',
                $prioritas,
                'waiting approval',
                $deskripsi,
                $requestor_name,
                $requestor_nik
            ]);

            if ($result_ticket) {
                $ticket_id = $this->db->insert_id(); // Ambil ID dari ticket yang baru disimpan

                // Insert file ke tabel documents
                if (!empty($uploaded_files)) {
                    foreach ($uploaded_files as $file) {
                        $query_document = "INSERT INTO documents (ticket_id, name_file) VALUES (?, ?)";
                        $this->db->query($query_document, [$ticket_id, $file]);
                    }
                }

                echo json_encode(['status' => 'success', 'message' => 'Request berhasil dikirim']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data ticket']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data sistem']);
        }
    }
}
