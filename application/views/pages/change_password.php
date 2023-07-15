<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

    </section>

    <section class="content">

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-6 offset-md-3">

                    <div class="card card-primary rounded-0">

                        <div class="card-header bg-dark rounded-0">

                            เปลี่ยนรหัสผ่านเข้าสู่ระบบ

                        </div>

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-12 mb-2">

                                    <label>รหัสผ่านใหม่ :</label>

                                    <input type="password" id="admin_password" class="form-control rounded-0" placeholder="กรอกรหัสผ่านใหม่">

                                </div>

                                <div class="col-md-12 mb-2">

                                    <label>รหัสผ่านใหม่อีกครั้ง :</label>

                                    <input type="password" id="confirm_password" class="form-control rounded-0" placeholder="กรอกรหัสผ่านใหม่อีกครั้ง">

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    <button id="btnChangePassword" class="btn btn-primary rounded-0">เปลี่ยนรหัสผ่าน</button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</div>



<script>

    $(document).on('click', '#btnChangePassword', function() {

        let admin_password = $("#admin_password").val();

        let confirm_password = $('#confirm_password').val();

        if (admin_password === '' || confirm_password === '') {

            Swal.fire({

                icon: 'warning',

                title: 'แจ้งเตือน',

                text: 'กรุณากรอกรหัสผ่านและยืนยันรหัสผ่านที่ต้องการเปลี่ยน',

                confirmButtonText: 'เข้าใจแล้ว'

            });

            return false;

        }

        if (admin_password.length < 8) {

            Swal.fire({

                icon: 'warning',

                title: 'แจ้งเตือน',

                text: 'รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษรขึ้นไป',

                confirmButtonText: 'เข้าใจแล้ว'

            });

            return false;

        }

        if (admin_password != confirm_password) {

            Swal.fire({

                icon: 'warning',

                title: 'แจ้งเตือน',

                text: 'รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน กรุณาตรวจสอบให้ถูกต้อง',

                confirmButtonText: 'เข้าใจแล้ว'

            });

            return false;

        }

        Swal.fire({

            title: 'เปลี่ยนรหัสผ่าน',

            text: "ต้องการเปลี่ยนรหัสผ่านเพื่อเข้าสู่ระบบนี้?",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'ตกลง',

            cancelButtonText: 'ยกเลิก'

        }).then((result) => {

            if (result.isConfirmed) {

                Swal.fire({

                    html: 'กำลังบันทึกข้อมูล กรุณารอสักครู่...',

                    timerProgressBar: true,

                    allowEnterKey : false,

                    allowOutsideClick : false, 

                    allowEscapeKey : false,

                    didOpen: () => {

                        Swal.showLoading();

                        $.ajax({

                            url: '<?=base_url();?>/change_password',

                            method: 'POST',

                            dataType: 'JSON',

                            data: {

                                admin_password: admin_password,

                            },

                            success: function(res) {

                                if (res.status === 'SUCCESS') {

                                    Swal.fire({

                                        icon: 'success',

                                        title: 'สำเร็จ',

                                        text : 'เปลี่ยนรหัสผ่านเข้าสู่ระบบเรียบร้อยแล้ว',

                                        showConfirmButton: false,

                                        timer: 1500

                                    });

                                    $('#admin_password').val('');

                                    $('#confirm_password').val('');

                                }

                            }

                        })



                    }

                })

            }

        })

    })

</script>
