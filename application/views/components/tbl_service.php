<table class="table table-bordered table-hover" id="tblService">

    <thead>

        <tr class="text-center">

            <th style="width: 10%">เลขที่</th>

            <th style="width: 15%">ทะเบียนรถ</th>

            <th>ชื่อลูกค้า</th>

            <th style="width: 15%">เบอร์โทร</th>

            <th style="width: 10%">สถานะ</th>

            <th style="width: 15%">ตัวเลือก</th>

        </tr>

    </thead>

    <tbody>

        <?php foreach ($service as $item) : ?>

            <tr>

                <td class="text-center"><span class="badge badge-dark"><?=$item->service_invoice;?></span></td>

                <td><?=$item->license_plate;?></td>

                <td><?=$item->cus_name;?></td>

                <td><?=$item->cus_tel;?></td>

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

                    <a href="<?=base_url();?>pages/service_detail/<?=$item->service_invoice;?>" class="btn btn-sm btn-default rounded-0">รายละเอียด</a>

                </td>

            </tr>

        <?php endforeach; ?>

    </tbody>

</table>



<script>

    $('#tblService').DataTable({

        "paging": true,

        "lengthChange": false,

        "searching": true,

        "ordering": false,

        "info": true,

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
