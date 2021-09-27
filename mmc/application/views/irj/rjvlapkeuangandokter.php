<?php
	$this->load->view('layout/header.php');
?>
<script type='text/javascript'>

$(function() {
	 
	$('.date_picker').datepicker({
				format: "yyyy-mm-dd",
				endDate: "current",
				autoclose: true,
				todayHighlight: true,
	});
});	

function cek_tgl_awal(tgl_awal){
	var tgl_akhir=document.getElementById("tgl_akhir").value;
	if(tgl_akhir==''){
	//none :D just none
	}else if(tgl_akhir<tgl_awal){
		document.getElementById("tgl_akhir").value = '';
	}
}
function cek_tgl_akhir(tgl_akhir){
	var tgl_awal=document.getElementById("tgl_awal").value;
	if(tgl_akhir<tgl_awal){
		document.getElementById("tgl_awal").value = '';
	}
}
	
function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='TGL'){
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker").required = true;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker').show();
			$('#date_picker_months').hide();
			$('#date_picker_years').hide();
			$('#cara_bayar').hide();
		}else if(val_tampil_per=='BLN'){
			document.getElementById("date_picker").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker").required = false;
			document.getElementById("date_picker_months").required = true;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker').hide();
			$('#date_picker_months').show();
			$('#date_picker_years').hide();
			$('#cara_bayar').show();
		}else{
			document.getElementById("date_picker").value = '';
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker").required = false;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = true;
			$('#date_picker').hide();
			$('#date_picker_months').hide();
			$('#date_picker_years').show();
			$('#cara_bayar').show();
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
tr.border_top td {
  border-bottom:1pt solid black;
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
				<?php echo form_open('irj/Rjclaporan/datakeu_dokter');?>
				<div class="col-lg-12">
					<div class="form-inline">
						
						<input type="text" id="tgl_awal" class="form-control date_picker" placeholder="tanggal awal" name="tgl_awal" onchange="cek_tgl_awal(this.value)" required>
						<input type="text" id="tgl_akhir" class="form-control date_picker" placeholder="tanggal akhir" name="tgl_akhir" onchange="cek_tgl_akhir(this.value)" required>
						<select name="id_dokter" id="id_dokter" class="form-control" required>
							<option value="" disabled selected>-Pilih Dokter-</option>
							<option value="SEMUA">SEMUA</option>
							<?php 
							foreach($select_dokter as $row){
								echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'">'.$row->nm_dokter.'</option>';
							}
							?>
						</select>
						<select name="cara_bayar" id="cara_bayar" class="form-control" required>
							<option value="SEMUA">SEMUA TIPE PASIEN</option>
							<option value="UMUM">UMUM</option>
							<option value="PERUSAHAAN">PERUSAHAAN</option>
							<option value="BPJS">BPJS</option>
						</select>
						
						&nbsp;&nbsp;&nbsp;&nbsp;
						<button class="btn btn-primary" type="submit">Cari</button>
						
					</div>
					
				</div><!-- /inline -->
			</div>
			<?php echo form_close();?>
		</div>						
	</div>
</div>
	
<div class="container-fluid"><br/>
	<section class="content">
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading" align="center" >Laporan Pendapatan <?php echo ($id_dokter=="SEMUA" ? "Semua Dokter":"Dokter <b>".$nm_dokter)."</b> ".$date_title; echo ($cara_bayar=='' ? "" : "<br> Tipe Pasien : <b>$cara_bayar</b>"); ?><br/></div>
					<div class="panel-body">
						<div style="display:block;overflow:auto;">
							<?php
							
							include("rjvlapkeuangandokter_harian.php");
							
							if (sizeof($datakeu_dokter)>0){
							?>

		
								<div class="form-inline" align="right">
									<div class="form-group">
									<!--<a target="_blank" href="<?php// echo site_url('irj/rjclaporan/lap_kunj_poli/'.$tgl_awal.'/'.$tgl_akhir);?>"><input type="button" class="btn btn-primary" value="Cetak Detail"></a>-->
									
									<?php
									//SET PASSING PARAM
									$param = $id_dokter."/".$tgl_awal."/".$tgl_akhir."/".$cara_bayar;
									?>
									
									<a target="_blank" href="<?php echo site_url('irj/rjcexcel/excel_lapkeudokter/'.$param);?>"><input type="button" class="btn 
									btn-primary" value="Download Excel"></a>
									&nbsp;
									<a target="_blank" href="<?php echo site_url('irj/rjccetaklaporan/pdf_lapkeudokter/'.$param);?>"><input type="button" class="btn 
									btn-primary" value="Cetak PDF"></a>
									
							<?php 
							} 
							?>
							</div>
						</div>
							
					</div>
				</div><!--- end panel body --->
			</div><!--- end panel --->
		</div><!--- end panel --->
	</section>
</div><!--- end container --->
<?php
	$this->load->view('layout/footer.php');
?>