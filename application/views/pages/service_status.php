<div class="content-wrapper">

    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h3><i class="fas fa-clipboard-list"></i> <strong id="titleHeader"></strong></h3>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item"><a href="<?=base_url();?>pages">หน้าหลัก</a></li>

                        <li class="breadcrumb-item active"> รายการส่งซ่อม</li>

                    </ol>

                </div>

            </div>

        </div>

    </section>

    <section class="content">

        <div class="container-fluid">

            <div class="row">

                <div class="col-md-12 mb-2">

                    <a href="<?=base_url();?>pages/service_create" class="btn btn-primary rounded-0"><i class="fas fa-tools"></i> รับงานซ่อม</a>

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



<script>

    

    function tblService() {

        let status = '<?=$this->input->get('status');?>';

        if(status==''){

            window.location.assign('<?=base_url();?>pages/service');

        }

        switch(status){

            case 'created':

                document.title = 'รายการที่รอส่งซ่อม';

                $('#titleHeader').html('รายการที่รอส่งซ่อม');

                break;

            case 'wait':

                document.title = 'รายการที่อยู่ระหว่างการซ่อม';

                $('#titleHeader').html('รายการที่อยู่ระหว่างการซ่อม');

                break;

            case 'fixed':

                document.title = 'รายการที่รอรับรถ';

                $('#titleHeader').html('รายการที่รอรับรถ');

                break;

            case 'done' :

                document.title = 'รายการที่รับรถเรียบร้อยแล้ว';

                $('#titleHeader').html('รายการที่รับรถเรียบร้อยแล้ว');

                break;

            default :

            window.location.assign('<?=base_url();?>pages/service');

        }

        $.ajax({

            url: '<?=base_url();?>service/tblService',

            method: 'POST',

            data: {

                status: status

            },

            success: function(res) {

                $('#showTable').html(res);

            }

        })

    }



    $(document).ready(function() {

        tblService();

    })

</script>
