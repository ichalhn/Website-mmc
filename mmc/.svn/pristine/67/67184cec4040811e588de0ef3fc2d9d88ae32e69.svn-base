<?php if($cara_bayar!='SEMUA'){ ?><h4 align="center">Jenis Pasien : <?php echo $cara_bayar; ?></h4><?php } ?>
<table id="example" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<tr>
								  <th>No</th>
								  <th>No Medrec</th>
								  <th>No Register</th>
								  <th>Nama</th>	
								  <th>Jenis Pasien</th>							 
								  <th>Diagnosa</th>
								</tr>
							  <!--<th>No</th>
							  <th>No Medrec</th>
							  <th>No Register</th>
							  <th>Kunjungan</th>					
							  <th>Nama</th>								 
							  <th>L/P</th>
							  <th>Usia</th>
							  <th>Dokter</th>
							  <th>Diagnosa</th>-->
							</tr>
							</thead>
							<tfoot>
								<tr>
								  <th>No</th>
								  <th>No Medrec</th>
								  <th>No Register</th>
								  <th>Nama</th>		
								  <th>Jenis Pasien</th>						 
								  <th>Diagnosa</th>
								  
								</tr>
							</tfoot>
							<tbody>
							<?php	// print_r($pasien_daftar);
							$i=1;
								//$tot_kunj=0;
								foreach($data_laporan_kunj as $row){
								$no_medrec=$row->no_medrec;
								//$tot_kunj=$tot_kunj+$row->jum_kunj;
							?>
								<tr>
								  <td><?php echo $i++;?></td>
								  <td><?php echo $row->no_cm;?></td>
								  <td><?php echo $row->no_register;?></td>
								  <td><?php echo strtoupper($row->nama);?></td>
								  <td><?php echo strtoupper($row->cara_bayar);?></td>
								  <td><?php echo $row->diagnosa;?></td>
								  
								</tr>
										<?php } ?>
									</tbody>
								</table>
							<h4 align="center"><b>Total Kunjungan : </b><?php echo $i-1;?></h4>
							<div class="form-inline" align="right">
								<div class="form-group">
									<a id="btnDown" class="btn btn-primary" name="btnCetak" target="_blank" href="<?php echo site_url('ird/IrDLaporan/export_excel2/'.$tampil_per.'/'.$tgl.'/'.$cara_bayar);?>">Download Excel</a>
									<a id="btnCetak" class="btn btn-primary" name="btnCetak" target="_blank" href="<?php echo site_url('ird/IrDLaporan/lap_kunj/'.$tampil_per.'/'.$tgl.'/'.$cara_bayar);?>">Cetak PDF</a>
								</div>
							</div>
