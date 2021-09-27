<?php
	$this->load->view('layout/header.php');
?>
<html>
<script type='text/javascript'>
	//-----------------------------------------------Data Table
	$(document).ready(function() {
		$('#example').DataTable();
	} );
	//---------------------------------------------------------

	$(function() {
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true,
		});  
	});

	var intervalSetting = function () {
		location.reload();
	};
	setInterval(intervalSetting, 60000);
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
					<h3 class="box-title">DAFTAR PASIEN OPERASI</h3>
				</div>
				<div class="box-body ">
					<?php echo form_open('ok/okcdaftar/by_date');?>
					<div class="col-xs-3">
						<div class="input-group">
							<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div><!-- /input-group -->
					</div><!-- /col-lg-6 -->
					<?php echo form_close();?>
					<?php echo form_open('ok/okcdaftar/by_no');?>
					<div class="col-xs-3">
						<div class="input-group">
							<input type="text" class="form-control" name="key" placeholder="Nama / No. Register" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div><!-- /input-group -->	
					</div><!-- /col-lg-3 -->
					<?php echo form_close();?>

					<div class="col-xs-3">
					</div><!-- /col-lg-3 -->

					
					<br/>	
					<br/>	
					<table id="example" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>No</th>
							  	<th>Tanggal Kunjungan</th>
							  	<th>No Medrec</th>
							  	<th>No Registrasi</th>
							  	<th>Nama</th>
							  	<th>Kelas</th>
							  	<th>Ruangan</th>
							  	<th>Bed</th>
							  	<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=1;
									foreach($operasi as $row){
									$no_register=$row->no_register;
							?>
							<tr>
								<td><?php echo $i++;?></td>
								<td><?php echo date('d-m-Y | H:i',strtotime($row->tgl_kunjungan));?></td>
								<td><?php echo $row->no_medrec;?></td>
								<td><?php echo $row->no_register;?></td>
								<td><?php echo $row->nama;?></td>
								<td><?php echo $row->kelas;?></td>
								<td><?php echo $row->idrg;?></td>
								<td><?php echo $row->bed;?></td>
							  	<td>
									<a href="<?php echo site_url('ok/okcdaftar/pemeriksaan_ok/'.$no_register); ?>" class="btn btn-primary btn-xs">Tindak</a>
							  	</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<?php
						//echo $this->session->flashdata('message_nodata'); 
					?>								
				</div>
			</div>
		</div>
	</div>
</section>

<?php
	$this->load->view('layout/footer.php');
?>
