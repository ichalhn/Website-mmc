<?php $this->load->view("layout/header"); ?>
<script type='text/javascript'>	
var site = "<?php echo site_url();?>";
$(document).ready(function() {
	$('#kwitansiTable').DataTable();

	$('#date_picker').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  
       
    });
</script>
<?php echo $this->session->flashdata('message_nodata'); ?>
<?php echo $this->session->flashdata('message_cetak'); ?>
<section class="content-header">
		
	<div class="small-box" style="background: #e4efe0">
		<div class="inner">
			<div class="container-fluid text-center"><br/>
				
				<div class="form-inline">			
					<?php echo form_open('ird/IrDKwitansi/kwitansi_by_date');?>
					<input type="text" class="form-control" name="date" id="date_picker" placeholder="Tanggal Kunjungan" value="<?php //echo date('d-m-Y'); ?>" required>
						
							<button class="btn btn-primary" type="submit">Cari</button>
					
					<?php echo form_close();?>
						
				</div>		
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="row">				
	 <div class="box" style="width:97%;margin:0 auto">
		<div class="box-header">
			<h3 class="box-title">Daftar Kwitansi</h3>			
		</div>
				
		<table id="kwitansiTable" class="display" cellspacing="0" width="98%">
		  <thead>
			<tr>
			  <th>No</th>
			  <th>Tanggal Kunjungan</th>
			  <th>No Registrasi</th>
			  <th>No Medrec</th>
			  <th>Nama</th>	
			  <th>Cara Bayar</th>		
			  <th>Aksi</th>
			</tr>
		  </thead>
		  <tfoot>
			<tr>
			  <th>No</th>
			  <th>Tanggal Kunjungan</th>
			  <th>No Registrasi</th>
			  <th>No Medrec</th>
			  <th>Nama</th>
			  <th>Cara Bayar</th>
			  <th>Aksi</th>
			</tr>
		</tfoot>
		<tbody>
		<?php $i=1; foreach($pasien_daftar as $row){
			$no_register=$row->no_register;?>
			<tr>
			  <td><?php echo $i++;?></td>
			  <td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan)).' | '.date("h:m", strtotime($row->tgl_kunjungan)); ?></td>
			  <td><?php echo $row->no_register;?></td>
			  <td><?php echo $row->no_cm;?></td>
			  <td><?php echo $row->nama;?></td>
			  <td><?php echo $row->cara_bayar;?></td>
			  <td ><a href="<?php echo site_url('ird/IrDKwitansi/kwitansi_pasien/'.$no_register); ?>" class="btn btn-primary btn-sm"><i class="fa fa-book"></i></a>
			  </td>
			</tr>
			<?php } ?>
		</tbody>
	</table>						
	
	</div>
 </div>
</div>
</section>

<?php $this->load->view("layout/footer"); ?>
