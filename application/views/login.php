<!DOCTYPE html>

<html lang="en">



<head>

	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>ระบบบริการ อู่ซ่อมรถ</title>

	<link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.ico">

	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">

	<link rel="stylesheet" href="<?= base_url(); ?>assets/AdminLTE/plugins/fontawesome-free/css/all.min.css">

	<link rel="stylesheet" href="<?= base_url(); ?>assets/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

	<link rel="stylesheet" href="<?= base_url(); ?>assets/AdminLTE/dist/css/adminlte.min.css?v=3.2.0">

	<link rel="stylesheet" href="<?= base_url(); ?>assets/AdminLTE/plugins/sweetalert2/sweetalert2.min.css">

	<script src="<?= base_url(); ?>assets/AdminLTE/plugins/sweetalert2/sweetalert2.all.min.js"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

	<!-- SweetAlert2 -->

	<script src="<?= base_url(); ?>assets/AdminLTE/plugins/sweetalert2/sweetalert2.all.min.js"></script>

	<link rel="stylesheet" href="<?= base_url(); ?>assets/AdminLTE/plugins/sweetalert2/sweetalert2.min.css">

	<style>
		* {

			font-family: 'Kanit';

		}
	</style>

</head>



<body class="hold-transition login-page" style="background-image: linear-gradient(to bottom right, #CB8931 , #FFF1A4, #FBCF68) ;">

	<div class="login-box">

		<div class="card">

			<div class="card-body login-card-body">

				<div class="login-logo">

					<img src="<?= base_url(); ?>assets/img/logo.png" class="img-fluid" style="max-width: 200px;">

				</div>

				<h4 class="text-center"><strong>ระบบบริหารจัดการอู่ซ่อมรถ</strong></h4>

				<p class="text-center">GARAGE MANAGEMENT SYSTEM</p>

				<form id="formLogin">

					<div class="input-group mb-3">

						<input type="text" name="username" id="username" class="form-control rounded-0" placeholder="ชื่อผู้ใช้งาน" autofocus>

						<div class="input-group-append">

							<div class="input-group-text rounded-0">

								<span class="fas fa-user"></span>

							</div>

						</div>

					</div>

					<div class="input-group mb-3">

						<input type="password" name="password" id="password" class="form-control rounded-0" placeholder="รหัสผ่าน">

						<div class="input-group-append">

							<div class="input-group-text rounded-0">

								<span class="fas fa-lock"></span>

							</div>

						</div>

					</div>

					<div class="row">

						<div class="col-12">

							<button type="submit" class="btn btn-dark btn-block rounded-0"><i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ</button>

						</div>

					</div>

				</form>

			</div>



		</div>

	</div>

	<script>
		$(document).on('submit', '#formLogin', function(e) {

			e.preventDefault();

			let username = $('#username').val();

			let password = $('#password').val();

			if (username === '' && password === '') {

				Swal.fire({

					icon: 'warning',

					title: 'แจ้งเตือน!',

					html: 'กรุณากรอก <strong>ชื่อผู้ใช้งาน</strong> และ <strong>รหัสผ่าน</strong>',

					confirmButtonText: 'ตกลง'

				});

				return false;

			}

			$.ajax({

				url: '<?= base_url(); ?>login/check_login',

				method: 'POST',

				dataType: 'JSON',

				data: {

					username: username,

					password: password

				},

				success: function(res) {

					console.log(res);

					if (res.status === 'SUCCESS') {

						Swal.fire({

							icon: 'success',

							title: 'สำเร็จ',

							text: 'ยินดีต้อนรับเข้าสู่ระบบบริหารจัดการงานอู่ซ่อมรถ',

							showConfirmButton: false,

							timer: 1500

						})

						setTimeout(function() {

							window.location.reload();

						}, 1500)

					} else {

						Swal.fire({

							icon: 'error',

							title: 'ผิดพลาด!',

							html: res.message,

							confirmButtonText: 'ตกลง'

						});

						return false;

					}

				}

			})

		})
	</script>

	<script src="<?= base_url(); ?>assets/AdminLTE/plugins/jquery/jquery.min.js"></script>

	<script src="<?= base_url(); ?>assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

	<script src="<?= base_url(); ?>assets/AdminLTE/dist/js/adminlte.min.js?v=3.2.0"></script>



</body>



</html>
