<?php
	$this->load->view('layout/header.php');
?>
<html>
<script type='text/javascript'>
	$(function() {
		$('#example').DataTable();
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
				<!-- <div class="box-header">
					<h3 class="box-title">DAFTAR PASIEN LABORATORIUM</h3>
				</div> -->
				<div class="box-body ">
					<?php echo form_open('lab/labcdaftar/by_date');?>
					<div class="col-xs-3">
						<div class="input-group">
							<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div><!-- /input-group -->
					</div><!-- /col-lg-6 -->
					<?php echo form_close();?>
					<?php echo form_open('lab/labcdaftar/by_no');?>
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

					<?php //echo form_open('lab/labcdaftar/daftar_pasien_luar');?>
					<!-- <div class="col-xs-3" align="right">
						<div class="input-group">
							<span class="input-group-btn">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Registrasi Pasien Luar</button>
							</span>
						</div>
					</div>

					<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
						<div class="modal-dialog modal-success">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Registrasi Pasien Luar</h4>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_nama">Nama</p>
										<div class="col-sm-7">
											<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
											<input type="text" class="form-control" name="nama" id="nama">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_alamat">Alamat</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="alamat" id="alamat">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_dokter">Dokter Rujuk</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="dokter" id="dokter">
										</div>
									</div>

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button class="btn btn-primary" type="submit">Simpan</button>
								</div>
							</div>

						</div>
					</div> -->

					<?php //echo form_close();?>
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
						<tfoot>
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
						</tfoot>
						<tbody>
							<?php
								$i=1;
									foreach($laboratorium as $row){
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
									<a href="<?php echo site_url('lab/labcdaftar/pemeriksaan_lab/'.$no_register); ?>" class="btn btn-primary btn-xs">Tindak</a>
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