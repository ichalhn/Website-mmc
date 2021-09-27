<!--<table class="table table-hover table-bordered">
				  <thead>
					<tr>
								  <th><p align="center">No</p></th>
								  <th><p align="center">Hari</p></th>
								  <th><p align="center">Qty</p></th>
								  <th><p align="center">Total Biaya Obat</p></th>
								</tr>
							  </thead>
							  <tbody>
							  
						<?php
							$i=1;
							$vtot1=0;
							$vtot2=0;
							foreach($data_laporan_keu as $row){
							$vtot1=$vtot1+$row->total;
						?>
							<tr>
								<td align="center"><?php echo $i++;?></td>
								<td><?php echo $row->hari;?></td>
								<td align="center"><?php echo $row->jum_kunj;?></td>
								<td>Rp <div class="pull-right"><?php echo number_format( $row->total, 2 , ',' , '.' );?></div></td>
							</tr>
						<?php
							}
						?>
							<tr>								
								<td colspan="3" align="right"><b>Total</b></td>
								
								<td>Rp <div class="pull-right"><b><?php echo number_format( $vtot1, 2 , ',' , '.' );?></b></div></td>
							</tr>
							  </tbody>
							 </table>
							 <br>							
							<div class="form-inline" align="right">
								<div class="form-group">
									<a id="btnCetak" name="btnCetak" class="btn btn-primary" target="_blank" href="<?php echo site_url('farmasi/Frmclaporan/lap_keu/'.$tampil_per.'/'.$bln);?>">Cetak</a>
								</div>
							</div>-->

<?php
	if(count($data_laporan_keu)>0){
		//echo "<h4 align='center'><b>$pemeriksaan_title</b></h4>";
		$jum_vtot=0;
		echo "<br>";
		foreach($data_periode as $row1){
			$cek_tgl=$row1->tgl;
?>
				

<h4><b>Tanggal <?php 	echo substr($row1->tgl, 8, 2)." ".$tgl; ?></b></h4>
<hr>
<table class="table table-hover table-striped table-bordered">
	<thead>
		<tr>
			<th width="5%"><b>No</b></th>
			<th width="15%"><b>Item Obat</b></th>
			<th width="40%"><b>Nama Obat</b></th>
			<th width="15%"><b>Jumlah Obat</b></th>
			<th width="25%"><b>Total</b></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$i=1;
		$vtot1=0;
		foreach($data_keuangan as $row2){
			if ($row2->tgl==$cek_tgl) {
				$vtot1=$vtot1+$row2->total;
				$jum_vtot = $jum_vtot+$row2->total;
		?>
			<tr>
				<td><?php echo $i++;?></td>
				<td><?php echo $row2->item_obat;?></td>
				<td><?php echo $row2->nama_obat;?></td>
				<td><?php echo $row2->jumlah;?></td>
				<td>Rp <div class="pull-right"><?php echo number_format( $row2->total, 2 , ',' , '.' );?></div></td>
			</tr>
		<?php
			} // if
		} // foreach data_pemeriksaan
		?>
		<tr>
			<td colspan="4"><p align="right"><b>Total</b></p></td>
			<td BGCOLOR="#cdd4cb">Rp <div class="pull-right"><b><?php echo number_format( $vtot1, 2 , ',' , '.' );?></b></div></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<?php //echo $space ?>
	</tbody>
</table>	
	
<?php 
}
?>
<table class="table table-hover table-striped table-bordered">
	<thead>
		<tr>
			<td width="50%"><p align="right"><b>Jumlah Total <?php echo $date_title; ?></b></p></td>
			<td BGCOLOR="#ccd4cb">Rp <div class="pull-right"><b><?php echo number_format( $jum_vtot, 2 , ',' , '.' );?></b></div></td>
		</tr>
	</thead>
</table>

<br>
<div class="form-inline" align="right">
	<div class="form-group">
		<a id="btnExcel" name="btnExcel" class="btn btn-primary" href="<?php echo site_url('farmasi/Frmclaporan/export_excel/'.$tampil_per.'/'.$bln.'/'.$jenis_bayar);?>">Download Excel</a>
		<a target="_blank" id="btnCetak" name="btnCetak" class="btn btn-primary" href="<?php echo site_url('farmasi/Frmclaporan/lap_keu/'.$tampil_per.'/'.$bln.'/'.$jenis_bayar);?>">Cetak PDF</a>
	</div>
</div>
<?php	} else {
	echo $message_nodata;
} 
?>

