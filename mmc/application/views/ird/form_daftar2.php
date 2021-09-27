<?php $this->load->view("layout/header"); $d=0;?>
<?php
	include('script_formdaftar2.php');	
	?>
	<section class="content-header">
		
	<!--<?php
		if($message!=''){
	?>
		<div class="content-header">
			
				<?php if($message!='1'){ 
					if($message=='Berhasil'){?>
				
				<div class="alert alert-success alert-dismissable">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>				
				<h4><i class="icon fa fa-check"></i>
					Registrasi Berhasil
				</h4>
				<?php } else if($message=='2'){ ?>
				<div class="alert alert-danger alert-dismissable">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>				
				<h4><i class="icon fa fa-close"></i>
					Daftar ulang berhasil
					<a href='<?php echo site_url('Ajax/buat_SEP/'.$no_cm);?>' type="button" class="btn btn-danger pull-right">Lanjut, Buat SEP</a>
				</h4>
				<?php }else { ?>
				<div class="alert alert-danger alert-dismissable">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>				
				<h4><i class="icon fa fa-close"></i>
					<?php echo $message ?>
				</h4>
				<?php }} else {?>				
				
				<div class="alert alert-danger alert-dismissable">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button><h4><i 					class="icon fa fa-close"></i>
					Data Tidak Ditemukan
				</h4>
				<?php }?>	
				</div>
			
		</div>
	<?php
		}
	?>-->
	<?php
	include('search_panel.php');
	?>
<style>
select {
width:100%;
}
</style>			
	</section>
	<section class="content" style="width:97%;margin:0 auto">
		<div class="row">
			<ul class="nav nav-tabs my-tab nav-justified" >
			    <li class="active" ><a data-toggle="tab" href="#home" ><h4>BIODATA</h4></a></li>
			    <li class=""><a data-toggle="tab" href="#daful" ><h4>DAFTAR PASIEN IRD</h4></a></li>
	    
	  		</ul>
			<div class="tab-content">
			  <div id="home" class="tab-pane fade in active">			    
				<div class="panel panel-info">					
					<div class="panel-body" id="biodataIRD">
						<div class="col-sm-6">					

							<?php
							// print_r($data_pasien);
								foreach($data_pasien as $row){
								$no_medrec=$row->no_medrec;
								$nama=$row->nama;

								//cek jenis kunjungan
								if ( date("Y-m-d") == substr($row->tgl_daftar,0,10) ) 
									$jns_kunjungan="BARU";
								else $jns_kunjungan="LAMA";
								if($row->foto!=''){
									$foto=$row->foto;
								}else $foto="unknown.png";
							?>
							
																		
							<div class="form-group row">
								<div class="col-sm-12">
									<center><img height="150px" class="img-rounded" src="<?php echo base_url("upload/photo/".$foto);?>">
								</div>
							</div>
							<?php echo form_open_multipart('ird/IrDRegistrasi/update_pasien_ird');?>
							<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>"name="no_cm">									
							<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" >No Medical Record*</p>									
									<div class="col-sm-7">
										<input type="text" class="form-control" name="cm_patria" value="<?php echo $row->no_cm;?>" disabled>
									
									</div>	
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="tgl_daftar">Tanggal Daftar</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="<?php echo $row->tgl_daftar;?>" name="tgl_daftar" readonly>
									</div>
								</div>							
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="nama">Nama Lengkap</p>
									<div class="col-sm-7">
										<input type="text" id="namaInput" class="form-control" value="<?php echo $row->nama;?>" name="nama">
									</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="sex">Jenis Kelamin*</p>
									<div class="col-sm-7">
												<?php 
													if($row->sex=='L'){
														echo '<input type="radio" name="sex" class="flat-red" value="L" checked required>&nbsp;Laki-Laki&nbsp;&nbsp;&nbsp;
														<input type="radio" name="sex" class="flat-red" value="P">&nbsp;Perempuan';
													}else{
														echo '<input type="radio" name="sex" class="flat-red" value="L" required>&nbsp;Laki-Laki&nbsp;&nbsp;&nbsp;
														<input type="radio" name="sex" class="flat-red" value="P" checked>&nbsp;Perempuan';
													}
												?>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="jenis_identitas">Pilih Identitas</p>
									<div class="col-sm-7">
												<select class="form-control" name="jenis_identitas" id="ident">
													
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
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_identitas">No. Identitas</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="<?php echo $row->no_identitas;?>" name="no_identitas" id="no_identitas" onchange="cek_no_identitas(this.value,'<?php echo $row->no_identitas; ?>')"  >
									</div>
								</div>
								<div class="form-group row" id="duplikat_id">
									<p class="col-sm-3 form-control-label"></p>
									<div class="col-sm-8">
										<p class="form-control-label" id="content_duplikat_id" style="color: red;"></p>
									</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_kk">No. Kartu Keluarga</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="<?php echo $row->no_kk;?>" name="no_kk" id="no_kk">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_kartu">No. Kartu BPJS</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="<?php echo $row->no_kartu;?>" name="no_kartu" id="no_kartu" onchange="cek_no_kartu(this.value,'<?php echo $row->no_kartu; ?>')">
									</div>
								</div>
								<div class="form-group row" id="duplikat_kartu">
									<p class="col-sm-3 form-control-label"></p>
									<div class="col-sm-8">
										<p class="form-control-label" id="content_duplikat_kartu" style="color: red;"></p>
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="asuransi_1">Asuransi 1</p>
									<div class="col-sm-7">
										<select class="form-control select2" name="asuransi1" id="asuransi1"  >
													
													<option value="0">-Pilih Asuransi-</option>
													<?php $id_kontraktor1=$row->id_kontraktor1;
													foreach($jenis_kontraktor as $row1){
														echo "<option value='".$row1->id_kontraktor."' >".$row1->nmkontraktor."</option>";
													}
													?>
												</select>
										<input type="text" class="form-control" placeholder="No Asuransi 1" name="no_asuransi1" id="no_asuransi1" value="<?php echo $row->no_asuransi1; ?>">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="asuransi_2">Asuransi 2</p>
									<div class="col-sm-7">
										<select class="form-control select2" name="asuransi2" id="asuransi2" >
													<option value="0">-Pilih Asuransi-</option>
													<?php $id_kontraktor2=$row->id_kontraktor2;
													foreach($jenis_kontraktor as $row2){
														echo '<option value="'.$row2->id_kontraktor.'"  >'.$row2->nmkontraktor.'</option>';
													}
													?>
												</select>
										<input type="text" class="form-control" placeholder="No Asuransi 2" name="no_asuransi2" id="no_asuransi2" value="<?php echo $row->no_asuransi2; ?>">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="tmpt_lahir">Tempat Lahir</p>
									<div class="col-sm-7">
										<input type="text" class="form-control"  value="<?php echo $row->tmpt_lahir;?>" name="tmpt_lahir" required>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="tgl_lahir">Tanggal Lahir</p>
									<div class="col-sm-7">
										<input type="text" class="form-control date_picker" value="<?php echo $row->tgl_lahir;?>" name="tgl_lahir" required>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" >Agama</p>
									<div class="col-sm-7">
												<select class="form-control" name="agama" id="agama">
													
													<option value="">-Pilih Agama-</option>
													<option value="Islam">Islam</option>
													<option value="Katolik">Katolik</option>
													<option value="Protestan">Protestan</option>
													<option value="Budha">Budha</option>
													<option value="Hindu">Hindu</option>
													<option value="Konghucu">Khonghucu</option>
												</select>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="status">Status</p>
									<div class="col-sm-7">
											<div class="form-group">
												<?php 
													if($row->status=='B'){
														echo '<input type="radio" name="status" value="B" class="flat-red" checked required>&nbsp;Belum Kawin&nbsp;&nbsp;&nbsp;
														<input type="radio" name="status" class="flat-red" value="K">&nbsp;Sudah Kawin';
													}else{
														echo '<input type="radio" name="status" value="B" class="flat-red" required>&nbsp;Belum Kawin&nbsp;&nbsp;&nbsp;
														<input type="radio" name="status" value="K" class="flat-red" checked>&nbsp;Sudah Kawin';
													}
												?> 
											</div>
									</div>
								</div>
								
						</div>
						<div class="col-sm-6">
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" ></p>
									
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" >Golongan Darah</p>
									<div class="col-sm-7">
											<select class="form-control" name="goldarah" id="goldarah">
												<?php $goldarah=$row->goldarah;?>
												<option value="0">-Pilih Golongan Darah-</option>
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
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="wnegara">Kewarganegaraan</p>
									<div class="col-sm-7">
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
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" >Alamat</p>
									<div class="col-sm-7">
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
									<div class="col-sm-7">
												<select id="prov" class="form-control select2" onchange="ajaxkota(this.value)">
													
													<option value="">-Pilih Provinsi-</option>
													<?php 
													foreach($prop as $row1){
														echo '<option value="'.$row1->id.'-'.$row1->nama.'">'.$row1->nama.'</option>';
													}
													?>
												</select>
												<input type="hidden" class="form-control" id="provinsi" placeholder="" name="provinsi" value="<?php echo $row->id_provinsi;?>">
												<input type="hidden" class="form-control" id="id_provinsi" placeholder="" name="id_provinsi" value="<?php echo $row->provinsi;?>">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_kotakabupaten">Kota/Kabupaten</p>
									<div class="col-sm-7">
												<select id="kota" class="form-control select2" onchange="ajaxkec(this.value)">
													<?php if($row->id_kotakabupaten!=''){
echo '<option value="'.$row->id_kotakabupaten.'-'.$row->kotakabupaten.'">'.$row->kotakabupaten.'</option>';}?>
													<option value="">-Pilih Kota/Kabupaten-</option>
												</select>
												<input type="hidden" class="form-control" id="kotakabupaten" value="<?php echo $row->kotakabupaten;?>" name="kotakabupaten">
												<input type="hidden" class="form-control" id="id_kotakabupaten" placeholder="" name="id_kotakabupaten">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_kecamatan">Kecamatan</p>
									<div class="col-sm-7">
												<select id="kec" class="form-control select2" onchange="ajaxkel(this.value)">
													<?php if($row->id_kecamatan!=''){
echo '<option value="'.$row->id_kecamatan.'-'.$row->kecamatan.'">'.$row->kecamatan.'</option>';}?>

													<option value="">-Pilih Kecamatan-</option>
												</select>
												<input type="hidden" class="form-control" id="kecamatan" value="<?php echo $row->kecamatan;?>" name="kecamatan">
												<input type="hidden" class="form-control" id="id_kecamatan" placeholder="" name="id_kecamatan">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_kelurahandesa">Kelurahan</p>
									<div class="col-sm-7">
											
												<select id="kel" class="form-control select2" onchange="setkel(this.value)">
													<?php if($row->id_kelurahandesa!=''){
echo '<option value="'.$row->id_kelurahandesa.'-'.$row->kelurahandesa.'">'.$row->kelurahandesa.'</option>';}?>
													<option value="">-Pilih Kelurahan/Desa-</option>
												</select>
												<input type="hidden" class="form-control" id="kelurahandesa" value="<?php echo $row->kelurahandesa;?>" name="kelurahandesa">
												<input type="hidden" class="form-control" id="id_kelurahandesa" placeholder="" name="id_kelurahandesa">
											
										
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="kodepos">Kode Pos</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="<?php echo $row->kodepos;?>" name="kodepos">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" >Pendidikan</p>
									<div class="col-sm-7">
												<select class="form-control" name="pendidikan" id="pendidikan">													
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
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="pekerjaan">Pekerjaan</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="<?php echo $row->pekerjaan;?>" name="pekerjaan">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_telp">No. Telp</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="<?php echo $row->no_telp;?>" maxlength="12" name="no_telp">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_hp">No. HP</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="<?php echo $row->no_hp;?>" maxlength="12" name="no_hp">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_telp_kantor">No. Telp Kantor</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="<?php echo $row->no_telp_kantor;?>" maxlength="12" name="no_telp_kantor">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="email">Email</p>
									<div class="col-sm-7">
										<input type="email" class="form-control" value="<?php echo $row->email;?>" name="email">
									</div>
								</div>								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="nama_ibu_istri">Nama Ibu Kandung</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="<?php echo $row->nm_ibu_istri;?>" name="nm_ibu_istri">
									</div>
								</div>								
								<!--<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="kartusdhdicetak">Kartu Sudah Dicetak</p>
									<div class="col-sm-8">
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
								--->
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="foto">Update Foto</p>
									<div class="col-sm-7">
										<input type="file" name="userfile" class="form-control" accept="image/jpeg, image/png, image/gif">
										<input type="text" class="form-control filefield browse" readonly="" value="" />
										<span class="input-group-btn">
											<button class="btn btn-info btn-flat" type="button" id="browseBtn">Browse</button>
										</span>
									</div>
								</div>
								<div class="form-inline" align="center">
									<div class="form-group">
										<a type="reset" class="btn bg-orange" href="<?php echo site_url();?>ird/IrDRegistrasi/update_reset_biodata/<?php echo $row->no_medrec;?>">Reset</a>
										
										
										
										<button type="submit" id="btn-submit" class="btn btn-primary">Simpan</button>
									</div>
								</div>
							<?php echo form_close();?>
					</div></div>
					<!--- end panel body--->
				</div>
				<!--- end panel --->
			</div>
		<!--- end col --->
			<div id="daful" class="tab-pane fade">
				<div class="panel panel-info">					
					<div class="panel-body" id="biodataDaful">
						<br>
						<div class="col-sm-6">
							<?php echo form_open('ird/IrDRegistrasi/insert_daftar_ulang'); ?>		
		<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>"name="no_medrec">
						<div style="margin-left:18px;margin-right:18px;">
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="jns_kunj">Jenis Kunjungan</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" readonly name="no_medrec">
												<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
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
										<input type="text" class="form-control" placeholder="" value="<?php echo $nama;?>" name="nama" readonly>
									</div>
								</div>
								<div class="form-group row">
								<!----------------- ---->
									<p class="col-sm-4 form-control-label" id="cara_bayar">Cara Bayar*</p>
									<div class="col-sm-8">
												<select id="prop" class="form-control" name="cara_bayar" onchange="pilih_cara_bayar(this.value)" required>
													<option value="">-Pilih Cara Bayar-</option>
													<?php 
													foreach($cara_bayar as $row){
														echo '<option value="'.$row->cara_bayar.'">'.$row->cara_bayar.'</option>';
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
													foreach($jenis_kontraktor as $row){
														
														echo '<option value="'.$row->id_kontraktor.'">'.$row->nmkontraktor.'</option>';
													}
													?>
										</select>
									</div>
								</div>
								<div class="form-group row" id="cek_sep" name="cek_sep"  style="width:99%;">
									<div class="pull-right"><a href="#responsive" class="btn btn-danger" onclick="cek_nokartu('<?php echo $no_medrec;?>')" >Validasi</a></div>
								</div>
								<div class="form-group row" id="warn_kartu">
									<p class="col-sm-4 form-control-label"></p>
									<div class="col-sm-8">
										<p class="form-control-label" id="content_warn_kartu" style="color: red;"></p>
									</div>
									
									
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="asal_rujukan">Asal Rujukan </p>
									<div class="col-sm-8">
												<select class="form-control select2" style="width: 100%" name="asal_rujukan" onchange="set_rujukan(this.value)">
													<option value="">-Pilih Asal Rujukan-</option>
													<option value="1">Lainnya</option>
													<?php 
													foreach($ppk as $row){
														echo '<option value="'.$row->kd_ppk.'">'.$row->nm_ppk.'</option>';
													}
													?>
												</select>
									</div>
								</div>
								<div class="form-group row" id="rujukan_lainnya">
									<p class="col-sm-4 form-control-label"></p>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="Nama Tempat Rujukan" name="dll_rujukan" id="dll_rujukan">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_rujukan">No. SJP/Rujukan</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="no_rujukan">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label"> Tgl. Rujukan</p>
									<div class="col-sm-8">
										<input type="text" class="form-control date_picker" placeholder="" id="tgl_rujukan" name="tgl_rujukan">
									</div>
								</div>	
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="kelas_pasien">Kelas Pasien</p>
									<div class="col-sm-8">
										<select class="form-control" name="kelas_pasien" required >
											<option value="III">III</option>																					
													<?php 
												
													//foreach($kelas as $row){
													//	echo '<option value="'.$row->kelas.'">'.$row->kelas.'</option>';
													//}
													?>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="tanggal_kunj">Tanggal Kunjungan</p>
									<div class="col-sm-8">
										<input type="text" class="form-control date_picker" placeholder="eg : 2001-05-11" id="tgl_kunj" name="tgl_kunj" value="<?php echo date('Y-m-d'); ?>"  required>
									</div>
								</div>
								
								
								
								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="nama_penjamin">Nama Penjamin</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="nama_penjamin" >
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="alber">Alasan Berobat</p >
										<div class="col-sm-8">
										<select class="form-control" name="alber" onchange="pilih_alber(this.value)" required>
											<option value="sakit">Sakit</option>
											<option value="kecelakaan">Kecelakaan</option>
											<option value="lain">Melahirkan</option>
										</select></div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="pasdatDg">Datang dengan</p>
									<div class="col-sm-8"><select class="form-control" name="pasdatDg" required>
										<option value="klg">Keluarga</option>
										<option value="ttg">Tetangga</option>
										<option value="lain">Lain-lain</option>
									</select></div>
								</div>								
								<div class="form-group row" id="input_kecelakaan">
									<p class="col-sm-4 form-control-label" id="Kclkaan">Kecelakaan</p>
									<div class="col-sm-8">
										<select  class="form-control select2" name="jenis_kecelakaan" id="jenis_kecelakaan" style="width:100%;">
													<option value="">-Pilih Jenis Kecelakaan-</option>
													<?php
													foreach($jenis_kecelakaan as $row){
														echo '<option value="'.$row->id.'">'.$row->nm_kecelakaan.'</option>';
													}
													?>
												</select>
										<input type="text" class="form-control" placeholder="Lokasi Kecelakaan" name="lokasi_kecelakaan" >
									</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="diagnosa">Diagnosa</p>
									<div class="col-sm-8">																							
										<input type="text" class="form-control input-sm auto_diagnosa_pasien" name="diagnosa" id="diag" style="width:273px;font-size:15px;" >	
										<input type="hidden" class="form-control " name="id_diagnosa" id="id_diagnosa">		
									</div>
								</div>								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="operator">Dokter</p>
										<div class="col-sm-8">
											<select class="form-control select2" name="operatorTindakan" style="width:100%;">
											<option value="">-Pilih Operator-</option>											
													<?php 
												
													foreach($operator as $row){
														echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'">'.$row->nm_dokter.'&nbsp;&nbsp;&nbsp;['.$row->id_dokter.'] </option>';
													}
													?>
											</select>
										</div>
								</div>																
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="hubungan">Hubungan Keluarga</p>
									<div class="col-sm-8">
										<select class="form-control" name="hubungan">
											<option value="">-Hubungan Keluarga-</option>
											<option value="klg">Keluarga</option>
											<option value="Pk_kant">Pekerja Kantor</option>
											<option value="lain">Lain-lain</option>
										</select>
									</div>
								</div>
								<!--<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_sep">No SEP</p>
									<div class="col-sm-8">
										<div class="form-inline">
											&nbsp;&nbsp;<a href="#responsive" class="btn btn-danger" onclick="cek_nokartu('<?php echo $no_medrec;?>')">Buat SEP</a>
											<input type="text" class="form-control" placeholder="" name="no_sep" >
										</div>
									</div>
								</div>-->
								<div class="form-inline" align="right">
									<div class="form-group">
										<button type="reset" class="btn bg-orange" >Reset</button>
										<!--<a href="#" class="btn btn-danger" >Cetak Kartu Poli</a>-->
										<button type="submit" id="btn-submit" class="btn btn-primary" >Simpan</button>									
										<!--<a href="<?php site_url('ird/IrDKwitansi/cetak_karcis/'.$no_register); ?>" class="btn btn-primary" >Cetak Karcis</a>-->
										<a href="<?php echo site_url('ird/IrDRegistrasi/cetak_sep/'.$no_register);?>" class="btn btn-primary">Cetak SEP</a>
									</div>
								</div>
							<?php echo form_close();
							}
							?>
					</div></div></div>
					<!--- end panel body--->
				</div><!--- end panel --->
			</div><!--- end col --->
		</div><!--- end row --->
	</section>

	<?php
	include('webservice_modal.php');
	?>
<!--- wrapp content --->

<?php $this->load->view("layout/footer"); ?>
