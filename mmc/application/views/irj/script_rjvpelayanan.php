<script src="<?php echo site_url('asset/plugins/ckeditor/ckeditor.js'); ?>"></script>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(document).ready(function() {

	$(".select2").select2();
    CKEDITOR.replace('catatan');
	
	//-----------------------------------------------Data Table
    $('#tabel_tindakan').DataTable();
	$('#tabel_diagnosa').DataTable();
	$('#tabel_lab').DataTable();
	$('#tabel_pa').DataTable();
	$('#tabel_rad').DataTable();
	$('#tabel_ok').DataTable();
	$('#tabel_resep').DataTable();
	$('#tabel_obat1').DataTable();
	$('#tabel_obat2').DataTable();
    $('#tabel_obat3').DataTable();
	//---------------------------------------------------------
	
	$('.auto_diagnosa_pasien').autocomplete({
		serviceUrl: site+'iri/ricstatus/data_icd_1',
		onSelect: function (suggestion) {
			$('#id_diagnosa').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
			$('#diagnosa').val(''+suggestion.id_icd+'@'+suggestion.nm_diagnosa);
			
		}
	});
	//CEK DATA LAB DAN RESEP-------------------------------------------
	var a_lab="<?php echo $a_lab ?>";
	var a_pa="<?php echo $a_pa ?>";
	var a_obat="<?php echo $a_obat ?>";
	var a_rad="<?php echo $a_rad ?>";
	
	//------------------------------------------------------------------
});


function pilih_tindakan(tindakan) {
	//alert(tindakan);	
	if(tindakan!=''){
		var result = tindakan.split('@');
		var id_tindakan = result[0];
		
		if(id_tindakan.substring(0,2)=='BA') {
			$("#dokterDiv").show();
			document.getElementById("id_dokter").required = true;
		} else {
			$("#dokterDiv").show();
			document.getElementById("id_dokter").required = true;
		}
		
		$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('irj/rjcpelayanan/get_biaya_tindakan')?>",
			data: {
				id_tindakan: id_tindakan,
				kelas : "<?php echo $kelas_pasien ?>"
			},
			success: function(data){
				//alert(data);
				$('#biaya_tindakan').val(data[0]);
				$('#biaya_tindakan_hide').val(data[0]);
				$('#biaya_alkes').val(data[1]);
				$('#biaya_alkes_hide').val(data[1]);
				$('#qtyind').val(1);
				vtot = parseInt(data[0])+parseInt(data[1]);
				$('#vtot').val(vtot);
				$('#vtot_hide').val(vtot);
			},
			error: function(xhr, status, error) {
				alert(xhr.responseText);
			}
	    });
	}
	
	
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
			$('#biaya_lab_hide').val(data);
			$('#qty_lab').val(1);
			$('#vtot_lab').val(data);
			$('#vtot_lab_hide').val(data);
		},
		error: function(){
			alert("error");
		}
    });
}

function set_total() {
	var total = $("#biaya_tindakan").val() * $("#qtyind").val() + $("#biaya_alkes").val() * $("#qtyind").val() ;	
	$('#vtot').val(total);
	$('#vtot_hide').val(total);
}

function set_total_lab() {
	var total = $("#biaya_lab").val() * $("#qty_lab").val();	
	$('#vtot_lab').val(total);
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
		
			var num = data*1.3*1.1;
			$('#biaya_obat').val(num.toFixed(2));
			$('#biaya_obat').maskMoney('mask');
			$('#biaya_obat_hide').val(num.toFixed(2));
			$("#qtyResep").val('1');
		
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
	$('#vtot_resep').val(total.toFixed(2));
	$('#vtot_resep').maskMoney('mask');
	$('#vtot_resep_hide').val(total.toFixed(2));
}

</script>
