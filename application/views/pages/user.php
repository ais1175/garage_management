<div class="content-wrapper">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h3><strong>จัดการผู้ใช้งานระบบ</strong></h3>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item"><a href="<?=base_url();?>/pages">หน้าหลัก</a></li>

                        <li class="breadcrumb-item active">จัดการผู้ใช้งานระบบ</li>

                    </ol>

                </div>

            </div>

        </div>

    </section>

    <section class="content">

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-12 mb-2">

                    <button type="button" onclick="clearForm()" class="btn btn-primary rounded-0" data-toggle="modal" data-target="#modalAddUser"><i class="fas fa-user-plus"></i> เพิ่มผู้ใช้งาน</button>

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



<!-- Modal Add User-->

<div class="modal fade" id="modalAddUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content rounded-0">

            <div class="modal-header bg-dark rounded-0" style="padding-bottom: 0px;">

                <p><i class="fas fa-user-plus"></i> เพิ่มผู้ใช้งาน</p>

                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-12 mb-2">

                        <label>ชื่อ-นามสกุล :</label>

                        <input type="text" id="admin_name" class="form-control rounded-0" placeholder="กรอกชื่อ-นามสกุล">

                    </div>

                    <div class="col-md-12 mb-2">

                        <label>ระดับการเข้าถึง</label>

                        <select id="admin_position" class="form-control rounded-0">

                            <option value="employee">พนักงานทั่วไป</option>

                            <option value="admin">ผู้ดูแลระบบ</option>

                        </select>

                    </div>

                    <div class="col-md-12 mb-2">

                        <label>ชื่อผู้ใช้งาน (Username) :</label>

                        <input type="text" id="admin_username" class="form-control rounded-0" placeholder="กรอกชื่อผู้ใช้งาน ภาษาอังกฤษและตัวเลขเท่านั้น" maxlength="20" oninput="this.value=this.value.replace(/[^A-Za-z0-9\\s]/g,'');">

                    </div>

                    <div class="col-md-12 mb-2">

                        <label>รหัสผ่าน (Password) : </label>

                        <input type="password" id="admin_password" class="form-control rounded-0" placeholder="กรอกรหัสผ่าน ต้องมีอย่างน้อย 8 ตัวอักษรขึ้นไป">

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" id="btnAddUser" class="btn btn-primary rounded-0">บันทึก</button>

                <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">ยกเลิก</button>

            </div>

        </div>

    </div>

</div>



<!-- Modal Edit User -->

<div class="modal fade" id="modalEditUser" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content rounded-0">

            <div class="modal-header bg-dark rounded-0" style="padding-bottom: 0px;">

                <p><i class="fas fa-user-edit"></i> แก้ไขผู้ใช้งาน</p>

                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-12 mb-2">

                        <label>ชื่อ-นามสกุล :</label>

                        <input type="text" id="edit_admin_name" class="form-control rounded-0" placeholder="กรอกชื่อ-นามสกุล">

                    </div>

                    <div class="col-md-12 mb-2">

                        <label>ระดับการเข้าถึง</label>

                        <select id="edit_admin_position" class="form-control rounded-0">

                            <option value="employee">พนักงานทั่วไป</option>

                            <option value="admin">ผู้ดูแลระบบ</option>

                        </select>

                    </div>

                    <div class="col-md-12 mb-2">

                        <label>ชื่อผู้ใช้งาน (Username) :</label>

                        <input type="text" id="edit_admin_username" class="form-control rounded-0" placeholder="กรอกชื่อผู้ใช้งาน ภาษาอังกฤษและตัวเลขเท่านั้น" maxlength="20" oninput="this.value=this.value.replace(/[^A-Za-z0-9\\s]/g,'');">

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" id="btnUpdateUser" class="btn btn-primary rounded-0">บันทึก</button>

                <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">ยกเลิก</button>

            </div>

        </div>

    </div>

</div>



<script>

    function tblUser() {

        $.ajax({

            url: '<?=base_url();?>/user/tbl_user',

            method: 'POST',

            success: function(res) {

                $('#showTable').html(res);

            }

        })

    }

    function clearForm() {

        $('#admin_name').val('');

        $('#admin_username').val('');

        $('#admin_password').val('');

    }

    $(document).ready(function() {

        tblUser();

    });

    //Add User

    $(document).on('click', '#btnAddUser', function() {

        let admin_name = $('#admin_name').val();

        let admin_username = $('#admin_username').val();

        let admin_position = $('#admin_position').val();

        let admin_password = $('#admin_password').val();

        if (admin_name == '' || admin_username == '' || admin_password == '' || admin_position == '') {

            Swal.fire({

                icon: 'warning',

                title: 'แจ้งเตือน',

                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',

                confirmButtonText: 'ตกลง'

            });

            return false;

        }

        if (admin_password.length < 8) {

            Swal.fire({

                icon: 'warning',

                title: 'แจ้งเตือน',

                text: 'รหัสผ่านต้องมีอย่างน้อย 8 ตัวอักษรขึ้นไป',

                confirmButtonText: 'ตกลง'

            });

            return false;

        }

        Swal.fire({

            title: 'บันทึกผู้ใช้งาน',

            text: "ต้องการเพิ่มข้อมูลผู้ใช้งานนี้?",

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

                            url: '<?=base_url();?>/user/add_user',

                            method: 'POST',

                            dataType: 'JSON',

                            data: {

                                admin_name: admin_name,

                                admin_username: admin_username,

                                admin_password: admin_password,

                                admin_position: admin_position,

                            },

                            success: function(res) {

                                if (res.status == 'SUCCESS') {

                                    Swal.fire({

                                        icon: 'success',

                                        title: 'สำเร็จ',

                                        timer: 1500,

                                        showConfirmButton: false,

                                    });

                                    tblUser();

                                    clearForm();

                                    $('#modalAddUser').modal('hide');

                                } else if (res.status == 'WARNING') {

                                    Swal.fire({

                                        icon: 'warning',

                                        title: 'แจ้งเตือน',

                                        text: res.message,

                                        confirmButtonText: 'ตกลง'

                                    });

                                    return false;

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

                    }

                })

            }

        })

    })

    //Update User

    $(document).on('click', '#btnUpdateUser', function() {

        let admin_id = $('#edit_admin_id').val();

        let admin_name = $('#edit_admin_name').val();

        let admin_username = $('#edit_admin_username').val();

        let admin_position = $('#edit_admin_position').val();

        if (admin_id == '' || admin_name == '' || admin_username == '' || admin_position == '') {

            Swal.fire({

                icon: 'warning',

                title: 'แจ้งเตือน',

                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',

                confirmButtonText: 'ตกลง'

            });

            return false;

        }



        Swal.fire({

            title: 'อัพเดตข้อมูล?',

            text: "ต้องการอัพเดตข้อมูลผู้ใช้งานนี้?",

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

                    allowEscapeKey : false,

                    allowOutsideClick : false,

                    didOpen: () => {

                        Swal.showLoading();

                        $.ajax({

                            url: '<?=base_url();?>/user/update_user',

                            method: 'POST',

                            dataType: 'JSON',

                            data: {

                                admin_id: admin_id,

                                admin_name: admin_name,

                                admin_position: admin_position,

                                admin_username: admin_username

                            },

                            success: function(res) {

                                if (res.status == 'SUCCESS') {

                                    Swal.fire({

                                        icon: 'success',

                                        title: 'สำเร็จ',

                                        text : 'อัพเดตข้อมูลเรียบร้อยแล้ว',

                                        showConfirmButton: false,

                                        timer: 1500

                                    });

                                    tblUser();

                                    $('#edit_admin_username').val('');

                                    $('#edit_admin_name').val('');

                                    $('#modalEditUser').modal('hide');

                                    

                                } else if (res.status == 'WARNING') {

                                    Swal.fire({

                                        icon: 'warning',

                                        title: 'แจ้งเตือน!',

                                        text: res.message,

                                        confirmButtonText: 'ตกลง'

                                    });

                                    return false;

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

        })





    })

</script>
