<?php
	$this->load->view('layout/header.php');
?>
<script type='text/javascript'>
$(function() {
	 
	$('#date_picker').datepicker({
				format: "yyyy-mm-dd",
				endDate: "current",
				autoclose: true,
				todayHighlight: true,
	});
	$('#date_picker_months').datepicker({
		format: "yyyy-mm",
		endDate: "current",
		autoclose: true,
		todayHighlight: true,
		viewMode: "months", 
		minViewMode: "months",
	}); 
	$('#date_picker_years').datepicker({
		format: "yyyy",
		endDate: "current",
		autoclose: true,
		todayHighlight: true,
		format: "yyyy",
		viewMode: "years", 
		minViewMode: "years",
	});
	$('#date_picker').show();
	$('#date_picker_months').hide();
	$('#date_picker_years').hide();

	cb = "<?php echo $cara_bayar; ?>";	
	if(cb!=''){
		$('#cara_bayar').val(cb).change();
	}

	
});	

function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='TGL'){
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker").required = true;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = false;
			$('#cara_bayar').show();
			$('#date_picker').show();			
			$('#date_picker_months').hide();
			$('#date_picker_years').hide();
		}else if(val_tampil_per=='BLN'){
			document.getElementById("date_picker").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker").required = false;
			document.getElementById("date_picker_months").required = true;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker').hide();
			$('#cara_bayar').hide();
			$('#date_picker_months').show();
			$('#date_picker_years').hide();
		}else{
			document.getElementById("date_picker").value = '';
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker").required = false;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = true;
			$('#date_picker').hide();
			$('#cara_bayar').hide();
			$('#date_picker_months').hide();
			$('#date_picker_years').show();
		}
	}	

</script>
<style>
hr {
	border-color:#7DBE64 !important;
}

thead {
	background: #c4e8b6 !important;
	background: -moz-linear-gradient(top,  #c4e8b6 0%, #7DBE64 100%) !important;
	background: -webkit-linear-gradient(top,  #c4e8b6 0%,#7DBE64 100%) !important;
	background: linear-gradient(to bottom,  #c4e8b6 0%,#7DBE64 100%) !important;
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c4e8b6', endColorstr='#7DBE64',GradientType=0 )!important;
}
</style>
	
	<!--
	<section class="content-header">
	<legend>Laporan Kunjungan Instalasi Rawat Jalan</legend>
	-->
<br>
<div class="container-fluid"><br/>
	<div class="inline">
		<div class="row">
			<div class="form-inline">
				<?php echo form_open('irj/Rjclaporan/data_kunjungan');?>
				<div class="col-lg-12">
					<div class="form-inline">
						<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
							<option value="TGL">Harian</option>
							<option value="BLN">Bulanan</option>
							<option value="THN">Tahunan</option>
						</select>
						<!--<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Awal" name="tgl_awal" onchange="cek_tgl_awal(this.value)" required>-->
						<input type="text" id="date_picker" class="form-control" placeholder="yyyy-mm-dd" name="tgl" required>
						<input type="text" id="date_picker_months" class="form-control" placeholder="yyyy-mm" name="bulan">
						<input type="text" id="date_picker_years" class="form-control" placeholder="yyyy" name="tahun">
						
						<select name="cara_bayar" id="cara_bayar" class="form-control">
							<option value="SEMUA">SEMUA</option>
							<option value="UMUM">UMUM</option>
							<option value="DIJAMIN / JAMSOSKES">DIJAMIN / JAMSOSKES</option>
							<option value="BPJS">BPJS</option>
						</select>						
						
						<select name="id_poli" class="js-example-basic-single" required>
							<option value="" disabled selected>-Pilih Poli-</option>
							<option value="SEMUA">SEMUA</option>
							<?php 
							foreach($select_poli as $row){
								echo '<option value="'.$row->id_poli.'@'.$row->nm_poli.'">'.$row->nm_poli.'</option>';
							}
							?>
						</select>
						<button class="btn btn-primary" type="submit">Cari</button>
						
					</div>
				</div><!-- /inline -->
				<?php echo form_close();?>
			</div>			
		</div>						
	</div>
</div>
	
<div class="container-fluid"><br/>
	<section class="content">
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading" align="center" >
					<h4 align="center">Laporan Kunjungan <?php echo ($id_poli=="SEMUA" ? "Semua Poliklinik":"Poliklinik ".$nm_poli)." ".$date_title; ?></h4></div>
					<?php if($cara_bayar!='SEMUA'){ ?>
							<h4 align="center"><b> <?php echo $cara_bayar; ?> </b></h4><?php 
						} ?>

					<div class="panel-body">
						<div style="display:block;overflow:auto;">
					
							<?php 
							if ($tampil_per=="TGL") {  
								include("rjvlapkunjungan_harian.php");
							} else if ($tampil_per=="BLN") {
								include("rjvlapkunjungan_bulanan.php");
							} else if ($tampil_per=="THN") {  
								include("rjvlapkunjungan_tahunan.php");
							} 
							
							if (sizeof($data_laporan_kunj)>0) {
							?>
								
							<div class="form-inline" align="right">
								<div class="form-group">
	
									
									<?php
									//SET PASSING PARAM
									$param=$tampil_per;
									if ($tampil_per=="TGL") {
										$param .= "/".$id_poli."/".$tgl."/".$cara_bayar;
									} else if ($tampil_per=="BLN") {
										$param .= "/".$id_poli."/".$bulan;
									} else if ($tampil_per=="THN") {
										$param .= "/".$id_poli."/".$tahun;
									} 
 									?>
						<!-- 			<a target="_blank" href="<?php //echo site_url('irj/rjccetaklaporan/pdf_lapkunj/'.$param);?>"><input type="button" class="btn 
									btn-primary" value="PDF"></a> -->
									<a target="_blank" href="<?php echo site_url('irj/rjcexcel/excel_lapkunj/'.$param);?>"><input type="button" class="btn 
									btn-warning" value="Excel"></a>
									&nbsp;
									
									
									</div>
							<?php 
							} 
							?>
								
							</div>							
						</div><!--- end panel body -->
					</div><!--- end panel body -->
				</div><!--- end panel -->
			</div><!--- end panel -->

		</section>
</div><!--- end container -->
<?php
	$this->load->view('layout/footer.php');
?>

<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2();
});
</script>