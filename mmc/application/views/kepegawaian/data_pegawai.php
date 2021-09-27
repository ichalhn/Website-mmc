<?php
	$this->load->view('layout/header.php');
?>
<section class="content-header">		
	<div class="small-box" style="background: #e4efe0">
		<div class="inner">
			<div class="container-fluid text-center"><br/>
				<div class="form-inline">
					<select name="search_per" id="search_per" class="form-control">
						<option value="cari_nama">Nama</option>
						<option value="cari_nip">NIP</option>
					</select>					
					<input type="search" class="form-control" id="cari_nama" name="cari_nama" placeholder="Pencarian Nama">
					<input type="hidden" class="form-control" id="vnip" name="vnip">
					<input type="search" style="width:450; display:none" class="form-control" id="cari_nip" name="cari_nip" placeholder="Pencarian NIP">					
					<button type="submit" class="btn btn-primary" type="button" onClick="searchPegawai()">Tampilkan</button>					
					<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> &nbsp;Data Pegawai Baru</i> </button>
						
				</div>		
			</div>
		</div>
	</div>
</section>
<section class="content">
	<div class="row">
		<div class="col-md-12" id="alertMsg">	
			<?php echo $this->session->flashdata('alert_msg'); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">			
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="pegawai-image">
						<img src="<?php echo site_url('upload/pegawai/NoImage.jpg'); ?>" id="fotoNip"> 
						<a class="change-image" href="#" >&nbsp;<i class="fa fa-camera"> &nbsp;Upload New Photo</i></a>
						<form id="addPhotoForm" class="photoForm" method="POST" enctype="multipart/form-data"><input type="file" name="userfile" id="userfile" accept="image/jpeg, image/png, image/gif"/><input type="hidden" id="pnip" name="pnip"></form>
					</div>	
					<form class="form-horizontal" method="POST" action="<?php echo site_url('kepegawaian/Data_pegawai/update');?>">
						<div class="row">
							<div class="col-md-4">	
								<div class="form-group">
									<label class="control-label col-sm-3">NIP</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="nip" id="nip">
									</div>
								</div>
							</div>
							<div class="col-md-2">	
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" name="gelar_dpn" id="gelar_dpn" placeholder="Gelar Depan">
									</div>
								</div>
							</div>
							<div class="col-md-2">	
								<div class="form-group">
									<div class="col-sm-12">
										<input type="text" class="form-control" name="gelar_bkl" id="gelar_bkl" placeholder="Gelar Belakang">
									</div>
								</div>
							</div>
							<div class="col-md-2">	
								<div class="form-group">
									<div class="checkbox">
							<input type="hidden" name="duk" value="0" />
									<label><input type="checkbox" name="duk" id="duk" value="1">DUK</label>
									</div>
								</div>
							</div>
							<div class="col-md-2">	
								<button type="submit" class="btn btn-info pull-right" id="btnUpdate"><i class="fa fa-floppy-o"> Update</i> </button>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">	
								<div class="form-group">
									<label class="control-label col-sm-3">Nama</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="nm_pegawai" id="nm_pegawai">
									</div>
								</div>
							</div>
							<div class="col-md-2">	
								<div class="form-group">
									<label class="col-sm-3 control-label">Aktif</label>
									<div class="col-sm-9">
										<label class="radio-inline"> <input type="radio" name="aktif" id="aktifY" value="Y" checked> Ya </label>
										<label class="radio-inline"> <input type="radio" name="aktif" id="aktifN" value="N"> Tidak </label>
									</div>
								</div>
							</div>
							<div class="col-md-4">	
								<div class="form-group">
									<label class="col-sm-4 control-label">Fulltime</label>
									<div class="col-sm-8">
										<label class="radio-inline"> <input type="radio" name="fulltime" id="fulltimeY" value="Y" checked> Ya </label>
										<label class="radio-inline"> <input type="radio" name="fulltime" id="fulltimeN" value="N"> Tidak </label>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">	
								<div class="form-group">
									<label class="control-label col-sm-3">No. SK</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="sk_masuk" id="sk_masuk" placeholder="No. SK Masuk">
									</div>
								</div>
							</div>
							<div class="col-md-8">	
								<div class="form-group">
									<label class="control-label col-sm-1">Tgl</label>
									<div class="col-sm-3">
										<div class="input-group">
											<input type="text" class="form-control datepicker" name="tgl_masuk" id="tgl_masuk">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">	
								<div class="form-group">
									<label class="control-label col-sm-3">Bagian</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="nm_bagian" id="nm_bagian">
										<input type="hidden" class="form-control" id="id_bagian" name="id_bagian">
									</div>
								</div>
							</div>
							<div class="col-md-8">	
								<div class="form-group">
									<label class="control-label col-sm-1">per</label>
									<div class="col-sm-3">
										<div class="input-group">
											<input type="text" class="form-control datepicker" name="tmt" id="tmt">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">	
								<div class="form-group">
									<label class="control-label col-sm-3">Jabatan</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="nm_jabatan" id="nm_jabatan">
										<input type="hidden" class="form-control" name="id_jabatan" id="id_jabatan">
									</div>
								</div>
							</div>
							<div class="col-md-8">	
								<div class="form-group">
									<label class="control-label col-sm-1">per</label>
									<div class="col-sm-3">
										<div class="input-group">
											<input type="text" class="form-control datepicker" name="tmt_jabatan" id="tmt_jabatan">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">	
								<div class="form-group">
									<label class="control-label col-sm-3">Golongan</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="nm_golongan" id="nm_golongan">
										<input type="hidden" class="form-control" name="id_golongan" id="id_golongan">
									</div>
								</div>
							</div>
							<div class="col-md-8">	
								<div class="form-group">
									<label class="control-label col-sm-1">per</label>
									<div class="col-sm-3">
										<div class="input-group">
											<input type="text" class="form-control datepicker" name="tmt_golongan" id="tmt_golongan">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
									<label class="col-sm-2 control-label">Gol.Puncak</label>
									<div class="col-sm-4">
										<label class="radio-inline"> <input type="radio" name="gol_puncak" id="golPuncakY" value="Y" checked> Ya </label>
										<label class="radio-inline"> <input type="radio" name="gol_puncak" id="golPuncakN" value="T"> Tidak </label>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">	
								<div class="form-group">
									<label class="control-label col-sm-3">Kualifikasi</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="nm_qualifikasi" id="nm_qualifikasi">
										<input type="hidden" class="form-control" name="id_qualifikasi" id="id_qualifikasi">
									</div>
								</div>
							</div>
							<div class="col-md-6">	
								<div class="form-group">
									<div class="col-sm-6">
										<input type="text" class="form-control" name="nm_sub_qua" id="nm_sub_qua" placeholder="Sub Kualifikasi">
										<input type="hidden" class="form-control" name="id_sub_qua" id="id_sub_qua" placeholder="Sub Kualifikasi">
									</div>
									<label class="col-sm-1 control-label">Ahli</label>
									<div class="col-sm-4">
										<label class="radio-inline"> <input type="radio" name="ahli" id="ahliY" value="A" checked> Ya </label>
										<label class="radio-inline"> <input type="radio" name="ahli" id="ahliN" value="T"> Tidak </label>
									</div>
								</div>
							</div>
						</div><!-- end row -->
						<div class="row">
							<div class="col-md-4">	
								<div class="form-group">
									<label class="control-label col-sm-3">Jenis</label>
									<div class="col-sm-9">
										<?php echo form_dropdown(
											array(
												'name'=>'id_jenis',
												'id'=>'id_jenis',
												'class'=>'form-control'), 
											$jenis, 
											"0"); ?>
									</div>
								</div>
							</div>
							<div class="col-md-4">	
								<div class="form-group">
									<label class="control-label col-sm-3">Penggaji</label>
									<div class="col-sm-9">
										<input type="text" class="form-control" name="penggaji_2" id="penggaji_2">
									</div>
								</div>
							</div>
						</div><!-- end row -->
					</form>
				</div><!-- end panel body -->
			</div><!-- end panel info-->				 
		</div><!-- end tab content -->			
	</div><!--- end row --->
	<div class="row">
		<div class="col-md-12">
		  <!-- Custom Tabs -->
		  <div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
			  <li class="active"><a href="#tab_1" data-toggle="tab">Biodata</a></li>
			  <li><a href="#tab_2" data-toggle="tab">Data Keluarga</a></li>
			  <li><a href="#tab_4" data-toggle="tab">KGB</a></li>
			  <li><a href="#tab_3" data-toggle="tab">Riwayat Pendidikan</a></li>
			  <li><a href="#tab_5" data-toggle="tab">Riwayat Jabatan</a></li>
			  <li><a href="#tab_6" data-toggle="tab">Riwayat Mutasi</a></li>
			</ul>
			<div class="tab-content">
			  <div class="tab-pane active" id="tab_1">
			  	<form class="form-horizontal" method="POST" action="<?php echo site_url('kepegawaian/Data_pegawai/update_bio');?>">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-3">Tempat Lahir</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="tpt_lahir" id="tpt_lahir">
								<input type="hidden" name="nip2" id="nip2">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-3">Thn Cuti Besar</label>
							<div class="col-sm-3">
								<input type="text" class="form-control datepicker" name="thncutibesar" id="thncutibesar">
							</div>
						</div>
					</div>
				</div>			
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-3">Tanggal Lahir</label>
							<div class="col-sm-6">
								<div class="input-group">
									<input type="text" class="form-control datepicker" name="tgl_lahir" id="tgl_lahir">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-3">No. Karpeg</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="no_karpeg" id="no_karpeg">
							</div>
						</div>
					</div>
				</div>	
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-3">Gender</label>
							<div class="col-sm-6">
								<label class="radio-inline"> <input type="radio" name="sex" id="sexL" value="L" checked> Laki-laki </label>
								<label class="radio-inline"> <input type="radio" name="sex" id="sexP" value="P"> Perempuan </label>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-3">No. Taspen</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="no_taspen" id="no_taspen">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-3">Agama</label>
							<div class="col-sm-6">
							  <select  class="form-control" style="width: 100%" name="agama" id="agama">
								<option value="">-Pilih Agama-</option>
								<option value="Islam">Islam</option>
								<option value="Katholik">Katholik</option>
								<option value="Protestan">Protestan</option>
								<option value="Hindu">Hindu</option>
								<option value="Budha">Budha</option>
							  </select>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-3">Alamat</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="alamat" id="alamat">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-3">Nomor HP</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="no_hp" id="no_hp">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-3">Propinsi</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="prop" id="prop">
							</div>
						</div>
					</div>
				</div>		
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-3">Status</label>
							<div class="col-sm-6">
							  <select  class="form-control" style="width: 100%" name="status" id="status">
								<option value="">-Pilih Status-</option>
								<option value="Kawin">Kawin</option>
								<option value="TKawin">Tidak Kawin</option>
								<option value="Janda">Janda</option>
								<option value="Duda">Duda</option>
							  </select>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-3">Kota/Kab</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="kota" id="kota">
							</div>
						</div>
					</div>
				</div>						
				<div class="row">
					<div class="col-md-6">
						<button type="submit" class="btn btn-info pull-right" id="btnUpdate2"><i class="fa fa-floppy-o"> Update</i> </button>
					</div>
				</div>	
				</form>
			  </div><!-- /.tab-pane -->
			  <div class="tab-pane" id="tab_2">				
				<button type="button" id="addSpouseBtn" class="btn btn-primary" data-toggle="modal" data-target="#addSpouseModal"><i class="fa fa-plus"></i>Tambah Data Pasangan</button><br/><br/>
				<table id="dtKel" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>NIP</th>
							<th>Nama Pasangan</th>
							<th>Status</th>
							<th>Tgl Lahir</th>
							<th>Gender</th>
							<th>Tgl Nikah</th>
							<th>Pekerjaan</th>
							<th>Dpt Tunjangan</th>
							<th>Aksi</th>
						</tr>
					</thead>
				</table>
				<br/><br/>	
				<button type="button" id="addChildBtn" class="btn btn-primary" data-toggle="modal" data-target="#addChildModal"><i class="fa fa-plus"></i>Tambah Data Anak</button><br/><br/>
				<table id="dtAnak" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>NIP</th>
							<th>Nama Anak</th>
							<th>Status</th>
							<th>Tgl Lahir</th>
							<th>Gender</th>
							<th>Pekerjaan</th>
							<th>Dpt Tunjangan</th>
							<th>Aksi</th>
						</tr>
					</thead>
				</table>
			  </div><!-- /.tab-pane -->
			  <div class="tab-pane" id="tab_3">							
				<button type="button" id="addChildBtn" class="btn btn-primary" data-toggle="modal" data-target="#addPendModal"><i class="fa fa-plus"></i>Tambah Data Pendidikan</button><br/><br/>
				<table id="dtPend" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>NIP</th>
							<th>Tingkat</th>
							<th>Tempat Pendidikan</th>
							<th>Tahun Ijazah</th>
							<th>Aksi</th>
						</tr>
					</thead>
				</table>
			  </div><!-- /.tab-pane -->
			  <div class="tab-pane" id="tab_4">							
				<button type="button" id="addChildBtn" class="btn btn-primary" data-toggle="modal" data-target="#addKBGModal"><i class="fa fa-plus"></i>Tambah Data KGB</button><br/><br/>
				<table id="dtKGB" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No.Surat</th>
							<th>TMT</th>
							<th>TST</th>
							<th>Golongan</th>
							<th>Pangkat</th>
							<th>Gaji Pokok Awal</th>
							<th>Gaji Pokok Akhir</th>
							<th>Aksi</th>
						</tr>
					</thead>
				</table>
			  </div>
			  <div class="tab-pane" id="tab_5">							
				<table id="dtRJab" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Tahun</th>
							<th>Instansi</th>
							<th>Jabatan</th>
							<th>Aksi</th>
						</tr>
					</thead>
				</table>
			  </div><!-- /.tab-pane -->
			  <div class="tab-pane" id="tab_6">							
				<table id="dtRUnit" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>Tahun</th>
							<th>Bagian</th>
							<th>Aksi</th>
						</tr>
					</thead>
				</table>
			  </div><!-- /.tab-pane -->
			</div><!-- /.tab-content -->
		  </div><!-- nav-tabs-custom -->
		</div><!-- /.col -->
	</div>
	<!-- Modal Insert-->
	<?php include ('form_add_pegawai.php');?>
	<?php include ('form_add_keluarga.php');?>
	<?php include ('form_add_pend.php');?>
	<?php include ('form_add_kgb.php');?>
</section>
<script type='text/javascript'>
var vsearch, tempNip, tempGol, foto;
var tblKel, tblAnak, tblPend, tblKGB, tblRJab, tblRUnit;
vsearch = "cari_nama";
$(function() {
	tblKel = $('#dtKel').DataTable({
		destroy: true,
		bFilter: false,
		bPaginate: false});
	tblAnak = $('#dtAnak').DataTable({
		destroy: true,
		bFilter: false,
		bPaginate: false});
	tblPend = $('#dtPend').DataTable();
	tblKGB = $('#dtKGB').DataTable();
	tblRJab = $('#dtRJab').DataTable();
	tblRUnit = $('#dtRUnit').DataTable();
	
	$('#cari_nama').focus();
	$('#btnUpdate').css("display", "none");
	$('#btnUpdate2').css("display", "none");
	$('#addSpouseBtn').css("display", "none");
	$('#addChildBtn').css("display", "none");
	$('.pegawai-image').css("display", "none");
	
	$('.change-image').click(function(event, numFiles, label) {
		var fileinput = $(this).parents('.pegawai-image').find(':file')
		if (fileinput != null) {fileinput.focus().trigger('click');}
	});
	$('#userfile').change(function(){	
		var formData = new FormData($('#addPhotoForm')[0]);
		$.ajax({
			dataType: "json",
			type: 'POST',
			async: false,
			cache: false,
			contentType: false,
			processData: false,
			url: '<?php echo site_url(); ?>kepegawaian/Data_pegawai/update_photo',
			data: formData,
			success: function (response) {
				if(response.success){
					foto = '../upload/pegawai/'+response.photo;		
					$('#fotoNip').attr("src",foto);
				}
			}
		});
	})
	
	$('#cari_nama').autocomplete({
		serviceUrl: '<?php echo site_url();?>kepegawaian/Data_pegawai/by_nama',
		onSelect: function (suggestion) {
			//$('#vnip').val(''+suggestion.nip).trigger('change');
			$('#vnip').val(''+suggestion.nip);
		}
	});
	
	$('#cari_nip').autocomplete({
		serviceUrl: '<?php echo site_url();?>kepegawaian/Data_pegawai/by_nip'
	});
	
	$('#nm_bagian').autocomplete({
		serviceUrl: '<?php echo site_url();?>kepegawaian/Data_pegawai/data_bagian_auto',
		onSelect: function (suggestion) {
			$('#id_bagian').val(''+suggestion.id_bagian);
		}
	});
	$('#vnm_bagian').autocomplete({
		serviceUrl: '<?php echo site_url();?>kepegawaian/Data_pegawai/data_bagian_auto',
		onSelect: function (suggestion) {
			$('#vid_bagian').val(''+suggestion.id_bagian);
		}
	});
	
	$('#nm_jabatan').autocomplete({
		serviceUrl: '<?php echo site_url();?>kepegawaian/Data_pegawai/data_jabatan_auto',
		onSelect: function (suggestion) {
			$('#id_jabatan').val(''+suggestion.id_jabatan);
		}
	});
	$('#vnm_jabatan').autocomplete({
		serviceUrl: '<?php echo site_url();?>kepegawaian/Data_pegawai/data_jabatan_auto',
		onSelect: function (suggestion) {
			$('#vid_jabatan').val(''+suggestion.id_jabatan);
		}
	});	
	
	$('#nm_golongan').autocomplete({
		serviceUrl: '<?php echo site_url();?>kepegawaian/Data_pegawai/data_golongan_auto',
		onSelect: function (suggestion) {
			$('#id_golongan').val(''+suggestion.id_golongan);
		}
	});
	$('#vnm_golongan').autocomplete({
		serviceUrl: '<?php echo site_url();?>kepegawaian/Data_pegawai/data_golongan_auto',
		onSelect: function (suggestion) {
			$('#vid_golongan').val(''+suggestion.id_golongan);
		}
	});
	$('#nm_qualifikasi').autocomplete({
		serviceUrl: '<?php echo site_url();?>kepegawaian/Data_pegawai/data_qua_auto',
		onSelect: function (suggestion) {
			$('#id_qualifikasi').val(''+suggestion.id_qualifikasi);
		}
	});
	$('#vnm_qualifikasi').autocomplete({
		serviceUrl: '<?php echo site_url();?>kepegawaian/Data_pegawai/data_qua_auto',
		onSelect: function (suggestion) {
			$('#vid_qualifikasi').val(''+suggestion.id_qualifikasi);
		}
	});
	$('#nm_sub_qua').autocomplete({
		serviceUrl: '<?php echo site_url();?>kepegawaian/Data_pegawai/data_sub_qua_auto',
		onSelect: function (suggestion) {
			$('#id_sub_qua').val(''+suggestion.id_sub_qua);
		}
	});
	$('#vnm_sub_qua').autocomplete({
		serviceUrl: '<?php echo site_url();?>kepegawaian/Data_pegawai/data_sub_qua_auto',
		onSelect: function (suggestion) {
			$('#vid_sub_qua').val(''+suggestion.id_sub_qua);
		}
	});
	$( "#search_per" ).change(function() {
		vsearch = $( "#search_per" ).val();
		//alert(vsearch);
		if(vsearch=='cari_nama'){
			$("#cari_nama").css("display", "");
			$("#cari_nip").css("display", "none");
		}else{	
			$("#cari_nama").css("display", "none");
			$("#cari_nip").css("display", "");
		}
	});
	
	$( ".vnip" ).change(function() {
		var vnip = $(".vnip").val();
		$.ajax({
		  dataType: "json",
		  type: 'POST',
		  data: {id:vnip},
		  url: "<?php echo site_url(); ?>kepegawaian/Data_pegawai/is_exist",
		  success: function( response ) {
			if(response.exist > 0){
				alert("NIP "+vnip+" sudah terdata atas nama "+response.nama+"");
				$( ".vnip" ).val('');
				$( ".vnip" ).focus();
			}
		  }
		})
	});
	
	$('.datepicker').datepicker({
      format: "yyyy-mm-dd",
      endDate: '0',
      autoclose: true,
      todayHighlight: true,
    }); 
})

	function searchPegawai(){
		if(vsearch=='cari_nama'){
			if ($("#vnip").val() =='')
				alert('Lengkapi kriteria pencarian!');
			else
				getDetail($("#vnip").val());
		}else{	
			if ($("#cari_nip").val() =='')
				alert('Lengkapi kriteria pencarian!');
			else
				getDetail($("#cari_nip").val());
		}
	}
	
	function getDetail(nip) {
		$.ajax({
		  dataType: "json",
		  type: 'POST',
		  data: {id:nip},
		  url: "<?php echo site_url(); ?>kepegawaian/Data_pegawai/detail",
		  success: function( response ) {
			if (response.nip == ''){
				alert("Data pegawai tidak ditemukan!");
			}else{
				$('.pegawai-image').css("display", "");
				tempNip = response.nip;
				tempGol = response.id_golongan;
				if ((response.foto != "")&&(response.foto != null))
					foto = '../upload/pegawai/'+response.foto;
				else
					foto = '../upload/pegawai/NoImage.jpg';				
				$('#fotoNip').attr("src",foto);
				$('#nip').val(response.nip);
				$('#nip2').val(response.nip);
				$('#pnip').val(response.nip);
				//$('#nip').prop('readonly', 'readonly');
				$('#nm_pegawai').val(response.nm_pegawai);
				$('#gelar_dpn').val(response.gelar_dpn);
				//$('#gelar_dpn').prop('readonly', 'readonly');
				$('#gelar_bkl').val(response.gelar_bkl);
				if (response.duk == 'Y') $('#duk').prop('checked', true);
				else $('#duk').prop('checked', false);
				$("input[name=aktif][value=" + response.aktif + "]").prop('checked', true);
				$("input[name=fulltime][value=" + response.fullpartime + "]").prop('checked', true);
				$('#sk_masuk').val(response.sk_masuk);
				$('#tgl_masuk').val(response.tgl_masuk);
				$('#dept').val(response.dept);
				$('#id_bagian').val(response.id_bagian);
				$('#nm_bagian').val(response.nm_bagian);
				$('#tmt').val(response.tmt);
				$('#id_jabatan').val(response.id_jabatan);
				$('#nm_jabatan').val(response.nm_jabatan);
				$('#tmt_jabatan').val(response.tmt_jabatan);
				$('#id_golongan').val(response.id_golongan);
				$('#nm_golongan').val(response.nm_golongan);
				$('#tmt_golongan').val(response.tmt_golongan);
				$('#id_qualifikasi').val(response.id_qualifikasi);
				$('#nm_qualifikasi').val(response.nm_qualifikasi);
				$('#id_sub_qua').val(response.id_sub_qua);
				$('#nm_sub_qua').val(response.nm_sub_qua);
				$('#id_jenis').val(response.id_jenis);
				$('#jenis').val(response.jenis);
				$("input[name=gol_puncak][value=" + response.gol_puncak + "]").prop('checked', true);
				$("input[name=ahli][value=" + response.flag_aktif + "]").prop('checked', true);
				$('#penggaji_2').val(response.penggaji_2);
				$('#tpt_lahir').val(response.tpt_lahir);
				$('#tgl_lahir').val(response.tgl_lahir);
				$("input[name=sex][value=" + response.sex + "]").prop('checked', true);
				$('#status').val(response.status);
				$('#agama').val(response.agama);
				$('#no_hp').val(response.no_hp);
				$('#thncutibesar').val(response.thncutibesar);
				$('#no_karpeg').val(response.no_karpeg);
				$('#no_taspen').val(response.no_taspen);
				$('#alamat').val(response.alamat);
				$('#prop').val(response.prop);
				$('#kota').val(response.kota);
				
				$('#btnUpdate').css("display", "");
				$('#btnUpdate2').css("display", "");
			  }
		  }
		});	
		
		loadTblKel(nip);
		loadTblAnak(nip);
		loadTblPend(nip);
		loadTblKGB(nip);
		
		tblRJab = $('#dtRJab').DataTable({
			ajax: "<?php echo site_url(); ?>kepegawaian/Data_pegawai/list_history_jabatan/"+nip,
			columns: [
				{ data: "tahun" },
				{ data: "instansi" },
				{ data: "nm_jabatan" },
				{ data: "aksi" }
			],
			destroy: true,
			order: [[ 0, "desc" ]]
		});	
		
		tblRUnit = $('#dtRUnit').DataTable({
			ajax: "<?php echo site_url(); ?>kepegawaian/Data_pegawai/list_history_mutasi/"+nip,
			columns: [
				{ data: "tahun" },
				{ data: "nm_bagian" },
				{ data: "aksi" }
			],
			destroy: true,
			order: [[ 0, "desc" ]]
		});	
		
		$('#addChildModal').on('shown.bs.modal', function(e) {
			$("#nip_anak").val(tempNip);
		});
		
		$('#addSpouseModal').on('shown.bs.modal', function(e) {
			$("#nip_si").val(tempNip);
			$(".stat_si").val("SUAMI");
			$( ".sex_si" ).click(function() {
				var vsex = $('input[name=sex_si]:checked').val();
				//alert(vsex);
				if(vsex=='L'){
					$(".stat_si").val("SUAMI");
				}else{	
					$(".stat_si").val("ISTRI");
				}
			});
		});
		
		$('#addPendModal').on('shown.bs.modal', function(e) {
			$("#nip_pend").val(tempNip);				
			
			$('#nm_pendidikan').autocomplete({
				serviceUrl: '<?php echo site_url();?>kepegawaian/Data_pegawai/data_tingkat_auto'
			});			
			
			$('#nm_qua_pend').autocomplete({
				serviceUrl: '<?php echo site_url();?>kepegawaian/Data_pegawai/data_qua_auto',
				onSelect: function (suggestion) {
					$('#id_qua_pend').val(''+suggestion.id_qua_pend);
				}
			});
			
		});
		
		$('#addKBGModal').on('shown.bs.modal', function(e) {
			$("#nip_kgb").val(tempNip);				
			$("#id_gol_kgb0").val(tempGol);				
				
			$('#nm_gol_kgb').autocomplete({
				serviceUrl: '<?php echo site_url();?>kepegawaian/Data_pegawai/data_golongan_auto',
				onSelect: function (suggestion) {
					$('#id_gol_kgb').val(''+suggestion.id_golongan);
				}
			});
			
		});
	};

function loadTblKel(nip){
	tblKel = $('#dtKel').DataTable({
		ajax: "<?php echo site_url(); ?>kepegawaian/Data_pegawai/list_keluarga/"+nip,
		columns: [
			{ data: "nip" },
			{ data: "nama" },
			{ data: "status" },
			{ data: "tgl_lahir" },
			{ data: "sex" },
			{ data: "tgl_nikah" },
			{ data: "pekerjaan" },
			{ data: "tunjangan" },
			{ data: "aksi" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false },
			{ targets: [ 3 ], orderable: false }
		],
		destroy: true,
		bFilter: false,
		bPaginate: false,
		order: [[ 3, "asc" ]],
		initComplete: function(settings, json) {
			if ( json.data.length > 0 )$('#addSpouseBtn').css("display", "none");
			else $('#addSpouseBtn').css("display", "");
		  }
	});	
}
function loadTblAnak(nip){
	$('#addChildBtn').css("display", "");
	tblAnak = $('#dtAnak').DataTable({
		ajax: "<?php echo site_url(); ?>kepegawaian/Data_pegawai/list_anak/"+nip,
		columns: [
			{ data: "nip" },
			{ data: "nama" },
			{ data: "status" },
			{ data: "tgl_lahir" },
			{ data: "sex" },
			{ data: "pekerjaan" },
			{ data: "tunjangan" },
			{ data: "aksi" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false },
			{ targets: [ 3 ], orderable: false }
		],
		destroy: true,
		bFilter: false,
		bPaginate: false,
		order: [[ 3, "asc" ]]
	});	
}
function deleteKel(nip, nm){	
	$.ajax({
	  dataType: "json",
	  type: 'POST',
	  data: {id:nip,nama:nm},
	  url: "<?php echo site_url(); ?>kepegawaian/Data_pegawai/delete_kel",
	  success: function( response ) {
		if(response.success){
			//$( "#alertMsg" ).append(response.message);	
			loadTblKel(nip);
			loadTblAnak(nip);
		}
	  }
	})
}
function loadTblPend(nip){
	tblPend = $('#dtPend').DataTable({
		ajax: "<?php echo site_url(); ?>kepegawaian/Data_pegawai/list_pendidikan/"+nip,
		columns: [
			{ data: "nip" },
			{ data: "tk_ijazah" },
			{ data: "tpt_pend" },
			{ data: "thn_ijazah" },
			{ data: "aksi" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false },
			{ targets: [ 3 ], orderable: false }
		],
		destroy: true,
		order: [[ 3, "desc" ]]
	});	
}
function deletePend(nip, nm){	
	$.ajax({
	  dataType: "json",
	  type: 'POST',
	  data: {id:nip,nama:nm},
	  url: "<?php echo site_url(); ?>kepegawaian/Data_pegawai/delete_pend",
	  success: function( response ) {
		if(response.success){
			//$( "#alertMsg" ).append(response.message);	
			loadTblPend(nip);
		}
	  }
	})
}
function loadTblKGB(nip){
	tblKGB = $('#dtKGB').DataTable({
			ajax: "<?php echo site_url(); ?>kepegawaian/Data_pegawai/list_kgb/"+nip,
			columns: [
				{ data: "no_suratkgb" },
				{ data: "tgl_berlaku0" },
				{ data: "tgl_berlaku" },
				{ data: "nm_golongan" },
				{ data: "pangkat" },
				{ data: "gaji_pokok0" },
				{ data: "gaji_pokok" },
				{ data: "aksi" }
			],
			destroy: true,
			order: [[ 1, "desc" ]]
		});	
}
function deleteKGB(nip, nm){	
	$.ajax({
	  dataType: "json",
	  type: 'POST',
	  data: {id:nip,nama:nm},
	  url: "<?php echo site_url(); ?>kepegawaian/Data_pegawai/delete_kgb",
	  success: function( response ) {
		if(response.success){
			//$( "#alertMsg" ).append(response.message);	
			loadTblKGB(nip);
		}
	  }
	})
}
</script>
<?php
	$this->load->view('layout/footer.php');
?>