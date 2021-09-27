
											<thead>
												<tr>
								  <th>No</th>
								  <th>Tanggal Permintaan Obat</th>
								  <th>Item Obat</th>
								  <th>Harga Obat</th>
								  <th>Signa</th>
								  <th>Qty</th>
								  <th>Total</th>
								  <th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php
													// print_r($pasien_daftar);
													
													$i=1;	if($data_obat_pasien!=''){
														foreach($data_obat_pasien as $row){
														//$id_pelayanan_poli=$row->id_pelayanan_poli;
														
													?>
														<tr>
															<td><?php echo $i++ ; ?></td>
															<td><?php echo $row->xupdate; ?></td>
															<td><?php echo $row->nama_obat.' ('.$row->item_obat.')' ; ?></td>
															<td><?php echo number_format( $row->biaya_obat, 2 , ',' , '.' );?></td>
															<td><?php echo $row->Signa ; ?></td>
															<td><?php echo $row->qty ; ?></td>
															<td><?php echo number_format( $row->vtot, 2 , ',' , '.' );?></td>
															<td><?php
																if ($a_obat =="closed") {
											
																	echo "<a href=\"javascript: void(0)\" class=\"btn btn-danger btn-xs\">Hapus</a>";
																
																} else {
																
		
echo '<a  href="'.site_url('ird/IrDPelayanan/hapus_data_resep/'.$no_register.'/'.$row->id_resep_pasien).'" class="btn btn-danger btn-xs">Hapus</a>
';
																}
																?>

														</tr>
													<?php
														}}
													?>
											</tbody>
										</table>
									
									</div><!-- style overflow -->
