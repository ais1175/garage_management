<div class="content-wrapper">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h3><i class="fas fa-clipboard-list"></i><strong> รายงานการส่งซ่อม</strong></h3>

                    <p class="text-muted">รายงานการเข้าซ่อม เป็นรายการที่ลูกค้ารับรถไปเรียบร้อยแล้ว</p>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item"><a href="<?=base_url();?>pages">หน้าหลัก</a></li>

                        <li class="breadcrumb-item active"> รายงานการส่งซ่อม</li>

                    </ol>

                </div>

            </div>

        </div>

    </section>

    <section class="content">

        <div class="container-fluid">

            <!-- เวลา -->

            <form method="GET" id="formSubmit">

                <div class="row">

                    <div class="col-md-6 mb-2">

                        <div class="row">

                            <div class="col-md-6">

                                <div class="input-group">

                                    <div class="input-group-prepend">

                                        <span class="input-group-text rounded-0">จาก</span>

                                    </div>

                                    <input type="date" name="datestart" value="<?= $this->input->get('datestart'); ?>" id="datestart" class="form-control rounded-0">

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="input-group">

                                    <div class="input-group-prepend">

                                        <span class="input-group-text rounded-0">ถึง</span>

                                    </div>

                                    <input type="date" name="dateend" value="<?= $this->input->get('dateend'); ?>" id="dateend" class="form-control rounded-0">

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-sm-12 col-md-2 mb-2">

                        <button class="btn btn-info btn-block rounded-0"><i class="fas fa-search"></i> ค้นหา</button>

                    </div>

                </div>

            </form>

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



<script>

    function tblService() {

        let datestart = $('#datestart').val();

        let dateend = $('#dateend').val();

        $.ajax({

            url: '<?=base_url();?>report/tblReportService',

            method: 'POST',

            data: {

                datestart: datestart,

                dateend: dateend

            },

            success: function(res) {

                $('#showTable').html(res);

            }

        })

    }



    $(document).ready(function() {

        tblService();

    })



    $(document).on('submit', '#formSubmit', function(e) {

        e.preventDefault();

        let datestart = $('#datestart').val();

        let dateend = $('#dateend').val();

        if(datestart == ''  || dateend == ''){

            Swal.fire({

                icon : 'warning',

                title : 'แจ้งเตือน',

                text : 'กรุณาเลือกช่วงวันที่ที่ต้องการค้นหา',

                confirmButtonText : 'ตกลง'

            })

            return false;

        }

        history.pushState('', '', 'report_service?datestart=' + datestart + '&dateend=' + dateend);

        tblService();

    });



</script>
