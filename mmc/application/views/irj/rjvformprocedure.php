	<div class="panel-body">					
		<div class="well" >
			<!-- form -->
			<form class="form-horizontal" id="form_add_procedure">
				<div class="form-group row">
					<p class="col-sm-2 form-control-label" id="lbl_procedure">Prosedur *</p>
					<div class="col-sm-10">
						<div class="form-group">
							<input type="text" class="form-control input-sm auto_procedure_pasien"  name="id_procedure" id="id_procedure" required style="width:400px;font-size:15px;">
							<input type="hidden" class="form-control " name="procedure" id="procedure" >	
						</div>
					</div>
				</div>
				<div class="form-group row">
					<p class="col-sm-2 form-control-label" id="lbl_klasifikasi_procedure">Klasifikasi *</p>
					<div class="col-sm-10">
						<div class="form-inline">
							<div class="form-group">
								<select id="prop" class="form-control" name="klasifikasi_procedure" required>
									<option value="">-Pilih Klasifikasi-</option>
									<option value="utama" id="utama">utama</option>';
									<option value="tambahan">tambahan</option>';
								</select>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="form-group row">
					<p class="col-sm-2 form-control-label"></p>
					<div class="col-sm-10">
						<div class="form-inline">
							<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
							<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
							<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec" id="no_medrec">
							<input type="hidden" name="tgl_kunjungan" value="<?php echo $tgl_kunjungan;?>">
							<div class="form-group">
								<button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i> Reset</button>
								<button type="submit" class="btn btn-primary" id="btn-procedure"><i class="fa fa-floppy-o"></i> Simpan</button>
							</div>
						</div>
					</div>
				</div>										
			</form>
		</div>
								
		<!-- table -->
		<br>
		<div style="display:block;overflow:auto;">
			<table id="tabel_procedure" class="table table-bordered table-hover" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Tanggal Kunjungan</th>
						<th>Prosedur</th>
						<th>Klasifikasi Prosedur</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
			
				</tbody>
			</table>
		</div> <!-- style overflow -->
		</div>
