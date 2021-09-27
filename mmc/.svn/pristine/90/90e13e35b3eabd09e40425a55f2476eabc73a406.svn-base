<?php
	$this->load->view('layout/header.php');
?>

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

function selesai_pengambilan(no_resep) {
	var r = confirm("Anda Yakin Resep Telah Selesai?");
	if (r == true) {
	   $.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('farmasi/Frmcdaftar/selesai_pengambilan')?>",
			data: {
				no_resep: no_resep
			},
			success: function(data){
				//alert(data);
				location.reload();
			},
			error: function(){
				alert("error");
			}
	    });
	   return true;
	} else {
	    return false;
	}
	
 	// alert('Tes Alert'+no_resep);
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
					<h3 class="box-title">DAFTAR PENGAMBILAN RESEP PASIEN</h3>
				</div>
				<div class="box-body">
					<table id="example" class="display" cellspacing="0" width="100%">
						  <thead>
							<tr>
								<th>No</th>
								<th>Tanggal Kunjungan</th>
								<th>No Resep</th>
								<th>No Registrasi</th>
								<th>Nama</th>
								<th>Kelas</th>
								<th>Ruangan</th>
								<th>Bed</th>
								<th>Cara Bayar</th>
								<th>Aksi</th>
							</tr>
						  </thead>
						  <tbody>
							
							<?php
							// print_r($pasien_daftar);
								$i=1;
								foreach($farmasi as $row){
									$no_register=$row->no_register;
							?>
								<tr>
								  	<td><?php echo $i++;?></td>
								  	<td><?php echo $row->tgl_kunjungan;?></td>
								  	<td><?php echo $row->no_resep;?></td>
								  	<td><?php echo $row->no_register;?></td>
								  	<td><?php echo $row->nama;?></td>
								  	<td><?php echo $row->kelas;?></td>
								  	<td><?php echo $row->idrg;?></td>
								  	<td><?php echo $row->bed;?></td>
								  	<td><?php 
								  		if($row->cara_bayar=='UMUM'){
								  			echo $row->cara_bayar;
								  			if($row->cetak_kwitansi=='1'){
								  				echo ' <br> <b>(Lunas)</b>'; 
								  			}else {
								  				echo ' <br> (<i>Belum Lunas</i>)';}
								  		}else {
								  			echo $row->cara_bayar;
								  		}?>
								  	</td>
								  	<td>
										<input type="button" name="selesai" onclick="selesai_pengambilan(<?php echo $row->no_resep;?>)" class="btn btn-primary" value="Selesai">
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