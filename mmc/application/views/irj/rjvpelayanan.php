<?php
	$this->load->view('layout/header.php');
?>
<html>

	<?php 
	include('script_rjvpelayanan.php');	
	
	echo $this->session->flashdata('success_msg'); 
	echo $this->session->flashdata('notification');
	?>
	<?php include('rjvdatapasien.php');?>
	<section class="content-header">
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading" align="center">
							<ul class="nav nav-pills nav-justified">
								<li role="presentation" class="<?php echo $tab_fisik; ?>"><a data-toggle="tab" href="#tabfisik">Pemeriksaan Fisik</a></li>
								<li role="presentation" class="<?php echo $tab_tindakan; ?>"><a data-toggle="tab" href="#tabtindakan">Tindakan</a></li>
								<li role="presentation" class="<?php echo $tab_diagnosa; ?>"><a data-toggle="tab" href="#tabdiagnosa">Diagnosa</a></li>
								<li role="presentation"><a  data-toggle="tab" href="#tabok">Operasi</a></li>
								<li role="presentation" class="<?php //echo $tab_lab; ?>"><a data-toggle="tab" href="#tablab">Laboratorium</a></li>
								<li role="presentation" class="<?php //echo $tab_pa; ?>"><a data-toggle="tab" href="#tabpa">Patologi Anatomi</a></li>
								<li role="presentation" class="<?php //echo $tab_rad; ?>"><a data-toggle="tab" href="#tabrad">Radiologi</a></li>
								<li role="presentation" class="<?php //echo $tab_resep; ?>"><a data-toggle="tab" href="#tabresep">Resep</a></li>								
								<!--<li role="presentation" class="active"><a href="<?php //echo site_url('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register);?>">Tindakan</a></li>-->
							</ul>
						</div>
						
						<!--<div class="panel-body" style="display:block;overflow:auto;">
						<br/>-->
						<div class="tab-content">
							
							<div id="tabfisik" class="tab-pane fade in <?php echo $tab_fisik; ?>">	    						
								<?php include('rjvformfisik.php');  ?>
							</div> <!-- end div tab fisik -->
							
							<div id="tabtindakan" class="tab-pane fade in <?php echo $tab_tindakan; ?>">	    						
								<?php include('rjvformtindakan.php');  ?>
							</div> <!-- end div tab tindakan -->
							
							<div id="tabdiagnosa" class="tab-pane fade in <?php echo $tab_diagnosa; ?>">	    						
								<?php include('rjvformdiagnosa.php');  ?>
							</div> <!-- end div tab diagnosa -->

							<div id="tabok" class="tab-pane fade in">	    								
								<?php include('form_ok.php');  ?>
							</div> <!-- end div tab ok -->
							<div id="tablab" class="tab-pane fade in <?php echo $tab_lab; ?>">	    								
								<?php include('form_lab.php');  ?>
							</div> <!-- end div tab lab -->

							<div id="tabpa" class="tab-pane fade in <?php echo $tab_pa; ?>">	    								
								<?php include('form_pa.php');  ?>
							</div> <!-- end div tab lab -->
							
							<div id="tabrad" class="tab-pane fade in <?php echo $tab_rad; ?>">	    								
								<?php include('form_rad.php');  ?>
							</div> <!-- end div tab lab -->
	
							<div id="tabresep" class="tab-pane fade in <?php echo $tab_resep; ?>">	    								
								<?php include('form_resep.php');  ?>
								<!--<?php echo form_open('irj/Rjcpelayanan/selesai_daftar_resep');?>
										<div class="form-inline" style="margin:15px;" align="right">
											<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
											<input type="hidden" class="form-control" value="<?php echo $no_resep;?>" name="no_resep">
											<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
											<div class="form-group">
												<!--<a href="<?php //echo site_url('irj/Rjcpelayanan/selesai_daftar_resep/'.$id_poli.'/'. $no_register); ?>" class="btn btn-primary btn-xl" id="button_selesai_obat">Selesai & Cetak</a>
											<button id="button_selesai_obat" class="btn btn-primary" id="button_selesai_obat">Selesai & Cetak</button>
											</div>
										</div>
										<?php echo form_close(); ?>-->
							</div> <!-- end div tab resep -->
						
				</div>
			</div>
		</section>
	<!-- Modal -->
<div class="modal fade" id="form-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Data</h4>
      </div>
	  
        <?php echo form_open('irj/rjcpelayanan/update_tindakan');?>
      <div class="modal-body">
		  <div style="display:block;overflow:auto;">
								<div class="form-group row">
								<p class="col-sm-2 form-control-label" id="tindakan">Tindakan</p>
										<div class="col-sm-8">
											<div class="form-inline">
												<input type="search" style="width:450px" class="auto_search_tindakan2 form-control" placeholder="" id="nmtindakan2" name="nmtindakan2" required>
												<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan2"  name="idtindakan2">
											</div>
										</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="operator">Pelaksana</p>
										<div class="col-sm-8">
											<div class="form-inline">
												<input type="search" style="width:450px" class="auto_search_operator2 form-control" placeholder="" id="nm_dokter2" name="nm_dokter2" required>
												<input type="text" class="form-control" placeholder="ID Dokter" id="id_dokter2" readonly name="id_dokter2" >
											</div>
										</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Biaya Poli</p>
									<div class="col-sm-8">
										<input type="number" min=0 class="form-control" value="" name="biaya_poli2" id="biaya_poli2">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qtyind">Qtyind</p>
									<div class="col-sm-8">
										<input type="number" class="form-control" value="1" name="qtyind2" id="qtyind2">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_dijamin">Dijamin</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="" name="dijamin2" id="dijamin2">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_vtot">Total</p>
									<div class="col-sm-8">
										<input type="number" min=0 class="form-control" value="" name="vtot2" id="vtot2">
									</div>
								</div>
		  </div>
      </div>
      <div class="modal-footer">
		<input type="hidden" class="form-control" value="" name="id_pelayanan_poli2" id="id_pelayanan_poli2">
		<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
		<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="reset" class="btn btn-default">Reset</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </div>
        <?php echo form_close();?>
  </div>
</div>
<!-- Modal -->

<?php
	$this->load->view('layout/footer.php');
?>
