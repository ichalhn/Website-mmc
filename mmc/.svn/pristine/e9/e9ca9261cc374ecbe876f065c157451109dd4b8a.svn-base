<?php
	$this->load->view('layout/header.php');
?>

<script type='text/javascript'>
var intervalSetting = function () { 
location.reload(); 
}; 
setInterval(intervalSetting, 120000);

	$(function() {
		$('#date_picker1').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		}); 
		$('#date_picker2').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		}); 
	});
	
	$(document).ready(function() {
		$('#tabel_kwitansi').DataTable();
		$('#daful_ird').DataTable();
		$('#daful_irj').DataTable();
		$('#tind_ird').DataTable();
		$('#tind_irj').DataTable();
	} );

</script>
	
<?php
	echo $this->session->flashdata('message_cetak'); 
?>
<section class="content">
	<div class="row">				
		<div class="box" style="width:97%;margin:0 auto">
			<div class="box-header">
				<h3 class="box-title">Daftar User Input Pasien <b><?php echo $date_awal;?></b> s/d <b><?php echo $date_akhir;?></b></h3>			
			</div>
			<div class="box-body">
				<div class="form-group row">
					<div class="col-md-8">
						<?php echo form_open('user/cuser/');?>
							<div class="form-group ">
								<input type="text" id="date_picker1" class="form-control" placeholder="Tanggal Awal" name="date0">
								<input type="text" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="date1">
								<span class="input-group-btn">
									<button class="btn btn-primary" type="submit">Cari</button>
								</span>
							</div><!-- /input-group -->
						<?php echo form_close();?>
					</div><!-- /.col-lg-6 -->
						
				</div><!-- /inline -->
				
				<hr>
					<table id="tabel_kwitansi" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>Total</th>
							  <th>User</th>							  
							</tr>
						</thead>
						<tbody>
						
							<?php
							// print_r($pasien_daftar);
							$i=1;
							foreach($user_pasien as $row){
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo $row->total; ?></td>
							  <td><?php echo $row->xuser;?></td>
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
				<div class="form-inline " align="right" style="padding:30px;">
					<a href="<?php echo site_url("user/cuser/cetak/new/".$date_awal."/".$date_akhir);?>" class="btn btn-primary ">Cetak</a>								
				</div>					
			</div><!-- /panel body -->

			
        </div><!-- /.box-body -->	

			
</section>



<section class="content">
	<div class="row">				
		<div class="box" style="width:97%;margin:0 auto">
			<div class="box-header">
				<h3 class="box-title">Daftar User Input Daftar Ulang Pasien IRD <b><?php echo $date_awal;?></b> s/d <b><?php echo $date_akhir;?></b></h3>			
			</div>
			<div class="box-body">								
				<hr>
					<table id="daful_ird" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>Total</th>
							  <th>User</th>							  
							</tr>
						</thead>
						<tbody>
						
							<?php
							// print_r($pasien_daftar);
							$i=1;
							foreach($user_pasien as $row){
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo $row->total; ?></td>
							  <td><?php echo $row->xuser;?></td>
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
				<div class="form-inline " align="right" style="padding:30px;">
					<a href="<?php echo site_url("user/cuser/cetak/dird/".$date_awal."/".$date_akhir);?>" class="btn btn-primary ">Cetak</a>								
				</div>					
			</div><!-- /panel body -->

			
        </div><!-- /.box-body -->	

			
</section>

<section class="content">
	<div class="row">				
		<div class="box" style="width:97%;margin:0 auto">
			<div class="box-header">
				<h3 class="box-title">Daftar User Input Daftar Ulang Pasien IRJ <b><?php echo $date_awal;?></b> s/d <b><?php echo $date_akhir;?></b></h3>			
			</div>
			<div class="box-body">				
				<hr>
					<table id="daful_irj" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>Total</th>
							  <th>User</th>							  
							</tr>
						</thead>
						<tbody>
						
							<?php
							// print_r($pasien_daftar);
							$i=1;
							foreach($daful_irj as $row){
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo $row->total; ?></td>
							  <td><?php echo $row->xuser;?></td>
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
				<div class="form-inline " align="right" style="padding:30px;">
					<a href="<?php echo site_url("user/cuser/cetak/dirj/".$date_awal."/".$date_akhir);?>" class="btn btn-primary ">Cetak</a>								
				</div>							
			</div><!-- /panel body -->

			
        </div><!-- /.box-body -->	

			
</section>

<section class="content">
	<div class="row">				
		<div class="box" style="width:97%;margin:0 auto">
			<div class="box-header">
				<h3 class="box-title">Daftar User Input Tindakan Pasien IRD <b><?php echo $date_awal;?></b> s/d <b><?php echo $date_akhir;?></b></h3>			
			</div>
			<div class="box-body">								
				<hr>
					<table id="tind_ird" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>Total</th>
							  <th>User</th>							  
							</tr>
						</thead>
						<tbody>
						
							<?php
							// print_r($pasien_daftar);
							$i=1;
							foreach($tind_ird as $row){
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo $row->total; ?></td>
							  <td><?php echo $row->xuser;?></td>
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
				<div class="form-inline " align="right" style="padding:30px;">
					<a href="<?php echo site_url("user/cuser/cetak/tird/".$date_awal."/".$date_akhir);?>" class="btn btn-primary ">Cetak</a>								
				</div>
			</div><!-- /panel body -->

			
        </div><!-- /.box-body -->	

			
</section>

<section class="content">
	<div class="row">				
		<div class="box" style="width:97%;margin:0 auto">
			<div class="box-header">
				<h3 class="box-title">Daftar User Input Tindakan Pasien IRJ <b><?php echo $date_awal;?></b> s/d <b><?php echo $date_akhir;?></b></h3>			
			</div>
			<div class="box-body">				
				<hr>
					<table id="tind_irj" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>Total</th>
							  <th>User</th>							  
							</tr>
						</thead>
						<tbody>
						
							<?php
							// print_r($pasien_daftar);
							$i=1;
							foreach($tind_irj as $row){
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo $row->total; ?></td>
							  <td><?php echo $row->xuser;?></td>
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
				<div class="form-inline " align="right" style="padding:30px;">
					<a href="<?php echo site_url("user/cuser/cetak/tirj/".$date_awal."/".$date_akhir);?>" class="btn btn-primary ">Cetak</a>								
				</div>					
			</div><!-- /panel body -->

			
        </div><!-- /.box-body -->	

			
</section>



<?php
	$this->load->view('layout/footer.php');
?>
