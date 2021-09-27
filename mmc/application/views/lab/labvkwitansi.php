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
					<h3 class="box-title">DAFTAR KWITANSI</h3>
				</div>
				<div class="box-body">
					<?php echo form_open('lab/labckwitansi/kwitansi_by_date');?>
					<div class="col-xs-3">
						<div class="input-group">
							<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div><!-- /input-group -->
					</div><!-- /col-lg-6 -->
					<?php echo form_close();?>
					<?php echo form_open('lab/labckwitansi/kwitansi_by_no');?>
					<div class="col-xs-3">
						<div class="input-group">
							<input type="text" class="form-control" name="key" placeholder="Nama / No. Register" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div><!-- /input-group -->	
					</div><!-- /col-lg-6 -->
					<?php echo form_close();?>
					<br/>	
					<br/>	
					<table id="example" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>No Pemeriksaan Lab</th>
							  <th>Tanggal Pemeriksaan</th>
							  <th>No Registrasi</th>
							  <th>No Medrec</th>
							  <th>Nama</th>
							  <th>Banyak Pemeriksaan</th>
							  <th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						
						<?php
							// print_r($pasien_daftar);
							$i=1;
							foreach($daftar_lab as $row){
								$no_lab=$row->no_lab;
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo $row->no_lab; ?></td>
							  <td><?php echo $row->tgl; ?></td>
							  <td><?php echo $row->no_register;?></td>
							  <td><?php echo $row->no_cm;?></td>
							  <td><?php echo $row->nama;?></td>
							  <td><?php echo $row->banyak;?></td>
							  <td>
									<a href="<?php echo site_url('lab/labckwitansi/kwitansi_pasien/'.$no_lab); ?>" class="btn btn-default btn-sm"><i class="fa fa-book"></i></a>
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