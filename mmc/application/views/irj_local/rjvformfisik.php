<div class="panel-body">	
									<!-- form -->
									<div class="well">
										<?php echo form_open('irj/rjcpelayanan/insert_fisik'); ?>										
										<div class="form-group row">
											<p class="col-sm-2 form-control-label">Tekanan Darah</p>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="td" id="td" placeholder="mmHg" value="<?php 
														if ($td == null){
															echo '';
														} else {
															echo $td;
														}?>">
												</div>
											</div>
										</div>
				
										<div class="form-group row">
											<p class="col-sm-2 form-control-label">Berat Badan</p>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="bb" id="bb" placeholder="kg" value="<?php 
														if ($td == null){
															echo '';
														} else {
															echo $bb;
														}?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<p class="col-sm-2 form-control-label">Tinggi Badan</p>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="tb" id="tb" placeholder="cm" value="<?php 
														if ($td == null){
															echo '';
														} else {
															echo $tb;
														}?>">
												</div>
											</div>
										</div>
	
    										<div class="form-group row">
											<p class="col-sm-2 form-control-label">Keluhan Utama</p>
											<div class="col-sm-8">
												<textarea rows="10" cols="80" name="catatan" id="catatan"><?php 
														if ($td == null){
															echo '';
														} else {
															echo $catatan;
														}?>
													
												</textarea>
											</div>
										</div>
										<div class="form-inline" align="right">
											<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
											<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
											<div class="form-group">
												<button type="submit" class="btn btn-primary">Simpan</button>
											</div>
										</div>
									<?php echo form_close();?>
									</div> <!-- end div well -->
									
									
								</div> 
