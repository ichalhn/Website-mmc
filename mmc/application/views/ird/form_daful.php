<?php $this->load->view("layout/header"); ?>

<?php 
	foreach($detail_pasien as $row){ 
	$no_register=$row->no_register;
	$alber=$row->alasan_berobat;
	$hubungan=$row->hubungan;
	$datang_dengan=$row->datang_dengan;
	$diagnosa1 = $row->diagnosa;
	$dokter1 = $row->id_dokter;
	$nmdokter = $row->nm_dokter;
	$idkecelakaan = $row->kecelakaan;
	$asalrujukan = $row->asal_rujukan;
	$carabayar = $row->cara_bayar;
	$nokartu1 = $row->no_kartu;
	$kelas1=$row->kelas_pasien;
	$nosep1=$row->no_sep;
	$statusBp=$row->status_bpjs;
}
?>
<script>
$(document).ready(function() {
	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
	      checkboxClass: 'icheckbox_flat-green',
	      radioClass: 'iradio_flat-green'
	    });

	$('.select2').select2();
	//$("#biayadaftar_").maskMoney({thousands:',', decimal:'.', affixesStay: true});

	$('.date_picker').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  


	var bp = "<?php echo $statusBp;?>";		
	if(bp!=''){
	$("#statusBpj").val(bp);
	}	
	
	var nosep = "<?php echo $nosep1;?>";		
	if(nosep==''){
		$('#btn-cetak-sep').addClass('disabled');
	}

	var alber = "<?php echo $alber;?>";	
	if(alber!=''){$("#alber1").val(alber);}

	var hubungan = "<?php echo $hubungan;?>";
	if(hubungan!=''){
	$("#hubungan1").val(hubungan);
	}

	if(alber=='sakit'){
		$("#input_kecelakaan").hide();
	}else{
		$("#input_kecelakaan").show();
	}
	
	var dtg_dgn="<?php echo $datang_dengan; ?>";
	$("#pasdatDg").val(dtg_dgn);
	
	var diag = "<?php echo $diagnosa1;?>";
	var n = diag.length;

	if(diag.length>5){
		
		$("#diagnosa1").hide();
		$("#diagnosa2").show();
		$("#item_diag_lain").val(diag);
		
		
	}else{
		//alert(diag);
		$("#diagnosa2").hide();
		$("#diagnosa1").show();
		$("#id_diagnosa").val(diag);
		
	}
	
	var dokter = "<?php echo $dokter1;?>";
	var nmdokter = "<?php echo $nmdokter;?>";

	if(dokter!=''){
		$("#operatorTindakan").val(dokter+'@'+nmdokter);		
	}

	var kecelakaan = "<?php echo $idkecelakaan;?>";	
	if(kecelakaan!='')
	{
		$("#jenis_kecelakaan").val(kecelakaan);
	}
	//$row1->id_dokter.'@'.$row1->nm_dokter.
	
	
	var rujukan = "<?php echo $asalrujukan;?>";
	if(rujukan!='')
	{
		$("#asal_rujukan").val(rujukan);
	}

	var carabayar = "<?php echo $carabayar;?>";
	if(carabayar!='')
	{
		$("#cara_bayar1").val(carabayar).change();
		if(carabayar=='BPJS'){
			var noBpjs = "<?php echo $nokartu1; ?>";			
			if(noBpjs!=''){
				document.getElementById("content_warn_kartu").innerHTML = "No. Kartu : "+noBpjs;
			}else{
				document.getElementById("content_warn_kartu").innerHTML = "Isi terlebih dahulu No. Kartu BPJS Pasien";
			}
		}
	}

});
var ajaxku;
function pilih_cara_bayar(val_cara_bayar){
		var res=val_cara_bayar.split("-");//it Works :D
		if(val_cara_bayar!=''){
			//document.getElementById("biayadaftar").value = res[1];
			document.getElementById("cara_bayar1").value = val_cara_bayar;
		}else{
			//document.getElementById("biayadaftar").value = '';
			document.getElementById("cara_bayar1").value = '';
		}//alert(val_cara_bayar);
		if(val_cara_bayar=='DIJAMIN / JAMSOSKES'){
			$('#cek_sep').hide();
			$('#input_kontraktor').show();
			$('#divNoSEP').hide();
			//$('#btnUpdate').show();
			//$('#btnCetak').hide();
			document.getElementById("jenis_kontraktor").required= true;
			$('#btn-cetak-sep').show();
			$('#warn_kartu').hide();
		}else{
			$('#input_kontraktor').hide();
			$('#cek_sep').hide();
			$('#warn_kartu').hide();
			$('#btn-cetak-sep').hide();
			$('#divNoSEP').hide();
			document.getElementById("jenis_kontraktor").required= false;
			//$('#btnUpdate').show();
			//$('#btnCetak').hide();
		}
		if(val_cara_bayar=='BPJS'){
			//document.getElementById("biayadaftar_").value='0';
			//document.getElementById("biayadaftar").value='0';
			$('#cek_sep').show();
			//$('#btnUpdate').hide();
			$('#btn-cetak-sep').show();
			//warn_kartu
			$('#warn_kartu').show();
			$('#divNoSEP').show();
			var noBpjs = "<?php echo $nokartu1; ?>";			
			if(noBpjs!=''){
				document.getElementById("content_warn_kartu").innerHTML = "No. Kartu : "+noBpjs;
			}else{
				document.getElementById("content_warn_kartu").innerHTML = "Isi terlebih dahulu No. Kartu BPJS Pasien";
			}
			//alert('hahahaha');
			//$("#no_rujukan").attr("disabled", true);
			//$("#asal_rujukan").attr("disabled", true);
			//document.getElementById("no_rujukan").required = true;
			//document.getElementById("asal_rujukan").required = true;
			//document.getElementById("tgl_rujukan").required = true;
			//document.getElementById("cek_sep").show;
			//$('#biayadaftar_').val('0');
			//$('#biayadaftar').val('0');
		}else{
			$('#btn-cetak-sep').hide();
			$('#cek_sep').hide();
			$('#warn_kartu').hide();
			//$('#btnUpdate').show();
			//$('#btnCetak').hide();
			//divNoSEP
			$('#divNoSEP').hide();
			document.getElementById("no_rujukan").required = false;
			document.getElementById("asal_rujukan").required = false;
			document.getElementById("tgl_rujukan").required = false;
			//$("#no_rujukan").removeAttr("disabled");
			//$("#asal_rujukan").removeAttr("disabled");
			//document.getElementById("biayadaftar_").value='15,000';
			//document.getElementById("biayadaftar").value='15000';
			//$('#biayadaftar_').val('15,000');
			//$('#biayadaftar').val('15000');
		}
	}

function pilih_alber(val_alber){
		var res=val_alber.split("-");//it Works :D				
		if(res=='kecelakaan'){
			$('#input_kecelakaan').show();
		}else{
			$('#input_kecelakaan').hide();
		}
	}

function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}

function cek_nokartu(no_medrec){
    ajaxku = buatajax();
    var url="<?php echo site_url('ird/IrDRegistrasi/check_no_kartu'); ?>";
    url=url+"/"+no_medrec;
    ajaxku.onreadystatechange=stateChangedSEP;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
}

function stateChangedSEP(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("data_anggota").innerHTML = data;
			$('#data_webservice').modal('show');
		}else{
			document.getElementById("data_anggota").innerHTML = "Data Tidak Ditemukan";
		}
    }
}

function ambil_sep(){
	var url_sep="<?php echo site_url('ird/IrDRegistrasi/ambil_sep'); ?>";
	var no_reg = "<?php echo $no_register;?>";
	$.ajax({
        type: "POST",
        url: url_sep+"/"+no_reg,
    }).done(function(msg) {
    	obj = JSON.parse(msg);
    	if(obj.status == 0){
    		alert(obj.response);
		$('#btn-cetak-sep').addClass('disabled');
		document.getElementById("btn-cetak-sep").disabled = true;
    	}else{
    	  	$('#no_sep').val(obj.response);
		$('#no_sep_hidden').val(obj.response);
		$('#btn-cetak-sep').removeClass('disabled');
    	}
    });
}
</script>
<section class="content">
<div class="panel panel-info">					
					<div class="panel-heading" align="center"><h4>DETAIL PASIEN</h4></div>
					
					<div class="panel-body" id="biodataIRD">
						<div class="col-sm-8 col-lg-offset-1">				

							<?php					
								foreach($detail_pasien as $row){
								$no_medrec=$row->no_medrec;
								$nama=$row->nama;
								$no_register=$row->no_register;
								
								//cek jenis kunjungan
								if ( date("Y-m-d") == substr($row->tgl_daftar,0,10) ) 
									$jns_kunjungan="BARU";
								else $jns_kunjungan="LAMA";
							?>							
							<?php echo form_open('ird/IrDRegistrasi/update_daful');?>
							<input type="hidden" class="form-control" value="<?php echo $row->no_medrec;?>"name="no_medrec">
							<input type="hidden" class="form-control" value="<?php echo $row->no_register;?>"name="no_register">
							<input type="hidden" id="no_sep_hidden" name="no_sep_hidden">
						<div style="margin-left:18px;margin-right:18px;">
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="jns_kunj">Jenis Kunjungan</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" readonly name="no_medrec">
												<?php echo ($jns_kunjungan == "LAMA" ? 
												
													'
													<input type="radio" class="flat-red" name="jns_kunj" class="jns_kunj" value="LAMA" checked>&nbsp;Lama
													&nbsp;&nbsp;&nbsp;
													<input type="radio" class="flat-red " name="jns_kunj" class="jns_kunj" value="BARU" disabled>&nbsp;Baru
									
													<input type="hidden"  name="jns_kunj" value="'.$jns_kunjungan.'">
													'
												:
												
													'
													<input type="radio"  class="flat-red" name="jns_kunj" class="jns_kunj" value="LAMA" disabled>&nbsp;Lama
													&nbsp;&nbsp;&nbsp;
													<input type="radio" class="flat-red" name="jns_kunj" class="jns_kunj" value="BARU" checked>&nbsp;Baru
													
													<input type="hidden" name="jns_kunj" value="'.$jns_kunjungan.'">
													'
												);
												?>
												
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="namapserta">Nama</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" value="<?php echo $row->nama;?>" name="nama" readonly>
									</div>
								</div>
								<div class="form-group row">
								<!----------------- ---->
									<p class="col-sm-4 form-control-label" >Cara Bayar*</p>
									<div class="col-sm-8">
												<select id="cara_bayar1" class="form-control" name="cara_bayar" onchange="pilih_cara_bayar(this.value)" required>					
													<option value="">-Pilih Cara Bayar-</option>
													<?php 
													foreach($cara_bayar as $row1){
														echo '<option value="'.$row1->cara_bayar.'">'.$row1->cara_bayar.'</option>';
													}
													?>
												</select>
									</div>
									
								</div>
								<div class="form-group row" id="input_kontraktor">
									<p class="col-sm-4 form-control-label" id="lbl_input_kontraktor">Kontraktor*</p>
									<div class="col-sm-8">
										<select id="jenis_kontraktor" class="form-control select2" name="jenis_kontraktor" style="width : 100%;">
											<option value="">-Pilih Kontraktor-</option>
											<?php 
											foreach($daful_kontraktor as $row1){
											if($row->id_kontraktor!='' and $row->id_kontraktor==$row1->id_kontraktor){ echo '<option value="'.$row1->id_kontraktor.'">'.$row1->nmkontraktor.'</option>';} else
											echo '<option value="'.$row1->id_kontraktor.'">'.$row1->nmkontraktor.'</option>';
													}
													?>
										</select>
									</div>
								</div>
								<div class="form-group row" id="cek_sep" name="cek_sep"  style="width:99%;">
									<div class="pull-right"><a href="#responsive" class="btn btn-danger" onclick="cek_nokartu('<?php echo $no_medrec;?>')" >Validasi</a>
									</div>
									
								</div>
								<div class="form-group row" id="warn_kartu">
									<p class="col-sm-4 form-control-label"></p>
									<div class="col-sm-8">
										<p class="form-control-label" id="content_warn_kartu" style="color: red;"></p>
									</div><br>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" >Asal Rujukan </p>
									<div class="col-sm-8">
												<select class="form-control select2" style="width: 100%" name="asal_rujukan" id="asal_rujukan">
													<?php if($row->asal_rujukan!=''){ echo '<option value='.$row->asal_rujukan.'>'.$row->nm_ppk.'</option>'; } ?>
													<option value="0">-Pilih Asal Rujukan-</option>
													<option value="1">Lainnya</option>
													<?php 
													foreach($ppk as $row1){
														echo '<option value="'.$row1->kd_ppk.'">'.$row1->nm_ppk.'</option>';
													}
													?>
												</select>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" >No. SJP/Rujukan</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="no_rujukan" id="no_rujukan" value="<?php echo $row->no_rujukan; ?>">
									</div>
								</div>	
								<div class="form-group row">
									<p class="col-sm-4 form-control-label"> Tgl. Rujukan</p>
									<div class="col-sm-8">
										<input type="text" class="form-control date_picker" placeholder="" id="tgl_rujukan" name="tgl_rujukan" value="<?php if($row->tgl_rujukan!=''){echo date("Y-m-d", strtotime($row->tgl_rujukan));} ?>">
									</div>
								</div>					
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="kelas_pasien">Kelas Pasien</p>
									<div class="col-sm-8">
										<select class="form-control" name="kelas_pasien" id="kelas_pasien1" required >
											
											<option value="III">III</option>							
													
										</select>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="tanggal_kunj">Tanggal Kunjungan</p>
									<div class="col-sm-8">
										<input type="date" class="form-control" placeholder="eg : 2001-05-11" id="tgl_kunj" name="tgl_kunj" value="<?php echo date('Y-m-d', strtotime($row->tgl_kunjungan)); ?>"  required>
									</div>
								</div>
								
								
								
								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="nama_penjamin">Nama Penjamin</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="nama_penjamin" value="<?php echo $row->nama_penjamin;?>">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="alber">Alasan Berobat</p >
										<div class="col-sm-8">
										<select class="form-control" name="alber" id="alber1" onchange="pilih_alber(this.value)" required>
											
											<option value="sakit">Sakit</option>
											<option value="kecelakaan">Kecelakaan</option>
											<!--<option value="lain">lain-lain</option>-->
										</select></div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="pasdatDg">Datang dengan</p>
									<div class="col-sm-8"><select class="form-control" name="pasdatDg" id="pasdatDg" required>									
										<option value="klg">Keluarga</option>
										<option value="ttg">Tetangga</option>
										<option value="lain">Lain-lain</option>
									</select></div>
								</div>								
								<div class="form-group row" id="input_kecelakaan">
									<p class="col-sm-4 form-control-label" id="Kclkaan">Kecelakaan</p>
									<div class="col-sm-8">
										<select  class="form-control" name="jenis_kecelakaan" id="jenis_kecelakaan">
													<option value="">-Pilih Jenis Kecelakaan-</option>
													<?php
													foreach($jenis_kecelakaan as $row1){
														echo '<option value="'.$row1->id.'">'.$row1->nm_kecelakaan.'</option>';
													}
													?>
												</select>
										
									</div>
								</div>
								
								<div class="form-group row" id="diagnosa1">
									<p class="col-sm-4 form-control-label" >Diagnosa*</p>
									<div class="col-sm-8">																					
										<select id="id_diagnosa" name="id_diagnosa" class="form-control "  required>
													<option value="">-Pilih Diagnosa-</option>
													
													<?php 
													foreach($diagnosa as $row1){
														echo '<option value="'.$row1->id_icd.'">'.$row1->id_icd.' - '.$row1->nm_diagnosa.'</option>';
													}
													?>
												</select>			
									</div>
								</div>								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" >Operator</p>
										<div class="col-sm-8">
											<select class="form-control " name="operatorTindakan" id="operatorTindakan" required >											
											<option value="">-Pilih Operator-</option>											
													<?php 
												
													foreach($operator as $row1){
														echo '<option value="'.$row1->id_dokter.'@'.$row1->nm_dokter.'">'.$row1->id_dokter.' - '.$row1->nm_dokter.'</option>';
													}
													?>
											</select>
										</div>
								</div>
								<div class="form-group row" id="diagnosa2">
									<p class="col-sm-4 form-control-label" ></p>
									<div class="col-sm-8">
										<input id="item_diag_lain" type="text" name="item_diag_lain" style="width:100%;">
</div>
								</div>								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="hubungan">Hubungan Keluarga</p>
									<div class="col-sm-8">
										<select class="form-control" name="hubungan" id="hubungan1">
																						
											<option value="">-Hubungan Keluarga-</option>
											<option value="klg">Keluarga</option>
											<option value="Pk_kant">Pekerja Kantor</option>
											<option value="lain">Lain-lain</option>
										</select>
									</div>
								</div>
								<div class="form-group row" id="divNoSEP">
									<p class="col-sm-4 form-control-label" >No SEP</p>
									<div class="col-sm-8">
										<div class="input-group">
											
											<input type="text" class="form-control" name="no_sepa" id="no_sep" disabled value="<?php echo $row->no_sep;?>">
											
											<span class="input-group-btn">
											<button type="button" class="btn btn-primary btn-sm" onclick="ambil_sep()"><i class="fa fa-save"></i> Ambil SEP</button>			</span>
										</div>
									</div>
								</div>
								<div class="form-inline" align="right">
									<div class="form-group">
										<!--<a href="#" class="btn btn-danger" >Cetak Kartu Poli</a>-->
										<button type="submit" class="btn btn-primary" id="btnSimpan" >Simpan</button>							
										<a href="<?php echo site_url('ird/IrDRegistrasi/cetak_sep/'.$no_register);?>" target="_blank" class="btn btn-primary" id="btn-cetak-sep">Cetak SEP</a>
											
										
									</div>
								</div>
							<?php echo form_close();}?>
					</div></div>
					<!--- end panel body--->
				</div></div>
</section>
<?php
	include('webservice_modal.php');
	?>
<?php $this->load->view("layout/footer"); ?>
