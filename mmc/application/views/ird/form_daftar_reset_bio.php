<?php $this->load->view("layout/header"); ?>
	<section class="content-header">
	<?php
	include('script_formdaftar2.php');	
	?>	
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
			    <li class=""><a data-toggle="tab" href="#daful" ><h4>DAFTAR ULANG PASIEN IRD</h4></a></li>
	    
	  		</ul>
			<div class="tab-content">
			  <div id="home" class="tab-pane fade in active">			    
				<div class="panel panel-info">					
					<div class="panel-body" id="biodataIRD">
												

							<?php
							// print_r($data_pasien);
								foreach($data_pasien as $row){
								$no_medrec=$row->no_medrec;
								$nama=$row->nama;

								//cek jenis kunjungan
								if ( date("Y-m-d") == substr($row->tgl_daftar,0,10) ) 
									$jns_kunjungan="BARU";
								else $jns_kunjungan="LAMA";
							?>
							<?php echo form_open_multipart('ird/IrDRegistrasi/update_pasien_ird');?>
					<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>"name="no_cm">	
					<div class="form-group row">
						<div class="col-sm-2">
						<div align="left">
							<img height="100px" class="img-rounded" src="<?php echo site_url("upload/photo/".$row->foto);?>"></div>	
						</div>
						<div class="col-sm-3" >
							<table class="table-sm" >
							  <tbody>
								<tr style="align: bottom;height: 20px;">
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr style="align: bottom;height: 50px;">
									<td>No CM </td>
									<td>:&nbsp;</td>
									<td><?php echo $row->no_medrec;?></td>
								</tr>
								<tr style="">
									<td>Tgl Daftar </td>
									<td>:&nbsp;</td>
									<td><?php echo date("d/m/Y",strtotime($row->tgl_daftar)); ?></td>
								</tr>							
							  </tbody>
							</table>
						</div>
					</div>
						
							<div class="col-sm-6">							
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="nama">Nama Lengkap</p>
									<div class="col-sm-7">
										<input type="text" id="namaInput" class="form-control" value="<?php echo $row->nama;?>" name="nama" >
									</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="sex">Jenis Kelamin*</p>
									<div class="col-sm-7">
										<input type="radio" name="sex" class="flat-red" value="L" checked >&nbsp;Laki-Laki&nbsp;&nbsp;&nbsp;
										<input type="radio" name="sex" class="flat-red" value="P">&nbsp;Perempuan
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="jenis_identitas">Pilih Identitas*</p>
									<div class="col-sm-7">
												<select class="form-control" name="jenis_identitas" required>
								
													<option value="">-Pilih Identitas-</option>
													<option value="KTP">KTP</option>
													<option value="SIM">SIM</option>
													<option value="PASPOR">Paspor</option>
													<option value="KTM">KTM</option>
												</select>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_identitas">No. Identitas*</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="" name="no_identitas" id="no_identitas" onchange="cek_no_identitas(this.value,'<?php echo $row->no_identitas; ?>')"  required>
									</div>
								</div>
								<div class="form-group row" id="duplikat_id">
									<p class="col-sm-3 form-control-label"></p>
									<div class="col-sm-8">
										<p class="form-control-label" id="content_duplikat_id" style="color: red;"></p>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="jenis_kartu">Pilih Kartu</p>
									<div class="col-sm-7">
												<select class="form-control" name="jenis_kartu">
													<option value="">-Pilih Kartu-</option>
													<option value="BPJS">BPJS</option>
													<option value="ASKES">ASKES</option>
												</select>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_kartu">No. Kartu</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="" name="no_kartu" id="no_kartu" onchange="cek_no_kartu(this.value)">
									</div>
								</div>
								<div class="form-group row" id="duplikat_kartu">
									<p class="col-sm-3 form-control-label"></p>
									<div class="col-sm-8">
										<p class="form-control-label" id="content_duplikat_kartu" style="color: red;"></p>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="tmpt_lahir">Tempat Lahir*</p>
									<div class="col-sm-7">
										<input type="text" class="form-control"  value="" name="tmpt_lahir" required>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="tgl_lahir">Tanggal Lahir*</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="" name="tgl_lahir" id="date_picker" required>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="agama">Agama</p>
									<div class="col-sm-7">
												<select class="form-control" name="agama">
													
													<option value="">-Pilih Agama-</option>
													<option value="Islam">Islam</option>
													<option value="Katolik">Katolik</option>
													<option value="Protestan">Protestan</option>
													<option value="Budha">Budha</option>
													<option value="Hindu">Hindu</option>
												</select>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="status">Status</p>
									<div class="col-sm-7">
											<div class="form-group">
												<input type="radio" name="status" value="B" class="flat-red" checked>&nbsp;Belum Kawin&nbsp;&nbsp;&nbsp;
												<input type="radio" name="status" class="flat-red" value="K">&nbsp;Sudah Kawin
													
											</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="goldarah">Golongan Darah</p>
									<div class="col-sm-7">
											<select class="form-control" name="goldarah">
											
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
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="wnegara">Kewarganegaraan</p>
									<div class="col-sm-7">
											<select class="form-control" name="wnegara">
												<option value="WNI" selected>WNI</option><option value="WNA">WNA</option>
												<option value="WNI">WNI</option><option value="WNA" selected>WNA</option>												
											</select>
										
									</div>
								</div>
						</div>
						<div class="col-sm-6">
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="alamat">Alamat</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="" name="alamat">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="rt_rw">RT - RW</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<input type="text" size="4" class="form-control" value="" name="rt"> - 
											<input type="text" size="4" class="form-control" value="" name="rw">
										</div>
									</div>
								</div>
								<div class="form-group row">
								<!----------------- ---->
									<p class="col-sm-4 form-control-label" id="lbl_provinsi">Provinsi</p>
									<div class="col-sm-7">
												<select id="prop" class="form-control select2" onchange="ajaxkota(this.value)">
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
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_kotakabupaten">Kota/Kabupaten</p>
									<div class="col-sm-7">
												<select id="kota" class="form-control select2" onchange="ajaxkec(this.value)">
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
													<option value="">-Pilih Kelurahan/Desa-</option>
												</select>
												<input type="hidden" class="form-control" id="kelurahandesa" value="<?php echo $row->kelurahandesa;?>" name="kelurahandesa">
												<input type="hidden" class="form-control" id="id_kelurahandesa" placeholder="" name="id_kelurahandesa">
											
										
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="kodepos">Kode Pos</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="" name="kodepos">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="pendidikan">Pendidikan</p>
									<div class="col-sm-7">
												<select class="form-control" name="pendidikan">
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
										<input type="text" class="form-control" value="" name="pekerjaan">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_telp">No. Telp</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="" maxlength="12" name="no_telp">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_hp">No. HP</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="" maxlength="12" name="no_hp">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="no_telp_kantor">No. Telp Kantor</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="" maxlength="12" name="no_telp_kantor">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="email">Email</p>
									<div class="col-sm-7">
										<input type="email" class="form-control" value="" name="email">
									</div>
								</div>								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="nama_ibu_istri">Nama Ibu Kandung</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="" name="nm_ibu_istri">
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
										<a type="reset" class="btn btn-primary" href="">Reset</a>
										
										
										
										<button type="submit" class="btn btn-primary">Simpan</button>
										<!--<a href="#" class="btn btn-primary">Cetak Kartu</a>-->
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
							<?php echo form_open('ird/IrDRegistrasi/insert_daftar_ulang'); ?>
		<input type="hidden" class="form-control" value="<?php echo $no_register;?>"name="no_register">
		<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>"name="no_medrec">
						<div style="margin-left:18px;margin-right:18px;">
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="jns_kunj">Jenis Kunjungan</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" readonly name="no_medrec">
												<?php echo ($jns_kunjungan == "LAMA" ? 
												
													'
													<input type="radio" class="flat-red" name="jns_kunj"  value="LAMA" checked >&nbsp;Lama
													&nbsp;&nbsp;&nbsp;
													<input type="radio" class="flat-red" name="jns_kunj"  value="BARU" disabled>&nbsp;Baru
									
													<input type="hidden"  name="jns_kunj" value="'.$jns_kunjungan.'">
													'
												:
												
													'
													<input type="radio"  class="flat-red" name="jns_kunj" class="jns_kunj" value="LAMA" disabled>&nbsp;Lama
													&nbsp;&nbsp;&nbsp;
													<input type="radio" class="flat-red" name="jns_kunj" class="jns_kunj" value="BARU" checked >&nbsp;Baru
													
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
									<div class="col-sm-7">
										<input type="text" class="form-control" placeholder="" value="<?php echo $nama;?>" name="nama" readonly>
									</div>
								</div>
																
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="kelas_pasien">Kelas Pasien</p>
									<div class="col-sm-7">
										<select class="form-control" name="kelas_pasien" required >
											<option value="III">III</option>											
										</select>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="tanggal_kunj">Tanggal Kunjungan</p>
									<div class="col-sm-7">
										<input type="date" class="form-control" placeholder="eg : 2001-05-11" id="tgl_kunj" name="tgl_kunj" value="<?php echo date('Y-m-d'); ?>"  required>
									</div>
								</div>
								
								<div class="form-group row">
								<!----------------- ---->
									<p class="col-sm-4 form-control-label" id="cara_bayar">Cara Bayar*</p>
									<div class="col-sm-7">
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
								<div class="form-group row" id="cek_sep" name="cek_sep"  style="width:99%;">
									<div class="pull-right"><a href="#responsive" class="btn btn-danger" onclick="cek_nokartu('<?php echo $no_medrec;?>')" >Validasi</a></div>
								</div>
								<div class="form-group row" id="input_kontraktor">
									<p class="col-sm-4 form-control-label" id="lbl_input_kontraktor">Kontraktor</p>
									<div class="col-sm-7">
										<select id="jenis_kontraktor" class="form-control select2" name="jenis_kontraktor" style="width : 100%;">
													<option value="">-Pilih Kontraktor-</option>
													<?php
													foreach($jenis_kontraktor as $row){
														foreach($data_pasien as $rows){
														if ( ($row->id_kontraktor==$rows->id_kontraktor1) || ($row->id_kontraktor==$rows->id_kontraktor2) )
														echo '<option value="'.$row->id_kontraktor.'">'.$row->nmkontraktor.'</option>';
}
													}
													?>
												</select>
									</div>
								</div>
							
								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="alber">Alasan Berobat</p >
										<div class="col-sm-7">
										<select class="form-control" name="alber" onchange="pilih_alber(this.value)" required>
											<option value="sakit">Sakit</option>
											<option value="kecelakaan">Kecelakaan</option>
											<option value="lain">Melahirkan</option>
										</select></div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="pasdatDg">Datang dengan</p>
									<div class="col-sm-7"><select class="form-control" name="pasdatDg" >
										<option value="klg">Keluarga</option>
										<option value="ttg">Tetangga</option>
										<option value="lain">Lain-lain</option>
									</select></div>
								</div>								
								<div class="form-group row" id="input_kecelakaan">
									<p class="col-sm-4 form-control-label" id="Kclkaan">Kecelakaan</p>
									<div class="col-sm-7">
										<select  class="form-control select2" name="jenis_kecelakaan">
													<option value="">-Pilih Jenis Kecelakaan-</option>
													<?php print_r($jenis_kecelakaan);
													foreach($jenis_kecelakaan as $row){
														echo '<option value="'.$row->nm_kecelakaan.'">'.$row->nm_kecelakaan.'</option>';
													}
													?>
												</select>
										
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="diagnosa">Diagnosa*</p>
									<div class="col-sm-8">								
										<input type="radio" class="flat-red" value="false" name="item[diag]" id="item_lain_false" checked="checked">
										<label for="item_lain_false" class="collection_radio_buttons" style="margin-bottom:10px;">List Diagnosa</label>		<br>											
										<input type="text" class="form-control input-sm auto_diagnosa_pasien" name="diagnosa" id="diagnosa" style="width:273px;font-size:15px;">	
										<input type="hidden" class="form-control " name="id_diagnosa" id="id_diagnosa">		
									</div>
								</div>
														
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="operator">Pelaksana*</p>
										<div class="col-sm-7">
											<select class="form-control select2" name="operatorTindakan" required style="width:100%;" >
											<option value="">-Pilih Pelaksana-</option>											
													<?php 
												
													foreach($operator as $row){
														echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'">'.$row->nm_dokter.'&nbsp;&nbsp;['.$row->id_dokter.'] </option>';
													}
													?>
											</select>
										</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" ></p>
									
									
									<div class="col-sm-7 ">
										<input type="radio" class="flat-red" value="true" name="item[diag]" id="item_lain_true">
								<label for="item_lain_true" class="collection_radio_buttons" style="margin-bottom:10px;">Lainnya</label><br><input id="item_diag_lain" type="text" name="item_diag_lain" disabled="disabled" style="width:100%;">
</div>
								</div>																


								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="nama_penjamin">Nama Penjamin</p>
									<div class="col-sm-7">
										<input type="text" class="form-control" placeholder="" name="nama_penjamin">
									</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="hubungan">Hubungan Keluarga</p>
									<div class="col-sm-7">
										<select class="form-control" name="hubungan" required>
											<option value="">-Hubungan Keluarga-</option>
											<option value="klg">Keluarga</option>
											<option value="Pk_kant">Pekerja Kantor</option>
											<option value="lain">Lain-lain</option>
										</select>
									</div>
								</div>
								
								<div class="form-inline" align="right">
									<div class="form-group">
										<button type="reset" class="btn btn-primary" >Reset</button>
										<!--<a href="#" class="btn btn-danger" >Cetak Kartu Poli</a>-->
										<button id="btn-submit" type="submit" class="btn btn-primary" >Cetak Karcis</button>									
										<!--<a href="<?php site_url('ird/IrDKwitansi/cetak_karcis/'.$no_register); ?>" class="btn btn-primary" >Cetak Karcis</a>-->
									</div>
								</div>
							<?php echo form_close();
							}
							?>
					</div></div>
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
