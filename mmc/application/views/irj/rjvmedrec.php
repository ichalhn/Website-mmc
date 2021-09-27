<?php
	$this->load->view('layout/header.php');
?>
<html>
<script type='text/javascript'>
//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#example').DataTable();
} );
//---------------------------------------------------------

$(function() {
	$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});  
			
	

	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    });
	});
</script>

<section class="content-header">
	<?php $a=''; echo $this->session->flashdata('success_msg'); ?>
				
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body">
					
					<?php echo form_open('irj/Rjcmedrec/search_list_medrec');?>
					
					<div class="form-inline">
						<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="tgl_kunj" value="<?php echo($tgl_kunj!=''?$tgl_kunj:'')?>">
						&nbsp;&nbsp;
						<input type="checkbox" class="flat-red" name="ceklist_diag" value="kosong" <?php if($ceklist_diag == 'kosong') echo 'checked="checked"';?>>&nbsp;Diagnosa Utama Kosong
						&nbsp;&nbsp;
						<button class="btn btn-primary" type="submit">Cari</button>
						</div>
					<?php echo form_close();?>
					<br/>
					<?php if ($tgl_kunj!=''){?><center><h4 class="box-title">Daftar Pasien Pulang Tanggal <b><?php echo date('d F Y', strtotime($tgl_kunj));?></b></h4><?php }else { ?> <center><h4 class="box-title">Daftar Pasien Pulang Tanggal <b><?php echo date('d F Y', strtotime('-7 days')).' s/d '.date('d F Y');?></b></h4> <?php }?>
					<hr>
					<table id="example" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>No</th>
								  <th>Tanggal Kunjungan</th>
								  <th>No Medrec</th>
								  <th>No Registrasi</th>
								  <th>Poli</th>
								  <th>Nama</th>
								  <th>JK</th>
								  <th>Usia</th>
								  <th>Diagnosa Utama</th>	
								  <th>Aksi</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>No</th>
								  <th>Tanggal Kunjungan</th>
								  <th>No Medrec</th>
								  <th>No Registrasi</th>
								  <th>Poli</th>
								  <th>Nama</th>
								  <th>JK</th>
								  <th>Usia</th>
								  <th>Diagnosa Utama</th>
								<th>Aksi</th>											  
							</tr>
						</tfoot>
						<tbody>
							<?php
								// print_r($pasien_daftar);
								$i=1;
								
									foreach($medrec as $row){
									$no_register=$row->no_register;	
							?>
							<tr>
								<td><?php echo $i++;?></td>
								<td><?php echo date('d-m-Y',strtotime($row->tgl_kunjungan));?></td>					
								<td><?php echo $row->no_cm;?></td>
								<td><?php echo $row->no_register;?></td>
								<td><?php echo $row->nm_poli;?></td>
								<td><?php echo strtoupper($row->nama);?></td>
								<td><?php echo $row->sex;?></td>
								<td><?php echo $row->usia;?></td>
								<td>
									<?php 
										//$pieces = explode("@", $pizza);
										echo $row->diag_utama;
									?>
								</td>
								<td>
									<?php 
									if ($row->diag_utama=='') { 
										echo form_open('irj/Rjcmedrec/list_diagnosa');
									?>
										<a href="<?php echo site_url('irj/Rjcmedrec/list_diagnosa/'.$row->no_register); ?>" class="btn btn-primary btn-xs">Lengkapi</a>
										<a href="<?php echo site_url('irj/rjcsjp/cetak_sjp/'.$row->no_register); ?>" class="btn btn-primary btn-xs">Cetak SJP</a>
									<?php 
										echo form_close();
									} 
									?> 
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<hr>

							<?php if($medrec==''){?>
									<div align="right">
									<a href="<?php echo site_url('irj/Rjcmedrec/cetak_pdf0/'.$tgl_kunj.'/'.$ceklist_diag); ?>" class="btn btn-primary " target="_blank">PDF</a>
									<a href="<?php echo site_url('irj/Rjcmedrec/export_excel/'.$tgl_kunj.'/'.$ceklist_diag); ?>" class="btn btn-warning " target="_blank">Excel</a>
								</div>
								<?php } ?>
								
					<?php
						//echo $this->session->flashdata('message_nodata'); 
					?>								
				</div>
			</div>
		</div>
</section>
<?php
	$this->load->view('layout/footer.php');
?>
