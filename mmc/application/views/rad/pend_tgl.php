<?php
	if(count($data_laporan_keu)>0){
?>						

<table class="table table-hover table-bordered table-responsive">
	<thead>
		<tr>
			<th >No</th>
			<th >No Medrec</th>
			<th >No Register</th>
			<th >Nama</th>
			<th >Jenis Pemeriksaan</th>
			<th>Total Biaya Pemeriksaan</th>
		</tr>
	</thead>
	<tbody>

<?php
		//echo "<h4 align='center'><b>$pemeriksaan_title</b></h4>";
		$jum_vtot=0;
		$vtot1=0;
		echo "<br>";
		$i=1;
		$tot_pem=0;
		foreach($data_laporan_keu as $row){

			$no_register=$row->no_register;
			$j=1;		
			foreach($data_keuangan as $row2){
				if ($row2->no_register==$no_register) {
					$vtot1=$vtot1+$row2->vtot;
					//$jum_vtot = $jum_vtot+$row2->total;
					if($j==1){ ?>
						<tr>
							<td><?php echo $i++;?></td>
							<td><?php echo $row->no_cm;?></td>
							<td><?php echo $row->no_register;?></td>
							<td><?php echo $row->nama;?></td>
							<td><?php echo $row2->jenis_tindakan;?></td>
							<td>Rp <div class="pull-right"><?php echo number_format( $row2->vtot, 2 , ',' , '.' );?></div></td>
						</tr>
			<?php   } else { ?>
						<tr>
							<td bgcolor="#ecf0f5" colspan="4"></td>
							<td><?php echo $row2->jenis_tindakan;?></td>
							<td>Rp <div class="pull-right"><?php echo number_format( $row2->vtot, 2 , ',' , '.' );?></div></td>
						</tr>
			<?php	}
				$j++;
				$tot_pem++;
				} // if
			} // foreach data_pemeriksaan
		}
?>
		<tr>
			<td colspan="5"><p align="right"><b>Total</b></p></td>
			<td bgcolor="#cdd4cb">Rp <div class="pull-right"><b><?php echo number_format( $vtot1, 2 , ',' , '.' );?></b></div></td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<?php //echo $space ?>
	</tbody>
</table>	
<h4 align="center"><b>Total Pasien : <?php echo $i-1;?><b></h4>
<h4 align="center"><b>Total Pemeriksaan : <?php echo $tot_pem;?><b></h4>
<br>
<div class="form-inline" align="right">
	<div class="form-group">
		<a id="btnExcel" name="btnExcel" class="btn btn-primary" href="<?php echo site_url('rad/Radclaporan/export_excel/'.$tampil_per.'/'.$tgl);?>">Download Excel</a>
		<a id="btnCetak" name="btnCetak" class="btn btn-primary" target="_blank" href="<?php echo site_url('rad/Radclaporan/lap_keu/'.$tampil_per.'/'.$tgl);?>">Cetak</a>
	</div>
</div>


<?php	} else {
	echo $message_nodata;
} 
?>
