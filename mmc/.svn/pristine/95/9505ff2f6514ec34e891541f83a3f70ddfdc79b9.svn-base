<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(function(){	
	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({      	
      	radioClass: 'iradio_flat-green'
    	});

	$(".select2").select2();
	$("#btnBIo").click(function(){
		alert("hi");
		$("p").show();
	});
	$("#tableBelumPulang").dataTable({"iDisplayLength": 25});
	$("#tableCari").dataTable({"iDisplayLength": 25});
	$("#duplikat_id").hide();
	$("#duplikat_kartu").hide();

	var searchper = "<?php echo $search_per; ?>";
	if(searchper!=''){
		$('select[name="search_per"]').val(searchper).change();
	}

	
	$('.auto_search_by_nocm').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/ird/IrDRegistrasi/data_pasien',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#cari_no_medrec').val(''+suggestion.no_cm);
			$('#no_medrec_baru').val(''+suggestion.no_medrec);
		}
		
	});

	

	$('.auto_search_poli').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/ird/IrDRegistrasi/data_poli',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#id_poli').val(''+suggestion.id_poli);
			$('#kd_ruang').val(''+suggestion.kd_ruang);
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

	$('#date_picker').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  

	$('#tgl_daftar').datepicker({
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
	}else{
		$("#cari_no_medrec").css("display", "none");  // To hide
		
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", ""); 
		$("#cari_nama").css("display", "none");
		$("#cari_alamat").css("display", "none");
		
	}
}

function cek_no_identitas(no_identitas){
	if(no_identitas!=''){
	$.ajax({
		type:'POST',
		dataType: 'html',
		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_noidentitas')?>/"+no_identitas+"/",
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
}

function cek_no_kartu(no_kartu){
	if(no_kartu!=''){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_nokartu')?>/"+no_kartu+"/",
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
}

function resetBiodata() {    
    document.getElementById("biodataIRD").reset();
}

function resetDafulIRD() {
    document.getElementById("daftarUlangIRD").reset();
}

</script>
