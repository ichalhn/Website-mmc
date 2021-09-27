<?php $this->load->view("layout/header"); ?>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(document).ready(function() {
    $('#example').DataTable();

    $('#date_picker').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  
} );

</script>
		<section class="content-header">
			
				<!--<div class="panel panel-primary">
					<div class="panel-heading" align="center">PENCARIAN DATA BERDASARKAN TANGGAL</div><br/>
					<div class="panel-body">
						<div class="form-group row"><div class="col-md-6 col-md-offset-3">
							<?php echo form_open('ird/irDPelayanan/kunj_pasien_tindakan_by_date');?>
								<div class="input-group">
										<input type="date" class="form-control" name="date" placeholder="" value="<?php echo date('Y-m-d'); ?>" required>
										<span class="input-group-btn">
											<button class="btn btn-primary" type="submit">Cari</button>
										</span>
									</div>								
							<?php echo form_close();?>
						</div></div><!-- /inline -->
					<!--</div><!-- /panel body -->
				<!--</div><!-- /panel -->
			
			</section>


			
			 <section class="content">
				
				<div class="row">				
					<div class="box" style="width:97%;margin:0 auto">
					<div class="box-header">
						<h3 class="box-title">Daftar Antrian Pasien</h3>
						
					</div>
					<div class="box-body">
						<div class="form-group row">
							<div class="col-md-6 " style="width: 22.5%;">
							<?php echo form_open('ird/irDPelayanan/kunj_pasien_tindakan_by_date');?>
																
								<div class="input-group">
										
										<input  type="text" class="form-control" name="date" placeholder="" value="<?php echo date('Y-m-d'); ?>" id="date_picker" required>
										<span class="input-group-btn">
											<button class="btn btn-primary" type="submit">Cari</button>
										</span>
									</div>								
							<?php echo form_close();?>
						</div></div>
						<hr>
						<table id="example" class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
								  <th>No</th>
								  <th>Tanggal Kunjungan</th>
								  <th>No Medrec</th>
								  <th>No Registrasi</th>
								  <th>Nama</th>
								  <th>Jenis Pasien</th>
								  <th>Aksi</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
								  <th>No</th>
								  <th>Tanggal Kunjungan</th>
								  <th>No Medrec</th>
								  <th>No Registrasi</th>
								  <th>Nama</th>
								  <th>Jenis Pasien</th>
								  <th>Aksi</th>
								</tr>
							</tfoot>
							<tbody>
								<?php
							// print_r($pasien_daftar);
							$i=1;
								foreach($pasien_daftar as $row){
								$no_register=$row->no_register;
								
							?>
								<tr>
								  <td><?php echo $i++;?></td>
								  <td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan)).' | '. date("H:i", strtotime($row->tgl_kunjungan));?></td>
								  <td><?php echo $row->no_cm;?></td>
								  <td><?php echo $row->no_register;?></td>
								  <td><?php echo strtoupper($row->nama);?></td>
								  <td><?php echo strtoupper($row->cara_bayar);?></td>
								  <td >
										<a href="<?php echo site_url('ird/irDPelayanan/pelayanan_pasien/'.$no_register); ?>" class="btn btn-primary btn-xs">Tindak</a>
								<a href="<?php echo site_url('ird/irDPelayanan/hapus_antrian/'.$no_register); ?>" class="btn btn-danger btn-xs">Batal</a>
								  </td>
								</tr>
										<?php } ?>
									</tbody>
								</table>							
							</div>
						</div>						
						<!-- <div class="panel panel-info">
							<div class="panel-heading" align="center" >DAFTAR ANTRIAN PASIEN</div>
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
								  <td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan));?></td>
								  <td><?php echo $row->no_medrec;?></td>
								  <td><?php echo $row->no_register;?></td>
								  <td><?php echo $row->nama;?></td>
								  <td>
										<a href="<?php echo site_url('ird/irDPelayanan/pelayanan_pasien/'.$no_register); ?>" class="btn btn-primary btn-xs">Tindak</a>
								<a href="#" class="btn btn-primary btn-xs">Hapus</a>
								  </td>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
						</div><!-- style overflow -->
					<!--</div><!--- end panel body --->
				
				<!--</div><!--- end panel --->
				
				</div><!--- end panel --->
			</section>
<?php $this->load->view("layout/footer"); ?>
