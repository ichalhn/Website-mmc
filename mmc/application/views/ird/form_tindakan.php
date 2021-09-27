<div class="panel-body">						
							<!-- form -->
							<div class="well" >
							<?php echo form_open('ird/IrDPelayanan/insert_pelayanan_tindakan'); ?>
							
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="tindakan">Tindakan</p>
										<div class="col-sm-8">
											<select id="idtindakan" class="form-control select2" name="idtindakan" onchange="pilih_tindakan(this.value)" style="width:100%;" required>
											<option value="">-Pilih Tindakan-</option>
												<?php foreach($tindakan as $row){
																	echo '<option value="'.$row->idtindakan.'@'.$row->nmtindakan.'">'.$row->nmtindakan.'&nbsp;&nbsp;['.$row->idtindakan.']</option>';
																}
																?>
															</select>
											
										</div>
								</div>

								<div class="form-group row" id="dokterDiv">
									<p class="col-sm-4 form-control-label" >Dokter</p>
										<div class="col-sm-8">
																					

											<select class="form-control select2" name="dokterTindakan" id="dokterTind" style="width:100%;" required>
											<option value="">-Pilih Dokter-</option>											
													<?php 
												
													foreach($operator as $row){
														echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'">'.$row->nm_dokter.'&nbsp;&nbsp;['.$row->id_dokter.']</option>';
													}
													?>
											</select>

											

										</div>
								</div><!-- 
								<div class="form-group row" id="dokterAnasDiv">
									<p class="col-sm-4 form-control-label" >Dokter Anastesi *)</p>
										<div class="col-sm-8">
																					

											<select class="form-control select2" name="dokterAnasTindakan" id="dokterAnasTind" style="width:100%;" >
											<option value="">-Pilih Dokter Anastesi-</option>											
													<?php 
												
													foreach($operator as $row){
														echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'">'.$row->nm_dokter.'&nbsp;&nbsp;['.$row->id_dokter.']</option>';
													}
													?>
											</select>

											

										</div>
								</div>
								<div class="form-group row" id="penataAnasDiv">
									<p class="col-sm-4 form-control-label" >Penata Anastesi *)</p>
										<div class="col-sm-8">
																					

											<select class="form-control select2" name="penataAnasTindakan" id="penataAnasTind" style="width:100%;" >
											<option value="">-Pilih Penata Anastesi-</option>											
													<?php 
												
													foreach($operator as $row){
														echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'">'.$row->nm_dokter.'&nbsp;&nbsp;['.$row->id_dokter.']</option>';
													}
													?>
											</select>

											

										</div>
								</div>
								<div class="form-group row" id="asistDokDiv">
									<p class="col-sm-4 form-control-label" >Asisten Dokter *)</p>
										<div class="col-sm-8">
																					

											<select class="form-control select2" name="dokterAsisTindakan" id="dokterAsisTind" style="width:100%;" >
											<option value="">-Pilih Asisten Dokter-</option>											
													<?php 
												
													foreach($operator as $row){
														echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'">'.$row->nm_dokter.'&nbsp;&nbsp;['.$row->id_dokter.']</option>';
													}
													?>
											</select>

											

										</div>
								</div>
								<div class="form-group row" id="dokterInstDiv">
									<p class="col-sm-4 form-control-label" >Instrumen *)</p>
										<div class="col-sm-8">
																					

											<select class="form-control select2" name="instrumenTindakan" id="instrumenTind" style="width:100%;" >
											<option value="">-Pilih Instrumen-</option>											
													<?php 
												
													foreach($operator as $row){
														echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'">'.$row->nm_dokter.'&nbsp;&nbsp;['.$row->id_dokter.']</option>';
													}
													?>
											</select>

											

										</div>
								</div>
								<div class="form-group row" id="dokterAnakDiv">
									<p class="col-sm-4 form-control-label" >Dokter Anak *)</p>
										<div class="col-sm-8">
										<select class="form-control select2" name="dokterAnakTindakan" id="dokterAnakTind" style="width:100%;" >
										<option value="">-Pilih Dokter Anak-</option>								
											<?php 
											foreach($operator as $row){
												echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'">'.$row->nm_dokter.'&nbsp;&nbsp;['.$row->id_dokter.']</option>';
											}
											?>
										</select>
									</div>
								</div>		 -->			
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_biaya_tindak">Biaya Tindakan</p>
									<div class="col-sm-6">
										<div class="input-group">
										 <span class="input-group-addon">Rp</span>
										<input type="text" class="form-control"  name="biaya_tindakan" id="biaya_tindakan" value="0" disabled>
									<input type="hidden" class="form-control" name="biaya_tindakan_hide" id="biaya_tindakan_hide">
									</div></div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_biaya_alkes">Biaya Alkes</p>
									<div class="col-sm-6">
										<div class="input-group">
										 <span class="input-group-addon">Rp</span>
										<input type="text" class="form-control"  name="biaya_alkes" id="biaya_alkes" value="0" disabled>
									<input type="hidden" class="form-control" name="biaya_alkes_hide" id="biaya_alkes_hide">
									</div></div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_qtyind">Qtyind</p>
									<div class="col-sm-6">
										<input type="number" class="form-control" value="1" name="qtyind" id="qtyind" min=1 onchange="set_total(this.value)">
									</div>
								</div>								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_vtot">Total</p>
									<div class="col-sm-6"><div class="input-group">
										 <span class="input-group-addon">Rp</span>
										<input type="text" class="form-control" name="vtot" id="vtot" value="0" disabled>								<input type="hidden" class="form-control" name="vtot_hide" id="vtot_hide">
									</div></div>
								</div><!-- 
								<div class="form-group row" id="lbl_operasi">
									<p class="col-sm-10 form-control-label">*) Diisi hanya untuk tindakan Operasi Paket</p>
									
								</div> -->
								<div class="form-inline " align="right">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">	
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
									<input type="hidden" class="form-control" value="<?php echo $tgl_kunjungan;?>" name="tgl_kunjung">
									<div class="form-group">
										<button type="reset" class="btn bg-orange">Reset</button>
										<button type="submit" class="btn btn-primary">Simpan</button>
									</div>
								</div>
							<?php echo form_close();?>
							</div>
							
							<!-- table -->
								<br>
							<div style="display:block;overflow:auto;">
							<table id="tableTindakan"  class="display" cellspacing="0" width="100%">
							  <thead>
								<tr>
								  <th>No</th>
								  <th>Tindakan</th>
								  <th>Operator</th>
								  <th>Biaya Tindakan</th>
								  <th>Qtyind</th>
								  <th>Biaya Alkes</th>
								  <th>Total</th>
								  <th>Aksi</th>
								</tr>
							  </thead>
							  <tbody>
								<?php
								// print_r($pasien_daftar);
								$i=1;
									foreach($data_tindakan_pasien as $row){
									$id_tindakan_ird=$row->id_tindakan_ird;
									
								?>
									<tr>
										<td><?php echo $i++ ; ?></td>
										<td><?php echo $row->idtindakan.' - '.$row->nmtindakan ; ?></td>										
										<td><?php echo $row->id_dokter.' - '.$row->nm_dokter ; ?></td>										
										<td><?php echo number_format( $row->biaya_ird, 2 , ',' , '.' );?></td>
										<td><?php echo $row->qty ; ?></td>
										<td><?php echo number_format( $row->biaya_alkes, 2 , ',' , '.' );?></td>
										<td><?php echo number_format( $row->vtot, 2 , ',' , '.' );?></td>
										<td>
											<a href="<?php echo site_url("ird/IrDPelayanan/hapus_tindakan/".$id_tindakan_ird);?>" class="btn btn-danger btn-xs">Hapus</a>
										</td>
									</tr>
								<?php
									}
								?>
							  </tbody>
							</table>							
							</div><!-- style overflow -->
						</div>
