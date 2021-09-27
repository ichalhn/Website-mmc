<?php
	$this->load->view('layout/header.php');
?>
<html>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(function() {
	$('.auto_search_operator').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_operator',
		onSelect: function (suggestion) {
			$('#id_dokter').val(''+suggestion.id_dokter);
			$('#nm_dokter').val(''+suggestion.nm_dokter);
		}
	});
	$('.auto_search_operator2').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_operator',
		onSelect: function (suggestion) {
			$('#id_dokter2').val(''+suggestion.id_dokter);
			$('#nm_dokter2').val(''+suggestion.nm_dokter);
		}
	});
});
		
		
function data_edit(param0,param1,param2,param3){
	document.getElementById("id_dokter2").value = param0;
	document.getElementById("nm_dokter2").value = param1;
	document.getElementById("resep2").value = param2;
	document.getElementById("id_resep_irj2").value = param3;
}
		
</script>
	<section class="content-header">
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading" align="center">
							<ul class="nav nav-pills nav-justified">
							  <li role="presentation"><a href="<?php echo site_url('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register);?>">Tindakan</a></li>
							  <li role="presentation"><a href="<?php echo site_url('irj/rjcpelayanan/pelayanan_diagnosa/'.$id_poli.'/'.$no_register);?>">Diagnosa</a></li>
							  <li role="presentation"><a href="<?php echo site_url('irj/rjcpelayanan/pelayanan_resep/'.$id_poli.'/'.$no_register);?>">Resep</a></li>
							  <li role="presentation" class="active"><a href="<?php echo site_url('irj/rjcpelayanan/rad_lab/'.$id_poli.'/'.$no_register);?>">Radiologi dan Lab</a></li>
							</ul>
						</div>
						<div class="panel-body" style="display:block;overflow:auto;">
						<br/>
							<!-- form -->
							<div class="well" style="background-color:#BAD8FF;">
							<?php echo form_open('irj/rjcpelayanan/'); ?>
								
							<?php echo form_close();?>
							</div>
							
							<!-- table -->
								<br>
							<div style="display:block;overflow:auto;">
							<table class="table table-hover table-striped table-bordered">
							  <thead>
								<tr>
								  <th>No</th>
								</tr>
							  </thead>
							  <tbody>
								
							  </tbody>
							</table>
							</div><!-- style overflow -->
						</div>
					</div>
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
	  
        <?php echo form_open('irj/rjcpelayanan/update_resep');?>
      <div class="modal-body">
		  <div style="display:block;overflow:auto;">
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
									<p class="col-sm-2 form-control-label" id="lbl_resep">Resep</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="" name="resep2" id="resep2" required>
									</div>
								</div>
		  </div>
      </div>
      <div class="modal-footer">
		<input type="hidden" class="form-control" value="" name="id_resep_irj2" id="id_resep_irj2">
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