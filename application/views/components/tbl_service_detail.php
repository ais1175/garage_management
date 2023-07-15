<table class="table table-bordered table-hover table-sm" id="tblServiceDetail">
    <thead>
        <tr class="text-center">
            <th style="width: 5%" class="text-center">#</th>
            <th>ชื่อรายการ</th>
            <th style="width: 5%">จำนวน</th>
            <th style="width: 15%">ราคา/หน่วย</th>
            <th style="width: 15%">ราคารวม</th>
            <th style="width: 10%">ตัวเลือก</th>
        </tr>
    </thead>
    <tbody>
        <?php $sum=0; $i=0; foreach($service_detail as $item):?>
            <tr>
                <td><?=++$i;?></td>
                <td><?=$item->service_name;?> <br>
                <small class="text-muted"><?=$item->detail;?></small>
                </td>
                <td class="text-center"><?=$item->amount;?></td>
                <td><?=number_format($item->price,2);?></td>
                <td><strong><?=number_format($item->total,2);?></strong></td>
                <td class="text-center">
                    <button id="delServiceDetail" onclick="delServiceDetail('<?=$item->id;?>');" class="btn btn-danger btn-sm rounded-0"><i class="fas fa-trash-alt"></i></button>
                </td>
            </tr>
        <?php $sum = $sum+$item->total; endforeach;?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4" class="text-right">
                ยอดรวม
            </th>
            <th class="text-danger"><?=number_format($sum, 2);?></th>
            <th>บาท</th>
        </tr>
    </tfoot>
</table>
<script>
    $('#tblServiceDetail').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "autoWidth": false,
        "responsive": true,
        "pageLength": 10,

        language: {
            search: "ค้นหา :",
            searchPlaceholder: "ค้นหาข้อมูลในตาราง",
            "lengthMenu": "แสดง _MENU_ รายการ/หน้า",
            "zeroRecords": "--ไม่มีรายการซ่อม--",
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