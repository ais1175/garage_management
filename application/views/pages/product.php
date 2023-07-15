<div class="content-wrapper">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h3><strong>จัดการสินค้าและบริการ</strong></h3>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item"><a href="<?=base_url();?>/pages">หน้าหลัก</a></li>

                        <li class="breadcrumb-item active">จัดการสินค้าและบริการ</li>

                    </ol>

                </div>

            </div>

        </div>

    </section>

    <section class="content">

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-12 mb-2">

                    <button type="button" class="btn btn-primary rounded-0" data-toggle="modal" data-target="#modalAddProduct"><i class="fas fa-plus"></i> เพิ่มสินค้าและบริการ</button>

                </div>

            </div>

            <div class="row">

                <div class="col-md-12">

                    <div class="card rounded-0">

                        <div class="card-body" id="showTable">

                            <div class="text-center">

                                <div class="spinner-border text-dark" role="status">

                                    <span class="sr-only">Loading...</span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>

<input type="hidden" id="product_id">

<!-- Modal Add Product-->

<div class="modal fade" id="modalAddProduct" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content rounded-0">

            <div class="modal-header bg-dark rounded-0">

                <h5 class="modal-title"><i class="fas fa-plus"></i> เพิ่มสินค้าและบริการ</h5>

                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-12 mb-2">

                        <label>ชื่อสินค้าหรือชื่อบริการ</label>

                        <input type="text" class="form-control rounded-0" id="product_name" placeholder="กรอกชื่อสินค้าหรือชื่อบริการ">

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button id="addProduct" type="button" class="btn btn-primary rounded-0">บันทึก</button>

                <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">ยกเลิก</button>

            </div>

        </div>

    </div>

</div>



<!-- Modal Edit Product -->

<div class="modal fade" id="modalEditProduct" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content rounded-0">

            <div class="modal-header bg-dark rounded-0">

                <h5 class="modal-title"><i class="fas fa-edit"></i> แก้ไขสินค้าและบริการ</h5>

                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-12 mb-2">

                        <label>ชื่อสินค้าหรือชื่อบริการ</label>

                        <input type="text" class="form-control rounded-0" id="edit_product_name" placeholder="กรอกชื่อสินค้าหรือชื่อบริการ">

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button id="updateProduct" type="button" class="btn btn-primary rounded-0">บันทึก</button>

                <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">ยกเลิก</button>

            </div>

        </div>

    </div>

</div>



<script>

    function tblProduct() {

        $.ajax({

            url: '<?=base_url();?>/product/tbl_product',

            method: 'POST',

            dataType: 'html',

            success: function(res) {

                $('#showTable').html(res);

            }

        })

    }



    function getProduct(product_id) {

        $('#modalEditProduct').modal('show');

        $.ajax({

            url: '<?=base_url();?>/product/get_product',

            method: 'POST',

            dataType: 'JSON',

            data: {

                product_id: product_id

            },

            success: function(res) {

                if (res.status == 'SUCCESS') {

                    $('#product_id').val(res.product_id);

                    $('#edit_product_name').val(res.product_name);

                } else {

                    Swal.fire({

                        icon: 'error',

                        title: 'ไม่สำเร็จ',

                        text: 'การเรียกข้อมูลไม่สำเร็จ กรุณาทำรายการใหม่อีกครั้ง',

                        confirmButtonText: 'ตกลง'

                    });

                    return false;

                }

            }

        })

    }



    $(document).ready(function() {

        tblProduct();

    })

    //เพิ่มสินค้า

    $(document).on('click', '#addProduct', function() {

        let product_name = $('#product_name').val();

        if (product_name === '') {

            Swal.fire({

                icon: 'warning',

                title: 'แจ้งเตือน',

                text: 'กรุณากรอกชื่อสินค้าและบริการ',

                confirmButtonText: 'ตกลง'

            });

            return false;

        }

        Swal.fire({

            title: 'เพิ่มข้อมูล?',

            text: "ต้องการเพิ่มสินค้าและบริการนี้?",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'ตกลง',

            cancelButtonText: 'ยกเลิก'

        }).then((result) => {

            if (result.isConfirmed) {

                Swal.fire({

                    html: 'กำลังบันทึกข้อมูล กรุณารอสักครู่...',

                    timerProgressBar: true,

                    didOpen: () => {

                        Swal.showLoading();

                        $.ajax({

                            url: '<?=base_url();?>/product/add_product',

                            method: 'POST',

                            dataType: 'JSON',

                            data: {

                                product_name: product_name

                            },

                            success: function(res) {

                                if (res.status == 'SUCCESS') {

                                    Swal.fire({

                                        icon: 'success',

                                        title: 'สำเร็จ',

                                        text: 'เพิ่มสินค้าและบริการเรียบร้อยแล้ว',

                                        showConfirmButton: false,

                                        timer: 1500

                                    });

                                    tblProduct();

                                    $('#product_name').val('');

                                    $('#modalAddProduct').modal('hide');

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

                });

            }

        });



    });



    //อัพเดตสินค้า

    $(document).on('click', '#updateProduct', function() {

        let product_id = $('#product_id').val();

        let product_name = $('#edit_product_name').val();

        if (product_id === '' || product_name === '') {

            Swal.fire({

                icon: 'warning',

                title: 'แจ้งเตือน',

                text: 'กรุณากรอกชื่อสินค้าและบริการ',

                confirmButtonText: 'ตกลง'

            });

            return false;

        }

        Swal.fire({

            title: 'อัพเดตข้อมูล',

            text: "ต้องการแก้ไขสินค้าและบริการนี้?",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'ตกลง',

            cancelButtonText: 'ยกเลิก'

        }).then((result) => {

            if (result.isConfirmed) {

                Swal.fire({

                    html: 'กำลังบันทึกข้อมูล กรุณารอสักครู่...',

                    timerProgressBar: true,

                    allowEnterKey: false,

                    allowEscapeKey: false,

                    allowOutsideClick: false,

                    didOpen: () => {

                        Swal.showLoading();

                        $.ajax({

                            url: '<?=base_url();?>/product/update_product',

                            method: 'POST',

                            dataType: 'JSON',

                            data: {

                                product_id: product_id,

                                product_name: product_name

                            },

                            success: function(res) {

                                if (res.status === 'SUCCESS') {

                                    Swal.fire({

                                        icon: 'success',

                                        title: 'สำเร็จ',

                                        text: 'อัพเดตข้อมูลสินค้าและบริการเรียบร้อยแล้ว',

                                        showConfirmButton: false,

                                        timer: 1500

                                    });

                                    tblProduct();

                                    $('#edit_product_name').val('');

                                    $('#product_id').val('');

                                    $('#modalEditProduct').modal('hide');

                                } else {

                                    Swal.fire({

                                        icon: 'error',

                                        title: 'ผิดพลาด',

                                        text: res.message,

                                        confirmButtonText: 'ตกลง'

                                    });

                                    return false;

                                }

                            }

                        })

                    },

                })

            }

        })

    });



    //ลบข้อมูลสินค้า

    $(document).on('click', '#delProduct', function() {

        let product_id = $(this).attr('product_id');

        Swal.fire({

            title: 'ลบข้อมูล',

            text: "ต้องการลบสินค้าและบริการนี้?",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'ตกลง',

            cancelButtonText: 'ยกเลิก'

        }).then((result) => {

            if (result.isConfirmed) {

                Swal.fire({

                    html: 'กำลังลบข้อมูล กรุณารอสักครู่...',

                    allowEnterKey : false,

                    allowEscapeKey : false,

                    allowOutsideClick : false,

                    timerProgressBar: true,

                    didOpen: () => {

                        Swal.showLoading();

                        $.ajax({

                            url: '<?=base_url();?>/product/del_product',

                            method: 'POST',

                            dataType: 'JSON',

                            data: {

                                product_id: product_id

                            },

                            success: function(res) {

                                if (res.status === 'SUCCESS') {

                                    Swal.fire({

                                        icon: 'success',

                                        title: 'สำเร็จ',

                                        text: 'ลบข้อมูลสินค้าและบริการเรียบร้อยแล้ว',

                                        showConfirmButton: false,

                                        timer: 1500

                                    });

                                    tblProduct();

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

</script>
