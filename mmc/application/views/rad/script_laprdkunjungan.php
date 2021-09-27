<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(document).ready(function() {
    $('#example').DataTable();

   
		$('#date_picker_days').datepicker({
				format: "yyyy-mm-dd",
				endDate: "current",
				autoclose: true,
				todayHighlight: true,
		}); 
		
		$('#date_picker_months').datepicker({
				format: "yyyy-mm",
				endDate: "current",
				autoclose: true,
				todayHighlight: true,
				viewMode: "months", 
				minViewMode: "months",
		}); 
		
		$('#date_picker_years').datepicker({
				format: "yyyy",
				endDate: "current",
				autoclose: true,
				todayHighlight: true,
				format: "yyyy",
				viewMode: "years", 
				minViewMode: "years",
		});
		
		var size = "<?php echo $size;?>";
		//alert(size+" awdad");
		if(size==''){		
			$('#btnCetak').addClass('disabled');
		}

		var tampil = "<?php echo $tampil_per;?>";
		if(tampil!=''){
		$('select[name="tampil_per"]').val(tampil).change();
		}
});


	
	function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='TGL'){
			//alert("tgl");
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker_days").required = true;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker_days').datepicker("setDate", "0");
			$('#date_input').show();
			$('#month_input').hide();
			$('#year_input').hide();
		}else if(val_tampil_per=='BLN'){
			//alert("bln");
			document.getElementById("date_picker_days").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker_days").required = false;
			document.getElementById("date_picker_months").required = true;
			document.getElementById("date_picker_years").required = false;
			$('#date_input').hide();
			$('#date_picker_months').datepicker("setDate", "0"); 
			$('#month_input').show();
			$('#year_input').hide();
		}else{
			//alert("thn");
			var tgl1 = new Date().getFullYear();
			document.getElementById("date_picker_days").value = '';
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker_days").required = false;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = true;
			$('#date_input').hide();
			$('#month_input').hide();
			$('#date_picker_years').datepicker("setDate", tgl1.toString()); 
			$('#year_input').show();
		}
	}

</script>
