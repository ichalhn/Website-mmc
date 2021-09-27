
<?php
	if(count($data_laporan_keu)>0){
		//echo "<h4 align='center'><b>$pemeriksaan_title</b></h4>";	
		$jum_vtot=0;
		echo "<br>";
		foreach($data_periode as $row1){

			$cek_bln=$row1->bln;
?>				

<h4><b>Bulan  
<?php 
	$inp=substr($row1->bln,5,2);
	if ($inp == 1)
		{
			echo "Januari";
		}
		else if ($inp == 2)
		{
			echo "Februari ";
		}
		else if ($inp == 3)
		{
			echo "Maret ";
		}
		else if ($inp == 4)
		{
			echo "April ";
		}
		else if ($inp == 5)
		{
			echo "Mei ";
		}
		else if ($inp == 6)
		{
			echo "Juni ";
		}
		else if ($inp == 7)
		{
			echo "July ";
		}
		else if ($inp == 8)
		{
			echo "Agustus ";
		}
		else if ($inp == 9)
		{
			echo "September ";
		}
		else if ($inp == 10)
		{
			echo "Oktober ";
		}
		else if ($inp == 11)
		{
			echo "November ";
		}
		else if ($inp == 12)
		{
			echo "Desember ";
		}				
		else
		{
			echo "";
		}//angke ke strin (BULAN)
?>
</b></h4>
<hr>
<table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th width="5%"><b>No</b></th>
			<th width="45%"><b>Jenis Pemeriksaan</b></th>
			<th width="15%"><b>Jumlah Pasien</b></th>
			<th width="20%"><b>Jumlah Pemeriksaan</b></th>
			<th width="30%"><b>Total</b></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$i=1;		
		$vtot1=0;
		foreach($data_keuangan as $row2){
			if ($row2->bln==$cek_bln) {
				$vtot1=$vtot1+$row2->total;
				$jum_vtot = $jum_vtot+$row2->total;
		?>
			<tr>
				<td><?php echo $i++;?></td>
				<td><?php echo $row2->jenis_tindakan;?></td>
				<td><?php echo $row2->jumlah_pasien;?></td>
				<td><?php echo $row2->jumlah_pemeriksaan;?></td>
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
	<tr>
		<td width="50%"><p align="right"><b>Jumlah Total <?php echo $date_title; ?></b></p></td>
		<td BGCOLOR="#ccd4cb">Rp <div class="pull-right"><b><?php echo number_format( $jum_vtot, 2 , ',' , '.' );?></b></div></td>
	</tr>
</table>

<br>
<div class="form-inline" align="right">
	<div class="form-group">
		<a id="btnExcel" name="btnExcel" class="btn btn-primary" href="<?php echo site_url('rad/Radclaporan/export_excel/'.$tampil_per.'/'.$thn.'/'.$jenis_bayar);?>">Download Excel</a>
		<a target="_blank" id="btnCetak" name="btnCetak" class="btn btn-primary" href="<?php echo site_url('rad/Radclaporan/lap_keu/'.$tampil_per.'/'.$thn.'/'.$jenis_bayar);?>">Cetak</a>
	</div>
</div>
<?php	} else {
	echo $message_nodata;
} 
?>
