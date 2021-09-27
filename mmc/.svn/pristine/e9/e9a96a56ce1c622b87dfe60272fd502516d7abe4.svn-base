<?php $this->load->view("layout/header"); ?>
<?php $this->load->view("iri/layout/script_addon"); ?>
<?php $this->load->view("iri/data_pasien_keluar_selesai"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>

<div >
	<div >
		
		<!-- Keterangan page -->
		<section class="content-header">
			<h1>STATUS PASIEN DI RUANGAN</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-home"></i> Home</a></li>
				<li><a href="#">Status</a></li>
			</ol>
		</section>
		<!-- /Keterangan page -->

        <!-- Main content -->
        <section class="content">
			<div class="row">
				<div class="col-sm-12">
					<?php echo $this->session->flashdata('pesan');?>
					<!-- Tabs -->
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#mutasi" data-toggle="tab">Ruangan</a></li>
							<li class=""><a href="#tindakan" data-toggle="tab">Tindakan</a></li>
							<li class=""><a href="#radiologi" data-toggle="tab">Radiologi</a></li>
							<li class=""><a href="#lab_pasien" data-toggle="tab">Lab</a></li>
							<li class=""><a href="#resep_pasien" data-toggle="tab">Resep</a></li>
							<li class=""><a href="#tindakan_ird" data-toggle="tab">Tindakan IRD</a></li>
							<li class=""><a href="#poli_irj" data-toggle="tab">Poli IRJ</a></li>
							
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="mutasi">
								<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example2">
								  <thead>
									<tr>
									  <th>Ruang</th>
									  <th>Kelas</th>
									  <th>Bed</th>
									  <th>Tgl Masuk</th>
									  <th>Tgl Keluar</th>
									  <th>Lama Inap</th>
									  <th>Total Biaya</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($list_mutasi_pasien)){
										foreach($list_mutasi_pasien as $r){ ?>
										<tr>
											<td><?php echo $r['nmruang'] ; ?></td>
											<td><?php echo $r['kelas'] ; ?></td>
											<td><?php echo $r['bed'] ; ?></td>
											<td>
												<?php 
										  		$tgl_indo = $controller->obj_tanggal();

										  		$bln_row = $tgl_indo->bulan(substr($r['tglmasukrg'],6,2));
										  		$tgl_row = substr($r['tglmasukrg'],8,2);
										  		$thn_row = substr($r['tglmasukrg'],0,4);

										  		echo $tgl_row." ".$bln_row." ".$thn_row;
										  		?>
											</td>
											<td><?php 
											if($r['tglkeluarrg'] != null){
												
												$tgl_indo = $controller->obj_tanggal();

										  		$bln_row = $tgl_indo->bulan(substr($r['tglkeluarrg'],6,2));
										  		$tgl_row = substr($r['tglkeluarrg'],8,2);
										  		$thn_row = substr($r['tglkeluarrg'],0,4);

										  		echo $tgl_row." ".$bln_row." ".$thn_row;

												//echo date("j F Y", strtotime($r['tglkeluarrg'])) ;
											}else{
												if($data_pasien[0]['tgl_keluar'] != NULL){
													//echo date("j F Y", strtotime($data_pasien[0]['tgl_keluar'])) ;

													$tgl_indo = $controller->obj_tanggal();

											  		$bln_row = $tgl_indo->bulan(substr($data_pasien[0]['tgl_keluar'],6,2));
											  		$tgl_row = substr($data_pasien[0]['tgl_keluar'],8,2);
											  		$thn_row = substr($data_pasien[0]['tgl_keluar'],0,4);

											  		echo $tgl_row." ".$bln_row." ".$thn_row;
												}else{
													echo "-";	
												}
											}
											?>

											</td>
											<td>
											<?php
											$diff = 1;
											if($r['tglkeluarrg'] != null){
												$start = new DateTime($r['tglmasukrg']);//start
												$end = new DateTime($r['tglkeluarrg']);//end

												$diff = $end->diff($start)->format("%a");
												if($diff == 0){
													$diff = 1;
												}
												echo $diff." Hari"; 
											}else{
												if($data_pasien[0]['tgl_keluar'] != NULL){
												$start = new DateTime($r['tglmasukrg']);//start
													$end = new DateTime($data_pasien[0]['tgl_keluar']);//end

													$diff = $end->diff($start)->format("%a");
													if($diff == 0){
														$diff = 1;
													}
													echo $diff." Hari"; 
												}else{
													$start = new DateTime($r['tglmasukrg']);//start
													$end = new DateTime(date("Y-m-d"));//end

													$diff = $end->diff($start)->format("%a");
													if($diff == 0){
														$diff = 1;
													}
													
													echo $diff." Hari"; 
												}
											}
											?>
											</td>
											<td>
											<?php
											//kalo paket 2 hari inep free
											if($status_paket == 1){
												$temp_diff = $diff - 2;//kalo ada paket free 2 hari
												if($temp_diff < 0){
													$temp_diff = 0;
												}
												echo "Rp. ".number_format( ($temp_diff * $r['vtot'] ) - ($temp_diff * $r['harga_jatah_kelas'] ),0);
												$total_bayar = $total_bayar + ($temp_diff * $r['vtot'] ) - ($temp_diff * $r['harga_jatah_kelas'] );
											}else{
												echo "Rp. ".number_format( ($diff * $r['vtot'] ) - ($diff * $r['harga_jatah_kelas'] ),0);
												$total_bayar = $total_bayar + ($diff * $r['vtot'] ) - ($diff * $r['harga_jatah_kelas'] );
											}
											?>

											</td>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<table width="100%" class="table table-hover table-striped table-bordered">
									<tr>
									  <td colspan="6">Total Ruangan</td>
									  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
									</tr>
								</table>
							</div>
							<div class="tab-pane" id="tindakan">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
								  <thead>
									<tr>
									  <th>Tindakan</th>
									  <th>Pelaksana</th>
									  <th>Tgl Tindakan</th>
									  <th>Biaya Tindakan</th>
									  <th>Biaya Alkes</th>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
									<?php
									$total_bayar = 0;
									if(!empty($list_tindakan_pasien)){
										foreach($list_tindakan_pasien as $r){ ?>
										<tr>
											<td><?php echo $r['nmtindakan'] ; ?></td>
											<td><?php echo $r['nmdokter'] ; ?></td>
											<td><?php 											

									  		echo date('d F Y',strtotime($r['tgl_layanan']));

											?></td>
											<td>Rp. <?php echo number_format($r['tumuminap'] - $r['harga_satuan_jatah_kelas'],0) ; ?></td>
											<td>Rp. <?php echo number_format($r['tarifalkes'],0) ; ?></td>
											<td><?php echo $r['qtyyanri'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'] - $r['vtot_jatah_kelas'],0) ; ?></td>
											<?php $total_bayar = $total_bayar + $r['vtot'] - $r['vtot_jatah_kelas'];?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<table width="100%" class="table table-hover table-striped table-bordered">
									<tr>
									  <td colspan="6">Total Tindakan</td>
									  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
									</tr>
								</table>
							</div>
							<div class="tab-pane" id="lab_pasien">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example4">
								  <thead>
									<tr>
									  <th>Jenis Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Harga Satuan</th>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($list_lab_pasien)){
										foreach($list_lab_pasien as $r){ ?>
										<tr>
											<td><?php echo $r['jenis_tindakan'] ; ?></td>
											<td><?php 
											$tgl_indo = $controller->obj_tanggal();

									  		$bln_row = $tgl_indo->bulan(substr($r['xupdate'],6,2));
									  		$tgl_row = substr($r['xupdate'],8,2);
									  		$thn_row = substr($r['xupdate'],0,4);

									  		echo $tgl_row." ".$bln_row." ".$thn_row;

											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_lab'],0) ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'],0) ; ?></td>
											<?php echo $total_bayar = $total_bayar + $r['vtot'];?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<table width="100%" class="table table-hover table-striped table-bordered">
									<tr>
									  <td colspan="6">Total Laboratorium</td>
									  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
									</tr>
								</table>
							</div>
							<div class="tab-pane" id="radiologi">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example0">
								  <thead>
									<tr>
									  <th>Jenis Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Harga Satuan</th>
									  <th>Qty</th>
									  <th>Total Harga</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($list_radiologi)){
										foreach($list_radiologi as $r){ ?>
										<tr>
											<td><?php echo $r['jenis_tindakan'] ; ?></td>
											<td><?php 
											$tgl_indo = $controller->obj_tanggal();

									  		$bln_row = $tgl_indo->bulan(substr($r['xupdate'],6,2));
									  		$tgl_row = substr($r['xupdate'],8,2);
									  		$thn_row = substr($r['xupdate'],0,4);

									  		echo $tgl_row." ".$bln_row." ".$thn_row;

											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_rad'],0) ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot']) ; ?></td>
											<?php echo $total_bayar = $total_bayar + $r['vtot'] ;?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<table width="100%" class="table table-hover table-striped table-bordered">
									<tr>
									  <td colspan="6">Total Radiologi</td>
									  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
									</tr>
								</table>
							</div>
							<div class="tab-pane" id="resep_pasien">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example5">
								  <thead>
									<tr>
									  <th>No Resep</th>
									  <th>Nama Obat</th>
									  <th>Tgl Tindakan</th>
									  <th>Satuan Obat</th>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($list_resep)){
										foreach($list_resep as $r){ ?>
										<tr>
											<td><?php echo $r['no_resep'] ; ?></td>
											<td><?php echo $r['nama_obat'] ; ?></td>
											<td><?php 
											$tgl_indo = $controller->obj_tanggal();

									  		$bln_row = $tgl_indo->bulan(substr($r['xupdate'],6,2));
									  		$tgl_row = substr($r['xupdate'],8,2);
									  		$thn_row = substr($r['xupdate'],0,4);

									  		echo $tgl_row." ".$bln_row." ".$thn_row;

											?></td>
											<td><?php echo $r['Satuan_obat'] ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'],0) ; ?></td>
											<?php echo $total_bayar = $total_bayar + $r['vtot'];?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<table width="100%" class="table table-hover table-striped table-bordered">
									<tr>
									  <td colspan="6">Total Resep</td>
									  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
									</tr>
								</table>
								<a target="_blank" href="<?php echo base_url() ;?>iri/ricstatus/cetak_detail_farmasi/<?php echo $data_pasien[0]['no_ipd'] ;?>"><input type="button" class="btn btn-primary btn-sm" value="Cetak Detail"></a>
							</div>
							<div class="tab-pane" id="tindakan_ird">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example6">
								  <thead>
									<tr>
									  <th>Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Biaya</th>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($list_tindakan_ird)){
										foreach($list_tindakan_ird as $r){ ?>
										<tr>
											<td><?php echo $r['nama_tindakan'] ; ?></td>
											<td><?php 
											$tgl_indo = $controller->obj_tanggal();

									  		$bln_row = $tgl_indo->bulan(substr($r['tgl_kunjungan'],6,2));
									  		$tgl_row = substr($r['tgl_kunjungan'],8,2);
									  		$thn_row = substr($r['tgl_kunjungan'],0,4);

									  		echo $tgl_row." ".$bln_row." ".$thn_row;

											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_ird'],0) ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'],0) ; ?></td>
											<?php $total_bayar = $total_bayar + $r['vtot'];?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>
								<table width="100%" class="table table-hover table-striped table-bordered">
									<tr>
									  <td colspan="6">Total Tindakan IRD</td>
									  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
									</tr>
								</table>
							</div>
							<div class="tab-pane" id="poli_irj">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example7">
								  <thead>
									<tr>
									  <th>Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Biaya</th>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($poli_irj)){
										foreach($poli_irj as $r){ ?>
										<tr>
											<td><?php echo $r['nmtindakan'] ; ?></td>
											<td><?php 
											$tgl_indo = $controller->obj_tanggal();

									  		$bln_row = $tgl_indo->bulan(substr($r['tgl_kunjungan'],6,2));
									  		$tgl_row = substr($r['tgl_kunjungan'],8,2);
									  		$thn_row = substr($r['tgl_kunjungan'],0,4);

									  		echo $tgl_row." ".$bln_row." ".$thn_row;

											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_tindakan'],0) ; ?></td>
											<td><?php echo $r['qtyind'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'],0) ; ?></td>
											<?php $total_bayar = $total_bayar + $r['vtot'];?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>
								<table width="100%" class="table table-hover table-striped table-bordered">
									<tr>
									  <td colspan="6">Total Tindakan IRJ</td>
									  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
									</tr>
								</table>
							</div>
						</div>
						
						</div>
					</div>
					<!-- /Tabs -->
					
				</div>
			</div>
		</section>
		<!-- /Main content -->
		
	</div>
</div>
<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
	});

	$(document).ready(function() {
		var dataTable = $('#dataTables-example2').DataTable( {
			
		});
	});

	$(document).ready(function() {
		var dataTable = $('#dataTables-example4').DataTable( {
			
		});
	});

	$(document).ready(function() {
		var dataTable = $('#dataTables-example5').DataTable( {
			
		});
	});

	$(document).ready(function() {
		var dataTable = $('#dataTables-example6').DataTable( {
			
		});
	});

	$(document).ready(function() {
		var dataTable = $('#dataTables-example0').DataTable( {
			
		});
	});

	$(document).ready(function() {
		var dataTable = $('#dataTables-example7').DataTable( {
			
		});
	});
</script>

<?php $this->load->view("layout/footer"); ?>

