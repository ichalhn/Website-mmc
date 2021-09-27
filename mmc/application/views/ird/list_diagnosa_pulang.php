<?php $this->load->view("layout/header"); ?>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(document).ready(function() {
    $('#example').DataTable();
	//Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });

    $('#date_picker').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	}); 

	$('#ksg_Check').on('ifChecked', function(event){
		$('#cek').val('0');	
	  //alert(event.type + ' callback'+ $('#ksg_Check').val());
	});

	$('#ksg_Check').on('ifUnchecked', function(event){
		$('#cek').val('');	
	  //alert(event.type + ' callback'+ $('#ksg_Check').val());
	});
  /*diag = "<?php echo $diag;?>";
	alert (diag);
	if(diag!=''){
		$('#ksgCheck').prop('checked', true);	
	}else $('#ksgCheck').prop('checked', false);*/

} );

</script>
		<section class="content-header">
			<?php echo $this->session->flashdata('success_msg'); ?>
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
					
					<div class="box-body">
						<div class="form-group row">
							<?php echo form_open('ird/irDMedrec/');?>
							<div class="col-md-2" >
							
										<input type="text" class="form-control" name="date" id="date_picker" placeholder="" value="<?php echo date('Y-m-d'); ?>" required style="width:100%;">														 
										</div>
							<input type="checkbox" class="flat-red"  name="ksgCheck" id="ksg_Check" value="0" /> &nbsp;Diagnosa Kosong &nbsp;&nbsp;&nbsp;
							<input type="hidden" name="cek" id="cek">
										
											<button class="btn btn-primary" type="submit">Cari</button>
							<?php echo form_close();?>
							
						</div>
						<hr>
						<?php if ($date!=''){?><center><h4 class="box-title">Daftar Pasien Pulang Tanggal <b><?php echo date('d F Y', strtotime($date));?></b></h4><?php }else { ?> <center><h4 class="box-title">Daftar Pasien Pulang Tanggal <b><?php echo date('d-m-Y', strtotime('-7 days')).' s/d '.date('d-m-Y');?></b></h4> <?php }?>
						<table id="example" class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
								  <th>No</th>
								  <th>Tanggal Kunjungan</th>
								  <th>No Medrec</th>
								  <th>No Registrasi</th>
								  <th>Diagnosa Utama</th>
								  <th>Nama</th>
								  <th>Aksi</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
								  <th>No</th>
								  <th>Tanggal Kunjungan</th>
								  <th>No Medrec</th>
								  <th>No Registrasi</th>
								  <th>Diagnosa Utama</th>
								  <th>Nama</th>
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
								  <td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan)).' | '. date("h:m", strtotime($row->tgl_kunjungan));?></td>
								  <td><?php echo $row->no_medrec;?></td>
								  <td><?php echo $row->no_register;?></td>
								  <td><?php echo $row->diag_utama;?></td>
								  <td><?php echo $row->nama;?></td>
								  <td >
									<?php 
									if ($row->diag_utama=='') { 
										
									?>
										<a href="<?php echo site_url('ird/IrDMedrec/pelayanan_diagnosa/'.$no_register); ?>" class="btn btn-primary btn-xs">Lengkapi</a>
										
									<?php 										
									} 
									?>
								  </td>
								</tr>
										<?php } ?>
									</tbody>
								</table>	
								<hr>
								<div align="right">
									<a href="<?php echo site_url('ird/IrDMedrec/cetak_pdf/'.$date.'/'.$diag); ?>" class="btn btn-primary " target="_blank">PDF</a>
									<a href="<?php echo site_url('ird/IrDMedrec/export_excel/'.$date.'/'.$diag); ?>" class="btn btn-warning " target="_blank">Excel</a>
								</div>
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
