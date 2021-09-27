<div class="panel-body">
<!-- form -->
	<div class="well" >
		<!-- table -->
		<div style="display:block;overflow:auto;">
			<div class="form-inline" align="right">
				<div class="input-group">
				<?php
				if(!empty($cetak_pa_pasien)){
					echo form_open('pa/pacpengisianhasil/st_cetak_hasil_pa_rawat');
				?>
					<select id="no_pa" class="form-control" name="no_pa"  required>
						<?php 
							foreach($cetak_pa_pasien as $row){
								echo "<option value=".$row->no_pa." selected>".$row->no_pa."</option>";
							}
						?>
					</select>
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary">Cetak Hasil</button>
					</span>
			
				<?php 
					echo form_close();
				}else{
					echo "Hasil Pemeriksaan Belum Keluar";
				}
				?>	
				</div>
			</div>
			<br>
			<table id="tabel_pa" class="display" cellspacing="0" width="100%">
			  <thead>
				<tr>
				  <th>No Pa</th>
				  <th>Jenis Tindakan</th>
				  <th>Tgl Tindakan</th>
				  <th>Dokter</th>
				  <th>Harga Satuan</th>
				  <th>Qty</th>
				  <th>Total</th>
				</tr>
			  </thead>
			  <tbody>
			  	<?php
			  	$total_bayar = 0;
				if(!empty($list_pa_pasien)){
					foreach($list_pa_pasien as $r){ ?>
					<tr>
						<td><?php echo $r->no_pa ; ?></td>
						<td><?php echo $r->jenis_tindakan ; ?></td>
						<td><?php 
						$tgl_indo = $controller->obj_tanggal();

				  		$bln_row = $tgl_indo->bulan(substr($r->xupdate,6,2));
				  		$tgl_row = substr($r->xupdate,8,2);
				  		$thn_row = substr($r->xupdate,0,4);

				  		echo $tgl_row." ".$bln_row." ".$thn_row;

						?></td>
						<td><?php echo $r->nm_dokter ; ?></td>
						<td>Rp. <?php echo number_format($r->biaya_pa,0) ; ?></td>
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
						  <td colspan="6">Total Patologi Anatomi</td>
						  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
						</tr>
					</table> 	
				</div>
			</div>
		</div><!-- style overflow -->
	</div>
</div>