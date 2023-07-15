<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        redirect('/');
    }
    public function login()
    {
        if($this->session->userdata('admin_id')!=null){
            redirect('/pages/dashboard');
        }
        $this->load->view('login');
    }

    //check login เข้าสู่ระบบ
    function check_login()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            show_404();
            exit();
        }
        $admin_username = $this->input->post('username');
        $admin_password = $this->input->post('password');
        if ($admin_username == null && $admin_password == null) {
            echo json_encode(array(
                'status' => 'ERROR',
                'message' => 'กรุณากรอกชื่อผู้ใช้งาน และ รหัสผ่าน'
            ));
            exit();
        }
        $where_array = [
            'admin_username' => $admin_username,
            'admin_password' => sha1($admin_password)
        ];
        $res = $this->Function_model->getDataRow('tbl_admin', $where_array);
        if ($res != null) {
            //ตรวจสอบสถานะ
            if ($res->admin_status == 'active') {
                $sess_array = [
                    'admin_name' => $res->admin_name,
                    'admin_id' => $res->admin_id,
                    'admin_position' => $res->admin_position
                ];
                $this->session->set_userdata($sess_array);
                echo json_encode([
                    'status' => 'SUCCESS',
                    'message' => 'เข้าสู่ระบบสำเร็จ'
                ]);
                exit();
            } else {
                echo json_encode([
                    'status' => 'ERROR',
                    'message' => 'ผู้ใช้งานนี้ไม่มีสิทธิเข้าใช้งานระบบ'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'ชื่อผู้ใช้งาน หรือ รหัสผ่านไม่ถูกต้อง'
            ]);
            exit();
        }
    }

    
}
