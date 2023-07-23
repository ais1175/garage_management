<table class="table table-bordered table-hover" id="tblCustomerHistory">

    <thead>

        <tr class="text-center">

            <th style="width: 15%">เลขที่ใบซ่อม</th>

            <th style="width: 15%">วันที่เข้าซ่อม</th>

            <th style="width: 15%">วันที่รับรถ</th>

            <th style="width: 10%">สถานะ</th>

            <th>ตัวเลือก</th>

        </tr>

    </thead>

    <tbody>

        <?php foreach($customer_history as $item):?>

            <tr>

                <th><?=$item->service_invoice;?></th>

                <td>

                    <?=date_format(date_create($item->service_start),'d/m/Y');?>

                </td>

                <td>

                    <?=date_format(date_create($item->service_end),'d/m/Y');?>

                </td>

                <td class="text-center">

                <?php

                        switch($item->service_status){

                            case 'created' :

                                echo '<span class="badge badge-primary">รอส่งซ่อม</span>';

                                break;

                            case 'wait':

                                echo '<span class="badge badge-danger">ระหว่างซ่อม</span>';

                                break;

                            case 'fixed':

                                echo '<span class="badge badge-warning">รอรับรถ</span>';

                                break;

                            case 'done':

                                echo '<span class="badge badge-success">รับรถแล้ว</span>';

                                break;

                            default :

                                echo '';

                        }

                    ?>

                </td>

                <td class="text-center">

                    <a href="<?=base_url();?>pages/service_detail/<?=$item->service_invoice;?>" class="btn btn-default btn-flat btn-sm mt-1"><i class="fas fa-list"></i> รายละเอียด</a>

                    <a href="<?=base_url();?>service/print_receipt?invoice=<?=$item->service_invoice;?>" target="_blank" class="btn btn-default btn-flat btn-sm mt-1"><i class="fas fa-receipt"></i> ใบส่งซ่อม</a>

                    <a href="<?=base_url();?>service/print_tax?invoice=<?=$item->service_invoice;?>" target="_blank" class="btn btn-default btn-flat btn-sm mt-1"><i class="fas fa-file-invoice"></i> ใบกำกับภาษี</a>

                </td>

            </tr>

        <?php endforeach;?>

    </tbody>

</table>

<script>

    $('#tblCustomerHistory').DataTable({

        "paging": true,

        "lengthChange": false,

        "searching": true,

        "ordering": false,

        "info": false,

        "autoWidth": false,

        "responsive": true,

        "pageLength": 25,

        language: {

            search: "ค้นหา :",

            searchPlaceholder: "ค้นหาข้อมูลในตาราง",

            "lengthMenu": "แสดง _MENU_ รายการ/หน้า",

            "zeroRecords": "--ไม่มีข้อมูล--",

            "paginate": {

                "first": "<<",

                "last": ">>",

                "next": ">",

                "previous": "<"

            },

            "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",

        },

    });

</script>
