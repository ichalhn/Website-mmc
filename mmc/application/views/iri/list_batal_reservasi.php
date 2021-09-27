<?php $this->load->view("layout/header"); ?>
<?php $this->load->view("iri/layout/script_addon"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
<script>
var site = "<?php echo site_url(); ?>";
$(function(){
	$('.date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
	});  
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
		
		<section class="content">
				<div class="row">
				<?php echo $this->session->flashdata('pesan');?>
						<div class="panel panel-info">
							
							<div class="panel-body">
								<?php echo form_open('iri/ricreservasi/list_batal');?>
					
								<div class="form-inline">
									<input type="text" id="date_picker" class="form-control date_picker" placeholder="Tanggal Awal" name="date0">
									&nbsp;&nbsp;s/d&nbsp;&nbsp;
									<input type="text" id="date_picker" class="form-control date_picker" placeholder="Tanggal Akhir" name="date1">
									&nbsp;&nbsp;									
									<button class="btn btn-primary" type="submit">Cari</button>
									</div>
								<?php echo form_close();?>
								<hr>
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
								<th>Ren. Masuk</th>
								<th>Aksi</th>
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
						  	foreach ($list_batal_antrian as $r) { ?>
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
						  		<td>
					  			<?php 
						  			echo date('d-m-Y',strtotime($r['tglrencanamasuk']));
						  		?>
						  		</td>
						  		<td>
						  		<?php if($r['stat']==0){
						  			$link=base_url().'iri/ricreservasi/undo_antrian/'.$r['noreservasi'];?>
						  			<a href="<?php echo $link; ?>"><button type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Kembalikan</button></a>
						  		<?php
									}	
						  		?>
						  		 						  		
						  		</td>
						  	</tr>
						  	<?php
						  	}
						  	?>

						  	<?php
						  	foreach ($list_batal_reservasi as $r) { ?>
						  	<tr>
						  		<td><?php echo '-';?></td>
						  		<td><?php echo $r['no_cm'];?></td>
						  		<td><?php echo $r['no_register'];?></td>
						  		<td>
						  		<?php 
						  			echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
						  		?>
						  		</td>
						  		<td><?php echo $r['nama'];?><br>
						  		<?php echo $r['no_hp'];?></td>
						  		<td><?php echo $r['nmruang'];?></td>
						  		<td><?php echo $r['kelas_pasien'];?></td>
						  		
						  		<td>
					  			<?php 
						  			echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
						  		?>
						  		</td>
						  		<td>
						  		<?php if($r['stat']==0){
						  			$link=base_url().'iri/ricreservasi/undo_reservasi/'.$r['no_register'];?>
						  			<a href="<?php echo $link; ?>"><button type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i> Kembalikan</button></a>
						  		<?php } ?>
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
