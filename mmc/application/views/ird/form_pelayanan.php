<?php $this->load->view("layout/header"); ?>
		<?php include('script_form_pelayanan.php'); echo $this->session->flashdata('success_msg');?>
		<?php include('data_pasien.php');?>
		<section class="content">
			
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading" align="center">
							<ul class="nav nav-pills nav-justified">
							  <li role="presentation" class="<?php echo $tab_fisik; ?>"><a data-toggle="tab" href="#tabfisik">Pemeriksaan Fisik</a></li>
							  <li role="presentation" class="<?php echo $tab_tindakan; ?>"><a data-toggle="tab" href="#tabtindakan">Tindakan</a></li>
							  <li role="presentation" class="<?php echo $tab_diagnosa; ?>"><a data-toggle="tab" href="#tabdiagnosa">Diagnosa</a></li>				
							  <li role="presentation" class="<?php echo $tab_ok; ?>"><a data-toggle="tab" href="#tabok">Operasi</a></li>						
							  <li role="presentation" class="<?php echo $tab_lab; ?>"><a data-toggle="tab" href="#tablab">Laboratorium</a></li>			
							  <li role="presentation" class="<?php echo $tab_pa; ?>"><a data-toggle="tab" href="#tabpa">Patologi Anatomi</a></li>
							  <li role="presentation" class="<?php echo $tab_rad; ?>"><a data-toggle="tab" href="#tabrad">Radiologi</a></li>
							  <li role="presentation" class="<?php echo $tab_resep; ?>"><a data-toggle="tab" href="#tabresep">Resep</a></li>			
							</ul>							
						</div>
						
						<div class="tab-content">
						  <div id="tabfisik" class="tab-pane fade in <?php echo $tab_fisik; ?>">	    								<?php include('form_fisik.php'); 								?>
						  </div>
						  <div id="tabtindakan" class="tab-pane fade in <?php echo $tab_tindakan; ?>">	    								<?php include('form_tindakan.php'); 								?>
						  </div>
						
						  <div id="tabdiagnosa" class="tab-pane fade in <?php echo $tab_diagnosa; ?>">
						    	<?php include('form_diagnosa.php'); 								?>				 
						</div>
						<div id="tabok" class="tab-pane fade in <?php echo $tab_ok; ?>">
						    	<?php include('form_ok.php'); ?>
						    											 
						</div>
						<div id="tablab" class="tab-pane fade in <?php echo $tab_lab; ?>">
						    	<?php include('form_lab.php'); ?>
						    											 
						</div>
						<div id="tabpa" class="tab-pane fade in <?php echo $tab_pa; ?>">
						    	<?php include('form_pa.php'); 								?>				 
						</div>
						<div id="tabrad" class="tab-pane fade in <?php echo $tab_rad; ?>">
						    	<?php include('form_rad.php'); 								?>				 
						</div>
						<div id="tabresep" class="tab-pane fade in <?php echo $tab_resep; ?>">
						    	<?php include('form_resep.php'); ?>
							<!-- <div class="form-inline" style="margin:15px;" align="right">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<div class="form-group">
										<?php	foreach($rujukan_penunjang as $row){ 
										if($row->obat=='1' and $row->status_obat=='0'){
											echo '<a  href="' .site_url('ird/IrDPelayanan/selesai_daftar_obat/'.$no_register.'/'.$no_resep).'" class="btn btn-primary btn-xl">Selesai & Cetak</a>
											';}else {
												echo '<a   class="btn btn-primary btn-xl" disabled>Selesai & Cetak</a>';
											} 
										}?>										
									</div>
								</div>	-->		 
						</div> 

						
					</div>
				</div>
			</div>
		</section>

<?php $this->load->view("layout/footer"); ?>
