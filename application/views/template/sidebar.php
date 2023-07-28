<!-- Main Sidebar Container -->

<aside class="main-sidebar sidebar-dark-primary bg-dark">

    <!-- Brand Logo -->

    <a href="<?=base_url();?>pages" class="brand-link text-center">

        <img src="<?=base_url();?>assets/img/logo.png" style="width:100%; max-width: 100px;">

    </a>



    <!-- Sidebar -->

    <div class="sidebar">

        <!-- Sidebar user (optional) -->

        <div class="user-panel mt-3 pb-3 d-flex">

            <div class="info">

                <a href="<?=base_url();?>pages" class="d-block"><strong></strong> <?= $this->session->userdata('admin_name'); ?></a>

            </div>

        </div>

        <!-- Sidebar Menu -->

        <nav class="mt-2">

            <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item ">

                    <a href="<?=base_url();?>pages" class="nav-link <?= ($active == 'dashboard') ? 'active' : ''; ?>">

                        <i class="nav-icon fas fa-home"></i>

                        <p>

                            หน้าหลัก

                        </p>

                    </a>

                </li>

                <li class="nav-item ">

                    <a href="<?=base_url();?>pages/service_create" class="nav-link <?= ($active == 'service_create') ? 'active' : ''; ?>">

                        <i class="nav-icon fas fa-tools"></i>

                        <p>

                            รับงานซ่อม

                        </p>

                    </a>

                </li>



                <li class="nav-item" id="sidebarService">

                    <a href="#" class="nav-link">

                        <i class="nav-icon fas fa-clipboard-list"></i>

                        <p>

                            รายการงานซ่อม

                            <i class="right fas fa-angle-left"></i>

                        </p>

                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">

                            <a href="<?=base_url();?>pages/service" class="nav-link <?=($active=='service'?'active':'');?>">

                                <i class="fas fa-circle nav-icon"></i>

                                <p>ทั้งหมด</p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="<?=base_url();?>pages/service_status?status=created" class="nav-link <?=($this->input->get('status')=='created'?'active':'');?>">

                                <i class="fas fa-circle nav-icon text-primary"></i>

                                <p>รอส่งซ่อม</p>

                                <span class="badge badge-info right" id="alertCreated"></span>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="<?=base_url();?>pages/service_status?status=wait" class="nav-link <?=($this->input->get('status')=='wait'?'active':'');?>">

                                <i class="fas fa-circle nav-icon text-danger"></i>

                                <p>รับงาน/ระหว่างซ่อม</p>

                                <span class="badge badge-info right" id="alertWait"></span>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="<?=base_url();?>pages/service_status?status=fixed" class="nav-link <?=($this->input->get('status')=='fixed'?'active':'');?>">

                                <i class="fas fa-circle nav-icon text-warning"></i>

                                <p>รอรับรถ</p>

                                <span class="badge badge-info right" id="alertFixed"></span>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="<?=base_url();?>pages/service_status?status=done" class="nav-link <?=($this->input->get('status')=='done'?'active':'');?>">

                                <i class="fas fa-circle nav-icon text-success"></i>

                                <p>เรียบร้อย</p>

                            </a>

                        </li>

                    </ul>

                </li>



                <li class="nav-header text-info">ข้อมูลทะเบียนรถลูกค้า</li>

                <li class="nav-item">

                    <a href="<?=base_url();?>pages/customer" class="nav-link <?= ($active == 'customer') ? 'active' : ''; ?>">

                        <i class="nav-icon fas fa-car"></i>

                        <p>ทะเบียนรถลูกค้า</p>

                    </a>

                </li>



                <!-- รายงานต่างๆ -->

                <li class="nav-header text-info">รายงานต่างๆ</li>

                <li class="nav-item">

                    <a href="<?=base_url();?>pages/report_service" class="nav-link <?= ($active == 'report_service') ? 'active' : ''; ?>">

                        <i class="nav-icon fas fa-circle"></i>

                        <p>รายงานเข้ารับบริการ</p>

                    </a>

                </li>

                <!-- จัดการสินค้าและบริการ -->

                <li class="nav-header text-info">จัดการสินค้า & บริการ และอื่นๆ</li>

                <li class="nav-item">

                    <a href="<?=base_url();?>pages/product" class="nav-link <?= ($active == 'product') ? 'active' : ''; ?>">

                        <i class="nav-icon fas fa-shopping-cart"></i>

                        <p>สินค้าและบริการ</p>

                    </a>

                </li>

                <?php if ($this->session->userdata('admin_position') == 'admin') : ?>

                    <li class="nav-item">

                        <a href="<?=base_url();?>pages/user" class="nav-link <?= ($active == 'user') ? 'active' : ''; ?>">

                            <i class="nav-icon fas fa-user"></i>

                            <p>จัดการผู้ใช้งานระบบ</p>

                        </a>

                    </li>

                <?php endif; ?>



                <!-- ตั้งค่า -->

                <li class="nav-header text-info">ตั้งค่า</li>

                <li class="nav-item">

                    <a href="<?=base_url();?>pages/change_password" class="nav-link <?= ($active == 'change_password') ? 'active' : ''; ?>">

                        <i class="nav-icon fas fa-cog"></i>

                        <p>เปลี่ยนรหัสผ่าน</p>

                    </a>

                </li>

                <li class="nav-item">

                    <a href="<?=base_url();?>logout" class="nav-link">

                        <i class="nav-icon fas fa-power-off"></i>

                        <p>ออกจากระบบ</p>

                    </a>

                </li>

                <!-- ./ตั้งค่า -->

            </ul>

        </nav>

        <!-- /.sidebar-menu -->

    </div>

    <!-- /.sidebar -->

</aside>



<script>

    function sidebarService(){

        $.ajax({

            url : '<?=base_url();?>service/sidebar_status',

            method: 'POST',

            dataType : 'JSON',

            success : function(res){

                if(res.service_created!=0 || res.service_wait!=0 || res.service_fixed!=0){

                    $('#sidebarService').addClass('menu-open')

                }

                //created

                if(res.service_created > 0){

                    $('#alertCreated').html(res.service_created);

                }

                //wait

                if(res.service_wait > 0){

                    $('#alertWait').html(res.service_wait);

                }

                //fixed

                if(res.service_fixed > 0){

                    $('#alertFixed').html(res.service_fixed);

                }

            }

        })

    }



    $(document).ready(function(){

        sidebarService();

    })

</script>
