<div class="panel-body">
	<!-- form -->
	<div class="well">
		<?php echo form_open('ird/IrDPelayanan/insert_pelayanan_diagnosa'); ?>
			<div class="form-group row">
				<p class="col-sm-4 form-control-label" id="lbl_diagnosa">Diagnosa</p>
				<div class="col-sm-8">
					<input type="text" class="form-control input-sm auto_diagnosa_pasien"  name="diagnosa" id="diagnosa" required style="width:400px;font-size:15px;">
					<input type="hidden" class="form-control " name="jenis_diagnosa" id="jenis_diagnosa" >		
								
				</div>
			</div>											
			<div class="form-group row">
				<p class="col-sm-4 form-control-label" id="klasifikasi">Klasifikasi</p>
					<div class="col-sm-4">
						<select class="form-control" name="klasifikasi">
							<option value="utama" selected>Utama</option>
							<option value="tambahan">Tambahan</option>
						</select>
					</div>
			</div>
			<div class="form-inline" align="right">
				<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
					<div class="form-group">
						<button type="reset" class="btn bg-orange">Reset</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
			</div>
		<?php echo form_close();?>
	</div>
							
	<!-- table -->
	<br>
	<div style="display:block;overflow:auto;">

		<table id="tableDiagnosa" class="display" cellspacing="0" width="100%">
		  <thead>
			<tr>
			  <th>No</th>
			  <th>Tanggal Kunjungan</th>
			  <th>Diagnosa</th>
			  <th>Klasifikasi Diagnosa</th>
			  
			  <th>Aksi</th>
			</tr>
			  </thead>
		  <tbody>
			<?php
			// print_r($pasien_daftar);
			$i=1;
			foreach($data_diagnosa_pasien as $row){
			$id_diagnosa_pasien=$row->id_diagnosa_pasien;						
			?>
			<tr>
			<td><?php echo $i++ ; ?></td>
			<td><?php echo $row->tgl_kunjungan; ?></td>
			<td><?php echo $row->id_diagnosa.' - '.$row->diagnosa; ?></td>		 					
			<td><?php echo $row->klasifikasi_diagnos;?></td>			
			<td>
			<a href="<?php echo site_url('ird/irDPelayanan/hapus_diagnosa/'.$id_diagnosa_pasien); ?>" class="btn btn-danger btn-xs">Hapus</a>
			</td>
			</tr>
			<?php
			}
			?>
		  </tbody>
		</table>
	</div><!-- style overflow -->
	</div>

