<?php
	$this->load->view('layout/header.php');
?>

<script type='text/javascript'>
var intervalSetting = function () { 
location.reload(); 
}; 
setInterval(intervalSetting, 120000);

	$(function() {
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});  
	});
	
	$(document).ready(function() {
		$('#date_picker1').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		}); 
		$('#date_picker2').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		}); 
		$('#tabel_kwitansi').DataTable();
		$(".select2").select2();
	
	//-----------------------------------------------Data Table
		$('#tabel_tindakan').DataTable();
		$('#tabel_lab').DataTable();
		$('#tabel_cetak_lab').DataTable();
		$('#tabel_cetak_rad').DataTable();
		$('#tabel_farm').DataTable();
		$('#tabel_cetak_farm').DataTable();
	} );

</script>

	
<?php
	echo $this->session->flashdata('message_cetak'); 
?>

<section class="content-header">
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group row">
					<div class="col-md-8">
						<?php echo form_open('user/cuser/penunjang/');?>
							<div class="form-group ">
								<input type="text" id="date_picker1" class="form-control" placeholder="Tanggal Awal" name="date0">
								<input type="text" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="date1">
								
									<button class="btn btn-primary" type="submit">Cari</button>
								
							</div><!-- /input-group -->
						<?php echo form_close();?>
					</div><!-- /.col-lg-6 -->
						
				</div>
					<div class="panel panel-default">
						<div class="panel-heading" align="center">
							<ul class="nav nav-pills nav-justified">
								<li role="presentation"><a data-toggle="tab" href="#tabRad">Radiologi</a></li>
								<li role="presentation"><a data-toggle="tab" href="#tabLab">Laboratorium</a></li>
								<li role="presentation"><a data-toggle="tab" href="#tabFarmasi">Farmasi</a></li>								
							</ul>
						</div>
						
						<!--<div class="panel-body" style="display:block;overflow:auto;">
						<br/>-->
						<div class="tab-content">
							
							<div id="tabRad" class="tab-pane fade in active">	    						
								<?php include('user_rad.php');  ?>
							</div> <!-- end div tab tindakan -->
							
							<div id="tabLab" class="tab-pane fade in ">	    						
								<?php include('user_lab.php');  ?>
							</div> <!-- end div tab diagnosa -->

							<div id="tabFarmasi" class="tab-pane fade in">	    								
								<?php include('user_farmasi.php');  ?>
							</div> <!-- end div tab lab -->
				</div>
			</div>
		</section>

<?php
	$this->load->view('layout/footer.php');
?>
