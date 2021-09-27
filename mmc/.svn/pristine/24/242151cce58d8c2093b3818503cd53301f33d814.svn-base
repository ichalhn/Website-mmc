 <div class="modal fade" id="addChildModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-success">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><b>Tambah Data Anak</b></h4>
		</div>
		<div class="modal-body">
		<div class="row">
			<div class="col-md-12">			
			<?php
			echo form_open('kepegawaian/Data_pegawai/saveChild/',array('id'=>'formAdd','class'=>'form-horizontal'));
			?>
				<div class="row">
					<div class="col-md-12">	
						<div class="form-group">
							<label class="control-label col-sm-4">Nama</label>
							<div class="col-sm-8">
								<input type="hidden" name="nip_anak" id="nip_anak">
								<input type="hidden" name="stat_anak" id="stat_anak" value="ANAK">
								<input type="text" class="form-control" name="nm_anak" id="nm_anak" required>
							</div>
						</div>
					</div>
				</div>			
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-sm-4">Tgl Lhr</label>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" class="form-control datepicker" name="tgl_anak" id="tgl_anak" required>
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
				</div>			
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-sm-4">Gender</label>
							<div class="col-sm-8">
								<label class="radio-inline"> <input type="radio" name="sex_anak" id="sexL" value="L" checked> Laki-laki </label>
								<label class="radio-inline"> <input type="radio" name="sex_anak" id="sexP" value="P"> Perempuan </label>
							</div>
						</div>
					</div>
				</div>			
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="col-sm-4 control-label">Tunjangan</label>
							<div class="col-sm-8">
								<label class="radio-inline"> <input type="radio" name="tunj_anak" id="vgolPuncakY" value="Y" checked> Ya </label>
								<label class="radio-inline"> <input type="radio" name="tunj_anak" id="vgolPuncakN" value="T"> Tidak </label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">	
						<div class="form-group">
							<label class="control-label col-sm-4">Pekerjaan</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="krj_anak" id="krj_anak" >
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
  <div class="modal fade" id="addSpouseModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-success">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><b>Tambah Data Pasangan</b></h4>
		</div>
		<div class="modal-body">
		<div class="row">
			<div class="col-md-12">			
			<?php
			echo form_open('kepegawaian/Data_pegawai/saveSpouse/',array('id'=>'formAdd','class'=>'form-horizontal'));
			?>
				<div class="row">
					<div class="col-md-12">	
						<div class="form-group">
							<label class="control-label col-sm-4">Nama</label>
							<div class="col-sm-8">
								<input type="hidden" name="nip_si" id="nip_si">
								<input type="hidden" name="stat_si" id="stat_si" class="stat_si">
								<input type="text" class="form-control" name="nm_si" id="nm_si" required>
							</div>
						</div>
					</div>
				</div>			
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-sm-4">Tgl Lhr</label>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" class="form-control datepicker" name="tgl_si" id="tgl_si" required>
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
				</div>			
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-sm-4">Gender</label>
							<div class="col-sm-8">
								<label class="radio-inline sex_si"> <input type="radio" name="sex_si" id="sexL" value="L" checked> Laki-laki </label>
								<label class="radio-inline sex_si"> <input type="radio" name="sex_si" id="sexP" value="P"> Perempuan </label>
							</div>
						</div>
					</div>
				</div>			
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label col-sm-4">Tgl Nikah</label>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" class="form-control datepicker" name="tgl_nikah" id="tgl_si" required>
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
				</div>			
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="col-sm-4 control-label">Tunjangan</label>
							<div class="col-sm-8">
								<label class="radio-inline"> <input type="radio" name="tunj_si" id="vgolPuncakY" value="Y" checked> Ya </label>
								<label class="radio-inline"> <input type="radio" name="tunj_si" id="vgolPuncakN" value="T"> Tidak </label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">	
						<div class="form-group">
							<label class="control-label col-sm-4">Pekerjaan</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="krj_si" id="krj_si">
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