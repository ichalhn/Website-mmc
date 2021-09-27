<div class="panel-body">						
									<div class="well" >
										<!-- form -->
										<?php echo form_open('irj/rjcpelayanan/insert_diagnosa'); ?>
										<div class="form-group row">
											<p class="col-sm-2 form-control-label" id="lbl_diagnosa">Diagnosa *</p>
											<div class="col-sm-10">
												<div class="form-group">
													<input type="text" class="form-control input-sm auto_diagnosa_pasien"  name="id_diagnosa" id="id_diagnosa" required style="width:400px;font-size:15px;">
													<input type="hidden" class="form-control " name="diagnosa" id="diagnosa" >	
												</div>
											</div>
										</div>
										<div class="form-group row">
											<p class="col-sm-2 form-control-label" id="lbl_klasifikasi_diagnos">Klasifikasi *</p>
											<div class="col-sm-10">
												<!--<input type="text" class="form-control" value="" name="klasifikasi_diagnos">-->
												<div class="form-inline">
														<div class="form-group">
															<select id="prop" class="form-control" name="klasifikasi_diagnos" required>
															<option value="">-Pilih Klasifikasi-</option>
															<option value="utama" SELECTED>utama</option>';
															<option value="tambahan">tambahan</option>';
															</select>
														</div>
													</div>
											</div>
										</div>
										<div class="form-inline" align="right">
											<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
											<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
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
									<table id="tabel_diagnosa" class="display" cellspacing="0" width="100%">
										<thead>
											<tr>
											  <th>No</th>
											  <th>Tanggal Kunjungan</th>
											  <th>Diagnosa</th>
											  <th>Klasifikasi Diagnosa</th>
											  <th>Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php
											// print_r($pasien_daftar);
											$i=1;
											foreach($data_diagnosa_pasien as $row){
												$id_diagnosa_pasien=$row->id_diagnosa_pasien;										
											?>
											<tr>
												<td><?php echo $i++ ; ?></td>
												<td><?php echo date('d-m-Y',strtotime($row->tgl_kunjungan)); ?></td>
												<td><?php echo $row->id_diagnosa.' - '.$row->diagnosa; ?></td>
												<td><?php echo $row->klasifikasi_diagnos; ?></td>
												<td>
													<!-- Button trigger modal -->
													<?php //echo '<a data-toggle="modal" data-id="" title="Add this item" class="open-form-edit btn btn-danger btn-xs" href="#form-edit" onclick="data_edit(\''.$row->diagnosa.'\',\''.$row->id_diagnosa.'\',\''.$row->klasifikasi_diagnos.'\',\''.$row->id_diagnosa_pasien.'\')">Hapus</a>';?>
													<?php if(date('d-m-Y',strtotime($data_pasien_daftar_ulang->tgl_kunjungan))==(date('d-m-Y',strtotime($row->tgl_kunjungan)))) { ?>
													<a href="<?php echo site_url('irj/rjcpelayanan/hapus_diagnosa/'.$id_poli.'/'.$id_diagnosa_pasien.'/'.$no_register); ?>" class="btn btn-danger btn-xs">Hapus</a>
													<?php
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
								</div>
