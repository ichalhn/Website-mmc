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
			<?php echo form_open('akun/Crsakunlap/lapgl');?>
			<div id="date_input">
				<div class="col-lg-4">
					<input type="text"  class="form-control date_picker_days" placeholder="Tanggal Awal" name="date_picker_days0" required >&nbsp;&nbsp;&nbsp;
					<input type="text"  class="form-control date_picker_days" placeholder="Tanggal Akhir" name="date_picker_days1" required >
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
			<?php echo form_open('akun/crsakunlap/lapgl/');?>
				<div class="form-group">		      
				  <div class="col-md-4">
					<select class="form-control" name="tipe_bt" id="tipe_bt">
						<option value="">-Pilih Tipe BT-</option>
						<?php if($caribt=='K' && $caribt!='' ){ ?>
							<option value="K" selected>KREDIT</option>
							<option value="D">DEBET</option>
						<?php } else if($caribt=='D' && $caribt!='' ){?>
							<option value="K">KREDIT</option>
							<option value="D" selected>DEBET</option>
						<?php } else {?>
							<option value="K" >KREDIT</option>
							<option value="D">DEBET</option>
						<?php }?>
					</select>
				  </div>
				</div>
				<div class="form-group">		      
				  <div class="col-md-4">
					<input type="text"  class="form-control" placeholder="Pencarian Kode Rekening" name="carikoderek" value="<?php echo $carikoderek;?>">
				  </div>
				</div>
				<div class="col-lg-2">
				<span class="input-group-btn">
					<input type="hidden" name="date_picker_days0" value="<?php echo $tgl_awal;?>">		
					<input type="hidden" name="date_picker_days1" value="<?php echo $tgl_akhir;?>">		
					<button class="btn btn-primary" type="submit">Cari</button>
				</span>
				</div>
			<?php form_close();?>
			<div class="clearfix" style="height: 10px;clear: both;"></div>
				<?php
	if(count($data_laporan_kunj)>0){
?>
<div id="table1">
<table id="example" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th width='5%'>No Voucher</th>
			<th>Keterangan</th>
			<th>Tgl Entry</th>		
			<th>Rincian Transaksi</th>								 
		</tr>
	</thead>
	<tbody>
		<?php	// print_r($pasien_daftar);
		$i=1;
		$vtot_banyak=0;$vtot4=0;
		foreach($data_laporan_kunj as $row){
		$novoucher=$row->novoucher;
		$vtot_banyak=$vtot_banyak+$row->banyak;
		?>
		<tr>
			<td><?php echo $i++;?></td>
			<td><?php echo $row->novoucher;?></td>
			<td><?php echo $row->vouchket;?></td>
			<td><?php echo date('d-m-Y', strtotime($row->tglentry));?></td>
			<td>
				<table width='100%'>
					<thead>
						<tr>
							<th>No</th>
							<th width='27%'>Kode Rekening</th>
							<th width='17%'>Tgl Transaksi</th>
							<th width='20%'>Nilai</th>
							<th width='20%'>BT</th>
							<th>PIC</th>
							<th width='15%'>Ket</th>									 
						</tr>
					</thead>
					<tbody>
				<?php
					$j=1;$vtot=0;$vtotkredit=0;$vtotdebet=0;
					foreach($data_tindakan as $row2){
						if($novoucher==$row2->novoucher){
							$vtot=$vtot+$row2->Nilai;
							if($row2->tipebt=='K'){
									$vtotkredit=$vtotkredit+(double)$row2->Nilai;
							}else
								$vtotdebet=$vtotdebet+(double)$row2->Nilai;
							
							echo "<tr><td>".$j."</td>";
							echo "<td> (".$row2->koderek.") ".$row2->perkiraan."</td>";
							echo "<td>".date('d-m-Y',strtotime($row2->tgltransaksi))."</td>";
							echo "<td>(".$row2->tipebt.") Rp. ".$row2->Nilai."</td>";
							if($row2->kodebt!=''){
								echo "<td>(".$row2->kodebt.") ".$row2->btma."</td>";
							}else echo "<td>-</td>";
							echo "<td>".$row2->pic."</td>";
							echo "<td>".$row2->ket."</td></tr>";
							$j++;
						}
					}
					(double)$vtot3=(double)$vtotkredit-(double)$vtotdebet;
					$vtot4=$vtot4+$vtot3;
					echo "<tr>
							<td colspan=\"3\"><p align=\"right\">Total</p></td>							
							<td><p align=\"right\">$vtot3</p></td>									 
						</tr>";
					//echo "<tr><td colspan='3' align='right' bgcolor='grey'>Total</td><td align='right' bgcolor='grey'>Rp. ".$vtot."</td></tr>";
				?>
					</tbody>
				</table>
			</td>

		</tr>
	<?php	} ?>
	</tbody>
</table>
</div>

<hr>
<?php if($carikoderek==''){$kode0='0';}else $kode0=$carikoderek;?>
<div class="pull-right">
	<a href="<?php echo site_url('akun/crsakunlap/cetak_lap_pdf/'.$tgl_awal.'/'.$tgl_akhir.'/'.$kode0.'/'.$caribt); ?>" target="_blank" class="btn btn-primary">Cetak</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo site_url('akun/crsakunlap/cetak_lap_excel/'.$tgl_awal.'/'.$tgl_akhir.'/'.$kode0.'/'.$caribt); ?>" target="_blank" class="btn btn-primary">Excel</a>
</div>
<h4 align="center"><b>Total Voucher : <?php echo $i-1;?><b></h4>
<h4 align="center"><b>Total Transaksi : <?php echo $vtot_banyak;?><b></h4>
<h4 align="center" style="padding-right:12%"><b>Total Rupiah : <?php echo $vtot4;?><b></h4>
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
