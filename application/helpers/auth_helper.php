<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('cek_login')) {
    function cek_login($CI) {
        if (!$CI->session->userdata('user_id')) {
            redirect('auth/login');
            exit();
        }
    }
}