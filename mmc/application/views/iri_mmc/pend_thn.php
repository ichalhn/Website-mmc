<table class="table table-hover table-bordered">
				  <thead>
					<tr>
								  <th>No</th>
								  <th>Bulan</th>
								  <th>Total Pasien</th>
								  <th>Total Potongan/Dijamin</th>
								  <th>Total Biaya Tindakan</th>
								</tr>
							  </thead>
							  <tbody>
							  
						<?php
							$i=1;
							$vtot1=0;$vtot2=0;$vtot3=0;$vtot4=0;
							
							foreach($data_laporan_keu as $row){
							//$vtot1=$vtot1+$row->totdaftar;
							$vtot4=$vtot4+$row->jum_tind;
							$vtot2=$vtot2+$row->total;
							$vtot3=$vtot3+$row->diskon;
						?>
							<tr>
								<td><?php echo $i++;?></td>
								<td><?php echo $tgl_indo->bulan(date('m', strtotime($row->bulan)));?></td>
								<td><?php echo $row->jum_tind;?></td>
								<td>Rp <div class="pull-right"><?php echo number_format( $row->diskon, 2 , ',' , '.' );?></div></td>
								<td>Rp <div class="pull-right"><?php echo number_format( $row->total, 2 , ',' , '.' );?></div></td>
							</tr>
						<?php
							}
						?>
							<tr>								
								<td colspan="2" align="right"><b>Total</b></td>
								<td><div class="pull-right"><b><?php echo $vtot4;?></b></div></td>
								<td>Rp <div class="pull-right"><b><?php echo number_format( $vtot3, 2 , ',' , '.' );?></b></div></td>
								<td>Rp <div class="pull-right"><b><?php echo number_format( $vtot2, 2 , ',' , '.' );?></b></div></td>
							</tr>
							
							  </tbody>
							 </table>							
							<div class="form-inline" align="right">
								<div class="form-group">
									<a target="_blank" id="btnDown" name="btnDown" class="btn btn-primary" href="<?php echo site_url('iri/rilaporan/export_excel/'.$tampil_per.''.$status.'/'.$thn.'/'.$psn);?>">Download Excel</a>
									<a target="_blank" id="btnCetak" name="btnCetak" class="btn btn-primary" href="<?php echo site_url('iri/rilaporan/lap_keu/'.$tampil_per.''.$status.'/'.$thn.'/'.$psn);?>">Cetak PDF</a>
								</div>
							</div>
