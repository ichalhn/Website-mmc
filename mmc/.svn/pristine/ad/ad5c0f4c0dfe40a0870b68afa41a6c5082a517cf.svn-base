<?php
	$this->load->view('layout/header.php');
?>

<script type='text/javascript'>
var intervalSetting = function () { 
location.reload(); 
}; 
setInterval(intervalSetting, 120000);

	$(function() {
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});  
	});
	
	$(document).ready(function() {
		$('#tabel_kwitansi').DataTable();
	} );

</script>
	
<?php
	echo $this->session->flashdata('message_cetak'); 
?>
<section class="content">
	<div class="row">				
		<div class="box" style="width:97%;margin:0 auto">
			<div class="box-header">
				<h3 class="box-title">Daftar Rekap Faktur & Kwitansi IRI <b><?php echo $date;?></b></h3>			
			</div>
			<div class="box-body">
				<div class="form-group row">
					<div class="col-md-3">
						<?php echo form_open('faktur/fcrekap/rawat_inap');?>
							<div class="input-group">
								<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date">
								<span class="input-group-btn">
									<button class="btn btn-primary" type="submit">Cari</button>
								</span>
							</div><!-- /input-group -->
						<?php echo form_close();?>
					</div><!-- /.col-lg-6 -->
						
				</div><!-- /inline -->
				
				<hr>
				<br/>
					<table id="tabel_kwitansi" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th>Tanggal Kunjungan</th>
							  <th>No Registrasi</th>
							  <th>No Medrec</th>
							  <th>Nama</th>
							  <th>Cara Bayar</th>
							  <th>Poli</th>
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
							  <td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan)).' | '.date("h:m", strtotime($row->tgl_kunjungan)); ?></td>
							  <td><?php echo $row->no_register;?></td>
							  <td><?php echo $row->no_cm;?></td>
							  <td><?php echo $row->nama;?></td>
							  <td><?php echo $row->cara_bayar;?></td>
							  <td><?php echo $row->id_poli.'-'.$row->nm_poli;?></td>
							  <td>
								<!-- <a href="<?php echo site_url('irj/rjcregistrasi/cetak_faktur_kt/'.$no_register); ?>" target="_blank"class="btn bg-orange btn-xs" style="width:63px;">Faktur</a>
								<a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $row->no_register;?>" target="_blank"><input type="button" class="btn btn-primary btn-xs" value="Cetak Faktur"></a> -->
								<a href="<?php echo site_url('faktur/fcrekap/faktur_iri/'.$no_register); ?>" target="_blank" class="btn btn-primary btn-xs" style="width:63px;">Faktur</a>
								<a href="<?php echo site_url('faktur/fcrekap/kw_iri/'.$no_register); ?>" target="_blank" class="btn btn-primary btn-xs" style="width:63px;">Kwitansi</a>
								<a href="<?php echo site_url('faktur/fcrekap/kw_iri/'.$no_register); ?>" target="_blank" class="btn btn-primary btn-xs" style="width:63px;">MR</a>
							  </td>
							</tr>
						<?php
							}
						?>
						</tbody>
					</table>
					
					<?php
					//echo $this->session->flashdata('message_nodata');
					?>
				</div>
			</div><!-- /panel body -->
        </div><!-- /.box-body -->
</section>

<?php
	$this->load->view('layout/footer.php');
?>
