<?php

function Convert($amount_number)

{

    $amount_number = number_format($amount_number, 2, ".", "");

    $pt = strpos($amount_number, ".");

    $number = $fraction = "";

    if ($pt === false)

        $number = $amount_number;

    else {

        $number = substr($amount_number, 0, $pt);

        $fraction = substr($amount_number, $pt + 1);

    }



    $ret = "";

    $baht = ReadNumber($number);

    if ($baht != "")

        $ret .= $baht . "บาท";



    $satang = ReadNumber($fraction);

    if ($satang != "")

        $ret .=  $satang . "สตางค์";

    else

        $ret .= "ถ้วน";

    return $ret;

}



function ReadNumber($number)

{

    $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");

    $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");

    $number = $number + 0;

    $ret = "";

    if ($number == 0) return $ret;

    if ($number > 1000000) {

        $ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";

        $number = intval(fmod($number, 1000000));

    }



    $divider = 100000;

    $pos = 0;

    while ($number > 0) {

        $d = intval($number / $divider);

        $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" : ((($divider == 10) && ($d == 1)) ? "" : ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));

        $ret .= ($d ? $position_call[$pos] : "");

        $number = $number % $divider;

        $divider = $divider / 10;

        $pos++;

    }

    return $ret;

}

?>

<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">

    <title><?= $title; ?></title>

    <style>

        h1,

        h2,

        h3,

        h4,

        h5,

        h6,

        p {

            padding: 0px;

            margin: 0px;

        }



        .table {

            border-collapse: collapse;

        }



        .table th,

        .table td {

            border: 1px solid #333;

        }



        .table td {

            padding-left: 5px;

        }



        .bg-dark {

            background-color: #333;

        }



        .text-white {

            color: white;

        }

    </style>

</head>



<body>

    <?php

    $startYear = date('Y', strtotime($service->service_start)) + 543;



    //หาวันปัจจุบันเป็นไทย

    $todayYear = date('Y', strtotime(date('Y-m-d'))) + 543;

    ?>

    <table>

        <tr>

            <td>

                <!-- <img src="<?=base_url();?>/assets/img/logo.png" alt="" style="max-width: 120px;"> -->

            </td>

            <td>

                <h2><strong>อู่..............................................................................</strong></h2>

                <p>................................................................................................ <br>

                    โทร..................................................<br>

                    <strong>เลขประจำตัวผู้เสียภาษี : </strong> ..........................................

                    <strong> เลขทะเบียนพาณิชย์เลขที่ :</strong> ............................................

                </p>

            </td>

        </tr>

    </table>

    <hr>

    <h2 style="text-align:center"><strong>ใบเสร็จรับเงิน/ใบกำกับภาษี</strong></h2>

    <p style="text-align:center; margin:0px; padding:0px;">

        <strong>เลขที่ </strong> <?= $service->service_invoice; ?>

        <strong>วันที่ออก</strong> <?= date_format(date_create(date('Y-m-d')), 'd/m/' . $todayYear); ?>

        <strong> เวลา</strong> <?= date('H:i:s'); ?>

    </p>

    <!-- ข้อมูลเจ้าของรถ  -->

    <div style="border-collapse: collapse; border:1px solid #333; padding-left: 10px; padding-right : 10px;">

        <table style="width: 100%; margin-top: 10px;">

            <tr>

                <td style="width: 50%;">

                    <strong>นาม :</strong> <?= $service->cus_name; ?>

                </td>

                <td style="width: 50%;">

                    <strong>เลขประจำตัวผู้เสียภาษี : </strong> <?= ($service->cus_tax != null) ? $service->cus_tax : '-'; ?>

                </td>

            </tr>

            <tr>

                <td colspan="2"><strong>ที่อยู่ : </strong><?= $service->cus_address; ?> </td>

            </tr>

        </table>

    </div>



    <!-- รายการสั่งซื้อและบริการ -->

    <div style="margin-top: 10px;">

        <h3 style="text-align:center"><strong>รายการสินค้าและบริการ</strong></h3>

        <table class="table" style="width: 100%;">

            <thead>

                <tr class="bg-dark">

                    <th style="width: 6%; color:white;">ลำดับ</th>

                    <th style="width: 46%; color:white;">รายการ</th>

                    <th style="width: 8%; color:white;">จำนวน</th>

                    <th style="width: 20%; color:white;">หน่วยละ</th>

                    <th style="width: 10%; color:white;" colspan="2">ราคารวม</th>

                </tr>

            </thead>

            <tbody>

                <?php $i = 0; $sum = 0;

                foreach ($service_detail as $item) : ?>

                    <tr>

                        <td style="text-align: center; padding:0px;"><?= ++$i; ?></td>

                        <td>

                            <?= $item->service_name; ?><br>

                            <em><small style="color: #333;"><?= $item->detail; ?></small></em>

                        </td>

                        <td style="text-align: center;">

                            <?= number_format($item->amount); ?>

                        </td>

                        <td style="text-align: center;">

                            <?= number_format($item->price, 2); ?>

                        </td>

                        <td style="text-align: center;">

                            <?= number_format($item->total, 2); ?>

                        </td>

                        <td style="width: 5%; text-align: center;padding:0px;"><small>บาท</small></td>

                    </tr>

                <?php $sum = $sum+$item->total; endforeach; ?>

            </tbody>

            <tfoot>

                <tr style="padding-top :5px;">

                    <td colspan="3" rowspan="4">

                        <div style="padding: 20px; margin-left: 50px; margin-right:50px; background-color: lightgray;">

                        </div>

                    </td>

                    <td style="text-align: right"><strong>ยอดรวมสินค้า & บริการ</strong></td>

                    <td style="text-align: right"><?= number_format($sum, 2); ?></td>

                    <td style="text-align: center"><small>บาท</small></td>

                </tr>

                <tr style="padding-top :5px;">

                    <td style="text-align: right"><strong>ส่วนลด</strong></td>

                    <td style="text-align: right"><?= number_format($service->service_discount, 2); ?></td>

                    <td style="text-align: center"><small>บาท</small></td>

                </tr>

                <tr style="padding-top :5px;">

                    <td style="text-align: right"><strong>ยอดก่อน VAT</strong></td>

                    <td style="text-align: right"><?= number_format($service->service_price,2); ?></td>

                    <td style="text-align: center"><small>บาท</small></td>

                </tr>

                

                <tr style="padding-top :5px;">

                    <td style="text-align: right"><strong>ภาษีมูลค่าเพิ่ม 7%</strong></td>

                    <td style="text-align: right"><?= number_format($service->service_vat, 2); ?></td>

                    <td style="text-align: center"><small>บาท</small></td>

                </tr>

                <tr style="padding-top :5px;">

                    <td colspan="3" style="text-align: center; background-color: lightgray"><em><?= Convert($service->service_total); ?></em></td>

                    <td style="text-align: right"><strong>ยอดสุทธิ</strong></td>

                    <td style="text-align: right"><strong><?= number_format($service->service_total, 2); ?></strong></td>

                    <td style="text-align: center"><small>บาท</small></td>

                </tr>

            </tfoot>

        </table>

    </div>

    <!--ลายเซ็น -->

    <div style="padding-top:50px;">

        <p> ลงชื่อ....................................................................ผู้รับเงิน</p>

        <p style="padding-top: 10px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(................................................................) </p>

    </div>

</body>



</html>
