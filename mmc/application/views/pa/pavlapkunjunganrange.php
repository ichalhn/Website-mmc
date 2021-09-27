<?php $this->load->view("layout/header"); ?>
<?php include('script_laprdkunjungan.php');?>
<style>
hr {
	border-color:#7DBE64 !important;
}

thead {
	background: #c4e8b6 !important;
	color:#4B5F43 !important;
	background: -moz-linear-gradient(top,  #c4e8b6 0%, #7DBE64 100%) !important;
	background: -webkit-linear-gradient(top,  #c4e8b6 0%,#7DBE64 100%) !important;
	background: linear-gradient(to bottom,  #c4e8b6 0%,#7DBE64 100%) !important;
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c4e8b6', endColorstr='#7DBE64',GradientType=0 )!important;
}
</style>

<section class="content-header">
	<?php include('lap_cari.php');	?>
</section>
              
<section class="content">
	<div class="row">
		<div class="panel panel-default" style="width:97%;margin:0 auto">
			<div class="panel-heading">			
				<h4 align="center"><?php echo $date_title; ?></h4>
			</div>
			<div class="panel-body">				
				<?php if($tampil_per=='TGL'){ 
				include('kunj_tgl.php');
				} else if($tampil_per=='BLN'){ 
				include('kunj_bln.php');
				} else {include('kunj_thn.php');} ?>			
												
					</div><!--- end panel body --->
				</div><!--- end panel --->
			</div><!--- end row --->
		</section>
<?php $this->load->view("layout/footer"); ?>
