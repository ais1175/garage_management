<?php
class Function_model extends CI_Model
{
    function getData($table, $where_array)
    {
        $this->db->where($where_array);
        return $this->db->get($table);
    }

    function getDataRow($table, $where_array)
    {
        $this->db->where($where_array);
        return $this->db->get($table)->row();
    }

    function fetchDataResult($table, $where_array = null, $order_key = null, $order_by = null)
    {
        if ($where_array != null) {
            $this->db->where($where_array);
        }
        if ($order_key != null && $order_by != null) {
            $this->db->order_by($order_key, $order_by);
        }
        return $this->db->get($table)->result();
    }

    function insertData($table, $data_array)
    {
        $this->db->insert($table, $data_array);
        if ($this->db->affected_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function insertDataMultiple($table, $data_array)
    {
        $this->db->insert_batch($table, $data_array);
        if ($this->db->affected_rows() >= 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function deleteData($table, $where_array)
    {
        $this->db->where($where_array);
        $this->db->delete($table);
        if ($this->db->affected_rows()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    function updateData($table, $where_array, $data_array)
    {
        $this->db->where($where_array);
        $this->db->update($table, $data_array);
        return TRUE;
    }
    //GET SUM COLUMN
    function getSum($table, $sum_column, $where_array = null)
    {
        $this->db->select_sum($sum_column);
        $this->db->from($table);
        if ($where_array != null) {
            $this->db->where($where_array);
        }
        return $this->db->get()->row()->$sum_column;
    }

    //ออกเลบใบส่งซ่อม service invoice
    function genInvoice()
    {
        $where_arr = [
            'service_start >=' => date('Y-01-01'),
            'service_start <=' => date('Y-12-31')
        ];
        //หาจำนวนข้อมูล
        $this->db->where($where_arr);
        $service = $this->db->get('tbl_service')->result();
        if(count($service)==0){
            $number_invoice = date('y') . sprintf('%04d', '1');
        }else{
            $number_invoice = date('y') . sprintf('%04d', count($service));
        }
       
        $this->db->where('service_invoice', $number_invoice);
        $check_invoice = $this->db->get('tbl_service')->row();
        //ตรวจสอบเลขซ้ำ
        while($check_invoice != null){
            $number_invoice++;
            $this->db->where('service_invoice', $number_invoice);
            $check_invoice = $this->db->get('tbl_service')->row();
        }
        return $number_invoice;
    }
}
