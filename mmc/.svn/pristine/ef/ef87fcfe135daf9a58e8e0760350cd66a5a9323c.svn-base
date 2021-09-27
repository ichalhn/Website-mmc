<?php $this->load->view("layout/header"); ?>
<?php include('script_laprdkunjungan.php');?>
<section class="content-header">
</section>
<section class="content">
	<div class="row">
		<div class="panel panel-default" style="width:97%;margin:0 auto">
			
				<div class="panel-body">
				<?php include('lap_cari.php');?>					
				<hr>
				<table id="example" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
						  <th width="5%">No</th>
						  <th>No Medrec</th>
						  <th>Nama</th>
						  <th width="10%">Jumlah Kunjungan</th>
						  <th>Aksi</th>
						</tr>
					</thead>
					<tfoot>
						<tr>
						  <th width="5%">No</th>
						  <th>No Medrec</th>
						  <th>Nama</th>
						  <th width="10%">Jumlah Kunjungan</th>
						  <th>Aksi</th>
						</tr>
					</tfoot>
					<tbody>
					<?php	// print_r($pasien_daftar);
						$i=1;
						foreach($data_laporan_kunj as $row){
						$no_medrec=$row->no_medrec; ?>
						<tr>
						  <td width="5%"><?php echo $i++;?></td>
						  <td><?php echo $row->no_medrec;?></td>
						  <td><?php echo $row->nama;?></td>
						  <td width="10%"><?php echo $row->jum_kunj;?></td>
						  <td >
							<a href="<?php echo site_url('ird/irDPelayanan/pelayanan_pasien/'.$no_medrec); ?>" class="btn btn-primary btn-xs">Detail</a>								
						  </td>
						</tr>
						<?php } ?>
					</tbody>
					</table>
					<div class="form-inline" align="right">
						<div class="form-group">
							<a target="_blank" href="<?php echo site_url('ird/IrDLaporan/lap_kunj/'.$tgl_awal.'/'.$tgl_akhir);?>"><input type="button" class="btn btn-primary" value="Cetak"></a>
						</div>
					</div>							
				</div>
			</div>
		</div><!--- end row --->
</section>	

<?php $this->load->view("layout/footer"); ?>
