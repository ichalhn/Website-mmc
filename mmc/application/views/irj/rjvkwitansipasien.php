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

	<div class="container-fluid" >
		<section class="content-header">
		</section>
		<section class="content">
			<div class="row">
				<div class="panel panel-success">
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

								

					
			</tr>
			<tr>
				<th><p style="padding-top:3px;">Pilih Jenis Pembayaran</p></th>
					<td><p style="padding-top:3px;">:</p></td>
					<td><select class="form-control" name="jenis_bayar" id="jenis_bayar" style="border: 2px solid  #7DBE64;" onchange="jenis_bayar(this.value)" required>
							<option value="">-Pilih Jenis Pembayaran-</option>
							<option value="1">TUNAI </option>
							<option value="0">KREDIT</option>
						</select></td>
				<?php if($data_pasien->cara_bayar=='DIJAMIN'){?>
					<th>Dijamin Oleh</th>
					<td>:</td>
					<td><?php if($kontraktor!=''){echo $kontraktor->nmkontraktor;}?></td>
				<?php }?>
				
			</tr>
			<?php if($data_pasien->catatan_plg!=''){?>
			<tr>
					
					<th>Cara Bayar</th>
					<td>:</td>
					<td><?php echo $data_pasien->cara_bayar;$cara_bayar=$data_pasien->cara_bayar;?></td>
					<tr>
									<th style="color:green !important">Catatan</th>
									<td>:</td>
									<td style="color:green !important" colspan="2"><u><?php echo strtoupper($data_pasien->catatan_plg);?></u></td>									
								</tr>
			<?php }?>
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
								?>
									<tr>
									  <td>1</td>
									  <td>Tindakan</td>
									  <td></td>
									  <td>Rp <div class="pull-right"><?php echo number_format( $vtotpoli, 2 , ',' , '.' );?></div></td>
									</tr>
									<?php if($data_tindakan!=''){ 
									$vtotind=0;
									foreach($data_tindakan as $row){
										$vtotind=$vtotind+$row->vtot; ?>
									<tr>
									  <td></td>
									  <td>- <?php echo $row->nmtindakan; if($row->bpjs!='1'){ echo ' | * NON-COVER';}?></td>
									  <td>Rp <div class="pull-right"><?php echo number_format( $row->vtot, 2 , ',' , '.' );?></div></td>
									  <td></td>
									</tr>
									<?php } } ?>

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
									<?php  if($data_resep!=''){
									foreach($data_resep as $row){ ?>
									<tr>
									  <td></td>
									  <td>- <?php echo ucfirst(strtolower($row->nama_obat));?></td>
									  <td>Rp <div class="pull-right"><?php echo number_format( $row->vtot, 2 , ',' , '.' );?></div></td>
									  <td></td>
									</tr>
									<?php } } if($data_ok!=''){ ?>
									<tr>
									  <td><?php if($data_pasien->cara_bayar!='UMUM'){echo '5';}else{ echo '5';}?></td>
									  <td>Kamar Operasi</td>
									  <td></td>
									  <td>Rp <div class="pull-right"><?php echo number_format( $vtot->vtot_ok, 2 , ',' , '.' );?></div></td>
									</tr>			
									<?php 
										foreach($data_ok as $row){?>
									<tr>
									  <td></td>
									  <td>- <?php echo ucwords(strtolower($row->jenis_tindakan));?></td>
									  <td>Rp <div class="pull-right"><?php echo number_format( $row->vtot, 2 , ',' , '.' );?></div></td>
									  <td></td>
									</tr>
									
									<?php } }?>
									<tr>
									  <td>6</td>
									  <td>Tindakan Lain</td>
									  <td></td>
									  <td>Rp <div class="pull-right"><?php echo number_format( $vtot->vtot_lain, 2 , ',' , '.' );?></div></td>
									</tr>	
										<?php 
											$jumlah_vtot=$vtotind+$vtot->vtot_lab+$vtot->vtot_rad+$vtot->vtot_obat+$vtot->vtot_ok+ $vtot->vtot_lain;
										?>
								
									<tr>
									  <th colspan="3" >Total</th>
									  <th>Rp <div class="pull-right"><?php echo number_format( $jumlah_vtot, 2 , ',' , '.' );?></div></th>
									</tr>
								</tbody>
							</table>
						</div><!-- style overflow -->


              <?php echo form_open('irj/rjckwitansi/edit_biaya_tambahan');?>
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Edit Biaya Tambahan</button>
              </span>
            <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Biaya Tambahan</h4>
                </div>
                <div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">Tindakan Lain</p>
                    <div class="input-group col-sm-6">
                      <span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="edit_tindakan" id="edit_tindakan" value='<?= $vtot->vtot_lain; ?>' placeholder="Nominal Tunai">
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">Laboratorium</p>
                    <div class="input-group col-sm-6">
                      <span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="edit_lab" id="edit_lab" value='<?= $vtot->vtot_lab; ?>' placeholder="Nominal Tunai">
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">Diagnostik</p>
                    <div class="input-group col-sm-6">
                      <span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="edit_diag" id="edit_diag" value='<?= $vtot->vtot_rad; ?>' placeholder="Nominal Tunai">
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">Obat</p>
                    <div class="input-group col-sm-6">
                      <span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="edit_obat" id="edit_obat" value='<?= $vtot->vtot_obat; ?>' placeholder="Nominal Tunai">
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">Biaya Operasi</p>
                    <div class="input-group col-sm-6">
                      <span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="edit_op" id="edit_op" value='<?= $vtot->vtot_ok; ?>' placeholder="Nominal Tunai">
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Tambah</button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-10">
          <input type="hidden" class="form-control" name="no_register" id="no_register" value="<?php echo  $data_pasien->no_register; ?>">
          </div>
          <?php echo form_close();?>
						
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
						<p>*) Input biaya TUNAI pasien BPJS untuk tindakan yang <b>tidak dicover/Non-cover oleh BPJS</b></p>
						<table class="table table-responsive" >		  
		<tbody>
			<!--<tr id="uangmuka0" name="uangmuka0">
				<th style="width:20%;">Uang Muka Pasien</th>
				<td>:</td>
				<td style="width:40%;">
					<div class="input-group" >
						<span class="input-group-addon" ><b>Rp</b></span>
						<input type="text" class="form-control" name="uangMuka" id="uangMuka" placeholder="0" disabled value="<?php //echo $row->uang_muka;?>" style="border: 2px solid  #7DBE64;">
						<span class="input-group-btn">
							<button type="btn" class="btn btn-primary" onclick="selisihUangMuka()" >Input</button>
						</span>
					</div>
				</td>
				<td style="width:40%;">
				<div class="input-group" >
						<span class="input-group-addon" ><b>Rp</b></span>
						<input type="text" class="form-control" name="selisih" id="selisih" placeholder="Sisa"   style="border: 2px solid  #7DBE64;">
						
					</div>
				</td>
			</tr>-->
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
			<!--<tr>
				<th>Dibayar Kartu Kredit/Debit</th>
				<td>:</td>
				<td><input type="text" class="form-control" name="no_kartuk" id="no_kartuk" placeholder="Nomor Kartu"></td>
				<td><div class="input-group">
						<span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="biaya_k" id="biaya_k" placeholder="Nominal KK/Debit"></td>
				   </div>		
			</tr>
			<tr>
				<th>Charge *)</th>
				<td>:</td>
				
				<td><div class="input-group"><span class="input-group-addon">%</span>								
				<input type="number" class="form-control" step="0.01" name="cashRate" id="cashRate" min=0>	
				<input type="hidden" class="form-control" name="cashFee" id="cashFee">

				<span class="input-group-btn">
					<button type="btn" class="btn btn-primary" onclick="setCash()" >Input</button>
				</span>
				</div></td>
				<td><div class="input-group">
						<span class="input-group-addon">Rp</span>
							<input type="text" class="form-control" name="kartuk" id="kartuk" placeholder="Nominal Akhir KK/Debit" disabled>
				   </div>
				</td>
			</tr>-->
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
	<!--<p style=" margin-left:10px; padding-top:3px;">*) Sesuai dengan kebijakan kartu kredit</p>-->
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
			<?php echo form_open('irj/rjckwitansi/st_cetak_kwitansi_kt');?>
					<input type="hidden" class="form-control" name="penyetor_hide" id="penyetor_hide">
					<input type="hidden" class="form-control" name="pilih" value="0" >
					<input type="hidden" class="form-control" name="no_register" value="<?php echo $no_register ?>">
					<input type="hidden" class="form-control" name="penyetor" id="penyetor_hide_1">
					<input type="hidden" class="form-control" name="jenis_bayar_hide" id="jenis_bayar_hide_1">
					<input type="hidden" class="form-control" name="diskon_hide" id="diskon_hide_1">
					<input type="hidden" class="form-control" name="totakhir_hide" id="totakhir_hide" >
					<input type="hidden" class="form-control" name="charge_rate" id="charge_rate_1" >
					<input type="hidden" class="form-control" name="totakhir_hide" id="totakhir_hide" >
					<input type="hidden" class="form-control" name="charge_fee" id="charge_fee_1" >
					<input type="hidden" class="form-control" name="nilai_kk" id="nilai_kk_1" >
					<input type="hidden" class="form-control" name="nilai_tunai" id="nilai_tunai_1" >
					<input type="hidden" class="form-control" name="totfinal_hide" id="totfinal_hide_1">
					<span>
						<button type="submit" id="btn-cetak" class="btn btn-primary">Cetak</button>
					</span>									
			<?php echo form_close();?>
			</div>
			<!--<div class="input-group">			
			<?php //echo form_open('irj/rjckwitansi/st_cetak_kwitansi_kt');?>
					
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
			<?php //echo form_close();?>
				</div>-->
			<?php }?>
		</div><!-- end panel body-->
		</div><!--- end panel -->
			</div><!--- end panel -->

		</section>
	</div><!--- end container -->

<script type='text/javascript'>	
var site = "<?php echo site_url();?>";
$(document).ready(function() {	    	
	var cara_bayar = "<?php echo $data_pasien->cara_bayar;?>"; 
	//alert(cara_bayar);

	var total = "<?php echo $jumlah_vtot; ?>";
	
	document.getElementById("jenis_bayar").disabled = true;
	if(total!='0'){
		if(cara_bayar=='BPJS'){
		$("#biaya_t").val('0');
		$('#kredit0').show();
		$("#diskon").val(total);
		setTotal();
		$("#jenis_bayar").val('0').change();
		}else if(cara_bayar=='DIJAMIN')
		{
			$("#jenis_bayar").val('0').change();
			$("#biaya_t").val(total);
			$('#kredit0').show();
		}else if (cara_bayar=='UMUM'){
			$("#jenis_bayar").val('1').change();
			$('#kredit0').hide();
			$("#biaya_t").val(total);
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
	var cara_bayar = "<?php echo $data_pasien->cara_bayar;?>"; 
	var potong=$('#diskon').val();
	$('#diskon_hide_1').val(potong);
	$('#diskon_hide_2').val(potong);
	var tunai =  $('#biaya_t').val();
	//alert("kartuk "+kartuk);alert("potong "+potong);alert("tunai "+tunai);alert("tunai kk "+tunaikk);alert("charge "+charge);
	
	if(tunai==''){
		tunai='0';
	}	
	if(potong==''){
		potong='0';
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
<?php
	$this->load->view('layout/footer.php');
?>
