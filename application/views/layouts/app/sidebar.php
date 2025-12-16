<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
	id="sidenav-main">
	<div class="sidenav-header">
		<i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
			aria-hidden="true" id="iconSidenav"></i>
		<a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html "
			target="_blank">
			<img src="<?= base_url('assets/img/logo.png'); ?>" width="26px" height="26px" class="navbar-brand-img h-100"
				alt="main_logo">
			<span class="ms-1 font-weight-bold">Anticket</span>
		</a>
	</div>
	<hr class="horizontal dark mt-0">
	<div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
		<ul class="navbar-nav">
			<li class="nav-item mt-3">
				<h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6"><?= $this->session->userdata('role'); ?></h6>
			</li>
			<?php if($this->session->userdata('role') == 'user'): ?>
				<li class="nav-item">
					<a class="nav-link" href="<?= site_url('/user/dashboard'); ?>">
						<div
							class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
							<i class="bi bi-rocket-takeoff text-dark text-sm opacity-10"></i>
						</div>
						<span class="nav-link-text ms-1">Dashboard</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?= site_url('/user/ticket/request-system'); ?>">
						<div
							class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
							<i class="bi-server text-dark text-sm opacity-10"></i>
						</div>
						<span class="nav-link-text ms-1">Request System</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?= site_url('/user/ticket/request-feature'); ?>">
						<div
							class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
							<i class="bi-lightning-charge text-dark text-sm opacity-10"></i>
						</div>
						<span class="nav-link-text ms-1">Request Feature</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?= site_url('/user/ticket/report-bug'); ?>">
						<div
							class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
							<i class="bi-bug text-dark text-sm opacity-10"></i>
						</div>
						<span class="nav-link-text ms-1">Report Bug</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?= site_url('/user/ticket/request-meeting'); ?>">
						<div
							class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
							<i class="bi-calendar-check text-dark text-sm opacity-10"></i>
						</div>
						<span class="nav-link-text ms-1">Request Meeting</span>
					</a>
				</li>
			<?php endif; ?>
		</ul>
	</div>
</aside>