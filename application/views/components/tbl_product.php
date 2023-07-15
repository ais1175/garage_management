<table class="table table-bordered table-hover" id="tblProduct">
    <thead>
        <tr class="text-center">
            <th>รายการสินค้าและบริการ</th>
            <th style="width: 20%">ตัวเลือก</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($product as $item) : ?>
            <tr id="product<?=$item->product_id;?>">
                <td><?=$item->product_name;?></td>
                <td class="text-center">
                    <button onclick="getProduct('<?=$item->product_id;?>')" class="btn btn-sm btn-success rounded-0"><i class="fas fa-edit"></i></button>
                    <button id="delProduct" product_id ="<?=$item->product_id;?>" class="btn btn-sm btn-danger rounded-0"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
    
    $('#tblProduct').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
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