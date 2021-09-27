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
		$('#tabel_kwitansi1').DataTable();		
	} );

</script>
	
<?php
	echo $this->session->flashdata('message_cetak'); 
?>
<section class="content">
	<div class="row">				
		<div class="box" style="width:97%;margin:0 auto">
			<div class="box-header">
				<h3 class="box-title">Laporan Kunjungan Pasien Tanggal <b><?php echo $date_awal;?></b> s/d <b><?php echo $date_akhir;?></b></h3>			
			</div>
			<div class="box-body">
				<div class="form-group row">
					<div class="col-md-8">
						<?php echo form_open('irj/rjclaporan/kunj_pasien_all');?>
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
					<table id="tabel_kwitansi1" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>Tanggal</th>
							  <th>Total</th>
							  <th>IRD</th>
							  <th>IRJ</th>
							  <th>Masuk Lt 1</th>
							  <th>Masuk Lt 2</th>
							  <th>Masuk Lt 3</th>
							  <th>Keluar Lt 1</th>
							  <th>Keluar Lt 2</th>
							  <th>Keluar Lt 3</th>							  
							</tr>
						</thead>
						<tbody>
						
							<?php
							// print_r($pasien_daftar);
							$i=1;
							foreach($all as $row){
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo date('d-m-Y',strtotime($row->tanggal));?></td>
								
							  <td><?php echo $row->total; ?></td>
								<td><?php echo $row->ird;?></td>
								<td><?php echo $row->irj;?></td>
								<td><?php echo $row->iri_masuk1;?></td>
								<td><?php echo $row->iri_masuk2;?></td>
								<td><?php echo $row->iri_masuk3;?></td>
								<td><?php echo $row->iri_keluar1;?></td>
								<td><?php echo $row->iri_keluar2;?></td>
								<td><?php echo $row->iri_keluar3;?></td>
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
					<a href="<?php echo site_url("irj/rjclaporan/cetak_all/".$date_awal."/".$date_akhir);?>" class="btn btn-primary ">Cetak</a>								
				</div>					
			</div><!-- /panel body -->

			
        </div><!-- /.box-body -->	

			
</section>
<?php
	$this->load->view('layout/footer.php');
?>
