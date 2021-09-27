<?php
if (sizeof($data_laporan_kunj)>0){ 
	if ($id_poli=="SEMUA") {
		$vtot1=0;
		foreach($poli as $row1){ 
		
			$array = json_decode(json_encode($data_laporan_kunj), True);
			$data_poli=array_column($array, 'id_poli');
			
			//Klo data tdk kosong, tampilkan
			if (in_array($row1->id_poli, $data_poli)) {	
		?>		
				<br />
				<h4><b>Poliklinik : <?php echo $row1->nm_poli ?></b></h4>
				<table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
				  <thead>
					<tr>
						<th width="5%"><b>No</b></th>
						<th width="30%"><b>Bulan</b></th>
						<th width="30%"><b>Jumlah Kunjungan</b></th>
					</tr>
				  </thead>
				  <tbody>
				<?php
				$i=1;
				$vtot=0;
				foreach($data_laporan_kunj as $row2){
					if ($row2->id_poli==$row1->id_poli) {
						$vtot=$vtot+$row2->jumlah_kunj;
						$vtot1=$vtot1+$row2->jumlah_kunj;
				?>
				<tr>
					<td width="5%"><?php echo $i++;?></td>
					<td width="30%"><?php echo $tgl_indo->bulan($row2->bulan_kunj);?></td>
					<td width="30%"><p align="right"><?php echo $row2->jumlah_kunj;?></p></td>
				</tr>
				<?php
					}
				}
				?>
				<tr>
					<td colspan="2"><p align="right"><b>Total</b></p></td>
					<td BGCOLOR="yellow"><p align="right"><b><?php echo $vtot;?></b></p></td>
				</tr>
				</tbody>
				</table>
				<br />
				<br />
	<?php 
			}
		}
	} else {
	?>
			 
		<table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
			<thead>
				<tr>
				  <th width="5%"><b>No</b></th>
				  <th width="30%"><b>Bulan</b></th>
				  <th width="30%"><b>Jumlah Kunjungan</b></th>
				</tr>
			</thead>
			<tbody>
			<?php
			$i=1;
			$vtot=0;
			foreach($data_laporan_kunj as $row){
			$vtot=$vtot+$row->jumlah_kunj;
			$vtot1=$vtot1+$row2->jumlah_kunj;
			?>
			<tr>
				<td width="5%"><?php echo $i++;?></td>
				<td width="30%"><?php echo $tgl_indo->bulan($row->bulan_kunj);?></td>
				<td width="30%"><p align="right"><?php echo $row->jumlah_kunj;?></p></td>
			</tr>
			<?php
			}
			?>
			<tr>
				<td colspan="2"><p align="right"><b>Total</b></p></td>
				<td BGCOLOR="yellow"><p align="right"><b><?php echo $vtot;?></b></p></td>
			</tr>
			</tbody>
		</table>
	<?php 
	} ?><h3 align="center">Total Kunjungan : <?php echo $vtot1;?></h3><?php
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
