<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(function(){
	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({      	
      	radioClass: 'iradio_flat-green'
    	});
	$("#jns_kunj").attr("disabled", "disabled");
	$(".select2").select2();

	$('#cek_sep').hide();
	$("#duplikat_id").hide();
	$("#duplikat_kartu").hide();
	$('#warn_kartu').hide();
	$('#input_kontraktor').hide();
	$('#input_kecelakaan').hide();
	$('#rujukan_lainnya').hide();

	$("#biayadaftar_").maskMoney({thousands:',', decimal:'.', affixesStay: true});

	var aaa = "<?php echo $id_kontraktor1; ?>";	
		if(aaa!=''){
		$("#asuransi1").val(aaa).change();
		}

	var aab = "<?php echo $id_kontraktor2; ?>";
		if(aab!=''){
		$("#asuransi2").val(aab).change();
		}

	var goldarah = "<?php echo $goldarah; ?>";
		if(goldarah!=''){
		$("#goldarah").val(goldarah).change();
		}

	var agama = "<?php echo $agama; ?>";
		if(agama!=''){
		$("#agama").val(agama).change();
		}

	var pendidikan = "<?php echo $pendidikan; ?>";
		if(pendidikan!=''){
		$("#pendidikan").val(pendidikan).change();
		}

	var prov = "<?php echo $id_provinsi; ?>";
	
		if(prov!='-'){
		$("#prov").val(prov).trigger("change")
		}

	var kota = "<?php echo $id_kabupaten; ?>";
			if(kota!=''){
	$("#kota").val(kota);	
	}
	var kec = "<?php echo $id_kecamatan; ?>";
			if(kec!='-'){
				$("#kec").val(kec);			
			}

	var kel = "<?php echo $id_kelurahan; ?>";
			if(kel!='-'){
				$("#kel").val(kel);
			}

	var ident = "<?php echo $jenis_identitas; ?>";
		if(ident!='-'){
		$("#ident").val(ident).change();
		}

	$("#asuransi1").on("change", function(e) {
	    
		var as1= $(this).val(); 
		if(as1!='0'){
			$("#no_asuransi1").prop('required',true);
		}else{
			$("#no_asuransi1").prop('required',false);
		}
	});
	
	
	$("#asuransi2").on("change", function(e) {
		var as1= $(this).val(); 
		if(as1!='0'){
			$("#no_asuransi2").prop('required',true);
		}else{
			$("#no_asuransi2").prop('required',false);
		}
	});
	
	//$('#biayadaftar_').val(biaya1);	
	//$('#biayadaftar_').maskMoney('mask');
	//$('#biayadaftar').val(biaya1);	
	//$( "#biodataIRD" ).fadeIn( "slow" );
	//$( "#biodataDaful" ).fadeIn( "slow" );


	/*$('input').iCheck('check', function(){
	  alert('Well done, Sir');
	});*/
	//$('input').iCheck('update');
	//$('#diag').attr('required', 'required');

	
	/*$('input[id="item_lain_false').on('ifClicked', function (event) {
        //alert("You clicked 1" + this.value);
		$('#item_diag_lain').attr("disabled","disabled");
		 $('#diag').removeAttr("disabled");
		//document.getElementById("diagnosa").disabled = true;
		$('#diag').attr('required', 'required');
		$('#item_diag_lain').removeAttr("required");
    	});
	
	$('input[id="item_lain_true').on('ifClicked', function (event) {
        //alert("You clicked " + this.value);
		$('#item_diag_lain').removeAttr("disabled");
		  $('#diag').attr("disabled","disabled");
		$('#item_diag_lain').attr('required', 'required');
		$('#diag').removeAttr("required");

    	});*/

	/*$('#item_lain_true').click(function()
		{
		  $('#item_diag_lain').removeAttr("disabled");
		  $('#id_diagnosa').attr("disabled","disabled");
		});

		$('#item_lain_false').click(function()
		{
		  $('#item_diag_lain').attr("disabled","disabled");
		  $('#id_diagnosa').removeAttr("disabled");
		});*/

	$('.auto_search_by_nocm').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/ird/IrDRegistrasi/data_pasien',		
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#no_medrec').val(''+suggestion.no_medrec);
		}
	});

	$('.auto_search_by_nokartu').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/ird/IrDRegistrasi/data_pasien_by_nokartu',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#cari_no_kartu').val(''+suggestion.no_kartu);
			$('#no_cmkartu').val(''+suggestion.no_medrec);
		}
	});
	$('.auto_search_by_noidentitas').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/ird/IrDRegistrasi/data_pasien_by_noidentitas',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#cari_no_identitas').val(''+suggestion.no_identitas);
			$('#no_cmident').val(''+suggestion.no_medrec);
		}
	});
	
	$('.auto_search_poli').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/ird/IrDRegistrasi/data_poli',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#kd_kecelakaan').val(''+suggestion.nm_kecelakaan);
		}
	});
	$('.auto_search_diagnosa').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/ird/IrDRegistrasi/data_diagnosa',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#kd_diagnosa').val(''+suggestion.nama_diagnosa);
		}
	});

	$('.auto_diagnosa_pasien').autocomplete({
		serviceUrl: site+'iri/ricstatus/data_icd_1',
		onSelect: function (suggestion) {
			//$('#no_cm').val(''+suggestion.no_cm);
			$('#diag').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
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

	$('.date_picker').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  
});

var ajaxku;


function ajaxkota(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('ird/IrDRegistrasi/data_kotakab'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChanged;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_provinsi").value = res[0];
	document.getElementById("provinsi").value = res[1];
	
}



function ajaxkec(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('ird/IrDRegistrasi/data_kecamatan'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedKec;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_kotakabupaten").value = res[0];
	document.getElementById("kotakabupaten").value = res[1];
}

function ajaxkel(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('ird/IrDRegistrasi/data_kelurahan'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedKel;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_kecamatan").value = res[0];
	document.getElementById("kecamatan").value = res[1];
}

function cek_nokartu(no_medrec){
    ajaxku = buatajax();
    var url="<?php echo site_url('ird/IrDRegistrasi/check_no_kartu'); ?>";
    url=url+"/"+no_medrec;
    ajaxku.onreadystatechange=stateChangedValidasi;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
}


function setkel(id){
	var res=id.split("-");//it Works :D
	document.getElementById("id_kelurahandesa").value = res[0];
	document.getElementById("kelurahandesa").value = res[1];
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

function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}
function stateChanged(){
    var data;
	
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
    document.getElementById("kota").innerHTML = data
    }else{
    document.getElementById("kota").value = "<option selected>Pilih Kota/Kab</option>";
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
    document.getElementById("kec").value = "<option selected>Pilih Kecamatan</option>";
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
    document.getElementById("kel").value = "<option selected>Pilih Kelurahan/Desa</option>";
    }
    }
	
}

function stateChangedValidasi(){
	var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if (data.indexOf('Tidak Ditemukan')!= -1 || data.indexOf('Masukan')!= -1) {						
		}
		if(data.length>=0){
			document.getElementById("data_anggota").innerHTML = data;
			$('#data_webservice').modal('show');
		}else{
			document.getElementById("data_anggota").innerHTML = "Data Tidak Ditemukan";
		}
    }
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

function pilih_cara_bayar(val_cara_bayar){
		var res=val_cara_bayar.split("-");//it Works :D
		if(val_cara_bayar!=''){
			//document.getElementById("biayadaftar").value = res[1];
			document.getElementById("cara_bayar").value = res[0];
		}else{
			//document.getElementById("biayadaftar").value = '';
			document.getElementById("cara_bayar").value = '';
		}
		if(res[0]=='DIJAMIN / JAMSOSKES'){
			$('#cek_sep').hide();
			$('#input_kontraktor').show();
			document.getElementById("jenis_kontraktor").required= true;
			document.getElementById("btn-submit").disabled= false;
		}else{
			$('#input_kontraktor').hide();
			document.getElementById("jenis_kontraktor").required= false;
			$('#cek_sep').hide();
		}
		if(res[0]=='BPJS'){
			//alert("hi");
			//document.getElementById("biayadaftar_").value='0';
			//document.getElementById("biayadaftar").value='0';
			$('#cek_sep').show();
			$('#warn_kartu').show();
			var noBpjs = "<?php echo $no_kartu; ?>";			
			if(noBpjs!=''){
				document.getElementById("content_warn_kartu").innerHTML = "No. Kartu : "+noBpjs;
			}else{
				document.getElementById("content_warn_kartu").innerHTML = "Isi terlebih dahulu No. Kartu BPJS Pasien";
			}
			//document.getElementById("cek_sep").show;
			//$('#biayadaftar_').val('0');
			//$('#biayadaftar').val('0');
		}else{
			$('#warn_kartu').hide();
			//$('#biayadaftar_').val(biaya2);	
			//$('#biayadaftar_').maskMoney('mask');
			//$('#biayadaftar').val(biaya2);	
			$('#cek_sep').hide();
			document.getElementById("btn-submit").disabled= false;
			//document.getElementById("biayadaftar_").value='15,000';
			//document.getElementById("biayadaftar").value='15000';
			//$('#biayadaftar_').val('15,000');
			//$('#biayadaftar').val('15000');
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
 


function cek_search_per(val_search_per){
	//alert(val_search_per);
	if(val_search_per=='cm'){
		$("#cari_no_medrec").css("display", ""); // To unhide
		$("#cari_no_kartu").css("display", "none");  // To hide
		$("#cari_no_identitas").css("display", "none");
		$("#cari_nama").css("display", "none");
		$("#cari_alamat").css("display", "none");
	}
	else if(val_search_per=='kartu'){
		$("#cari_no_medrec").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", ""); 
		$("#cari_no_identitas").css("display", "none");
		$("#cari_nama").css("display", "none");
		$("#cari_alamat").css("display", "none");
	}else if(val_search_per=='nama'){
		$("#cari_no_medrec").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", "none"); 
		$("#cari_no_identitas").css("display", "none");
		$("#cari_nama").css("display", "");
		$("#cari_alamat").css("display", "none");
	}else if(val_search_per=='alamat'){
		$("#cari_no_medrec").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", "none"); 
		$("#cari_no_identitas").css("display", "none");
		$("#cari_nama").css("display", "none");
		$("#cari_alamat").css("display", "");
	}else {
		
		$("#cari_no_medrec").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", ""); 
		$("#cari_nama").css("display", "none");
		$("#cari_alamat").css("display", "none");
		
	}
}

function cek_no_identitas(no_identitas, no_identitas_old){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_noidentitas')?>/"+no_identitas+"/"+no_identitas_old,
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
		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_nokartu')?>/"+no_kartu+"/"+no_kartu_old,
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

function resetBiodata() {    
    document.getElementById("biodataIRD").reset();
    var form = document.getElementById("biodataIRD");
}

function resetDafulIRD() {
    document.getElementById("daftarUlangIRD").reset();
}
</script>
