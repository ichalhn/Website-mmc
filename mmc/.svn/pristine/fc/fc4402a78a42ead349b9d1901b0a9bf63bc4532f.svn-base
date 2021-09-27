<table class="table table-hover table-bordered table-responsive">
				  <thead>
					<tr>
								  <th><p align="center">No</p></th>
								  <th><p align="center">Item Obat</p></th>
								  <th><p align="center">Qty</p></th>
								  <!--<th >Harga Satuan</th>-->
								  <th><p align="center">Total Biaya Obat</p></th>
								</tr>
							  </thead>
							  <tbody>
							  
						<?php
							$i=1;
							$vtot1=0;$vtot2=0;
							foreach($data_laporan_keu as $row){
							$vtot1=$vtot1+$row->vtot;
						?>
							<tr>
								<td align="center"><?php echo $i++;?></td>
								<td><?php echo $row->nama_obat;?></td>
								<td align="center"><?php echo $row->qty;?></td>
								<!--<td><?php echo $row->biaya_obat;?></td>-->
								<td>Rp <div class="pull-right"><?php echo number_format( $row->vtot, 2 , ',' , '.' );?></div></td>
							</tr>
						<?php
							}
						?>
							<tr>								
								<td colspan="3" align="right"><b>Total</b></td>
								<td>Rp <div class="pull-right"><b><?php echo number_format( $vtot1, 2 , ',' , '.' );?></b></div></td>
								</tr>	
							  </tbody>
							 </table>
							 <br>					
							<div class="form-inline" align="right">
								<div class="form-group">
									<a id="btnExcel" name="btnExcel" class="btn btn-primary" href="<?php echo site_url('farmasi/Frmclaporan/export_excel/'.$tampil_per.'/'.$tgl);?>">Download Excel</a>
									<a id="btnCetak" name="btnCetak" class="btn btn-primary" target="_blank" href="<?php echo site_url('farmasi/Frmclaporan/lap_keu/'.$tampil_per.'/'.$tgl);?>">Cetak PDF</a>
								</div>
							</div>
