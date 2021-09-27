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
        url:"<?php echo base_url('pa/pacpengisianhasil/simpan_hasil')?>",
		data: dataString,
        cache: false,
        success: function(html) {	
            location.reload();
        }
    });
}

</script>
	<?php include('pavdatapasien.php');?>
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
						<h3 class="box-title">Pengisian Hasil Tes Patologi Anatomi</h3>
						
						<?php
							echo form_open('pa/pacpengisianhasil/st_cetak_hasil_pa');
						?>
						<input type="hidden" class="form-control" name="jumlah_vtot" value="<?php //echo $jumlah_vtot ?>">
						
						<div class="form-inline" align="right">
							<div class="input-group">
								<select id="no_pa" class="form-control" name="no_pa"  required>
									<?php 
										echo "<option value='$no_pa' selected>$no_pa</option>";
									?>
								</select>
								<!--<a href="<?php //echo site_url('irj/rjckwitansi/st_cetak_kwitansi_kt/'.$no_pa);?>"><input type="button" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak"></a>-->
								<span class="input-group-btn">
									<button type="submit" class="btn btn-primary">Cetak Hasil</button>
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
						  <th>No Pendaftaran Pa</th>
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
									  	<td><?php echo $row->no_pa;?></td>
									  	<td><?php echo $row->jenis_tindakan;?></td>
									  	
								  		<?php 
							  				if($row->hasil_periksa==0){
							  					echo "<td>Hasil Belum di Isi</td>";
								  		;?><td>
											<a href="<?php echo site_url('pa/pacpengisianhasil/isi_hasil/'.$row->id_pemeriksaan_pa); ?>" class="btn btn-primary btn-xs">Isi Hasil</a>
										</td>
								  		<?php 
							  				} else if($row->hasil_periksa==1){
							  					echo "<td>Hasil <b>Sudah</b> di Isi</td>";
							  			;?><td>
											<a href="<?php echo site_url('pa/pacpengisianhasil/edit_hasil/'.$row->id_pemeriksaan_pa); ?>" class="btn btn-primary btn-xs">Edit Hasil</a>
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