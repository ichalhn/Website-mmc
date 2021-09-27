<?php $this->load->view("layout/header"); ?>
<?php 
$this->load->view("iri/layout/script_addon"); 
?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>

<script type='text/javascript'>
$(function() {
	 
	$('#date_picker1').datepicker({
				format: "yyyy-mm-dd",
				//endDate: "current",
				autoclose: true,
				todayHighlight: true,
		});
	$('#date_picker2').datepicker({
				format: "yyyy-mm-dd",
				//endDate: "current",
				autoclose: true,
				todayHighlight: true,
		});
	
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
	$('#date_picker2').show();
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
	//		document.getElementById("date_picker_months").value = '';
	//		document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker1").required = true;
			document.getElementById("date_picker2").required = true;
	//		document.getElementById("date_picker_months").required = false;
	//		document.getElementById("date_picker_years").required = false;
			$('#date_picker1').show();
		//	$('#date_picker_months').hide();
			$('#date_picker2').show();
		//	$('#date_picker_years').hide();
		}else if(val_tampil_per=='BLN'){
			document.getElementById("date_picker1").value = '';
			document.getElementById("date_picker2").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker1").required = false;
			document.getElementById("date_picker2").required = false;
			document.getElementById("date_picker_months").required = true;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker1').hide();
			//$('#date_picker2').hide();
			$('#date_picker_months').show();
			$('#date_picker_years').hide();
		}else{
			document.getElementById("date_picker1").value = '';
			document.getElementById("date_picker2").value = '';
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker1").required = false;
			document.getElementById("date_picker2").required = false;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = true;
			$('#date_picker1').hide();
			$('#date_picker2').hide();
			$('#date_picker_months').hide();
			$('#date_picker_years').show();
		}
	}

</script>

<div >
	<div >
		
		<div class="container-fluid"><br/><br/>
			<div class="inline">
				<div class="row">
					<div class="form-inline">
						<form action="<?php echo base_url();?>irj/rjclaporan/lap_kunj_pasien_detail" method="post" accept-charset="utf-8">
						<div class="col-lg-10">
							<div class="form-inline">
								<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
							<option value="TGL">Periode</option>
							<option value="BLN">Bulanan</option>
							<option value="THN">Tahunan</option>
						</select>
								<input type="text" id="date_picker1" class="form-control" placeholder="Pilih Tanggal" name="tgl_awal" onchange="cek_tgl_awal(this.value)" required>
								<input type="text" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="tgl_akhir" onchange="cek_tgl_akhir(this.value)" required>
 								<button class="btn btn-primary" type="submit">Tampilkan</button>
								
							</div>
						</div><!-- /inline -->
					</div>
					</form>		</div>						
			</div>
		</div>
			
		<div class="container-fluid"><br/>
		<section class="content">
				<div class="row">
						<div class="panel panel-info">
							<div class="panel-heading" align="center" >Laporan Kunjungan Pasien <br> 
							Tanggal <?php echo $tgl_awal; ?> - <?php echo $tgl_akhir; ?>
							</div>
							<div class="panel-body">
								<br/>
						<div style="display:block;overflow:auto;">
						<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
						  <thead>
							<tr>
								<th>Tanggal</th>
								<th>No Register</th>
								<th>No Medrec</th>
								<th>Nama</th>
								<th>Jenis Kelamin</th>
								<th>Poliklinik</th>
								<th>Dokter</th>
								<th>Jenis Pasien</th>
							</tr>
						  </thead>

						  	<tbody>
				<?php
					// $i=0;
					foreach($data_kunjungan as $r){

			//			print_r($data_kunjungan);exit();
					//$vtot=$vtot+$row->jumlah_kunj;
						// if ($row2->id_poli==$row1->id_poli) {						
					?>
	<!-- 				<tr>
						<td> <?php echo $i++;?></td>
						<td> <?php echo $row->tanggal;?></td>
						<td><?php echo $row->no_cm;?></td>
						<td><?php echo strtoupper($row->nama);?></td>					
						<td><?php echo $row->jenis_kelamin;?></td>
						<td><?php echo $row->nama_poli;?></td>
						<td><?php echo $row->nama_dokter;?></td>
						<td><?php echo $row->cara_bayar;?></td>						
					</tr> -->

					<tr>
						<td> <?php echo $r['tanggal'];?></td>
						<td><?php echo $r['no_register'];?></td>
						<td><?php echo $r['no_cm'];?></td>
						<td><?php echo $r['nama'];?></td>					
						<td><?php echo $r['jenis_kelamin'];?></td>
						<td><?php echo $r['nama_poli'];?></td>
						<td><?php echo $r['nama_dokter'];?></td>
						<td><?php echo $r['cara_bayar'];?></td>						
					</tr>
				<?php
						}
					// }
					// $vtot=$vtot+($i-1);
				?>
					<!-- <tr>
						<td colspan="6"><p align="right"><b>Total</b></p></td>
						<td BGCOLOR="yellow"><p align="right"><b><?php echo $i-1;?></b></p></td>
					</tr> -->

							</tbody>
						</table>
						<br>
						<div class="form-inline" align="right">
							<div class="form-group">
								<!--<a target="_blank" href="<?php //echo site_url('iri/riclaporan/cetak_laporan_harian/');?><?php //echo '/'.$tgl_awal ;?>"><input type="button" class="btn 
								btn-primary" value="Cetak Laporan PDF"></a>-->
								<a target="_blank" href="<?php echo site_url('irj/Rjcexcel/excel_lapkunj_detail/');?><?php echo '/'.$tgl_awal.'/'.$tgl_akhir;?>"><input type="button" class="btn 
								btn-primary" value="Cetak Laporan Excel"></a>
							</div>
						</div>
						</div><!-- style overflow -->
					</div><!--- end panel body -->
				</div><!--- end panel -->
				</div><!--- end panel -->
		</section>
		<!-- /Main content -->
		</div>

	</div>
</div>
<script>
	$('#calendar-tgl').datepicker();
</script>

<?php $this->load->view("layout/footer"); ?>
