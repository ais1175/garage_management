<table class="table table-bordered table-hover" id="tblReportService">
    <thead>
        <tr class="text-center">
            <th style="width: 10%">เลขที่</th>
            <th style="width: 15%">ทะเบียนรถ</th>
            <th>ชื่อลูกค้า</th>
            <th style="width: 12%">เบอร์โทร</th>
            <th style="width: 15%">วันที่รับซ่อม</th>
            <th style="width: 15%">วันที่รับรถ</th>
            <th style="width: 12%">ตัวเลือก</th>
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
                    <?=date_format(date_create($item->service_start), 'd/m/Y');?>
                </td>
                <td>
                <?=date_format(date_create($item->service_end), 'd/m/Y');?>
                </td>
                <td class="text-center">
                    <a href="/pages/service_detail/<?=$item->service_invoice;?>" class="btn btn-sm btn-default rounded-0">รายละเอียด</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
    $('#tblReportService').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
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