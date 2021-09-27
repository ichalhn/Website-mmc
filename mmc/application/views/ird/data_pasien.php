
    <!-- Main content -->
<section class="content">
	<div class="row">
			<?php
				// print_r($data_pasien);
				foreach($data_pasien_daftar_ulang as $row){
				
			?>
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div class="panel-heading" align="center" >Data Pasien</div>
				<div class="panel-body">
					<div align="center"><img height="100px" class="img-rounded" src="<?php 
							if($row->foto==''){
								echo site_url("upload/photo/unknown.png");
							}else{
								echo site_url("upload/photo/".$row->foto);
							}
							?>">
					</div>
					<div align="center"><a href="<?php echo base_url();?>ird/IrDSjp/cetak_gelang/<?php echo $row->no_register ;?>" target="_blank" title="cetak gelang"><input type="button" class="btn btn-primary btn-sm" value="Cetak Gelang"></a></div>
					<div align="center"><table class="table-sm table-striped " style="font-size:15">
					  <tbody>
						<tr>
							<th>Nama</th>
							<td>:&nbsp;</td>
							<td><?php echo strtoupper($row->nama);?></td>
						</tr>
						<tr>
							<th>No. CM</th>
							<td>:&nbsp;</td>
							<td><?php echo $row->no_cm;?></td>
						</tr>
						<tr>
							<th>No. Register</th>
							<td>:&nbsp;</td>
							<td><?php echo $row->no_register;?></td>
						</tr>
						<tr>
							<th>Umur</th>
							<td>:&nbsp;</td>
							<td><?php echo $row->umurrj.' Tahun '.$row->ublnrj.' Bulan '.$row->uharirj.' Hari';?></td>
						</tr>
						<tr>
							<th>Gol Darah</th>
							<td>:&nbsp;</td>
							<td><?php echo $row->goldarah;?></td>
						</tr>
						<tr>
							<th>Tanggal Kunjungan</th>
							<td>:&nbsp;</td>
							<td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan));?></td>
						</tr>
						<tr>
							<th>Kelas</th>
							<td>:&nbsp;</td>
							<td><?php echo $kelas_pasien;?></td>
						</tr>
						<tr>
							<th>Cara Bayar</th>
							<td>:&nbsp;</td>
							<td><?php echo $row->cara_bayar;?></td>
						</tr>
					  </tbody>
					</table>
					<?php
						}
					?>
			</div></div>
			</div>
		</div>
		<div class="col-sm-8">
			<div class="panel panel-danger">
				<div class="panel-heading" align="center" >Status Pulang</div>
				<div class="panel-body">
				<br/>	<div class="">
					<?php echo form_open('ird/IrDPelayanan/update_pulang'); ?>
						<div class="form-group row">
							<p class="col-sm-2 col-md-offset-2  form-control-label" >Tanggal</p>
							<div class="col-sm-4">
								<input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="tgl_pulang"  required>
							</div>
						</div>
						<div class="form-group row">
							<p class="col-sm-2 col-md-offset-2 form-control-label" id="ket_pulang">Pilih MRS</p>
								<div class="col-sm-4">
									<select class="form-control" name="ket_pulang" onchange="pilih_mrs(this.value)">
										<option value="">-Pilih Ket Pulang-</option>
										<option value="PULANG">Pulang</option>
										<option value="DIRUJUK_RAWATINAP">Dirujuk Rawat Inap</option>
										<option value="DIRUJUK_RS">Dirujuk ke RS Lain</option>
										<option value="MENINGGAL">Meninggal</option>
									</select>
								</div>
						</div>

						<div class="form-group row"  id="lbl_kontrol">
								<p class="col-sm-2 col-md-offset-2 form-control-label" id="tanggal_kunj">Tanggal Kontrol</p>
								<div class="col-sm-4">
									<input type="date" class="form-control" placeholder="eg : 2001-05-11" id="tgl_kontrol" name="tgl_kontrol" value="<?php echo date('Y-m-d'); ?>"  required>
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
					
					
				</div></div>
			</div>
		<div class="panel panel-danger">
		<div class="panel-body">
		<?php echo form_open('ird/IrDPelayanan/rujukan_penunjang'); ?>
			<?php foreach($rujukan_penunjang as $row){
					$lab= $row->lab; $ok= $row->ok; $pa= $row->pa; $rad= $row->rad; $obat= $row->obat; ?>
						<div class="form-group row">
							<p class="col-sm-12 form-control-label" id="label_rujukan">Rujukan Penunjang</p>
							<div class="col-sm-12">
								<label class="checkbox-inline no_indent">
								<?php 
								if($row->ok=='1'){
									echo '<input type="checkbox" id="okCheckbox"  class="flat-red" name="okCheckbox" checked="checked" value="1" disabled> Operasi';
									if($row->status_ok=='1'){
										echo ' | Done';
									} else {
										echo ' | Progress';
									}
								} else { 
									echo '<input type="checkbox" id="okCheckbox"  class="flat-red" name="okCheckbox" value="1"> Operasi';
								}?>
								</label>

								<label class="checkbox-inline no_indent">
								<?php 
								if($row->lab=='1'){
									echo '<input type="checkbox" id="labCheckbox"  class="flat-red" name="labCheckbox" checked="checked" value="1" disabled> Laboratorium';
									if($row->status_lab=='1'){
										echo ' | Done';
									} else {
										echo ' | <a href="'.base_url('lab/labcdaftar/pemeriksaan_lab').'/'.$no_register.'" target="_blank">Progress</a>';
									}
								} else { 
									echo '<input type="checkbox" id="labCheckbox"  class="flat-red" name="labCheckbox" value="1"> Laboratorium';
								}?>
								</label>

								<label class="checkbox-inline no_indent">
								<?php if($row->pa=='1'){
										echo '<input type="checkbox" id="paCheckbox"  class="flat-red" name="paCheckbox" checked="checked" value="1" disabled> Patologi Anatomi';
										if($row->status_pa=='1'){
											echo ' | Done';
										} else {
											echo ' | <a href="'.base_url('pa/pacdaftar/pemeriksaan_pa').'/'.$no_register.'" target="_blank">Progress</a>';
										}
									}
									else { 
										echo '<input type="checkbox" id="paCheckbox"  class="flat-red" name="paCheckbox" value="1"> Patologi Anatomi';
									}?>
								</label>

								<label class="checkbox-inline no_indent">
								  <?php if($row->rad=='1'){
										echo '<input type="checkbox" id="radCheckbox" class="flat-red" name="radCheckbox" checked="checked" value="1" disabled> Radiologi';
										if($row->status_rad=='1'){
											echo ' | Done';
										} else {
											echo ' | <a href="'.base_url('rad/radcdaftar/pemeriksaan_rad').'/'.$no_register.'" target="_blank">Progress</a>';
										}
									}else { 
										echo '<input type="checkbox" id="radCheckbox" class="flat-red" name="radCheckbox" value="1"> Radiologi';
									}?>
								</label>

								<label class="checkbox-inline no_indent">
								  <?php if($row->obat=='1'){
											echo '<input type="checkbox" id="obatCheckbox"  class="flat-red" name="obatCheckbox" checked="checked" value="1" disabled> Obat';
										if($row->status_obat=='1'){
											echo ' | Done';
										} else {
											echo ' | <a href="'.base_url('farmasi/Frmcdaftar/permintaan_obat').'/'.$no_register.'" target="_blank">Progress</a>';
										}
										}else { 
											echo '<input type="checkbox" id="obatCheckbox"  class="flat-red" name="obatCheckbox" value="1"> Obat';}?>
								</label>
							</div>

							<div class="col-sm-12" align="right">	
								<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register"><br>
								<?php if($row->obat=='1' and $row->lab=='1' and $row->rad='1'){
										echo '<button type="submit" class="btn btn-primary col-md-offset-1 " disabled> Simpan </button>';
										}else { 
											echo '<button type="submit" class="btn btn-primary col-md-offset-1"> Simpan </button>';
										}?>
							</div>				
					</div>
					<?php } ?>
					<?php echo form_close();?>
				</div>
			</div>			
		</div>						
	</div>
</section>

