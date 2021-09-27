<script>
$(function(){
<?php if($pasien[0]['sex']=='L'){ ?>
	$('#laki_laki').attr('selected', 'selected');
	$('#perempuan').removeAttr('selected', 'selected');
<?php }else{ ?>
	$('#laki_laki').removeAttr('selected', 'selected');
	$('#perempuan').attr('selected', 'selected');
<?php } ?>
});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_ruang').autocomplete({
		serviceUrl: site+'/iri/ricpendaftaran/data_ruang',
		onSelect: function (suggestion) {
			$('#ruang').val(''+suggestion.idrg);
			$('#nm_ruang').val(''+suggestion.nmruang);
			$('#kelas').val(''+suggestion.kelas);
		}
	});
});
</script>
<div class="wrapper">
	<div class="content-wrapper">
		
		<!-- Keterangan page -->
		<section class="content-header">
			<h1>PENDAFTARAN RAWAT INAP</h1>			
		</section>
		<!-- /Keterangan page -->

        <!-- Main content -->
        <section class="content">
			<div class="row">
				<div class="col-sm-12">
					<?php echo $this->session->flashdata('pesan');?>
					<div class="box box-success">
						<br/>
						
						<!-- Form Pendaftaran -->
						<form class="form-horizontal" action="<?php echo site_url('iri/ricpendaftaran/insert_pendaftaran'); ?>" method="post">
							<div class="box-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="box-body">
											<div class="form-group">
												<div class="col-sm-3 control-label">No. Reg. IRJ/IRD</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="noregasal" value="<?php echo $irna_reservasi[0]['no_register_asal']; ?>" readonly>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">No. CM</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="no_cm" value="<?php echo $irna_reservasi[0]['no_cm']; ?>" readonly>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Tgl. Daftar</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="tgldaftarri" value="<?php echo $irna_reservasi[0]['tglreserv']; ?>" readonly>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Cara Bayar</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="carabayar">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">SMF</div>
												<div class="col-sm-9" align="left">
													<div class="col-sm-3 input-left"><input type="text" class="form-control input-sm" name="id_smf"></div>
													<div class="col-sm-9 input-right"><input type="text" class="form-control input-sm" name="nmsmf"></div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Cara Masuk</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="caramasuk">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Dokter</div>
												<div class="col-sm-9" align="left">
													<div class="col-sm-4 input-left"><input type="text" class="form-control input-sm" name="id_dokter" value="<?php echo $irna_reservasi[0]['id_dokter']; ?>" readonly></div>
													<div class="col-sm-8 input-right"><input type="text" class="form-control input-sm" name="nmdokter" value="<?php echo $irna_reservasi[0]['dokter']; ?>" readonly></div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6 form-right">
										<div class="box-body">
											<div class="form-group">
												<div class="col-sm-3 control-label">No. Reg. Lama</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="noipdlama" value="<?php echo $irna_reservasi[0]['noreservasi']; ?>" readonly>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Nama</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" disabled="true" name="nama" value="<?php echo $pasien[0]['nama']; ?>" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Tgl. Lahir</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" id="calendar-tgl-lahir" name="tgllahirri" value="<?php echo $pasien[0]['tgl_lahir']; ?>" disabled="true">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Jenis Kelamin <?php echo $pasien[0]['sex']; ?></div>
												<div class="col-sm-4">
													<select class="form-control input-sm" name="sex" disabled="true">
														<option id="laki_laki" value="L">Laki-Laki</option>
														<option id="perempuan" value="P">Perempuan</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Gol. Darah</div>
												<div class="col-sm-4">
													<select class="form-control input-sm" name="goldarah">
														<option value="A">A</option>
														<option value="B">B</option>
														<option value="O">O</option>
														<option value="AB">AB</option>
													</select>
												</div>
												<div class="col-sm-5">
													<input type="checkbox" value="Y" name="barulahir"> Bayi Baru Lahir
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">No. Register Ibu</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="noipdibu">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Tabs -->
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#biodata" data-toggle="tab">Biodata</a></li>
									<li class=""><a href="#penanggung-jawab" data-toggle="tab">Penanggung Jawab</a></li>
									<li class=""><a href="#ruangan" data-toggle="tab">Ruangan</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="biodata">
										<div class="row">
											<div class="col-sm-6 form-left">
												<div class="box-body">
													<div class="form-group">
														<div class="col-sm-3 control-label">Alamat</div>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="alamatri">
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Kelurahan</div>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="kelurahanri">
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Kecamatan</div>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="kecamatanri">
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">RT/RW</div>
														<div class="col-sm-9" align="left">
															<div class="col-sm-3 input-left"><input type="text" class="form-control input-sm" name="rtri"></div>
															<div class="col-sm-3 input-right"><input type="text" class="form-control input-sm" name="rwri"></div>
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Daerah</div>
														<div class="col-sm-9" align="left">
															<div class="col-sm-3 input-left"><input type="text" class="form-control input-sm" name="id_daerah"></div>
															<div class="col-sm-9 input-right"><input type="text" class="form-control input-sm" name="nmdaerah"></div>
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">No. Telp</div>
														<div class="col-sm-3">
															<input type="text" class="form-control input-sm" name="notelp">
														</div>
														<div class="col-sm-2 control-label">No. HP</div>
														<div class="col-sm-3">
															<input type="text" class="form-control input-sm" name="nohp">
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Status</div>
														<div class="col-sm-3">
															<input type="text" class="form-control input-sm" name="statusri">
														</div>
														<div class="col-sm-2 control-label">Agama</div>
														<div class="col-sm-4">
															<input type="text" class="form-control input-sm" name="agamari">
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="box-body">
													<div class="form-group">
														<div class="col-sm-3 control-label">Pendidikan</div>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="pendidikanri">
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Pekerjaan</div>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="pekerjaanri">
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Warga Negara</div>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="wnegarari">
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Suku Bangsa</div>
														<div class="col-sm-9" align="left">
															<input type="text" class="form-control input-sm" name="sukubangsari">
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Bahasa</div>
														<div class="col-sm-9" align="left">
															<input type="text" class="form-control input-sm" name="bahasari">
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Nama Ibu/Istri</div>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="nm_ibu_istri">
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Nama Ayah/Suami</div>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="nm_ayah_suami">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="penanggung-jawab">
										<div class="row">
											<div class="col-sm-6">
												<div class="box box-success">
													<div class="box-header with-border">
														<h3 class="box-title">Penjamin</h3>
													</div>
													<div class="box-body">
														<div class="form-group">
															<div class="col-sm-3 control-label">No.SJP / No.Surat</div>
															<div class="col-sm-9" align="left">
																<input type="text" class="form-control input-sm" name="nosjp">
															</div>
														</div>
														<div class="form-group">
															<div class="col-sm-3 control-label">No.Askes / No.Peserta</div>
															<div class="col-sm-9" align="left">
																<input type="text" class="form-control input-sm" name="nopembayranri">
															</div>
														</div>
														<div class="form-group">
															<div class="col-sm-3 control-label">Perusahaan</div>
															<div class="col-sm-9" align="left">
																<div class="col-sm-3 input-left"><input type="text" class="form-control input-sm" name="id_kontraktor"></div>
																<div class="col-sm-9 input-right"><input type="text" class="form-control input-sm" name="nmkontraktor"></div>
															</div>
														</div>
														<div class="form-group">
															<div class="col-sm-3 control-label">P/I/S/A</div>
															<div class="col-sm-9" align="left">
																<select class="form-control input-sm" name="ketpembayarri">
																	<option value="Pembayaran">Pembayaran</option>
																</select>
															</div>
														</div>
														<div class="form-group">
															<div class="col-sm-3 control-label">Nama Peserta</div>
															<div class="col-sm-9" align="left">
																<input type="text" class="form-control input-sm" name="nmpembayarri">
															</div>
														</div>
														<div class="form-group">
															<div class="col-sm-3 control-label">Golongan</div>
															<div class="col-sm-9" align="left">
																<input type="text" class="form-control input-sm" name="golpembayarri">
															</div>
														</div>
														<div class="form-group">
															<div class="col-sm-3 control-label">Jatah Kelas</div>
															<div class="col-sm-9" align="left">
																<input type="text" class="form-control input-sm" name="jatahkls">
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="box box-success">
													<div class="box-header with-border">
														<h3 class="box-title">Keluarga</h3>
													</div>
													<div class="box-body">
														<div class="form-group">
															<div class="col-sm-3 control-label">Nama</div>
															<div class="col-sm-9" align="left">
																<input type="text" class="form-control input-sm" name="nmpjawabri">
															</div>
														</div>
														<div class="form-group">
															<div class="col-sm-3 control-label">Alamat</div>
															<div class="col-sm-9" align="left">
																<input type="text" class="form-control input-sm" name="alamatpjawabri">
															</div>
														</div>
														<div class="form-group">
															<div class="col-sm-3 control-label">No.Telp / HP</div>
															<div class="col-sm-9" align="left">
																<input type="text" class="form-control input-sm" name="notlppjawab">
															</div>
														</div>
														<div class="form-group">
															<div class="col-sm-3 control-label">Kartu Identitas</div>
															<div class="col-sm-9" align="left">
																<div class="col-sm-4 input-left">
																	<select class="form-control input-sm" name="kartuidp">
																		<option value="kartuidp">Kartu IDP</option>
																	</select>
																</div>
																<div class="col-sm-8 input-right"><input type="text" class="form-control input-sm" name="noidpjawab"></div>
															</div>
														</div>
														<div class="form-group">
															<div class="col-sm-3 control-label">Hub.Keluarga</div>
															<div class="col-sm-3" align="left">
																<select class="form-control input-sm" name="hubjawabri">
																	<option value="hubjawabri">Hubjawabri</option>
																</select>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="ruangan">
										<div class="row">
											<div class="col-sm-6">
												<div class="box-body">
													<div class="form-group">
														<div class="col-sm-3 control-label">Bed</div>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="bed">
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Ruang</div>
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
														<div class="col-sm-3 control-label">Tgl. Masuk</div>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" id="calendar-tgl-masuk" name="tglmasukrg">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /Tabs -->
							
							<!-- Button -->
							<div class="row">
								<div class="col-sm-8">
									<div class="button-pendaftaran">
										<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
									</div>							
								</div>
							</div>
							<!-- /Button -->
							
							<!-- Modal -->
							<div class="modal fade bs-example-modal-sm" id="modal-pendaftaran" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
						<!-- /Form Pendaftaran -->
						
					</div>
					
				</div>
			</div>
		</section>
		<!-- /Main content -->
		
	</div>
</div>
<script>
	$('#calendar-tgl-daftar').datepicker({
		format: 'yyyy-mm-dd'
	});
	$('#calendar-tgl-lahir').datepicker({
		format: 'yyyy-mm-dd'
	});
	$('#calendar-tgl-masuk').datepicker({
		format: 'yyyy-mm-dd'
	});
</script>
