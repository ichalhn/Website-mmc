<table id="example" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
		  <th>No</th>
		  <th>Bulan</th>		  						 
		  <th>Jumlah Kunjungan</th>		 
		</tr>
	</thead>
	<tfoot>
		<tr>
		  <th>No</th>
		  <th>Bulan</th>						 
		  <th>Jumlah Kunjungan</th>		  
		</tr>
	</tfoot>
	<tbody>
	<?php	// print_r($pasien_daftar);
		$i=1;
		$tot_kunj=0;
		
		foreach($data_laporan_kunj as $row){
		//$no_medrec=$row->no_medrec;
		$tot_kunj=$tot_kunj+$row->jum_kunj;
	?>
	<tr>
	  <td><?php echo $i++;?></td>
	  <td><?php echo $tgl_indo->bulan(date('m', strtotime($row->bulan)));?></td>
	  <td><?php echo $row->jum_kunj;?></td>	  
	</tr>
	<?php } ?>
	</tbody>
	</table>
	<h4 align="center"><b>Total Kunjungan : <?php echo $tot_kunj;?><b></h4>
	<div class="form-inline" align="right">
		<div class="form-group">
			<a name="btnDown" class="btn btn-primary" target="_blank" href="<?php echo site_url('ird/IrDLaporan/export_excel2/'.$tampil_per.'/'.$thn);?>">Download Excel</a>
			<a name="btnCetak" class="btn btn-primary" target="_blank" href="<?php echo site_url('ird/IrDLaporan/lap_kunj/'.$tampil_per.'/'.$thn);?>">Cetak PDF</a>
		</div>
	</div>
