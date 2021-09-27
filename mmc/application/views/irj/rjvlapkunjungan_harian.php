<?php 
if (sizeof($data_laporan_kunj)>0){
	if ($id_poli=="SEMUA") {
		$vtot=0;
		foreach($poli as $row1){ 
			
			$array = json_decode(json_encode($data_laporan_kunj), True);
			$data_poli=array_column($array, 'id_poli');
		
			//Klo data tdk kosong, tampilkan
			if (in_array($row1->id_poli, $data_poli)) {	
		?>
			<h4><b>Poliklinik : <?php echo $row1->nm_poli ?></b></h4>
			<table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
				<thead>
					<tr>
						<th width="5%"><b>No</b></th>
						<th width="10%"><b>No MR</b></th>
						<th width="10%"><b>No Register</b></th>
						<th width="25%"><b>Nama</b></th>
						<th width="10%"><b>Cara Bayar</b></th>
						<th width="25%"><b>Diagnosa Utama</b></th>
						<th width="25%"><b>Dokter</b></th>
						<th width="20%"><b>Keterangan</b></th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i=1;
					
					foreach($data_laporan_kunj as $row2){
					//$vtot=$vtot+$row->jumlah_kunj;
						if ($row2->id_poli==$row1->id_poli) {						
					?>
					<tr>
						<td width="5%"><?php echo $i++;?></td>
						<td width="10%"><?php echo $row2->no_cm;?></td>
						<td width="10%"><?php echo $row2->no_register;?></td>
						<td width="25%"><?php echo strtoupper($row2->nama);?></td>					
						<td width="10%"><?php if($row2->cara_bayar=='DIJAMIN / JAMSOSKES'){
							echo $row2->kontraktor;
						}else echo $row2->cara_bayar;?></td>
						<td width="25%"><?php echo $row2->diagnosa;?></td>
						<td width="25%"><?php echo $row2->nm_dokter;?></td>
						<td width="20%"><?php echo str_replace('_', ' ',$row2->ket_pulang);?></td>
					</tr>
				<?php
						}
					}
					$vtot=$vtot+($i-1);
				?>
					<tr>
						<td colspan="6"><p align="right"><b>Total</b></p></td>
						<td BGCOLOR="yellow"><p align="right"><b><?php echo $i-1;?></b></p></td>
					</tr>
				</tbody>
			</table>	
				
			<br />
		
	<?php 
			}
		}
		?><h3 align="center">Total Kunjungan : <?php echo $vtot;?></h3>
	<?php } else {
	?>	
		<table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
			<thead>
				<tr>
					<th width="5%"><b>No</b></th>
					<th width="10%"><b>No MR</b></th>
					<th width="10%"><b>No Register</b></th>
					<th width="20%"><b>Nama</b></th>
					<th width="10%"><b>Cara Bayar</b></th>
					<th width="20%"><b>Diagnosa Utama</b></th>
					<th width="20%"><b>Dokter</b></th>
					<th width="15%"><b>Keterangan</b></th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i=1;
				foreach($data_laporan_kunj as $row2){
				?>
				<tr>
					<td width="5%"><?php echo $i++;?></td>
					<td width="10%"><?php echo $row2->no_cm;?></td>
					<td width="10%"><?php echo $row2->no_register;?></td>
					<td width="20%"><?php echo strtoupper($row2->nama);?></td>					
					<td width="10%"><?php if($row2->cara_bayar=='DIJAMIN / JAMSOSKES'){
							echo $row2->kontraktor;
						}else echo $row2->cara_bayar;?></td>
					<td width="20%"><?php echo $row2->diagnosa;?></td>
					<td width="15%"><?php echo str_replace('_', ' ',$row2->ket_pulang);?></td>
				</tr>
			<?php
				}
			?>
				<tr>
					<td colspan="6"><p align="right"><b>Total</b></p></td>
					<td BGCOLOR="yellow"><p align="right"><b><?php echo $i-1;?></b></p></td>
				</tr>
			</tbody>
		</table>
		<br>
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
?>

