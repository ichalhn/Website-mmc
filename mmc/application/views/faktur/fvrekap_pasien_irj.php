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
</script>

	<div class="container-fluid">
		<section class="content-header">
		</section>
		<section class="content">
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading" align="center">Rekap Biaya</div>
					<div class="panel-body">
						<br/>
						<div style="display:block;overflow:auto;">
							<table class="table">
							  <tbody>
								<tr>
									<th>No CM</th>
									<td>:</td>
									<td><?php echo $data_pasien->no_cm;?></td>
									<th>Tanggal Kunjungan</th>
									<td>:</td>
									<td><?php echo date("d-m-Y", strtotime($data_pasien->tgl_kunjungan)).' | '.date("h:m", strtotime($data_pasien->tgl_kunjungan)); ?></td>
								</tr>
								<tr>
									<th>No. Register</th>
									<td>:</td>
									<td><?php echo $data_pasien->no_register;?></td>
									<th>Kelas Pasien</th>
									<td>:</td>
									<td><?php echo $data_pasien->kelas_pasien;?></td>
								</tr>
								<tr>
									<th>Nama Pasien</th>
									<td>:</td>
									<td><?php echo strtoupper($data_pasien->nama);?></td>
									<th>Poli</th>
									<td>:</td>
									<td><?php echo $data_pasien->nm_poli.' ('.$data_pasien->id_poli.')';?></td>
								</tr>
								<tr>
					<th>Nama Pasien</th>
					<td>:</td>
					<td></td>
					<th>Cara Bayar</th>
					<td>:</td>
					<td><?php echo $data_pasien->cara_bayar;$cara_bayar=$data_pasien->cara_bayar;?></td>
					
			</tr>
			<tr>
				<?php if($data_pasien->cara_bayar=='PERUSAHAAN'){?>
					<th>Nama Perusahaan</th>
					<td>:</td>
					<td><?php echo $kontraktor->id_kontraktor.' - '.$kontraktor->nmkontraktor;?></td>
				<?php }?>
				
			</tr>
							  </tbody>
							</table>
							<hr>
							<table class="table table-hover table-striped table-bordered">
							  <thead>
								<tr>
								  <th>No</th>
								  <th>Pemeriksaan</th>
								  <td></td>
								  <th>Biaya</th>
								</tr>
							  </thead>
							  <tbody>
								
								<?php
								$jumlah_vtot=0;
								$jumlah_vtot=$vtot->vtot+$vtot->vtot_lab+$vtot->vtot_rad+$vtot->vtot_obat;
								?>
									<tr>
									  <td>1</td>
									  <td>Tindakan</td>
									  <td></td>
									  <td>Rp <div class="pull-right"><?php echo number_format( $vtot->vtot, 2 , ',' , '.' );?></div></td>
									</tr>
									<?php if($data_tindakan!=''){ 
									foreach($data_tindakan as $row){?>
									<tr>
									  <td></td>
									  <td>- <?php echo $row->nmtindakan;?></td>
									  <td>Rp <div class="pull-right"><?php echo number_format( $row->vtot, 2 , ',' , '.' );?></div></td>
									  <td></td>
									</tr>
									<?php } }?>
									<tr>
									  <td>2</td>
									  <td>Laboratorium</td>
									  <td></td>
									  <td>Rp <div class="pull-right"><?php echo number_format( $vtot->vtot_lab, 2 , ',' , '.' );?></div></td>
									</tr>
									<?php if($data_laboratorium!=''){ 
									foreach($data_laboratorium as $row){?>
									<tr>
									  <td></td>
									  <td>- <?php echo $row->jenis_tindakan;?></td>
									  <td>Rp <div class="pull-right"><?php echo number_format( $row->vtot, 2 , ',' , '.' );?></div></td>
									  <td></td>
									</tr>
									<?php } }?>
									<tr>
									  <td>3</td>
									  <td>Radiologi</td>
									  <td></td>
									  <td>Rp <div class="pull-right"><?php echo number_format( $vtot->vtot_rad, 2 , ',' , '.' );?></div></td>
									</tr>
									<?php if($data_radiologi!=''){
									foreach($data_radiologi as $row){ ?>
									<tr>
									  <td></td>
									  <td>- <?php echo $row->jenis_tindakan;?></td>
									  <td>Rp <div class="pull-right"><?php echo number_format( $row->vtot, 2 , ',' , '.' );?></div></td>
									  <td></td>
									</tr>
									<?php } }?>
									<tr>
									  <td>4</td>
									  <td>Obat</td>
									  <td></td>
									  <td>Rp <div class="pull-right"><?php echo number_format( $vtot->vtot_obat, 2 , ',' , '.' );?></div></td>
									</tr>
									<?php if($data_resep!=''){
									foreach($data_resep as $row){ ?>
									<tr>
									  <td></td>
									  <td>- <?php echo ucfirst(strtolower($row->nama_obat));?></td>
									  <td>Rp <div class="pull-right"><?php echo number_format( $row->vtot, 2 , ',' , '.' );?></div></td>
									  <td></td>
									</tr>
									<?php } }?>
								
									<tr>
									  <th colspan="3" >Total</th>
									  <th>Rp <div class="pull-right"><?php echo number_format( $jumlah_vtot, 2 , ',' , '.' );?></div></th>
									</tr>
								</tbody>
							</table>
						</div><!-- style overflow -->
						
						<?php
						//echo $this->session->flashdata('message_no_tindakan'); 
						if($this->session->flashdata('message_no_tindakan')=='tindakan_kosong' and $jumlah_vtot==0){
						?>
							<div class="form-inline" align="right">
								<div class="form-group">
							
									<a href="<?php echo site_url('irj/rjckwitansi/st_selesai_kwitansi_kt/'.$no_register);?>"><input type="button" class="btn btn-primary btn-sm" id="btn_selesai" value="Selesai"></a>
								</div>
							</div>
						<?php
							
						}else{?>
	<br>
		<div class="form-inline row" align="left" style="margin-left:10px;">
			<div class="input-group">			
			<?php echo form_open('faktur/fcrekap/st_cetak_kwitansi_kt_irj');?>
					
					<input type="hidden" class="form-control" name="pilih" value="detail" >
					<input type="hidden" class="form-control" name="penyetor_hide" id="penyetor_hide">
					<input type="hidden" class="form-control" name="jenis_bayar_hide" id="jenis_bayar_hide_2">
					<input type="hidden" class="form-control" name="no_register" value="<?php echo $no_register ?>">
					<input type="hidden" class="form-control" name="diskon_hide" id="diskon_hide_2">
					<input type="hidden" class="form-control" name="totakhir_hide" id="totakhir_hide" >
					<input type="hidden" class="form-control" name="totakhir_hide" id="totakhir_hide" >
					<input type="hidden" class="form-control" name="charge_rate" id="charge_rate_2" >
					<input type="hidden" class="form-control" name="charge_fee" id="charge_fee_2" >
					<input type="hidden" class="form-control" name="nilai_kk" id="nilai_kk_2" >
					<input type="hidden" class="form-control" name="nilai_tunai" id="nilai_tunai_2" >
					<input type="hidden" class="form-control" name="totfinal_hide" id="totfinal_hide_2">
					<span>
						<button type="submit" id="btn-cetak-detail" class="btn btn-primary" value="" >Cetak Detail</button>
					</span>
			<?php echo form_close();?>
				</div>
			<?php }?>
		</div><!--- end panel body --->
		</div><!--- end panel --->
			</div><!--- end panel --->
		</section>
	</div><!--- end container --->
<script type='text/javascript'>	
var site = "<?php echo site_url();?>";
$(document).ready(function() {	    	
	var total = "<?php echo $jumlah_vtot; ?>";			

    });


function penyetorDetail(){
	var num = $('#penyetor').val(); 
	$('#penyetor_hide').val(num); 
	$('#penyetor_hide_1').val(num); 
}




</script>
<?php
	$this->load->view('layout/footer.php');
?>
