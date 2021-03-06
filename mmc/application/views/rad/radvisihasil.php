<?php
	$this->load->view('layout/header.php');
?>

<script src="<?php echo site_url('asset/plugins/ckeditor/ckeditor.js'); ?>"></script>
<script type='text/javascript'>
//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#example').DataTable();
    CKEDITOR.replace('hasil_periksa');
} );
//---------------------------------------------------------

function isi_value(isi_value, id) {
	document.getElementById(id).value = isi_value;
}	
var site = "<?php echo site_url();?>";

function downloadFile(datafoto) {
    window.location.href = "<?php echo base_url('rad/Radcpengisianhasil/download')?>/"+ datafoto ;
    //alert('download');
}
</script>
	<?php include('radvdatapasien.php');
	$itot=0;?>
	<section class="content-header">
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">	
						<div class="panel-heading" align="center">
							<h4  align="left">Tindakan : <?php echo $jenis_tindakan?></h4>
						</div>
						<?php echo form_open_multipart('rad/radcpengisianhasil/simpan_hasil'); ?>
						<div class="panel-body" style="display:block;overflow:auto;">
						<br/>
							<!-- form -->
							<div class="well">
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="lbl_gambar_hasil">Foto Hasil Diagnostik</p>
									<div class="col-sm-8">
									<?php 
									$this->load->helper('directory'); //load directory helper
									$dir = "upload/radgambarhasil/"; // Your Path to folder
									$map = directory_map($dir); /* This function reads the directory path specified in the first parameter and builds an array representation of it and all its contained files. */
									$kosong = 0;
									foreach ($map as $k){
										if(stripos($k, $no_register."-".$id_pemeriksaan_rad) !== FALSE){
											$kosong++;
										?>
										<div class="col-sm-4" style='margin-bottom: 20px;'>
									     <center>
									     	<img src="<?php echo base_url($dir)."/".$k?>" alt="" height='150px'  style='margin-bottom: 10px;'>
									     	<br>
									     	<input type="button" value="Download" onClick="downloadFile('<?php echo $k; ?>')">
									     </center>
										</div>
									   
									<?php 
										}
									}
									if($kosong==0){
										echo "Foto Tidak Ditemukan";
									}
									          
									?> 
									</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="lbl_hasil_periksa">Hasil Dokter</p>
									<div class="col-sm-8">
										<textarea rows="10" cols="80" name="hasil_periksa" id="hasil_periksa" ></textarea>
									</div>
								</div>
								
								<div class="form-inline" align="right">
									<input type="hidden" class="form-control" value="<?php echo $id_pemeriksaan_rad;?>" name="id_pemeriksaan_rad">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $no_rad;?>" name="no_rad">
									
									<div class="form-group">
										<a href="<?php echo site_url('rad/Radcpengisianhasil/daftar_hasil/'.$no_rad); ?>" class="btn bg-orange btn-s">Back</a>
										<button type="submit" class="btn btn-primary">Simpan</button>
									</div>
								</div>
						</div>
					</div>
					<?php echo form_close();?>
				</div>

				
			</div>
		</section>
	
<?php
	$this->load->view('layout/footer.php');
?>