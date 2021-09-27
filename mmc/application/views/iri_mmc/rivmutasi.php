<div class="wrapper">
	<div class="content-wrapper">
		
		<!-- Keterangan page -->
		<section class="content-header">
			<h1>MUTASI RUANGAN</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-home"></i> Home</a></li>
				<li><a href="#">Mutasi</a></li>
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
						
						<!-- Form Mutasi -->
						<form class="form-horizontal" action="<?php echo site_url('iri/ricmutasi/insert_mutasi'); ?>">
							<div class="box-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="box-body">
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
												<div class="col-sm-3 control-label">No. Peserta</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6 form-right">
										<div class="box-body">
											<div class="form-group">
												<div class="col-sm-3 control-label">Ruang</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Kelas</div>
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
												<div class="col-sm-3 control-label">Tanggal</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" id="calendar-tgl">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Jatah Kelas</div>
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
						<!-- /Form Mutasi -->
						
					</div>
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
