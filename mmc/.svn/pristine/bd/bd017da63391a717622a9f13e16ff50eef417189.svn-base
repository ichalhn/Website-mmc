  <div class="modal fade" id="addKBGModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-success">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><b>Tambah Data KGB</b></h4>
		</div>
		<div class="modal-body">
		<div class="row">
			<div class="col-md-12">			
			<?php
			echo form_open('kepegawaian/Data_pegawai/saveKgb/',array('id'=>'formAdd','class'=>'form-horizontal'));
			?>
				<div class="row">
					<div class="col-md-12">	
						<div class="form-group">
							<label class="control-label col-sm-4">No. Surat</label>
							<div class="col-sm-8">
								<input type="hidden" name="nip_kgb" id="nip_kgb">		
								<input type="hidden" name="id_gol_kgb0" id="id_gol_kgb0">		
								<input type="text" class="form-control" name="no_suratkgb" id="no_suratkgb" >
							</div>
						</div>
					</div>
				</div>			
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-sm-4">Terhitung Mulai</label>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" class="form-control datepicker" name="tgl_berlaku0" id="tgl_berlaku0" required>
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
				</div>			
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-sm-4">s/d</label>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" class="form-control datepicker" name="tgl_berlaku" id="tgl_berlaku" required>
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
				</div>			
				<div class="row">
					<div class="col-md-12">	
						<div class="form-group">
							<label class="control-label col-sm-4">Naik Golongan</label>
							<div class="col-sm-8">
								<input type="hidden" class="form-control" name="id_gol_kgb" id="id_gol_kgb" required>
								<input type="text" class="form-control" name="nm_gol_kgb" id="nm_gol_kgb" required>
							</div>
						</div>
					</div>
				</div>	
				<div class="row">
					<div class="col-md-12">	
						<div class="form-group">
							<label class="control-label col-sm-4">Gaji</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="gaji_pokok0" id="gaji_pokok0" required>
							</div>
						</div>
					</div>
				</div>		
				<div class="row">
					<div class="col-md-12">	
						<div class="form-group">
							<label class="control-label col-sm-4">Naik Gaji</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="gaji_pokok" id="gaji_pokok" required>
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