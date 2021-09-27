<script>
var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_rawatjalan').autocomplete({
		serviceUrl: site+'/iri/ricreservasi/data_pasien_irj',
		onSelect: function (suggestion) {
			$('#no_cm').val(''+suggestion.no_cm);
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
			$('#diagnosa').val(''+suggestion.diagnosa);
		}
	});
});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_ruangrawat').autocomplete({
		serviceUrl: site+'/iri/ricreservasi/data_pasien_iri',
		onSelect: function (suggestion) {
			$('#no_cm').val(''+suggestion.no_cm);
			$('#nama').val(''+suggestion.nama);
			$('.tanggal_lahir').val('-');
			$('#laki_laki').attr('selected', 'selected');
			$('#perempuan').removeAttr('selected', 'selected');
			$('#telp').val('-');
			$('#hp').val('-');
			$('#id_poli').val('-');
			$('#poliasal').val('-');
			$('#id_dokter').val('-');
			$('#dokter').val('-');
			$('#diagnosa').val('-');
		}
	});
});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_rawatdarurat').autocomplete({
		serviceUrl: site+'/iri/ricreservasi/data_pasien_ird',
		onSelect: function (suggestion) {
			$('#no_cm').val(''+suggestion.no_cm);
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
			$('#diagnosa').val(''+suggestion.diagnosa);
		}
	});
});

$(function(){
	$('#no_register_rawatjalan').show();
	$('#no_register_ruangrawat').hide();
	$('#no_register_rawatdarurat').hide();
});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_ruang').autocomplete({
		serviceUrl: site+'/iri/ricreservasi/data_ruang',
		onSelect: function (suggestion) {
			$('#ruang').val(''+suggestion.idrg);
			$('#nm_ruang').val(''+suggestion.nmruang);
			$('#kelas').val(''+suggestion.kelas);
		}
	});
});

$(document).ready(function() {
	$("#form_reservasi").validate({ 
		rules: { 
			noreservasi: "required",
			no_cm: "required",
			nama: "required",
			tgllahir: "required",
			telp: "required",
			poliasal: "required",
			dokter: "required",
			diagnosa: "required",
			
			tglrencanamasuk: "required",
			tglsprawat: "required",
			nm_ruang: "required",
			kelas: "required",
			keterangan: "required"
		}
	}); 
	
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
	
	$('#tppri').change(function(){
		var tppri = $('#tppri').val();
		if(tppri=='rawatjalan'){
			$('#no_register_rawatjalan').show();
			$('#no_register_ruangrawat').hide();
			$('#no_register_rawatdarurat').hide();
		}else if(tppri=='ruangrawat'){
			$('#no_register_rawatjalan').hide();
			$('#no_register_ruangrawat').show();
			$('#no_register_rawatdarurat').hide();
		}else{
			$('#no_register_rawatjalan').hide();
			$('#no_register_ruangrawat').hide();
			$('#no_register_rawatdarurat').show();
		}
	});
});
</script>
<div class="wrapper">
	<div class="content-wrapper">
		
		<!-- Keterangan page -->
		<section class="content-header">
			<h1>RESERVASI ANTRIAN PASIEN RAWAT INAP</h1>			
		</section>
		<!-- /Keterangan page -->
		
        <!-- Main content -->
        <section class="content">
			<div class="row">
				<div class="col-sm-12">
					<?php echo $this->session->flashdata('pesan');?>
					
					<!-- Tabs -->
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#reservasi" data-toggle="tab">Reservasi</a></li>
							<li class=""><a href="#approve" data-toggle="tab">Approve</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="reservasi">
								
								<!-- Reservasi -->
								<form class="form-horizontal" action="<?php echo site_url('iri/ricreservasi/insert_reservasi'); ?>" method="POST" id="form_reservasi">
									<div class="row">
										<div class="col-sm-6 form-left">
											<div class="box-body">
												<div class="form-group">
													<div class="col-sm-3 control-label">Asal</div>
													<div class="col-sm-4">
														<select class="form-control input-sm" id="tppri" name="tppri">
															<option value="rawatjalan">Rawat Jalan</option>
															<option value="ruangrawat">Ruang Rawat</option>
															<option value="rawatdarurat">Rawat Darurat</option>
														</select>
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
													<div class="col-sm-3 control-label">No. Medrec</div>
													<div class="col-sm-9">
														<span class="label-form-validation"></span>
														<input type="text" class="form-control input-sm" name="no_cm" id="no_cm" readonly>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Reg. Asal *</div>
													<div class="col-sm-9" align="left">
														<span class="label-form-validation"></span>
														<div class="col-sm-4 input-left">
															<input type="text" class="form-control input-sm auto_no_register_rawatjalan" name="no_register_rawatjalan" id="no_register_rawatjalan">
															<input type="text" class="form-control input-sm auto_no_register_ruangrawat" name="no_register_ruangrawat" id="no_register_ruangrawat">
															<input type="text" class="form-control input-sm auto_no_register_rawatdarurat" name="no_register_rawatdarurat" id="no_register_rawatdarurat">
														</div>
														<div class="col-sm-8 input-right"><input type="text" class="form-control input-sm" name="nama" id="nama"></div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Jenis Kelamin</div>
													<div class="col-sm-4">
														<select class="form-control input-sm" name="sex">
															<option id="laki-laki" value="L">Laki-Laki</option>
															<option id="perempuan" value="P">Perempuan</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Tanggal Lahir</div>
													<div class="col-sm-9">
														<span class="label-form-validation"></span>
														<input type="text" class="form-control input-sm tanggal_lahir" id="calendar-tgl-lahir" name="tgllahir">
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Telp *</div>
													<div class="col-sm-9">
														<span class="label-form-validation"></span>
														<input type="text" class="form-control input-sm" name="telp" id="telp">
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">HP</div>
													<div class="col-sm-9">
														<span class="label-form-validation"></span>
														<input type="text" class="form-control input-sm" name="hp" id="hp">
													</div>
												</div>
											</div>
											
											<div class="box-body">
												<h4 class="title-form">ASAL PASIEN</h4>
												<div class="form-group">
													<div class="col-sm-3 control-label">Poli/Ruang Asal</div>
													<div class="col-sm-9" align="left">
														<span class="label-form-validation"></span>
														<div class="col-sm-4 input-left"><input type="text" class="form-control input-sm" name="id_poli" id="id_poli" readonly></div>
														<div class="col-sm-8 input-right"><input type="text" class="form-control input-sm" name="poliasal" id="poliasal" readonly></div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Dokter</div>
													<div class="col-sm-9" align="left">
														<span class="label-form-validation"></span>
														<div class="col-sm-4 input-left"><input type="text" class="form-control input-sm" name="id_dokter" id="id_dokter" readonly></div>
														<div class="col-sm-8 input-right"><input type="text" class="form-control input-sm" name="dokter" id="dokter" readonly></div>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Diagnosa</div>
													<div class="col-sm-9">
														<span class="label-form-validation"></span>
														<input type="text" class="form-control input-sm" name="diagnosa" id="diagnosa" readonly>
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
														<input type="text" class="form-control input-sm" id="calendar-tgl-rencana-masuk" name="tglrencanamasuk">
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Tgl. SP. Rawat *</div>
													<div class="col-sm-9">
														<span class="label-form-validation"></span>
														<input type="text" class="form-control input-sm" id="calendar-tgl-sp-rawat" name="tglsprawat">
													</div>
												</div>
												<div class="form-group">
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
														<div class="col-sm-8 input-left"><input type="text" class="form-control input-sm" id="nm_ruang" name="nm_ruang" readonly></div>
														<div class="col-sm-4 input-right"><input type="text" class="form-control input-sm" id="kelas" name="kelas" readonly></div>
													</div>
												</div>
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
														<input type="text" class="form-control input-sm" name="keterangan" id="keterangan">
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
								
							</div>
							<div class="tab-pane" id="approve">
								<div class="row">
									<div class="col-sm-8">
								
										<!-- Rencana Masuk -->
										<div class="form-horizontal">
											<div class="box-body">
												<div class="form-group">
													<div class="col-sm-3 control-label">Tgl. Approve</div>
													<div class="col-sm-9">
														<input type="text" class="form-control input-sm" name="tgl_approve" readonly>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Jam Approve</div>
													<div class="col-sm-9">
														<input type="text" class="form-control input-sm" name="jam_approve" readonly>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Bed</div>
													<div class="col-sm-9">
														<input type="text" class="form-control input-sm" name="bed_approve" readonly>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Kelas</div>
													<div class="col-sm-9">
														<input type="text" class="form-control input-sm" name="kelas_approve" readonly>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">Ruang</div>
													<div class="col-sm-9">
														<input type="text" class="form-control input-sm" name="ruang_approve" readonly>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">User Approve</div>
													<div class="col-sm-9">
														<input type="text" class="form-control input-sm" name="user_approve" readonly>
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-3 control-label">No. Register</div>
													<div class="col-sm-9">
														<input type="text" class="form-control input-sm" name="no_register" readonly>
													</div>
												</div>
											</div>
											
										</div>
										<!-- /Belum Approve -->
									
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Tabs -->
					
				</div>
			</div>
		</section>
		<!-- /Main content -->
		
	</div>
</div>
<script>
	$('#calendar-tgl-lahir').datepicker({
		format: 'yyyy-mm-dd'
	});
	$('#calendar-tgl-sp-rawat').datepicker({
		format: 'yyyy-mm-dd'
	});
	$('#calendar-tgl-rencana-masuk').datepicker({
		format: 'yyyy-mm-dd'
	});
</script>
