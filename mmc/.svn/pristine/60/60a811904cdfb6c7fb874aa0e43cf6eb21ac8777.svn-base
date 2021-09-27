  <div class="modal fade" id="addPendModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-success">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><b>Tambah Data Pendidikan</b></h4>
		</div>
		<div class="modal-body">
		<div class="row">
			<div class="col-md-12">			
			<?php
			echo form_open('kepegawaian/Data_pegawai/savePend/',array('id'=>'formAdd','class'=>'form-horizontal'));
			?>
				<div class="row">
					<div class="col-md-12">	
						<div class="form-group">
							<label class="control-label col-sm-4">Tingkat</label>
							<div class="col-sm-8">
								<input type="hidden" name="nip_pend" id="nip_pend">		
								<input type="text" class="form-control" name="nm_pendidikan" id="nm_pendidikan" required >
							</div>
						</div>
					</div>
				</div>			
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-sm-4">Tgl Ijazah</label>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" class="form-control datepicker" name="thn_ijazah" id="thn_ijazah" required>
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
				</div>			
				<div class="row">
					<div class="col-md-12">	
						<div class="form-group">
							<label class="control-label col-sm-4">Nama Instansi</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="tpt_pend" id="tpt_pend" required>
							</div>
						</div>
					</div>
				</div>			
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="col-sm-4 control-label">Status Instansi</label>
							<div class="col-sm-8">
								  <select  class="form-control" style="width: 100%" name="stat_sekolah" id="stat_sekolah">
									<option value="">-Pilih Status-</option>
									<option value="Negri">Negri</option>
									<option value="Swasta">Swasta</option>
								  </select>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">	
						<div class="form-group">
							<label class="control-label col-sm-4">Kualifikasi</label>
							<div class="col-sm-8">
								<input type="hidden" class="form-control" name="id_qua_pend" id="id_qua_pend" >
								<input type="text" class="form-control" name="nm_qua_pend" id="nm_qua_pend" >
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">	
					</div>
					<div class="col-md-4">	
						<?php 
							echo form_submit(array(
								'name'=>'submit',
								'id'=>'submit',
								'value'=>'Simpan',
								'class'=>'form-control btn btn-info pull-right')
							);
						?>
					</div>
				</div><!-- end row -->
			</form>
			</div>
			</div>
		</div>
	  </div>
	</div>
  </div>