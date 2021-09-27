
     <div class="panel-body">
      	<?php echo form_open_multipart('farmasi/Frmcdaftar/insert_racikan'); ?>
      				<div class="col-sm-6">
								<div class="form-group row">
									<p class="col-sm-2 form-control-label " id="tindakan">Obat</p>
										<div class="col-sm-10">
											<div class="form-inline">
											
												<div class="form-group">
													<select width="auto" id="idracikan" class="form-control js-example-basic-single" name="idracikan" onchange="pilih_racikan(this.value)" required>
														<option value="">-Pilih Obat-</option>
														<?php 
															foreach($data_obat as $row){
																echo '<option value="'.$row->id_obat.'">'.$row->nm_obat.'</option>';
															}
														?>
													</select>
												</div>

												
											</div>
										</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qtyind">Quantity</p>
									<div class="col-sm-3">
										<input type="number" step="0.01" class="form-control" name="qty_racikan" id="qty_racikan" onchange="set_total_racikan(this.value)">
									</div>
								</div>

								
					</div>

					<div class="col-sm-6">
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="lbl_biaya_poli">Harga Obat</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>" name="biaya_racikan" id="biaya_racikan" disabled>
										<input type="hidden" class="form-control" value="" name="biaya_racikan_hide" id="biaya_racikan_hide">
									</div>
								</div>


								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="lbl_vtot">Total</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="vtot_racikan" id="vtot_racikan" disabled>
										<input type="hidden" class="form-control" value="" name="vtot_racikan_hide" id="vtot_racikan_hide">
									</div>
								</div>
								
										<input type="hidden" class="form-control" name="fmarkup" id="fmarkup" value="<?php echo $fmarkup ?>">
								
										<input type="hidden" class="form-control" name="ppn" id="ppn" value="<?php echo $ppn ?>" >

								
									
								<!--<div class="form-group row">
									<p class="col-sm-2 form-control-label " id="markup">Kebijakan Obat</p>
										<div class="col-sm-10">
											<div class="form-inline">
												<!--
												<input type="search" style="width:100%" class="auto_search_tindakan form-control" placeholder="" id="nmtindakan" name="nmtindakan" required>
												<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan"  name="idtindakan">
												-->
												<!--<div class="form-group">
													<select id="idmarkup" class="form-control" name="idmarkup" onchange="pilih_kebijakan(this.value)" required>
														<option value="">-Pilih Kebijakan-</option>
														<?php 
															foreach($get_data_markup as $row){
																echo '<option value="'.$row->kodemarkup.'">'.$row->ket_markup.'</option>';
															}
														?>
													</select>
												</div>
											</div>
										</div>
								</div>-->
				</div>
								
								
								<div class="form-inline" align="right">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
									<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
									

									<?php
										if($no_resep!=''){
												echo "<input type='hidden' class='form-control' value=".$no_resep." name='no_resep'>";
										} else {
											
										}
									?>
									<input type="hidden" class="form-control" value="<?php echo $tgl_kunjungan;?>" name="tgl_kunjungan">
									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<!--<input type="hidden" class="form-control" value="<?php echo $no_resep;?>" name="no_resep">-->

									<input type="hidden" class="form-control" value="<?php echo $no_resep;?>" name="no_resep">
									<div class="form-group">
										<button type="reset" class="btn bg-orange">Reset</button>
										<button type="submit" class="btn btn-primary">Tambah</button>
									</div>
								</div>
							<?php echo form_close();?>  
     

  <br><br>
    			<div class="form-group row">
    			<div class="col-sm-12">

										<table class="table table-hover table-bordered table-responsive">
				  			  <thead>
								<tr>
								  <th><p align="center">No</p></th>
								  <th><p align="center">Nama Obat</p></th>
								  <th><p align="center">Harga Obat</p></th>
								  <th><p align="center">Qty</p></th>
								  <!--<th >Harga Satuan</th>-->
								  <th><p align="center">Total</p></th>
								  <th><p align="center">Aksi</p></th>
								</tr>
							  </thead>
							  <tbody>
							  
						<?php
							$i=1;
							$vtot1=0;$vtot2=0;
							foreach($data_tindakan_racikan as $row){
							
						?>
							<tr>
								<td align="center"><?php echo $i++;?></td>
								<td><?php echo $row->nm_obat;?></td>
								<td><?php echo $row->hargajual;?></td>
								<td align="center"><?php echo $row->qty;?></td>
								<?php $v=$row->hargajual*$row->qty; 
									$vtot1=$vtot1+$v;
								?>
								<!--<td><?php echo $row->biaya_obat;?></td>-->
								<td>Rp <div class="pull-right"><?php echo number_format( $v, 2 , ',' , '.' );?></div></td>
								<td><a href="<?php echo site_url("farmasi/Frmcdaftar/hapus_data_racikan/".$no_register."/".$row->no_resep."/".$row->item_obat."/".$row->id_resep_pasien);?>" class="btn btn-danger btn-xs">Hapus</a></td>
							</tr>
						<?php
							}
						?>
							<tr>								
								<td colspan="4" align="right"><b>Total</b></td>
								<td>Rp <div class="pull-right"><b><?php echo number_format( $vtot1, 2 , ',' , '.' );?>
									<input type="hidden" class="form-control" value="<?php echo $vtot1;?>" name="vtot1"></b></div></td>
								</tr>	
							  </tbody>
							 </table>
				</div>	
				</div>
						

      	<?php echo form_open_multipart('farmasi/Frmcdaftar/insert_racikan_selesai'); ?>
      						<div class="col-sm-6">
    							<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="lbl_racikan">Nama Racikan</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="racikan" id="rck" >
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="lbl_signa">Signa</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" name="signa" id="sgn"> 
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="qty">Quantity Total</p>
									<div class="col-sm-4">
										<input type="number" class="form-control" name="qty1" id="qty1" min=1 onchange="set_hasil_obat(this.value)">
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="lbl_vtotx">Total</p>
									<div class="col-sm-4">
										<input type="number" class="form-control" name="vtot_x" id="vtot_x" disabled="">
										<input type="hidden" class="form-control" name="vtot_x_hide" id="vtot_x_hide">
									</div>
								</div>
								

								<input type="hidden" class="form-control" value="<?php echo $tgl_kunjungan;?>" name="tgl_kun">
									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<!--<input type="hidden" class="form-control" value="<?php echo $no_resep;?>" name="no_resep">-->
									
									<input type="hidden" class="form-control" value="<?php echo $no_resep;?>" name="no_resep">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
									<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
						</div>
							<div class="col-xs-6" align="right">
								<div class="form-inline" align="right">
							<div class="input-group">
									<div class="form-group">
										<button class="btn btn-primary">Selesai</button>
									</div>
							</div>
						</div>
					</div><!-- /col-lg-6 -->
							<?php echo form_close();?>  


