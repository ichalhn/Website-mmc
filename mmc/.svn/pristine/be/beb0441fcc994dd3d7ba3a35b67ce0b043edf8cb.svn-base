<?php
//print_r($datakeu_dokter); 
if (sizeof($datakeu_dokter)>0){
	if ($id_dokter=="SEMUA") {
		foreach($dokter as $row1){ 

			//$array = json_decode(json_encode($datakeu_dokter), True);
			//print_r($datakeu_dokter);
			//$data_id_dokter=array_column($array, 'id_dokter');
			//Klo data tdk kosong, tampilkan
			//print_r($row1->id_dokter);
			//echo array_intersect($datakeu_dokter, $data_id_dokter);
	?>	
		
				<h4><b>Dokter : <?php echo '('.$row1->id_dokter.') '.$row1->nm_dokter ?></b></h4>
				<table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
				<thead>
					<tr>
						<th width="12%"><b>Tanggal</b></th>
						<th width="13%"><b>No Medrec</b></th>
						<th width="16%"><b>Nama</b></th>
						<th width="8%"><b>Ruang</b></th>
						<th width="30%"><b>Tindakan</b></th>
						<th width="6%"><b>Inst.</b></th>
						<th width="15%"><b>Biaya</b></th>
						
					</tr>
				</thead>
				<tbody>
				<?php
				//$i=1;
				$total=0;
				foreach($datakeu_dokter as $row2){
					//echo $row2->id_dokter.' - '.$row1->id_dokter.' ';
					if ($row2->id_dokter==$row1->id_dokter) {
					$total+=$row2->vtot;
				?>
					<tr>
						<td width="12%"><?php echo $row2->tgl;?></td>
						<td width="13%"><?php echo $row2->no_cm;?></td>
						<td width="16%"><?php echo $row2->nama;?></td>
						<td width="8%"><?php if($row2->idrg!=''){ echo $row2->idrg;}else { echo '-';}?></td>
						<td width="30%"><?php echo $row2->nmtindakan;?></td>
						<td width="6%"><?php echo $row2->instalasi;?></td>
						<td width="15%"><p align="right"><?php echo number_format( $row2->vtot, 2 , ',' , '.' ); ?></p></td>
						
					</tr>
				<?php
					}
				}
				?>
					<tr>
						<td colspan="6" width="85%"><p align="right"><b>Total</b></p></td>
						<td width="15%" bgcolor="yellow"><p align="right"><b><?php echo number_format( $total, 2 , ',' , '.' ); ?></b></p></td>
						
					</tr>
				</tbody>
				</table>
				<br />
				<br />


				<?php 
			
			
		}
	} else {
		?>	
		<table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
		<thead>
			<tr>
				<th width="12%"><b>Tanggal</b></th>
				<th width="13%"><b>No Medrec</b></th>
				<th width="16%"><b>Nama</b></th>
				<th width="8%"><b>Ruang</b></th>
				<th width="30%"><b>Tindakan</b></th>
				<th width="6%"><b>Inst.</b></th>
				<th width="15%"><b>Biaya</b></th>
			</tr>
		</thead>
		<tbody>
		<?php
		$i=1;
		$total=0;
		foreach($datakeu_dokter as $row2){
			$total+=$row2->vtot;
		?>
			<tr>
				<td width="12%"><?php echo $row2->tgl;?></td>
				<td width="13%"><?php echo $row2->no_medrec;?></td>
				<td width="16%"><?php echo $row2->nama;?></td>
				<td width="8%"><?php echo $row2->idrg;?></td>
				<td width="30%"><?php echo $row2->nmtindakan;?></td>
				<td width="6%"><?php echo $row2->instalasi;?></td>
				<td width="15%"><p align="right"><?php echo number_format( $row2->vtot, 2 , ',' , '.' ); ?></p></td>
				
			</tr>
		<?php
		}
		?>
			<tr>
				<td colspan="6"  width="85%"><p align="right"><b>Total</b></p></td>
				<td width="15%" bgcolor="yellow"><p align="right"><b><?php echo number_format( $total, 2 , ',' , '.' ); ?></b></p></td>
			</tr>
		</tbody>
		</table>
		<br />
		<br />
	<?php 
	}
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
						
