<div class="panel-body">	
									<!-- form -->
									<div class="well">
										<?php echo form_open('irj/rjcpelayanan/insert_tindakan'); ?>
										<div class="form-group row">
											<p class="col-sm-2 form-control-label" id="tindakan">Tindakan *</p>
											<div class="col-sm-10">
													<!--
													<input type="search" style="width:100%" class="auto_search_tindakan form-control" placeholder="" id="nmtindakan" name="nmtindakan" required>
													<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan"  name="idtindakan">
													-->
														<select id="prop" class="form-control select2" name="idtindakan" onchange="pilih_tindakan(this.value)" style="width:100%;" required>
															<option value="">-Pilih Tindakan-</option>
															<?php 
															foreach($tindakan as $row){
																echo '<option value="'.$row->idtindakan.'@'.$row->nmtindakan.'">'.$row->nmtindakan.' | Rp. '.number_format($row->total_tarif, 2 , ',' , '.' ).'</option>';
															}
															?>
														</select>
											</div>
										</div> <!-- end form group row 
										<div class="form-group row" id="bpjs">
											<p class="col-sm-2 form-control-label">Dibayar BPJS *</p>
											<div class="col-sm-10">
												<input type="radio" name="cover_bpjs" value="1" required <?php if($data_pasien_daftar_ulang->cara_bayar=='UMUM'){ echo 'disabled';}else if($data_pasien_daftar_ulang->cara_bayar=='BPJS'){ echo 'checked';} ?> >&nbsp;Ya
											&nbsp;&nbsp;&nbsp;
												<input type="radio" name="cover_bpjs" value="0" <?php if($data_pasien_daftar_ulang->cara_bayar=='UMUM'){ echo 'checked';} ?> >&nbsp;Tidak
											</div>
										</div>-->
										<div class="form-group row" id="dokterDiv">
											<p class="col-sm-2 form-control-label" id="label_dokter">Pelaksana *</p>
											<div class="col-sm-10">
													
													<select id="id_dokter" class="form-control select2" name="id_dokter" style="width:100%;" required>
														<option value="">-Pilih Pelaksana-</option>
														<?php 
														foreach($dokter_tindakan as $row){
															echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'">'.$row->nm_dokter.'</option>';
														}
														
														?>
													</select>
											</div>
										</div> <!-- end form group row -->
										
										<div class="form-group row">
											<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Biaya Tindakan</p>
											<div class="col-sm-3">
												<div class="input-group">
													<span class="input-group-addon">Rp</span>
													<input type="text" class="form-control" name="biaya_tindakan" id="biaya_tindakan" disabled>
													<input type="hidden" class="form-control" name="biaya_tindakan_hide" id="biaya_tindakan_hide">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<p class="col-sm-2 form-control-label">Biaya Alkes</p>
											<div class="col-sm-3">
												<div class="input-group">
													<span class="input-group-addon">Rp</span>
													<input type="text" class="form-control" name="biaya_alkes" id="biaya_alkes" disabled>
													<input type="hidden" class="form-control" name="biaya_alkes_hide" id="biaya_alkes_hide">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<p class="col-sm-2 form-control-label" id="lbl_qtyind">Qtyind *</p>
											<div class="col-sm-2">
												<input type="number" class="form-control" name="qtyind" id="qtyind" min=1 onchange="set_total(this.value)" required>
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
													<input type="text" class="form-control" name="vtot" id="vtot" disabled>
													<input type="hidden" class="form-control" name="vtot_hide" id="vtot_hide">
												</div>
											</div>
										</div>
										
										<div class="form-inline" align="right">
											<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="id_poli">
											<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
											<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
											<div class="form-group">
												<button type="reset" class="btn bg-orange">Reset</button>
												<button type="submit" class="btn btn-primary">Simpan</button>
											</div>
										</div>
									<?php echo form_close();?>
									</div> <!-- end div well -->
									
									<!-- table -->
									<br>
									<div style="display:block;overflow:auto;">
										<table id="tabel_tindakan" class="display" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>No</th>
													<th>Tindakan</th>
													<th>Dokter</th>
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
														$id_pelayanan_poli=$row->id_pelayanan_poli;
												?>
												<tr  >
													<td><?php echo $i++ ; ?></td>
													<td <?php if($row->bayar=='1') {echo 'style="color:green !important"' ;} else {echo 'style="color:red !important"' ;} ?> ><?php echo $row->idtindakan.' - '.$row->nmtindakan ; ?></td>
													<td><?php echo $row->nm_dokter.'('.$row->id_dokter.')' ; ?></td>
													<td><?php echo number_format($row->biaya_tindakan , 2 , ',' , '.' ); ?></td>
													<td><?php echo $row->qtyind ; ?></td>
													<td><?php  echo number_format( $row->biaya_alkes , 2 , ',' , '.' );?></td>
													<td><?php echo number_format( $row->vtot , 2 , ',' , '.' ); ?></td>
													<td>
														<!-- Button trigger modal -->
														<?php if($row->bayar=='1') {?>
														<a href="javascript:void(0)" class="btn btn-danger btn-xs" disabled>Hapus</a>
														<?php //echo '<a data-toggle="modal" data-id="" title="Add this item" class="open-form-edit btn btn-danger btn-xs" href="#form-edit" onclick="data_edit(\''.$row->idtindakan.'\',\''.$row->nmtindakan.'\',\''.$row->id_dokter.'\',\''.$row->nm_dokter.'\',\''.$row->biaya_tindakan.'\',\''.$row->qtyind.'\',\''.$row->vtot.'\',\''.$row->id_pelayanan_poli.'\')">Hapus</a>';?>
														<?php } else {?>
														<a href="<?php echo site_url('irj/rjcpelayanan/hapus_tindakan/'.$id_poli.'/'.$id_pelayanan_poli.'/'.$no_register); ?>" class="btn btn-danger btn-xs">Hapus</a>
														<?php }?>
													</td>
												</tr>
												<?php
													}
												?>

											</tbody>
										</table>
									<hr>
									<div class="pull-right">
									<?php if($unpaid!=''){?>
									<a href="<?php echo site_url('irj/rjcregistrasi/cetak_faktur_kt/'.$no_register); ?>" target="_blank" class="btn btn-danger">Cetak</a>
									<?php } else {?>
									<a href="javascript:void(0)" class="btn btn-danger" disabled>Cetak</a>
									<?php }?>
									</div>
									</div><!-- style overflow -->
								</div> 
