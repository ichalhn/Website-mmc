<div class="wrapper">
	<div class="content-wrapper">
		
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
						<form class="form-horizontal" action="<?php echo site_url('iri/ricresume'); ?>">
							<div class="box-body">
								<div class="row">
									<div class="col-sm-6 form-left">
										<div class="box-body">
											<div class="form-group">
												<div class="col-sm-3 control-label">No. Register</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">No. Reka Medis</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Nama</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Alamat</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Tgl. Lahir</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" id="calendar-tgl-lahir">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Tgl. Masuk</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" id="calendar-tgl-masuk">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Tgl. Meninggal</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" id="calendar-tgl-meninggal">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">SMF</div>
												<div class="col-sm-9">
													<div class="col-sm-3 input-left"><input type="text" class="form-control input-sm"></div>
													<div class="col-sm-9 input-right"><input type="text" class="form-control input-sm"></div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Ruang</div>
												<div class="col-sm-9">
													<div class="col-sm-3 input-left"><input type="text" class="form-control input-sm"></div>
													<div class="col-sm-9 input-right"><input type="text" class="form-control input-sm"></div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Kelas</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Dr. Pengirim</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Dr. Yang Merawat</div>
												<div class="col-sm-9">
													<div class="col-sm-3 input-left"><input type="text" class="form-control input-sm"></div>
													<div class="col-sm-9 input-right"><input type="text" class="form-control input-sm"></div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="box-body">
											<div class="form-group">
												<div class="col-sm-3 control-label">Dr. Konsulen</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Anamnesa</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Pemeriksaan Fisik</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Diagnosa Akhir</div>
												<div class="col-sm-9">
													<div class="col-sm-3 input-left"><input type="text" class="form-control input-sm"></div>
													<div class="col-sm-9 input-right"><input type="text" class="form-control input-sm"></div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Pengobatan/ Tindakan</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Prognosis</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Pengobatan Lanjutan</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Anjuran</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Cara Masuk</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Keadaan Pulang</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-8">
										<div class="button-reservasi">
											<button type="button" class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Cetak Resume Medik</button>
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
</script>
