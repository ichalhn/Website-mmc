<?php $this->load->view("layout/header"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>

<script>
var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_rawatjalan').autocomplete({
		serviceUrl: site+'/iri/ricreservasi/data_pasien_irj',
		onSelect: function (suggestion) {
			//$('#no_cm').val(''+suggestion.no_cm);
			$('#no_cm').val(''+suggestion.no_cm_real);
			$('#no_cm_h').val(''+suggestion.no_cm);
			$('#nama').val(''+suggestion.nama);
			$('.tanggal_lahir').val(''+suggestion.tanggal_lahir);
			if(suggestion.jenis_kelamin=='L'){
				$('#laki_laki').attr('selected', 'selected');
				$('#perempuan').removeAttr('selected', 'selected');
			}else{
				$('#laki_laki').removeAttr('selected', 'selected');
				$('#perempuan').attr('selected', 'selected');
			}
			$('#telp').val(''+suggestion.telp);
			$('#hp').val(''+suggestion.hp);
			$('#id_poli').val(''+suggestion.id_poli);
			$('#poliasal').val(''+suggestion.poliasal);
			$('#id_dokter').val(''+suggestion.id_dokter);
			$('#dokter').val(''+suggestion.dokter);
			$('#diagnosa').val(suggestion.diagnosa_id+' - '+suggestion.diagnosa);
			$('#diagnosa_id').val(''+suggestion.diagnosa_id);
		}
	});
});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_ruangrawat').autocomplete({
		serviceUrl: site+'/iri/ricreservasi/data_pasien_iri',
		onSelect: function (suggestion) {
			$('#no_cm').val(''+suggestion.no_cm);
			$('#no_cm_h').val(''+suggestion.no_cm);
			$('#nama').val(''+suggestion.nama);
			$('.tanggal_lahir').val(''+suggestion.tanggal_lahir);
			if(suggestion.jenis_kelamin=='L'){
				$('#laki_laki').attr('selected', 'selected');
				$('#perempuan').removeAttr('selected', 'selected');
			}else{
				$('#laki_laki').removeAttr('selected', 'selected');
				$('#perempuan').attr('selected', 'selected');
			}
			$('#telp').val(''+suggestion.telp);
			$('#hp').val(''+suggestion.hp);
			$('#id_poli').val(''+suggestion.id_poli);
			$('#poliasal').val(''+suggestion.poliasal);
			$('#id_dokter').val(''+suggestion.id_dokter);
			$('#dokter').val(''+suggestion.dokter);
			$('#diagnosa').val(suggestion.diagnosa_id+' - '+suggestion.diagnosa);
			$('#diagnosa_id').val(''+suggestion.diagnosa_id);
		}
	});
});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_rawatdarurat').autocomplete({
		serviceUrl: site+'/iri/ricreservasi/data_pasien_ird',
		onSelect: function (suggestion) {
			//$('#no_cm').val(''+suggestion.no_cm);
			$('#no_cm').val(''+suggestion.no_cm_real);
			$('#no_cm_h').val(''+suggestion.no_cm);
			$('#nama').val(''+suggestion.nama);
			$('.tanggal_lahir').val(''+suggestion.tanggal_lahir);
			if(suggestion.jenis_kelamin=='L'){
				$('#laki_laki').attr('selected', 'selected');
				$('#perempuan').removeAttr('selected', 'selected');
			}else{
				$('#laki_laki').removeAttr('selected', 'selected');
				$('#perempuan').attr('selected', 'selected');
			}
			$('#telp').val(''+suggestion.telp);
			$('#hp').val(''+suggestion.hp);
			$('#id_poli').val(''+suggestion.id_poli);
			$('#poliasal').val(''+suggestion.poliasal);
			$('#id_dokter').val(''+suggestion.id_dokter);
			$('#dokter').val(''+suggestion.dokter);
			$('#diagnosa').val(suggestion.diagnosa_id+' - '+suggestion.diagnosa);
			$('#diagnosa_id').val(''+suggestion.diagnosa_id);
		}
	});
});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_ruang').autocomplete({
		serviceUrl: site+'/iri/ricreservasi/data_ruang',
		onSelect: function (suggestion) {
			$('#ruang').val(''+suggestion.idrg);
			$('#nm_ruang').val(''+suggestion.nmruang);
			//$('#kelas').val(''+suggestion.kelas);
		}
	});
});

$(document).ready(function() {

	$('#calendar-tgl-lahir').datepicker({
		format: 'yyyy-mm-dd',
		minDate: 0
	});
	$('#calendar-tgl-sp-rawat').datepicker({
		format: 'yyyy-mm-dd',
		minDate: 0
	});
	$('#calendar-tgl-rencana-masuk').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
		minDate: '0'
	});
	$("#calendar-tgl-rencana-masuk").datepicker("setDate", new Date());
	
	// $("#form_reservasi").validate({ 
	// 	rules: { 
	// 		noreservasi: "required",
	// 		no_cm: "required",
	// 		nama: "required",
	// 		tgllahir: "required",
	// 		telp: "required",
	// 		poliasal: "required",
	// 		dokter: "required",
	// 		diagnosa: "required",
			
	// 		tglrencanamasuk: "required",
	// 		tglsprawat: "required",
	// 		nm_ruang: "required",
	// 		kelas: "required",
	// 		keterangan: "required"
	// 	}
	// }); 
	
	$('#pilihan_prioritas').change(function(){
		var kasus = $('#pilihan_prioritas').val();
		if(kasus=='-'){
			$('#normal').attr('selected', 'selected');
			$('#high').removeAttr('selected', 'selected');
		}else{
			$('#normal').removeAttr('selected', 'selected');
			$('#high').attr('selected', 'selected');
		}
	});
	
	<?php
	if($data_pasien == ''){ ?>
		$(function(){
			$('#no_register_rawatjalan').show();
			$('#no_register_ruangrawat').hide();
			$('#no_register_rawatdarurat').hide();
			document.getElementById("no_register_rawatjalan").required = true;
			document.getElementById("no_register_ruangrawat").required = false;
			document.getElementById("no_register_rawatdarurat").required = false;
		});
	<?php
	}
	?>
	
	$('#tppri').change(function(){
			var tppri = $('#tppri').val();
			if(tppri=='rawatjalan'){
				document.getElementById("no_register_rawatjalan").required = true;
				document.getElementById("no_register_ruangrawat").required = false;
				document.getElementById("no_register_rawatdarurat").required = false;
				$('#no_register_rawatjalan').show();
				$('#no_register_ruangrawat').hide();
				$('#no_register_rawatdarurat').hide();
			}else if(tppri=='ruangrawat'){
				document.getElementById("no_register_rawatjalan").required = false;
				document.getElementById("no_register_ruangrawat").required = true;
				document.getElementById("no_register_rawatdarurat").required = false;
				$('#no_register_rawatjalan').hide();
				$('#no_register_ruangrawat').show();
				$('#no_register_rawatdarurat').hide();
			}else{
				document.getElementById("no_register_rawatjalan").required = false;
				document.getElementById("no_register_ruangrawat").required = false;
				document.getElementById("no_register_rawatdarurat").required = true;
				$('#no_register_rawatjalan').hide();
				$('#no_register_ruangrawat').hide();
				$('#no_register_rawatdarurat').show();
			}
		});
});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_diagnosa_pasien').autocomplete({
		serviceUrl: site+'iri/ricstatus/data_icd_1',
		onSelect: function (suggestion) {
			//$('#no_cm').val(''+suggestion.no_cm);
			$('#diagnosa').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
			$('#diagnosa_id').val(''+suggestion.id_icd);
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
	<section class="content">
		<div class="row">			
			<div class="col-md-12">
				<?php echo $this->session->flashdata('pesan');?>
				<div class="panel panel-info">
					<div class="panel-heading" align="center" ><h4>RESERVASI ANTRIAN PASIEN RAWAT INAP</h4></div>
					<!-- Reservasi -->
								<form class="form-horizontal" action="<?php echo site_url('iri/ricreservasi/insert_reservasi'); ?>" method="POST" id="form_reservasi">
									<div class="row">
										<div class="col-sm-6 form-left">
											<div class="box-body">
												<div class="form-group">
													<div class="col-sm-3 control-label">Asal</div>
													<div class="col-sm-4">
														<?php
														if($data_pasien == ''){ ?>
														<select class="form-control input-sm" id="tppri" name="tppri">
															<option value="rawatjalan">Rawat Jalan</option>
															<option value="ruangrawat">Ruang Rawat</option>
															<option value="rawatdarurat">Rawat Darurat</option>
														</select>
														<?php
														}else{ 
														// kalo mutasi
														?>
														<select class="form-control input-sm" id="tppri" name="tppri" >
															<option value="ruangrawat" selected="true">Ruang Rawat</option>
														</select>
														<?php
														}
														?>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Rujukan</div>
													<div class="col-sm-4">
														<select class="form-control input-sm" name="rujukan">
															<option value="regional">Regional</option>
															<option value="nasional">Nasional</option>
															<option value="rslain">RS Lain</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Reg. Asal *</div>
													<div class="col-sm-9" align="left">
														<span class="label-form-validation"></span>
														<div class="col-sm-4 input-left">
															<?php
															if($data_pasien == ''){ ?>
															<input type="text" class="form-control input-sm auto_no_register_rawatjalan" name="no_register_rawatjalan" id="no_register_rawatjalan">
															<input type="text" class="form-control input-sm auto_no_register_ruangrawat" name="no_register_ruangrawat" id="no_register_ruangrawat">
															<input type="text" class="form-control input-sm auto_no_register_rawatdarurat" name="no_register_rawatdarurat" id="no_register_rawatdarurat">
															<?php
															}else{ ?>
															<input type="text" class="form-control input-sm auto_no_register_ruangrawat" name="no_register_ruangrawat" id="no_register_ruangrawat" value="<?php echo $data_pasien[0]['no_ipd'] ;?>">
															<?php
															}
															?>
														</div>
														<?php
														if($data_pasien == ''){ ?>
														<div class="col-sm-8 input-right"><input type="text" class="form-control input-sm" name="nama" id="nama" disabled="true"></div>
														<?php
														}else{ ?>
														<div class="col-sm-8 input-right"><input type="text" class="form-control input-sm" name="nama" id="nama" disabled="true" value="<?php echo $data_pasien[0]['nama'] ;?>"></div>
														<?php
														}
														?>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">No. Medrec</div>
													<div class="col-sm-9">
														<span class="label-form-validation"></span>
														<?php
														if($data_pasien == ''){ ?>
														<input type="text" class="form-control input-sm" name="no_cm" id="no_cm" disabled="true">
														<input type="hidden" class="form-control input-sm" name="no_cm_h" id="no_cm_h">
														<?php
														}else{ ?>
														<input type="text" class="form-control input-sm" name="no_cm" id="no_cm" disabled="true" value="<?php echo $data_pasien[0]['no_cm'] ;?>">
														<input type="hidden" class="form-control input-sm" name="no_cm_h" id="no_cm_h" value="<?php echo $data_pasien[0]['no_medrec'] ;?>">
														<?php
														}
														?>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Jenis Kelamin</div>
													<div class="col-sm-4">
														<select class="form-control input-sm" name="sex" disabled="true">
															<?php
															if($data_pasien == ''){ ?>
															<option id="laki-laki" value="L">Laki-Laki</option>
															<option id="perempuan" value="P">Perempuan</option>
															<?php
															}else{ 
																if($data_pasien[0]['sex'] == 'P'){ ?>
																<option id="laki-laki" value="L">Laki-Laki</option>
																<option id="perempuan" value="P" selected="true">Perempuan</option>
																<?php
																}
																else{ ?>
																<option id="laki-laki" value="L" selected="true">Laki-Laki</option>
																<option id="perempuan" value="P">Perempuan</option>
																<?php
																}
																?>
															<?php
															}
															?>
															
														</select>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Tanggal Lahir</div>
													<div class="col-sm-9">
														<span class="label-form-validation"></span>
														<?php
														if($data_pasien == ''){ ?>
														<input type="text" class="form-control input-sm tanggal_lahir" id="calendar-tgl-lahir" name="tgllahir" disabled="true">
														<?php
														}else{ ?>
														<input type="text" class="form-control input-sm tanggal_lahir" id="calendar-tgl-lahir" name="tgllahir" disabled="true" value="<?php echo $data_pasien[0]['tgl_lahir'] ;?>">
														<?php
														}
														?>

													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Telp</div>
													<div class="col-sm-9">
														<span class="label-form-validation"></span>
														<?php
														if($data_pasien == ''){ ?>
														<input type="text" class="form-control input-sm" name="telp" id="telp">
														<?php
														}else{ ?>
														<input type="text" class="form-control input-sm" name="telp" id="telp" value="<?php echo $data_pasien[0]['no_telp'] ;?>">
														<?php
														}
														?>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">HP</div>
													<div class="col-sm-9">
														<span class="label-form-validation"></span>
														<?php
														if($data_pasien == ''){ ?>
														<input type="text" class="form-control input-sm" name="hp" id="hp">
														<?php
														}else{ ?>
														<input type="text" class="form-control input-sm" name="hp" id="hp" value="<?php echo $data_pasien[0]['no_hp'] ;?>">
														<?php
														}
														?>
													</div>
												</div>
											</div>
											
											<div class="box-body">
												<h4 class="title-form">ASAL PASIEN</h4>
												<div class="form-group">
													<div class="col-sm-3 control-label">Poli/Ruang Asal</div>
													<div class="col-sm-9" align="left">
														<span class="label-form-validation"></span>
														<?php
														if($data_pasien == ''){ ?>
														<div class="col-sm-4 input-left"><input type="text" class="form-control input-sm" name="id_poli" id="id_poli" ></div>
														<div class="col-sm-8 input-right"><input type="text" class="form-control input-sm" name="poliasal" id="poliasal" ></div>
														<?php
														}else{ ?>
														<div class="col-sm-4 input-left"><input type="text" class="form-control input-sm" name="id_poli" id="id_poli" disabled="true" value="<?php echo $data_pasien[0]['idrg'] ;?>" ></div>
														<div class="col-sm-8 input-right"><input type="text" class="form-control input-sm" name="poliasal" id="poliasal" disabled="true" value="<?php echo $data_pasien[0]['nmruang'] ;?>" ></div>
														<?php
														}
														?>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Dokter</div>
													<div class="col-sm-9" align="left">
														<span class="label-form-validation"></span>
														<?php
														if($data_pasien == ''){ ?>
														<input type="hidden" name="id_dokter" id="id_dokter">
														<input type="text" class="form-control input-sm" name="dokter" id="dokter" value="">
														<?php
														}else{ ?>
														<input type="hidden" name="id_dokter" id="id_dokter">
														<input type="text" class="form-control input-sm" name="dokter" id="dokter" value="<?php echo $data_pasien[0]['dokter'] ;?>">
														<?php
														}
														?>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Diagnosa</div>
													<div class="col-sm-9">
														<span class="label-form-validation"></span>
														<?php
														if($data_pasien == ''){ ?>
														<input type="text" class="form-control input-sm auto_diagnosa_pasien" name="diagnosa" id="diagnosa" ><div id="loading_diagnosa"></div>
														<input type="hidden" name="diagnosa_id" id="diagnosa_id" >
														<?php
														}else{ ?>
														<input type="text" class="form-control input-sm auto_diagnosa_pasien" name="diagnosa" id="diagnosa" value="<?php echo $data_pasien[0]['nm_diagnosa'] ;?>" ><div id="loading_diagnosa"></div>
														<input type="hidden" name="diagnosa_id" id="diagnosa_id" value="<?php echo $data_pasien[0]['diagmasuk'] ;?>" >
														<?php
														}
														?>
													</div>
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="box-body">
												<h4 class="title-form">RENCANA MASUK</h4>
												<div class="form-group">
													<div class="col-sm-3 control-label">Rencana Masuk *</div>
													<div class="col-sm-9">
														<span class="label-form-validation"></span>
														<input type="text" class="form-control input-sm" id="calendar-tgl-rencana-masuk" name="tglrencanamasuk" required>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Ruang Pilih *</div>
													<div class="col-sm-9">
														<span class="label-form-validation"></span>
														<select class="form-control input-sm" id="ruang" name="ruang" required>
															<?php
															if(empty($kelas)){ ?>
															<option value="">Ruang Penuh</option>
															<?php
															} else{ 
																foreach ($kelas as $r) {
															?>
																<option value="<?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?>"><?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?></option>
															<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<!-- <div class="form-group">
													<div class="col-sm-3 control-label">Ruang Pilih *</div>
													<div class="col-sm-9">
														<span class="label-form-validation"></span>
														<input type="text" class="form-control input-sm auto_ruang" id="ruang" name="ruang">
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label"></div>
													<div class="col-sm-9">
														<span class="label-form-validation"></span>
														<div class="col-sm-8 input-left"><input type="text" class="form-control input-sm" id="nm_ruang" name="nm_ruang" disabled="true"></div>
														<div class="col-sm-4 input-right">
															<select class="form-control input-sm" id="kelas" name="kelas">
																<?php
																//foreach ($kelas as $r) { ?>
																<option value="<?php //echo $r['kelas'] ;?>"><?php //echo $r['kelas'] ;?></option>
																<?php
																//}
																?>
															</select>
														</div>

													</div>
												</div> -->
												<div class="form-group">
													<div class="col-sm-3 control-label">Kasus</div>
													<div class="col-sm-4">
														<select class="form-control input-sm" id="pilihan_prioritas" name="pilihan_prioritas">
															<option value="-">-</option>
															<option value="IRD">Emergency</option>
															<option value="KEMO">Kemoterapi</option>
															<option value="HEMO">Hemodialisa</option>
															<option value="OPERASI">Operasi Terjadwal</option>
															<option value="TALA">Talamesia</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Prioritas</div>
													<div class="col-sm-3">
														<select class="form-control input-sm" name="prioritas">
															<option id="normal" value="normal">Normal</option>
															<option id="high" value="high">High</option>
														</select>
													</div>
													<div class="col-sm-6">
														<input type="checkbox" value="Y" name="infeksi"> Infeksi
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Keterangan *</div>
													<div class="col-sm-9">
														<span class="label-form-validation"></span>
														<input type="text" class="form-control input-sm" name="keterangan" id="keterangan" required>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div class="button-reservasi">
												<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
												<a href="<?php echo site_url('iri/ricreservasi'); ?>"><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-remove"></i> Batal</button></a>
											</div>							
										</div>
									</div>
									
									<!-- Modal -->
									<div class="modal fade bs-example-modal-sm" id="modal-reservasi" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
												</div>
												<div class="modal-body">
													Apakah kamu yakin dengan data tersebut?
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-remove"></i> Tidak</button>
													<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Ya</button>
												</div>
											</div>
										</div>
									</div>
									<!-- /Modal -->
									
								</form>
								<!-- /Reservasi -->
					<!--- end panel body -->
				</div>
				<!--- end panel -->
			</div>
		<!--- end col -->
			
		</div><!--- end row -->
	</section>
<?php $this->load->view("layout/footer"); ?>
