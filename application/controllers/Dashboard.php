<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('admin_id') == null){
            redirect('/');
        }
    }
    public function index()
    {
        redirect('/');
    }
}
