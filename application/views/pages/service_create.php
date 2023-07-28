<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h3><i class="fas fa-tools"></i><strong> รับงานซ่อม & บริการ</strong></h3>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item"><a href="<?=base_url();?>pages">หน้าหลัก</a></li>

                        <li class="breadcrumb-item active">รับงานซ่อม</li>

                    </ol>

                </div>

            </div>

        </div><!-- /.container-fluid -->

    </section>

    <section class="content">

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-12 mb-2">

                    <div class="card rounded-0">

                        <div class="card-header bg-dark rounded-0">

                            ข้อมูลลูกค้า & ข้อมูลรถ

                            <div class="card-tools">

                                <button type="button" class="btn btn-warning btn-sm rounded-0" data-toggle="modal" data-target="#modalSearchData"><i class="fas fa-search"></i> ค้นหาทะเบียนรถ</button>

                            </div>

                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-3 mb-2">

                                    <label>วันที่รับซ่อม :</label>

                                    <input type="date" id="service_start" class="form-control rounded-0" placeholder="วันที่ส่งซ่อม" value="<?=date('Y-m-d');?>">

                                </div>

                            </div>

                            <p class="text-primary"><i class="fas fa-circle"></i> ข้อมูลลูกค้า</p>

                            <div class="row">

                                <div class="col-md-4 mb-2">

                                    <label><strong class="text-danger">*</strong>ชื่อ-นามสกุล :</label>

                                    <input type="text" id="cus_name" class="form-control rounded-0" placeholder="กรอกชื่อ-นามสกุล">

                                </div>

                                <div class="col-md-4 mb-2">

                                    <label><strong class="text-danger">*</strong>เบอร์โทร :</label>

                                    <input type="text" id="cus_tel" class="form-control rounded-0" placeholder="กรอกเบอร์โทร" maxlength="10" oninput="this.value=this.value.replace(/[^0-9\\s]/g,'');">

                                </div>

                                <div class="col-md-4 mb-2">

                                    <label>เลขประจำตัวผู้เสียภาษี (ถ้ามี)</label>

                                    <input type="text" id="cus_tax" class="form-control rounded-0" placeholder="กรอกเลขผู้เสียภาษี (ถ้ามี)" oninput="this.value=this.value.replace(/[^0-9\\s]/g,'');">

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12 mb-2">

                                    <label><strong class="text-danger">*</strong>ที่อยู่ ออกใบเสร็จ/ใบกำกับภาษี :</label>

                                    <textarea id="cus_address" rows="1" class="form-control rounded-0" placeholder="กรอกที่อยู่ลูกค้า"></textarea>

                                </div>

                            </div>

                            <p class="text-primary"><i class="fas fa-circle"></i> ข้อมูลรถ</p>

                            <div class="row">

                                <div class="col-md-4 mb-2">

                                    <label><strong class="text-danger">*</strong>ทะเบียนรถ :</label>

                                    <input type="text" id="license_plate" class="form-control rounded-0" placeholder="กรอกทะเบียนรถ ตัวอย่าง '1กด-2547' เป็นต้น">

                                </div>

                                <div class="col-md-4 mb-2">

                                    <label><strong class="text-danger">*</strong>ยี่ห้อรถ :</label>

                                    <input type="text" id="car_brand" class="form-control rounded-0" placeholder="กรอกยี่ห้อรถ ตัวอย่างเช่น 'Suzuki','Honda' เป็นต้น">

                                </div>

                                <div class="col-md-4 mb-2">

                                    <label><strong class="text-danger">*</strong>รุ่นรถ :</label>

                                    <input type="text" id="car_model" class="form-control rounded-0" placeholder="กรอกรุ่นรถ ตัวอย่างเช่น 'Swift', 'Accord' เป็นต้น">

                                </div>

                                <div class="col-md-4 mb-2">

                                    <label><strong class="text-danger">*</strong>เลขไมล์รถ :</label>

                                    <input type="text" maxlength="6" id="car_mile_number" class="form-control rounded-0" placeholder="กรอกเลขไมล์รถ" maxlength="6" oninput="this.value=this.value.replace(/[^0-9\s]/g,'');">

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12 mt-2">

                                    <button id="createService" class="btn btn-primary rounded-0">สร้างรายการซ่อม</button>

                                    <button onclick="clearForm()" class="btn btn-default rounded-0">เคลียร์</button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>





<!-- Modal -->

<div class="modal fade" id="modalSearchData" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content rounded-0">

            <div class="modal-header bg-dark rounded-0">

                <h5 class="modal-title">ค้นหาทะเบียนรถ</h5>

                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-12 mb-2">

                        <div class="input-group">

                            <input type="text" onkeyup="search_license_plate()" id="search_license_plate" class="form-control rounded-0" placeholder="กรอกเลขทะเบียนรถ ตัวอย่าง 1กด-2565 เป็นต้น">

                            <span class="input-group-append">

                                <button type="button" onclick="search_license_plate()" class="btn btn-warning btn-flat"><i class="fas fa-search"></i> ค้นหา</button>

                            </span>

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-12 mb-2" id="showSearch">

                        <div class="row">

                            <div class="col-md-12 mt-2 mb-2 text-center">

                                <h5 class="text-info"><small>กรอกเลขทะเบียนรถที่ต้องการค้นหา</small></h5>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



<script>

    //clear form

    function clearForm(){

        $('#cus_name').val('');

        $('#cus_tel').val('');

        $('#cus_tax').val('');

        $('#cus_address').val('');

        $('#license_plate').val('');

        $('#car_brand').val('');

        $('#car_model').val('');

        $('#car_mile_number').val('');

        $('#service_start').val('<?=date('Y-m-d');?>');

    }

    function search_license_plate() {

        let license_plate = $("#search_license_plate").val();

        $.ajax({

            url: '<?=base_url();?>service/search_license_plate',

            method: 'POST',

            data: {

                license_plate: license_plate

            },

            success: function(res) {

                $('#showSearch').html(res);

            }

        })

    }

    $(document).on('click', '#createService', function() {

        let cus_name = $('#cus_name').val();

        let cus_tel = $('#cus_tel').val();

        let cus_tax = $('#cus_tax').val();

        let cus_address = $('#cus_address').val();

        let license_plate = $('#license_plate').val();

        let car_brand = $('#car_brand').val();

        let car_model = $('#car_model').val();

        let car_mile_number = $('#car_mile_number').val();

        let service_start = $('#service_start').val();

        if (cus_name == '' || cus_tel == '' || cus_address == '' || license_plate == '' || car_brand == '' || car_model == '', car_mile_number == '') {

            Swal.fire({

                icon: 'warning',

                title: 'แจ้งเตือน',

                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',

                confirmButtonText: 'ตกลง'

            });

            return false;

        }

        Swal.fire({

            title: 'สร้างรายการซ่อม',

            text: "ต้องการสร้างรายการซ่อมนี้?",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'ตกลง',

            cancelButtonText: 'ยกเลิก'

        }).then((result) => {

            if (result.isConfirmed) {

                Swal.fire({

                    allowEnterKey : false,

                    allowEscapeKey :false,

                    allowOutsideClick: false,

                    html: 'กำลังสร้างรายการ กรุณารอสักครู่...',

                    timerProgressBar: true,

                    didOpen: () => {

                        Swal.showLoading();

                        $.ajax({

                            url: '<?=base_url();?>service/create_service',

                            method: 'POST',

                            dataType: 'JSON',

                            data: {

                                cus_name: cus_name,

                                cus_tel: cus_tel,

                                cus_tax: cus_tax,

                                cus_address: cus_address,

                                license_plate: license_plate,

                                car_brand: car_brand,

                                car_model: car_model,

                                car_mile_number: car_mile_number,

                                service_start : service_start

                            },

                            success: function(res) {

                                if (res.status == 'SUCCESS') {

                                    Swal.fire({

                                        icon: 'success',

                                        title: 'สำเร็จ',

                                        text: 'สร้างรายการซ่อมสำเร็จ',

                                        showConfirmButton: false,

                                        timer: 1500

                                    });

                                    setTimeout(function() {

                                        window.location.assign('<?=base_url();?>pages/service_detail/' + res.service_invoice);

                                    }, 1500);

                                } else {

                                    Swal.fire({

                                        icon: 'error',

                                        title: 'ผิดพลาด!',

                                        text: res.message,

                                        confirmButtonText: 'ตกลง'

                                    });

                                    return false;

                                }

                            }

                        })

                    }

                })

            }

        })

    });

    $(document).on('click', '#search', function() {

        let license_plate = $("#search_license_plate").val();

        if (license_plate == '') {

            Swal.fire({

                icon: 'warning',

                title: 'แจ้งเตือน',

                text: 'กรุณากรอกทะเบียนรถที่ต้องการค้นหา',

                confirmButtonText: 'ตกลง'

            })

            return false;

        }

        $.ajax({

            url: '<?=base_url();?>service/search_license_plate',

            method: 'POST',

            data: {

                license_plate: license_plate

            },

            success: function(res) {

                $('#showSearch').html(res);

            }

        })

    })

</script>
