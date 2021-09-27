<table class="table table-hover table-bordered table-responsive">
				  <thead>
					<tr>
								  <th >No</th>
								  <th >No Medrec</th>
								  <th >No Register</th>
								  <th >Nama</th>
								 <?php if($stat_pilih==''){
									echo ' <th>Status</th>';
									}?>		
								  <th>Gol. Pasien</th>						 
								  <th>Potongan/Jaminan</th>
								  <th>Biaya Tindakan</th>
								  
								</tr>
							  </thead>
							  <tbody>
							  
						<?php
							$i=1;
							$vtot1=0;$vtot3=0;
							foreach($data_laporan_keu as $row){
							$vtot1=$vtot1+$row->total;						
							$vtot3=$vtot3+$row->diskon;
						?>
							<tr>
								<td><?php echo $i++;?></td>
								<td><?php echo $row->no_cm;?></td>
								<td><?php echo $row->no_register;?></td>
								<td><?php echo strtoupper($row->nama);?></td>
								<?php if($stat_pilih==''){
									if($row->status=='1'){
										echo ' <td>Pulang</td>';
									}else {
										echo ' <td>Dirawat</td>';}
									
								}?>
								<td><?php echo strtoupper($row->cara_bayar);?></td>
								<td>Rp <div class="pull-right"><?php echo number_format( $row->diskon, 2 , ',' , '.' );?></div></td>
								<td>Rp <div class="pull-right"><?php echo number_format( $row->total, 2 , ',' , '.' );?></div></td>
							</tr>
						<?php
							}
						?>
							<tr>								
								<td colspan="<?php if($stat_pilih==''){ echo '6';} else echo "5";?>" align="right"><b>Total</b></td>
								<td>Rp <div class="pull-right"><b><?php echo number_format( $vtot3, 2 , ',' , '.' );?></b></div></td>
								<td>Rp <div class="pull-right"><b><?php echo number_format( $vtot1, 2 , ',' , '.' );?></b></div></td>
							</tr>
							
							  </tbody>
							 </table>						
							<div class="form-inline" align="right">
								<div class="form-group">
									<a id="btnDown" name="btnDown" class="btn btn-primary" target="_blank" href="<?php echo site_url('ird/IrDLaporan/export_excel/'.$tampil_per.''.$status.'/'.$tgl.'/'.$psn);?>" >Download Excel</a>
									<a id="btnCetak" name="btnCetak" class="btn btn-primary" target="_blank" href="<?php echo site_url('ird/IrDLaporan/lap_keu/'.$tampil_per.''.$status.'/'.$tgl.'/'.$psn);?>">Cetak</a>
								</div>
							</div>
