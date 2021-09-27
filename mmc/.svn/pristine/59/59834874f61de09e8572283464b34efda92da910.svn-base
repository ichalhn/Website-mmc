<?php $this->load->view("layout/header"); ?>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(document).ready(function() {
    $('#example').DataTable();
   
	$('.date_picker_days').datepicker({
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
	$('#date_picker_days').datepicker("setDate", "0");
	var size = "<?php echo $size;?>";
	//alert(size+" awdad");
	if(size==''){		
		$('#btnCetak').addClass('disabled');
	}

	var tampilper = "<?php echo $tampil_per;?>";
	if(tampilper!=''){
		$('#tampil_per').val(tampilper).change();
	}else{
		$('#tampil_per').val('BLN').change();
	}
	

	
});

function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='BLN'){
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker_months").required = true;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker_months').show();
			$('#date_picker_years').hide();
		}else{
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = true;
			$('#date_picker_months').hide();
			$('#date_picker_years').show();
		}
	}

</script>
<style>
hr {
	border-color:#7DBE64 !important;
}

thead {
	background: #c4e8b6 !important;
	color:#4B5F43 !important;
	background: -moz-linear-gradient(top,  #c4e8b6 0%, #7DBE64 100%) !important;
	background: -webkit-linear-gradient(top,  #c4e8b6 0%,#7DBE64 100%) !important;
	background: linear-gradient(to bottom,  #c4e8b6 0%,#7DBE64 100%) !important;
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c4e8b6', endColorstr='#7DBE64',GradientType=0 )!important;
}
</style>

<section class="content-header">
	<div class="form-group row">
		<div class="form-inline">
			<?php echo form_open('akun/Crsnrl/lap_rugilaba');?>
			<div id="date_input">
				<div class="col-lg-4">
					<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
							<option value="BLN">Bulanan</option>
							<option value="THN">Tahunan</option>
					</select>
					<input type="text" id="date_picker_months" class="form-control" placeholder="yyyy-mm" name="bln0">
					<input type="text" id="date_picker_years" class="form-control" placeholder="yyyy" name="thn0">
				</div>						
			</div>
			
			<div class="col-lg-2">
				<span class="input-group-btn">
					<button class="btn btn-primary" type="submit">Cari</button>
				</span>
			</div>
			<?php echo form_close();?>
		</div>				
	</div>
</section>
              
<section class="content">
	<div class="row">
		<div class="panel panel-default" style="width:97%;margin:0 auto">
			<div class="panel-heading">			
				<h4 align="center"><?php echo $date_title; ?></h4>
			</div>
			<div class="panel-body">				
				<?php
	if(count($data_lap_rl)>1){
?>
<table id="example" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th >Param 1</th>
			<th>Param 2</th>
			<th>Param 3</th>		
			<th><?php if($tampil_per=='BLN'){echo date('F Y', strtotime($date0));}else{ echo $date0;}?></th>
			<th><?php if($tampil_per=='BLN'){echo date('F Y', strtotime($date00));}else{echo $date00;}?></th>								 
		</tr>
	</thead>
	<tbody>
		<?php	// print_r($pasien_daftar);
		$i=1;
		$vtot_banyak=0;
		foreach($data_lap_rl as $row){
		//$vtot_banyak=$vtot_banyak+$row->banyak;
		$id_nrl=$row->id_nrl;
		?>
		<tr>
			<td><?php echo $i++;?></td>
			<td><?php echo $row->param1;?></td>
			<td><?php echo $row->param2;?></td>
			<td><?php echo $row->param3;?></td>
			<?php foreach($data_detail_lap_rl as $row1){
			if($row1->id_nrl==$id_nrl){
				if($row1->year==$date0){echo "<td>".number_format($row1->totnilai, 2 , ',' , '.' )."</td>";}
				if($row1->year==$date00){echo "<td>".number_format($row1->totnilai, 2 , ',' , '.' )."</td>";}
			} }?>
		</tr>
	<?php	} ?>
	</tbody>
</table>
<hr>
<div class="pull-right">
	<a href="<?php echo site_url('akun/crsnrl/cetak_lap_pdf/'.$tampil_per.'/'.$date0.'/RL'); ?>" target="_blank" class="btn btn-primary">Cetak</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('akun/crsnrl/cetak_lap_excel/'.$tampil_per.'/'.$date0.'/RL'); ?>" target="_blank" class="btn btn-primary">Excel</a>
</div>

<br>

<?php 
			
			//TUTUP IF 
	} else {
	echo $message_nodata;
} 
?>
					
					</div>
				</div>
			</div>
		</section>
<?php $this->load->view("layout/footer"); ?>
