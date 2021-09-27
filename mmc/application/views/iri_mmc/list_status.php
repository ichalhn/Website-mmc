<?php $this->load->view("layout/header"); ?>
<!-- <?php $this->load->view("iri/layout/script_addon"); ?> -->
<br>
<?php $this->load->view("iri/data_pasien"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>

<div >
	<div >
		
		<!-- Keterangan page -->
		<section class="content-header">
			<h1>STATUS PASIEN DI RUANGAN</h1>
			
		</section>
		<!-- /Keterangan page -->

        <!-- Main content -->
        <section class="content">
        	
			<div class="row">
			
				<div class="col-sm-12">
					<?php echo $this->session->flashdata('pesan_tindakan');?>
					<?php echo $this->session->flashdata('pesan');?>
					<!-- Tabs -->
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#mutasi" data-toggle="tab">Ruangan</a></li>
							<li class=""><a href="#tindakan" data-toggle="tab">Tindakan</a></li>
							<li class=""><a href="#gizi_pasien" data-toggle="tab">Gizi</a></li>
							<li class=""><a href="#ok_pasien" data-toggle="tab">Operasi</a></li>
							<li class=""><a href="#radiologi" data-toggle="tab">Diagnostik</a></li>
							<li class=""><a href="#lab_pasien" data-toggle="tab">Lab</a></li>
							<!--<li class=""><a href="#pa_pasien" data-toggle="tab">Patologi Anatomi</a></li>-->
							<li class=""><a href="#resep_pasien" data-toggle="tab">Resep</a></li>
							<!--<li class=""><a href="#tindakan_ird" data-toggle="tab">Tindakan IRD</a></li>-->
							<li class=""><a href="#poli_irj" data-toggle="tab">Poli</a></li>
							
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="mutasi">
								<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
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
										foreach($list_mutasi_pasien as $r){ 
											?>
										<tr>
											<td><?php echo $r['nmruang'] ; ?></td>
											<td><?php echo $r['kelas'] ; ?></td>
											<td><?php echo $r['bed'] ; ?></td>
											<td>
												<?php 
										  		
										  		echo date('d F Y', strtotime($r['tglmasukrg']));
										  		?>
											</td>
											<td><?php 
											if($r['tglkeluarrg'] != null and $r['tglkeluarrg'] !=''){
												
												
										  		echo date('d F Y', strtotime($r['tglkeluarrg']));

												//echo date("j F Y", strtotime($r['tglkeluarrg'])) ;
											}else{
												if($data_pasien[0]['tgl_keluar'] != NULL and $data_pasien[0]['tgl_keluar'] !=''){
													//echo date("j F Y", strtotime($data_pasien[0]['tgl_keluar'])) ;

											  		echo date('d F Y', strtotime($r['tglkeluarrg'])); 
												}else{
													echo "-";	
												}
											}
											?>

											</td>
											<td>
											<?php
											$diff = 1;
											if($r['tglkeluarrg'] != null and $r['tglkeluarrg'] !=''){
												$start = new DateTime($r['tglmasukrg']);//start
												$end = new DateTime($r['tglkeluarrg']);//end

												$diff = $end->diff($start)->format("%a");
												if($diff == 0){
													$diff = 1;
												}
												echo $diff." Hari"; 
											}else{
												if($data_pasien[0]['tgl_keluar'] != NULL and $data_pasien[0]['tgl_keluar'] !=''){
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
											/*if($status_paket == 1){
												$temp_diff = $diff - 2;//kalo ada paket free 2 hari
												if($temp_diff < 0){
													$temp_diff = 0;
												}
												echo "Rp. ".number_format( ($temp_diff * $r['vtot'] ) - ($temp_diff * $r['harga_jatah_kelas'] ),0);
												$total_bayar = $total_bayar + ($temp_diff * $r['vtot'] ) - ($temp_diff * $r['harga_jatah_kelas'] );
											}else{*/
												echo "Rp. ".number_format( ($diff * $r['vtot'] ) - ($diff * $r['harga_jatah_kelas'] ),0);
												$total_bayar = $total_bayar + ($diff * $r['vtot'] ) - ($diff * $r['harga_jatah_kelas'] );
											//}
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

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Ruangan</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="tindakan">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example2">
								  <thead>
									<tr>
									  <th>Tindakan</th>
									  <th>Pelaksana</th>
									  <th>Ruangan</th>
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
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td><?php  echo $r['nmruang'] ; ?></td>
											<td><?php 
									  		echo date('d F Y', strtotime($r['tgl_layanan']));

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
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Tindakan</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="lab_pasien">
								<div class="form-inline" align="right">
									<div class="input-group">
									<?php
									if(!empty($cetak_lab_pasien)){
										echo form_open('lab/labcpengisianhasil/st_cetak_hasil_lab_rawat');
									?>
										<select id="no_lab" class="form-control" name="no_lab"  required>
											<?php 
												foreach($cetak_lab_pasien as $row){
													echo "<option value=".$row['no_lab']." selected>".$row['no_lab']."</option>";
												}
											?>
										</select>
										<span class="input-group-btn">
											<button type="submit" class="btn btn-primary">Cetak Hasil</button>
										</span>
								
									<?php 
										echo form_close();
									}else{
										echo "Hasil Pemeriksaan Belum Keluar";
									}
									?>	
									</div>
								</div>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example4">
								  <thead>
									<tr>
									  <th>No Lab</th>
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
											<td><?php echo $r['no_lab'] ; ?></td>
											<td><?php echo $r['jenis_tindakan'] ; ?></td>
											<td><?php 
											
									  		echo date('d F Y', strtotime($r['xupdate']));

											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_lab'],0) ; ?></td>
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
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>


								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Laboratorium</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>	
							</div>
							<div class="tab-pane" id="pa_pasien">
								<div class="form-inline" align="right">
									<div class="input-group">
									<?php
									if(!empty($cetak_pa_pasien)){
										echo form_open('pa/pacpengisianhasil/st_cetak_hasil_pa_rawat');
									?>
										<select id="no_pa" class="form-control" name="no_pa"  required>
											<?php 
												foreach($cetak_pa_pasien as $row){
													echo "<option value=".$row['no_pa']." selected>".$row['no_pa']."</option>";
												}
											?>
										</select>
										<span class="input-group-btn">
											<button type="submit" class="btn btn-primary">Cetak Hasil</button>
										</span>
								
									<?php 
										echo form_close();
									}else{
										echo "Hasil Pemeriksaan Belum Keluar";
									}
									?>	
									</div>
								</div>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example5">
								  <thead>
									<tr>
									  <th>No PA</th>
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
									if(!empty($list_pa_pasien)){
										foreach($list_pa_pasien as $r){ ?>
										<tr>
											<td><?php echo $r['no_pa'] ; ?></td>
											<td><?php echo $r['jenis_tindakan'] ; ?></td>
											<td>
											<?php 

									  		echo date('d F Y', strtotime($r['xupdate']));
											?>
											</td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_pa'],0) ; ?></td>
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
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Patologi Anatomi</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="ok_pasien">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example9">
								  <thead>
									<tr>
									  	<th>No Ok</th>
									  	<th width="15%">Jadwal Operasi</th>
									  	<th>Jenis Pemeriksaan</th>
									  	<th>Operator</th>
									  	<th width="10%">Total Pemeriksaan</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($list_ok_pasien)){
										foreach($list_ok_pasien as $row){ ?>
										<tr>
											<td><?php echo $row['no_ok'] ; ?></td>
											<td><?php echo date('d F Y', strtotime($row['tgl_operasi'])); ?></td>
											<td><?php echo $row['jenis_tindakan'].' ('.$row['id_tindakan'].')' ; ?></td>
											<td>
												<?php
													echo 'Dokter : '.$row['nm_dokter'].' ('.$row['id_dokter'].')';
													if($row['id_opr_anes']<>NULL)
													echo '<br>- Operator Anestesi: '.$row['nm_opr_anes'].' ('.$row['id_opr_anes'].')';
													if($row['id_dok_anes']<>NULL)
													echo '<br>- Dokter Anestesi: '.$row['nm_dok_anes'].' ('.$row['id_dok_anes'].')';
													if($row['jns_anes']<>NULL)
													echo '<br>- Jenis Anestesi: '.$row['jns_anes'];
													if($row['id_dok_anak']<>NULL)
													echo '<br>- Dokter Anak: '.$row['nm_dok_anak'].' ('.$row['id_dok_anak'].')';
												?> 
											</td>
											<td><?php echo 'Rp '.number_format( $row['vtot'], 2 , ',' , '.' ); ?></td>
											<?php $total_bayar = $total_bayar + $row['vtot'];?>
										</tr>
									<?php
										}
									}else{ ?>
									<tr>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Biaya Operasi</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table> 
									</div>
								</div>
							</div>
							<div class="tab-pane" id="gizi_pasien">
								<div class="form-group row">
									<div class="col-sm-1"></div>
									<p class="col-sm-4 form-control-label" id="catatan_gizi">Catatan Gizi</p>
										<div class="col-sm-6">
											<div class="form-group row">
												<textarea class="form-control" name="catatangizi1" id="catatangizi1" cols="30" rows="5" style="resize:vertical" disabled><?php echo $data_pasien[0]['catatangizi'];?></textarea>				
											</div>
										</div>
								</div>
							</div>
							<div class="tab-pane" id="radiologi">
								<div class="form-inline" align="right">
									<div class="input-group">
									<?php
									if(!empty($cetak_rad_pasien)){
										echo form_open('rad/radcpengisianhasil/st_cetak_hasil_rad_rawat');
									?>
										<select id="no_rad" class="form-control" name="no_rad"  required>
											<?php 
												foreach($cetak_rad_pasien as $row){
													echo "<option value=".$row['no_rad']." selected>".$row['no_rad']."</option>";
												}
											?>
										</select>
										<span class="input-group-btn">
											<button type="submit" class="btn btn-primary">Cetak Hasil</button>
										</span>
								
									<?php 
										echo form_close();
									}else{
										echo "Hasil Pemeriksaan Belum Keluar";
									}
									?>	
									</div>
								</div>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example6">
								  <thead>
									<tr>
									  <th>No Rad</th>
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
											<td><?php echo $r['no_rad'] ; ?></td>
											<td><?php echo $r['jenis_tindakan'] ; ?></td>
											<td><?php 
									  		echo date('d F Y', strtotime($r['xupdate']));

											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_rad'],0) ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot']) ; ?></td>
											<?php $total_bayar = $total_bayar + $r['vtot'] ;?>
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

								
								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Diagnostik</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="resep_pasien">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example7">
								  <thead>
									<tr>
									  <th>No Resep</th>
									  <th>Nama Obat</th>
									  <th>Tgl Tindakan</th>
									  <th>Satuan Obat</th>
									  <th>Qty</th>
									  <th>Total</th>
									  <!-- <th>Status</th> -->
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
									  		echo date('d F Y', strtotime($r['xupdate']));
											?></td>
											<td><?php echo $r['Satuan_obat'] ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'],0) ; ?></td>
											<?php $total_bayar = $total_bayar + $r['vtot'];?>
											<!-- <td><?php echo $r['cetak_kwitansi'] ; ?></td> -->
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
											<!-- <td>Data Kosong</td> -->
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Resep</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
								<a target="_blank" href="<?php echo base_url() ;?>iri/ricstatus/cetak_detail_farmasi/<?php echo $data_pasien[0]['no_ipd'] ;?>"><input type="button" class="btn btn-primary btn-sm" value="Cetak Detail"></a>
							</div>
							<!--<div class="tab-pane" id="tindakan_ird">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example8">
								  <thead>
									<tr>
									  <th>Tindakan</th>
									  <th>Tgl Tindakan</th>
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
											<td><?php echo $r['id_tindakan_ird'] ; ?></td>
											<td><?php echo $r['idtindakan'] ; ?></td>
											<td><?php echo $r['nama_tindakan'] ; ?></td>
											<td><?php 
											
									  		echo date('d F Y', strtotime($r['tgl_kunjungan']));

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

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Tindakan IRD</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>-->
							<div class="tab-pane" id="poli_irj">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example10">
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
											
									  		echo date('d F Y', strtotime($r['tgl_kunjungan']));

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

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Tindakan Poli</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
						
						</div>
					</div>
					<!-- /Tabs -->
					
				</div>
							
		</section>
		<!-- /Main content -->
		</div>
	</div>

<script>
	$(document).ready(function() {
	    $('#dataTables-example').DataTable();
	    $('#dataTables-example2').DataTable();
	    $('#dataTables-example4').DataTable();
	    $('#dataTables-example5').DataTable();
	    $('#dataTables-example6').DataTable();
	    $('#dataTables-example7').DataTable();
	    $('#dataTables-example8').DataTable();
	    $('#dataTables-example9').DataTable();
	    $('#dataTables-example10').DataTable();
	});
</script>

<?php $this->load->view("layout/footer"); ?>
