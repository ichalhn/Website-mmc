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
			// $('#nama').val(''+suggestion.nama);
			// $('.tanggal_lahir').val(''+suggestion.tanggal_lahir);
			// if(suggestion.jenis_kelamin=='L'){
			// 	$('#laki_laki').attr('selected', 'selected');
			// 	$('#perempuan').removeAttr('selected', 'selected');
			// }else{
			// 	$('#laki_laki').removeAttr('selected', 'selected');
			// 	$('#perempuan').attr('selected', 'selected');
			// }
			// $('#telp').val(''+suggestion.telp);
			// $('#hp').val(''+suggestion.hp);
			// $('#id_poli').val(''+suggestion.id_poli);
			// $('#poliasal').val(''+suggestion.poliasal);
			// $('#id_dokter').val(''+suggestion.id_dokter);
			// $('#dokter').val(''+suggestion.dokter);
			// $('#diagnosa').val(''+suggestion.diagnosa);
		}
	});
});
</script>
<div >
	<div>
		
		<!-- Keterangan page -->
		<section class="content-header">
			<h1>RESUME MEDIK</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-home"></i> Home</a></li>
				<li><a href="#">Resume</a></li>
			</ol>
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
											<div class="form-group">
												<div class="col-sm-3 control-label">No. Reka Medis</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['no_cm'] ?>" name="no_cm" id="no_cm" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Nama</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['nama'] ?>" name="nama" id="nama" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Alamat</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['alamat'] ?>" name="alamat" id="alamat" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Tgl. Lahir</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['tgl_lahir'] ?>" name="tgl_lahir" id="tgl_lahir" >
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
													<input type="text" class="form-control input-sm" name="tgl_meninggal" value="<?php echo $data_pasien[0]['id_smf'] ?>" id="tgl_meninggal" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">SMF</div>
												<div class="col-sm-9">
													<div class="col-sm-3 input-left"><input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['id_smf'] ?>" name="id_smf" id="id_smf" ></div>
													<div class="col-sm-9 input-right"><input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['id_smf'] ?>" name="id_smf" id="id_smf" ></div>
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
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['drpengirim'] ?>" name="drpengirim" id="drpengirim" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Dr. Yang Merawat</div>
												<div class="col-sm-9">
													<input type="hidden"  value="<?php echo $data_pasien[0]['id_dokter'] ?>" name="id_dokter" id="id_dokter" >
													<div class="col-sm-9 input-right"><input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['dokter'] ?>" name="dokter" id="dokter" ></div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="box-body">
											<div class="form-group">
												<div class="col-sm-3 control-label">Dr. Konsulen</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['drkonsulen'] ?>" name="drkonsulen" id="drkonsulen" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Anamnesa</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['anamnesa'] ?>" name="anamnesa" id="anamnesa" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Pemeriksaan Fisik</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['pemfisik'] ?>" name="pemfisik" id="pemfisik" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Diagnosa Akhir</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm auto_diagnosa_pasien" name="nm_diagnosa" id="nm_diagnosa" value="<?php echo $data_pasien[0]['nm_diagnosa'] ?>">
													<input type="hidden" name="diagnosa1" id="diagnosa1" value="<?php echo $data_pasien[0]['diagnosa1'] ?>">
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
												<div class="col-sm-3 control-label">Cara Masuk</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" value="<?php echo $data_pasien[0]['id_smf'] ?>" name="id_smf" id="id_smf" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Keadaan Pulang</div>
												<div class="col-sm-9">
													<select class="form-control input-sm" name="keadaanpulang">
														<option value="DIPULANGKAN" <?php if($data_pasien[0]['keadaanpulang'] == "DIPULANGKAN"){echo "selected='true'" ;}?> >DIPULANGKAN</option>
														<option value="MENINGGAL" <?php if($data_pasien[0]['keadaanpulang'] == "MENINGGAL"){echo "selected='true'" ;}?>>MENINGGAL</option>
														<option value="PULANG SENDIRI" <?php if($data_pasien[0]['keadaanpulang'] == "PULANG"){echo "selected='true'" ;}?>>PULANG</option>
														<option value="MELARIKAN DIRI" <?php if($data_pasien[0]['keadaanpulang'] == "MELARIKAN DIRI"){echo "selected='true'" ;}?>>MELARIKAN DIRI</option>
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
	$("#tgl_pulang").datepicker("setDate", new Date());
</script>

<?php $this->load->view("layout/footer"); ?>
