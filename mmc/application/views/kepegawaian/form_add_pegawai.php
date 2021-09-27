
  <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-success modal-lg">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><b>Tambah Data Pegawai</b></h4>
		</div>
		<div class="modal-body">
		<div class="row">
			<div class="col-md-12">			
			<?php
			echo form_open_multipart('kepegawaian/Data_pegawai/save/',array('id'=>'formAdd','class'=>'form-horizontal'));
			?>
				<div class="row">
					<div class="col-md-6">	
						<div class="form-group">
							<label class="control-label col-sm-2">Nama</label>
							<div class="col-sm-10">
								<input type="hidden" name="vid" id="vid">
								<input type="text" class="form-control" name="vnm_pegawai" id="vnm_pegawai" required>
							</div>
						</div>
					</div>
					<div class="col-md-2">	
						<div class="form-group">
							<div class="col-sm-12">
								<input type="text" class="form-control" name="vgelar_dpn" id="vgelar_dpn" placeholder="Gelar Depan">
							</div>
						</div>
					</div>
					<div class="col-md-2">	
						<div class="form-group">
							<div class="col-sm-12">
								<input type="text" class="form-control" name="vgelar_bkl" id="vgelar_bkl" placeholder="Gelar Belakang">
							</div>
						</div>
					</div>
					<div class="col-md-2">	
						<div class="form-group">
							<div class="checkbox">
							<input type="hidden" name="vduk" value="0" />
							<label><input type="checkbox" name="vduk" id="vduk" value="1" >DUK</label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">	
						<div class="form-group">
							<label class="control-label col-sm-3">NIP</label>
							<div class="col-sm-9">
								<input type="text" class="form-control vnip" name="vnip" id="vnip" required>
							</div>
						</div>
					</div>
					<div class="col-md-4">	
						<div class="form-group">
							<label class="col-sm-3 control-label">Aktif</label>
							<div class="col-sm-9">
								<label class="radio-inline"> <input type="radio" name="vaktif" id="vaktifY" value="Y" checked> Ya </label>
								<label class="radio-inline"> <input type="radio" name="vaktif" id="vaktifN" value="N"> Tidak </label>
							</div>
						</div>
					</div>
					<div class="col-md-4">	
						<div class="form-group">
							<label class="col-sm-4 control-label">Fulltime</label>
							<div class="col-sm-8">
								<label class="radio-inline"> <input type="radio" name="vfulltime" id="vfulltimeY" value="Y" checked> Ya </label>
								<label class="radio-inline"> <input type="radio" name="vfulltime" id="vfulltimeN" value="N"> Tidak </label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">	
						<div class="form-group">
							<label class="control-label col-sm-2">No. SK</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="vsk_masuk" id="vsk_masuk" placeholder="No. SK Masuk" >
							</div>
						</div>
					</div>
					<div class="col-md-6">	
						<div class="form-group">
							<label class="control-label col-sm-2">Tgl</label>
							<div class="col-sm-6">
								<div class="input-group">
									<input type="text" class="form-control datepicker" name="vtgl_masuk" id="vtgl_masuk" >
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">	
						<div class="form-group">
							<label class="control-label col-sm-2">Bagian</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="vnm_bagian" id="vnm_bagian" >
								<input type="hidden" class="form-control" id="vid_bagian" name="vid_bagian">
							</div>
						</div>
					</div>
					<div class="col-md-6">	
						<div class="form-group">
							<label class="control-label col-sm-2">per</label>
							<div class="col-sm-6">
								<div class="input-group">
									<input type="text" class="form-control datepicker" name="vtmt" id="vtmt" >
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">	
						<div class="form-group">
							<label class="control-label col-sm-2">Jabatan</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="vnm_jabatan" id="vnm_jabatan" >
								<input type="hidden" class="form-control" name="vid_jabatan" id="vid_jabatan">
							</div>
						</div>
					</div>
					<div class="col-md-6">	
						<div class="form-group">
							<label class="control-label col-sm-2">per</label>
							<div class="col-sm-6">
								<div class="input-group">
									<input type="text" class="form-control datepicker" name="vtmt_jabatan" id="vtmt_jabatan" >
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">	
						<div class="form-group">
							<label class="control-label col-sm-3">Golongan</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" name="vnm_golongan" id="vnm_golongan" >
								<input type="hidden" class="form-control" name="vid_golongan" id="vid_golongan">
							</div>
						</div>
					</div>
					<div class="col-md-8">	
						<div class="form-group">
							<label class="control-label col-sm-2">per</label>
							<div class="col-sm-4">
								<div class="input-group">
									<input type="text" class="form-control datepicker" name="vtmt_golongan" id="vtmt_golongan" >
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
							<label class="col-sm-2 control-label">Gol.Puncak</label>
							<div class="col-sm-4">
								<label class="radio-inline"> <input type="radio" name="vgol_puncak" id="vgolPuncakY" value="Y" checked> Ya </label>
								<label class="radio-inline"> <input type="radio" name="vgol_puncak" id="vgolPuncakN" value="T"> Tidak </label>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">	
						<div class="form-group">
							<label class="control-label col-sm-2">Kualifikasi</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="vnm_qualifikasi" id="vnm_qualifikasi">
								<input type="hidden" class="form-control" name="vid_qualifikasi" id="vid_qualifikasi">
							</div>
						</div>
					</div>
					<div class="col-md-6">	
						<div class="form-group">
							<div class="col-sm-6">
								<input type="text" class="form-control" name="vnm_sub_qua" id="vnm_sub_qua" placeholder="Sub Kualifikasi">
								<input type="hidden" class="form-control" name="vid_sub_qua" id="vid_sub_qua" placeholder="Sub Kualifikasi">
							</div>
							<label class="col-sm-1 control-label">Ahli</label>
							<div class="col-sm-4">
								<label class="radio-inline"> <input type="radio" name="vahli" id="vahliY" value="A" checked> Ya </label>
								<label class="radio-inline"> <input type="radio" name="vahli" id="vahliN" value="T"> Tidak </label>
							</div>
						</div>
					</div>
				</div><!-- end row -->
				<div class="row">
					<div class="col-md-6">	
						<div class="form-group">
							<label class="control-label col-sm-2">Jenis</label>
							<div class="col-sm-10">
								<?php echo form_dropdown(
									array(
										'name'=>'vid_jenis',
										'id'=>'vid_jenis',
										'class'=>'form-control'), 
									$jenis, 
									"0"); ?>
							</div>
						</div>
					</div>
					<div class="col-md-6">	
					</div>
				</div>				
				<div class="row">
					<div class="col-md-6">	
						<div class="form-group">
							<label class="control-label col-sm-2">Penggaji</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="vpenggaji_2" id="vpenggaji_2" >
							</div>
						</div>
					</div>
					<div class="col-md-6">	
					</div>
				</div><!-- end row -->
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-2">Tpt Lhr</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="vtpt_lahir" id="vtpt_lahir" placeholder="Tempat Lahir" >
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-2">Tgl Lhr</label>
							<div class="col-sm-10">
								<div class="input-group">
									<input type="text" class="form-control datepicker" name="vtgl_lahir" id="vtgl_lahir" placeholder="Tanggal Lahir" >
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
				</div>			
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-2">Gender</label>
							<div class="col-sm-10">
								<label class="radio-inline"> <input type="radio" name="vsex" id="sexL" value="L" checked> Laki-laki </label>
								<label class="radio-inline"> <input type="radio" name="vsex" id="sexP" value="P"> Perempuan </label>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-2">Status</label>
							<div class="col-sm-10">
							  <select  class="form-control" style="width: 100%" name="vstatus" id="vstatus">
								<option value="">-Pilih Status-</option>
								<option value="Kawin">Kawin</option>
								<option value="TKawin">Tidak Kawin</option>
								<option value="Janda">Janda</option>
								<option value="Duda">Duda</option>
							  </select>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-2">Agama</label>
							<div class="col-sm-10">
							  <select  class="form-control" style="width: 100%" name="vagama" id="vagama">
								<option value="">-Pilih Agama-</option>
								<option value="Islam">Islam</option>
								<option value="Katholik">Katholik</option>
								<option value="Protestan">Protestan</option>
								<option value="Hindu">Hindu</option>
								<option value="Budha">Budha</option>
							  </select>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-2">Alamat</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="valamat" id="valamat" >
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-2">Prop</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="vprop" id="vprop" >
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label class="control-label col-sm-2">Kota/Kab</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="vkota" id="vkota" >
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">	
						<div class="form-group">
							<label class="control-label col-sm-2">Foto</label>
							<div class="col-sm-10">								
								<div class="input-group">
									<input type="file" name="userfile" accept="image/jpeg, image/png, image/gif"/>
									<input type="text" name="vfoto" id="vfoto" class="form-control filefield browse" readonly="" value="" />
									<span class="input-group-btn">
										<button class="btn btn-info btn-flat" type="button" id="browseBtn">Browse</button>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">	
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