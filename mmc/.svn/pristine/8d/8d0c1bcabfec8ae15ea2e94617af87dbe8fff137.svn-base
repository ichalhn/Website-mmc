<?php $this->load->view("layout/header"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
<script>
	
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

function get_bed(val){
	$('#bed')
        .find('option')
        .remove()
        .end()
    ;
    $("#bed").append("<option value=''>Loading...</option>");
	$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>iri/ricmutasi/get_empty_bed_select/",
        data:   {
                    val        : val
                },
    }).done(function(msg) {
    	$('#bed')
            .find('option')
            .remove()
            .end()
        ;
        $("#bed").append(msg);
    });
}

</script>

        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1><?php //echo $title; ?></h1>          
        </section>
	<section class="content-header">
	<?php
		if(isset($message) && $message !=''){
	?>
		<div class="row">
			<div class="col-md-12">
			  <div class="box box-info box-solid">
				<div class="box-header with-border">
				  <h3 class="box-content">Registrasi Berhasil</h3>
				  <div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				  </div>
				</div>				
			  </div>
			</div>
		</div>
	<?php
		}
	?>
				
	</section>

	<section class="content">
		<div class="row">			
			<div class="col-md-12">
				<?php echo $this->session->flashdata('pesan');?>
				<div class="panel panel-info">
					<div class="panel-heading" align="center" ><h4>MUTASI RUANGAN</h4></div>
					<!-- Form Mutasi -->
						<form class="form-horizontal" action="<?php echo site_url('iri/ricmutasi/insert_mutasi'); ?>" method="post">
							<input type="hidden" name="no_reservasi" value="<?php echo $this->uri->segment(4);?>">
							<div class="box-body">
								<div class="row">
									<div class="col-sm-6">
										<div class="box-body">
											<div class="form-group">
												<div class="col-sm-3 control-label">No. Register IPD LAMA</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="no_ipd" id="no_ipd" value="<?php echo $pasien_lama[0]['no_ipd'] ;?>">
													<input type="hidden" name="no_reservasi" id="no_reservasi" value="<?php echo $data_pasien[0]['noreservasi'] ;?>">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">No. CM</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="no_cm" id="no_cm" value="<?php echo $pasien_lama[0]['no_cm'] ;?>">
													<input type="hidden" name="no_medrec" id="no_medrec" value="<?php echo $pasien_lama[0]['no_medrec'] ;?>">
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
												<div class="col-sm-3 control-label">Ruang Lama</div>
												<div class="col-sm-4">
													<input type="text" class="form-control input-sm" name="nmruang_old" id="nmruang_old" value="<?php echo $pasien_lama[0]['nmruang'] ;?>">
												</div>
												<div class="col-sm-4">
													<input type="text" class="form-control input-sm" name="idrg_old" id="idrg_old" value="<?php echo $pasien_lama[0]['idrg'] ;?>">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Kelas & Bed Lama</div>
												<div class="col-sm-4">
													<input type="text" class="form-control input-sm" name="kelas_old" id="kelas_old" value="<?php echo $pasien_lama[0]['kelas'] ;?>">
												</div>
												<div class="col-sm-4">
													<input type="text" class="form-control input-sm" name="bed_old" id="bed_old" value="<?php echo $pasien_lama[0]['bed'] ;?>">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Nama</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="nama" id="nama" value="<?php echo $pasien_lama[0]['nama'] ;?>">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Alamat</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="alamat" id="alamat" value="<?php echo $pasien_lama[0]['alamat'] ;?>">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Tanggal Reservasi</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" id="calendar-tgl" name="tgldaftarri" id="tgldaftarri" value="<?php echo $data_pasien[0]['tglrencanamasuk'] ;?>">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Ruang Pilih *</div>
												<div class="col-sm-9">
													<span class="label-form-validation"></span>
													<select class="form-control input-sm" id="ruang" name="ruang" onchange="get_bed(this.value)" required>
														<option value="" selected="">Pilih Ruangan</option>
														<?php
														if(empty($kelas)){ ?>
														<option value="" selected="true">Semua Kelas Penuh</option>
														<?php
														}else{
															foreach ($kelas as $r) { 
																if($data_pasien[0]['kelas'] == $r['kelas'] && $data_pasien[0]['idrg'] == $r['idrg']){ ?>
														<option value="<?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?>" selected="true"><?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?></option>
															<?php
															}else{ ?>
															<option value="<?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?>"><?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?></option>
															<?php
															}
															}
														?>
														<?php
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Bed</div>
												<div class="col-sm-9">
													<select class="form-control input-sm" id="bed" name="bed" required>
														<?php
														foreach ($bed_by_idrg_kelas as $r) { ?>
														<option value="<?php echo $r['bed'] ;?>"><?php echo $r['bed'];?></option>
														<?php	
														}
														?>
													</select>
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
					<!--- end panel body -->
				</div>
				<!--- end panel -->
			</div>
		<!--- end col -->
			
		</div><!--- end row -->
	</section>

	<script>
	$('#calendar-tgl').datepicker();
</script>
<?php $this->load->view("layout/footer"); ?>
