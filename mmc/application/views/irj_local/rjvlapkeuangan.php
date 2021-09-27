<?php $this->load->view("layout/header"); ?>
<?php // include('script_laprdpendapatan.php');	?>

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

<script type='text/javascript'>
	$(document).ready(function () {	
		$('#tanggal_laporan').daterangepicker({
          	opens: 'left',
			format: 'DD/MM/YYYY',
			startDate: moment(),
          	endDate: moment(),
		});
		var startDate = $('#tanggal_laporan').data('daterangepicker').startDate;
		var endDate = $('#tanggal_laporan').data('daterangepicker').endDate;
		startDate = startDate.format('YYYY-MM-DD');
		endDate = endDate.format('YYYY-MM-DD');
		$('#tanggal_awal').val(startDate);

		$('#tanggal_akhir').val(endDate);


		$('#tab_lapkeu').DataTable();

		$('#tgl_awal').datepicker({
		format: "yyyy-mm-dd",
		
		autoclose: true,
		todayHighlight: true,
		});
		$('#tgl_akhir').datepicker({
		format: "yyyy-mm-dd",
		
		autoclose: true,
		todayHighlight: true,
		});
    });
	
	function cek(){
		var startDate = $('#tanggal_laporan').data('daterangepicker').startDate;
		var endDate = $('#tanggal_laporan').data('daterangepicker').endDate;
		startDate = startDate.format('YYYY-MM-DD');
		endDate = endDate.format('YYYY-MM-DD');
		poli = document.getElementById("id_poli").value;
		$.ajax({
				type:'POST',
				dataType: 'json',
				url:"<?php echo base_url('irj/rjclaporan/cek_lapkeu')?>",
				data: {
					tanggal_awal : startDate,
					tanggal_akhir : endDate,
					poli : poli
				},
				success:function(data){
        			console.log(data);
           		}
			});
	}

	function download(){	
		var startDate = $('#tanggal_laporan').data('daterangepicker').startDate;
		var endDate = $('#tanggal_laporan').data('daterangepicker').endDate;
		startDate = startDate.format('YYYY-MM-DD')
		endDate = endDate.format('YYYY-MM-DD')
		// date = document.getElementById('reservation');
		// alert(startDate);
		swal({
		  title: "Download?",
		  text: "Download Laporan Keuangan Rawat Jalan!",
		  type: "warning",
		  showCancelButton: true,
	  	  showLoaderOnConfirm: false,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Ya!",
		  cancelButtonText: "Tidak!",
		  closeOnConfirm: false,
		  closeOnCancel: false
		},
		function(isConfirm){
		  if (isConfirm) {
		 //    $.ajax({
			// 	type:'POST',
			// 	dataType: 'json',
			// 	url:"<?php echo base_url('irj/rjcexcel/export_excel')?>",
			// 	data: {
			// 		tanggal_awal : startDate,
			// 		tanggal_akhir : endDate
			// 	},
			// 	success: function(data){
		 //    swal("Download", "Sukses", "success");
			// 	},
			// 	error: function(){
			// 		alert("error");
			// 	}
			// });
			///TGL/$id_poli/$tgl0/$status/$cara_bayar/$tgl1
			poli = document.getElementById("id_poli").value;
			swal("Download", "Sukses", "success");
			window.open("<?php echo base_url('irj/rjcexcel/excel_lapkeu/TGL')?>/"+poli+"/"+startDate+"/10/SEMUA/"+endDate);
		  } else {
		    swal("Close", "Tidak Jadi", "error");
			document.getElementById("ok1").checked = false;
		  }
		});
		
		
	}	
</script>

<section class="content-header">
	<?php //include('pend_cari.php');	?>


</section>

<section class="content">
	<div class="row">
	
		<div class="panel panel-default" style="width:97%;margin:0 auto">
			<div class="panel-heading">		
				<h4  align="center">Download Laporan Keuangan Rawat Jalan</h4>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="form-group">
						
				              <!-- Date range -->
						<div class="col-lg-5">
				        	<div class="input-group">
				          	<div class="input-group-addon">
				            	<i class="fa fa-calendar"></i>
				          	</div>
				          		<input type="text" class="form-control pull-right" id="tanggal_laporan" name="tanggal_laporan">
				        	</div>
				        	<!-- <input type="text" class="" id="tanggal_awal" name="tanggal_awal" hidden>
				        	<input type="text" class="" id="tanggal_akhir" name="tanggal_akhir" hidden> -->

				        	<!-- /.input group -->
				      	</div>
				      	<div class="col-lg-5">
					      	<select id="id_poli" name="id_poli" class="form-control select2" required>
								<option value="" disabled selected>-Pilih Poli-</option>
								<option value="SEMUA">SEMUA</option>
								<?php 
								foreach($select_poli as $row){
									echo '<option value="'.$row->id_poli.'">'.$row->nm_poli.'</option>';
								}
								?>
							</select>
						</div>
						
						<div class="col-lg-2">
							<span class="input-group-btn">
								<!-- <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit">Cari</button> -->
								<button class="btn btn-primary pull-right" type="button" onclick="download()">Download</button>
							</span>
						</div>
					</div>				
				</div>
			</div>
		</div>
		</form>
		</div>
		<br>
		<div class="panel panel-default" style="width:100%;margin:0 auto">
		<div class="panel-heading">
			<h4 align="center">Cek Laporan Keuangan Rawat Jalan</h1>
		</div>
			<div class="panel-body">
			<div class="row">
			<form action="<?php echo base_url('irj/rjclaporan/cek_lapkeu')?>" method="post">
				<div class="form-group">
					<label  class="col-sm-1 form-control-label">Dari</label>
					<div class="col-md-2">
						<div class="input-group">
							<div class="input-group-addon">
				            	<i class="fa fa-calendar"></i>
				          	</div>
							<input type="input" class="form-control" id="tgl_awal" name="tgl_awal"/>	
						</div>
						
					</div>
					<label  class="col-sm-1 form-control-label">Sampai</label>
					<div class="col-md-2">
						<div class="input-group">
							<div class="input-group-addon">
				            	<i class="fa fa-calendar"></i>
				          	</div>
							<input type="input" class="form-control" id="tgl_akhir" name="tgl_akhir"/>	
						</div>
						
					</div>
					<div class="col-md-1">
							<span class="input-group-btn">
								<!-- <button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit">Cari</button> -->
								<button class="btn btn-primary pull-right" type="submit" onclick="">Cek</button>
					</span>
					</div>
				</div>
			</div>
			</form>
			<br>
				<div class="row">
			<table class="table table-responsive" id="tab_lapkeu">
				  <thead>
					<tr>
								  <th><p align="center">No</p></th>
								  <th><p align="center">Poliklinik</p></th>
								  <th><p align="center">No Medrec</th>
								  <th><p align="center">No Reg</th>
								  <th><p align="center">Nama</th>
								  <th><p align="center">Status Pulang</th>
								  <th><p align="center">Cara Bayar</th>
								  <th><p align="center">Biaya Tindakan</th>
								  <th><p align="center">Lab</th>
								  <th><p align="center">Rad</th>
								  <th><p align="center">Obat</th>
								  <th><p align="center">Operasi</th>
								  <th><p align="center">Total</th>
								  <th><p align="center">Tunai</th>
								  <th><p align="center">Diskon</th>
					</tr>
					</thead>
							  
					<tbody>
							 
						<?php
						
							$i=1;
							foreach($data_laporan_keuangan as $row){
							$total = 0;
							$total = $row->vtot + $row->vtot_lab + $row->vtot_rad + $row->vtot_obat + $row->vtot_ok;				
						?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $row->nm_poli; ?></td>
							<td><?php echo $row->no_cm; ?></td>
							<td><?php echo $row->no_register; ?></td>
							<td><?php echo $row->nama; ?></td>
							<td><?php echo $row->status; ?></td>
							<td><?php echo $row->cara_bayar; ?></td>
							<td><?php echo $row->vtot; ?></td>
							<td><?php echo $row->vtot_lab; ?></td>
							<td><?php echo $row->vtot_rad; ?></td>
							<td><?php echo $row->vtot_obat; ?></td>
							<td><?php echo $row->vtot_ok; ?></td>
							<td><?php echo $total ?></td>
							<td><?php echo $row->tunai; ?></td>
							<td><?php echo $row->diskon; ?></td>
						</tr>
						<?php
						$i++;
							}
						?>
									
					</tbody>
				</table>
				</div>
			</div>
		</div>
		
</section>
<?php $this->load->view("layout/footer"); ?>
