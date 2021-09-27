<div class="panel-body">
<!-- form -->
	<div class="well" >
		<!-- table -->
		<div style="display:block;overflow:auto;">
			<div class="form-inline" align="right">
				<div class="input-group">
				<?php
				if(!empty($cetak_resep_pasien)){
					echo form_open('farmasi/Frmckwitansi/cetak_faktur_resep_kt');
				?>
					<select id="no_resep" class="form-control" name="no_resep"  required>
						<?php 
							foreach($cetak_resep_pasien as $row){
								echo "<option value=".$row->no_resep." selected>".$row->no_resep."</option>";
							}
						?>
					</select>
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary">Cetak Faktur</button>
					</span>
			
				<?php 
					echo form_close();
				}else{
					echo "Faktur Belum Keluar";
				}
				?>	
				</div>
			</div>
			<br>
			<table id="tabel_resep" class="display" cellspacing="0" width="100%">
			  <thead>
				<tr>
				  <th>No Resep</th>
				  <th>Nama Obat</th>
				  <th>Tgl Tindakan</th>
				  <th>Satuan Obat</th>	
				  <th>Biaya Obat</th>			  
				  <th>Qty</th>
				  <th>Total</th>
				</tr>
			  </thead>
			  <tbody>
			  	<?php
			  	$total_bayar = 0;
				if(!empty($list_resep_pasien)){
					foreach($list_resep_pasien as $r){ ?>
					<tr>
						<td><?php echo $r->no_resep ; ?></td>
						<td><?php echo $r->nama_obat ; ?></td>
						<td><?php 
						$tgl_indo = $controller->obj_tanggal();

				  		$bln_row = $tgl_indo->bulan(substr($r->xupdate,6,2));
				  		$tgl_row = substr($r->xupdate,8,2);
				  		$thn_row = substr($r->xupdate,0,4);

				  		echo $tgl_row." ".$bln_row." ".$thn_row;

						?></td>
						<td><?php echo $r->Satuan_obat ; ?></td>
						<td>Rp. <?php echo number_format($r->biaya_obat,0) ; ?></td>
						<td><?php echo $r->qty ; ?></td>
						<td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
						<?php $total_bayar = $total_bayar + $r->vtot;?>
					</tr>
					<?php
					}
				}else{ ?>
				<tr>
						<td>Data Kosong</td>
						<td>Data Kosong</td>
						<td>Data Kosong</td>
						<td>Data Kosong</td>
						<td>Data Kosong</td>
						<td>Data Kosong</td>
						<td>Data Kosong</td>
					</tr>
				<?php
				}
				?>
			  </tbody>
			</table>
			
			<div class="form-inline" align="right">
				<div class="input-group">
					<table width="100%" class="table table-hover table-striped table-bordered">
						<tr>
						  <td colspan="6">Total Resep</td>
						  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
						</tr>
					</table> 	
				</div>
			</div>
		</div><!-- style overflow -->
	</div>
</div>
