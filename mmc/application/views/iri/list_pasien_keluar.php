<?php $this->load->view("layout/header"); ?>
<?php $this->load->view("iri/layout/script_addon"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
<div >
	<div >
		
		<!-- Keterangan page -->
		<section class="content-header">
			<h1>PASIEN KELUAR</h1>			
		</section>
		<!-- /Keterangan page -->

        <!-- Main content -->
        <!-- <section class="content">
			<div class="row">
				<div class="col-sm-12">
					
				
					<div class="box box-success">
						<br/>
						<div class="box-body">
							<table id="dataTables-example" class="table table-bordered table-striped data-table">
								<thead>
									<tr>
										<th>Tgl. Masuk</th>
										<th>No. Register</th>
										<th>Nama</th>
										<th>Kelas</th>
										<th>No. Bed</th>
										<th>Penjamin</th>
										<th>Dokter Yang Merawat</th>
										<th>LOS</th>
										<th>Total Biaya</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
					
					
				</div>
			</div>
		</section> -->

		<section class="content">
				<div class="row">
						<div class="panel panel-info">
							<div class="panel-body">
								<br/>
						<div style="display:block;overflow:auto;">
						<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
						  <thead>
							<tr>
								<th>No. Register</th>
								<th>No. Medical Record</th>
								<th>Nama</th>
								<th>Kelas</th>
								<th>No. Bed</th>
								<th>Tgl. Masuk</th>
								<th>Jenis Pasien</th>
								<th>Dokter Yang Merawat</th>							
								<th>Aksi</th>
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
						  	foreach ($list_pasien as $r) { ?>
						  	<tr>
						  		<td><?php echo $r['no_ipd']?></td>
						  		<td><?php echo $r['no_cm']?></td>
						  		<td><?php echo $r['nama']?></td>
						  		<td><?php echo $r['kelas']?></td>
						  		<td><?php echo $r['bed']?></td>
						  		<td>
						  		<?php 						  		
						  		echo date('d F Y', strtotime($r['tglmasukrg']));
						  		?>
						  		</td>
						  		<td><?php echo $r['carabayar']?></td>
						  		<td><?php echo $r['dokter']?></td>
						  		<!--<td><?php echo number_format($r['vtot']+$r['vtot_lab']+$r['vtot_pa']+$r['vtot_rad']+$r['vtot_obat'],0);?></td>-->
						  		<td>
						  		<a href="<?php echo base_url(); ?>iri/rickwitansi/detail_kwitansi/<?php echo $r['no_ipd']?>"><button type="button" class="btn btn-default btn-sm"><i class="fa fa-book"></i></button></a>
						  		</td>
						  	</tr>
						  	<?php
						  	}
						  	?>
							</tbody>
						</table>
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
