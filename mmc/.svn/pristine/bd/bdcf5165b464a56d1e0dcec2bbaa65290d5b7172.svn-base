<?php $this->load->view("layout/header"); ?>
	<?php
	include('script_formdaftar.php');	
	?>
	<?php
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
	?>
	<section class="content-header">
	
	<?php
	include('search_panel.php');	
	?>		
</section>

	<section class="content" style="width:97%;margin:0 auto">
		<div class="row">			
			<ul class="nav nav-tabs my-tab nav-justified">
			    <li class="active"><a data-toggle="tab" href="#home" ><h4>BIODATA</h4></a></li>
			    <li class="disabled" ><a><h4>DAFTAR ULANG PASIEN IRD</h4></a></li>
	    
	  		</ul>
			<div class="tab-content">
			
			  <div id="home" class="tab-pane fade in active">	
				<!--<div id="tabIRD" class="container">	
					<ul  class="nav nav-pills">
						<li class="active">
						<a  href="#tabbio" data-toggle="tab">Biodata</a>
						</li>
						<li><a href="#tabdaful" data-toggle="tab">Daftar Ulang</a>
						</li>
					</ul>
				</div>
				<div class="tab-content clearfix">
			  <div class="tab-pane active" id="1a">
          <h3>Content's background color is the same for the tab</h3>
				</div>
				<div class="tab-pane" id="2a">
          <h3>We use the class nav-pills instead of nav-tabs which automatically creates a background color for the tab</h3>
				</div>
				-->
				<div class="panel panel-info">					
					<div class="panel-body" id="biodataIRD">
						<br>				
							<?php echo form_open_multipart('ird/IrDRegistrasi/insert_pasien_ird');?>
						<div class="col-sm-6">
						<!--<input type="hidden" class="form-control" value="<?php echo $no_cm;?>" name="no_cm" >-->
								
								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="nama">Nama Lengkap*</p>									
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="ex: Budi, TN" name="nama" required>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" >Tanggal Daftar*</p>
									<div class="col-sm-8">
										<input type="text" id="tgl_daftar" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="tgl_daftar" placeholder="eg : 2016-05-11" required>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="sex">Jenis Kelamin*</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												 <input type="radio" name="sex" class="flat-red" value="L" checked> &nbsp;Laki-Laki &nbsp;&nbsp;&nbsp;
                
               
                  <input type="radio" name="sex" class="flat-red" value="P"> &nbsp;Perempuan
											</div>
										</div>
									</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="jenis_identitas">Pilih Identitas</p>
									<div class="col-sm-8">
												<select class="form-control" name="jenis_identitas" >
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
									<p class="col-sm-4 form-control-label" id="no_kk">No. Kartu Keluarga</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="no_kk" id="no_kk">
									</div>
								</div>
								<!--<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="jenis_kartu">Pilih Kartu</p>
									<div class="col-sm-8">
												<select class="form-control" name="jenis_kartu">
													<option value="">-Pilih Kartu-</option>
													<option value="BPJS">BPJS</option>
													<option value="ASKES">ASKES</option>
												</select>
									</div>
								</div>-->
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_kartu">No. Kartu BPJS</p>
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
									<p class="col-sm-4 form-control-label" id="asuransi_1">Asuransi 1</p>
									<div class="col-sm-8">
										<select class="form-control select2" name="asuransi1">
													<option value="">-Pilih Asuransi-</option>
													<?php print_r($jenis_kontraktor);
													foreach($jenis_kontraktor as $row){
														echo '<option value="'.$row->id_kontraktor.'">'.$row->nmkontraktor.'</option>';
													}
													?>
												</select>
										<input type="text" class="form-control" placeholder="No Asuransi 1" name="no_asuransi1" id="no_asuransi1">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="asuransi_2">Asuransi 2</p>
									<div class="col-sm-8">
										<select class="form-control select2" name="asuransi2">
													<option value="">-Pilih Asuransi-</option>
													<?php print_r($jenis_kontraktor);
													foreach($jenis_kontraktor as $row){
														echo '<option value="'.$row->id_kontraktor.'">'.$row->nmkontraktor.'</option>';
													}
													?>
												</select>
										<input type="text" class="form-control" placeholder="No Asuransi 2" name="no_asuransi2" id="no_asuransi2">
									</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="tmpt_lahir">Tempat Lahir*</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="tmpt_lahir" required>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="tgl_lahir">Tanggal Lahir*</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" id="date_picker" placeholder="eg : 1990-05-11" name="tgl_lahir" required>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="agama">Agama</p>
									<div class="col-sm-8">
												<select class="form-control" name="agama">
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
									<p class="col-sm-4 form-control-label" id="statusN">Status</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">

												 <input type="radio" name="status" class="flat-red" value="B" checked> &nbsp;Belum Kawin
												&nbsp;&nbsp;&nbsp;
                								                 <input type="radio" name="status" class="flat-red" value="K"> &nbsp;Sudah Kawin
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="goldarah">Golongan Darah</p>
									<div class="col-sm-8">
											<select class="form-control" name="goldarah">
												<option value="">-Pilih Golongan Darah-</option>
												<option value="A">A+</option>
												<option value="A">A-</option>
												<option value="B">B+</option>
												<option value="AB">B-</option>
												<option value="O">AB+</option>
												<option value="B">AB-</option>
												<option value="AB">O+</option>
												<option value="O">O-</option>
												
											</select>
									</div>
								</div>
								<!-- <div class="form-group row">
									<p class="col-sm-4 form-control-label" id="rhesusP">Rhesus</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<input type="radio" name="rhesus" value="1" checked>&nbsp;Positif (+)
												&nbsp;&nbsp;&nbsp;
												<input type="radio" name="rhesus" value="0">&nbsp;Negatif (-)
											</div>
										</div>
									</div>
								</div> -->
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="wnegara">Kewarganegaraan</p>
									<div class="col-sm-8">
											<select class="form-control" name="wnegara">
												<option value="WNI">WNI</option>
												<option value="WNA">WNA</option>
											</select>
									</div>
								</div>
						</div>
						<div class="col-sm-6">
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="alamat">Alamat</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="alamat">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="rt_rw">RT - RW</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<input type="text" size="4" class="form-control" placeholder="" name="rt"> - 
											<input type="text" size="4" class="form-control" placeholder="" name="rw">
										</div>
									</div>
								</div>
								<div class="form-group row">
								<!----------------- ---->
									<p class="col-sm-4 form-control-label" id="lbl_provinsi">Provinsi</p>
									<div class="col-sm-8">
												<select id="prop" class="form-control select2" onchange="ajaxkota(this.value)">
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
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_kotakabupaten">Kota/Kabupaten</p>
									<div class="col-sm-8">
												<select id="kota" class="form-control select2" onchange="ajaxkec(this.value)">
													<option value="">-Pilih Kota/Kabupaten-</option>
												</select>
												<input type="hidden" class="form-control" id="kotakabupaten" placeholder="" name="kotakabupaten">
												<input type="hidden" class="form-control" id="id_kotakabupaten" placeholder="" name="id_kotakabupaten">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_kecamatan">Kecamatan</p>
									<div class="col-sm-8">
												<select id="kec" class="form-control select2" onchange="ajaxkel(this.value)">
													<option value="">-Pilih Kecamatan-</option>
												</select>
												<input type="hidden" class="form-control" id="kecamatan" placeholder="" name="kecamatan">
												<input type="hidden" class="form-control" id="id_kecamatan" placeholder="" name="id_kecamatan">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_kelurahandesa">Kelurahan</p>
									<div class="col-sm-8">
												<select id="kel" class="form-control select2" onchange="setkel(this.value)">
													<option value="">-Pilih Kelurahan/Desa-</option>
												</select>
												<input type="hidden" class="form-control" id="kelurahandesa" placeholder="" name="kelurahandesa">
												<input type="hidden" class="form-control" id="id_kelurahandesa" placeholder="" name="id_kelurahandesa">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="kodepos">Kode Pos</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="kodepos">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="pendidikan">Pendidikan</p>
									<div class="col-sm-8">
												<select class="form-control" name="pendidikan">
													<option value="">-Pilih Pendidikan Terakhir-</option>
													<option value="sd">SD</option>
													<option value="smp">SMP</option>
													<option value="sma">SMA</option>
													<option value="s1">S1</option>
													<option value="s2">S2</option>
													<option value="s3">S3</option>
												</select>
											
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="pekerjaan">Pekerjaan</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" name="pekerjaan">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_telp">No. Telp</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" maxlength="12" name="no_telp">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_hp">No. HP</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" maxlength="12" name="no_hp">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_telp_kantor">No. Telp Kantor</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" placeholder="" maxlength="12" name="no_telp_kantor">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="email">Email</p>
									<div class="col-sm-8">
										<input type="email" class="form-control" placeholder="" name="email">
									</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="nama_ibu_kandung">Nama Ibu Kandung</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="" name="nm_ibu_istri">
									</div>
								</div>
								<!--<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="kartusdhdicetak">Kartu Sudah Dicetak</p>
									<div class="col-sm-8">
												<select class="form-control" name="kartusdhdicetak">
													<option value="0">Belum</option>
													<option value="1">Sudah</option>
												</select>
									</div>
								</div>-->
								<!-- --->
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="foto">Foto</p>
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
										<button type="reset" class="btn bg-orange" onclick="resetBiodata()" >Reset</button>
										<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
										<button type="submit" id="btn-submit" class="btn btn-primary" id="btnBio">Simpan</button>
										<!--<a href="#" class="btn btn-primary">Cetak Kartu</a>-->
									</div>
								</div>
							<?php echo form_close();?>
					</div>
					<!--- end panel body--->
				</div></div>
				<!--- end panel --->
			</div>
		<!--- end col --->
			
		</div><!--- end row --->
	</section>
<?php $this->load->view("layout/footer"); ?>
