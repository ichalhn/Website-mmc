<script type='text/javascript'>

$(document).ready(function() {

	//-----------------------------------------------Data Table
    $('#tabel_tindakan').DataTable();
	$('#tabel_diagnosa').DataTable();
	$('#tabel_lab').DataTable();
	$('#tabel_resep').DataTable();
	//---------------------------------------------------------
	
	
	//CEK DATA LAB DAN RESEP-------------------------------------------
	var a_lab="<?php echo $a_lab ?>";
	var a_obat="<?php echo $a_obat ?>";
	if (a_lab=="closed") { //jika lab==0 atau status_lab==1
		 document.getElementById("button_reset_lab").disabled= true;
		 document.getElementById("button_simpan_lab").disabled= true;
		 document.getElementById("button_selesai_lab").href = "javascript: void(0)";		
	}	
	if (a_obat=="closed")  { //jika obat==0 atau status_obat==1
		 document.getElementById("button_reset_obat").disabled= true;
		 document.getElementById("button_simpan_obat").disabled= true;
		 document.getElementById("button_selesai_obat").href = "javascript: void(0)"
	}
	//------------------------------------------------------------------
});


function pilih_tindakan(tindakan) {	
	if(tindakan!=null){
		var result = tindakan.split('@');
		var id_tindakan = result[0];
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
				$('#biaya_tindakan').val(data);
				$('#biaya_tindakan_hide').val(data);
			},
			error: function(){
				alert("error");
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
		},
		error: function(){
			alert("error");
		}
    });
}

function set_total() {
	var total = $("#biaya_tindakan").val() * $("#qtyind").val();	
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