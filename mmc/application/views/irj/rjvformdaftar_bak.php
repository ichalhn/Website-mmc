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
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  

	$('#date_picker1').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
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

</script>
	
<?php echo $this->session->flashdata('success_msg'); ?>

<br>
<section class="content" style="width:97%;margin:0 auto">
	<div class="row">
		
		<ul class="nav nav-tabs my-tab nav-justified">
			<li class="active"><a data-toggle="tab" href="#home" ><h4>BIODATA</h4></a></li>
	
		</ul>
		<div class="tab-content">
			<div id="home" class="tab-pane fade in active">	
		  
				<div class="panel panel-info">
					<div class="panel-body">
						<br>
						<?php echo form_open_multipart('irj/rjcregistrasi/insert_data_pasien');?>
						<div class="col-sm-12">
							
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="nama">No MR Terakhir</p>
								<div class="col-sm-8">
									<p class="col-sm-3 form-control-label"><?php echo $last_mr;?> </p>
								</div>
							</div>
							<div class="form-group row">
						    <p class="col-sm-3 form-control-label" id="nama">Nama Lengkap *</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="" name="nama" required>
								</div>
							</div>
							
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="sex">Jenis Kelamin *</p>
								<div class="col-sm-8">
									<div class="form-inline">
										<div class="form-group">
											
											<input type="radio" name="sex" value="L" required>&nbsp;Laki-Laki
											&nbsp;&nbsp;&nbsp;
											<input type="radio" name="sex" value="P">&nbsp;Perempuan
										</div>
									</div>
								</div>
							</div>
							
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" >Pilih Identitas</p>
								<div class="col-sm-8">
									<div class="form-inline">
											<select  class="form-control" style="width: 100%" name="jenis_identitas" id="jenis_identitas" onchange="set_ident(this.value)" >
												<option value="">-Pilih Identitas-</option>
												<option value="KTP">KTP</option>
												<option value="SIM">SIM</option>
												<option value="PASPOR">Paspor</option>
												<option value="KTM">KTM</option>
												<option value="NIK">NIK</option>
												<option value="DLL">Lainnya</option>
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
								<p class="col-sm-3 form-control-label" id="no_kartu">No. Kartu Keluarga</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="" name="no_kk" id="no_kk">
								</div>
							</div>							
								<hr>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="no_kartu">No. Kartu BPJS</p>
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
								<p class="col-sm-3 form-control-label" id="tmpt_lahir">Tempat Lahir</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="" name="tmpt_lahir">
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="tgl_lahir">Tanggal Lahir *</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" id="date_picker1" maxDate="0" placeholder="" name="tgl_lahir" required>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="agama">Agama</p>
								<div class="col-sm-8">
									<div class="form-inline">
											<select class="form-control" style="width: 100%" name="agama">
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
								<p class="col-sm-3 form-control-label" id="status">Status</p>
								<div class="col-sm-8">
									<div class="form-inline">
										<div class="form-group">
											<input type="radio" name="status" value="B">&nbsp;Belum Kawin
											&nbsp;&nbsp;&nbsp;
											<input type="radio" name="status" value="K">&nbsp;Sudah Kawin
											&nbsp;&nbsp;&nbsp;
											<input type="radio" name="status" value="C">&nbsp;Cerai
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="goldarah">Golongan Darah</p>
								<div class="col-sm-8">
									<div class="form-inline">
										<select class="form-control" style="width: 100%" name="goldarah">
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
								<p class="col-sm-3 form-control-label" id="wnegara">Kewarganegaraan</p>
								<div class="col-sm-8">
									<div class="form-inline">
										<select class="form-control" style="width: 100%" name="wnegara">
											<option value="WNI">WNI</option>
											<option value="WNA">WNA</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="alamat">Alamat *</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="" name="alamat" required>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="rt_rw">RT - RW</p>
								<div class="col-sm-8">
									<div class="form-inline">
										<input type="text" size="4" class="form-control" placeholder="" name="rt"> - 
										<input type="text" size="4" class="form-control" placeholder="" name="rw">
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
								<p class="col-sm-3 form-control-label" id="kodepos">Kode Pos</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="" name="kodepos">
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="pendidikan">Pendidikan</p>
								<div class="col-sm-8">
									<div class="form-inline">
											<select class="form-control" style="width: 100%" name="pendidikan">
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
								<p class="col-sm-3 form-control-label" id="pekerjaan">Pekerjaan</p>
								<div class="col-sm-8">
									<select class="form-control" style="width: 100%" name="pekerjaan">
													<option value="">-Pilih Pekerjaan Terakhir-</option>
													<option value="SWASTA">SWASTA</option>
													<option value="MAHASISWA">MAHASISWA</option>
													<option value="PELAJAR">PELAJAR</option>	
													<option value="PNS">PNS</option>		
													<option value="TIDAK ADA">TIDAK ADA</option>
													<option value="LAINNYA">LAINNYA</option>
												</select>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="no_telp">No. Telp</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="" maxlength="12" name="no_telp">
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="no_hp">No. HP</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="" maxlength="12" name="no_hp">
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="no_telp_kantor">No. Telp Kantor</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="" maxlength="12" name="no_telp_kantor">
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="email">Email</p>
								<div class="col-sm-8">
									<input type="email" class="form-control" placeholder="" name="email">
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="nm_ibu_istri">Nama Ibu Kandung</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" placeholder="" name="nm_ibu_istri">
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="foto">Foto</p>
								<div class="col-sm-8">
									<div class="input-group">
										<input type="file" name="userfile" accept="image/jpeg, image/png, image/gif">
										<input type="text" class="form-control filefield browse" readonly="" value="" />
										<span class="input-group-btn">
											<button class="btn btn-info btn-flat" type="button" id="browseBtn">Browse</button>
										</span>

									</div>
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
			
	</div><!--- end row -->
</section>
	
<?php
	$this->load->view('layout/footer.php');
?>
