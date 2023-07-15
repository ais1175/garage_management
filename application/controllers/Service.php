<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php';
class Service extends CI_Controller
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
    function tblService()
    {
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            show_404();exit();
        }
        $datestart = $this->input->post('datestart');
        $dateend = $this->input->post('dateend');
        $service_status = $this->input->post('status');
        if($datestart ==null || $dateend == null){
            $datestart = date('Y-m-d');
            $dateend = date('Y-m-d');
        }
        $where_arr = array(
                            'service_start >=' => $datestart,
                            'service_start <=' => $dateend
                        );
        if($service_status != null){
            $where_arr = [
                'service_status' => $service_status
            ];
        }
        $data['service'] = $this->Function_model->fetchDataResult('tbl_service', $where_arr, 'service_id', 'DESC');
        $this->load->view('components/tbl_service', $data);
    }

    //สร้างรายการซ่อม
    function create_service()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            show_404();
            exit();
        }
        $service_invoice = $this->Function_model->genInvoice();
        $cus_name = $this->input->post('cus_name');
        $cus_tel = $this->input->post('cus_tel');
        $cus_tax = $this->input->post('cus_tax');
        $cus_address = $this->input->post('cus_address');
        $license_plate = $this->input->post('license_plate');
        $car_brand = $this->input->post('car_brand');
        $car_model = $this->input->post('car_model');
        $car_mile_number = $this->input->post('car_mile_number');
        $service_start = $this->input->post('service_start');

        if ($service_invoice == null || $cus_name == null || $cus_tel == null || $license_plate == null || $car_brand == null || $car_model == null || $car_mile_number == null) {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'No data input'
            ]);
            exit();
        }
        //ตรวจสอบว่าทะเบียนรถนี้มีในระบบหรือยัง
        $this->db->like('license_plate', $license_plate, 'both');
        $check_license_plate = $this->db->get('tbl_customer')->row();
        if ($check_license_plate == null) {
            $data_cus = [
                'cus_name' => $cus_name,
                'cus_tel' => $cus_tel,
                'cus_address' => $cus_address,
                'cus_tax' => $cus_tax,
                'license_plate' => $license_plate,
                'car_brand' => $car_brand,
                'car_model' => $car_model
            ];
            $this->Function_model->insertData('tbl_customer', $data_cus);
        }
        $data_arr = [
            'service_invoice' => $service_invoice,
            'cus_name' => $cus_name,
            'cus_tel' => $cus_tel,
            'cus_tax' => $cus_tax,
            'cus_address' => $cus_address,
            'license_plate' => $license_plate,
            'car_brand' => $car_brand,
            'car_model' => $car_model,
            'car_mile_number' => $car_mile_number,
            'service_start' => $service_start
        ];
        $res = $this->Function_model->insertData('tbl_service', $data_arr);
        if ($res == TRUE) {
            echo json_encode([
                'status' => 'SUCCESS',
                'service_invoice' => $service_invoice
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'Create Service Fail!'
            ]);
            exit();
        }
    }
    //ดึงข้อมูลใบซ่อม
    function get_invoice()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            show_404();
            exit();
        }
        $service_invoice = $this->input->post('service_invoice');
        if ($service_invoice == null) {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'No data input'
            ]);
            exit();
        }
        $res = $this->Function_model->getDataRow('tbl_service', ['service_invoice' => $service_invoice]);
        if ($res != null) {
            echo json_encode([
                'status' => 'SUCCESS',
                'data' => [
                    'service_id' => $res->service_id,
                    'service_invoice' => $res->service_invoice,
                    'option_vat' => $res->option_vat,
                    'service_total' => number_format($res->service_total, 2),
                    'service_price' => number_format($res->service_price, 2),
                    'service_discount' => number_format($res->service_discount, 2),
                    'service_vat' => number_format($res->service_vat, 2)
                ]
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'ไม่พบเลขใบส่งซ่อม'
            ]);
            exit();
        }
    }
    //ค้นหาข้อมูลจากเลขทะเบียนรถ
    function search_license_plate()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            show_404();
            exit();
        }
        $license_plate = $this->input->post('license_plate');
        if ($license_plate == null) {
            echo '<div class="row">
            <div class="col-md-12 mt-2 mb-2 text-center">
                <h5 class="text-info">แจ้งเตือน! <small>กรอกเลขทะเบียนรถที่ต้องการค้นหา</small></h5>
            </div>
            </div>';
            exit();
        }
        $this->db->like('license_plate', $license_plate, 'after');
        $data['customer'] = $this->db->get('tbl_customer')->result();
        $this->load->view('components/search_customer', $data);
    }

    //ตารางรายการสินค้าและบริการ
    function tbl_service_detail()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            show_404();
            exit();
        }
        $service_invoice = $this->input->post('service_invoice');
        if ($service_invoice == null) {
            show_404();
            exit();
        }
        $data['service_detail'] = $this->Function_model->fetchDataResult('tbl_service_detail', ['service_invoice' => $service_invoice]);
        $this->load->view('components/tbl_service_detail', $data);
    }

    //เพิ่มสินค้าและบริการ
    function add_service_detail()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            show_404();
            exit();
        }
        $service_invoice = $this->input->post('service_invoice');
        $service_name = $this->input->post('service_name');
        $amount = $this->input->post('amount');
        $price = $this->input->post('price');
        $detail = $this->input->post('detail');
        $service = $this->Function_model->getDataRow('tbl_service', ['service_invoice' => $service_invoice]);
        $total = $price * $amount;
        if ($service_invoice == null || $service_name == null || $amount == null || $price == null) {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'No data input'
            ]);
            exit();
        }
        if ($service == null) {
            show_404();
            exit();
        }
        $data_arr = [
            'service_invoice' => $service_invoice,
            'service_name' => $service_name,
            'amount' => $amount,
            'price' => $price,
            'total' => $total,
            'detail' => $detail
        ];
        //insert to tbl_service_detail
        $res_detail = $this->Function_model->insertData('tbl_service_detail', $data_arr);
        if ($res_detail != TRUE) {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'Have someting wrong when insert service_detail'
            ]);
            exit();
        }

        //ขั้นตอนการคำนวณสรุปยอด
        $sum_detail = $this->Function_model->getSum('tbl_service_detail', 'total', ['service_invoice' => $service_invoice]);
        switch ($service->option_vat) {
            case 'in':
                $sum_after_discount = $sum_detail - $service->service_discount; //ยอดหลังหักจากส่วนลด
                $service_vat = ($sum_after_discount * 7) / 107; //หาค่าของ vat 7%
                $service_price = $sum_after_discount - $service_vat;
                $service_total = $sum_after_discount;
                break;
            case 'out':
                $sum_after_discount = $sum_detail - $service->service_discount; //ยอดหลังหักจากส่วนลด
                $service_vat = ($sum_after_discount * 7) / 100; //หาค่าของ vat 7%
                $service_price = $sum_after_discount;
                $service_total = ($sum_detail - $service->service_discount) + $service_vat;
                break;
            default:
                $service_total = $sum_detail - $service->service_discount;
                $service_price = $sum_detail - $service->service_discount;
                $service_vat = 0;
        }
        $data_arr = [
            'service_total' => $service_total,
            'service_vat' => $service_vat,
            'service_price' => $service_price
        ];
        $res = $this->Function_model->updateData('tbl_service', ['service_invoice' => $service_invoice], $data_arr);

        if ($res == TRUE) {
            echo json_encode([
                'status' => 'SUCCESS',
                'message' => 'เพิ่มรายการสินค้าและบริการเรียบร้อยแล้ว'
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'มีบางอย่างผิดพลาด กรุณาทำรายการใหม่อีกครั้ง'
            ]);
        }
    }

    //อัพเดตส่วนลด
    function update_discount()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            show_404();
            exit();
        }
        $service_invoice = $this->input->post('service_invoice');
        $service_discount = $this->input->post('service_discount');

        if ($service_invoice == null || $service_discount == null) {
            show_404();
            exit();
        }
        $res_discount = $this->Function_model->updateData('tbl_service', ['service_invoice' => $service_invoice], ['service_discount' => $service_discount]);
        if ($res_discount != TRUE) {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'Have something wrong add discount'
            ]);
            exit();
        }
        $service = $this->Function_model->getDataRow('tbl_service', ['service_invoice' => $service_invoice]);
        if ($service == null) {
            show_404();
            exit();
        }
        //ขั้นตอนการคำนวณสรุปยอด
        $sum_detail = $this->Function_model->getSum('tbl_service_detail', 'total', ['service_invoice' => $service_invoice]);
        switch ($service->option_vat) {
            case 'in':
                $sum_after_discount = $sum_detail - $service->service_discount; //ยอดหลังหักจากส่วนลด
                $service_vat = ($sum_after_discount * 7) / 107; //หาค่าของ vat 7%
                $service_price = $sum_after_discount - $service_vat;
                $service_total = $sum_after_discount;
                break;
            case 'out':
                $sum_after_discount = $sum_detail - $service->service_discount; //ยอดหลังหักจากส่วนลด
                $service_vat = ($sum_after_discount * 7) / 100; //หาค่าของ vat 7%
                $service_price = $sum_after_discount;
                $service_total = ($sum_detail - $service->service_discount) + $service_vat;
                break;
            default:
                $service_total = $sum_detail - $service->service_discount;
                $service_price = $sum_detail - $service->service_discount;
                $service_vat = 0;
        }
        $data_arr = [
            'service_total' => $service_total,
            'service_vat' => $service_vat,
            'service_price' => $service_price
        ];
        $res = $this->Function_model->updateData('tbl_service', ['service_invoice' => $service_invoice], $data_arr);

        if ($res == TRUE) {
            echo json_encode([
                'status' => 'SUCCESS',
                'message' => 'แก้ไขส่วนลดเรียบร้อยแล้ว'
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'มีบางอย่างผิดพลาด กรุณาทำรายการใหม่อีกครั้ง'
            ]);
        }
    }
    //ดึงเอาส่วนลด
    function get_discount()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            show_404();
            exit();
        }
        $service_invoice = $this->input->post('service_invoice');
        if ($service_invoice == null) {
            show_404();
            exit();
        }
        $res = $this->Function_model->getDataRow('tbl_service', ['service_invoice' => $service_invoice]);
        if ($res != null) {
            echo json_encode([
                'status' => 'SUCCESS',
                'data' => [
                    'service_discount' => $res->service_discount
                ]
            ]);
        }
    }
    //ลบสินค้าและบริการ
    function del_service_detail()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            show_404();
            exit();
        }
        $service_invoice = $this->input->post('service_invoice');
        $id = $this->input->post('detail_id');
        $service = $this->Function_model->getDataRow('tbl_service', ['service_invoice' => $service_invoice]);
        if ($id == null || $service_invoice == null) {
            show_404();
            exit();
        }
        if ($service->service_status == 'done' || $service->service_status == 'fixed') {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'ไม่สามารถลบได้ เนื่องจากซ่อมเสร็จแล้ว หรือรับรถไปแล้ว'
            ]);
            exit();
        }
        $where_arr = [
            'service_invoice' => $service_invoice,
            'id' => $id
        ];
        $res_del = $this->Function_model->deleteData('tbl_service_detail', $where_arr);
        if ($res_del != TRUE) {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'Cannot Delete This Service Detail'
            ]);
            exit();
        }
        //ขั้นตอนการคำนวณสรุปยอด
        $sum_detail = $this->Function_model->getSum('tbl_service_detail', 'total', ['service_invoice' => $service_invoice]);
        switch ($service->option_vat) {
            case 'in':
                $sum_after_discount = $sum_detail - $service->service_discount; //ยอดหลังหักจากส่วนลด
                $service_vat = ($sum_after_discount * 7) / 107; //หาค่าของ vat 7%
                $service_price = $sum_after_discount - $service_vat;
                $service_total = $sum_after_discount;
                break;
            case 'out':
                $sum_after_discount = $sum_detail - $service->service_discount; //ยอดหลังหักจากส่วนลด
                $service_vat = ($sum_after_discount * 7) / 100; //หาค่าของ vat 7%
                $service_price = $sum_after_discount;
                $service_total = ($sum_detail - $service->service_discount) + $service_vat;
                break;
            default:
                $service_total = $sum_detail - $service->service_discount;
                $service_price = $sum_detail - $service->service_discount;
                $service_vat = 0;
        }
        $data_arr = [
            'service_total' => $service_total,
            'service_vat' => $service_vat,
            'service_price' => $service_price
        ];
        $res = $this->Function_model->updateData('tbl_service', ['service_invoice' => $service_invoice], $data_arr);
        if ($res == TRUE) {
            echo json_encode([
                'status' => 'SUCCESS',
                'message' => 'ลบสินค้าและบริการเรียบร้อยแล้ว'
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'มีบางอย่างผิดพลาดกรุณาทำรายการใหม่อีกครั้ง'
            ]);
            exit();
        }
    }

    //อัพเดตฟังก์ชั่นของ vat 
    function update_option_vat()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            show_404();
            exit();
        }
        $service_invoice = $this->input->post('service_invoice');
        $option_vat = $this->input->post('option_vat');
        if ($service_invoice == null) {
            show_404();
            exit();
        }

        $service = $this->Function_model->getDataRow('tbl_service', ['service_invoice' => $service_invoice]);
        if ($service == null) {
            show_404();
            exit();
        }
        $data_arr = [
            'option_vat' => $option_vat
        ];
        $res_option_vat = $this->Function_model->updateData('tbl_service', ['service_invoice' => $service_invoice], $data_arr);
        if ($res_option_vat != TRUE) {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'Cannot update option for Vat'
            ]);
            exit();
        }
        //ขั้นตอนการคำนวณสรุปยอด
        $sum_detail = $this->Function_model->getSum('tbl_service_detail', 'total', ['service_invoice' => $service_invoice]);
        switch ($option_vat) {
            case 'in':
                $sum_after_discount = $sum_detail - $service->service_discount; //ยอดหลังหักจากส่วนลด
                $service_vat = ($sum_after_discount * 7) / 107; //หาค่าของ vat 7%
                $service_price = $sum_after_discount - $service_vat;
                $service_total = $sum_after_discount;
                break;
            case 'out':
                $sum_after_discount = $sum_detail - $service->service_discount; //ยอดหลังหักจากส่วนลด
                $service_vat = ($sum_after_discount * 7) / 100; //หาค่าของ vat 7%
                $service_price = $sum_after_discount;
                $service_total = ($sum_detail - $service->service_discount) + $service_vat;
                break;
            default:
                $service_total = $sum_detail - $service->service_discount;
                $service_price = $sum_detail - $service->service_discount;
                $service_vat = 0;
        }
        $data_arr = [
            'service_total' => $service_total,
            'service_vat' => $service_vat,
            'service_price' => $service_price
        ];
        $res = $this->Function_model->updateData('tbl_service', ['service_invoice' => $service_invoice], $data_arr);
        if ($res == TRUE) {
            echo json_encode([
                'status' => 'SUCCESS',
                'message' => 'อัพเดตข้อมูลภาษีสำเร็จ'
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'มีบางอย่างผิดพลาดกรุณาทำรายการใหม่อีกครั้ง'
            ]);
            exit();
        }
    }

    //ยืนยันการแจ้งซ่อม
    function confirm_fix()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            show_404();
            exit();
        }
        $service_invoice = $this->input->post('service_invoice');
        if ($service_invoice == null) {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'No data input'
            ]);
            exit();
        }
        $service_detail = $this->Function_model->fetchDataResult('tbl_service_detail', ['service_invoice' => $service_invoice]);
        if ($service_detail == null) {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'ไม่มีรายการซ่อมหรือบริการ ไม่สามารถยืนยันงานบริการหรือซ่อมได้'
            ]);
            exit();
        }
        $data_arr = [
            'service_status' => 'wait'
        ];
        $where_arr = [
            'service_invoice' => $service_invoice
        ];
        $res = $this->Function_model->updateData('tbl_service', $where_arr, $data_arr);
        if ($res == TRUE) {
            echo json_encode([
                'status' => 'SUCCESS',
                'message' => 'ยืนยันการส่งซ่อมเรียบร้อยแล้ว'
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'ยืนยันไม่สำเร็จ กรุณาทำรายการใหม่อีกครั้ง'
            ]);
            exit();
        }
    }
    //ยืนยันการซ่อมเสร็จแล้ว
    function confirm_fixed()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            show_404();
            exit();
        }
        $service_invoice =  $this->input->post('service_invoice');
        if ($service_invoice == null) {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'No data input'
            ]);
            exit();
        }
        $res = $this->Function_model->updateData('tbl_service', ['service_invoice' => $service_invoice], ['service_status' => 'fixed']);
        if ($res == TRUE) {
            echo json_encode([
                'status' => 'SUCCESS',
                'message' => 'ยืนยันการซ่อมเสร็จ เรียบร้อยแล้ว'
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'มีบางอย่างผิดพลาด กรุณาทำรายการอีกครั้ง'
            ]);
            exit();
        }
    }

    //ยืนยันรับรถ
    function confirm_pick_car()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            show_404();
            exit();
        }
        $service_invoice = $this->input->post('service_invoice');
        if ($service_invoice == null) {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'No Data Input'
            ]);
            exit();
        }

        $data_arr = [
            'service_end' => date('Y-m-d'),     //วันที่รับรถ
            'service_status' => 'done'
        ];
        $res = $this->Function_model->updateData('tbl_service', ['service_invoice' => $service_invoice], $data_arr);
        if ($res == TRUE) {
            echo json_encode([
                'status' => 'SUCCESS',
                'message' => 'ยืนยันการรับรถเรียบร้อยแล้ว'
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'มีบางอย่างผิดพลาด กรุณาทำรายการใหม่อีกครั้ง'
            ]);
            exit();
        }
    }

    //ยกเลิกรับงานซ่อม
    function cancel_service()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            show_404();
            exit();
        }
        $service_invoice = $this->input->post('service_invoice');
        $service = $this->Function_model->getDataRow('tbl_service', ['service_invoice' => $service_invoice]);
        if ($service_invoice == null || $service == null) {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'No Data Input'
            ]);
            exit();
        }

        //ตรวจสอบในตาราง tbl_service_detail ถ้ามีให้ทำการลบข้อมูล
        $service_detail = $this->Function_model->fetchDataResult('tbl_service_detail', ['service_invoice' => $service_invoice]);
        if ($service_detail != null) {
            $this->Function_model->deleteData('tbl_service_detail', ['service_invoice' => $service_invoice]);
        }
        //ลบ tbl_service
        $res = $this->Function_model->deleteData('tbl_service', ['service_invoice' => $service_invoice]);
        if ($res == TRUE) {
            echo json_encode([
                'status' => 'SUCCESS',
                'message' => 'ลบใบแจ้งซ่อมเรียบร้อยแล้ว'
            ]);
            exit();
        } else {
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'มีบางอย่างผิพลาด กรุณาทำรายการใหม่อีกครั้ง'
            ]);
            exit();
        }
    }

    //ปริ้นใบแจ้งซ่อม ใบเสร็จ
    function print_receipt()
    {
        $service_invoice = $this->input->get('invoice');
        $where_arr = ['service_invoice' => $service_invoice];
        $service = $this->Function_model->getDataRow('tbl_service', $where_arr);
        if ($service == null) {
            echo 'ไม่มีรายการนี้อยู่ในระบบ';
            exit();
        }

        $data['title'] = 'ใบแจ้งซ่อมเลขที่ ' . $service_invoice . ' ทะเบียนรถ ' . $service->license_plate;
        $data['service'] = $service;
        $data['service_detail'] = $this->Function_model->fetchDataResult('tbl_service_detail', $where_arr);
        $html = $this->load->view('print/service_receipt', $data, true);

        $mpdf = new \Mpdf\Mpdf([
            'setAutoTopMargin' => 'stretch',
            'mode' => '',
            'format' => 'A4',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 5,
            'margin_bottom' => 5,
            'margin_header' => 0,
            'margin_footer' => 0,
            'orientation' => 'P',
            'mode' => 'utf-8',
            'default_font_size' => 14,
            'default_font' => 'sarabun'
        ]);
        $mpdf->useFixedNormalLineHeight = false;
        $mpdf->useFixedTextBaseline = false;
        $mpdf->adjustFontDescLineheight = 1;
        $mpdf->WriteHTML($html);
        $mpdf->Output($data['title'] . '.pdf', 'I');
    }

    //ปริ้นใบกำกับภาษี
    function print_tax()
    {
        $service_invoice = $this->input->get('invoice');
        $where_arr = ['service_invoice' => $service_invoice];
        $service = $this->Function_model->getDataRow('tbl_service', $where_arr);
        if ($service == null) {
            echo 'ไม่มีรายการนี้อยู่ในระบบ';
            exit();
        }

        $data['title'] = 'ใบกำกับภาษีเลขที่ ' . $service_invoice . ' ทะเบียนรถ ' . $service->license_plate;
        $data['service'] = $service;
        $data['service_detail'] = $this->Function_model->fetchDataResult('tbl_service_detail', $where_arr);
        $html = $this->load->view('print/service_tax', $data, true);

        $mpdf = new \Mpdf\Mpdf([
            'setAutoTopMargin' => 'stretch',
            'mode' => '',
            'format' => 'A4',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 5,
            'margin_bottom' => 5,
            'margin_header' => 0,
            'margin_footer' => 0,
            'orientation' => 'P',
            'mode' => 'utf-8',
            'default_font_size' => 14,
            'default_font' => 'sarabun'
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output($data['title'] . '.pdf', 'I');
    }

    //genarate invoice
    function gen_invoice(){
        echo $this->Function_model->genInvoice();
    }

    //ค้นหาใบส่งซ่อม
    function search_service_invoice(){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            show_404();exit();
        }
        $service_invoice = $this->input->post('service_invoice');
        if($service_invoice == null){
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'No Data Input'
            ]);exit();
        }
        $res = $this->Function_model->getDataRow('tbl_service', ['service_invoice'=> $service_invoice]);
        if($res != null){
            echo json_encode([
                'status' => 'SUCCESS',
                'service_invoice' => $res->service_invoice
            ]);exit();
        }else{
            echo json_encode([
                'status' => 'ERROR',
                'message' => 'ไม่พบหมายเลขใบสั่งซื้อ'
            ]);exit();
        }
    } 

    //จำนวนรายการที่ต่างๆ
    function get_service_amount(){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            show_404();exit();
        }
        $amount_all_service = count($this->Function_model->fetchDataResult('tbl_service'));
        $amount_service_wait = count($this->Function_model->fetchDataResult('tbl_service', ['service_status'=>'wait']));
        $amount_service_fixed = count($this->Function_model->fetchDataResult('tbl_service',['service_status'=>'fixed']));
        $amount_customer = count($this->Function_model->fetchDataResult('tbl_customer'));
        echo json_encode([
            'status' => 'SUCCESS',
            'amount_all_service' => number_format($amount_all_service),
            'amount_service_wait' => number_format($amount_service_wait),
            'amount_service_fixed' => number_format($amount_service_fixed),
            'amount_customer' => number_format($amount_customer)

        ]);exit();
    }

    /****************************************** */
    //              Side Bar
    /****************************************** */
    function sidebar_status(){
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            show_404();exit();
        }
        
        echo json_encode([
            'service_created' => count($this->Function_model->fetchDataResult('tbl_service', ['service_status'=>'created'])),
            'service_wait' => count($this->Function_model->fetchDataResult('tbl_service', ['service_status'=>'wait'])),
            'service_fixed' => count($this->Function_model->fetchDataResult('tbl_service', ['service_status'=>'fixed'])),
            'service_done' => count($this->Function_model->fetchDataResult('tbl_service', ['service_status'=>'done'])),
        ]);exit();
    }
}
