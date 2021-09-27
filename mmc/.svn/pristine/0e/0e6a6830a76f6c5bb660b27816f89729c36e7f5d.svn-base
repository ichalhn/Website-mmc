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
				<th><p style="padding-top:3px;">Pilih Jenis Pembayaran</p></th>
					<td><p style="padding-top:3px;">:</p></td>
					<td><select class="form-control" name="jenis_bayar"id="jenis_bayar" style="border: 2px solid  #7DBE64;" onchange="jenis_bayar(this.value)" required>
							<option value="">-Pilih Jenis Pembayaran-</option>
							<option value="1">TUNAI </option>
							<option value="0">KREDIT</option>
						</select></td>
				<?php if($row->cara_bayar=='DIJAMIN / JAMSOSKES'){?>
					<th>Nama Perusahaan</th>
					<td>:</td>
					<td><?php if($kontraktor!=''){ echo $kontraktor->id_kontraktor.' - '.$kontraktor->nmkontraktor;}?></td>
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
			$jumlah_vtot=0; echo $vtot->vtot_pa;
			$jumlah_vtot=$vtot->vtot+$vtot->vtot_lab+$vtot->vtot_rad+$vtot->vtot_obat+$vtot->vtot_ok+$vtot->vtot_pa;
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
		  <td>5</td>
		  <td>Patologi Anatomi</td>
		  <td></td>
		  <td>Rp <div class="pull-right"><?php echo number_format( $vtot->vtot_pa, 2 , ',' , '.' );?></div></td>
		</tr>			
		<?php if($data_pa!=''){ 
			foreach($data_pa as $row){?>
		<tr>
		  <td></td>
		  <td>- <?php echo ucwords(strtolower($row->jenis_tindakan));?></td>
		  <td>Rp <div class="pull-right"><?php echo number_format( $row->vtot, 2 , ',' , '.' );?></div></td>
		  <td></td>
		</tr>
		<?php } }?>	
		<tr>
		  <td>6</td>
		  <td>Kamar Operasi</td>
		  <td></td>
		  <td>Rp <div class="pull-right"><?php echo number_format( $vtot->vtot_ok, 2 , ',' , '.' );?></div></td>
		</tr>			
		<?php if($data_ok!=''){ 
			foreach($data_ok as $row){?>
		<tr>
		  <td></td>
		  <td>- <?php echo ucwords(strtolower($row->jenis_tindakan));?></td>
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
	
	

	<?php if(($this->session->flashdata('message_no_tindakan')=='' and $jumlah_vtot!=0) or $jumlah_vtot!=0){	?>

	<table class="table table-responsive" >		  
		<tbody>
			
			<tr>
				<th style="width:20%;">Dibayar Tunai</th>
				<td>:</td>
				<td style="width:40%;">
					<div class="input-group">
						<span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="biaya_t" id="biaya_t" placeholder="Nominal Tunai" required>
					</div>
				</td>
				<td style="width:40%;"></td>
			</tr>			
			
			<tr id="kredit0" name="kredit0">
				<th>Pengurangan</th>
				<td>:</td>
				<td><div class="input-group"><span class="input-group-addon">Rp</span>						
					<input type="text" class="form-control" name="diskon" id="diskon" placeholder="Nominal Pengurangan" >				
					</div>	
				</td>
				<td>
					
				</td>
			</tr>
			<tr>
				<th>Total Akhir</th>
				<td>:</td>
				<td><div class="input-group">
						<span class="input-group-addon">Rp</span>
							<input type="text" class="form-control" placeholder="0" name="totfinal" id="totfinal" disabled>							
						<span class="input-group-btn">
						<button type="btn" class="btn btn-primary" onclick="setTotal()">Hitung</button>
					</span>
					</div>
				</td>
			</tr>
			<!--<tr>
				<th>Total Akhir</th>
				<td>:</td>
				<td><div class="input-group">
						<span class="input-group-addon">Rp</span>
							<input type="text" class="form-control" placeholder="0" name="kembalian" id="kembalian" disabled>							
						<span class="input-group-btn">
						<button type="btn" class="btn btn-primary" onclick="setTotal()">Hitung</button>
					</span>
					</div>
				</td>
			</tr>-->
		</tbody>
	</table>
	<p style=" margin-left:10px; padding-top:3px;">*) Sesuai dengan kebijakan kartu kredit</p>
	<hr>
	<table style="margin-left:10px;">
		<tbody>
			<tr>
				<th style="width:40%;"><p >Sudah Terima Dari</p></th>
				<td style="width:10%;"><p>:</p></td>
				<td style="width:40%;">
					<input type="text" class="form-control" name="penyetor" id="penyetor" onchange="penyetorDetail(this.value)" >
				</td>
			</tr>			
			
		</tbody>
	</table>
	<br>
	<div class="form-inline row" align="left" style="margin-left:10px;">
			<div class="input-group">
				<?php echo form_open('ird/IrDKwitansi/st_cetak_kwitansi_kt');?>
				<input type="hidden" class="form-control" name="penyetor_hide" id="penyetor_hide">								
				<input type="hidden" class="form-control" name="pilih" value="0" >
				<input type="hidden" class="form-control" name="no_register" value="<?php echo $no_register ?>">
				<input type="hidden" class="form-control" name="penyetor" id="penyetor_hide_1">
				<input type="hidden" class="form-control" name="jenis_bayar_hide" id="jenis_bayar_hide_1">
				<input type="hidden" class="form-control" name="diskon_hide" id="diskon_hide_1">
				<input type="hidden" class="form-control" name="totakhir_hide" id="totakhir_hide" >
				<input type="hidden" class="form-control" name="totakhir_hide" id="totakhir_hide" >
				<input type="hidden" class="form-control" name="nilai_tunai" id="nilai_tunai_1" >
				<input type="hidden" class="form-control" name="totfinal_hide" id="totfinal_hide_1">
				<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">			
				<span >	
					<button type="submit" id="btn-cetak" class="btn btn-primary">Cetak</button>
				</span>	
				<?php echo form_close();?>				
			</div>
			
			<!--<div class="input-group">	
				<?php echo form_open('ird/IrDKwitansi/st_cetak_kwitansi_kt');?>		
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
						
			<span><button type="submit" id="btn-cetak-detail" class="btn btn-primary" >Cetak Detail</button></span>
				<?php echo form_close();?>
			</div>-->
					
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
			
				<!--- end panel -->
		</section>

<script type='text/javascript'>	
var site = "<?php echo site_url();?>";
$(document).ready(function() {
	    	
	var cara_bayar = "<?php echo $cara_bayar;?>"; 
	//alert(cara_bayar);

	var total = "<?php echo $jumlah_vtot; ?>";

	if(total!='0'){
		if(cara_bayar=='BPJS'){
			$("#biaya_t").val('0');			
			$("#diskon").val(total);
			setTotal();
			$("#jenis_bayar").val('0').change();
		}else if(cara_bayar=='DIJAMIN / JAMSOSKES')
		{
			$("#biaya_t").val('0');			
			$("#diskon").val(total);
			setTotal();
			$("#jenis_bayar").val('0').change();
		}else if (cara_bayar=='UMUM'){
			$("#biaya_t").val(total);	
			$("#jenis_bayar").val('1').change();
		}
		else alert('ERROR!');
		
		document.getElementById("btn-cetak").disabled = true;
		//document.getElementById("btn-cetak-detail").disabled =true;
	}

    });


function penyetorDetail(){
	var num = $('#penyetor').val(); 
	$('#penyetor_hide').val(num); 
	$('#penyetor_hide_1').val(num); 
}

function setCash(){
	var num0 = $('#cashRate').val(); 
	var num1 = $('#biaya_k').val(); 
	if(num0!=''){
		var charge = (parseInt(num0)/100)*parseInt(num1);
		$('#cashFee').val(charge);
		$('#charge_rate_1').val(num0); 
		$('#charge_rate_2').val(num0); 
		$('#charge_fee_1').val(charge); 
		$('#charge_fee_2').val(charge);
		var result = parseInt(charge)+parseInt(num1);
		$('#kartuk').val(result); 
		$('#nilai_kk_1').val(num1); 
		$('#nilai_kk_2').val(num1); 
	}
}

function selisihUangMuka(){
	var total = "<?php echo $jumlah_vtot; ?>";
	var num = $('#uangMuka').val(); 
	
//	alert(result);
	//$('#penyetor_hide').val(num); 
}
function jenis_bayar(bayar){
	$('#jenis_bayar_hide_1').val(bayar); 
	$('#jenis_bayar_hide_2').val(bayar); 
	//alert($('#jenis_bayar_hide_1').val() );
}
function setTotal(){
	var total = "<?php echo $jumlah_vtot; ?>";
	var cara_bayar = "<?php echo $cara_bayar;?>"; 
	//var kartuk = $('#kartuk').val(); 
	var potong=$('#diskon').val();
	$('#diskon_hide_1').val(potong);
	$('#diskon_hide_2').val(potong);
	var tunai = $('#biaya_t').val();
	//var tunaikk = $('#biaya_k').val();
	//var charge = $('#cashFee').val();
	//alert("kartuk "+kartuk);alert("potong "+potong);alert("tunai "+tunai);alert("tunai kk "+tunaikk);alert("charge "+charge);
	if(potong==''){
		potong='0';
	}
	if(tunai==''){
		tunai='0';
	}	
	
	var totalfix = parseInt(total)-(parseInt(tunai)+parseInt(potong));	
		if(totalfix!='0'){
			if(cara_bayar!='BPJS'){
				
				if(totalfix=='0'){
					$('#totfinal').val(totalfix);
					$('#totfinal_hide_1').val(totalfix); 
					$('#totfinal_hide_2').val(totalfix);
					document.getElementById("btn-cetak").disabled = false;
					//document.getElementById("btn-cetak-detail").disabled =false;
				}else{
					alert("Jumlah pembayaran tidak sesuai : "+ totalfix);
					$('#totfinal').val(totalfix);
					$('#totfinal_hide_1').val(totalfix); 
					$('#totfinal_hide_2').val(totalfix);
					document.getElementById("btn-cetak").disabled = true;
					//document.getElementById("btn-cetak-detail").disabled =true;
				}
			}else {
				//alert("Jumlah "+ totalfix);
				alert("Jumlah pembayaran tidak sesuai : "+ totalfix);
				document.getElementById("btn-cetak").disabled = true;
				//document.getElementById("btn-cetak-detail").disabled =true;
			}
			
		}else{
			$('#totfinal').val(total); 
			$('#totfinal_hide_1').val(total); 
			$('#totfinal_hide_2').val(total);
			$('#nilai_tunai_1').val($('#biaya_t').val());
			$('#nilai_tunai_2').val($('#biaya_t').val());
			document.getElementById("btn-cetak").disabled = false;
			//document.getElementById("btn-cetak-detail").disabled =false;
		}
	
	
	//alert( total+" - "+ tunai +" - "+ potong +" = "+ totalfix);
	//$('#totfinal').val(total); 
	$('#nilai_tunai_1').val($('#biaya_t').val());
	$('#nilai_tunai_2').val($('#biaya_t').val());
	 
}
</script>
<?php $this->load->view("layout/footer"); ?>
