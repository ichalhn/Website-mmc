<?php
	$this->load->view('layout/header.php');
?>

<script type='text/javascript'>
	
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
				<!-- <h3 class="box-title">Daftar SJP</h3>			 -->
			</div>
			<div class="box-body">
				
				<!-- <hr> -->`
				<br/>
					<table id="tabel_kwitansi" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>No</th>
							  <th width="20px">Tanggal Kunjungan</th>
							  <th width="15px">No Registrasi</th>
							  <th>No Medrec</th>
							  <th>Nama</th>
							  <th>Cara Bayar</th>
							  <th>Penjamin</th>
							  <th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						
							<?php
							// print_r($pasien_daftar);
							$i=1;
							foreach($pasien_daftar as $row){
								$no_register=$row->no_register;
							if($row->no_cm!=''){
						?>
							<tr>
							  <td><?php echo $i++;?></td>
							  <td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan)).' | '.date("h:m", strtotime($row->tgl_kunjungan)); ?></td>
							  <td><?php echo $row->no_register;?></td>
							  <td><?php echo $row->no_cm;?></td>
							  <td><?php echo $row->nama;?></td>
							  <td><?php echo $row->cara_bayar;?></td>
							  <td><?php echo $row->id_kontraktor.'-'.$row->nmkontraktor;?></td>
							  <td>
								<a href="<?php echo site_url('ird/irDSjp/cetak_sjp/'.$no_register); ?>" class="btn btn-default btn-sm"><i class="fa fa-book"></i> Cetak SJP</a>
							  </td>
							</tr>
						<?php
							}}
						?>
						</tbody>
					</table>
					
					<?php
					//echo $this->session->flashdata('message_nodata');
					?>
				</div>
			</div><!-- /panel body -->
        </div><!-- /.box-body -->
	</div><!-- /.box -->
</section>

<?php
	$this->load->view('layout/footer.php');
?>
