<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin_id') == null) {
            redirect('/');
        }
    }
    public function index()
    {
        redirect('/');
    }
    
    function get_customer(){
        if($_SERVER['REQUEST_METHOD']!='POST'){
            show_404();exit();
        }
        $cus_id = $this->input->post('cus_id');
        if($cus_id == null){
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'No data input'
            ]);exit();
        }
        $res = $this->Function_model->getDataRow('tbl_customer', ['cus_id' => $cus_id]);
        if($res != null){
            echo json_encode([
                'status' => 'SUCCESS',
                'data' => [
                    'cus_id' => $res->cus_id,
                    'cus_name' => $res->cus_name,
                    'cus_tel' => $res->cus_tel,
                    'cus_tax' => $res->cus_tax,
                    'cus_address' => $res->cus_address,
                    'license_plate' => $res->license_plate,
                    'car_brand' => $res->car_brand,
                    'car_model' => $res->car_model
                ]
            ]);
        }else{
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'ไม่พบข้อมูลลูกค้าที่ต้องการ'
            ]);exit();
        }
    }

    //ทะเบียนรถลูกค้า
    function tblCustomer(){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            show_404();exit();
        }
        $license_plate = $this->input->post('license_plate');
        $this->db->like('license_plate', $license_plate, 'both');
        $data['customer'] = $this->db->get('tbl_customer')->result();
        $this->load->view('components/tbl_customer', $data);
    }
    
    //ตารางประวัติการเข้าใช้งาน
    function tbl_customer_history(){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            show_404();exit();
        }
        $datestart = $this->input->post('datestart');
        $dateend = $this->input->post('dateend');
        $cus_id = $this->input->post('cus_id');
        if($cus_id == null){
            show_404();exit();
        }
        $license_plate = $this->Function_model->getDataRow('tbl_customer', ['cus_id'=>$cus_id])->license_plate;
        if($datestart == null || $dateend == null){
            $where_arr = [
                'license_plate' => $license_plate
            ];
        }else{
            $where_arr = [
                'service_start >=' => $datestart,
                'service_end <=' => $dateend,
                'license_plate' => $license_plate
            ];
        }
        $data['customer_history'] = $this->Function_model->fetchDataResult('tbl_service', $where_arr,'service_id', 'DESC');
        $this->load->view('components/tbl_customer_history', $data);
    }

    //อัพเดตข้อมูลลูกค้า
    function update_customer(){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            show_404();exit();
        }
        $cus_id = $this->input->post('cus_id');
        $cus_name = $this->input->post('cus_name');
        $cus_tel = $this->input->post('cus_tel');
        $cus_tax = $this->input->post('cus_tax');
        $cus_address = $this->input->post('cus_address');
        if($cus_id == null || $cus_name == null || $cus_tel == null || $cus_address == null){
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'No data Input'
            ]);exit();
        }
        $where_arr = ['cus_id' => $cus_id];
        $data_arr = [
            'cus_name' => $cus_name,
            'cus_tel' => $cus_tel,
            'cus_tax' => $cus_tax,
            'cus_address' => $cus_address
        ];
        $res = $this->Function_model->updateData('tbl_customer', $where_arr, $data_arr);
        if($res == TRUE){
            echo json_encode([
                'status' => 'SUCCESS',
                'message' => 'อัพเดตข้อมูลเรียบร้อยแล้ว'
            ]);exit();
        }else{
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'มีบางอย่างผิดพลาด กรุณาทำรายการใหม่อีกครั้ง'
            ]);exit();
        }
    }

    //ลบข้อมูลลูกค้า
    function del_customer(){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            show_404();exit();
        }
        $cus_id = $this->input->post('cus_id');
        if($cus_id == null){
            echo json_encode([
                'status'=>'ERROR',
                'message' => 'No Data Input'
            ]);exit();
        }
        $res =$this->Function_model->deleteData('tbl_customer', ['cus_id'=>$cus_id]);
        if($res == TRUE){
            echo json_encode([
                'status' => 'SUCCESS',
                'message' => 'ลบข้อมูลทะเบียนรถและลูกค้าเรียบร้อยแล้ว'
            ]);exit();
        }else{
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'มีบางอย่างผิดพลาด กรุณาตรวจสอบหรือทำรายการใหม่อีกครั้ง'
            ]);exit();
        }
    }
}
