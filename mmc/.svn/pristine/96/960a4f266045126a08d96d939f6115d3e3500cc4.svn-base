<div class="panel-body">
<!-- form -->
	<div class="well" >
		<!-- table -->
		<div style="display:block;overflow:auto;">
			<table id="tabel_ok" class="display" cellspacing="0" width="100%">
			  <thead>
				<tr>
				  	<th>No Ok</th>
				  	<th width="15%">Jadwal Operasi</th>
				  	<th>Jenis Pemeriksaan</th>
				  	<th>Operator</th>
				  	<th width="10%">Total Pemeriksaan</th>
				</tr>
			  </thead>
			  <tbody>
			  	<?php
			  	$total_bayar = 0;
				if(!empty($list_ok_pasien)){
					foreach($list_ok_pasien as $row){ ?>
					<tr>
						<td><?php echo $row->no_ok ; ?></td>
						<td><?php echo $row->tgl_operasi ; ?></td>
						<td><?php echo $row->jenis_tindakan.' ('.$row->id_tindakan.')' ; ?></td>
						<td>
							<?php
								echo 'Dokter : '.$row->nm_dokter.' ('.$row->id_dokter.')';
								if($row->id_opr_anes<>NULL)
								echo '<br>- Operator Anestesi: '.$row->nm_opr_anes.' ('.$row->id_opr_anes.')';
								if($row->id_dok_anes<>NULL)
								echo '<br>- Dokter Anestesi: '.$row->nm_dok_anes.' ('.$row->id_dok_anes.')';
								if($row->jns_anes<>NULL)
								echo '<br>- Jenis Anestesi: '.$row->jns_anes;
								if($row->id_dok_anak<>NULL)
								echo '<br>- Dokter Anak: '.$row->nm_dok_anak.' ('.$row->id_dok_anak.')';
							?> 
						</td>
						<td><?php echo 'Rp '.number_format( $row->vtot, 2 , ',' , '.' ); ?></td>
						<?php $total_bayar = $total_bayar + $row->vtot;?>
					</tr>
				<?php
					}
				}else{ ?>
				<tr>
						<td>Tidak Ada Operasi</td>
						<td>Tidak Ada Operasi</td>
						<td>Tidak Ada Operasi</td>
						<td>Tidak Ada Operasi</td>
						<td>Tidak Ada Operasi</td>
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
						  <td colspan="6">Total Biaya Operasi</td>
						  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
						</tr>
					</table> 	
				</div>
			</div>
		</div><!-- style overflow -->
	</div>
</div>