<?php $this->load->view("layout/header"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
<script>
$(document).ready(function(){
	$('#div_rujukan').hide();
	$('#btn_sep').hide();
	$('#loading-rujukan').hide();
	$('.js-example-basic-single').select2();

	//untuk nampilin form bpjs ato engga di awal
	var kls_bpjs = "<?php echo $kls_bpjs;?>";
		//alert(kls_bpjs);
		if(kls_bpjs!='' || kls_bpjs!=null){
			$('#jatahkls').val(kls_bpjs).change();
		}
	var cara_bayar = "<?php echo $data_pasien[0]['cara_bayar'] ;?>";
	if(cara_bayar == "BPJS"){
		$('.form_bpjs').show();
		$('#div_rujukan').show();
		$('#btn_sep').show();
		$('#btn_simpan').hide();
		$('.form_perusahaan').hide();
		document.getElementById("nmkontraktorbpjs").required= false;
		
	}else if(cara_bayar == "DIJAMIN"){
		$('.form_bpjs').hide();
		$('#div_rujukan').hide();
		$('#btn_sep').hide();
		$('#btn_simpan').show();		
		$('.form_perusahaan').show();
		document.getElementById("nmkontraktorbpjs").required= false;
	}else{
		$('.form_bpjs').hide();
		$('#div_rujukan').hide();
		$('#btn_sep').hide();
		$('#btn_simpan').show();		
		$('.form_perusahaan').hide();
		document.getElementById("nmkontraktorbpjs").required= false;
	}

	$('#loading_bpjs').hide();
});

$(function(){
<?php if($data_pasien[0]['sex']=='L'){ ?>
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

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_dokter').autocomplete({
		serviceUrl: site+'/iri/ricpendaftaran/data_dokter_autocomp',
		onSelect: function (suggestion) {
			$('#id_dokter').val(''+suggestion.id_dokter);
			$('#nmdokter').val(''+suggestion.nm_dokter);
		}
	});
});

// buat pendaftaran ibu
var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_ipd_pasien').autocomplete({
		// serviceUrl: site+'/iri/ricreservasi/data_pasien_irj',
		serviceUrl: site+'/iri/ricpasien/data_pasien_auto',
		onSelect: function (suggestion) {
			$('#ipdnama').val(''+suggestion.no_ipd+' - '+suggestion.nama);
			$('#noipdibu').val(''+suggestion.no_ipd);
		}
	});
});

function cek_kartu_bpjs(){
	$('#loading_bpjs').show();
	var no_bpjs = $('#no_bpjs').val();
	$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>iri/ricstatus/cek_kartu_bpjs/",
        data:   {
                    no_bpjs        : no_bpjs
                },
    }).done(function(msg) {
    	if(msg == ""){
    		document.getElementById("data_validasi").innerHTML = "Data Tidak Ditemukan";
    	}else{
    		document.getElementById("data_validasi").innerHTML = msg;
    	}
    	$('#modal_validasi').modal('show');
    	$('#loading_bpjs').hide();
    });
}

function ambil_sep(){
	$('#loading_bpjs').show();
	var no_bpjs = $('#no_bpjs').val();
	var nosjp = $('#nosjp').val();
	var diagnosa_id = $('#diagnosa_id').val();
	var no_cm_hidden = $('#no_cm_hidden').val();
	var noregasal_hidden = $('#noregasal_hidden').val();
	var ruang = $('#ruang').val();
	var ppk = $('#ppk').val();
	$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>iri/ricstatus/ambil_sep/",
        data:   {
                    no_bpjs        : no_bpjs,
                    noregasal_hidden    : noregasal_hidden,
                    ruang        : ruang,
                    nosjp        : nosjp,
                    diagnosa_id  : diagnosa_id,
                    no_cm        : no_cm_hidden,
                    ppk          : ppk
                },
    }).done(function(msg) {
    	obj = JSON.parse(msg);
    	if(obj.status == 0){
    		alert(obj.response);
    	}else{
    	  	$('#no_sep').val(obj.response);
			$('#no_sep_hidden').val(obj.response);
    	}
    	$('#loading_bpjs').hide();
    });
}

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

function update_form_bpjs(cara_bayar){

	if(cara_bayar == "BPJS"){
		$('.form_bpjs').show();
		$('#div_rujukan').show();
		$('#btn_sep').show();
		$('#btn_simpan').hide();		
		$('.form_perusahaan').hide();
		//nmkontraktorbpjs
		document.getElementById("nmkontraktorbpjs").required= true;
	}else if(cara_bayar == "DIJAMIN"){
		$('.form_bpjs').hide();
		$('#div_rujukan').hide();
		$('#btn_sep').hide();
		$('#btn_simpan').show();		
		$('.form_perusahaan').show();
		document.getElementById("nmkontraktor").required= true;
	}else{
		$('#div_rujukan').hide();
		$('#btn_sep').hide();
		$('#btn_simpan').show();		
		$('.form_bpjs').hide();
		$('.form_perusahaan').hide();
		document.getElementById("nmkontraktorbpjs").required= false;
	}
}
var ajaxku;
function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}
function cek_rujukan(){
	$('#loading-rujukan').show();
	var no_rujukan = document.getElementById("nosjp").value;
	var e = document.getElementById("id_smf");
	var get_cara_kunjungan = e.options[e.selectedIndex].value;
	if (get_cara_kunjungan == 'RUJUKAN RS') {
		var cara_kunjungan = 'RS';
	}
	else {
		var cara_kunjungan = 'PCare';
	}
	if (no_rujukan.length == 0) {
	$('#loading-rujukan').hide();		
	swal("Cek Nomor Rujukan", "Silahkan masukkan nomor rujukan", "error");
	}
	else {
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcwebservice/check_no_rujukan'); ?>";
    url=url+"/"+no_rujukan+"/"+cara_kunjungan;
    ajaxku.onreadystatechange=stateChangedValidasiRujukan;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
    }
}
function stateChangedValidasiRujukan(){
	var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if (data.indexOf('Tidak Ditemukan')!= -1 || data.indexOf('Masukan')!= -1) {	
			// // $('#modal_validasi').modal('show');		
			// // document.getElementById("cara_bayar" ).disabled=false;
			// // document.getElementById("cara_bayar").selectedIndex = "0";
			// document.getElementById("asal_rujukan" ).disabled=false;
			// document.getElementById("diagnosa" ).disabled=false;
			// document.getElementById("id_poli" ).disabled=false;
			// document.getElementById('tgl_rujukan').value = '<?php echo date('Y-m-d');?>';
			// document.getElementById("asal_rujukan").selectedIndex = "0";
			// document.getElementById('id_poli').value = '';
			// document.getElementById('kode_provider').value='';
			// document.getElementById('tgl_rujukan').value='';
			// document.getElementById('diagnosa').value='';
			// document.getElementById('entri_catatan').value='';
			$('#loading-rujukan').hide();	
			swal("Cek Nomor Rujukan", "Silahkan masukkan nomor rujukan yang valid", "error");
		}
		else {
			// // document.getElementById('cara_bayar').value = 'BPJS';
			// // document.getElementById("cara_bayar" ).disabled=true;
			// document.getElementById("asal_rujukan" ).disabled=false;
			// document.getElementById("diagnosa" ).disabled=false;
			// document.getElementById("id_poli" ).disabled=false;
			var data1 = JSON.parse(data);
			// document.getElementById('kode_provider').value=data1["response"].item.provKunjungan.kdProvider;
			// document.getElementById('tgl_rujukan').value=data1["response"].item.tglKunjungan;
			// document.getElementById('diagnosa').value=data1["response"].item.diagnosa.kdDiag;
			// document.getElementById('entri_catatan').value=data1["response"].item.catatan;
			$('#loading-rujukan').hide();
			swal(""+data1["response"].item.peserta.nama+"", "Nomor Kartu : "+data1["response"].item.peserta.noKartu+"", "success");	
		}
    }
}
</script>
<div>
	<div>
		
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

						<!-- Modal Validasi -->
						<div class="modal fade" id="modal_validasi" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						  <div class="modal-dialog modal-lg" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        <h4 class="modal-title" id="myModalLabel">Hasil Validasi</h4>
						      </div>
						      <div class="modal-body">
									<div id="data_validasi"></div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
						      </div>
						    </div>
						  </div>
						</div>	
						<!-- Modal -->

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
													<input type="hidden" value="<?php echo $irna_reservasi[0]['no_register_asal']; ?>" id="noregasal_hidden">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">No. CM</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="no_cm" value="<?php echo $irna_reservasi[0]['no_cm']; ?>" readonly>
													<input type="hidden" name="no_cm_hidden" value="<?php echo $irna_reservasi[0]['no_medrec']; ?>" id="no_cm_hidden">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Tgl. Daftar</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="tgldaftarri" value="<?php echo date('Y-m-d',strtotime($irna_reservasi[0]['tglreserv'])); ?>" readonly>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Cara Bayar</div>
												<div class="col-sm-9">
													<!-- <input type="text" class="form-control input-sm" name="carabayar"> -->
													<select class="form-control input-sm" name="carabayar" onchange="update_form_bpjs(this.value)" id="cara_bayar">
														<?php
														foreach ($cara_bayar as $r) { 
															if($r['cara_bayar'] == $data_pasien[0]['cara_bayar']){ ?>
															<option value="<?php echo $r['cara_bayar'] ;?>" selected><?php echo $r['cara_bayar'] ;?></option>
															<?php
															}else{ ?>
															<option value="<?php echo $r['cara_bayar'] ;?>"><?php echo $r['cara_bayar'] ;?></option>
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
												<div class="col-sm-3 control-label">Penjamin</div>
												<div class="col-sm-9" align="left">
													<input type="hidden" class="form-control input-sm" name="id_kontraktor" id="id_kontraktor" value="<?php if(isset($data_pasien[0]['id_kontraktor'])){echo $data_pasien[0]['id_kontraktor'];}?>">
													<div class="col-sm-8 input-right"><input type="text" class="form-control input-sm auto_no_register_dokter" name="nmkontraktor" value="<?php if(isset($data_pasien[0]['nmkontraktor'])){echo $data_pasien[0]['nmkontraktor'];}?>"></div>
												</div>
											</div>



											<div class="form-group">
												<div class="col-sm-3 control-label">Cara Datang</div>
												<div class="col-sm-9" align="left">
													<select class="form-control input-sm" id="id_smf" name="id_smf" >
														<?php
															foreach ($smf as $r) { ?>
														<option value="<?php echo $r['cara_kunj'];?>" ><?php echo $r['cara_kunj'];?></option>
														<?php															
														}?>
													</select>
												</div>
											</div>
											<!-- <div class="form-group">
												<div class="col-sm-3 control-label">Cara Masuk</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="caramasuk">
												</div>
											</div> -->
											<div class="form-group">
												<div class="col-sm-3 control-label">Dokter DPJP</div>
												<div class="col-sm-9" align="left">
													<input type="hidden" class="form-control input-sm" name="id_dokter" id="id_dokter" value="<?php if(isset($data_pasien[0]['id_dokter'])){echo $data_pasien[0]['id_dokter'];}?>">
													<div class="col-sm-8 input-right"><input type="text" class="form-control input-sm auto_no_register_dokter" name="nmdokter" value="<?php if(isset($data_pasien[0]['nm_dokter'])){echo $data_pasien[0]['nm_dokter'];}?>" required></div>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Diagnosa</div>
												<div class="col-sm-9" align="left">
													<input type="text" class="form-control input-sm auto_diagnosa_pasien" name="diagnosa" id="diagnosa" value="<?php echo $irna_reservasi[0]['diagnosa'];?> - <?php echo $irna_reservasi[0]['nm_diagnosa'];?>" ><div id="loading_diagnosa"></div>
													<input type="hidden" name="diagnosa_id" id="diagnosa_id" value="<?php echo $irna_reservasi[0]['diagnosa'];?>" >
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6 form-right">
										<div class="box-body">
											<div class="form-group">
												<div class="col-sm-3 control-label">No. Reg. Lama</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="noipdlama" value="<?php echo $irna_reservasi[0]['noreservasi']; ?>">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Nama</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" disabled="true" name="nama_disp" value="<?php echo $data_pasien[0]['nama']; ?>" >
													<input type="hidden" name="nama" value="<?php echo $data_pasien[0]['nama']; ?>" >
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Tgl. Lahir</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" id="calendar-tgl-lahir" name="tgllahirri" value="<?php echo date('d-m-Y',strtotime($data_pasien[0]['tgl_lahir'])); ?>" disabled="true">
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-3 control-label">Jenis Kelamin <?php echo $data_pasien[0]['sex']; ?></div>
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
													<input type="text" class="form-control input-sm auto_no_ipd_pasien" name="ipdnama" id="ipdnama">
													<input type="hidden" name="noipdibu" id="noipdibu">
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
															<input type="text" class="form-control input-sm" name="alamatri" value="<?php echo $data_pasien[0]['alamat']; ?>" >
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Kelurahan</div>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="kelurahanri" value="<?php echo $data_pasien[0]['kelurahandesa']; ?>" >
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Kecamatan</div>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="kecamatanri" value="<?php echo $data_pasien[0]['kecamatan']; ?>" >
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">RT/RW</div>
														<div class="col-sm-9" align="left">
															<div class="col-sm-3 input-left"><input type="text" class="form-control input-sm" name="rtri" value="<?php echo $data_pasien[0]['rt']; ?>" ></div>
															<div class="col-sm-3 input-right"><input type="text" class="form-control input-sm" name="rwri" value="<?php echo $data_pasien[0]['rw']; ?>" ></div>
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
															<input type="text" class="form-control input-sm" name="notelp" value="<?php echo $data_pasien[0]['no_telp']; ?>" >
														</div>
														<div class="col-sm-2 control-label">No. HP</div>
														<div class="col-sm-3">
															<input type="text" class="form-control input-sm" name="nohp" value="<?php echo $data_pasien[0]['no_hp']; ?>" >
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Status</div>
														<div class="col-sm-3">
															<input type="text" class="form-control input-sm" name="statusri" value="<?php echo $data_pasien[0]['status']; ?>" >
														</div>
														<div class="col-sm-2 control-label">Agama</div>
														<div class="col-sm-4">
															<input type="text" class="form-control input-sm" name="agamari" value="<?php echo $data_pasien[0]['agama']; ?>" >
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="box-body">
													<div class="form-group">
														<div class="col-sm-3 control-label">Pendidikan</div>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="pendidikanri" value="<?php echo $data_pasien[0]['pendidikan']; ?>" >
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Pekerjaan</div>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="pekerjaanri" value="<?php echo $data_pasien[0]['pekerjaan']; ?>" >
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Warga Negara</div>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="wnegarari" value="<?php echo $data_pasien[0]['wnegara']; ?>" >
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Suku Bangsa</div>
														<div class="col-sm-9" align="left">
															<input type="text" class="form-control input-sm" name="sukubangsari" value="<?php echo $data_pasien[0]['sukubangsa']; ?>" >
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Bahasa</div>
														<div class="col-sm-9" align="left">
															<input type="text" class="form-control input-sm" name="bahasari" value="<?php echo $data_pasien[0]['bahasa']; ?>">
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Nama Ibu/Istri</div>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="nm_ibu_istri" value="<?php echo $data_pasien[0]['nm_ibu_istri']; ?>" >
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Nama Ayah/Suami</div>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="nm_ayah_suami" value="<?php echo $data_pasien[0]['nm_ayah_suami']; ?>" >
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
													<div class="box-body ">
														<div class="form-group form_bpjs">
															<div class="col-sm-3 control-label">Asal Rujukan</div>
															<div class="col-sm-9" align="left">
																<select class="form-control js-example-basic-single" style="width:100%" name="ppk" id="ppk">
																	<?php
																	foreach ($ppk as $r) { 
																		if($r['kd_ppk'] == $data_pasien[0]['asal_rujukan']){ ?>
																		<option value="<?php echo $r['kd_ppk'] ;?>" selected="true"><?php echo $r['nm_ppk'] ;?></option>
																		<?php
																		}else{ ?>	
																		<option value="<?php echo $r['kd_ppk'] ;?>"><?php echo $r['nm_ppk'] ;?></option>
																		<?php
																		}
																	?>
																	<?php
																	}
																	?>
																</select>
															</div>
														</div>
														<div class="form-group form_bpjs">
															<div class="col-sm-3 control-label">No.SJP / No.Rujukan</div>
															<div class="col-sm-9" align="left">
   												<div class="input-group">
      											<input type="text" class="form-control" name="nosjp" value="<?php echo $data_pasien[0]['no_rujukan']; ?>" id="nosjp">
      											<span class="input-group-btn">
        											<button class="btn btn-danger" type="button" onclick="cek_rujukan()"><i class="fa fa-spinner fa-spin" id="loading-rujukan"></i> Cek Rujukan</button>
      											</span>
    											</div>	
															</div>
														</div>
													<!-- 	<div class="form-group">
															<div class="col-sm-3 control-label">No.Askes / No.Peserta</div>
															<div class="col-sm-9" align="left">
																<input type="text" class="form-control input-sm" name="nopembayranri">
															</div>
														</div> -->
														<div class="form-group form_bpjs">
															<div class="col-sm-3 control-label">Dijamin Oleh</div>
															<div class="col-sm-9" align="left">
																<input type="text" name="id_kontraktor_bpjs">
																<select class="form-control js-example-basic-single" style="width:100%" name="nmkontraktorbpjs" id="nmkontraktorbpjs">
																	<option value="">Pilih BPJS</option>
																	<?php
																	foreach ($kontraktorbpjs as $r) { ?>
																	<option value="<?php echo $r['id_kontraktor'] ;?>"><?php echo $r['nmkontraktor'] ;?></option>
																	<?php
																	}
																	?>
																</select>
															</div>
														</div>
														<div class="form-group form_bpjs">
															<div class="col-sm-3 control-label">No. Kartu BPJS</div>
															<div class="col-sm-9" align="left">
																<input type="text" class="form-control input-sm" name="no_bpjs" id="no_bpjs" value="<?php echo $data_pasien[0]['no_kartu']; ?>" disabled="true" style="margin-bottom:10px">
																<button type="button" class="btn btn-primary btn-sm" onclick="cek_kartu_bpjs()"><i class="fa fa-eye"></i> Cek Kartu BPJS</button>
<!-- 																<button type="button" class="btn btn-primary btn-sm" onclick="ambil_sep()"><i class="fa fa-save"></i> Ambil SEP</button> -->
<!-- 																<div id="loading_bpjs">Loading...</div> -->
															</div>
														</div>
<!-- 														<div class="form-group form_bpjs" >
															<div class="col-sm-3 control-label">No. SEP</div>
															<div class="col-sm-9" align="left">
																<input type="text" class="form-control input-sm" name="no_sep" id="no_sep" disabled="true">
																<input type="hidden" id="no_sep_hidden" name="no_sep_hidden">
															</div>
														</div> -->
					<!-- 									<div class="form-group form_perusahaan">
															<div class="col-sm-3 control-label">Kontraktor</div>
															<div class="col-sm-9" align="left">
																<input type="hidden" name="id_kontraktor">
																<select class="form-control js-example-basic-single" style="width:100%" name="nmkontraktor">
																	<option value="">Pilih Kontraktor</option>
																	<?php
																	foreach ($kontraktor as $r) { ?>
																	<option value="<?php echo $r['id_kontraktor'];?>"> <?php echo $r['nmkontraktor'] ;?></option>
																	<?php
																	}
																	?>
																</select>
															</div>
														</div> -->
														<div class="form-group form_perusahaan">
															<div class="col-sm-3 control-label">P/I/S/A</div>
															<div class="col-sm-9" align="left">
																<select class="form-control input-sm" name="ketpembayarri">
																	<option value="Ybs">Ybs</option>
																	<option value="Istri">Istri</option>
																	<option value="Suami">Suami</option>
																	<option value="Anak">Anak</option>
																</select>
															</div>
														</div>
														<div class="form-group form_perusahaan">
															<div class="col-sm-3 control-label">Nama Peserta</div>
															<div class="col-sm-9" align="left">
																<input type="text" class="form-control input-sm" name="nmpembayarri">
															</div>
														</div>
														<div class="form-group form_perusahaan">
															<div class="col-sm-3 control-label">Golongan</div>
															<div class="col-sm-9" align="left">
																<input type="text" class="form-control input-sm" name="golpembayarri">
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
																		<option value="KTP">KTP</option>
																		<option value="SIM">SIM</option>
																		<option value="PASPOR">PASPOR</option>
																		<option value="KTM">KTM</option>
																		<option value="NIK">NIK</option>
																	</select>
																</div>
																<div class="col-sm-8 input-right"><input type="text" class="form-control input-sm" name="noidpjawab"></div>
															</div>
														</div>
														<div class="form-group">
															<div class="col-sm-3 control-label">Hub.Keluarga</div>
															<div class="col-sm-3" align="left">
																<select class="form-control input-sm" name="hubjawabri">
																	<option value="Suami">Suami</option>
																	<option value="Istri">Istri</option>
																	<option value="Ayah">Ayah</option>
																	<option value="Ibu">Ibu</option>
																	<option value="Saudara">Saudara</option>
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
													<!-- <div class="form-group">
														<div class="col-sm-3 control-label">Bed</div>
														<div class="col-sm-9">
														<select class="form-control input-sm" name="bed">
															<?php
															foreach ($empty_bed as $r) { ?>
															<option value="<?php echo $r['bed'] ;?>"><?php echo $r['bed'] ;?></option>
															<?php
															}
															?>
														</select>
														</div>
													</div> -->
													<div class="form-group">
														<div class="col-sm-3 control-label">Bed</div>
														<div class="col-sm-9">
															<select class="form-control input-sm" id="bed" name="bed" required>
																<?php
																foreach ($empty_bed as $r) { ?>
																<option value="<?php echo $r['bed'] ;?>"><?php echo $r['bed'];?></option>
																<?php	
																}
																?>
															</select>
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Ruang Pilih *</div>
														<div class="col-sm-9">
															<span class="label-form-validation"></span>
															<!-- <select class="form-control input-sm" id="ruang" name="ruang" onchange="get_bed(this.value)" required>
																<?php
																if(empty($empty_bed)){ ?>
																<option value="" selected="true">-- Kelas yang dipesan penuh silahkan reservasi ulang--</option>
																<?php
																} else{
																	foreach ($kelas as $r) { 
																		if($irna_reservasi[0]['kelas'] == $r['kelas'] && $irna_reservasi[0]['idrg'] == $r['idrg']){ 
																			$status_kelas = 1;
																		?>
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
															</select> -->
															<?php 
																if(empty($kelas)){
															?>
																<select class="form-control input-sm" id="ruang" name="ruang" onchange="get_bed(this.value)" required>
																	<option value="" selected="true">Semua Kelas Penuh</option>
																</select>
															<?php
																} else { 
																	if(empty($status_bed)){ 
															?>
																	<select class="form-control input-sm" id="ruang" name="ruang" onchange="get_bed(this.value)" required>
																	 	<option value="" selected="true">-- Kelas yang dipesan penuh silahkan pilih kelas lain --</option>
															<?php
																		foreach ($kelas as $r) { 
															?>
																		<option value="<?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?>"><?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?></option>
															<?php
																			
																		}
															?>
																	</select> 
															<?php
																	} else {
															?>
																		<select class="form-control input-sm" id="ruang" name="ruang" onchange="get_bed(this.value)" required>
															<?php
																		foreach ($kelas as $r) { 
																			if($irna_reservasi[0]['kelas'] == $r['kelas'] && $irna_reservasi[0]['idrg'] == $r['idrg']){ 
															?>
																				<option value="<?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?>" selected="true"><?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?></option>
															<?php
																			} else {
															?>
																		<option value="<?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?>"><?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?></option>

															<?php
																			}
																		}
																	}
																}
															?>
																	</select>

															<!-- <select class="form-control input-sm" id="ruang" name="ruang" onchange="get_bed(this.value)" required>
																<?php
																$status_kelas = 0;
																if(empty($kelas)){ 
																?>
																	<option value="" selected="true">Semua Kelas Penuh</option>
																<?php
																}else{
																	foreach ($kelas as $r) { 
																		if($irna_reservasi[0]['kelas'] == $r['kelas'] && $irna_reservasi[0]['idrg'] == $r['idrg']){ 
																			$status_kelas = 1;
																		?>
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
																<?php if($status_kelas == 0){ ?>
																<option value="" selected="true">-- Kelas yang dipesan penuh silahkan pilih kelas lain --</option>
																<?php
																}?>
															</select> -->
														</div>
													</div>
													<!-- <div class="form-group">
														<div class="col-sm-3 control-label">Ruang</div>
														<div class="col-sm-9">
															<span class="label-form-validation"></span>
															<input type="text" class="form-control input-sm auto_ruang" id="ruang" name="ruang" value="<?php echo $irna_reservasi[0]['ruangpilih']; ?>" readonly>
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label"></div>
														<div class="col-sm-9">
															<span class="label-form-validation"></span>
															<div class="col-sm-8 input-left"><input type="text" class="form-control input-sm" id="nm_ruang" name="nm_ruang" value="<?php echo $irna_reservasi[0]['nmruang']; ?>" readonly></div>
															<div class="col-sm-4 input-right"><input type="text" class="form-control input-sm" id="kelas" name="kelas" value="<?php echo $irna_reservasi[0]['kelas']; ?>" readonly></div>
														</div>
													</div> -->
													<div class="form-group">
														<div class="col-sm-3 control-label">Tgl. Masuk</div>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" id="calendar-tgl-masuk" name="tglmasukrg" value="<?php echo $irna_reservasi[0]['tglrencanamasuk']; ?>" required>
														</div>
													</div>
													<div class="form-group">
														<div class="col-sm-3 control-label">Jatah Kelas</div>
														<div class="col-sm-9" align="left">
															<!-- <input type="text" class="form-control input-sm" name="jatahkls"> -->
															<select class="form-control input-sm" name="jatahkls" id="jatahkls">
																<?php
																foreach ($all_kelas as $r) {  ?>
																<option value="<?php echo $r['kelas'] ;?>"><?php echo $r['kelas'] ;?></option>
																<?php
																}
																?>
															</select>
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
							<div class="container">
							<div class="row">
								<div class="col-md-12">
									<div class="button-pendaftaran">
									<a href="<?php echo base_url(); ?>iri/Ricdaftar" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Kembali</a>
									<button type="submit" class="btn btn-danger" id="btn_simpan"><i class="fa fa-save"></i> Simpan</button>	
									<button type="submit" class="btn btn-danger" id="btn_sep"><i class="fa fa-print"></i> Simpan </button>	<!--& Cetak SEP-->		
									</div>							
								</div>
							</div>
							</div>
							<br/>
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
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
		minDate: '0'
	});
</script>

<?php $this->load->view("layout/footer"); ?>
