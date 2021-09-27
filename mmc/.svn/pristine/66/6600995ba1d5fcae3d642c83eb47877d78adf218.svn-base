<?php $this->load->view("layout/header"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
<div >
	<div >
		
		<!-- Keterangan page -->
		<section class="content-header">
			<h1>STATUS PASIEN DI RUANGAN</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-home"></i> Home</a></li>
				<li><a href="#">Status</a></li>
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
							
						<div class="panel panel-info">
					<div class="panel-heading" align="center" style="background-color:#00C0C5;color:#ffffff"><h4>RESERVASI ANTRIAN PASIEN RAWAT INAP</h4></div>
					<!-- Form Status -->
						<form class="form-horizontal" action="<?php echo site_url('iri/ricstatus/insert_status'); ?>">
							<div class="box-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="box-body">
											<div class="form-group">
												<div class="col-sm-3 control-label">Cari No. IPD</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">No. Register IPD</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">No. CM</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Penjamin</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Jatah Kelas</div>
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
										</div>
									</div>
									<div class="col-sm-6 form-right">
										<div class="box-body">
											<div class="form-group">
												<div class="col-sm-3 control-label">SMF</div>
												<div class="col-sm-9">
													<div class="col-sm-3 input-left"><input type="text" class="form-control input-sm"></div>
													<div class="col-sm-9 input-right"><input type="text" class="form-control input-sm"></div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Dr. Yang Merawat</div>
												<div class="col-sm-9">
													<div class="col-sm-3 input-left"><input type="text" class="form-control input-sm"></div>
													<div class="col-sm-9 input-right"><input type="text" class="form-control input-sm"></div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Anamnesa</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Tanggal</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" id="calendar-tgl">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Jenis Kelamin</div>
												<div class="col-sm-4">
													<select class="form-control input-sm">
														<option>Laki-Laki</option>
														<option>Perempuan</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Gol. Darah</div>
												<div class="col-sm-4">
													<select class="form-control input-sm">
														<option>A</option>
														<option>B</option>
														<option>O</option>
														<option>AB</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">No IPD Ibu</div>
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
											<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-mutasi"><i class="fa fa-save"></i> Simpan</button>
										</div>						
									</div>
								</div>
								
								<!-- Modal -->
								<div class="modal fade bs-example-modal-sm" id="modal-mutasi" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
								
							</div>
						</form>
						<!-- /Form Status -->
					<!--- end panel body -->
				</div>
						
						
						
					</div>
					
					<!-- Tabs -->
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li class=""><a href="#ruang-rawat" data-toggle="tab">Ruang Rawat</a></li>
							<li class="active"><a href="#dokter-rawat-bersama" data-toggle="tab">Dokter Rawat Bersama</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane" id="ruang-rawat">
							
							</div>
							<div class="tab-pane active" id="dokter-rawat-bersama">
								
								<!-- Table -->
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Rendering engine</th>
											<th>Browser</th>
											<th>Platform(s)</th>
											<th>Engine version</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>Trident</td>
											<td>Internet Explorer 4.0</td>
											<td>Win 95+</td>
											<td>4</td>
											<td><button type="button" class="btn btn-primary btn-sm">Faktur</button></td>
										</tr>
										<tr>
											<td>Trident</td>
											<td>Internet Explorer 5.0</td>
											<td>Win 95+</td>
											<td>5</td>
											<td><button type="button" class="btn btn-primary btn-sm">Faktur</button></td>
										</tr>
										<tr>
											<td>Trident</td>
											<td>Internet Explorer 5.5</td>
											<td>Win 95+</td>
											<td>5.5</td>
											<td><button type="button" class="btn btn-primary btn-sm">Faktur</button></td>
										</tr>
										<tr>
											<td>Trident</td>
											<td>Internet Explorer 6</td>
											<td>Win 98+</td>
											<td>6</td>
											<td><button type="button" class="btn btn-primary btn-sm">Faktur</button></td>
										</tr>
										<tr>
											<td>Trident</td>
											<td>Internet Explorer 7</td>
											<td>Win XP SP2+</td>
											<td>7</td>
											<td><button type="button" class="btn btn-primary btn-sm">Faktur</button></td>
										</tr>
										<tr>
											<td>Trident</td>
											<td>AOL browser (AOL desktop)</td>
											<td>Win XP</td>
											<td>6</td>
											<td><button type="button" class="btn btn-primary btn-sm">Faktur</button></td>
										</tr>
										<tr>
											<td>Gecko</td>
											<td>Firefox 1.0</td>
											<td>Win 98+ / OSX.2+</td>
											<td>1.7</td>
											<td><button type="button" class="btn btn-primary btn-sm">Faktur</button></td>
										</tr>
										<tr>
											<td>Gecko</td>
											<td>Firefox 1.5</td>
											<td>Win 98+ / OSX.2+</td>
											<td>1.8</td>
											<td><button type="button" class="btn btn-primary btn-sm">Faktur</button></td>
										</tr>
										<tr>
											<td>Gecko</td>
											<td>Firefox 2.0</td>
											<td>Win 98+ / OSX.2+</td>
											<td>1.8</td>
											<td><button type="button" class="btn btn-primary btn-sm">Faktur</button></td>
										</tr>
										<tr>
											<td>Gecko</td>
											<td>Firefox 3.0</td>
											<td>Win 2k+ / OSX.3+</td>
											<td>1.9</td>
											<td><button type="button" class="btn btn-primary btn-sm">Faktur</button></td>
										</tr>
										<tr>
											<td>Gecko</td>
											<td>Camino 1.0</td>
											<td>OSX.2+</td>
											<td>1.8</td>
											<td><button type="button" class="btn btn-primary btn-sm">Faktur</button></td>
										</tr>
										<tr>
											<td>Gecko</td>
											<td>Camino 1.5</td>
											<td>OSX.3+</td>
											<td>1.8</td>
											<td><button type="button" class="btn btn-primary btn-sm">Faktur</button></td>
										</tr>
										<tr>
											<td>Gecko</td>
											<td>Netscape 7.2</td>
											<td>Win 95+ / Mac OS 8.6-9.2</td>
											<td>1.7</td>
											<td><button type="button" class="btn btn-primary btn-sm">Faktur</button></td>
										</tr>
										<tr>
											<td>Gecko</td>
											<td>Netscape Browser 8</td>
											<td>Win 98SE+</td>
											<td>1.7</td>
											<td><button type="button" class="btn btn-primary btn-sm">Faktur</button></td>
										</tr>
									</tbody>
								</table>
								<!-- /Table -->
								
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
	$(function () {
		$("#example1").DataTable();
	});
	$('#calendar-tgl').datepicker();
</script>

<?php $this->load->view("iri/layout/footer"); ?>
