<?php 
if (sizeof($data_laporan_keu)>0){
	$vtottotal=0;
	if ($id_poli=="SEMUA") {
		
		foreach($poli as $row1){ 
			
			$array = json_decode(json_encode($data_laporan_keu), True);
			$data_poli=array_column($array, 'id_poli');
			//Klo data tdk kosong, tampilkan
			if (in_array($row1->id_poli, $data_poli)) {		
		?>	
				<h4><b>Poliklinik : <?php echo $row1->nm_poli ?></b></h4>
				<table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
					<thead>
						<tr>
							<th width="3%"><b>No</b></th>
							<th width="7%"><b>No Medrec</b></th>
							<th width="10%"><b>No Register</b></th>
							<th width="25%"><b>Nama</b></th>
							<th width="12%"><b>Cara Bayar</b></th>
							<?php if ($status=='10') echo "<th width=\"10%\"><b>Status</b></th>"; ?>
							<!--<th width="15%"><b>Biaya Daftar</b></th>-->
							<th width="10%"><b>Tunai</b></th>
							<th width="10%"><b>Diskon</b></th>
							<th width="15%"><b>Biaya Tindakan</b></th>							
						</tr>
					</thead>
					<tbody>
						<?php
						$i=1;
						$vtot=0;$vtottunai=0;
						$vtotdiskon=0;
						//$biayadaftar=0;
						foreach($data_laporan_keu as $row2){
							if ($row2->id_poli==$row1->id_poli) {
							$vtot+=$row2->vtot;
							$vtottunai+=$row2->tunai;
							$vtotdiskon+=$row2->diskon;
							$vtottotal+=$row2->vtot;
							//$biayadaftar+=$row2->biayadaftar;
						?>
						<tr>
							<td width="3%"><?php echo $i++;?></td>
							<td width="7%"><?php echo $row2->no_cm;?></td>
							<td width="10%"><?php echo $row2->no_register;?></td>
							<td width="25%"><?php echo strtoupper($row2->nama);?></td>
							<td width="12%"><?php echo $row2->cara_bayar;?></td>
							<?php if ($status=='10') echo " <td width=\"10%\">".($row2->status=="1" ? "Pulang":"Dirawat")."</td>";?>
							<!--<td width="15%"><p align="right"><?php //echo number_format( $row2->biayadaftar, 2 , ',' , '.' ); ?></p></td>-->
							<td width="10%"><?php if($row2->tunai!='-'){echo number_format( $row2->tunai, 2 , ',' , '.' );}else{ echo $row2->tunai;}?></td>
							<td width="10%"><?php if($row2->diskon!='-'){echo number_format( $row2->diskon, 2 , ',' , '.' );}else{echo $row2->diskon;}?></td>
							<td width="15%"><p align="right"><?php echo number_format( $row2->vtot, 2 , ',' , '.' ); ?></p></td>
						</tr>
					<?php
							}
						}
					?>
						<tr>
							<td <?php echo ($status=='10' ? "colspan=\"6\" ":"colspan=\"5\" ") ?>><p align="right"><b>Total</b></p></td>
							<!--<td width="15%" bgcolor="#cdd4cb"><p align="right"><b><?php //echo number_format( $biayadaftar, 2 , ',' , '.' ); ?></b></p></td>-->
							<td bgcolor="yellow"><p align="right"><b><?php echo number_format( $vtottunai, 2 , ',' , '.' ); ?></b></p></td>
							<td  bgcolor="yellow"><p align="right"><b><?php echo number_format( $vtotdiskon, 2 , ',' , '.' ); ?></b></p></td>
							<td  bgcolor="yellow"><p align="right"><b><?php echo number_format( $vtot, 2 , ',' , '.' ); ?></b></p></td>
							
						</tr>
						<!--<tr>
							<td <?php //echo ($status=='10' ? "colspan=\"6\" width=\"85%\"":"colspan='5' width=\"75%\"") ?>><p align="right"><b>Total Biaya Daftar dan Tindakan</b></div></td>
							<td width="15%" BGCOLOR="yellow"><p align="right"><b><?php //echo number_format( $biayadaftar+$vtot, 2 , ',' , '.' ); ?></b></p></td>
						</tr>
						-->
					</tbody>
				</table>
				<br />

				<br />
			
		
	<?php 
			}
		}?>
		<h3 align="center">Total : <?php echo number_format( $vtottotal, 0 , ',' , '.' ); ?></h3>
	<?php } else {
	?>	
		<table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
			<thead>
				<tr>
					<th width="3%"><b>No</b></th>
						<th width="7%"><b>No Medrec</b></th>
						<th width="10%"><b>No Register</b></th>
						<th width="25%"><b>Nama</b></th>
						<th width="12%"><b>Cara Bayar</b></th>
						<?php if ($status=='10') echo "<th width=\"10%\"><b>Status</b></th>"; ?>
						<!--<th width="15%"><b>Biaya Daftar</b></th>-->
						<th width="10%"><b>Tunai</b></th>
						<th width="10%"><b>Diskon</b></th>
						<th width="15%"><b>Biaya Tindakan</b></th>
				</tr>				
			</thead>
			<tbody>
				<?php
				$i=1;
				$vtot=0;
				$vtottunai=0;
				$vtotdiskon=0;
				//$biayadaftar=0;
				foreach($data_laporan_keu as $row2){
				$vtot+=$row2->vtot;
				$vtottunai+=$row2->tunai;
				$vtotdiskon+=$row2->diskon;
				$vtottotal+=$row2->vtot;
				//$biayadaftar+=$row2->biayadaftar;
				?>
				<tr>
					<td width="3%"><?php echo $i++;?></td>
					<td width="7%"><?php echo $row2->no_cm;?></td>
					<td width="10%"><?php echo $row2->no_register;?></td>
					<td width="25%"><?php echo strtoupper($row2->nama);?></td>
					<td width="12%"><?php echo $row2->cara_bayar;?></td>
					<?php if ($status=='10') echo " <td width=\"10%\">".($row2->status=="1" ? "Pulang":"Dirawat")."</td>";?>
					<!--<td width="15%"><p align="right"><?php //echo number_format( $row2->biayadaftar, 2 , ',' , '.' ); ?></p></td>-->
					<td width="10%"><?php echo number_format( $row2->tunai, 2 , ',' , '.' );?></td>
					<td width="10%"><?php echo number_format( $row2->diskon, 2 , ',' , '.' );?></td>
					<td width="15%"><p align="right"><?php echo number_format( $row2->vtot, 2 , ',' , '.' ); ?></p></td>
				</tr>
			<?php
				}
			?>
				<tr>
					<td <?php echo ($status=='10' ? "colspan=\"6\" ":"colspan=\"5\" ") ?>><p align="right"><b>Total</b></p></td>
					<!--<td width="15%" bgcolor="#cdd4cb"><p align="right"><b><?php //echo number_format( $biayadaftar, 2 , ',' , '.' ); ?></b></p></td>-->
					<td bgcolor="yellow"><p align="right"><b><?php echo number_format( $vtottunai, 2 , ',' , '.' ); ?></b></p></td>
					<td bgcolor="yellow"><p align="right"><b><?php echo number_format( $vtotdiskon, 2 , ',' , '.' ); ?></b></p></td>
					<td bgcolor="yellow"><p align="right"><b><?php echo number_format( $vtot, 2 , ',' , '.' ); ?></b></p></td>
				</tr>
				<!--
				<tr>
					<td <?php //echo ($status=='10' ? "colspan=\"6\" width=\"85%\"":"colspan='5' width=\"75%\"") ?>><p align="right"><b>Total Biaya Daftar dan Tindakan</b></div></td>
					<td width="15%" BGCOLOR="yellow"><p align="right"><b><?php //echo number_format( $biayadaftar+$vtot, 2 , ',' , '.' ); ?></b></p></td>
				</tr>
				-->
			</tbody>
		</table>
		<br />		
		<br />
	<?php } 
} else {
	echo "<div class=\"content-header\">
				<div class=\"alert alert-danger alert-dismissable\">
					<button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>				
				<h4><i class=\"icon fa fa-close\"></i>
					Tidak Ditemukan Data
				</h4>							
				</div>
			</div>";
}
?> 

