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

		<section class="content">
				<div class="row">
				<?php echo $this->session->flashdata('pesan');?>
						<div class="panel panel-info">
							
							<div class="panel-body">
								<br/>
						<div style="display:block;overflow:auto;">
						<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
						  <thead>
							<tr>
							  	<th>No. Antri</th>
								<th>No. MedRec</th>
								<th>Reg. Asal</th>
								<th>Tanggal Daftar</th>
								<th>Nama</th>
								<th>Ruang</th>
								<th>Kelas</th>
								<th>Infeksi</th>
								<th>Prioritas</th>
								<th>Ren. Masuk</th>
								<th>Aksi</th>
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
						  	foreach ($list_reservasi_all as $r) { ?>
						  	<tr>
						  		<td><?php echo $r['noreservasi'];?></td>
						  		<td><?php echo $r['no_cm'];?></td>
						  		<td><?php echo $r['no_register_asal'];?></td>
						  		<td>
						  		<?php 
						  			echo date('d-m-Y',strtotime($r['tglreserv']));
						  		?>
						  		</td>
						  		<td><?php echo $r['nama'];?><br>
						  		<?php echo $r['no_hp'];?></td>
						  		<td><?php echo $r['nmruang'];?></td>
						  		<td><?php echo $r['kelas'];?></td>
						  		<td><?php echo $r['infeksi'];?></td>
						  		<td><?php echo $r['prioritas'];?></td>
						  		<td>
					  			<?php 
						  			echo date('d-m-Y',strtotime($r['tglrencanamasuk']));
						  		?>
						  		</td>
						  		<td>
						  		<?php
						  		if($r['tppri']=='rawatjalan'){
									$link=base_url().'iri/ricpendaftaran/index/'.$r['noreservasi'];
								}else if($r['tppri']=='rawatdarurat'){
									$link=base_url().'iri/ricpendaftaran/index/'.$r['noreservasi'];
								}else{
									$link=base_url().'iri/ricmutasi/index/'.$r['noreservasi'];
								}
						  		?>
						  		<a href="<?php echo $link; ?>"><button type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Setujui</button></a> 
						  		<?php 
						  		if(substr($r['no_register_asal'], 0,2) == "RI"){ ?>
						  		<a href="<?php echo base_url(); ?>iri/ricdaftar/batal_mutasi/<?php echo $r['noreservasi'] ; ?>"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Batal</button></a>
						  		<?php
						  		}else{ ?>
						  		<a href="<?php echo base_url(); ?>iri/ricdaftar/batal_reservasi/<?php echo $r['noreservasi'] ; ?>"><button type="button" class="btn btn-danger btn-xs"><i class="fa fa-remove"></i> Batal</button></a>
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
