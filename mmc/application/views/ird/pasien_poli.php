<?php $this->load->view("layout/header"); ?>
		<section class="content-header">
			<legend></legend>
				<div class="panel panel-primary">
					<div class="panel-heading" align="center">PENCARIAN DATA</div><br/>
					<div class="panel-body">
						<div class="form-group row">
							<?php echo form_open('irDPelayanan/kunj_pasien_poli_by_no');?>
								<div class="col-sm-2"><select class="form-control" name="based">
									<option value="no_cm">NO CM</option>
									<option value="no_register">No Register</option>
									<option value="tanggal">Tanggal</option>
								</select></div>
								<div class="col-sm-3"><input type="text" class="form-control" name="key" placeholder="No.CM/No.Reg/2016-02-12" required></div>
								<div class="col-sm-1"><button class="btn btn-primary" type="submit">Cari</button></div>
							<?php echo form_close();?>
						</div><!-- /inline -->
					</div><!-- /panel body -->
				</div><!-- /panel -->
			</section>
			<section class="content">
				<div class="row">
						<div class="panel panel-info">
							<div class="panel-heading" align="center" style="background-color:#529BC5;color:#ffffff">DAFTAR ANTRIAN PASIEN POLI</div>
							<div class="panel-body">
								<br/>
						<div style="display:block;overflow:auto;">
						<table class="table table-hover table-striped table-bordered">
						  <thead>
							<tr>
							  <th>No</th>
							  <th>Tanggal Kunjungan</th>
							  <th>No Medrec</th>
							  <th>No Registrasi</th>
							  <th>Nama</th>
							  <th>Aksi</th>
							</tr>
						  </thead>
						  <tbody>
							
							<?php
							// print_r($pasien_daftar);
							$i=1;
								foreach($pasien_daftar as $row){
								$no_register=$row->no_register;
								
							?>
								<tr>
								  <td><?php echo $i++;?></td>
								  <td><?php echo $row->tgl_kunjungan;?></td>
								  <td><?php echo $row->no_medrec;?></td>
								  <td><?php echo $row->no_register;?></td>
								  <td><?php echo $row->nama;?></td>
								  <td>
										<a href="<?php echo site_url('irDPelayanan/pelayanan_pasien/'.$no_register); ?>" class="btn btn-primary btn-xs">Tindak</a>
								  </td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
						</div><!-- style overflow -->
					</div><!--- end panel body --->
				</div><!--- end panel --->
				</div><!--- end panel --->
			</section>
<?php $this->load->view("layout/footer"); ?>