<!-- Menu -->
<aside class="main-sidebar">
	<section class="sidebar">
		
		<!-- Profil User -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="<?php echo site_url('asset/img/user2-160x160.jpg'); ?>" class="img-circle" alt="User Image">
			</div>
			<div class="pull-left info">
				<p>Asep Mulyadi</p>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>
		<!-- Profil User -->
		
		<!-- Sidebar Menu -->
		<ul class="sidebar-menu">
			<li class="<?php echo $reservasi; ?>" ><a href="<?php echo site_url('iri/ricreservasi'); ?>"><i class="fa fa-book"></i> <span>Reservasi</span></a></li>
			<li class="<?php echo $daftar; ?>" ><a href="<?php echo site_url('iri/ricdaftar'); ?>"><i class="fa fa-list"></i> <span>Daftar</span></a></li>
			<li class="<?php echo $pasien; ?>" ><a href="<?php echo site_url('iri/ricpasien'); ?>"><i class="fa fa-users"></i> <span>Pasien</span></a></li>
			<li class="<?php echo $mutasi; ?>" ><a href="<?php echo site_url('iri/ricmutasi'); ?>"><i class="fa fa-medkit"></i> <span>Mutasi</span></a></li>
			<li class="<?php echo $status; ?>" ><a href="<?php echo site_url('iri/ricstatus'); ?>"><i class="fa fa-wheelchair"></i> <span>Status</span></a></li>
			<li class="<?php echo $resume; ?>" ><a href="<?php echo site_url('iri/ricresume'); ?>"><i class="fa fa-tags"></i> <span>Resume</span></a></li>
		</ul>
		</section>
		<!-- /Sidebar Menu -->
		
</aside>
<!-- /Menu -->
