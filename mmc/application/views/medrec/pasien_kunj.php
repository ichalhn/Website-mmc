<?php
	$this->load->view('layout/header.php');
?>
<html>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";

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
	$('.auto_search_by_nocm').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/ird/IrDRegistrasi/data_pasien',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#cari_no_medrec').val(''+suggestion.no_cm);
			$('#no_medrec_baru').val(''+suggestion.no_medrec);
		}
		
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
		url:"<?php echo base_url('lab/labcdaftar/get_banyak_hasil')?>",
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
				<div class="box-header">
					<h3 class="box-title">Pasien RS</h3>
				</div>
				<div class="box-body">
					
					<?php echo form_open('medrec/rjrdcmedrec/patientrecord');?>
					<div class="col-xs-3">
						<div class="input-group">
							<input type="text" class="form-control auto_search_by_nocm" name="no_cm" placeholder="No CM" required>
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
							  	<th>No Register</th>
							  	<th>No CM</th>
							  	<th>Nama</th>
							  	<th>Alamat</th>
							  	<th>Data Rawat</th>
							  	<th>Dokter</th>
							  	<th>Cara Bayar</th>
								<th>Diagnosa</th>
							  	<th>Tanggal Kunjungan</th>
							  	<th>Tanggal Pulang</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
							  	<th>No</th>
							  	<th>No Register</th>
							  	<th>No CM</th>
							  	<th>Nama</th>
							  	<th>Alamat</th>
							  	<th>Data Rawat</th>
							  	<th>Dokter</th>
							  	<th>Cara Bayar</th>
								<th>Diagnosa</th>
							  	<th>Tanggal Kunjungan</th>
							  	<th>Tanggal Pulang</th>
							</tr>
						</tfoot>
						<tbody>
							<?php
								$i=1;
									if($pasien!=''){
									foreach($pasien as $row){
									//$no_register=$row->no_register;
							?>
							<tr>
							  	<td><?php echo $i++;?></td>
							  	<td><?php echo $row->no_register;?></td>
							  	<td><?php echo $row->no_cm;?></td>
							  	<td><?php echo $row->nama;?></td>
							  	<td>
							  		<?php echo $row->alamat?>
							  	</td>
							  	<td>
							  		<?php echo $row->nm_poli;?>
							  	</td>
							  	<td>
							  		<?php  echo $row->nm_dokter; ?>
							  	</td>
							  	<td>
									<?php  echo $row->pasien_bayar; ?>
							 	</td>
								<td>
									<?php  echo $row->diagnosa; ?>
							 	</td>
								<td>
									<?php  echo date('d-m-Y',strtotime($row->tgl_kunjungan)); ?>
							 	</td>
								<td>
									<?php  if($row->tgl_pulang!=null){echo date('d-m-Y',strtotime($row->tgl_pulang));} ?>
							 	</td>
							<?php }} ?>
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
