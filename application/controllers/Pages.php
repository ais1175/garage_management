<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Pages extends CI_Controller

{

    public function __construct()

    {

        parent::__construct();

        if($this->session->userdata('admin_id')==null){

            redirect('/');

        }

    }

    //จัดการหน้าต่างๆ

    public function index($page = 'dashboard')

    {

        if (!file_exists('./application/views/pages/' . $page . '.php')) {

            show_404();

        }

        $data['active'] = $page;

        switch ($page) {

            //หน้าหลัก

            case 'dashboard':

                $data['title'] = 'หน้าแรก | ระบบบริหารจัดการอู่ซ่อมรถ';

                break;

            //รายการซ่อม

            case 'service_create':

                $data['title'] = 'รับงานซ่อม | ระบบบริหารจัดการอู่ซ่อมรถ';

                break;

            case 'service':

                $data['title'] ='รายการส่งซ่อม';

                break;

            case 'service_status':

                $data['title'] = 'รายการส่งซ่อมตามสถานะ';

                break;

            case 'service_detail' :

                $data['title'] = 'รายละเอียดงานซ่อม';

                break;

            //จัดการสินค้า บริการ และอื่นๆ

            case 'product':

                $data['title'] = 'จัดการสินค้าและบริการ';

                break;

            case 'user':

                if($this->session->userdata('admin_position')!='admin'){

                    redirect('/dashboard');

                }

                $data['title'] = 'จัดการผู้ใช้งานระบบ';

                break;

            //ลูกค้า

            case 'customer':

                $data['title'] = 'ทะเบียนรถที่เข้ารับบริการ';

                break;

            //รายงานต่างๆ 

            case 'report_service':

                $data['title'] = 'รายงานการส่งซ่อม';

                break;

            case 'change_password':

                $data['title'] = 'เปลี่ยนรหัสผ่าน';

                break;

            default:

                show_404();

                exit();

        }



        //layout

        $this->load->view('template/header', $data);

        $this->load->view('template/navbar');

        $this->load->view('template/sidebar');

        $this->load->view('pages/'.$page, $data);

        $this->load->view('template/footer');

    }



    //รายละเอียแจ้งซ่อม

    function service_detail($invoice){

        if($invoice == null){

            show_404();exit();

        }

        $data['service'] = $this->Function_model->getDataRow('tbl_service', ['service_invoice'=>$invoice]);

        if($data['service'] == null){

            show_404();exit();

        }

        $data['title']= 'ใบแจ้งซ่อมเลขที่ '.$data['service']->service_invoice;

        $data['active'] = 'service_detail';

        $this->load->view('template/header', $data);

        $this->load->view('template/navbar');

        $this->load->view('template/sidebar');

        $this->load->view('pages/service_detail', $data);

        $this->load->view('template/footer');

    }



    //รายละเอียลูกค้า

    function customer_detail($cus_id){

        if($cus_id == null){

            show_404();exit();

        }

        $data['customer'] = $this->Function_model->getDataRow('tbl_customer', ['cus_id'=>$cus_id]);

        if($data['customer'] == null){

            show_404();exit();

        }

        $data['title']= 'รายละเอียดประวัติการเข้าซ่อมทะเบียน '.$data['customer']->license_plate;

        $data['active'] = 'customer';

        $this->load->view('template/header', $data);

        $this->load->view('template/navbar');

        $this->load->view('template/sidebar');

        $this->load->view('pages/customer_detail', $data);

        $this->load->view('template/footer');

    }



    //เปลี่ยนรหัสผ่าน

    function change_password(){

        if($_SERVER['REQUEST_METHOD'] != 'POST'){

            show_404();

            exit();

        }

        $admin_password = $this->input->post('admin_password');

        $admin_id = $this->session->userdata('admin_id');

        if($admin_password == null){

            echo json_encode([

                'status' => 'ERROR',

                'message' => 'กรุณากรอกข้อมูลรหัสผ่าน'

            ]);exit();

        }

        $data_arr = ['admin_password'=> sha1($admin_password)];

        $where_arr = ['admin_id'=>$admin_id];

        $res = $this->Function_model->updateData('tbl_admin', $where_arr, $data_arr);

        if($res == TRUE){

            echo json_encode([

                'status' => 'SUCCESS',

                'message' => 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว'

            ]);exit();

        }else{

            echo json_encode(array(

                'status' => 'ERROR',

                'message' => 'เปลี่ยนรหัสผ่านไม่สำเร็จ กรุณาตรวจสอบใหม่อีกครั้ง'

            ));exit();

        }

    }



    //logout ออกจากระบบ

    function logout()

    {

        $sess_array = array('admin_id', 'admin_name', 'admin_position');

        $this->session->unset_userdata($sess_array);

        redirect('/');

    }

}

