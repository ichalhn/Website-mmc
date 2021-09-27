<?php $this->load->view("layout/header"); ?>
<?php $this->load->view("rekap/layout/script_addon"); ?>
<?php $this->load->view("rekap/layout/all_page_js_req"); ?>
<script type='text/javascript'>
$(function() {
	 
	$('#date_picker1').datepicker({
				format: "yyyy-mm-dd",
				//endDate: "current",
				autoclose: true,
				todayHighlight: true,
		});
	// $('#date_picker2').datepicker({
	// 			format: "yyyy-mm-dd",
	// 			//endDate: "current",
	// 			autoclose: true,
	// 			todayHighlight: true,
	// 	});
	
	$('#date_picker_months').datepicker({
		format: "yyyy-mm",
		//endDate: "current",
		autoclose: true,
		todayHighlight: true,
		viewMode: "months", 
		minViewMode: "months",
	}); 
	$('#date_picker_years').datepicker({
		format: "yyyy",
		//endDate: "current",
		autoclose: true,
		todayHighlight: true,
		format: "yyyy",
		viewMode: "years", 
		minViewMode: "years",
	});
	$('#date_picker1').show();
	// $('#date_picker2').show();
	$('#date_picker_months').hide();
	$('#date_picker_years').hide();

	
});	
function cek_tgl_awal(tgl_awal){
		//var tgl_akhir=document.getElementById("date_picker2").value;
		var tgl_akhir=$('#date_picker2').val();
		if(tgl_akhir==''){
		//none :D just none
		}else if(tgl_akhir<tgl_awal){
			$('#date_picker2').val('');
			//document.getElementById("date_picker2").value = '';
		}
	}
	function cek_tgl_akhir(tgl_akhir){
		//var tgl_awal=document.getElementById("date_picker1").value;
		var tgl_awal=$('#date_picker1').val();
		if(tgl_akhir<tgl_awal){
			$('#date_picker1').val('');
			//document.getElementById("date_picker1").value = '';
		}
	}
	function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='TGL'){
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker1").required = true;
			// document.getElementById("date_picker2").required = true;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker1').show();
			// $('#date_picker2').show();
			$('#date_picker_months').hide();
			$('#date_picker_years').hide();
		}
	}

</script>


	<div >
			
		<div class="container-fluid"><br/>

		<!-- Keterangan page -->
		<section class="content-header">
			<h1>Laporan Rawat Inap - Jumlah Pasien Keluar Masuk</h1>
			<!-- <ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-home"></i> Home</a></li>
				<li><a href="#">Laporan Rawat Inap</a></li>
			</ol> -->
		</section>
		<!-- /Keterangan page -->

		<div class="container-fluid"><br/>
			<div class="inline">
				<div class="row">
					<div class="form-inline">
						<form action="<?php echo base_url();?>rekap/Rcrekap/index" method="post" accept-charset="utf-8">
						<div class="col-lg-10">
							<div class="form-inline">
								<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
									<option value="TGL">Tanggal</option>
									<!-- <option value="THN">Tahun</option> -->
								</select>
								<!-- <input type="text" id="date_picker1" class="form-control" placeholder="Tanggal Awal" name="tgl_awal" onchange="cek_tgl_awal(this.value)" required>
								<input type="text" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="tgl_akhir" onchange="cek_tgl_akhir(this.value)" required> -->
								<input type="text" id="date_picker1" class="form-control" placeholder="Pilih Tanggal" name="tgl_awal" required>
								<input type="text" id="date_picker_months" class="form-control" placeholder="yyyy-mm" name="bulan">
								<input type="text" id="date_picker_years" class="form-control" placeholder="yyyy" name="tahun">
								<button class="btn btn-primary" type="submit">Cari</button>
								
							</div>
						</div><!-- /inline -->					
					</form>	
					</div>
				</div>						
			</div>
		</div>

		<section class="content">
				<div class="row">
						<div class="panel panel-info">
							<div class="panel-body">
								<br/>
						<div style="display:block;overflow:auto;">
						<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
						  <thead>
							<tr>
								<th>Tanggal</th>
								<th>Jumlah Masuk</th>
								<th>Jumlah Keluar</th>
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
						  	$tanggal = $bulan_input;
						  	foreach ($list_keluar_masuk as $r) { 
						  	?>
						  	<tr>
						  		<td><?php echo date('d-m-Y | H:i',strtotime($r['tanggal']))?></td>
						  		<td>
						  			<?php 
						  				if($r['jml_tgl_masuk'] == null){
						  					echo '0';
						  				}else{
						  					echo $r['jml_tgl_masuk'];
						  				}
						  			?>
						  		</td>
						  		<td>
						  			<?php 
						  				if($r['jml_tgl_keluar'] == null){
						  					echo '0';
						  				}else{
						  					echo $r['jml_tgl_keluar'];
						  				}
						  			?>
						  		</td>
						  		</td>
						  	</tr>
						  	<?php
						  	}
						  	?>
							</tbody>
						</table>
						<hr>
						<div class="form-inline" align="right">
						</div>
						</div><!-- style overflow -->
					</div><!--- end panel body -->
				</div><!--- end panel -->
				</div><!--- end panel -->
		</section>
		<!-- /Main content -->		
	</div>
</div>
<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
	});
	$('#calendar-tgl').datepicker();
</script>

<?php $this->load->view("layout/footer"); ?>
