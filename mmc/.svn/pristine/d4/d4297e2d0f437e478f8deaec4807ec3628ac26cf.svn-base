<?php $this->load->view("layout/header"); ?>
<?php $this->load->view("iri/layout/script_addon"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
<script>
var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto-ruang').autocomplete({
		serviceUrl: site+'/iri/ricreservasi/data_ruang',
		onSelect: function (suggestion) {
			$('#kode-ruang-pilih').val(''+suggestion.idrg);
			$('#nama-ruang-pilih').val(''+suggestion.nmruang);
		}
	});
});
</script>
<div>
	<div >
		
		<!-- Keterangan page -->
		<section class="content-header">
			<h1>DAFTAR ANTRIAN RESERVASI</h1>			
		</section>
		<!-- /Keterangan page -->

		<section class="content" style="width:98%;" >
				<div class="row">
				<?php echo $this->session->flashdata('pesan');?>
						<div class="panel panel-info">
							
							<div class="panel-body">
								<br/>
						<div style="display:block;overflow:auto;">
						<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
						  <thead>
							<tr>
								<th>Registrasi Asal</th>
								<th width="7%">Tanggal Kunjungan</th>
								<th>Nama</th>
								<th>No Medrec</th>
								<th width="13%">Data Pasien</th>
								<th>Poli Asal</th>
								<th>Dokter</th>
								<th>Diagnosa</th>
								<th>Aksi</th>
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
						  	foreach ($data_irj as $r) { ?>
						  	<tr>
						  		<td>
							  		Rawat Jalan<br>
							  		<?php echo $r['no_register'];?>
						  		</td>
						  		<td>
						  		<?php
						  			echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
						  		?>
						  		</td>
						  		<td><?php echo $r['nama'];?></td>
						  		<td><?php echo $r['no_cm'];?></td>
						  		<td>
						  			<?php if($r['sex']=='P'){
						  				echo 'Perempuan';} else {
						  				echo 'Laki-laki';}?><br>
						  			<?php echo date('d-m-Y',strtotime($r['tgl_lahir']));?><br>
						  			<?php echo $r['no_telp'];?>
						  		</td>
						  		<td><?php echo $r['id_poli']." - ".$r['nm_poli'];?></td>
						  		<td><?php echo $r['nama_dokter'];?></td>
						  		<td><?php echo $r['id_diagnosa']." ".$r['diagnosa'];?></td>
						  		<td><a href="<?php echo base_url(); ?>iri/ricreservasi/reservasi_from_list/<?php echo $r['no_register']; ?>"><button type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Reservasi</button></a>
						  		<a href="<?php echo base_url(); ?>iri/ricreservasi/batal/<?php echo $r['no_register']; ?>"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-close"></i> Batal</button></a></td>
						  	</tr>
						  	<?php
						  	}
						  	?>
						  	<?php
						  	foreach ($data_ird as $r) { ?>
						  	<tr>
						  		<td>
						  			Rawat Darurat<br>
						  			<?php echo $r['no_register'];?>
						  		</td>
						  		<td>
						  		<?php
						  			echo substr($r['tgl_kunjungan'],0,10);
						  		?>
						  		</td>
						  		<td><?php echo $r['nama'];?></td>
						  		<td><?php echo $r['no_cm'];?></td>
						  		<td>
						  			<?php if($r['sex']=='P'){
						  				echo 'Perempuan';} else {
						  				echo 'Laki-laki';}?><br>
						  			<?php echo $r['tgl_lahir'];?><br>
						  			<?php echo $r['no_telp'];?>
						  		</td>
						  		<td>BB99 - POLI UGD</td>
						  		<td><?php echo $r['nm_dokter'];?></td>
						  		<td><?php echo $r['id_diagnosa']." ".$r['diagnosa_utama'];?></td>
						  		<td><a href="<?php echo base_url(); ?>iri/ricreservasi/reservasi_from_list/<?php echo $r['no_register']; ?>"><button type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Reservasi</button></a></td>
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
		
		<!-- Modal -->
		<div class="modal fade bs-example-modal-sm" id="modal-batal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
					</div>
					<div class="modal-body">
						Apakah kamu yakin ingin mengapprove ini?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-remove"></i> Tidak</button>
						<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Ya</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /Modal -->
		
	</div>
</div>
<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
	});
</script>
<?php $this->load->view("layout/footer"); ?>
