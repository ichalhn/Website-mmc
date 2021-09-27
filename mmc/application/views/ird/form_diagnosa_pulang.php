<?php $this->load->view("layout/header"); ?>
<script>
$(document).ready(function() {
$('#tableDiagnosa').DataTable();

$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});
});
</script>
<?php echo $this->session->flashdata('success_msg'); ?>


<section class="content">
	<div class="row">
		<div class="col-sm-12">
			
			<div class="box" style="width:100%;margin:0 auto; padding-bottom:7px;">
				<div class="box-header" align="center"><b>Diagnosa Pasien</b></div>
				
				<!-- form -->
				<div class="box-body">
				<?php foreach($data_pasien_daftar_ulang as $row){ ?>
				<div class="col-md-6">
				<table class="table" >	
				<tbody>
							<tr>
								<th>No. CM</th>
								<td>:&nbsp;</td>
								<td><?php echo $row->no_medrec;?></td>
							</tr>
							<tr>
								<th>No. Register</th>
								<td>:&nbsp;</td>
								<td><?php echo $row->no_register;?></td>
							</tr>
				</tbody>
				</table>
				</div>
				<div class="col-md-6">
				<table class="table" >	
				<tbody>
							<tr>
								<th>Nama</th>
								<td>:&nbsp;</td>
								<td><?php echo $row->nama;?></td>
							</tr>
							<tr>
								<th>Tgl Kunjungan</th>
								<td>:&nbsp;</td>
								<td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan))." | ".date("h-i-s", strtotime($row->tgl_kunjungan));?></td>
							</tr>
				</tbody>
				</table>
				</div>
				<?php }?>
				</div>
				<div class="well" style="margin:10px;">
					<?php echo form_open('ird/IrDMedrec/insert_pelayanan_diagnosa'); ?>
						<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
						<div class="form-group row">
							<p class="col-sm-4 form-control-label" id="lbl_diagnosa">Diagnosa</p>
							<div class="col-sm-8">
								<select class="form-control" name="jenis_diagnosa" required>
									<option value="">-Pilih Jenis Diagnosa</option>
									<?php
										foreach($diagnosa as $row){
													
										echo '<option value="'.$row->id_icd.'@'.$row->nm_diagnosa.'">'.$row->id_icd.' - '.$row->nm_diagnosa.'</option>';
									}
									?>					
								</select>
								
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
							
								<div class="form-group">
									<button type="reset" class="btn bg-orange">Reset</button>
									<button type="submit" class="btn btn-primary">Simpan</button>
								</div>
						</div>
					<?php echo form_close();?>
				</div>
							
				<!-- table -->
				
			</div>
			<br>
			<div class="box" style="width:100%;margin:0 auto">
			<div style="display:block;overflow:auto;margin:5px;">

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
						<a href="<?php echo site_url('ird/irDMedrec/hapus_diagnosa/'.$id_diagnosa_pasien); ?>" class="btn btn-primary btn-xs">Hapus</a>
						</td>
						</tr>
						<?php
						}
						?>
					  </tbody>
					</table>
					<div class="form-group" align="right" style="padding-right:10px;">
						<a  href="<?php echo site_url('ird/irDMedrec/'); ?>" class="btn btn-primary ">Selesai</a>
					</div>
				</div><!-- style overflow -->
		</div>
		</div>
	</div>
</section>
<?php $this->load->view("layout/footer"); ?>
