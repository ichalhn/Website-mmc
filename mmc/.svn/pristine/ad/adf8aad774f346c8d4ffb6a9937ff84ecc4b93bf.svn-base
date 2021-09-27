<?php
	$this->load->view('layout/header.php');
?>

<script type='text/javascript'>
	$(function() {
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});  
	});
	
	$(document).ready(function() {
		$('#tabel_kwitansi').DataTable();
	} );
	//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#example').DataTable();
} );
//---------------------------------------------------------

</script>

<section class="content-header">
	<?php
		echo $this->session->flashdata('success_msg');
	?>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Rekap Tanggal <b><?php echo $date;?></b></h3>			
				</div>
				<div class="box-body">
					<div class="form-group row">
						<div class="col-md-3">
							<?php echo form_open('faktur/fcrekap/frm');?>
								<div class="input-group">
									<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date">
									<span class="input-group-btn">
										<button class="btn btn-primary" type="submit">Cari</button>
									</span>
								</div><!-- /input-group -->
							<?php echo form_close();?>
						</div><!-- /.col-lg-6 -->
							
					</div><!-- /inline -->
					<hr>
					<table id="example" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>No Resep</th>
							  <th>Tanggal Permintaan</th>
							  <th>No Registrasi</th>
							  <th>Nama</th>
							  <th>Banyak</th>
							  <th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						
						<?php
							// print_r($pasien_daftar);
							$i=1;
							foreach($daftar_farmasi as $row){
								$no_resep=$row->no_resep;
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo $row->no_resep; ?></td>
							  <td><?php echo $row->tgl; ?></td>
							  <td><?php echo $row->no_register;?></td>
							  <td><?php echo $row->nama;?></td>
							  <td><?php echo $row->banyak;?></td>
							  <td>
									<a href="<?php echo site_url('faktur/fcrekap/faktur_frm/SKT_'.$no_resep.'.pdf'); ?>" target="_blank"class="btn bg-orange btn-sm" style="width:63px; margin:2px;">Faktur</a>
									<a href="<?php echo site_url('faktur/fcrekap/kwitansi_frm/KWI_'.$no_resep.'.pdf'); ?>" target="_blank" class="btn btn-primary btn-sm" style="width:63px; margin:2px;">Kwitansi</a>
							  </td>
							</tr>
						<?php
							}
						?>
						</tbody>
					</table>
					<?php
						//echo $this->session->flashdata('message_nodata'); 
					?>								
				</div>
			</div>
		</div>
</section>

<?php
	$this->load->view('layout/footer.php');
?>