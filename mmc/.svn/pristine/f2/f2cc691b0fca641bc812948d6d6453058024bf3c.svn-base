<?php $this->load->view("layout/header"); ?>

<?php echo $this->session->flashdata('message_no_tindakan'); ?>

<section class="content">
	<div class="row">
		<div class="box" style="width:97%;margin:0 auto">
		<div class="box-header">
			<h3 class="box-title">Rekap Tindakan</h3>			
		</div>
		<div class="box-body">			
		
		<table class="table" >		  
		<tbody>
		<?php foreach($data_pasien as $row){ ?>
			<tr>
				<th>No CM</th>
				<td>:</td>
				<td><?php echo $row->no_cm;?></td>
				<th>Tanggal Kunjungan</th>
				<td>:</td>
				<td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan)).' | '.date("h:m", strtotime($row->tgl_kunjungan)); ?></td>
			</tr>
			<tr>
				<th>No. Register</th>
				<td>:</td>
				<td><?php echo $row->no_register;?></td>
				<th>Kelas Pasien</th>
				<td>:</td>
				<td><?php echo $row->kelas_pasien;?></td>
			</tr>
			<tr>
					<th>Nama Pasien</th>
					<td>:</td>
					<td><?php echo $row->nama;?></td>
					<th>Cara Bayar</th>
					<td>:</td>
					<td><?php echo $row->cara_bayar;$cara_bayar=$row->cara_bayar;?></td>
					
			</tr>
			<tr>
				<?php if($row->cara_bayar=='PERUSAHAAN'){?>
					<th>Nama Perusahaan</th>
					<td>:</td>
					<td><?php echo $kontraktor->id_kontraktor.' - '.$kontraktor->nmkontraktor;?></td>
				<?php }?>
				
			</tr>
			
		</tbody>
	</table>
	<hr>
	<?php } ?>
	<table class="table table-hover table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
		<tr>
			<th>No</th>
			<th>Pemeriksaan</th>
			<th class="text-right">Detail Biaya</th>
			<th class="text-right">Total Biaya</th>
		</tr>
		</thead>							
		<tbody>
		<?php
			$jumlah_vtot=0;
			$jumlah_vtot=$vtot->vtot+$vtot->vtot_lab+$vtot->vtot_rad+$vtot->vtot_obat
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
		  <td>- <?php echo ucwords(strtolower($row->nmtindakan));?></td>
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
		  <td>- <?php echo ucwords(strtolower($row->jenis_tindakan));?></td>
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
			foreach($data_radiologi as $row){?>
		<tr>
		  <td></td>
		  <td>- <?php echo ucwords(strtolower($row->jenis_tindakan));?></td>
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
			foreach($data_resep as $row){?>
		<tr>
		  <td></td>
		  <td>- <?php echo ucwords(strtolower($row->nama_obat));?></td>
		  <td>Rp <div class="pull-right"><?php echo number_format( $row->vtot, 2 , ',' , '.' );?></div></td>
		  <td></td>
		</tr>
		<?php } }?>	
		<tr>
		  <th></th>
		  <th></th>
		  <th colspan="2" class="pull-right">Total</th>
		  <th>Rp <div class="pull-right"><?php echo number_format( $jumlah_vtot, 2 , ',' , '.' );?></div></th>
		</tr>
		</tbody>
	</table>
	<hr>	
	
	

	<?php if($this->session->flashdata('message_no_tindakan')=='' and $jumlah_vtot!=0){	?>


	<br>
	
		<div class="form-inline row" align="left" style="margin-left:10px;">
			
			<div class="input-group">	
				<?php echo form_open('faktur/fcrekap/st_cetak_kwitansi_kt_ird');?>		
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
					<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
						
			<span><button type="submit" id="btn-cetak-detail5" class="btn btn-primary" >Cetak Detail</button></span>
				<?php echo form_close();?>
			</div>
					
		</div>			
					
		<!--<a href="<?php //echo site_url('irj/rjckwitansi/st_cetak_kwitansi_kt/'.$no_register);?>"><input type="button" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak"></a>-->			
	

	
	</div>
	
	<?php } else {	?>
	<div class="form-inline" align="right">
		<div class="form-group">
			<a href="<?php echo site_url('ird/IrDKwitansi/st_selesai_kwitansi_kt/'.$no_register);?>"><input type="button" class="btn btn-danger btn-sm" id="btn_selesai" value="Selesai"></a>
		</div>
	</div>
	<?php	} ?>
	</div>					
			
				<!--- end panel --->
		</section>

<script type='text/javascript'>	
var site = "<?php echo site_url();?>";
$(document).ready(function() {	    	

	

    });


function penyetorDetail(){
	var num = $('#penyetor').val(); 
	$('#penyetor_hide').val(num); 
	$('#penyetor_hide_1').val(num); 
}


</script>
<?php $this->load->view("layout/footer"); ?>
