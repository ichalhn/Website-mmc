<style>
.table-bordered th, .table-bordered td {
	border: 1px solid #ddd!important
}
</style>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
		
function pilih_racikan(id_resep) {
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('farmasi/Frmcdaftar/get_biaya_tindakan')?>",
		data: {
			id_resep: id_resep
		},
		success: function(data){
			//alert(data);
			$('#biaya_racikan').val(data);
			$('#biaya_racikan_hide').val(data);
			$('#qty_racikan').val('1');
			set_total_racikan() ;
		},
		error: function(){
			alert("error");
		}
    });
}

function pilih_kebijakan(kodemarkup) {
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('farmasi/Frmcdaftar/get_biaya_kebijakan')?>",
		data: {
			kodemarkup: kodemarkup
		},
		success: function(data){
			//alert(data);
			$('#fmarkup').val(data);
			set_total() ;
		},
		error: function(){
			alert("error");
		}
    });
}
function set_total_racikan() {
	var total = $("#biaya_racikan").val() * $("#qty_racikan").val() ;	
	$('#vtot_racikan').val(total);
	$('#vtot_racikan_hide').val(total);
}

function set_hasil_obat(qty) {
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('farmasi/Frmcdaftar/get_biaya_resep')?>",
		data: {
			no_resep: "<?php echo $no_resep ?>",
			qty : qty
		},
		success: function(data){
			//alert(data);	
			$('#vtot_x').val(data);
			$('#vtot_x_hide').val(data);
		},
		error: function(){
			alert("error");
		}
    });
}

function insert_total(){
	var jumlah = $('#jumlah').val();

	// bawah
	//qty di set 1 karena hasil dari perhitungan sendiri


	var val = $('select[name=idtindakan]').val();
	var temp = val.split("-");
	var cara_bayar = "$data_pasien[0]['carabayar']";

	$('#biaya_obat').val(jumlah);
	$('#biaya_obat_hide').val(jumlah);
	var qty = 1;
	$('#qtyind').val(1)
	var total = qty * jumlah;
	$('#vtot').val(total);

	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('farmasi/Frmcdaftar/get_biaya_resep')?>",
		data: {
			no_resep: "<?php echo $no_resep ?>",
			qty : qty
		},
		success: function(data){
			//alert(data);	
			$('#vtot_x').val(data);
			$('#vtot_x_hide').val(data);
		},
		error: function(){
			alert("error");
		}
    });
}

</script>
	<div class="panel-heading panel-default" align="center">
	<ul class="nav nav-pills nav-justified">
	  <li role="presentation" class="<?php echo $tab_obat; ?>"><a data-toggle="tab" href="#tabobat">OBAT</a></li>
	  <li role="presentation" class="<?php echo $tab_racikan; ?>"><a data-toggle="tab" href="#tabracik">RACIKAN</a></li>		
	</ul>
	</div>
<div class="tab-content">
	<div id="tabobat" class="tab-pane fade in <?php echo $tab_obat; ?>">
		<div class="panel-body" style="display:block;overflow:auto;">
						
							<!-- form -->
							<div class="well">
							<?php echo form_open('irj/rjcpelayanan/insert_resep'); ?>
								<!--<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="operator">Dokter</p>
										<div class="col-sm-8">
																						

											<select class="form-control" name="dokterObat" id="dokterObat" style="width:67.5%">
											<option value="">-Pilih Dokter-</option>											
													<?php 
												
													//foreach($dokter as $row){
														//echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'">'.$row->id_dokter.' - '.$row->nm_dokter.'</option>';
													//}
													?>
											</select>

											

										</div>
								</div>
								-->
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="obat">Obat</p>
										<div class="col-sm-8">
											<div class="form-inline">
												<!--
												<input type="search" style="width:100%" class="auto_search_tindakan form-control" placeholder="" id="nmtindakan" name="nmtindakan" required>
												<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan"  name="idtindakan">
												-->
												
												<div class="form-group">
													<select id="obat" class="form-control" name="obat" onchange="pilih_obat(this.value)" required>
														<option value="">-Pilih Obat-</option>
														<?php 
															foreach($data_obat as $row){
																echo '<option value="'.$row->id_obat.'">'.$row->nm_obat.'</option>';
															}
														?>
													</select>
												</div>
											</div>
										</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Obat</p>
									<div class="col-sm-3"><div class="input-group">
										<span class="input-group-addon">Rp</span>
										<input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>" name="biaya_obat" id="biaya_obat" disabled>
										<input type="hidden" class="form-control" value="" name="biaya_obat_hide" id="biaya_obat_hide">
									</div></div>
								</div>

								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_signa">Signa</p>
									<div class="col-sm-3">
										<input type="text" class="form-control" name="signa" id="sgn" min=1 onchange="set_total_resep(this.value)" required>
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qtyind">Quantity</p>
									<div class="col-sm-2">
										<input type="number" class="form-control" name="qtyResep" id="qtyResep" min=1 onchange="set_total_resep(this.value)">
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_vtot">Total</p>
									<div class="col-sm-3"><div class="input-group">
										<span class="input-group-addon">Rp</span>
										<input type="text" class="form-control" name="vtot_resep" id="vtot_resep" disabled>
										<input type="hidden" class="form-control" value="" name="vtot_resep_hide" id="vtot_resep_hide">
									</div></div>
								</div>
								
								<div class="form-inline" align="right">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
									<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kunjungan">
									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
									<input type="hidden" class="form-control" value="<?php echo $no_resep;?>" name="no_resep">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
									<div class="form-group">
										<button id="button_reset_obat" type="reset" class="btn btn-warning">Reset</button>
										<button id="button_simpan_obat" type="submit" class="btn btn-primary">Simpan</button>
									</div>
								</div>
							<?php echo form_close();?>

							<!-- table -->
										<br>
									<div style="display:block;overflow:auto;">
										<table id="tabel_obat1" name="tabel_obat" class="display" cellspacing="0" width="100%">									
									<?php include('rjvtableresep.php');?>
									<br>
								<!--<div class="form-inline" align="right">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<div class="form-group">
										<?php	foreach($rujukan_penunjang as $row){ 
										if($row->obat=='1' and $row->status_obat=='0'){
echo '<a  href="' .site_url('ird/IrDPelayanan/selesai_daftar_obat/'.$no_register.'/'.$no_resep).'" class="btn btn-primary btn-xl">Selesai & Cetak</a>
';}
else {
echo '<a   class="btn btn-primary btn-xl" disabled>Selesai & Cetak</a>';
} }?>										
									</div>
								</div>-->
						</div>
					</div>
</div>

<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

<div id="tabracik" class="tab-pane fade in <?php echo $tab_racikan; ?>"> 
   
     <div class="panel-body" style="display:block;overflow:auto;">
	<div class="well" >
      	<?php echo form_open('irj/rjcpelayanan/insert_racikan'); ?>
		<div class="col-sm-6">
			<div class="form-group row">
				<p class="col-sm-2 form-control-label " id="tindakan">Obat</p>
				<div class="col-sm-10">
							<select width="100%" id="idracikan" class="form-control js-example-basic-single" name="idracikan" onchange="pilih_racikan(this.value)" required>
								<option value="">-Pilih Obat-</option>
								<?php foreach($data_obat as $row){
								echo '<option value="'.$row->id_obat.'">'.$row->nm_obat.'</option>';
								} ?>
							</select>
						
				</div>
			</div>
			<div class="form-group row">
				<p class="col-sm-2 form-control-label" id="lbl_qtyind">Quantity</p>
				<div class="col-sm-3">
					<input type="number" step="0.01" class="form-control" name="qty_racikan" id="qty_racikan" onchange="set_total_racikan(this.value)">
				</div>
			</div>				
		</div>
		<div class="col-sm-6">
			<div class="form-group row">
				<p class="col-sm-3 form-control-label" id="lbl_biaya_poli">Harga Obat</p>
					<div class="col-sm-4">
						<input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>" name="biaya_racikan" id="biaya_racikan" disabled>
						<input type="hidden" class="form-control" value="" name="biaya_racikan_hide" id="biaya_racikan_hide">
					</div>
			</div>
			<div class="form-group row">
				<p class="col-sm-3 form-control-label" id="lbl_vtot">Total</p>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="vtot_racikan" id="vtot_racikan" disabled>
						<input type="hidden" class="form-control" value="" name="vtot_racikan_hide" id="vtot_racikan_hide">
					</div>
			</div>
			<input type="hidden" class="form-control" name="fmarkup" id="fmarkup" value="<?php echo $fmarkup ?>">	
			<input type="hidden" class="form-control" name="ppn" id="ppn" value="<?php echo $ppn ?>" >
								
									
								<!--<div class="form-group row">
									<p class="col-sm-2 form-control-label " id="markup">Kebijakan Obat</p>
										<div class="col-sm-10">
											<div class="form-inline">
												<!--
												<input type="search" style="width:100%" class="auto_search_tindakan form-control" placeholder="" id="nmtindakan" name="nmtindakan" required>
												<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan"  name="idtindakan">
												-->
												<!--<div class="form-group">
													<select id="idmarkup" class="form-control" name="idmarkup" onchange="pilih_kebijakan(this.value)" required>
														<option value="">-Pilih Kebijakan-</option>
														<?php 
															foreach($get_data_markup as $row){
																echo '<option value="'.$row->kodemarkup.'">'.$row->ket_markup.'</option>';
															}
														?>
													</select>
												</div>
											</div>
										</div>
								</div>-->
		</div>
		<div class="form-inline" align="right">
			<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
			<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
			<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
			<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
			<?php if($no_resep!=''){
			echo "<input type='hidden' class='form-control' value=".$no_resep." name='no_resep'>";
			} else {
			}?>
			<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
			<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kunjungan">
			<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
			<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
			<!--<input type="hidden" class="form-control" value="<?php echo $no_resep;?>" name="no_resep">-->
			<input type="hidden" class="form-control" value="<?php echo $no_resep;?>" name="no_resep">
				<div class="form-group">
					<button id="button_reset_racik" type="reset" class="btn bg-orange">Reset</button>					
					<button id="button_tambah_racik" type="submit" class="btn btn-primary">Tambah</button>
				</div>
			</div>
			<?php echo form_close();?>  
   

  <br><br>
    			<div class="form-group row">
    			<div class="col-sm-12">
				<table class="table table-bordered table-hovered" width="100%">
				  			  <thead>
								<tr>
								  <th><p align="center">No</p></th>
								  <th><p align="center">Nama Obat</p></th>
								  <th><p align="center">Harga Obat</p></th>
								  <th><p align="center">Qty</p></th>
								  <!--<th >Harga Satuan</th>-->
								  <th><p align="center">Total</p></th>
								  <th><p align="center">Aksi</p></th>
								</tr>
							  </thead>
							  <tbody>
							  
						<?php
							$i=1;
							$vtot1=0;$vtot2=0;
							if($data_tindakan_racikan!=''){
							foreach($data_tindakan_racikan as $row){
							
						?>
							<tr>
								<td align="center"><?php echo $i++;?></td>
								<td><?php echo $row->nm_obat;?></td>
								<td><?php echo $row->hargajual;?></td>
								<td align="center"><?php echo $row->qty;?></td>
								<?php $v=$row->hargajual*$row->qty; 
									$vtot1=$vtot1+$v;
								?>
								<!--<td><?php echo $row->biaya_obat;?></td>-->
								<td>Rp <div class="pull-right"><?php echo number_format( $v, 2 , ',' , '.' );?></div></td>
								<td><a href="<?php echo site_url("irj/rjcpelayanan/hapus_data_racikan/".$no_register."/".$row->no_resep."/".$row->item_obat."/".$row->id_resep_pasien."/".$id_poli);?>" class="btn btn-danger btn-xs">Hapus</a></td>
							</tr>
							
						<?php
							}}
						?>
							<tr>								
								<td colspan="4" align="right"><b>Total</b></td>
								<td>Rp <div class="pull-right"><b><?php echo number_format( $vtot1, 2 , ',' , '.' );?>
									<input type="hidden" class="form-control" value="<?php echo $vtot1;?>" name="vtot1"></b></div></td>
								</tr>	
							  </tbody>
							 </table>
							
				</div>	
				
						

      	<?php echo form_open('irj/rjcpelayanan/insert_racikan_selesai'); ?>
      						<div class="col-sm-6">
    							<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="lbl_racikan">Nama Racikan</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="racikan" id="rck" required>
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="lbl_signa">Signa</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="signa" id="sgn" required> 
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="qty">Quantity Total</p>
									<div class="col-sm-4">
										<input type="number" class="form-control" name="qty1" id="qty1" min=1 onchange="set_hasil_obat(this.value)" required>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="lbl_vtotx">Total</p>
									<div class="col-sm-4">
										<input type="number" class="form-control" name="vtot_x" id="vtot_x" disabled="">
										<input type="hidden" class="form-control" name="vtot_x_hide" id="vtot_x_hide">
									</div>
								</div>
								

								<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kun">
									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
									<input type="hidden" class="form-control" value="<?php echo $fmarkup;?>" name="fmarkup">
									
									<input type="hidden" class="form-control" value="<?php echo $no_resep;?>" name="no_resep">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
									<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
						</div>
							<div class="col-xs-6" align="right">
								<div class="form-inline" align="right">
							<div class="input-group">
									<div class="form-group">
										<button id="button_selesai_racik" class="btn btn-primary">Selesai</button>
									</div>
							</div>
						</div>
						<!-- /col-lg-6 -->
							<?php echo form_close();?>  


	</div>
   </div>
  </div>

							<div style="display:block;overflow:auto;">
								<table id="tabel_obat2" name="tabel_obat" class="display" cellspacing="0" width="98%">
							<?php include('rjvtableresep.php');?>

</div></div>






