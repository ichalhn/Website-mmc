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
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  
		
});

var intervalSetting = function () {
	location.reload();
};
setInterval(intervalSetting, 120000);

function get_hasil(no_register) {
   // alert("<?php echo site_url('irj/rjcpelayanan/get_biaya_tindakan'); ?>");
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('rad/radcdaftar/get_banyak_hasil')?>",
		data: {
			no_register: no_register
		},
		success: function(data){
			//alert(data);
			$('#biaya_lab').val(data);
			$('#biaya_lab_hide').val(data);
		},
		error: function(){
			alert("error");
		}
    });
}

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
					<h3 class="box-title"><a href="<?php echo site_url('rad/radcdaftarhasil'); ?>">DAFTAR HASIL RADIOLOGI</a></h3>
				</div> -->
				<div class="box-body">
					<?php echo form_open('rad/radcdaftarhasil/by_date');?>
					<div class="col-xs-3">
						<div class="input-group">
							<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div><!-- /input-group -->
					</div><!-- /col-lg-6 -->
					<?php echo form_close();?>
					<?php echo form_open('rad/radcdaftarhasil/by_no');?>
					<div class="col-xs-4">
						<div class="input-group">
							<input type="text" class="form-control" name="key" placeholder="Nama / No. Register / No. MR" required>
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
							  	<th width="8px">No</th>
							  	<th width="80px">Tanggal Pemeriksaan</th>
							  	<th width="50px">No Dia</th>
							  	<th width="50px">No Register</th>
							  	<th width="50px">No MR</th>
							  	<th width="200px">Nama</th>
							  	<th>Banyak Pemeriksaan</th>
							  	<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$i=1;
									foreach($radiologi as $row){
									$no_register=$row->no_register;
							?>
							<tr>
							  	<td><?php echo $i++;?></td>
							  	<td><?php echo $row->tgl;?></td>
							  	<td><?php echo $row->no_rad;?></td>
							  	<td><?php echo $row->no_register;?></td>
							  	<td><?php echo $row->no_medrec;?></td>
							  	<td><?php echo $row->nama;?></td>
							  	<td>
							  		<?php echo $row->banyak;?>
							  	</td>
							  	<td>
									<a href="<?php echo site_url('rad/radcdaftarhasil/cetak_hasil_rad/'.$row->no_rad); ?>" class="btn btn-primary btn-xs" target="_blank">Lihat Hasil Diagnostik</a>
							 	</td>
							<?php } ?>
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