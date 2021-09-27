<script type='text/javascript'>
$(document).ready(function () {	
			
	
	  //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });			

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
				viewMode: "years", 
				minViewMode: "years",
		});
	
  	var tampil = "<?php echo $tampil_per;?>";
	if(tampil!=''){
	$('select[name="tampil_per"]').val(tampil).change();
	}
	
	
   		/*$('input[id="plgCheckbox').on('ifUnchecked', function (event) {
			alert("hahahaha" );
			
	    	});
	var checked = $("#plgCheckbox").parent('[class*="icheckbox"]').hasClass("checked");
	
	alert(checked);*/

	var size = "<?php echo $size;?>";
		//alert(size+" awdad");
		if(size==''){		
			$('#btnCetak').addClass('disabled');
			$('#btnDown').addClass('disabled');
		}
	/*var stat = "<?php echo $status;?>";
	if(stat!=''){
		//alert("hi");
		$('#plgCheckbox').prop('checked', false);
		$('#noCheckbox').prop('checked', false);
		if(stat=='1'){
			$('#plgCheckbox').prop('checked', true);
		}
		else if(stat=='0'){
			$('#noCheckbox').prop('checked', true);
		}
		else{
			$('#plgCheckbox').prop('checked', true);
			$('#noCheckbox').prop('checked', true);
		}
	}*/
	
	
    });
function cek_tgl(tgl){		
		if(tgl==''){
		//none :D just none
		}else if(tgl>Date()){
			document.getElementById("date_picker_days").value = '';
		}
	}	
	
	function cek_tampil_per(val_tampil_per){
		
		$('#plgCheckbox').prop('checked', false);
		$('#noCheckbox').prop('checked', false);
		if(val_tampil_per=='TGL'){			
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
