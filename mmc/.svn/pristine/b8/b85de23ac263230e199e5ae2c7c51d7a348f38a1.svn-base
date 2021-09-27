<?php $this->load->view("layout/header"); ?>
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
	$('#date_picker_days').datepicker("setDate", "0");
	var size = "<?php echo $size;?>";
	//alert(size+" awdad");
	if(size==''){		
		$('#btnCetak').addClass('disabled');
	}

	
});


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
			<?php echo form_open('farmasi/Frmclaporan/data_kunjungan');?>
			<div id="date_input">
				<div class="col-lg-2">
					<input type="text" id="date_picker_days" class="form-control" placeholder="Tanggal" name="date_picker_days" required >
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
	if(count($data_laporan_kunj)>0){
?>
<table id="example" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th>No Medrec</th>
			<th>No Register</th>
			<th>Nama</th>		
			<th>Rincian Obat</th>								 
		</tr>
	</thead>
	<tbody>
		<?php	// print_r($pasien_daftar);
		$i=1;
		$vtot_banyak=0;
		foreach($data_laporan_kunj as $row){
		$no_register=$row->no_register;
		$vtot_banyak=$vtot_banyak+$row->banyak;
		?>
		<tr>
			<td><?php echo $i++;?></td>
			<td><?php echo $row->no_cm;?></td>
			<td><?php echo $row->no_register;?></td>
			<td><?php echo $row->nama;?></td>
			<td>
				<table width='100%'>
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Obat</th>
							<th>Banyak Obat</th>
							<th>Harga Total</th>									 
						</tr>
					</thead>
					<tbody>
				<?php
					$j=1;
					foreach($data_tindakan as $row2){
						if($no_register==$row2->no_register){
							echo "<tr><td>".$j."</td>";
							echo "<td>".$row2->nama_obat."</td>";
							echo "<td>".$row2->qty."</td>";
							echo "<td>Rp. ".$row2->vtot."</td></tr>";
							$j++;
						}
					}
					echo "<tr><td colspan='3' align='right' bgcolor='grey'>Total</td><td align='right' bgcolor='grey'>Rp. ".$row->vtot."</td></tr>";
				?>
					</tbody>
				</table>
			</td>

		</tr>
	<?php	} ?>
	</tbody>
</table>
<h4 align="center"><b>Total Kunjungan : <?php echo $i-1;?><b></h4>
<h4 align="center"><b>Total Obat : <?php echo $vtot_banyak;?><b></h4>
<hr>
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