<?php 
if (sizeof($data_laporan_keu)>0){
	$vtottotal=0;$vtotkunj=0;
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
						<th width="5%"><b>No</b></th>
						<th width="15%"><b>Bulan</b></th>
						<th width="20%"><b>Total Kunjungan</b></th>
						<th width="25%"><b>Total Biaya Tindakan</b></th>
					</tr>
				  </thead>
				  <tbody>
				<?php
				$i=1;
				$vtot=0;$vtot1=0;
				//$biayadaftar=0;
				foreach($data_laporan_keu as $row2){
					if ($row2->id_poli==$row1->id_poli) {
						$vtot+=$row2->jumlah_vtot;
						$vtot1+=$row2->jumlah_kunj;
						$vtottotal+=$row2->jumlah_vtot;
						$vtotkunj+=$row2->jumlah_kunj;
						//$biayadaftar+=$row2->jumlah_biayadaftar;
				?>
				<tr>
					<td width="5%"><?php echo $i++;?></td>
					<td width="15%"><?php echo $tgl_indo->bulan($row2->bulan_kunj);?></td>
					<td width="20%"><?php echo $row2->jumlah_kunj;?></td>
					<!--<td width="20%"><p align="right"><?php //echo number_format( $row2->jumlah_biayadaftar, 2 , ',' , '.' ); ?></p></td>-->
					<td width="25%"><p align="right"><?php echo number_format( $row2->jumlah_vtot, 2 , ',' , '.' ); ?></p></td>
				</tr>
				<?php
					}
				}
				?>
				<tr>
					<td colspan="2" width="20%"><p align="right"><b>Total</b></p></td>
					<td width="20%" bgcolor="yellow"><p align="right"><b><?php echo $vtot1;?></b></p></td>
					<!--<td width="20%" bgcolor="#cdd4cb"><p align="right"><b><?php //echo number_format( $biayadaftar, 2 , ',' , '.' ); ?></b></p></td>-->
					<td width="25%" bgcolor="yellow"><p align="right"><b><?php echo number_format( $vtot, 2 , ',' , '.' ); ?></b></p></td>
				</tr>
				<!--
				<tr>
					<td width="40%" colspan="3"><p align="right"><b>Total Biaya Daftar dan Tindakan</b></p></td>
					<td width="25%" BGCOLOR="yellow"><p align="right"><b><?php //echo number_format( $biayadaftar+$vtot, 2 , ',' , '.' ); ?></b></p></td>
				</tr>
				-->
				</tbody>
				</table>
				<br />
				<br />
				
			<?php 
				}
			} //end if data tdk kosong?>
		<h3 align="center">Total Biaya : <?php echo number_format( $vtottotal, 0 , ',' , '.' ); ?></h3>
		<h3 align="center">Total Kunjungan : <?php echo $vtotkunj; ?></h3>
	<?php } else {
		?>
			 
		<table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
			<thead>
				<tr>
					<th width="5%"><b>No</b></th>
					<th width="15%"><b>Bulan</b></th>
					<th width="20%"><b>Total Kunjungan</b></th>
					<th width="25%"><b>Total Biaya Tindakan</b></th>
				</tr>
			</thead>
			<tbody>
			<?php
			$i=1;
			$vtot=0;$vtot1=0;
			//$biayadaftar=0;
			foreach($data_laporan_keu as $row){
				$vtot+=$row->jumlah_vtot;
				$vtot1+=$row->jumlah_kunj;
				//$biayadaftar+=$row->jumlah_biayadaftar;
			?>
			<tr>
				<td width="5%"><?php echo $i++;?></td>
				<td width="15%"><?php echo $tgl_indo->bulan($row->bulan_kunj);?></td>
				<td width="20%"><p align="right"><b><?php echo $row->jumlah_kunj;?></b></p></td>
				<!--<td width="20%"><p align="right"><?php //echo number_format( $row->jumlah_biayadaftar, 2 , ',' , '.' ); ?></p></td>-->
				<td width="25%"><p align="right"><?php echo number_format( $row->jumlah_vtot, 2 , ',' , '.' ); ?></p></td>
			</tr>
			<?php
			}
			?>
			<tr>
				<td colspan="2" width="20%"><p align="right"><b>Total</b></p></td>
				<td width="20%" bgcolor="yellow"><p align="right"><b><?php echo $vtot1;?></b></p></td>
				<!--<td width="20%" bgcolor="#cdd4cb"><p align="right"><b><?php echo number_format( $biayadaftar, 2 , ',' , '.' ); ?></b></p></td>-->
				<td width="25%" bgcolor="yellow"><p align="right"><b><?php echo number_format( $vtot, 2 , ',' , '.' ); ?></b></p></td>
			</tr>
			<!--
			<tr>
				<td width="40%" colspan="3"><p align="right"><b>Total Biaya Daftar dan Tindakan</b></p></td>
				<td width="25%" BGCOLOR="yellow"><p align="right"><b><?php echo number_format( $biayadaftar+$vtot, 2 , ',' , '.' ); ?></b></p></td>
			</tr>
			-->
			</tbody>
		</table>
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
