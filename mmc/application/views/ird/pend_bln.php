<table class="table table-hover table-bordered">
				  <thead>
					<tr>
								  <th >No</th>
								  <th >Hari</th>
								  <th>Total Tindakan</th>
								  <th >Total Potongan/Dijamin</th>
								  <th>Total Biaya Tindakan</th>
								</tr>
							  </thead>
							  <tbody>
							  
						<?php
							$i=1;
							$vtot1=0;
							$vtot2=0;$vtot3=0;$vtot4=0;
							foreach($data_laporan_keu as $row){
							$vtot1=$vtot1+$row->total;
							$vtot4=$vtot4+$row->jum_kunj;
							$vtot3=$vtot3+$row->totdiskon;
						?>
							<tr>
								<td><?php echo $i++;?></td>
								<td><?php echo $row->hari;?></td>
								<td><?php echo $row->jum_kunj;?></td>
								<td>Rp <div class="pull-right"><?php echo number_format( $row->totdiskon, 2 , ',' , '.' );?></div></td>
								<td>Rp <div class="pull-right"><?php echo number_format( $row->total, 2 , ',' , '.' );?></div></td>
							</tr>
						<?php
							}
						?>
							<tr>								
								<td colspan="2" align="right"><b>Total</b></td>
								<td><div class="pull-right"><b><?php echo $vtot4;?></b></div></td>
								<td>Rp <div class="pull-right"><b><?php echo number_format( $vtot3, 2 , ',' , '.' );?></b></div></td>
								<td>Rp <div class="pull-right"><b><?php echo number_format( $vtot1, 2 , ',' , '.' );?></b></div></td>
							</tr>
							
							  </tbody>
							 </table>							
							<div class="form-inline" align="right">
								<div class="form-group">
									<a id="btnDown" name="btnDown" class="btn btn-primary" target="_blank" href="<?php echo site_url('ird/IrDLaporan/export_excel/'.$tampil_per.''.$status.'/'.$bln.'/'.$psn);?>" >Download Excel</a>
									<a id="btnCetak" name="btnCetak" class="btn btn-primary" target="_blank" href="<?php echo site_url('ird/IrDLaporan/lap_keu/'.$tampil_per.''.$status.'/'.$bln.'/'.$psn);?>">Cetak</a>
								</div>
							</div>
