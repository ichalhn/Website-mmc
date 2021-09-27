<div class="panel-body">	
									<!-- form -->
									<div class="well">
										<?php echo form_open('irj/rjcpelayanan/insert_pemeriksaan'); ?>
										
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nmdokter">Dokter *</p>
										<div class="col-sm-4">
												<!--
												<input type="search" style="width:100%" class="auto_search_tindakan form-control" placeholder="" id="nmtindakan" name="nmtindakan" required>
												<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan"  name="idtindakan">
												-->
												<div class="form-group">
													<select id="id_dokter" class="form-control select2" style="width:100%" name="id_dokter"  required>
														<option value="">-Pilih Dokter-</option>
														<?php 
															foreach($dokter_lab as $row){
																echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
															}
														?>
													</select>
												</div>
										</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="tindakan">Pemeriksaan *</p>
										<div class="col-sm-4">
												<!--
												<input type="search" style="width:100%" class="auto_search_tindakan form-control" placeholder="" id="nmtindakan" name="nmtindakan" required>
												<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan"  name="idtindakan">
												-->
												<div class="form-group">
													<select id="idtindakan" class="form-control select2" style="width:100%" name="idtindakan" onchange="pilih_tindakan_lab(this.value)" required>
														<option value="">-Pilih Pemeriksaan-</option>
														<?php 
															foreach($tindakan_lab as $row){
																echo '<option value="'.$row->idtindakan.'">'.$row->nmtindakan.'</option>';
															}
														?>
													</select>
												</div>
										</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Biaya Pemeriksaan</p>
									<div class="col-sm-3">
										<div class="input-group">
											<span class="input-group-addon">Rp</span>
											<input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>" name="biaya_lab" id="biaya_lab" disabled>
											<input type="hidden" class="form-control" value="" name="biaya_lab_hide" id="biaya_lab_hide">
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qtyind">Qtyind *</p>
									<div class="col-sm-2">
										<input type="number" class="form-control" name="qty_lab" id="qty_lab" min=1 onchange="set_total_lab(this.value)" required>
									</div>
								</div>
								<!--<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_dijamin">Dijamin</p>
									<div class="col-sm-10">
										<input type="text" class="form-control" value="" name="dijamin">
									</div>
								</div>
								-->
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_vtot">Total</p>
									<div class="col-sm-3">
										<div class="input-group">
											<span class="input-group-addon">Rp</span>
											<input type="text" class="form-control" name="vtot_lab" id="vtot_lab" disabled>
											<input type="hidden" class="form-control" value="" name="vtot_lab_hide" id="vtot_lab_hide">
										</div>
									</div>
								</div>
								
								<div class="form-inline" align="right">
									<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kunj">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
									<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
									<!--<input type="hidden" class="form-control" value="<?php //echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php //echo $bed;?>" name="bed">-->
									<input type="hidden" class="form-control" value="<?php echo $no_lab;?>" name="no_lab">
									<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
									<div class="form-group">
										<button type="reset" id="button_reset_lab" class="btn bg-orange">Reset</button>
										<button type="submit" id="button_simpan_lab" class="btn btn-primary">Simpan</button>

									</div>
								</div>
							<?php echo form_close();?>

							<!-- table -->
										<br>
									<div style="display:block;overflow:auto;">
										<table id="tabel_lab" class="display" cellspacing="0" width="100%">
											<thead>
												<tr>
												  	<th>No</th>
												  	<th>Tanggal Pemeriksaan</th>
												  	<th>Dokter</th>
												  	<th>Jenis Pemeriksaan</th>
												  	<th>Biaya Pemeriksaan</th>
												  	<th>Qtyind</th>
												  	<th>Total</th>
												  	<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												
												<?php
													$i=1;
													foreach($data_pemeriksaan as $row){
														//$id_pelayanan_poli=$row->id_pelayanan_poli;
														
													?>
														<tr>
															<td><?php echo $i++ ; ?></td>
															<td><?php echo $row->xupdate ; ?></td>
															<td><?php echo $row->nm_dokter.' ('.$row->id_dokter.')' ; ?></td>
															<td><?php echo $row->jenis_tindakan.' ('.$row->id_tindakan.')' ; ?></td>
															<td><?php echo $row->biaya_lab ; ?></td>
															<td><?php echo $row->qty ; ?></td>
															<td><?php echo $row->vtot  ; ?></td>
															<td>
																<!-- Button trigger modal -->
																<?php
																if ($a_lab =="closed") {
											
																	echo "<a href=\"javascript: void(0)\" class=\"btn btn-danger btn-xs\">Hapus</a>";
																
																} else {
																
																	echo "<a href=\"".site_url("irj/Rjcpelayanan/hapus_data_pemeriksaan/".$id_poli."/".$row->no_register."/lab/".$no_lab."/".$row->id_pemeriksaan_lab)."\" class=\"btn btn-danger btn-xs\">Hapus</a>";
																}
																?>
															</td>
														</tr>
													<?php
														}
													?>
											</tbody>
										</table>
									
									</div><!-- style overflow -->
									<br>
								<div class="form-inline" align="right">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<div class="form-group">
										<a href="<?php echo site_url('irj/Rjcpelayanan/selesai_daftar_pemeriksaan/'.$id_poli.'/'. $no_register.'/lab'); ?>" class="btn btn-primary btn-xl" id="button_selesai_lab">Selesai</a>
									</div>
								</div>
									
									</div><!-- style overflow -->
								</div> 