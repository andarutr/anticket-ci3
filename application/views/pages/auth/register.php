<main class="main-content mt-0">
	<div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
		style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-cover.jpg'); background-position: top;">
		<span class="mask bg-gradient-dark opacity-6"></span>
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-5 text-center mx-auto">
					<h1 class="text-white mb-2 mt-5">Selamat Datang!</h1>
					<p class="text-lead text-white">Silahkan daftar terlebih dahulu ya...</p>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
			<div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
				<div class="card z-index-0">
					<div class="card-header text-center pt-4">
						<h5>Register</h5>
					</div>
					
					<div class="card-body">
						<div class="mb-3">
							<input type="text" class="form-control" id="name" placeholder="Masukkan Nama Lengkap">
						</div>
						<div class="mb-3">
							<input type="email" class="form-control" id="email" placeholder="Masukkan Email">
						</div>
						<div class="mb-3">
							<input type="number" class="form-control" id="nik" placeholder="Masukkan NIK Karyawan">
						</div>
						<div class="mb-3">
							<input type="password" class="form-control" id="password" placeholder="Masukkan Password">
						</div>
						<div class="text-center">
							<button type="button" class="btn bg-gradient-dark w-100 my-4 mb-2" onClick="submit()">Register</button>
						</div>
						<p class="text-sm mt-3 mb-0">Sudah memiliki akun? <a href="<?= base_url('auth/login'); ?>"
								class="text-dark font-weight-bolder">Login</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<script src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/swal2.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/pages/register.js') ?>"></script>