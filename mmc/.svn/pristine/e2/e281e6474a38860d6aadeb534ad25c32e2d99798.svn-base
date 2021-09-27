<?php
	$this->load->view('layout/header.php');
?>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(function() {
	$(".select2").select2();
	$("#duplikat_id").hide();
	$("#duplikat_kartu").hide();

	$('#date_picker').datepicker({
		format: "yyyy-mm-dd",
		
		autoclose: true,
		todayHighlight: true,
	});

	$('#date_picker1').datepicker({
		format: "yyyy-mm-dd",
		
		autoclose: true,
		todayHighlight: true,
	});  

	$('.auto_search_by_nonrp').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_pasien_by_nonrp',
		onSelect: function (suggestion) {
			$('#no_nrp').val(''+suggestion.no_nrp);
			$('#hidden_no_nrp').val(''+suggestion.no_nrp);
		}
	});

	$('#chk1').change(function() {
	 // alert($(this).prop('checked'))
	  if($(this).prop('checked')==false){
	  	$('#input_tentara').hide();
	  }else{
	  	$('#input_tentara').show();
	  }
	});
});	

var ajaxku;
function ajaxkota(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi/data_kotakab'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedKota;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_provinsi").value = res[0];
	document.getElementById("provinsi").value = res[1];
}

function ajaxkec(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi/data_kecamatan'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedKec;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_kotakabupaten").value = res[0];
	document.getElementById("kotakabupaten").value = res[1];
}

function ajaxkel(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi/data_kelurahan'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedKel;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_kecamatan").value = res[0];
	document.getElementById("kecamatan").value = res[1];
}
function setkel(id){
	var res=id.split("-");//it Works :D
	document.getElementById("id_kelurahandesa").value = res[0];
	document.getElementById("kelurahandesa").value = res[1];
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
function stateChangedKota(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
		document.getElementById("kota").innerHTML = data;
		document.getElementById("kec").innerHTML = "<option selected value=\"\">Pilih Kecamatan</option>";
		document.getElementById("kel").innerHTML = "<option selected value=\"\">Pilih Kel/Desa</option>";
    }else{
    document.getElementById("kota").value = "<option selected value=\"\">Pilih Kota/Kab</option>";
    }
    }
}

function stateChangedKec(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
    document.getElementById("kec").innerHTML = data
    }else{
    document.getElementById("kec").value = "<option selected value=\"\">Pilih Kecamatan</option>";
    }
    }
}

function stateChangedKel(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
    document.getElementById("kel").innerHTML = data
    }else{
    document.getElementById("kel").value = "<option selected value=\"\">Pilih Kelurahan/Desa</option>";
    }
    }
}

function cek_no_identitas(no_identitas){
	if(no_identitas!=''){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_noidentitas')?>/"+no_identitas+"/",
		success: function(data){
			if (data>0) {
				document.getElementById("content_duplikat_id").innerHTML = "<i class=\"icon fa fa-ban\"></i> No Identitas \""+no_identitas+"\" Sudah Terdaftar ! <br>Silahkan masukkan no identitas lain...";
				$("#duplikat_id").show();
				document.getElementById("btn-submit").disabled= true;
				//$(window).scrollTop(0);
			} else {
				$("#duplikat_id").hide();
				document.getElementById("btn-submit").disabled= false;
			}
		},
		error: function (request, status, error) {
			alert(request.responseText);
		}
    });}
}

function set_ident(ident){
	//alert(ident);
	if(ident!=''){
		document.getElementById("no_identitas").required= true;
 	}else
		document.getElementById("no_identitas").required= false;
}

function cek_no_kartu(no_kartu){
	if(no_kartu!=''){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_nokartu')?>/"+no_kartu+"/",
		success: function(data){
			//alert(data);
			if (data>0) {
				//alert("No Kartu '"+no_kartu+"' Sudah Terdaftar ! <br> Silahkan masukkan no kartu lain...");
				document.getElementById("content_duplikat_kartu").innerHTML = "<i class=\"icon fa fa-ban\"></i> No Kartu \""+no_kartu+"\" Sudah Terdaftar ! Silahkan masukkan no kartu lain...";
				$("#duplikat_kartu").show();
				document.getElementById("btn-submit").disabled= true;
			} else {
				$("#duplikat_kartu").hide();
				document.getElementById("btn-submit").disabled= false;
			}
		},
		error: function (request, status, error) {
			alert(request.responseText);
		}
   	 });
 	}
}

function cek_no_nrp(){
	nrp=$("#no_nrp").val();
		
	if(nrp!='' && $("#nrp_sbg").val()!=''){
		nrpurl=nrp.replace(/\//g , "%2F");
		$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_nonrp1')?>/"+URLEncoder.encode(nrp, "UTF-8")+"/"+$("#nrp_sbg").val(),
		success: function(data){
			alert(data[0].nama_anggota);
			if (data!='') {
				//alert("No Kartu '"+no_kartu+"' Sudah Terdaftar ! <br> Silahkan masukkan no kartu lain...");
				document.getElementById("content_duplikat_nrp").innerHTML = "<i class=\"icon fa fa-ban\"></i> No NRP \""+$("#no_nrp").val()+"\" Sudah Terdaftar. Silahkan melanjutkan pembaharuan data";
				$("#duplikat_kartu").show();
				//document.getElementById("btn-submit").disabled= true;
				if(data[0].kst_id!=''){
					$("#kesatuan").val(data[0].kst_id).change();
				}
				
				if(data[0].pkt_id!=''){
					$("#pangkat").val(data[0].pkt_id).change();
				}
				if(data[0].angkatan!=''){
					$("#angkatan").val(data[0].angkatan).change();
				}
				
				if(data[0].tgl_nonaktif!=''){
					$("#date_picker").val(data[0].tgl_nonaktif);
				}

				if(data[0].nama_anggota!=''){
					$("#nama").val(data[0].nama_anggota);
				}


				if(data[0].tmpt_lahir!=''){
					$("#tmpt_lahir").val(data[0].tmpt_lahir);
				}

				if(data[0].tgl_lahir!=''){
					$("#date_picker1").val(data[0].tgl_lahir);
				}

				if(data[0].sex!=''){
					if(data[0].sex=='L'){
						$("#sexl").prop('checked', true);
					}else
						$("#sexp").prop('checked', true);
				}

				//no_identitas				
				if(data[0].nik!=''){
					$("#no_identitas").val(data[0].nik);
				}

				if(data[0].bpjs!=''){
					$("#no_kartu").val(data[0].bpjs);
				}				

				if(data[0].status!=''){
					if(data[0].status=='B'){
						$("#statusb").prop('checked', true);
					}else
						$("#statusk").prop('checked', true);
				}

				if(data[0].agama!=''){
					$("#agama").val(data[0].agama).change();
				}

				if(data[0].pendidikan!=''){
					$("#pendidikan").val(data[0].pendidikan).change();
				}

				if(data[0].alamat!=''){
					$("#alamat").val(data[0].alamat);
				}

				if(data[0].rt!=''){
					$("#rt").val(data[0].rt);
				}

				if(data[0].rw!=''){
					$("#rw").val(data[0].rw);
				}

				if(data[0].id_provinsi!=''){
					$("#prop").val(data[0].id_provinsi).change();
				}

				if(data[0].id_kotakabupaten!=''){
					$("#kota").val(data[0].id_kotakabupaten).change();
				}

				if(data[0].id_kecamatan!=''){
					$("#kec").val(data[0].id_kecamatan).change();
				}

				if(data[0].id_kelurahandesa!=''){
					$("#kel").val(data[0].id_kelurahandesa).change();
				}

				if(data[0].kodepos!=''){
					$("#kodepos").val(data[0].kodepos);
				}

				//no_telp
				if(data[0].no_telp!=''){
					$("#no_telp").val(data[0].no_telp);
				}

				if(data[0].no_hp!=''){
					$("#no_hp").val(data[0].no_hp);
				}

				if(data[0].persh_tlp!=''){
					$("#no_telp_kantor").val(data[0].persh_tlp);
				}

			} else {
				document.getElementById("content_duplikat_nrp").innerHTML = "<i class=\"icon fa fa-ban\"></i> No NRP \""+$("#no_nrp").val()+"\" Belum Terdaftar. Silahkan melanjutkan pengisian data";
				$("#duplikat_kartu").hide();
				//document.getElementById("btn-submit").disabled= false;
			}
		},
		error: function (request, status, error) {
			alert(request.responseText);
		}
   	 });
 	}else alert("Input nomor NRP dan jenis tentara terlebih dahulu");
}

function set_tentara(tni){
	alert(tni);
	if(tni!='T'){
		//$("#medrecnrp").hide();
		//$("#nonrp").hide();
		document.getElementById("no_nrp").required= false;
		//document.getElementById("medrecnrp").required= false;
	}
	/*else if(tni!='0'){
		$("#medrecnrp").show();
		$("#nonrp").hide();
		document.getElementById("nonrp").required= false;
		document.getElementById("medrecnrp").required= true;
 	}*/else{
 		//$("#medrecnrp").hide();
		//$("#nonrp").show();
		document.getElementById("kesatuan").required= true;
		document.getElementById("pangkat").required= true;
		document.getElementById("angkatan").required= true;
		//document.getElementById("medrecnrp").required= false;
 	}
}
</script>
	
<?php echo $this->session->flashdata('success_msg'); ?>

<br>
<section class="content" style="width:97%;margin:0 auto">
	<div class="row">
		
		<ul class="nav nav-tabs my-tab nav-justified">
			<li class="active"><a data-toggle="tab" href="#home" ><h4>BIODATA PASIEN TNI</h4></a></li>
	
		</ul>
		<div class="tab-content">
			<div id="home" class="tab-pane fade in active">	
		  
				<div class="panel panel-info">
					<div class="panel-body">
						<br>
						<?php echo form_open_multipart('irj/rjctni/insert_data_tni');?>
						<div class="col-sm-6">							
									<div class="form-group row" id="inputtentara">
										<p class="col-sm-3 form-control-label">Tentara</p>
										<div class="col-sm-8">
											<select name="nrp_sbg" id="nrp_sbg" class="form-control select2" style="width: 100%" onchange="set_tentara(this.value)">
												<option value="">-Pilih Jenis-</option>
														<?php 
												foreach($hubungan as $row){
												echo '<option value="'.$row->hub_id.'">'.$row->hub_name.'</option>';
												}
												?>
														
											</select>
											
											
										</div>
									</div>									
									<div class="form-group row" id="nonrp">
										<p class="col-sm-3 form-control-label"></p>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="no_nrp" id="no_nrp" placeholder="Nomor NRP*" style="width: 230px;" required="">
											<input type="hidden" class="form-control "  name="hidden_no_nrp" id="hidden_no_nrp" >											
										</div>
									</div>
									<div class="form-group row" id="nonrp">
										<p class="col-sm-3 form-control-label"></p>
										<div class="col-sm-8">											
											<button class="btn btn-warn" id="cek_nrp" onclick="cek_no_nrp()">Cek</button>
										</div>
									</div>
									<div class="form-group row" id="duplikat_nrp">
										<p class="col-sm-3 form-control-label"></p>
										<div class="col-sm-8">
											<p class="form-control-label" id="content_duplikat_nrp" style="color: red;"></p>
										</div>
									</div>

									<div class="form-group row" >
										<p class="col-sm-3 form-control-label">Kesatuan</p>
										<div class="col-sm-8">
											<select name="kesatuan" id="kesatuan" class="form-control select2" style="width: 100%" >
												<option value="">-Pilih Kesatuan-</option>
												<?php 
												foreach($kesatuan as $row){
												echo '<option value="'.$row->kst_id.'">'.$row->kst_nama.'</option>';
												}
												?>
														
											</select>
											
											
										</div>
									</div>
									<div class="form-group row" >
										<p class="col-sm-3 form-control-label">Pangkat</p>
										<div class="col-sm-8">
											<select name="pangkat" id="pangkat" class="form-control select2" style="width: 100%" >
												<option value="">-Pilih Pangkat-</option>
												<?php 
												foreach($pangkat as $row){
												echo '<option value="'.$row->pangkat_id.'">'.$row->pangkat.'</option>';
												}
												?>
														
											</select>
											
											
										</div>
									</div>
									<div class="form-group row" >
										<p class="col-sm-3 form-control-label">Angkatan</p>
										<div class="col-sm-8">
											<select name="angkatan" id="angkatan" class="form-control select2" style="width: 100%" >
												<option value="">-Pilih Angkatan-</option>
												<?php 
												foreach($angkatan as $row){
												echo '<option value="'.$row->angkatan.'">'.$row->angkatan.'</option>';
												}
												?>
														
											</select>
											
											
										</div>
									</div>
									<div class="form-group row">
										<p class="col-sm-3 form-control-label" id="tgl_nonaktif">Tanggal Non-aktif</p>
										<div class="col-sm-8">
											<input type="text" class="form-control" id="date_picker" placeholder="" name="tgl_nonaktif">
										</div>
									</div>											

									<hr>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label">Nama Lengkap *</p>
								<div class="col-sm-8">
									<input type="text" class="form-control"  id="nama" placeholder="" name="nama" required>
								</div>
							</div>
							
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" >Jenis Kelamin *</p>
								<div class="col-sm-8">
									<div class="form-inline">
										<div class="form-group">
											
											<input type="radio" id="sexl" name="sex" value="L" required>&nbsp;Laki-Laki
											&nbsp;&nbsp;&nbsp;
											<input type="radio" id="sexp" name="sex" value="P">&nbsp;Perempuan
										</div>
									</div>
								</div>
							</div>
							
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" >Pilih Identitas</p>
								<div class="col-sm-8">
									<div class="form-inline">
											<select  class="form-control" style="width: 100%" name="jenis_identitas" id="jenis_identitas" onchange="set_ident(this.value)" >
												<option value="KTP">KTP</option>
											</select>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" >No. Identitas</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="" name="no_identitas" id="no_identitas" onchange="cek_no_identitas(this.value)">
								</div>
							</div>
							<div class="form-group row" id="duplikat_id">
								<p class="col-sm-3 form-control-label"></p>
								<div class="col-sm-8">
									<p class="form-control-label" id="content_duplikat_id" style="color: red;"></p>
								</div>
							</div>							

							<div class="form-group row">
								<p class="col-sm-3 form-control-label" >No. Kartu BPJS</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="" name="no_kartu" id="no_kartu" onchange="cek_no_kartu(this.value)">
								</div>
							</div>
							
							<div class="form-group row" id="duplikat_kartu">
								<p class="col-sm-3 form-control-label"></p>
								<div class="col-sm-8">
									<p class="form-control-label" id="content_duplikat_kartu" style="color: red;"></p>
								</div>
							</div>							
							<div class="form-group row">
								<p class="col-sm-3 form-control-label">Tempat Lahir *</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="tmpt_lahir" placeholder="" name="tmpt_lahir" required>
								</div>
							</div>
						</div><!-- end col-sm-6-->
						<div class="col-sm-6">
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" >Tanggal Lahir *</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="date_picker1" maxDate="0" placeholder="" name="tgl_lahir" required>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" >Agama</p>
								<div class="col-sm-8">
									<div class="form-inline">
											<select class="form-control" style="width: 100%" id="agama" name="agama">
												<option value="">-Pilih Agama-</option>
												<option value="ISLAM">Islam</option>
												<option value="KATOLIK">Katolik</option>
												<option value="PROTESTAN">Protestan</option>
												<option value="BUDHA">Budha</option>
												<option value="HINDU">Hindu</option>
												<option value="KONGHUCU">Konghucu</option>
											</select>
										
									</div>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" >Status</p>
								<div class="col-sm-8">
									<div class="form-inline">
										<div class="form-group">
											<input type="radio" id="statusb" name="status" value="B">&nbsp;Belum Kawin
											&nbsp;&nbsp;&nbsp;
											<input type="radio" id="statusk" name="status" value="K">&nbsp;Sudah Kawin
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" >Golongan Darah</p>
								<div class="col-sm-8">
									<div class="form-inline">
										<select class="form-control" style="width: 100%" id="goldarah" name="goldarah">
											<option value="">-Pilih Golongan Darah-</option>
											<option value="A+">A+</option>
											<option value="A-">A-</option>
											<option value="B+">B+</option>
											<option value="B-">B-</option>
											<option value="AB+">AB+</option>
											<option value="AB-">AB-</option>
											<option value="O+">O+</option>
											<option value="O-">O-</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" >Alamat</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="" id="alamat" name="alamat">
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" >RT - RW</p>
								<div class="col-sm-8">
									<div class="form-inline">
										<input type="text" size="4" class="form-control" placeholder="" id="rt" name="rt"> - 
										<input type="text" size="4" class="form-control" placeholder="" id="rw" name="rw">
									</div>
								</div>
							</div>
							<div class="form-group row">
							<!----------------- ---->
								<p class="col-sm-3 form-control-label" id="lbl_provinsi">Provinsi</p>
								<div class="col-sm-8">
									<div class="form-inline">
											<select id="prop" class="form-control" style="width: 100%" onchange="ajaxkota(this.value)">
												<option value="">-Pilih Provinsi-</option>
												<?php 
												foreach($prop as $row){
													echo '<option value="'.$row->id.'-'.$row->nama.'">'.$row->nama.'</option>';
												}
												?>
											</select>
											<input type="hidden" class="form-control" id="provinsi" placeholder="" name="provinsi">
											<input type="hidden" class="form-control" id="id_provinsi" placeholder="" name="id_provinsi">
										
									</div>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="lbl_kotakabupaten">Kota/Kabupaten</p>
								<div class="col-sm-8">
									<div class="form-inline">
											<select id="kota" class="form-control" style="width: 100%" onchange="ajaxkec(this.value)">
												<option value="">-Pilih Kota/Kabupaten-</option>
											</select>
											<input type="hidden" class="form-control" id="kotakabupaten" placeholder="" name="kotakabupaten">
											<input type="hidden" class="form-control" id="id_kotakabupaten" placeholder="" name="id_kotakabupaten">
									</div>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="lbl_kecamatan">Kecamatan</p>
								<div class="col-sm-8">
									<div class="form-inline">
											<select id="kec" class="form-control" style="width: 100%" onchange="ajaxkel(this.value)">
												<option value="">-Pilih Kecamatan-</option>
											</select>
											<input type="hidden" class="form-control" id="kecamatan" placeholder="" name="kecamatan">
											<input type="hidden" class="form-control" id="id_kecamatan" placeholder="" name="id_kecamatan">
										
									</div>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="lbl_kelurahandesa">Kelurahan</p>
								<div class="col-sm-8">
									<div class="form-inline">
											<select id="kel" class="form-control" style="width: 100%" onchange="setkel(this.value)">
												<option value="">-Pilih Kelurahan/Desa-</option>
											</select>
											<input type="hidden" class="form-control" id="kelurahandesa" placeholder="" name="kelurahandesa">
											<input type="hidden" class="form-control" id="id_kelurahandesa" placeholder="" name="id_kelurahandesa">
									</div>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" >Kode Pos</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="" id="kodepos" name="kodepos">
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" >Pendidikan</p>
								<div class="col-sm-8">
									<div class="form-inline">
											<select class="form-control" style="width: 100%" id="pendidikan" name="pendidikan">
												<option value="">-Pilih Pendidikan Terakhir-</option>
												<option value="SD">SD</option>
												<option value="SMP">SMP</option>
												<option value="SMA">SMA</option>
												<option value="D1">D1</option>
												<option value="D2">D2</option>
												<option value="D3">D3</option>
												<option value="D4">D4</option>
												<option value="S1">S1</option>
												<option value="S2">S2</option>
												<option value="S3">S3</option>
											</select>
									</div>
								</div>
							</div>							
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" >No. Telp</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="" maxlength="15" id="no_telp" name="no_telp">
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" >No. HP</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="" maxlength="15" id="no_hp" name="no_hp">
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" >No. Telp Kantor</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="" maxlength="15" id="no_telp_kantor" name="no_telp_kantor">
								</div>
							</div>							
							<div class="form-inline" align="center">
								<div class="form-group">
									<button type="reset" class="btn bg-orange">Reset</button>
									<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
									<button type="submit" class="btn btn-primary" id="btn-submit">Simpan</button>
									<!--<a href="#" class="btn btn-primary">Cetak Kartu</a>-->
								</div>
							</div>
							<?php echo form_close();?>
						</div><!-- end div col-sm-6-->
					</div><!-- end panel body -->
				</div><!-- end panel info-->
				
			</div><!-- end div id home -->
		</div><!-- end tab content -->
			
	</div><!--- end row --->
</section>
	
<?php
	$this->load->view('layout/footer.php');
?>
