<?php $this->load->view("layout/header"); ?>
<?php include('script_laprdkunjungan.php');?>
<style>
hr{
border-color: green;
}
</style>
<?php echo $message_nodata;?>	
<!-- checkbox -->
<div class="container-fluid"><br/>
              <?php include('lap_cari.php');?>
</div>
	<section class="content">
		<div class="row">
			<div class="panel panel-default" style="width:97%;margin:0 auto">	
				<div class="panel-heading"><h4 align="center"><?php echo $date_title; ?></h4>
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
