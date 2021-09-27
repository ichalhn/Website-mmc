<?php $this->load->view("layout/header"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
<script>
	
	var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_diagnosa_pasien').autocomplete({
		serviceUrl: site+'iri/ricstatus/data_icd_1',
		onSelect: function (suggestion) {
			//$('#no_cm').val(''+suggestion.no_cm);
			$('#diagnosa1').val(''+suggestion.id_icd);
	});
});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_dokter').autocomplete({
		serviceUrl: site+'/iri/ricpendaftaran/data_dokter_autocomp',
		onSelect: function (suggestion) {
			$('#id_dokter').val(''+suggestion.id_dokter);
			$('#dokter').val(''+suggestion.nm_dokter);
		}
	});
});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_dokter_pengirim').autocomplete({
		serviceUrl: site+'/iri/ricpendaftaran/data_dokter_autocomp',
		onSelect: function (suggestion) {
			$('#drpengirim').val(''+suggestion.nm_dokter);
		}
	});
});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_dokter_konsulen').autocomplete({
		serviceUrl: site+'/iri/ricpendaftaran/data_dokter_autocomp',
		onSelect: function (suggestion) {
			$('#drkonsulen').val(''+suggestion.nm_dokter);
		}
	});
});
</script>
<div >
	<div>
		
		<!-- Keterangan page -->
		<section class="content-header">
			<h1>RESUME MEDIK</h1>			
		</section>
		<!-- /Keterangan page -->

        <!-- Main content -->
        <section class="content">
			<div class="row">
				<div class="col-sm-12">
					<?php echo $this->session->flashdata('pesan');?>
					<div class="box box-success">
						<br/>
						
						<!-- Form Resume Medik -->
						<form class="form-horizontal" action="<?php echo site_url('iri/ricresume/simpan_resume'); ?>" method="post">
							<div class="box-body">
								<div class="row">
									<div class="col-sm-6 form-left">
										<div class="box-body">
											<div class="form-group">
												<div class="col-sm-3 control-label">No. Register</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['no_ipd'] ?>" name="no_ipd" id="no_ipd" >
												</div>
											</div>
											<?php if($data_pasien[0]['carabayar']=='BPJS'){?>
											<div class="form-group">
												<div class="col-sm-3 control-label">SEP</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['no_sep'] ?>" name="no_sep" id="no_sep" >
												</div>
											</div>
											<?php }?>
											
											<div class="form-group">
												<div class="col-sm-3 control-label">No. Rekam Medis</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['no_cm'] ?>" name="no_cm" id="no_cm" disabled>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Nama Pasien</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['nama'] ?> (<?php echo $data_pasien[0]['sex'] ?>)" name="nama" id="nama" disabled>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Alamat</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['alamat'] ?>" name="alamat" id="alamat" disabled>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Telepon</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['no_telp'] ?>" name="alamat" id="alamat" disabled>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Tgl. Lahir</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo date('Y-m-d',strtotime($data_pasien[0]['tgl_lahir'])) ?>" name="tgl_lahir" id="tgl_lahir" disabled>
													<input type="text" class="form-control input-sm" value="<?php
									$interval = date_diff(date_create(), date_create($data_pasien[0]['tgl_lahir']));
									echo $interval->format("%Y Tahun, %M Bulan, %d Hari");
								?>" name="usia" id="usia" disabled>
												</div>
											</div>
											
											<div class="form-group">
												<div class="col-sm-3 control-label">Tgl. Masuk</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['tgl_masuk'] ?>" name="tgl_masuk" id="tgl_masuk" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Tgl. Meninggal</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="tgl_meninggal" id="tgl_meninggal" value="<?php echo $data_pasien[0]['tgl_meninggal'] ?>">
													<input type="text" class="form-control input-sm" name="jam_meninggal" id="jam_meninggal" value="<?php echo $data_pasien[0]['jam_meninggal'] ?>">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Kondisi Meninggal</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="tgl_meninggal" id="kondisi_meninggal" value="<?php echo $data_pasien[0]['kondisi_meninggal'] ?>">													
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Keadaan Datang</div>
												<div class="col-sm-9">												
													<div class="col-sm-12 input-right"><input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['id_smf'] ?>" name="id_smf" id="id_smf" ></div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Ruang</div>
												<div class="col-sm-9">
													<div class="col-sm-3 input-left"><input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['idrg'] ?>" name="idrg" id="idrg" ></div>
													<div class="col-sm-9 input-right"><input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['nmruang'] ?>" name="nmruang" id="nmruang" ></div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Kelas / Bed</div>
												<div class="col-sm-9">
													<div class="col-sm-3 input-left"><input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['kelas'] ?>" name="kelas" id="kelas" ></div>
													<div class="col-sm-9 input-right"><input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['bed'] ?>" name="bed" id="bed" ></div>													
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Dr. Pengirim</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm auto_no_register_dokter_pengirim" value="<?php echo $data_pasien[0]['drpengirim'] ?>" name="drpengirim" id="drpengirim" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Dr. Yang Merawat</div>
												<div class="col-sm-9">
													<input type="hidden"  value="<?php echo $data_pasien[0]['id_dokter'] ?>" name="id_dokter" id="id_dokter" >
													<div class="col-sm-9 input-right"><input type="text" class="form-control input-sm auto_no_register_dokter" value="<?php echo $data_pasien[0]['dokter'] ?>" name="dokter" id="dokter" ></div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="box-body">
											<div class="form-group">
												<div class="col-sm-3 control-label">Dr. Konsulen</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm auto_no_register_dokter_konsulen" value="<?php echo $data_pasien[0]['drkonsulen'] ?>" name="drkonsulen" id="drkonsulen" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Anamnesa</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['anamnesa'] ?>" name="anamnesa" id="anamnesa" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Riwayat Penyakit</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="" name="riwpenyakit" id="riwpenyakit" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Pemeriksaan Fisik</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['pemfisik'] ?>" name="pemfisik" id="pemfisik" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Diagnosa Masuk</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm auto_diagnosa_pasien" name="nm_diagnosa" id="nm_diagnosa" value="<?php echo $data_pasien[0]['diagmasuk'].' - '.$data_pasien[0]['nm_diagmasuk'] ?>">
													<input type="hidden" name="diagmasuk" id="diagmasuk" value="<?php echo $data_pasien[0]['diagmasuk'] ?>">						
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Kode ICD 9</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm auto_diagnosa_pasien" name="nm_procicd" id="nm_procicd" value="">
													<input type="hidden" name="nm_procicd" id="nm_procicd" value="">						
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Diagnosa Akhir</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm auto_diagnosa_pasien" name="nm_diagnosa" id="nm_diagnosa" value="<?php echo $data_pasien[0]['diagnosa1'].' - '.$data_pasien[0]['nm_diagnosa'] ?>">
													<input type="hidden" name="diagnosa1" id="diagnosa1" value="<?php echo $data_pasien[0]['diagnosa1'] ?>">

													<!-- kalo ada diagnosa tambahan -->
													<?php
													if(!empty($diagnosa_pasien)){ ?>
													Diagnosa Tambahan :
													<br>

													<?php
													foreach ($diagnosa_pasien as $r) {
														echo $r['id_diagnosa']." - ".$r['diagnosa']."<br>";
													}
													?>

													<?php
													}
													?>
													<!-- kalo ada diagnosa tambahan -->
												</div>
											</div>

											<div class="form-group">
												<div class="col-sm-3 control-label"></div>
												<div class="col-sm-9">
													<a href="<?php echo base_url()?>iri/rictindakan/tambah_diagnosa/<?php echo  $data_pasien[0]['no_ipd'] ;?>"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah Diagnosa</button></a>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Diagnosa Post Tindakan</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="nm_diagpost" id="nm_diagpost" value="">					
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Pengobatan/ Tindakan</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['pngobatan'] ?>" name="pngobatan" id="pngobatan" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Prognosis</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['prognosis'] ?>" name="prognosis" id="prognosis" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Pengobatan Lanjutan</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['lanjutan'] ?>" name="lanjutan" id="lanjutan" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Anjuran</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['anjuran'] ?>" name="anjuran" id="anjuran" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Tgl Kontrol</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="tgl_kontrol" id="tgl_kontrol" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Cara Masuk</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['id_smf'] ?>" name="id_smf" id="id_smf" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Keadaan Pulang</div>
												<div class="col-sm-9">
													<select class="form-control input-sm" name="keadaanpulang">
														<option value="ATAS PERSETUJUAN DOKTER" <?php if($data_pasien[0]['keadaanpulang'] == "ATAS PERSETUJUAN DOKTER"){echo "selected='true'" ;}?> >ATAS PERSETUJUAN DOKTER</option>
														<option value="MENINGGAL" <?php if($data_pasien[0]['keadaanpulang'] == "MENINGGAL"){echo "selected='true'" ;}?>>MENINGGAL</option>
														<option value="DIRUJUK" <?php if($data_pasien[0]['keadaanpulang'] == "DIRUJUK"){echo "selected='true'" ;}?>>DIRUJUK</option>
														<option value="ATAS PERMINTAAN SENDIRI" <?php if($data_pasien[0]['keadaanpulang'] == "ATAS PERMINTAAN SENDIRI"){echo "selected='true'" ;}?>>ATAS PERMINTAAN SENDIRI</option>
														<option value="LAIN-LAIN" <?php if($data_pasien[0]['keadaanpulang'] == "LAIN-LAIN"){echo "selected='true'" ;}?>>LAIN-LAIN</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Tgl Pulang</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="tgl_pulang" id="tgl_pulang" >
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-8">
										<div class="button-reservasi">
											<?php
												$status_simpan = $this->uri->segment(5);
												if($status_simpan == 1){ ?>
												<a target="blank" href="<?php echo base_url()?>iri/ricresume/pdf_resume/<?php echo  $data_pasien[0]['no_ipd'] ;?>"> <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Cetak Resume Medik</button></a>
												<?php
												}else{ ?>
												<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Simpan Data</button>
												<?php
												}
											?>
										</div>
									</div>
								</div>
							</div>
						</form>
						<!-- /Form Resume Medik -->
						
					</div>
				</div>
			</div>
		</section>
		<!-- /Main content -->
		
	</div>
</div>
<script>
	$('#calendar-tgl-lahir').datepicker();
	$('#calendar-tgl-masuk').datepicker();
	$('#calendar-tgl-meninggal').datepicker();
	$('#tgl_meninggal').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
		minDate: '0'
	});
	$('#tgl_pulang').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
		minDate: '0'
	});
	$('#tgl_kontrol').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
		minDate: '0'
	});
	$("#tgl_pulang").datepicker("setDate", new Date());
</script>

<?php $this->load->view("layout/footer"); ?>
