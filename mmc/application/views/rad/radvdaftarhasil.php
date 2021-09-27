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

		
function isi_value(isi_value, id) {
	document.getElementById(id).value = isi_value;
}	
var site = "<?php echo site_url();?>";
function simpan_hasil(id) {
	var x = document.getElementById(id).value;
	dataString = 'id='+id+'&val='+x;
	$.ajax({
        type: "GET",
        url:"<?php echo base_url('rad/Radcpengisianhasil/simpan_hasil')?>",
		data: dataString,
        cache: false,
        success: function(html) {	
            location.reload();
        }
    });
}

</script>
	<?php include('radvdatapasien.php');?>
	<section class="content-header">
		<legend><?php //echo $title;?></legend>
			<?php
				//echo $this->session->flashdata('success_msg');
			?>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<!-- <h3 class="box-title">Pengisian Hasil Tes Radiologi</h3> -->
						
						<?php
							echo form_open('rad/radcpengisianhasil/st_cetak_hasil_rad');
						?>
						<input type="hidden" class="form-control" name="jumlah_vtot" value="<?php //echo $jumlah_vtot ?>">
						
						<div class="form-inline" align="right">
							<div class="input-group">
								<select id="no_rad" class="form-control" name="no_rad"  required>
									<?php 
										echo "<option value='$no_rad' selected>$no_rad</option>";
									?>
								</select>
								<span class="input-group-btn">
									<button type="submit" class="btn btn-primary">Cetak</button>
								</span>
						
							</div>
						</div>
						<?php 
							echo form_close();
						
						?>	
					</div>
					<div class="box-body">
						<table id="example" class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
						  <th>No</th>
						  <th>No Pendaftaran Rad</th>
						  <th>No Tindakan Rad</th>
						  <th>Jenis Pemeriksaan</th>
						  <th>Hasil Pemeriksaan</th>
						  <th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
								// print_r($pasien_daftar);
									$i=1;
									foreach($daftarpengisian as $row){
									//$id_pelayanan_poli=$row->id_pelayanan_poli;
									
								?>
									<tr>
									  	<td><?php echo $i++;?></td>
									  	<td><?php echo $row->no_rad;?></td>
									  	<td><?php echo $row->id_pemeriksaan_rad;?></td>
									  	<td><?php echo $row->jenis_tindakan;?></td>
									  	
								  		<?php 
							  				if($row->hasil_periksa==''){
							  					echo "<td>Hasil Belum di Isi</td>";
								  		;?><td>
											<a href="<?php echo site_url('rad/radcpengisianhasil/isi_hasil/'.$row->id_pemeriksaan_rad); ?>" class="btn btn-primary btn-xs">Isi Hasil</a>
										</td>
								  		<?php 
							  				} else if($row->hasil_periksa!=''){
							  					echo "<td>Hasil <b>Sudah</b> di Isi</td>";
							  			;?><td>
											<a href="<?php echo site_url('rad/Radcpengisianhasil/edit_hasil/'.$row->id_pemeriksaan_rad); ?>" class="btn btn-primary btn-xs">Edit Hasil</a>
										</td>
								  		<?php 
							  				}
								  		;?>
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