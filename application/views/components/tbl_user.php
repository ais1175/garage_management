<table class="table table-bordered table-hover" id="tblUser">

    <thead>

        <tr class="text-center">

            <th>ชื่อ-นามสกุล</th>

            <th>ชื่อผู้ใช้งาน (Username)</th>

            <th style="width: 15%">ระดับ</th>

            <th style="width: 20%">ตัวเลือก</th>

        </tr>

    </thead>

    <tbody>

        <?php foreach ($admin as $item) : ?>

            <tr id="row<?= $item->admin_id; ?>">

                <td><?= $item->admin_name; ?></td>

                <td><?= $item->admin_username; ?></td>

                <td class="text-center">

                    <?php if ($item->admin_position == 'admin') : ?>

                        <span class="badge badge-primary">ผู้ดูแล</span>

                    <?php elseif ($item->admin_position == 'employee') : ?>

                        <span class="badge badge-dark">พนักงาน</span>

                    <?php else : ?>

                        <span class="badge badge-danger">พนักงาน</span>

                    <?php endif; ?>

                </td>

                <td class="text-center">

                    <?php if ($this->session->userdata('admin_id') != $item->admin_id) : ?>

                        <button onclick="edit('<?=$item->admin_id;?>')" admin_id="<?=$item->admin_id;?>" type="button" class="btn btn-success btn-sm rounded-0" data-toggle="modal" data-target="#modalEditUser"><i class="fas fa-edit"></i></button>

                        <button onclick="del('<?= $item->admin_id; ?>')" type="button" class="btn btn-danger btn-sm rounded-0"><i class="fas fa-trash"></i></button>

                        <button id="btnChangePassword" admin_id="<?= $item->admin_id; ?>" type="button" class="btn btn-outline-primary btn-sm rounded-0" title="เปลี่ยนรหัสผ่าน" data-toggle="modal" data-target="#modalChangePassword"><i class="fas fa-key"></i></button>

                        <?php else : ?>

                        <em class="text-muted">บัญชีปัจจุบัน</em>

                    <?php endif; ?>

                </td>

            </tr>

        <?php endforeach; ?>

    </tbody>

</table>

<input type="hidden" id="edit_admin_id">



<!-- Modal -->

<div class="modal fade" id="modalChangePassword" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content rounded-0">

            <div class="modal-header rounded-0 bg-dark">

                <h5 class="modal-title">เปลี่ยนรหัสผ่านผู้ใช้งาน</h5>

                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-12 mb-2">

                        <label>รหัสผ่านใหม่ :</label>

                        <input type="password" id="edit_admin_password" class="form-control rounded-0" placeholder="กรอกรหัสผ่านใหม่ อย่างน้อย 8 ตัวอักษร">

                    </div>

                    <div class="col-md-12 mb-2">

                        <label>ยืนยันรหัสผ่านใหม่ :</label>

                        <input type="password" id="edit_confirm_password" class="form-control rounded-0" placeholder="กรอกรหัสผ่านใหม่อีกครั้ง">

                    </div>

                </div>

            </div>

            <div class="modal-footer">

                <button id="changePassword" type="button" class="btn btn-primary rounded-0">บันทึก</button>

                <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">ยกเลิก</button>

            </div>

        </div>

    </div>

</div>

<script>

    function clearPasswordForm() {

        $('#edit_admin_password').val('');

        $('#edit_confirm_password').val('');

    }



    function del(admin_id) {

        Swal.fire({

            title: 'ลบผู้ใช้งาน',

            text: "ต้องการลบข้อมูลผู้ใช้งานนี้?",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonText: 'ตกลง',

            cancelButtonText: 'ยกเลิก'

        }).then((result) => {

            if (result.isConfirmed) {

                Swal.fire({

                    html: 'กำลังลบข้อมูลผู้ใช้งาน กรุณารอสักครู่',

                    allowEnterKey: false,

                    allowEscapeKey: false,

                    allowOutsideClick: false,

                    timerProgressBar: true,

                    didOpen: () => {

                        Swal.showLoading();

                        $.ajax({

                            url: '<?=base_url();?>user/del_user',

                            method: 'POST',

                            dataType: 'JSON',

                            data: {

                                admin_id: admin_id

                            },

                            success: function(res) {

                                if (res.status === 'SUCCESS') {

                                    Swal.fire({

                                        icon: 'success',

                                        title : 'สำเร็จ',

                                        text: 'ลบข้อมูลผู้ใช้เรียบร้อยแล้ว',

                                        showConfirmButton: false,

                                        timer: 1500

                                    });

                                    $('#row'+admin_id).hide();

                                } else {

                                    Swal.fire({

                                        icon: 'error',

                                        title: 'ผิดพลาด',

                                        text : res.mesage,

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

    }



    function edit(admin_id){

        $.ajax({

            url : '<?=base_url();?>user/get_user', 

            method : 'POST',

            dataType : 'JSON',

            data : {admin_id : admin_id},

            success : function(res){

                if(res.status === 'SUCCESS'){

                    $('#edit_admin_id').val(admin_id);

                    $('#edit_admin_name').val(res.data.admin_name);

                    $('#edit_admin_username').val(res.data.admin_username);

                    document.querySelector('#edit_admin_position').value = res.data.admin_position;

                }

            }

        })

    }



    $(document).on('click', '#btnChangePassword', function() {

        clearPasswordForm();

        $('#edit_admin_id').val($(this).attr('admin_id'));

    })

    $(document).on('click', '#changePassword', function() {

        let admin_password = $('#edit_admin_password').val();

        let confirm_password = $('#edit_confirm_password').val();

        let admin_id = $('#edit_admin_id').val();

        if (admin_password == '' || confirm_password == '') {

            Swal.fire({

                icon: 'warning',

                title: 'แจ้งเตือน',

                text: 'กรุณากรอกรหัสผ่านและยืนยันรหัสผ่านที่ต้องการเปลี่ยน',

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

        if (admin_password != confirm_password) {

            Swal.fire({

                icon: 'warning',

                title: 'แจ้งเตือน',

                text: 'รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน กรุณาตรวจสอบให้ถูกต้อง',

                confirmButtonText: 'ตกลง'

            });

            return false;

        }

        Swal.fire({

            title: 'เปลี่ยนรหัสผ่าน',

            text: "ต้องการเปลี่ยนรหัสผ่านผู้ใช้งานนี้?",

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

                            url: '/user/change_password',

                            method: 'POST',

                            data: {

                                admin_id: admin_id,

                                admin_password: admin_password

                            },

                            dataType: 'JSON',

                            success: function(res) {

                                if (res.status == 'SUCCESS') {

                                    Swal.fire({

                                        icon: 'success',

                                        title: 'สำเร็จ',

                                        text: 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว',

                                        timer: 1500,

                                        showConfirmButton: false,

                                    })

                                    clearPasswordForm();

                                    $('#edit_admin_id').val('');

                                    $('#modalChangePassword').modal('hide');

                                } else {

                                    Swal.fire({

                                        icon: 'error',

                                        title: 'ผิดพลาด',

                                        html: res.message,

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

    $('#tblUser').DataTable({

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
