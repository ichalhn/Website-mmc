<script src="<?php echo site_url('asset/plugins/ckeditor/ckeditor.js'); ?>"></script>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(document).ready(function() {
     $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });
    CKEDITOR.replace('catatan');
	
	$('#lbl_kontrol').hide();
    $('.select2').select2();
    $('#tableTindakan').DataTable();
    $('#tabel_tindakan').DataTable();
    $('#tabel_ok').DataTable();
    $('#tabel_pa').DataTable();
    $('#tabel_rad').DataTable();
    $('#tabel_resep').DataTable();
    $('#tableDiagnosa').DataTable();
    $('#tabel_obat1').DataTable();
    $('#tabel_obat2').DataTable();
    $('#tabel_obat3').DataTable();

    $("#biaya_tindakan").maskMoney({thousands:',', decimal:'.', affixesStay: true});
    $("#biaya_alkes").maskMoney({thousands:',', decimal:'.', affixesStay: true});
    $("#vtot").maskMoney({thousands:',', decimal:'.', affixesStay: true});
    
    // $("#biaya_lab").maskMoney({thousands:',', decimal:'.', affixesStay: true});
    // $("#vtot_lab").maskMoney({thousands:',', decimal:'.', affixesStay: true});
    $("#biaya_obat").maskMoney({thousands:',', decimal:'.'});
    $("#vtot_resep").maskMoney({thousands:',', decimal:'.'});

    $("#biaya_rad").maskMoney({thousands:',', decimal:'.'});
    $("#vtot_rad").maskMoney({thousands:',', decimal:'.'});
	
   
} );
$(function(){
	
	$('.auto_search_tindakan').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/IrDPelayanan/data_tindakan',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#idtindakan').val(''+suggestion.idtindakan);
			$('#nmtindakan').val(''+suggestion.nmtindakan);
		}
	});
	$('.auto_search_operator').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/IrDPelayanan/data_operator',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#id_dokter').val(''+suggestion.id_dokter);
			$('#nm_dokter').val(''+suggestion.nm_dokter);
		}
	});
	$('.auto_search_tindakan2').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/IrDPelayanan/data_tindakan',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#idtindakan2').val(''+suggestion.idtindakan);
			$('#nmtindakan2').val(''+suggestion.nmtindakan);
		}
	});
	$('.auto_search_operator2').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/IrDPelayanan/data_tindakan_no',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#id_dokter2').val(''+suggestion.id_dokter);
			$('#nm_dokter2').val(''+suggestion.nm_dokter);
		}
	});

	$('.auto_diagnosa_pasien').autocomplete({
		serviceUrl: site+'iri/ricstatus/data_icd_1',
		onSelect: function (suggestion) {
			//$('#no_cm').val(''+suggestion.no_cm);
			$('#diagnosa').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
			$('#jenis_diagnosa').val(''+suggestion.id_icd+'@'+suggestion.nm_diagnosa);
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
		

function data_edit(param0,param1,param2,param3,param4,param5,param6,param7,param8){
	document.getElementById("idtindakan2").value = param0;
	document.getElementById("nmtindakan2").value = param1;
	document.getElementById("id_dokter2").value = param2;
	document.getElementById("nm_dokter2").value = param3;
	document.getElementById("biaya_poli2").value = param4;
	document.getElementById("qtyind2").value = param5;
	document.getElementById("dijamin2").value = param6;
	document.getElementById("vtot2").value = param7;
	document.getElementById("id_pelayanan_poli2").value = param8;
}

function pilih_tindakan(tindakan) {
   // alert("<?php echo site_url('irj/rjcpelayanan/get_biaya_tindakan'); ?>");
	var result = tindakan.split('@');
	var id_tindakan = result[0];
	//alert(id_tindakan);
	//alert("<?php echo $kelas_pasien ?>");
	if(tindakan!=''){
		$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('ird/IrDPelayanan/get_biaya_tindakan')?>",
		data: { //data yg dikirim ke kontroller variabelnya sebelah kiri
			id_tindakan: id_tindakan,
			kelas : "<?php echo $kelas_pasien ?>"
		},
		success: function(data){
			//alert(data);		
			if(id_tindakan.substr(0, 2)=='BA'){
				$("#dokterDiv").hide();
				$("#dokterAnakDiv").hide();
				$("#dokterInstDiv").hide();
				$("#asistDokDiv").hide();
				$("#penataAnasDiv").hide();
				$("#dokterAnasDiv").hide();
				$("#lbl_operasi").hide();
				document.getElementById('dokterTind').required = false;
			}else{
				$("#dokterDiv").show();
				$("#lbl_operasi").show();
				$("#dokterAnakDiv").show();
				$("#dokterInstDiv").show();
				$("#asistDokDiv").show();
				$("#penataAnasDiv").show();
				$("#dokterAnasDiv").show();
				document.getElementById('dokterTind').required = true;
			}
			$('#biaya_tindakan').val(data[0]);
			$('#biaya_tindakan').maskMoney('mask');
			$('#biaya_tindakan_hide').val(data[0]);
			$("#qtyind").val('1');		
			$('#biaya_alkes').val(data[1]);
			$('#biaya_alkes').maskMoney('mask');
			$('#biaya_alkes_hide').val(data[1]);
			vtot = parseInt(data[0])+parseInt(data[1]);	
			$('#vtot').val(vtot);
			$('#vtot').maskMoney('mask');
			$('#vtot_hide').val(vtot);
		},
		error: function(xhr,err){
			//alert("readyState: "+xhr.readyState+"\nstatus: "+xhr.status);
    			alert("ERROR : "+xhr.responseText);
		}
	    });
	}
}

function pilih_mrs(mrs) {
   	//alert(mrs);
	if(mrs=='PULANG'){
		$('#lbl_kontrol').show();
	}else{
		$('#lbl_kontrol').hide();
	}
	//alert(id_tindakan);
	//alert("<?php echo $kelas_pasien ?>");
	
}

function set_total() {
	
	var total = parseInt($("#biaya_tindakan_hide").val()) * parseInt($("#qtyind").val()) + parseInt($("#biaya_alkes_hide").val())  ;	
	
	$('#vtot').val(total);
	$('#vtot').maskMoney('mask');
	$('#vtot_hide').val(total);
}

function pilih_tindakan_lab(id_tindakan) {
   // alert("<?php echo site_url('irj/rjcpelayanan/get_biaya_tindakan'); ?>");
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('lab/labcdaftar/get_biaya_tindakan')?>",
		data: {
			id_tindakan: id_tindakan,
			kelas : "<?php echo $kelas_pasien ?>"
		},
		success: function(data){
			//alert(data);
			$('#biaya_lab').val(data);
			$('#biaya_lab').maskMoney('mask');
			$('#biaya_lab_hide').val(data);
			$('#vtot_lab').val(data);
			$('#vtot_lab').maskMoney('mask');
			$('#vtot_lab_hide').val(data);
			
		},
		error: function(){
			alert("error");
		}
    });
}


function set_total_lab() {
	var total = $("#biaya_lab_hide").val() * $("#qtyLab").val();	
	$('#vtot_lab').val(total);
	$('#vtot_lab').maskMoney('mask');
	$('#vtot_lab_hide').val(total);
}

function pilih_obat(id_resep) {
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('farmasi/Frmcdaftar/get_biaya_tindakan')?>",
		data: {
			id_resep: id_resep
		},
		success: function(data){
			//alert(data);
			var num = data*1.3*1.1;
			$('#biaya_obat').val(num.toFixed(2));
			$('#biaya_obat').maskMoney('mask');
			$('#biaya_obat_hide').val(num.toFixed(2));
			$("#qtyResep").val('1');
			
		
			//alert(num.toFixed(2));
			$('#vtot_resep').val(num.toFixed(2));
			$('#vtot_resep').maskMoney('mask' );
			$('#vtot_resep_hide').val(num.toFixed(2));
		},
		error: function(){
			alert("error");
		}
    });
}

function set_total_resep() {	
	var total = $("#biaya_obat_hide").val() * $("#qtyResep").val();
	//var tot1 = total*1.1*1.1;
	//alert(tot1.toFixed(2));
	$('#vtot_resep').val(total.toFixed(2));
	$('#vtot_resep').maskMoney('mask');
	//alert(total);
	$('#vtot_resep_hide').val(total.toFixed(2));
}
</script>
