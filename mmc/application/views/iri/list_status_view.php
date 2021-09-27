<?php $this->load->view("layout/header"); ?>
<!-- <?php $this->load->view("iri/layout/script_addon"); ?> -->
<br>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>

<script>
	$('#tgl_pulang').datepicker({
		format: 'yyyy-mm-dd'
	});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_diagnosa_pasien').autocomplete({
		serviceUrl: site+'iri/ricstatus/data_icd_1',
		onSelect: function (suggestion) {
			//$('#no_cm').val(''+suggestion.no_cm);
			$('#diagnosa1').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
			$('#id_row_diagnosa').val(''+suggestion.id_icd);
			// $('#nama').val(''+suggestion.nama);
			// $('.tanggal_lahir').val(''+suggestion.tanggal_lahir);
			// if(suggestion.jenis_kelamin=='L'){
			// 	$('#laki_laki').attr('selected', 'selected');
			// 	$('#perempuan').removeAttr('selected', 'selected');
			// }else{
			// 	$('#laki_laki').removeAttr('selected', 'selected');
			// 	$('#perempuan').attr('selected', 'selected');
			// }
			// $('#telp').val(''+suggestion.telp);
			// $('#hp').val(''+suggestion.hp);
			// $('#id_poli').val(''+suggestion.id_poli);
			// $('#poliasal').val(''+suggestion.poliasal);
			// $('#id_dokter').val(''+suggestion.id_dokter);
			// $('#dokter').val(''+suggestion.dokter);
			// $('#diagnosa').val(''+suggestion.diagnosa);
		}
	});
});

function update_status_pemeriksaan_ok(no_ipd){
	var r = confirm("Anda yakin ingin menambah pemeriksaan Operasi ?");
	if (r == true) {
	   $.ajax({
		    type:'POST',
		    url:'<?php echo base_url("iri/rictindakan/set_status_ok/"); ?>',
		    data:{
		    		'no_ipd':no_ipd
		    	},
		    success:function(data){
	    		//var obj = JSON.parse(data);
	    		//alert("Request Pemeriksaan Radiologi Berhasil Dikirim. ");	
	    		//window.open("'.site_url("rad/radcdaftar/pemeriksaan_rad/no_ipd").'", "_blank");
	    		window.open(' <?php echo base_url("ok/okcdaftar/pemeriksaan_ok")?>/'+no_ipd);
	    		// if(!isEmpty(obj)){
	    		// 	$("#harga_satuan_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$("#biaya_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$('#vtot_kelas').val(obj[0]['total_tarif']);
	    		// 	$('#vtot').val(total - (obj[0]['total_tarif'] * qty) );
	    		// 	$('#biaya_tindakan').val(temp[1] - obj[0]['total_tarif']);
	    		// }else{
	    		// 	$("#harga_satuan_jatah_kelas").val('0');
	    		// 	$("#biaya_jatah_kelas").val('0');
	    		// 	//$('#vtot').val('0');
	    		// }
		    }
		});
	   return true;
	} else {
	    return false;
	}
	
}

function update_status_pemeriksaan_rad(no_ipd){
	var r = confirm("Anda yakin ingin menambah pemeriksaan Radiologi ?");
	if (r == true) {
	   $.ajax({
		    type:'POST',
		    url:'<?php echo base_url("iri/rictindakan/set_status_rad/"); ?>',
		    data:{
		    		'no_ipd':no_ipd
		    	},
		    success:function(data){
	    		//var obj = JSON.parse(data);
	    		//alert("Request Pemeriksaan Radiologi Berhasil Dikirim. ");	
	    		//window.open("'.site_url("rad/radcdaftar/pemeriksaan_rad/no_ipd").'", "_blank");
	    		window.open(' <?php echo base_url("rad/radcdaftar/pemeriksaan_rad")?>/'+no_ipd);
	    		// if(!isEmpty(obj)){
	    		// 	$("#harga_satuan_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$("#biaya_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$('#vtot_kelas').val(obj[0]['total_tarif']);
	    		// 	$('#vtot').val(total - (obj[0]['total_tarif'] * qty) );
	    		// 	$('#biaya_tindakan').val(temp[1] - obj[0]['total_tarif']);
	    		// }else{
	    		// 	$("#harga_satuan_jatah_kelas").val('0');
	    		// 	$("#biaya_jatah_kelas").val('0');
	    		// 	//$('#vtot').val('0');
	    		// }
		    }
		});
	   return true;
	} else {
	    return false;
	}
	
}


function update_status_pemeriksaan_lab(no_ipd){
	var r = confirm("Anda yakin ingin menambah pemeriksaan Laboratorium ?");
	if (r == true) {
	   $.ajax({
		    type:'POST',
		    url:'<?php echo base_url("iri/rictindakan/set_status_lab/"); ?>',
		    data:{
		    		'no_ipd':no_ipd
		    	},
		    success:function(data){
	    		//var obj = JSON.parse(data);
	    		//alert("Request Pemeriksaan Laboratorium Berhasil Dikirim. ");
	    		window.open(' <?php echo base_url("lab/labcdaftar/pemeriksaan_lab")?>/'+no_ipd);
	    		// if(!isEmpty(obj)){
	    		// 	$("#harga_satuan_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$("#biaya_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$('#vtot_kelas').val(obj[0]['total_tarif']);
	    		// 	$('#vtot').val(total - (obj[0]['total_tarif'] * qty) );
	    		// 	$('#biaya_tindakan').val(temp[1] - obj[0]['total_tarif']);
	    		// }else{
	    		// 	$("#harga_satuan_jatah_kelas").val('0');
	    		// 	$("#biaya_jatah_kelas").val('0');
	    		// 	//$('#vtot').val('0');
	    		// }
		    }
		});
	   return true;
	} else {
	    return false;
	}
	
}


function update_status_pemeriksaan_pa(no_ipd){
	var r = confirm("Anda yakin ingin menambah pemeriksaan Patologi Anatomi ?");
	if (r == true) {
	   $.ajax({
		    type:'POST',
		    url:'<?php echo base_url("iri/rictindakan/set_status_pa/"); ?>',
		    data:{
		    		'no_ipd':no_ipd
		    	},
		    success:function(data){
	    		//var obj = JSON.parse(data);
	    		alert("Request Pemeriksaan Patologi Anatomi Berhasil Dikirim. ");
	    		window.open(' <?php echo base_url("pa/pacdaftar/pemeriksaan_pa")?>/'+no_ipd);
	    		// if(!isEmpty(obj)){
	    		// 	$("#harga_satuan_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$("#biaya_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$('#vtot_kelas').val(obj[0]['total_tarif']);
	    		// 	$('#vtot').val(total - (obj[0]['total_tarif'] * qty) );
	    		// 	$('#biaya_tindakan').val(temp[1] - obj[0]['total_tarif']);
	    		// }else{
	    		// 	$("#harga_satuan_jatah_kelas").val('0');
	    		// 	$("#biaya_jatah_kelas").val('0');
	    		// 	//$('#vtot').val('0');
	    		// }
		    }
		});
	   return true;
	} else {
	    return false;
	}
	
}

function update_status_resep(no_ipd){
	var r = confirm("Anda yakin ingin memberikan resep?");
	if (r == true) {
	    $.ajax({
		    type:'POST',
		    url:'<?php echo base_url("iri/rictindakan/set_status_resep/"); ?>',
		    data:{
		    		'no_ipd':no_ipd
		    	},
		    success:function(data){
	    		//var obj = JSON.parse(data);
	    		alert("Request Resep Obat Berhasil Dikirim. ");
	    		// if(!isEmpty(obj)){
	    		// 	$("#harga_satuan_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$("#biaya_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$('#vtot_kelas').val(obj[0]['total_tarif']);
	    		// 	$('#vtot').val(total - (obj[0]['total_tarif'] * qty) );
	    		// 	$('#biaya_tindakan').val(temp[1] - obj[0]['total_tarif']);
	    		// }else{
	    		// 	$("#harga_satuan_jatah_kelas").val('0');
	    		// 	$("#biaya_jatah_kelas").val('0');
	    		// 	//$('#vtot').val('0');
	    		// }
		    }
		});
		return true;
	} else {
	   return false;
	}
}

function update_dokter(no_ipd){
	var r = confirm("Anda yakin ingin mengupdate dokter?");
	if (r == true) {
			var id_dokter = $('#id_dokter').val();
			var nmdokter = $('#nmdokter').val();
	    $.ajax({
		    type:'POST',
		    url:'<?php echo base_url("iri/ricstatus/update_dokter/"); ?>',
		    data:{
		    		'no_ipd':no_ipd,
		    		'id_dokter':id_dokter,
		    		'nmdokter':nmdokter
		    	},
		    success:function(data){
		    	if(data == "1"){
		    		alert("Dokter berhasil diupdate");
		    	}else{
		    		alert("Gagal update. Silahkan coba lagi");
		    	}
		    }
		});
		return true;
	} else {
	   return false;
	}
}

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_dokter').autocomplete({
		serviceUrl: site+'/iri/ricpendaftaran/data_dokter_autocomp',
		onSelect: function (suggestion) {
			$('#id_dokter').val(''+suggestion.id_dokter);
			$('#nmdokter').val(''+suggestion.nm_dokter);
		}
	});
});
</script>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading" align="center">Data Pasien</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-3">
							<div align="center"><img height="100px" class="img-rounded" src="<?php 
									if($data_pasien[0]['foto']==''){
										echo site_url("upload/photo/unknown.png");
									}else{
										echo site_url("upload/photo/".$data_pasien[0]['foto']);
									}
									?>">
							</div>
						</div>
						<div class="col-sm-9">
							<table class="table-sm table-striped" style="font-size:15">
							  <tbody>
								<tr>
									<th>Nama</th>
									<td>:&nbsp;</td>
									<td><?php echo $data_pasien[0]['nama'];?></td>
								</tr>
								<tr>
									<th>No. MedRec</th>
									<td>:&nbsp;</td>
									<td><?php echo $data_pasien[0]['no_cm'];?></td>
								</tr>
								<tr>
									<th>No. Register</th>
									<td>:&nbsp;</td>
									<td><?php echo $data_pasien[0]['no_ipd'];?></td>
								</tr>
								<tr>
									<th>Umur</th>
									<td>:&nbsp;</td>
									<td><?php
										$interval = date_diff(date_create(), date_create($data_pasien[0]['tgl_lahir']));
										echo $interval->format("%Y Tahun, %M Bulan, %d Hari");
									?>
									</td>
								</tr>
								<tr>
									<th>Gol Darah</th>
									<td>:&nbsp;</td>
									<td><?php echo $data_pasien[0]['goldarah'];?></td>
								</tr>
								<tr>
									<th>Tanggal Kujungan</th>
									<td>:&nbsp;</td>
									<td><?php echo $data_pasien[0]['tgl_masuk']; ?></td>
									<!-- <td><?php echo date("j F Y", strtotime($data_pasien[0]['tgl_masuk'])); ?></td> -->
								</tr>
								<tr>
									<th>Kelas</th>
									<td>:&nbsp;</td>
									<td><?php echo $data_pasien[0]['kelas'];?></td>
								</tr>
								<tr>
									<th>Dokter PJP</th>
									<td>:&nbsp;</td>
									<td><input type="hidden" class="form-control input-sm" name="id_dokter" id="id_dokter" value="<?php if(isset($data_pasien[0]['id_dokter'])){echo $data_pasien[0]['id_dokter'];}?>">
									<input disabled="" type="text" class="form-control input-sm auto_no_register_dokter" name="nmdokter" id="nmdokter" value="<?php if(isset($data_pasien[0]['dokter'])){echo $data_pasien[0]['dokter'];}?>">
									</td>
								</tr>
								<tr>
									<th>Total Pembayaran</th>
									<td>:&nbsp;</td>
									<td>Rp. <?php echo number_format($grand_total,0);?></td>
								</tr>
								<tr>
									<th>Cara Bayar</th>
									<td>:&nbsp;</td>
									<td><?php echo $data_pasien[0]['carabayar'];?></td>
								</tr>
								<tr>
									<th></th>
									<td>&nbsp;</td>
									<!-- <td><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'];?>" target="_blank"> <input type="button" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak Detail Pembayaran"></a></td> -->
									<!-- <td><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien_simple/<?php echo $data_pasien[0]['no_ipd'];?>" target="_blank"> <input type="button" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak Detail Pembayaran"></a></td> -->
								</tr>
							  </tbody>
							</table>
							<!-- <br>
							<div class="form-inline" align="right">
								<div class="form-group">
									<a target="_blank" href="<?php echo site_url('iri/riclaporan/cetak_medrec/');?><?php echo '/'.$tgl_awal . '/' .$type ;?>"><input type="button" class="btn 
									btn-primary" value="Cetak Laporan PDF"></a>
									<a target="_blank" href="<?php echo site_url('iri/riclaporan/cetak_medrec/');?><?php echo '/'.$tgl_awal . '/' .$type;?>"><input type="button" class="btn 
									btn-primary" value="Cetak Laporan Excel"></a>
								</div>
							</div> -->
						</div>
					</div>
				</div>
			</div>			
		</div>	
	</div>
		
</section>

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
					<?php echo $this->session->flashdata('pesan');?>
					<!-- Tabs -->
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#mutasi" data-toggle="tab">Ruangan</a></li>
							<li class=""><a href="#tindakan" data-toggle="tab">Tindakan</a></li>
							<li class=""><a href="#ok_pasien" data-toggle="tab">Operasi</a></li>
							<li class=""><a href="#radiologi" data-toggle="tab">Radiologi</a></li>
							<li class=""><a href="#lab_pasien" data-toggle="tab">Lab</a></li>
							<li class=""><a href="#pa_pasien" data-toggle="tab">Patologi Anatomi</a></li>
							<li class=""><a href="#resep_pasien" data-toggle="tab">Resep</a></li>
							<li class=""><a href="#poli_irj" data-toggle="tab">Poli IRD/IRJ</a></li>
							
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
										foreach($list_mutasi_pasien as $r){ ?>
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
											if($r['tglkeluarrg'] != null){
												
												
										  		echo date('d F Y', strtotime($r['tglkeluarrg']));

												//echo date("j F Y", strtotime($r['tglkeluarrg'])) ;
											}else{
												if($data_pasien[0]['tgl_keluar'] != NULL){
													echo date("j F Y", strtotime($data_pasien[0]['tgl_keluar'])) ;
// 
											  		// echo date('d F Y', strtotime($r['tgl_keluar']));
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
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example11">
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
											<td width="15%"><?php echo date('d F Y', strtotime($row['tgl_operasi'])); ?></td>
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
											<td  width="10%"><?php echo 'Rp '.number_format( $row['vtot'], 2 , ',' , '.' ); ?></td>
											
										</tr>
										<?php $total_bayar = $total_bayar + $row['vtot'];?>
									<?php
										}
									}else{ ?>
									<tr>
											<td>Tidak Ada Operasi</td>
											<td width="15%">Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>											
											<td  width="10%">Tidak Ada Operasi</td>
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
											  <td colspan="6">Total Radiologi</td>
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
											  <td colspan="6">Total Tindakan IRJ</td>
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
	    $('#dataTables-example11').DataTable();
	    $('#dataTables-example10').DataTable();
	});
</script>

<?php $this->load->view("layout/footer"); ?>
