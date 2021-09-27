<?php
	$this->load->view('layout/header.php');
	
	//cek jenis kunjungan
	if ( date("Y-m-d") == substr($data_pasien->tgl_daftar,0,10) ) 
		$jns_kunjungan="BARU";
	else $jns_kunjungan="LAMA";
?>
<html>
<script type='text/javascript'>
<?php $no_medrec=$data_pasien->no_medrec; ?>
$(document).ready(function() {
    cek_validasi_post('<?php echo $no_medrec;?>');
});
var site = "<?php echo site_url();?>";
$(function() {
	$(".jns_kunj").attr('disabled', true);
	$('#hubungan').hide();
	$(".select2").select2();
	$("#duplikat_id").hide();
	$("#warn_kartu").hide();
	$("#duplikat_kartu").hide();
	$('#input_kontraktor').hide();
	$('#input_diagnosa').hide();
	$('#input_kecelakaan').hide();
	$('#div_sep').hide();
	$('#div_rujukan').hide();
	$('#loading-rujukan').hide();
	$('#button_cetak_sep').hide();	
	$('#ird').hide();
	$('#rujukan_lainnya').hide();
	$('#nrp_sbg').change();
	$('#input_tentara').hide();

	$('.auto_diagnosa_pasien').autocomplete({
		serviceUrl: site+'iri/ricstatus/data_icd_1',
		onSelect: function (suggestion) {
			//$('#no_cm').val(''+suggestion.no_cm);
			$('#diagnosa').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
			$('#id_diagnosa').val(''+suggestion.id_icd);
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

	$('.auto_search_by_nocm').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_pasien_by_nocm',
		onSelect: function (suggestion) {
			$('#cari_no_cm').val(''+suggestion.no_medrec);
		}
	});

	$('.auto_search_by_nonrp').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_pasien_by_nonrp',
		onSelect: function (suggestion) {
			$('#cari_no_cm').val(''+suggestion.no_nrp);
		}
	});

	$('.auto_search_by_nokartu').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_pasien_by_nokartu',
		onSelect: function (suggestion) {
			$('#cari_no_kartu').val(''+suggestion.no_kartu);
		}
	});
	$('.auto_search_by_noidentitas').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_pasien_by_noidentitas',
		onSelect: function (suggestion) {
			$('#cari_no_identitas').val(''+suggestion.no_identitas);
		}
	});
	$('.auto_search_poli').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_poli',
		onSelect: function (suggestion) {
			$('#id_poli').val(''+suggestion.id_poli);
			$('#kd_ruang').val(''+suggestion.kd_ruang);
		}
	});
	
	$('.date_picker').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  

	if($('#chk1').prop('checked')==false){
	  	$('#input_tentara').hide();
	  	document.getElementById("no_nrp").required= false;
		document.getElementById("nrp_sbg").required= false;
	  }else{
	  	$('#input_tentara').show();
	  	document.getElementById("no_nrp").required= true;
		document.getElementById("nrp_sbg").required= true;
	  }

	$('#chk1').change(function() {
	 // alert($(this).prop('checked'))
	  if($(this).prop('checked')==false){
	  	$('#input_tentara').hide();
	  	document.getElementById("no_nrp").required= false;
		document.getElementById("nrp_sbg").required= false;
	  }else{
	  	$('#input_tentara').show();
	  	document.getElementById("no_nrp").required= true;
		document.getElementById("nrp_sbg").required= true;
	  }
	});

});
function pilih_cara_bayar(val_cara_bayar){

	if(val_cara_bayar=='DIJAMIN'){
		$('#input_kontraktor').show();
		$('#warn_kartu').hide();
		$('#div_sep').hide();
		document.getElementById("button_cetak_karcis").disabled= false;
		document.getElementById("id_kontraktor").required = true;
		document.getElementById("no_rujukan").required = false;
		document.getElementById("asal_rujukan").required = false;
		document.getElementById("tgl_rujukan").required = false;

		ajaxku = buatajax();
	    var url="<?php echo site_url('irj/rjcregistrasi_bpjs/data_kontraktor'); ?>";
	    url=url+"/"+val_cara_bayar;
	    url=url+"/"+Math.random();
	    ajaxku.onreadystatechange=stateChangedKontraktor;
	    ajaxku.open("GET",url,true);
	    ajaxku.send(null);

	}else if(val_cara_bayar=='BPJS'){
		$('#input_diagnosa').show();
		$('#warn_kartu').show();
		$('#input_kontraktor').show();
		document.getElementById("id_kontraktor").required = true;
		document.getElementById("button_cetak_sep").disabled = true;

		//cek no kartu
		var noBpjs = "<?php echo $data_pasien->no_kartu; ?>";	
		if(noBpjs!=''){
			document.getElementById("content_warn_kartu").innerHTML = "No. Kartu : "+noBpjs;
			//$('#content_warn_kartu').val('No. Kartu : '+noBpjs);
		}else{
			document.getElementById("content_warn_kartu").innerHTML = "Isi terlebih dahulu No. Kartu BPJS Pasien";
			//$('#content_warn_kartu').val('Isi terlebih dahulu No. Kartu BPJS Pasien');
		}
		//$('#biayadaftar_').val(0);
		//$('#biayadaftar').val(0);
		$('#div_sep').show();
		$('#div_rujukan').show();
		$('#button_cetak_karcis').hide();
		$('#button_cetak_sep').show();
		//document.getElementById("no_rujukan").required = true;
		//document.getElementById("asal_rujukan").required = true;
		//document.getElementById("tgl_rujukan").required = true;
		//document.getElementById("id_diagnosa").required = true;

		ajaxku = buatajax();
	    var url="<?php echo site_url('irj/rjcregistrasi_bpjs/data_kontraktor'); ?>";
	    url=url+"/"+val_cara_bayar;
	    url=url+"/"+Math.random();
	    ajaxku.onreadystatechange=stateChangedKontraktor;
	    ajaxku.open("GET",url,true);
	    ajaxku.send(null);

	}else{
		document.getElementById("button_cetak_karcis").disabled= false;
		$('#input_diagnosa').hide();
		$('#warn_kartu').hide();
		$('#div_sep').hide();
		$('#input_kontraktor').hide();
		$('#div_rujukan').hide();
		$('#button_cetak_sep').hide();
		$('#button_cetak_karcis').show();		
		var jns_kunj = '<?php echo $jns_kunjungan; ?>';
		/*var biayakarcis_baru = '<?php echo $biayakarcis->nilai_karcis_baru; ?>';
		var biayakarcis_lama = '<?php echo $biayakarcis->nilai_karcis_lama; ?>';
		if (jns_kunj=='BARU') {
			$('#biayadaftar_').val(biayakarcis_baru);
			$('#biayadaftar').val(biayakarcis_baru);
		} else {
			$('#biayadaftar_').val(biayakarcis_lama);
			$('#biayadaftar').val(biayakarcis_lama);
		}
		*/

		document.getElementById("id_kontraktor").required = false;
		document.getElementById("no_rujukan").required = false;
		document.getElementById("asal_rujukan").required = false;
		document.getElementById("tgl_rujukan").required = false;
		
	}
}

var ajaxku;
function ajaxkota(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi_bpjs/data_kotakab'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedKota;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_provinsi").value = res[0];
	document.getElementById("provinsi").value = res[1];
}

function set_rujukan(rujukan){
	if(rujukan=='1'){
		$('#rujukan_lainnya').show();
		document.getElementById("dll_rujukan").required = true;
	}else{
		$('#rujukan_lainnya').hide();
		document.getElementById("dll_rujukan").required = false;
	}
}

function ajaxkec(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi_bpjs/data_kecamatan'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();irj/rjcregistrasi_bpjs/pasien
    ajaxku.onreadystatechange=stateChangedKec;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_kotakabupaten").value = res[0];
	document.getElementById("kotakabupaten").value = res[1];
}

function ajaxkel(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi_bpjs/data_kelurahan'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedKel;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_kecamatan").value = res[0];
	document.getElementById("kecamatan").value = res[1];
}
function setkel(id){
	var res=id.split("-");//it Works :D
	document.getElementById("id_kelurahandesa").value = res[0];
	document.getElementById("kelurahandesa").value = res[1];
}

function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}
function stateChangedKota(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
		document.getElementById("kota").innerHTML = data;
		document.getElementById("kec").innerHTML = "<option selected value=\"\">Pilih Kecamatan</option>";
		document.getElementById("kel").innerHTML = "<option selected value=\"\">Pilih Kel/Desa</option>";
    }else{
    document.getElementById("kota").value = "<option selected value=\"\">Pilih Kota/Kab</option>";
    }
    }
}

function stateChangedKontraktor(){
    var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("id_kontraktor").innerHTML = data;
		}
    }
}

function stateChangedKec(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
    document.getElementById("kec").innerHTML = data
    }else{
    document.getElementById("kec").value = "<option selected value=\"\">Pilih Kecamatan</option>";
    }
    }
}

function stateChangedKel(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
    document.getElementById("kel").innerHTML = data
    }else{
    document.getElementById("kel").value = "<option selected value=\"\">Pilih Kelurahan/Desa</option>";
    }
    }
}

function pilih_alber(val_alber){
		var res=val_alber.split("-");//it Works :D				
		if(res=='kecelakaan'){
			$('#input_kecelakaan').show();
			document.getElementById("jenis_kecelakaan").required= true;

		}else if(res=='sakit'){
			$('#input_kecelakaan').hide();
			document.getElementById("jenis_kecelakaan").required= false;
		}else{}
	}

function ajaxdokter(id_poli){


	//var res=id.split("-");//it Works :D
	if(id_poli=='BA00')
	{
		$('#ird').show();
		$('#hubungan').show();
	}else{
		$('#ird').hide();
		$('#hubungan').hide();
	}

    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi_bpjs/data_dokter_poli'); ?>";
    url=url+"/"+id_poli;
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedDokter;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	//document.getElementById("id_provinsi").value = res[0];
	//document.getElementById("provinsi").value = res[1];
	
}
function stateChangedDokter(){
    var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("id_dokter").innerHTML = data;
		}/*else{
		document.getElementById("id_dokter").value = "<option selected value=\"\">Pilih Kota/Kab</option>";
		}*/
    }
}

function cek_validasi(no_medrec){
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcwebservice/check_no_kartu'); ?>";
    url=url+"/"+no_medrec;
    ajaxku.onreadystatechange=stateChangedValidasi;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
}
function cek_validasi_post(no_medrec){
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcwebservice/validasi_kartu'); ?>";
    url=url+"/"+no_medrec;
    ajaxku.onreadystatechange=stateChangedValidasiPost;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
}	

function cek_rujukan(){
	$('#loading-rujukan').show();
	var no_rujukan = document.getElementById("no_rujukan").value;
	var e = document.getElementById("cara_kunjungan");
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

function stateChangedValidasi(){
	var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if (data.indexOf('Tidak Ditemukan')!= -1 || data.indexOf('Masukan')!= -1) {			
			//document.getElementById("button_cetak_karcis").disabled= true;
			document.getElementById("button_cetak_sep").disabled = true;
		}
		if(data.length>=0){
			document.getElementById("data_validasi").innerHTML = data;
			$('#modal_validasi').modal('show');
			document.getElementById("button_cetak_sep").disabled = false;			

		}else{
			document.getElementById("data_validasi").innerHTML = "Data Tidak Ditemukan";			
			document.getElementById("button_cetak_sep").disabled = true;
		}
    }
}

function stateChangedValidasiPost(){
	var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		var result_validasi = JSON.parse(data);
		console.log(result_validasi);
		if (data.indexOf('Tidak Ditemukan')!= -1 || data.indexOf('Masukan')!= -1) {			
			document.getElementById("button_cetak_sep").disabled = true;
		}
		if(data.length>=0){
			// document.getElementById("data_validasi").innerHTML = data;
			var status_bpjs = result_validasi["response"].peserta.statusPeserta.keterangan;
			if (status_bpjs == 'AKTIF') {
			document.getElementById("button_cetak_sep").disabled = false;
			}		
			else {
			document.getElementById("button_cetak_sep").disabled = true;
			}

		}else{
			document.getElementById("data_validasi").innerHTML = "Data Tidak Ditemukan";			
			document.getElementById("button_cetak_sep").disabled = true;
		}
    }
}

function stateChangedValidasiRujukan(){
	var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("data_validasi").innerHTML = data;
			
		}else{
			document.getElementById("data_validasi").innerHTML = "Data Tidak Ditemukan";
		}
		if (data.indexOf('Tidak Ditemukan')!= -1 || data.indexOf('Masukan')!= -1) {	
			// $('#modal_validasi').modal('show');		
			// document.getElementById("cara_bayar" ).disabled=false;
			// document.getElementById("cara_bayar").selectedIndex = "0";
			document.getElementById("asal_rujukan" ).disabled=false;
			document.getElementById("diagnosa" ).disabled=false;
			document.getElementById("id_poli" ).disabled=false;
			document.getElementById('tgl_rujukan').value = '<?php echo date('Y-m-d');?>';
			document.getElementById("asal_rujukan").selectedIndex = "0";
			document.getElementById('id_poli').value = '';
			document.getElementById('kode_provider').value='';
			document.getElementById('tgl_rujukan').value='';
			document.getElementById('diagnosa').value='';
			document.getElementById('entri_catatan').value='';
			$('#loading-rujukan').hide();	
			swal("Cek Nomor Rujukan", "Silahkan masukkan nomor rujukan yang valid", "error");
		}
		else {
			// document.getElementById('cara_bayar').value = 'BPJS';
			// document.getElementById("cara_bayar" ).disabled=true;
			document.getElementById("asal_rujukan" ).disabled=false;
			document.getElementById("diagnosa" ).disabled=false;
			document.getElementById("id_poli" ).disabled=false;
			var data1 = JSON.parse(data);
			document.getElementById('kode_provider').value=data1["response"].item.provKunjungan.kdProvider;
			document.getElementById('tgl_rujukan').value=data1["response"].item.tglKunjungan;
			document.getElementById('diagnosa').value=data1["response"].item.diagnosa.kdDiag;
			document.getElementById('entri_catatan').value=data1["response"].item.catatan;
			var update_kartu = document.getElementById("no_kartu_bpjs").value;
			if (update_kartu.length == 0) {
			swal({
  			title: ""+data1["response"].item.peserta.nama+"",
  			type: "success",
  			text: "<p>Nomor Kartu : "+data1["response"].item.peserta.noKartu+"<p/><p>NIK : "+data1["response"].item.peserta.nik+"<p/><p>Status Peserta : "+data1["response"].item.peserta.statusPeserta+"</p>",
  			html: true,
			showCancelButton: true,
  			confirmButtonColor: "#DD6B55",
  			confirmButtonText: "Simpan Nomor Kartu",
  			closeOnConfirm: false
			},
			function(){
			update_nokartu(data1["response"].item.peserta.noKartu);
  			swal("Sukses", "Nomor kartu berhasil disimpan.", "success");
			});		  							
			}
			if (update_kartu.length > 0) {
			swal({
  			title: ""+data1["response"].item.peserta.nama+"",
  			type: "success",
  			text: "<p>Nomor Kartu : "+data1["response"].item.peserta.noKartu+"<p/><p>NIK : "+data1["response"].item.peserta.nik+"<p/><p>Status Peserta : "+data1["response"].item.peserta.statusPeserta+"</p>",
  			html: true,
  			showCancelButton: true,
  			confirmButtonColor: "#DD6B55",
  			confirmButtonText: "Update Nomor Kartu",
  			closeOnConfirm: false
			},
			function(){
			update_nokartu(data1["response"].item.peserta.noKartu);
  			swal("Sukses", "Nomor kartu berhasil diupdate.", "success");
			});				
			}			
			$('#loading-rujukan').hide();
			// swal(""+data1["response"].item.peserta.nama+"", "Nomor Kartu : "+data1["response"].item.peserta.noKartu+"", "success");	
		}
    }
}

function cek_eligible(no_medrec){
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcwebservice/check_no_kartu'); ?>";
    url=url+"/"+no_medrec;
    ajaxku.onreadystatechange=stateChangedSEP;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
}	
	
function stateChangedSEP(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("data_anggota").innerHTML = data;
			$('#data_webservice').modal('show');
		}else{
			document.getElementById("data_anggota").innerHTML = "Data Tidak Ditemukan";
		}
    }
}
	
function cek_search_per(val_search_per){
	//alert(val_search_per);
	if(val_search_per=='cm'){
		$("#cari_no_cm").css("display", ""); // To unhide
		$("#cari_no_kartu").css("display", "none");  // To hide
		$("#cari_no_identitas").css("display", "none");
	}
	else if(val_search_per=='kartu'){
		$("#cari_no_cm").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", ""); 
		$("#cari_no_identitas").css("display", "none");
	}else{
		$("#cari_no_cm").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", ""); 
		
	}
}

function cek_no_identitas(no_identitas, no_identitas_old){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi_bpjs/cek_available_noidentitas')?>/"+no_identitas+"/"+no_identitas_old,
		success: function(data){
			if (data>0) {
				document.getElementById("content_duplikat_id").innerHTML = "<i class=\"icon fa fa-ban\"></i> No Identitas \""+no_identitas+"\" Sudah Terdaftar ! <br>Silahkan masukkan no identitas lain...";
				$("#duplikat_id").show();
				document.getElementById("btn-submit").disabled= true;
				//$(window).scrollTop(0);
			} else {
				$("#duplikat_id").hide();
				document.getElementById("btn-submit").disabled= false;
			}
		},
		error: function (request, status, error) {
			alert(request.responseText);
		}
    });
}

function cek_no_kartu(no_kartu, no_kartu_old){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi_bpjs/cek_available_nokartu')?>/"+no_kartu+"/"+no_kartu_old,
		success: function(data){
			//alert(data);
			if (data>0) {
				//alert("No Kartu '"+no_kartu+"' Sudah Terdaftar ! <br> Silahkan masukkan no kartu lain...");
				document.getElementById("content_duplikat_kartu").innerHTML = "<i class=\"icon fa fa-ban\"></i> No Kartu \""+no_kartu+"\" Sudah Terdaftar ! Silahkan masukkan no kartu lain...";
				$("#duplikat_kartu").show();
				document.getElementById("btn-submit").disabled= true;
			} else {
				$("#duplikat_kartu").hide();
				document.getElementById("btn-submit").disabled= false;
			}
		},
		error: function (request, status, error) {
			alert(request.responseText);
		}
    });
}

function cek_no_nrp(no_nrp, no_nrp_old){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi_bpjs/cek_available_nonrp')?>/"+no_nrp+"/"+no_nrp_old,
		success: function(data){
			//alert(data);
			if (data>0) {
				//alert("No Kartu '"+no_kartu+"' Sudah Terdaftar ! <br> Silahkan masukkan no kartu lain...");
				document.getElementById("content_duplikat_nrp").innerHTML = "<i class=\"icon fa fa-ban\"></i> No NRP \""+no_nrp+"\" Sudah Terdaftar ! Silahkan masukkan No NRP lain...";
				$("#duplikat_nrp").show();
				document.getElementById("btn-submit").disabled= true;
			} else {
				$("#duplikat_nrp").hide();
				document.getElementById("btn-submit").disabled= false;
			}
		},
		error: function (request, status, error) {
			alert(request.responseText);
		}
    });
}



function set_ident(ident){
//	alert(ident);
	if(ident!=''){
		document.getElementById("no_identitas").required= true;
 	}else
		document.getElementById("no_identitas").required= false;
}

function set_tentara(tni){
//	alert(ident);
	if(tni!='T'){
		//$("#medrecnrp").hide();
		//$("#kstpktangakat").hide();
		//document.getElementById("kesatuan").required= false;
		//document.getElementById("pangkat").required= false;
		document.getElementById("angkatan").required= false;
	}
	/*else if(tni!='0'){
		$("#medrecnrp").show();
		$("#nonrp").hide();
		document.getElementById("nonrp").required= false;
		document.getElementById("medrecnrp").required= true;
 	}*/else{
 		//$("#kstpktangakat").show();
 		//document.getElementById("kesatuan").required= true;
		//document.getElementById("pangkat").required= true;
		document.getElementById("angkatan").required= true;		
 	}
}
function update_nokartu(no_kartu) {
  var no_medrec = document.getElementById("no_medrec").value;
  if(no_medrec.length > 0 && no_kartu.length > 0){
  $.ajax({
        type: 'POST',
        url: '<?php echo base_url('irj/rjcwebservice/update_nokartu')?>',
        data: {
        no_kartu:no_kartu,
        no_medrec:no_medrec
        },
        success: function (response) {
		document.getElementById("no_kartu_bpjs").value = no_kartu;
		document.getElementById("content_warn_kartu").innerHTML = "No. Kartu : "+no_kartu;
        }
    });

return false;
}
};
</script>

<?php echo $this->session->flashdata('success_msg');?>
<?php echo $this->session->flashdata('notification');?>

<br>
<section class="content" style="width:97%;margin:0 auto">
	<?php if($data_pasien->no_nrp!='' && ($data_pasien->nrp_sbg=='' || $data_pasien->nrp_sbg==null)){ 
	echo "
		<div class=\"alert alert-danger alert-dismissable\">
			<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>
				<h7>
					<i class=\"icon fa fa-ban\"></i>
						KELENGKAPAN DATA TENTARA/TNI BELUM DIISI. SILAHKAN ISI DATA JENIS TENTARA & ANGKATAN.	
			</h7>
		</div>";
 } ?>
	<div class="row">
		
		<ul class="nav nav-tabs my-tab nav-justified">
			<li class="active"><a data-toggle="tab" href="#biodata" ><h4>BIODATA</h4></a></li>
			<li class="" ><a data-toggle="tab" href="#daftar_ulang" ><h4>DAFTAR ULANG PASIEN IRJ</h4></a></li>
		</ul>		
		<div class="tab-content">
			<div id="biodata" class="tab-pane fade in active">	
		  
				<div class="panel panel-info">
					<div class="panel-body">
					<br>
					<div class="col-sm-12">
							<?php
								$no_medrec=$data_pasien->no_medrec;
								if($data_pasien->foto!=''){
									$foto=$data_pasien->foto;
								}else $foto="unknown.png";
							?>
							<div class="form-group row">
								<div class="col-sm-12">
									<center>
										<img height="150px" class="img-rounded" src="<?php echo base_url("upload/photo/".$foto);?>"><br>
									<?php echo form_open_multipart('irj/rjcregistrasi_bpjs/cetak_kartu_pasien');?>
										<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec" id="no_medrec">
										<input type="hidden" class="form-control" value="<?php echo $data_pasien->no_cm;?>" name="cetak_kartu" id="cetak_kartu">
										<button type="submit" class="btn btn-primary" id="btn-submit">Cetak Kartu</button>
									<?php echo form_close();?>
										<?php $url=site_url('irj/rjcregistrasi_bpjs/cetak_identitas/').'/'.$data_pasien->no_cm; ?>
										<br>
										<a href="<?php echo $url ?>" target="_blank" class="btn btn-danger" type="button">Cetak Identitas</a>
										<br>
									</center>

								</div>
							</div>
								
							<?php echo form_open_multipart('irj/rjcregistrasi_bpjs/update_data_pasien');?>
								<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_cm" readonly>
								<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="no_cm">No MR</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_cm;?>" name="cm_baru" readonly>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="tgl_daftar">Tanggal Daftar</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->tgl_daftar;?>" name="tgl_daftar" readonly>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="nama">Nama Lengkap *</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->nama;?>" name="nama" id="nama_pasien" required>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="sex">Jenis Kelamin *</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<?php 
													if($data_pasien->sex=='L'){
														echo '<input type="radio" name="sex" value="L" checked required>&nbsp;Laki-Laki&nbsp;&nbsp;&nbsp;
														<input type="radio" name="sex" value="P">&nbsp;Perempuan';
													}else{
														echo '<input type="radio" name="sex" value="L" required>&nbsp;Laki-Laki&nbsp;&nbsp;&nbsp;
														<input type="radio" name="sex" value="P" checked>&nbsp;Perempuan';
													}
												?>
											</div>
										</div>
									</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" >Pilih Identitas</p>
									<div class="col-sm-8">
										<div class="form-inline">
												<select class="form-control" style="width: 100%" name="jenis_identitas" id="jenis_identitas" onchange="set_ident(this.value)">
													<option value="">-Pilih Identitas-</option>
													<option <?php if($data_pasien->jenis_identitas=='KTP') echo 'selected';?> value="KTP">KTP</option>
													<option <?php if($data_pasien->jenis_identitas=='SIM') echo 'selected';?> value="SIM">SIM</option>
													<option <?php if($data_pasien->jenis_identitas=='PASPOR') echo 'selected';?> value="PASPOR">Paspor</option>
													<option <?php if($data_pasien->jenis_identitas=='KTM') echo 'selected';?> value="KTM">KTM</option>
													<option <?php if($data_pasien->jenis_identitas=='NIK') echo 'selected';?> value="NIK">NIK</option>
													<option <?php if($data_pasien->jenis_identitas=='DLL') echo 'selected';?> value="DLL">Lainnya</option>
												</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" >No. Identitas</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_identitas;?>" name="no_identitas"  id="no_identitas" onchange="cek_no_identitas(this.value,'<?php echo $data_pasien->no_identitas; ?>')">
									</div>
								</div>
								<div class="form-group row" id="duplikat_id">
									<p class="col-sm-3 form-control-label"></p>
									<div class="col-sm-8">
										<p class="form-control-label" id="content_duplikat_id" style="color: red;"></p>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="no_kartu">No. Kartu Keluarga</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_kk;?>" name="no_kk" id="no_kk">
									</div>
								</div>

								<hr>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="jenis_kartu">Anggota Tentara</p>
									<div class="col-sm-8">
										<div class="form-inline">
												<div class="checkbox">
												  <label><input type="checkbox" value="ya" name="chk1" id="chk1" <?php if($data_pasien->no_nrp!='' ) echo 'checked';?> >&nbsp;&nbsp;Ya</label>
												</div>
											
										</div>
									</div>
								</div>
								
								<div id="input_tentara">
									<div class="form-group row" id="inputtentara">
										<p class="col-sm-3 form-control-label">Tentara</p>
										<div class="col-sm-8">
											<select name="nrp_sbg" id="nrp_sbg" class="form-control select2" style="width: 100%" onchange="set_tentara(this.value)">
												<option value="">-Pilih Jenis-</option>
														<?php 
												foreach($hubungan as $row){	
												echo '<option '; if($data_pasien->nrp_sbg==$row->hub_id) echo 'selected '; echo 'value="'.$row->hub_id.'">'.$row->hub_name.'</option>';
												}
												?>
														
											</select>
											
											
										</div>
									</div>
									<div class="form-group row" >
										<p class="col-sm-3 form-control-label"></p>
										<div class="col-sm-8">
											<input type="search" class="form-control" id="no_nrp" name="no_nrp" placeholder="Pencarian NRP/NIP Anggota" value="<?php echo $data_pasien->no_nrp; ?>">
											<!--<input type="text" class="form-control" value="<?php echo $data_pasien->no_nrp;?>" name="no_nrp" id="no_nrp" placeholder="Nomor NRP" onchange="cek_no_nrp(this.value,'<?php echo $data_pasien->no_nrp; ?>')">-->
										</div>
									</div>
									<div class="form-group row" id="duplikat_nrp">
										<p class="col-sm-3 form-control-label"></p>
										<div class="col-sm-8">
											<p class="form-control-label" id="content_duplikat_nrp" style="color: red;"></p>
										</div>
									</div>	
									<div id="kstpktangakat">
									<div class="form-group row" >
										<p class="col-sm-3 form-control-label">Kesatuan</p>
										<div class="col-sm-8">
											<select name="kesatuan" id="kesatuan" class="form-control select2" style="width: 100%" >
												<option value="">-Pilih Kesatuan-</option>
												<?php 
												foreach($kesatuan as $row){												
												echo '<option '; if($data_pasien->kst_id==$row->kst_id) echo 'selected '; echo 'value="'.$row->kst_id.'">'.$row->kst_nama.'</option>';
												}
												?>
														
											</select>
											
											
										</div>
									</div>
									<div class="form-group row" >
										<p class="col-sm-3 form-control-label">Pangkat</p>
										<div class="col-sm-8">
											<select name="pangkat" id="pangkat" class="form-control select2" style="width: 100%" >
												<option value="">-Pilih Pangkat-</option>
												<?php 
												foreach($pangkat as $row){												
												echo '<option '; if($data_pasien->pkt_id==$row->pangkat_id) echo 'selected '; echo 'value="'.$row->pangkat_id.'">'.$row->pangkat.'</option>';
												}
												?>
														
											</select>
											
											
										</div>
									</div>
									<div class="form-group row" >
										<p class="col-sm-3 form-control-label">Angkatan</p>
										<div class="col-sm-8">
											<select name="angkatan" id="angkatan" class="form-control select2" style="width: 100%" >
												<option value="">-Pilih Angkatan-</option>
												<?php 
												foreach($angkatan as $row){
												echo '<option '; if($data_pasien->angkatan_id==$row->tni_id) echo 'selected '; echo 'value="'.$row->tni_id.'">'.$row->angkatan.'</option>';
												}
												?>
														
											</select>											
										</div>
									</div>
									<div class="form-group row">
										<p class="col-sm-3 form-control-label" id="tgl_nonaktif">Tanggal Non-aktif</p>
										<div class="col-sm-8">
											<input type="text" class="form-control date_picker" id="date_picker" placeholder="yyyy-mm-dd" name="tgl_nonaktif">
										</div>
									</div>		
									</div>						
								</div>
								<hr>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="no_kartu">No. Kartu BPJS</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_kartu;?>" name="no_kartu" id="no_kartu_bpjs" onchange="cek_no_kartu(this.value,'<?php echo $data_pasien->no_kartu; ?>')">
									</div>
								</div>
								<div class="form-group row" id="duplikat_kartu">
									<p class="col-sm-3 form-control-label"></p>
									<div class="col-sm-8">
										<p class="form-control-label" id="content_duplikat_kartu" style="color: red;"></p>
									</div>
								</div>
							
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="tmpt_lahir">Tempat Lahir *</p>
									<div class="col-sm-8">
										<input type="text" class="form-control"  value="<?php echo $data_pasien->tmpt_lahir;?>" name="tmpt_lahir" required>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="tgl_lahir">Tanggal Lahir *</p>
									<div class="col-sm-8">
										<input type="text" class="form-control date_picker" value="<?php echo date('Y-m-d',strtotime($data_pasien->tgl_lahir));?>" name="tgl_lahir" required>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="agama">Agama</p>
									<div class="col-sm-8">
										<div class="form-inline">
												<select class="form-control" style="width: 100%" name="agama">
													<option value="">-Pilih Agama-</option>
													<option <?php if($data_pasien->agama=='ISLAM') echo 'selected';?> value="ISLAM">Islam</option>
													<option <?php if($data_pasien->agama=='KATOLIK') echo 'selected';?> value="KATOLIK">Katolik</option>
													<option <?php if($data_pasien->agama=='PROTESTAN') echo 'selected';?> value="PROTESTAN">Protestan</option>
													<option <?php if($data_pasien->agama=='BUDHA') echo 'selected';?> value="BUDHA">Budha</option>
													<option <?php if($data_pasien->agama=='HINDU') echo 'selected';?> value="HINDU">Hindu</option>
													<option <?php if($data_pasien->agama=='KONGHUCU') echo 'selected';?> value="KONGHUCU">Konghucu</option>
												</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="status">Status</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<?php 
													if($data_pasien->status=='B'){
														echo '<input type="radio" name="status" value="B" checked required>&nbsp;Belum Kawin&nbsp;&nbsp;&nbsp;
														<input type="radio" name="status" value="K">&nbsp;Sudah Kawin';
													}else{
														echo '<input type="radio" name="status" value="B" required>&nbsp;Belum Kawin&nbsp;&nbsp;&nbsp;
														<input type="radio" name="status" value="K" checked>&nbsp;Sudah Kawin';
													}
												?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="goldarah">Golongan Darah</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<select class="form-control" style="width: 100%" name="goldarah">
												<option value="">-Pilih Golongan Darah-</option>
												<option <?php if($data_pasien->goldarah=='A+') echo 'selected';?> value="A+">A+</option>
												<option <?php if($data_pasien->goldarah=='A-') echo 'selected';?> value="A-">A-</option>
												<option <?php if($data_pasien->goldarah=='B+') echo 'selected';?> value="B+">B+</option>
												<option <?php if($data_pasien->goldarah=='B-') echo 'selected';?> value="B-">B-</option>
												<option <?php if($data_pasien->goldarah=='AB+') echo 'selected';?> value="AB+">AB+</option>
												<option <?php if($data_pasien->goldarah=='AB-') echo 'selected';?> value="AB-">AB-</option>
												<option <?php if($data_pasien->goldarah=='O+') echo 'selected';?> value="O+">O+</option>
												<option <?php if($data_pasien->goldarah=='O-') echo 'selected';?> value="O-">O-</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="wnegara">Kewarganegaraan</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<select class="form-control" style="width: 100%" name="wnegara">
												<?php if($data_pasien->wnegara=='WNI'){
													echo '<option value="WNI" selected>WNI</option><option value="WNA">WNA</option>';
												}else{
													echo '<option value="WNI">WNI</option><option value="WNA" selected>WNA</option>';
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="alamat">Alamat</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->alamat;?>" name="alamat">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="rt_rw">RT - RW</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<input type="text" size="4" class="form-control" value="<?php echo $data_pasien->rt;?>" name="rt"> - 
											<input type="text" size="4" class="form-control" value="<?php echo $data_pasien->rw;?>" name="rw">
										</div>
									</div>
								</div>
								<div class="form-group row">
								<!--- -->
									<p class="col-sm-3 form-control-label" id="lbl_provinsi">Provinsi</p>
									<div class="col-sm-8">
										<div class="form-inline">
												<select id="prop" class="form-control select2" style="width: 100%" onchange="ajaxkota(this.value)">
													<option value="">-Pilih Provinsi-</option>
													<?php 
													foreach($prop as $row1){
														echo '<option '; if($data_pasien->id_provinsi==$row1->id) echo 'selected '; echo 'value="'.$row1->id.'-'.$row1->nama.'">'.$row1->nama.'</option>';
													}
													?>
												</select>
												<input type="hidden" class="form-control" id="provinsi" placeholder="" value="<?php echo $data_pasien->provinsi;?>" name="provinsi">
												<input type="hidden" class="form-control" id="id_provinsi" placeholder="" value="<?php echo $data_pasien->id_provinsi;?>" name="id_provinsi">
											
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="lbl_kotakabupaten">Kota/Kabupaten</p>
									<div class="col-sm-8">
										<div class="form-inline">
												<select id="kota" class="form-control select2" style="width: 100%" onchange="ajaxkec(this.value)">
													<?php 
													echo '<option value="'.$data_pasien->id_kotakabupaten.'-'.$data_pasien->kotakabupaten.'">'.$data_pasien->kotakabupaten.'</option>';?>
													<option value="">-Pilih Kota/Kabupaten-</option>
												</select>
												<input type="hidden" class="form-control" id="kotakabupaten" value="<?php echo $data_pasien->kotakabupaten;?>" name="kotakabupaten">
												<input type="hidden" class="form-control" id="id_kotakabupaten" value="<?php echo $data_pasien->id_kotakabupaten;?>" placeholder="" name="id_kotakabupaten">
											
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="lbl_kecamatan">Kecamatan</p>
									<div class="col-sm-8">
										<div class="form-inline">
												<select id="kec" class="form-control select2" style="width: 100%" onchange="ajaxkel(this.value)">
													<?php echo '<option value="'.$data_pasien->id_kecamatan.'-'.$data_pasien->kecamatan.'">'.$data_pasien->kecamatan.'</option>';?>
													<option value="">-Pilih Kecamatan-</option>
												</select>
												<input type="hidden" class="form-control" id="kecamatan" value="<?php echo $data_pasien->kecamatan;?>" name="kecamatan">
												<input type="hidden" class="form-control" id="id_kecamatan" value="<?php echo $data_pasien->id_kecamatan;?>" placeholder="" name="id_kecamatan">
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="lbl_kelurahandesa">Kelurahan</p>
									<div class="col-sm-8">
										<div class="form-inline">
												<select id="kel" class="form-control select2" style="width: 100%" onchange="setkel(this.value)">
													<?php echo '<option value="'.$data_pasien->id_kelurahandesa.'-'.$data_pasien->kelurahandesa.'">'.$data_pasien->kelurahandesa.'</option>';?>
													<option value="">-Pilih Kelurahan/Desa-</option>
												</select>
												<input type="hidden" class="form-control" id="kelurahandesa" value="<?php echo $data_pasien->kelurahandesa;?>" name="kelurahandesa">
												<input type="hidden" class="form-control" id="id_kelurahandesa" value="<?php echo $data_pasien->id_kelurahandesa;?>" placeholder="" name="id_kelurahandesa">
											
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="kodepos">Kode Pos</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->kodepos;?>" name="kodepos">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="pendidikan">Pendidikan</p>
									<div class="col-sm-8">
										<div class="form-inline">
												<select class="form-control" style="width: 100%" name="pendidikan">
													<option value="">-Pilih Pendidikan Terakhir-</option>
													<option <?php if($data_pasien->pendidikan=='SD') echo 'selected';?> value="SD">SD</option>
													<option <?php if($data_pasien->pendidikan=='SMP') echo 'selected';?> value="SMP">SMP</option>
													<option <?php if($data_pasien->pendidikan=='SMA') echo 'selected';?> value="SMA">SMA</option>
													<option <?php if($data_pasien->pendidikan=='D1') echo 'selected';?> value="D1">D1</option>
													<option <?php if($data_pasien->pendidikan=='D2') echo 'selected';?> value="D2">D2</option>
													<option <?php if($data_pasien->pendidikan=='D3') echo 'selected';?> value="D3">D3</option>
													<option <?php if($data_pasien->pendidikan=='D4') echo 'selected';?> value="D4">D4</option>
													<option <?php if($data_pasien->pendidikan=='S1') echo 'selected';?> value="S1">S1</option>
													<option <?php if($data_pasien->pendidikan=='S2') echo 'selected';?> value="S2">S2</option>
													<option <?php if($data_pasien->pendidikan=='S3') echo 'selected';?> value="S3">S3</option>
												</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="pekerjaan">Pekerjaan</p>
									<div class="col-sm-8">
										<select class="form-control" style="width: 100%" name="pekerjaan">
													<option value="">-Pilih Pekerjaan Terakhir-</option>
													<option <?php if($data_pasien->pekerjaan=='HONOR') echo 'selected';?> value="HONOR">HONOR</option>
													<option <?php if($data_pasien->pekerjaan=='MAHASISWA') echo 'selected';?> value="MAHASISWA">MAHASISWA</option>
													<option <?php if($data_pasien->pekerjaan=='MARINIR') echo 'selected';?> value="MARINIR">MARINIR</option>
													<option <?php if($data_pasien->pekerjaan=='PELAJAR') echo 'selected';?> value="PELAJAR">PELAJAR</option>
													<option <?php if($data_pasien->pekerjaan=='PENSIUNAN AL') echo 'selected';?> value="PENSIUNAN AL">PENSIUNAN AL</option>
													<option <?php if($data_pasien->pekerjaan=='PENSIUNAN NON AL') echo 'selected';?> value="PENSIUNAN NON AL">PENSIUNAN NON AL</option>
													<option <?php if($data_pasien->pekerjaan=='POLISI') echo 'selected';?> value="POLISI">POLISI</option>
													<option <?php if($data_pasien->pekerjaan=='PURNAWIRAWAN AL') echo 'selected';?> value="PURNAWIRAWAN AL">PURNAWIRAWAN AL</option>
													<option <?php if($data_pasien->pekerjaan=='PURNAWIRAWAN NON AL') echo 'selected';?> value="PURNAWIRAWAN NON AL">PURNAWIRAWAN NON AL</option>
													<option <?php if($data_pasien->pekerjaan=='SWASTA') echo 'selected';?> value="SWASTA">SWASTA</option>
													<option <?php if($data_pasien->pekerjaan=='TNI AL') echo 'selected';?> value="TNI AL">TNI AL</option>
													<option <?php if($data_pasien->pekerjaan=='TNI NON AL') echo 'selected';?> value="TNI NON AL">TNI NON AL</option>
													<option <?php if($data_pasien->pekerjaan=='PNS NON AL') echo 'selected';?> value="PNS NON AL">PNS NON AL</option>
													<option <?php if($data_pasien->pekerjaan=='PNS AL') echo 'selected';?> value="PNS AL">PNS AL</option>
													<option <?php if($data_pasien->pekerjaan=='TIDAK ADA') echo 'selected';?> value="TIDAK ADA">TIDAK ADA</option>
													<option <?php if($data_pasien->pekerjaan=='LAINNYA') echo 'selected';?> value="LAINNYA">LAINNYA</option>
												</select>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="no_telp">No. Telp</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_telp;?>" maxlength="12" name="no_telp">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="no_hp">No. HP</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_hp;?>" maxlength="12" name="no_hp">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="no_telp_kantor">No. Telp Kantor</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_telp_kantor;?>" maxlength="12" name="no_telp_kantor">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="email">Email</p>
									<div class="col-sm-8">
										<input type="email" class="form-control" value="<?php echo $data_pasien->email;?>" name="email">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="nama_ibu_istri">Nama Ibu Kandung</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->nm_ibu_istri;?>" name="nm_ibu_istri">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="foto">Update Foto</p>
									<div class="col-sm-8">										
										<div class="input-group">
											<input type="file" name="userfile" accept="image/jpeg, image/png, image/gif">
											<input type="text" class="form-control filefield browse" readonly="" value="" />
											<span class="input-group-btn">
												<button class="btn btn-info btn-flat" type="button" id="browseBtn">Browse</button>
											</span>
										</div>
									</div>
								</div>
								<div class="form-inline" align="center">
									<div class="form-group">										
										<button type="reset" class="btn bg-orange">Reset</button>
										<button type="submit" class="btn btn-primary" id="btn-submit">Simpan</button>
										<!--<a href="#" class="btn btn-primary">Cetak Kartu</a>-->
									</div>
								</div>
							<?php echo form_close();?>
						</div><!-- end div col-sm-6-->
					</div><!-- end panel body -->
				</div><!-- end panel info-->
			</div><!-- end div id home -->

<!-------------------------------------------------------------------------------------------------------------------------->			
		
			<div id="daftar_ulang" class="tab-pane fade in">	
		  
				<div class="panel panel-info">
					<div class="panel-body">
					<br>
							<?php echo form_open('irj/rjcregistrasi_bpjs/insert_daftar_ulang'); ?>
							<input type="hidden" value="<?php echo $data_pasien->no_kartu;?>" name="no_kartu">
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="jns_kunj">Jenis Kunjungan</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
												<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
												<?php echo ($jns_kunjungan == "LAMA" ? 
												
													'
													<input type="radio" name="jns_kunj" class="jns_kunj" value="LAMA" checked>&nbsp;Lama
													&nbsp;&nbsp;&nbsp;
													<input type="radio" name="jns_kunj" class="jns_kunj" value="BARU">&nbsp;Baru
									
													<input type="hidden" name="jns_kunj" value="'.$jns_kunjungan.'">
													'
												:
												
													'
													<input type="radio" name="jns_kunj" class="jns_kunj" value="LAMA">&nbsp;Lama
													&nbsp;&nbsp;&nbsp;
													<input type="radio" name="jns_kunj" class="jns_kunj" value="BARU" checked>&nbsp;Baru
													
													<input type="hidden" name="jns_kunj" value="'.$jns_kunjungan.'">
													'
												);
												?>
												
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label">Tanggal Kunjungan</p>
									<div class="col-sm-4">
										<input type="text" class="form-control date_picker" name="tgl_kunjungan" value="<?php echo date('Y-m-d');?>">
									</div>
								</div>
								<div class="form-group row">
								<!----------------- ---->
									<p class="col-sm-2 form-control-label" >Cara Kunjungan *</p>
									<div class="col-sm-4">
												<select id="cara_kunjungan" class="form-control" style="width: 100%" name="cara_kunj" required>
													<option value="">-Pilih Cara Kunjungan-</option>
													<?php 
													foreach($cara_berkunjung as $row){
														echo '<option value="'.$row->cara_kunj.'">'.$row->cara_kunj.'</option>';
													}
													?>
												</select>
									</div>
								</div>
								<div class="form-group row">
								<!----------------- ---->
									<p class="col-sm-2 form-control-label" id="lbl_cara_bayar">Cara Bayar *</p>
									<div class="col-sm-4">
										<div class="form-inline">
												<select id="cara_bayar" class="form-control" style="width: 100%" name="cara_bayar" onchange="pilih_cara_bayar(this.value)" required>
													<option value="">-Pilih Cara Bayar-</option>
													<?php
													foreach($cara_bayar as $row){
														echo '<option value="'.$row->cara_bayar.'">'.$row->cara_bayar.'</option>';
													}
													?>
												</select>		
											
										</div>
									</div>
									<div class="col-sm-1" id="div_sep">
									<a href="#" class="btn btn-danger" onclick="cek_validasi('<?php echo $no_medrec;?>')">Cek Validasi</a>
									</div>
								</div>
								
								<div class="form-group row" id="input_kontraktor">
									<p class="col-sm-2 form-control-label" id="lbl_input_kontraktor">Dijamin Oleh</p>
									<div class="col-sm-4">
										<div class="form-inline">
												<select id="id_kontraktor" class="form-control select2" style="width: 100%" name="id_kontraktor">
													<option value="">-Pilih Penjamin-</option>
													
												</select>
										</div>
									</div>
								</div>
								<div class="form-group row" id="warn_kartu">
									<p class="col-sm-2 form-control-label"></p>
									<div class="col-sm-4">
										<p class="" id="content_warn_kartu" style="color: red;"></p>
										<p class="" id="status_aktif_bpjs" style="color: red;"></p>

									</div>
									
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label">Asal Rujukan</p>
									<div class="col-sm-4">
												<select id="asal_rujukan" class="form-control select2" style="width: 100%" name="asal_rujukan" onchange="set_rujukan(this.value)">
													<option value="">-Pilih Asal Rujukan-</option>
													<option value="1">Lainnya</option>
													<?php 
													foreach($ppk as $row){
														echo '<option value="'.$row->kd_ppk.'">'.$row->nm_ppk.'</option>';
													}
													?>
												</select>
									</div>
								</div>
								<div class="form-group row" id="rujukan_lainnya">
									<p class="col-sm-2 form-control-label"></p>
									<div class="col-sm-4">
										<input type="text" class="form-control" placeholder="Nama Tempat Rujukan" name="dll_rujukan" id="dll_rujukan">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label">No. SJP/Rujukan</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" placeholder="" name="no_rujukan" id="no_rujukan">
									</div>
									<div class="col-sm-1" id="div_rujukan">
									<!-- <a href="javascript:void(0)" class="btn btn-danger" onclick="cek_rujukan()">Cek Nomor Rujukan</a> -->
									<a href="javascript:void(0)" class="btn btn-danger" onclick="cek_rujukan()"><i class="fa fa-spinner fa-spin" id="loading-rujukan"></i> Cek Nomor Rujukan</a>
									</div>									
								</div>								
								<div class="form-group row">
									<p class="col-sm-2 form-control-label">Tgl. Rujukan</p>
									<div class="col-sm-4">
										<input type="text" class="form-control date_picker" placeholder="" id="tgl_rujukan" name="tgl_rujukan">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="kelas_pasien">Kelas Pasien</p>
									<div class="col-sm-4">
										<div class="form-inline">
												<select class="form-control" style="width: 100%" name="kelas_pasien2" required disabled>
													<!--<option value="">-Pilih Kelas-</option>-->
													<?php 
													foreach($kelas as $row){
														$string = "";
														if($row->kelas == "III") $string = "SELECTED"; 

														echo '<option value="'.$row->kelas.'" '.$string.'>'.$row->kelas.'</option>';
													}
													?>
												</select>
												<input type="hidden" name="kelas_pasien" value="III"/>
										</div>
									
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="dirujuk_ke">Tujuan Poliklinik*</p>
									<div class="col-sm-4">
										<div class="form-inline">
												<select id="id_poli" class="form-control select2" style="width: 100%" name="id_poli"  onchange="ajaxdokter(this.value)" required>
													<option value="">-Pilih Nama Poli-</option>
													<?php 
													foreach($poli as $row){
														echo '<option value="'.$row->id_poli.'">'.$row->nm_poli.'</option>';
													}
													?>
												</select>
										</div>
									</div>
								</div>

								<div id="ird">
									<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="alber">Alasan Berobat</p >
											<div class="col-sm-4">
											<select class="form-control" name="alber" onchange="pilih_alber(this.value)" required>
												<option value="sakit">Sakit</option>
												<option value="kecelakaan">Kecelakaan</option>
												<option value="lahir">Melahirkan</option>
											</select></div>
									</div>
									
									<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="pasdatDg">Datang dengan</p>
										<div class="col-sm-4"><select class="form-control" name="pasdatDg" required>
											<option value="klg">Keluarga</option>
											<option value="ttg">Tetangga</option>
											<option value="lain">Lain-lain</option>
										</select></div>
									</div>								
									<div class="form-group row" id="input_kecelakaan">
										<p class="col-sm-2 form-control-label" id="Kclkaan">Kecelakaan</p>
										<div class="col-sm-4">
											<select  class="form-control select2" name="jenis_kecelakaan" id="jenis_kecelakaan" style="width:100%;">
														<option value="">-Pilih Jenis Kecelakaan-</option>
														<?php
														foreach($kecelakaan as $row){
															echo '<option value="'.$row->id.'">'.$row->nm_kecelakaan.'</option>';
														}
														?>
													</select>
											<input type="text" class="form-control" placeholder="Lokasi Kecelakaan" name="lokasi_kecelakaan" >
										</div>
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="dokter">Dokter *</p>
									<div class="col-sm-4">
										<div class="form-inline">
												<select id="id_dokter" class="form-control select2" style="width: 100%" name="id_dokter" required>
													<option value="">-Pilih Dokter-</option>
													<?php 
													foreach($dokter as $row){
														echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
													}
													?>
												</select>
										</div>
									</div>
								</div>
								
								<div class="form-group row" id="input_diagnosa">
									<p class="col-sm-2 form-control-label" id="lbl_input_diagnosa">Diagnosa</p>
									<div class="col-sm-8">
										
										<input type="text" class="form-control input-sm auto_diagnosa_pasien"  name="diagnosa" id="diagnosa" style="width:300px;font-size:15px;">
										<input type="hidden" class="form-control " name="id_diagnosa" id="id_diagnosa" >
									</div>
								</div>
								<!--<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_biayadaftar">Biaya Daftar</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" placeholder="" name="biayadaftar_" id="biayadaftar_" 
											value="<?php //echo($jns_kunjungan == 'BARU' ? $biayakarcis->nilai_karcis_baru : $biayakarcis->nilai_karcis_lama) ?>" disabled>
										<input type="hidden" class="form-control" placeholder="" name="biayadaftar" id="biayadaftar" 
											value="<?php //echo($jns_kunjungan == 'BARU' ? $biayakarcis->nilai_karcis_baru : $biayakarcis->nilai_karcis_lama) ?>">
									</div>
								</div>
								-->
								<!-- <div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nama_penjamin">Nama Penjamin</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" placeholder="" name="nama_penjamin">
									</div>
								</div> -->
								<div class="form-group row" id="hubungan">
									<p class="col-sm-2 form-control-label" >Hubungan</p>
									<div class="col-sm-4">
										<div class="form-inline">
												<select class="form-control" style="width: 100%" name="hubungan">
													<option value="">-Pilih Hubungan-</option>
													<option value="Ybs.">Ybs.</option>
													<option value="Istri">Istri</option>
													<option value="Suami">Suami</option>
													<option value="Anak">Anak</option>
												</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nama_penjamin">Catatan</p>
									<div class="col-sm-4">
									<textarea class="form-control" name="entri_catatan" id="entri_catatan" cols="30" rows="5" style="resize:vertical"></textarea>
									</div>
								</div>									
								<!--<div class="form-group row">
									<p class="col-sm-2 form-control-label" >No SEP</p>
									<div class="col-sm-4">
										<div class="input-group">
											
											<input type="text" class="form-control" name="no_sepa" id="no_sep" disabled value="">
											<span class="input-group-btn">
											<button type="button" class="btn btn-primary btn-sm" onclick="ambil_sep()"><i class="fa fa-save"></i> Ambil SEP</button>			</span>
										</div>
									</div>
								</div>-->
								<div class="form-group row">
									<div class="col-sm-4">
									<label class="checkbox-inline">
												<input type="checkbox" value="1" name="cetak_kartu" id="cetak_kartu" <?php if($jns_kunjungan == "BARU") echo 'checked ';?> /> Cetak Kartu
											 <span></span>
										</label>
										<input type="hidden" class="form-control" value="<?php echo $data_pasien->no_cm;?>" name="cetak_kartu1" id="cetak_kartu1">
									</div>
								</div>	
								<input type="hidden" value="" id="kode_provider" name="kode_provider">							
								<input type="hidden" class="form-control" value="<?php echo $data_pasien->no_nrp;?>" name="hidden_nrpdaful" id="hidden_nrpdaful" >
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nama_penjamin"></p>
									<div class="col-sm-4 text-right">
								<button type="reset" class="btn bg-orange">Reset</button>
								<!--<button type="#" class="btn btn-primary">Simpan</button>-->
								<button type="submit" class="btn btn-primary" id="button_cetak_karcis">Simpan</button>
							<button type="submit" class="btn btn-danger" id="button_cetak_sep" title="I am tooltip"><i class="fa fa-print"></i> Simpan & Cetak SEP</button>
									</div>
								</div>
							<?php echo form_close();
							?>
							</div>
					</div><!--- end panel body-->
				</div><!--- end panel -->
			</div><!--- end col -->
		</div><!--- end row -->
	</section>
<!--- Modal Web Service -->
<div class="modal fade" id="data_webservice" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Data</h4>
      </div>
      <div class="modal-body">
			<div id="data_anggota"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>	
<!--- Modal -->

<!--- Modal Validasi -->
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


<!--- Modal -->
	
	
<?php
	$this->load->view('layout/footer.php');
?>
