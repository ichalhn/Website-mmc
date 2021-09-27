<?php $this->load->view("layout/header"); ?>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(function(){
	$('.auto_search_by_nocm').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/IrDRegistrasi/data_pasien',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#no_medrec').val(''+suggestion.no_medrec);
		}
	});
	$('.auto_search_poli').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/IrDRegistrasi/data_poli',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#id_poli').val(''+suggestion.id_poli);
			$('#kd_ruang').val(''+suggestion.kd_ruang);
		}
	});
});

	    var ajaxku;
function ajaxkota(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('IrDRegistrasi/data_kotakab'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChanged;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_provinsi").value = res[0];
	document.getElementById("provinsi").value = res[1];
}

function ajaxkec(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('IrDRegistrasi/data_kecamatan'); ?>";
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
    var url="<?php echo site_url('IrDRegistrasi/data_kelurahan'); ?>";
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
function stateChanged(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
    document.getElementById("kota").innerHTML = data
    }else{
    document.getElementById("kota").value = "<option selected>Pilih Kota/Kab</option>";
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
    document.getElementById("kec").value = "<option selected>Pilih Kecamatan</option>";
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
    document.getElementById("kel").value = "<option selected>Pilih Kelurahan/Desa</option>";
    }
    }
}
</script>
	<section class="content-header">
	<!--
		<div class="row">
			<div class="col-md-12">
			  <div class="box box-info box-solid">
				<div class="box-header with-border">
				  Data Berhasil
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				  </div>
				</div>
			  </div>
			</div>
		</div>
	-->
	
				<div class="panel panel-primary">
					<div class="panel-heading" align="center"><h4>PENCARIAN DATA<h4></div>
					<div class="panel-body">
						<br>
						<?php echo form_open('IrDRegistrasi/search_pasien');?>
						<div class="col-md-6 col-md-offset-3">
							<div class="input-group">
								<input type="search" class="auto_search_by_nocm form-control" id="no_medrec" name="no_medrec" placeholder="Pencarian NO CM">
								<span class="input-group-btn">
									<button type="submit" class="btn btn-primary" type="button">Cari</button>
								</span>
							</div>
						</div>
						<?php echo form_close();?>
					</div>
				</div>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading" align="center" style="background-color:#00C0C5;color:#ffffff"><h4>BIODATA</h4></div>
					<div class="panel-body" style="background-color:#BAD8FF;">
						<br>
							<?php
							// print_r($data_pasien);
								foreach($data_pasien as $row){
								$no_medrec=$row->no_medrec;
							?>
							<div class="form-group row">
								<div class="col-sm-12">
									<center><img height="100px" class="img-rounded" src="<?php echo site_url("upload/photo/".$row->foto);?>">
								</div>
							</div>
								
							<?php echo form_open_multipart('IrDRegistrasi/update_pasien_irj');?>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_cm">No CM</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $row->no_medrec;?>" name="no_cm" readonly>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="tgl_daftar">Tanggal Daftar</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $row->tgl_daftar;?>" name="tgl_daftar" readonly>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="sex">Jenis Kelamin</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<?php 
													if($row->sex=='L'){
														echo '<input type="radio" name="sex" value="L" checked required>&nbsp;Laki-Laki&nbsp;&nbsp;&nbsp;
														<input type="radio" name="sex" value="P">&nbsp;Perempuan';
													}else{
														echo '<input type="radio" name="sex" value="L" required>&nbsp;Laki-Laki&nbsp;&nbsp;&nbsp;
														<input type="radio" name="sex" value="P" checked>&nbsp;Perempuan';
													}
												?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="nama">Nama Lengkap</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $row->nama;?>" name="nama" required>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="jenis_identitas">Pilih Identitas</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<select class="form-control" name="jenis_identitas" required>
													<?php echo '<option value="'.$row->jenis_identitas.'">'.$row->jenis_identitas.'</option>';?>
													<option value="">-Pilih Identitas-</option>
													<option value="KTP">KTP</option>
													<option value="SIM">SIM</option>
													<option value="PASPOR">Paspor</option>
													<option value="KTM">KTM</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_identitas">No. Identitas</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $row->no_identitas;?>" name="no_identitas" required>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="jenis_kartu">Pilih Kartu</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<select class="form-control" name="jenis_kartu">
													<?php echo '<option value="'.$row->jenis_kartu.'">'.$row->jenis_kartu.'</option>';?>
													<option value="">-Pilih Kartu-</option>
													<option value="BPJS">BPJS</option>
													<option value="ASKES">ASKES</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_kartu">No. Kartu</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $row->no_kartu;?>" name="no_kartu">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="tmpt_lahir">Tempat Lahir</p>
									<div class="col-sm-8">
										<input type="text" class="form-control"  value="<?php echo $row->tmpt_lahir;?>" name="tmpt_lahir" required>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="tgl_lahir">Tanggal Lahir</p>
									<div class="col-sm-8">
										<input type="date" class="form-control" value="<?php echo $row->tgl_lahir;?>" name="tgl_lahir" required>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="agama">Agama</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<select class="form-control" name="agama">
													<?php echo '<option value="'.$row->agama.'">'.$row->agama.'</option>';?>
													<option value="">-Pilih Agama-</option>
													<option value="Islam">Islam</option>
													<option value="Katolik">Katolik</option>
													<option value="Protestan">Protestan</option>
													<option value="Budha">Budha</option>
													<option value="Hindu">Hindu</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="status">Status</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<?php 
													if($row->status=='B'){
														echo '<input type="radio" name="status" value="B" checked required>&nbsp;Belum Kawin&nbsp;&nbsp;&nbsp;
														<input type="radio" name="status" value="K">&nbsp;Sudah Kawin';
													}else{
														echo '<input type="radio" name="status" value="B" required>&nbsp;Belum Kawin&nbsp;&nbsp;&nbsp;
														<input type="radio" name="status" value="K" checked>&nbsp;Sudah Kawin';
													}
												?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="goldarah">Golongan Darah</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<select class="form-control" name="goldarah">
												<?php echo '<option value="'.$row->goldarah.'">'.$row->goldarah.'</option>';?>
												<option value="">-Pilih Golongan Darah-</option>
												<option value="A">A</option>
												<option value="B">B</option>
												<option value="AB">AB</option>
												<option value="O">O</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="wnegara">Kewarganegaraan</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<select class="form-control" name="wnegara">
												<?php if($row->wnegara=='WNI'){
													echo '<option value="WNI" selected>WNI</option><option value="WNA">WNA</option>';
												}else{
													echo '<option value="WNI">WNI</option><option value="WNA" selected>WNA</option>';
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="alamat">Alamat</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $row->alamat;?>" name="alamat">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="rt_rw">RT - RW</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<input type="text" size="4" class="form-control" value="<?php echo $row->rt;?>" name="rt"> - 
											<input type="text" size="4" class="form-control" value="<?php echo $row->rw;?>" name="rw">
										</div>
									</div>
								</div>
								<div class="form-group row">
								<!----------------- ---->
									<p class="col-sm-4 form-control-label" id="lbl_provinsi">Provinsi</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<select id="prop" class="form-control" onchange="ajaxkota(this.value)">
													<?php 
													echo '<option value="'.$row->id_provinsi.'-'.$row->provinsi.'">'.$row->provinsi.'</option>';?>
													<option value="">-Pilih Provinsi-</option>
													<?php 
													foreach($prop as $row1){
														echo '<option value="'.$row1->id.'-'.$row1->nama.'">'.$row1->nama.'</option>';
													}
													?>
												</select>
												<input type="hidden" class="form-control" id="provinsi" placeholder="" name="provinsi">
												<input type="hidden" class="form-control" id="id_provinsi" placeholder="" name="id_provinsi">
											
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_kotakabupaten">Kota/Kabupaten</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<select id="kota" class="form-control" onchange="ajaxkec(this.value)">
													<?php 
													echo '<option value="'.$row->id_kotakabupaten.'-'.$row->kotakabupaten.'">'.$row->kotakabupaten.'</option>';?>
													<option value="">-Pilih Kota/Kabupaten-</option>
												</select>
												<input type="hidden" class="form-control" id="kotakabupaten" value="<?php echo $row->kotakabupaten;?>" name="kotakabupaten">
												<input type="hidden" class="form-control" id="id_kotakabupaten" placeholder="" name="id_kotakabupaten">
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_kecamatan">Kecamatan</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<select id="kec" class="form-control" onchange="ajaxkel(this.value)">
													<?php echo '<option value="'.$row->id_kecamatan.'-'.$row->kecamatan.'">'.$row->kecamatan.'</option>';?>
													<option value="">-Pilih Kecamatan-</option>
												</select>
												<input type="hidden" class="form-control" id="kecamatan" value="<?php echo $row->kecamatan;?>" name="kecamatan">
												<input type="hidden" class="form-control" id="id_kecamatan" placeholder="" name="id_kecamatan">
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_kelurahandesa">Kelurahan</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<select id="kel" class="form-control" onchange="setkel(this.value)">
													<?php echo '<option value="'.$row->id_kelurahandesa.'-'.$row->kelurahandesa.'">'.$row->kelurahandesa.'</option>';?>
													<option value="">-Pilih Kelurahan/Desa-</option>
												</select>
												<input type="hidden" class="form-control" id="kelurahandesa" value="<?php echo $row->kelurahandesa;?>" name="kelurahandesa">
												<input type="hidden" class="form-control" id="id_kelurahandesa" placeholder="" name="id_kelurahandesa">
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="kodepos">Kode Pos</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $row->kodepos;?>" name="kodepos">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="pendidikan">Pendidikan</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<select class="form-control" name="pendidikan">
													<?php echo '<option value="'.$row->pendidikan.'">'.$row->pendidikan.'</option>';?>
													<option value="">-Pilih Pendidikan Terakhir-</option>
													<option value="SD">SD</option>
													<option value="SMP">SMP</option>
													<option value="SMA">SMA</option>
													<option value="S1">S1</option>
													<option value="S2">S2</option>
													<option value="S3">S3</option>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="pekerjaan">Pekerjaan</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $row->pekerjaan;?>" name="pekerjaan">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_telp">No. Telp</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $row->no_telp;?>" maxlength="12" name="no_telp">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_hp">No. HP</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $row->no_hp;?>" maxlength="12" name="no_hp">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_telp_kantor">No. Telp Kantor</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $row->no_telp_kantor;?>" maxlength="12" name="no_telp_kantor">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="email">Email</p>
									<div class="col-sm-8">
										<input type="email" class="form-control" value="<?php echo $row->email;?>" name="email">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="bahasa">Bahasa</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $row->bahasa;?>" name="bahasa">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="sukubangsa">Suku Bangsa</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $row->sukubangsa;?>" name="sukubangsa">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="nama_ayah_suami">Nama Ayah/Suami</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $row->nm_ayah_suami;?>" name="nm_ayah_suami">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="pekerjaan_ayah_suami">Pekerjaan Ayah/Suami</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $row->pekerjaan_ayah_suami;?>" name="pekerjaan_ayah_suami">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="nama_ibu_istri">Nama Ibu/Istri</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $row->nm_ibu_istri;?>" name="nm_ibu_istri">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="pekerjaan_ibu_istri">Pekerjaan Ibu/Istri</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $row->pekerjaan_ibu_istri;?>" name="pekerjaan_ibu_istri">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="kartusdhdicetak">Kartu Sudah Dicetak</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<select class="form-control" name="kartusdhdicetak">
													<?php if($row->kartusdhdicetak=='0'){
													echo '<option value=0 selected>Belum</option><option value="1">Sudah</option>';
												}else{
													echo '<option value="0">Belum</option><option value="1" selected>Sudah</option>';
												}
												?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<!-- --->
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="foto">Update Foto</p>
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
										<button type="reset" class="btn btn-primary">Reset</button>
										<button type="submit" class="btn btn-primary">Simpan</button>
										<a href="#" class="btn btn-primary">Cetak Kartu</a>
									</div>
								</div>
							<?php echo form_close();?>
					</div>
					<!--- end panel body--->
				</div>
				<!--- end panel --->
			</div>
		<!--- end col --->
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading" align="center" style="background-color:#529BC5;color:#ffffff"><h4>DAFTAR ULANG PASIEN IRD</h4></div>
					<div class="panel-body" style="background-color:#bad8e9;">
						<br>
							<?php echo form_open('IrDRegistrasi/insert_daftar_ulang'); ?>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_register">No. Registrasi</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $no_register;?>" readonly name="no_register">
										<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" readonly name="no_medrec">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="jns_kunj">Jenis Kunjungan</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<input type="radio" name="jns_kunj" value="LAMA" checked>&nbsp;Lama
												&nbsp;&nbsp;&nbsp;
												<input type="radio" name="jns_kunj" value="BARU">&nbsp;Baru
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
								<!----------------- ---->
									<p class="col-sm-4 form-control-label" id="cara_kunj">Cara Kunjungan</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<select id="prop" class="form-control" name="cara_kunj" required>
													<option value="">-Pilih Cara Kunjungan-</option>
													<?php 
													foreach($cara_berkunjung as $row){
														echo '<option value="'.$row->cara_kunj.'">'.$row->cara_kunj.'</option>';
													}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="asal_rujukan">Asal Rujukan</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="asal_rujukan">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_rujukan">No. SJP/Rujukan</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="no_rujukan">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="kelas_pasien" required>Kelas Pasien</p>
									
									<div class="col-sm-8">
										<select class="form-control" name="kelas_pasien">
											<option value="">-Pilih Kelas-</option>
											<option value="I">I</option>
											<option value="II">II</option>
											<option value="III">III</option>
											<option value="VIP">VIP</option>
										</select>
									
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="kelas_pasien">Dirujuk Ke</p>
									<div class="col-sm-8">
											<input type="search" class="auto_search_poli form-control" id="nm_poli" placeholder="Nama Poli" required>
										<div class="form-inline">
											ID Poli : <input type="text" size="8" class="form-control" placeholder="" id="id_poli" readonly name="id_poli">
											Ruang : <input type="text" size="8" class="form-control" placeholder="" id="kd_ruang" readonly name="kd_ruang">
										</div>
									</div>
								</div>
								<div class="form-group row">
								<!----------------- ---->
									<p class="col-sm-4 form-control-label" id="cara_bayar">Cara Bayar</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<select id="prop" class="form-control" name="cara_bayar">
													<option value="">-Pilih Cara Bayar-</option>
													<?php
													foreach($cara_bayar as $row){
														echo '<option value="'.$row->cara_bayar.'">'.$row->cara_bayar.'</option>';
													}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="biayadaftar">Biaya Daftar</p>
									<div class="col-sm-8">
										<input type="number" min=0 class="form-control" placeholder="" name="biayadaftar">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="nama_penjamin">Nama Penjamin</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="nama_penjamin">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="hubungan">Hubungan</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="hubungan">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="vtot">Total</p>
									<div class="col-sm-8">
										<input type="number" min=0 class="form-control" placeholder="" name="vtot">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_sep">No SEP</p>
									<div class="col-sm-8">
										<div class="form-inline">
											&nbsp;&nbsp;<a href="#" class="btn btn-danger">Buat SEP</a>
											<input type="text" class="form-control" placeholder="" name="no_sep" readonly>
										</div>
									</div>
								</div>
								<div class="form-inline" align="center">
									<div class="form-group">
										<button type="reset" class="btn btn-primary">Reset</button>
										<a href="#" class="btn btn-primary">Cetak Kartu Poli</a>
										<button type="submit" class="btn btn-primary">Cetak Karcis</button>
									</div>
								</div>
							<?php echo form_close();
							}
							?>
					</div>
					<!--- end panel body--->
				</div><!--- end panel --->
			</div><!--- end col --->
		</div><!--- end row --->
	</section>
<?php $this->load->view("layout/footer"); ?>