<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
    //ตารางผู้ใช้งานระบบ
    function tbl_user(){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            show_404();
            exit();
        }
        $data['admin'] = $this->Function_model->fetchDataResult('tbl_admin',null,'admin_id','DESC');
        $this->load->view('components/tbl_user', $data);
    }

    //เพิ่มข้อมูลพนักงานใน tbl_admin
    function add_user(){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            show_404();exit();
        }
        $admin_name = $this->input->post('admin_name');
        $admin_username = $this->input->post('admin_username');
        $admin_password = $this->input->post('admin_password');
        $admin_position = $this->input->post('admin_position');
        //check username
        $res_username = $this->Function_model->getDataRow('tbl_admin', ['admin_username'=>$admin_username]);
        if($res_username != null){
            echo json_encode([
                'status' => 'WARNING',
                'message' => 'ชื่อผู้ใช้งานนี้มีในระบบแล้ว กรุณาเปลี่ยนใหม่'
            ]);
            exit();
        }
        $data_arr = [
            'admin_name' => $admin_name,
            'admin_username' => $admin_username,
            'admin_password' => sha1($admin_password),
            'admin_position' => $admin_position
        ];
        $res = $this->Function_model->insertData('tbl_admin',$data_arr);
        if($res == TRUE){
            echo json_encode([
                'status' => 'SUCCESS',
                'message' => 'เพิ่มข้อมูลผู้ใช้งานเรียบร้อยแล้ว'
            ]); exit();
        }else{
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'มีบางอย่างผิดพลาด กรุณาทำรายการใหม่อีกครั้ง'
            ]);exit();
        }
    }

    //เปลี่ยนรหัสผู้ใช้งาน
    function change_password(){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            show_404();
            exit();
        }
        $admin_id = $this->input->post('admin_id');
        $admin_password = $this->input->post('admin_password');
        if($admin_id == null || $admin_password == null){
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'ไม่มีข้อมูลเข้ามา'
            ]);exit();
        }
        $where_arr = [
            'admin_id' => $admin_id
        ];
        $data_arr = [
            'admin_password' => sha1($admin_password)
        ];
        $res = $this->Function_model->updateData('tbl_admin', $where_arr, $data_arr);
        if($res == TRUE){
            echo json_encode([
                'status' => 'SUCCESS',
                'message' => 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว'
            ]);exit();
        }
    }
    //ดึงข้อมูลผุ้ใช้งาน
    function get_user(){
        if($_SERVER['REQUEST_METHOD'] !='POST'){
            show_404();exit();
        }
        $admin_id = $this->input->post('admin_id');
        if($admin_id == null){
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'ไม่มีข้อมูลเข้ามา'
            ]);exit();
        }
        $res = $this->Function_model->getDataRow('tbl_admin', ['admin_id' => $admin_id]);
        if($res != null){
            echo json_encode([
                'status' => 'SUCCESS',
                'data' => [
                    'admin_id' => $res->admin_id,
                    'admin_name' => $res->admin_name,
                    'admin_username' => $res->admin_username,
                    'admin_position' => $res->admin_position
                ]
            ]);exit();
        }else{
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'ไม่พบข้อมูลที่ต้องการ'
            ]);exit();
        }
    }
    //ลบข้อมูลผู้ใช้งาน
    function del_user(){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            show_404();exit();
        }
        $admin_id = $this->input->post('admin_id');
        if($admin_id == null){
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'ไม่มีข้อมูลเข้ามา'
            ]);exit();
        }
        $res = $this->Function_model->deleteData('tbl_admin', ['admin_id'=>$admin_id]);
        if($res == TRUE){
            echo json_encode([
                'status' => 'SUCCESS',
                'message' => 'ลบข้อมูลผู้ใช้งานเรียบร้อยแล้ว'
            ]);exit();
        }else{
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'มีบางอย่างผิดพลาด กรุณาทำรายการใหม่อีกครั้ง'
            ]);exit();
        }
    }

    //อัพเดตข้อมูลผู้ใช้งาน
    function update_user(){
        // if($_SERVER['REQEUST_METHOD'] != 'POST'){
        //     show_404();exit();
        // }
        $admin_id = $this->input->post('admin_id');
        $admin_name = $this->input->post('admin_name');
        $admin_username = $this->input->post('admin_username');
        $admin_position = $this->input->post('admin_position');
        if($admin_id == null || $admin_name == null || $admin_username == null || $admin_position == null){
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'ไม่มีข้อมูลเข้ามา'
            ]);exit();
        }
        //ตรวจสอบ username ซ้ำ
        $where_username = [
            'admin_username' => $admin_username,
            'admin_id !=' => $admin_id
        ];
        $res_check_username = $this->Function_model->getDataRow('tbl_admin',$where_username);
        if($res_check_username !=null){
            echo json_encode([
                'status' => 'WARNING',
                'message' =>'ชื่อผู้ใช้งานนี้มีในระบบแล้ว กรุณาเปลี่ยนใหม่'
            ]);exit();
        }
        //update data
        $where_arr = ['admin_id' => $admin_id];
        $data_arr = [
            'admin_name' => $admin_name,
            'admin_position' => $admin_position,
            'admin_username' => $admin_username,
        ];
        $res = $this->Function_model->updateData('tbl_admin', $where_arr, $data_arr);
        if($res == TRUE){
            echo json_encode([
                'status' => 'SUCCESS',
                'message' => 'อัพเดตข้อมูลผู้ใช้งานเรียบร้อยแล้ว'
            ]);exit();
        }else{
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'อัพเดตข้อมูลไม่สำเร็จ กรุณาทำรายการใหม่อีกครั้ง'
            ]);exit();
        }
    }
}