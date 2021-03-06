<?php $this->load->view("layout/header"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
<?php 
$this->load->view("iri/layout/script_addon"); 
?>

<script type='text/javascript'>
$(function() {
	 
	// $('#date_picker1').datepicker({
	// 			format: "yyyy-mm-dd",
	// 			//endDate: "current",
	// 			autoclose: true,
	// 			todayHighlight: true,
	// 	});
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
	// $('#date_picker1').show();
	$('#date_picker2').show();
	$('#date_picker_months').hide();
	$('#date_picker_years').hide();

	
});	
function cek_tgl_awal(tgl_awal){
		var tgl_akhir=document.getElementById("date_picker2").value;
		var tgl_akhir=$('#date_picker2').val();
		if(tgl_akhir==''){
		//none :D just none
		}else if(tgl_akhir<tgl_awal){
			$('#date_picker2').val('');
			document.getElementById("date_picker2").value = '';
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
			document.getElementById("date_picker2").required = true;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = false;
			// $('#date_picker1').show();
			$('#date_picker_months').hide();
			$('#date_picker2').show();
			$('#date_picker_years').hide();
		}else if(val_tampil_per=='BLN'){
			// document.getElementById("date_picker1").value = '';
			document.getElementById("date_picker2").value = '';
			document.getElementById("date_picker_years").value = '';
			// document.getElementById("date_picker1").required = false;
			document.getElementById("date_picker2").required = false;
			document.getElementById("date_picker_months").required = true;
			document.getElementById("date_picker_years").required = false;
			// $('#date_picker1').hide();
			$('#date_picker2').hide();
			$('#date_picker_months').show();
			$('#date_picker_years').hide();
		}else{
			// document.getElementById("date_picker1").value = '';
			document.getElementById("date_picker2").value = '';
			document.getElementById("date_picker_months").value = '';
			// document.getElementById("date_picker1").required = false;
			document.getElementById("date_picker2").required = false;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = true;
			// $('#date_picker1').hide();
			$('#date_picker2').hide();
			$('#date_picker_months').hide();
			$('#date_picker_years').show();
		}
	}

</script>

<div>
	<div>
		
		<div class="container-fluid"><br/>
			<div class="inline">
				<div class="row">
					<div class="form-inline">
						<form action="<?php echo base_url();?>iri/ricmedrec/" method="post" accept-charset="utf-8">
						<div class="col-lg-10">
							<div class="form-inline">
								<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
									<option value="TGL">Tanggal</option>
									<option value="BLN">Bulan</option>
								</select>
								<!-- <input type="text" id="date_picker1" class="form-control" placeholder="Pilih Tanggal" name="tgl_awal" onchange="cek_tgl_awal(this.value)" required> -->
								<!-- <input type="text" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="tgl_akhir" onchange="cek_tgl_akhir(this.value)" required> -->
								<input type="text" id="date_picker2" class="form-control" placeholder="Tanggal" name="tgl_akhir" required>
								<input type="text" id="date_picker_months" class="form-control" placeholder="yyyy-mm" name="bulan">
								<input type="text" id="date_picker_years" class="form-control" placeholder="yyyy" name="tahun">
								<button class="btn btn-primary" type="submit">Cari</button>
								
							</div>
						</div>
						</form><!-- /inline -->
					</div>
				</div>						
			</div>
		</div>
			
		<div class="container-fluid"><br/>

		<!-- Keterangan page -->
		<!-- <section class="content-header">
			<h1>Laporan Pendapatan Rawat Inap</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-home"></i> Home</a></li>
				<li><a href="#">Laporan Pendapatan Rawat Inap</a></li>
			</ol>
		</section> -->
		<!-- /Keterangan page -->

		<section class="content">
				<div class="row">
						<div class="panel panel-info">
							<div class="panel-heading" align="center" >Medical Record Pasien<br> 
							</div>
							<div class="panel-body">
								<br/>
						<div >
						<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example" style="display:block;overflow:auto;">
						  <thead>
							<tr>
								<th>No. Register</th>
								<th>Nama</th>
								<th>No MedRec</th>
								<th>Ruang</th>
								<th>Usia</th>
								<th>JK</th>
								<th>Kls</th>
								<th>Tgl Masuk</th>
								<th>Tgl Keluar</th>
								<th>Lama Rawat</th>
								<th>Hari Perawatan</th>
								<th>Dokter</th>
								<th>Diagnosa</th>
								<th>Icd</th>
								<th>Berat Bayi</th>
								<th>Jenis Pasien</th>
								<th>Pangkat</th>
								<th>Kesatuan</th>
								<th>Keterangan</th>
								<th>Aksi</th>
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
						  	foreach ($list_medrec as $r) { ?>
						  	<tr>
						  		<td><?php echo $r['no_ipd']?></td>
						  		<td><?php echo $r['nama']?></td>
						  		<td><?php echo $r['no_medrec_patria']?></td>
						  		<td><?php echo $r['nmruang']?></td>
						  		<td>
						  			<?php
										$interval = date_diff(date_create(), date_create($r['tgl_lahir']));
										echo $interval->format("%Y Tahun, %M Bulan, %d Hari");
									?>
						  		</td>
						  		<td><?php echo $r['sex']?></td>
						  		<td><?php echo $r['klsiri']?></td>
						  		<td>
					  			<?php echo date('d-m-Y',strtotime($r['tgl_masuk']));
						  		?>
						  		</td>
						  		<td>
					  			<?php 
						  		echo date('d-m-Y',strtotime($r['tgl_keluar']));
						  		?>
						  		</td>
					  			<td>
					  			<?php
									 $temp_tgl_awal = strtotime($r['tgl_masuk']);
									 $temp_tgl_akhir = strtotime($r['tgl_keluar']);
								     $diff = $temp_tgl_akhir - $temp_tgl_awal;
								     $diff =  floor($diff/(60*60*24));
								     if($diff == 0){
								     	$diff = 1;
								     }
								     echo $diff;
								?>
						  		</td>
						  		<td><?php echo $diff + 1;?></td>
						  		<td><?php echo $r['dokter']?></td>
						  		<td><?php echo $r['nm_diagnosa'].",".$r['list_diagnosa_tambahan']?></td>
						  		<td><?php echo $r['diagnosa1'] .",".$r['list_id_diagnosa_tambahan']?> </td>
						  		<td><?php echo $r['brtlahir']?></td>
						  		<td><?php echo $r['nmkontraktor']?></td>
						  		<td><?php echo $r['kesatuan']?></td>
						  		<td><?php echo $r['pangkat']?></td>
						  		<td><?php echo $r['jenis_bayar']?></td>
						  		<td>
						  		<?php
						  		if(empty($r['diagnosa1']) || $r['diagnosa1'] == ''){ ?>
						  		<a href="<?php echo base_url(); ?>iri/ricmedrec/lengkapi_medrec/<?php echo $r['no_ipd']?>"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-plusthick"></i> Lengkapi MedRec</button></a>
						  		<?php
						  		}
						  		?>
						  		</td>
						  	</tr>
						  	<?php
						  	}
						  	?>
							</tbody>
						</table>
						<br>
						<div class="form-inline" align="right">
							<div class="form-group">
								<a target="_blank" href="<?php echo site_url('iri/riclaporan/cetak_medrec/');?><?php echo '/'.$tgl.'/'.$type ;?>"><input type="button" class="btn 
								btn-primary" value="Cetak Laporan PDF"></a>
								<a target="_blank" href="<?php echo site_url('iri/riclaporan/cetak_medrec_excel/');?><?php echo '/'.$tgl.'/'.$type ;?>"><input type="button" class="btn 
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

<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
	});

	$('#calendar-tgl').datepicker();
</script>

</div>
<?php $this->load->view("layout/footer"); ?>


