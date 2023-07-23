<div class="row">

    <?php if ($customer != null) : ?>

        <div class="col-md-12 mt-2 text-center text-info">

            <h5><strong>ผลลัพธ์ค้นหา</strong></h5>

        </div>

        <?php foreach ($customer as $item) : ?>

            <div class="col-md-12 mb-2">

                <div class="callout callout-warning rounded-0">

                    <h5><strong> <?= $item->license_plate; ?></strong> <small>(ยี่ห้อ : <?= $item->car_brand; ?> , รุ่น : <?= $item->car_model; ?>)</small></h5>

                    <p class="text-muted">

                        <em>

                            <strong>ชื่อ-นามสกุล : </strong><?= $item->cus_name; ?> <br>

                            <strong>โทร. </strong><?= $item->cus_tel; ?> <br>

                            <strong> ที่อยู่</strong> <?= $item->cus_address; ?><br>

                            <strong>เลขประจำตัวผู้เสียภาษี : </strong> <?= ($item->cus_tax != null ? $item->cus_tax : '-');  ?>

                        </em>

                    </p>

                    <button id="chooseCus" cus_id="<?=$item->cus_id;?>" class="btn btn-dark btn-sm rounded-0"><i class="fas fa-check"></i> เลือก</button>

                </div>

            </div>

        <?php endforeach; ?>

    <?php else : ?>

        <div class="col-md-12 mt-2 mb-2 text-center">

            <h4 class="text-danger"><strong>Oops!</strong><small>ไม่พบทะเบียนที่ต้องการ</small></h4>

        </div>

    <?php endif; ?>

</div>



<script>

    $(document).on('click', '#chooseCus', function(){

        let cus_id = $(this).attr('cus_id');

        $.ajax({

            url : '<?=base_url();?>customer/get_customer',

            method : 'POST',

            dataType : 'JSON',

            data : {

                cus_id : cus_id

            },

            success : function(res){

                if(res.status === 'SUCCESS'){

                    $('#cus_name').val(res.data.cus_name);

                    $('#cus_tel').val(res.data.cus_tel);

                    $('#cus_tax').val(res.data.cus_tax);

                    $('#cus_address').val(res.data.cus_address);

                    $('#license_plate').val(res.data.license_plate);

                    $('#car_brand').val(res.data.car_brand);

                    $('#car_model').val(res.data.car_model);

                    $('#modalSearchData').modal('hide');

                    $('#search_license_plate').val('');

                    $('#showSearch').html(`<div class="row">

                            <div class="col-md-12 mt-2 mb-2 text-center">

                                <h5 class="text-info"><small>กรอกเลขทะเบียนรถที่ต้องการค้นหา</small></h5>

                            </div>

                        </div>`);

                }

            }

        })

        

    })

</script>

