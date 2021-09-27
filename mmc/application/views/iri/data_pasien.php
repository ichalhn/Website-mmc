<script>
	$('#tgl_pulang').datepicker({
		format: 'yyyy-mm-dd'
	});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.meninggal').hide();
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
	$('#tgl_meninggal').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true,
		});
	  $("#jam_meninggal").timepicker({
		    showInputs: false,
		    showMeridian: false
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

function batal_pasien(no_ipd){
	var r = confirm("Anda yakin ingin membatalkan pasien ?");
	if (r == true) {
		window.location.href = '<?php echo base_url("iri/ricstatus/batalkan_pasien/")?>/'+no_ipd;
	   	// window.open('<?php echo base_url("iri/ricstatus/batalkan_pasien/")?>/'+no_ipd , "_self");
	   // alert('<?php echo base_url("iri/ricstatus/batalkan_pasien/")?>/'+no_ipd);
	} else {
	    return false;
	}
	
}

function pulang(val_plg){
	if(val_plg!=''){
		if(val_plg=="MENINGGAL"){
			$('.meninggal').show();
			document.getElementById("tgl_meninggal").required= true;
			document.getElementById("jam_meninggal").required= true;
			document.getElementById("kondisi_meninggal").required= true;
		}else{
			$('.meninggal').hide();
			document.getElementById("tgl_meninggal").required= false;
			document.getElementById("jam_meninggal").required= false;
			document.getElementById("kondisi_meninggal").required= false;
		}
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
							<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading" align="center">Data Pasien</div>
					<div class="panel-body"><br/>
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
						<div align="center"><a href="<?php echo base_url();?>iri/ricsjp/cetak_gelang/<?php echo $data_pasien[0]['no_ipd'] ;?>" target="_blank"><input type="button" class="btn btn-primary btn-sm" value="Cetak Gelang"></a></div>
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
								<th>Tanggal Kunjungan</th>
								<td>:&nbsp;</td>
								<td><?php echo date('d-m-Y', strtotime($data_pasien[0]['tgl_masuk'])); ?></td>
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
								<td><?php echo $data_pasien[0]['dokter'];?>
								</td>
							</tr>
							<tr>
								<th>Cara Bayar</th>
								<td>:&nbsp;</td>
								<td><?php echo $data_pasien[0]['carabayar'];?> <a href="<?php echo base_url() ;?>iri/ricpasien/ubah_cara_bayar/<?php echo $data_pasien[0]['no_ipd'] ;?>"><input type="button" class="btn btn-primary btn-sm" value="Ubah"></a></td>
							</tr>
							<tr>
								<th></th>
								<td> &nbsp;</td>
								<td><?php echo $data_pasien[0]['nmkontraktor'];?></td>
							</tr>
							<tr>
								<th></th>
								<td>&nbsp;</td>
								<td><input type="button" onclick="return batal_pasien('<?php echo $data_pasien[0]['no_ipd'] ;?>');" class="btn btn-primary btn-sm" value="Batalkan Pasien">
							</tr>
							<tr>
								<th></th>
								<td>&nbsp;</td>
								<td><br><a href="<?php echo base_url();?>iri/rictindakan/list_dokter/<?php echo $data_pasien[0]['no_ipd'];?>"><input type="button" class="btn btn-primary btn-sm" value="Dokter Pasien"></a></td>
								<!-- <td><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'];?>" target="_blank"> <input type="button" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak Detail Pembayaran"></a></td> -->
								<!-- <td><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien_simple/<?php echo $data_pasien[0]['no_ipd'];?>" target="_blank"> <input type="button" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak Detail Pembayaran"></a></td> -->
							</tr>
							<tr>
								<th></th>
								<td>&nbsp;</td>
								<td><br><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'].'/0';?>" target="_blank"><input type="button" class="btn btn-primary btn-sm" value="Lihat Kwitansi Sementara"></a></td>
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
					<br/>
			</div>
			</div>
			</div>
						<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading" align="center">Pemeriksaan Lanjutan</div>
					<div class="panel-body">
					<br/>
						<form action="<?php echo site_url('iri/rictindakan/update_tindakan_lain'); ?>" method="post">
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" id="ket_pulang">Status Pulang</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<select class="form-control" name="ket_pulang" onchange="pulang(this.value)">
													<option value="">-Pilih Ket Pulang-</option>
													<option value="PULANG">PULANG</option>
													<option value="PULANG PAKSA">PULANG PAKSA</option>
													<option value="MENINGGAL">MENINGGAL</option>
													<option value="MELARIKAN DIRI">MELARIKAN DIRI</option>
													<option value="DIRUJUK RS LAIN">DIRUJUK RS LAIN</option>
												</select>
											</div>
										</div>
									</div>
							</div>
							<div class="form-group row meninggal">
								<div class="col-sm-4 control-label">Tgl. Meninggal</div>
									<div class="col-sm-8">
										<div class='input-group date' id='jadwal_operasi'>
													<input type="text" id="tgl_meninggal" class="form-control" placeholder="Tanggal Meninggal" name="tgl_meninggal">
													
												</div>
								                <div class='input-group bootstrap-timepicker' >
													<input type="text" id="jam_meninggal" class="form-control" placeholder="Jam Meninggal" name="jam_meninggal">													
												</div>

									</div>
							</div>
							<div class="form-group row meninggal">
								<p class="col-sm-4 form-control-label">Waktu Meninggal</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<select class="form-control" name="kondisi_meninggal" id="kondisi_meninggal">
													<option value="">-Pilih Waktu-</option>
													<option value="KURANG 48 JAM">Kurang dari 48 Jam</option>
													<option value="LEBIH 48 JAM">Lebih dari 48 Jam</option>
												</select>
											</div>
										</div>
									</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Diagnosa</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
											</div>
										</div>
									</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-12 form-control-label" id="ket_pulang"><input type="text" value="" class="form-control input-sm auto_diagnosa_pasien" name="diagnosa1" id="diagnosa1" /></p>
									
							</div>
							<div class="form-group row">
								<div class="col-sm-8">
									<!-- <input type="button" onclick="return update_status_pemeriksaan_ok('<?php echo $data_pasien[0]['no_ipd']; ?>');" class="btn btn-default btn-sm" value="Operasi">
									<input type="button" onclick="return update_status_pemeriksaan_rad('<?php echo $data_pasien[0]['no_ipd']; ?>');" class="btn btn-default btn-sm" value="Radiologi">
									<input type="button" onclick="return update_status_pemeriksaan_lab('<?php echo $data_pasien[0]['no_ipd']; ?>');" class="btn btn-default btn-sm" value="Laboratorium">
									<br><input type="button" onclick="return update_status_pemeriksaan_pa('<?php echo $data_pasien[0]['no_ipd']; ?>');" class="btn btn-default btn-sm" value="Patologi Anatomi">
									<input type="button" onclick="return update_status_resep('<?php echo $data_pasien[0]['no_ipd']; ?>');" class="btn btn-default btn-sm" value="Resep Obat"> -->
									<!-- <a href="<?php echo site_url('rad/radcdaftar/pemeriksaan_rad/'); ?><?php echo '/'.$data_pasien[0]['no_ipd'] ;?>" class="btn btn-primary btn-xs" onclick="return update_status_pemeriksaan_rad('<?php echo $data_pasien[0]['no_ipd']; ?>');">Radiologi</a>
									<a href="<?php echo site_url('lab/labcdaftar/pemeriksaan_lab/'); ?><?php echo '/'.$data_pasien[0]['no_ipd'] ;?>" class="btn btn-primary btn-xs" onclick="return update_status_pemeriksaan_lab('<?php echo $data_pasien[0]['no_ipd']; ?>');">Laboratorium</a>
									<a href="<?php echo site_url('farmasi/Frmcdaftar/permintaan_obat/'); ?><?php echo '/'.$data_pasien[0]['no_ipd'] ;?>" class="btn btn-primary btn-xs" onclick="return update_status_resep('<?php echo $data_pasien[0]['no_ipd']; ?>');">Resep Obat</a>
									 -->
									<!-- <label class="checkbox-inline">
										<input type="checkbox" id="lab" name="lab" value="1" <?php if($data_pasien[0]['lab'] == 1){echo "checked='true'" ; }?> > Laboratotium
									</label>
									<label class="checkbox-inline">
										<input type="checkbox" id="rad" name="rad" value="1" <?php if($data_pasien[0]['rad'] == 1){echo "checked='true'" ;}?>> Radiologi
									</label>
									<label class="checkbox-inline">
										<input type="checkbox" id="obat" name="obat" value="1" <?php if($data_pasien[0]['obat'] == 1){echo "checked='true'" ;}?>> Obat
									</label> -->
								</div>
							</div>
							
							<div class="form-inline" align="right">
								<input type="hidden" class="form-control" value="<?php echo $data_pasien[0]['no_ipd'];?>" name="no_ipd">
								<input type="hidden" class="form-control" value="" name="id_row_diagnosa" id="id_row_diagnosa">
								<div class="form-group">
									<button type="reset" class="btn btn-default btn-sm">Reset</button>
									<input type="submit" class="btn btn-primary btn-sm" id="btn_simpan" value="Simpan">
								</div>
							</div>
						</form>					</div>
				</div><div class="panel panel-danger">
		<div class="panel-body">
		<?php echo form_open('iri/rictindakan/rujukan_penunjang'); ?>
			<?php foreach($rujukan_penunjang as $row){
					$lab= $row->lab; $ok= $row->ok; $pa= $row->pa; $rad= $row->rad; $obat= $row->obat; ?>
						<div class="form-group row">
							<p class="col-sm-12 form-control-label" id="label_rujukan">Rujukan Penunjang</p>
							<div class="col-sm-12">
								<label class="checkbox-inline no_indent">
								<?php 
									if($row->status_ok>='1'){
										if($row->ok=='0'){
										echo '<input type="checkbox" id="okCheckbox"  class="flat-red" name="okCheckbox" value="1"> Operasi | '.$row->status_ok.' Done';
										} else {
											echo '<input type="checkbox" id="okCheckbox"  class="flat-red" name="okCheckbox" checked="checked" value="1" disabled> Operasi';
											echo ' | Progress';
										}
									}
									else { 
										if($row->ok=='0'){
										echo '<input type="checkbox" id="okCheckbox"  class="flat-red" name="okCheckbox" value="1"> Operasi';
										} else {
											echo '<input type="checkbox" id="okCheckbox"  class="flat-red" name="okCheckbox" checked="checked" value="1" disabled> Operasi';
											echo '';
										}
									}?>
								</label>

								<label class="checkbox-inline no_indent">
								<?php 
									if($row->status_lab>='1'){
										if($row->lab=='0'){
										echo '<input type="checkbox" id="labCheckbox"  class="flat-red" name="labCheckbox"  value="1"> Laboratorium | '.$row->status_lab.' Done';
										} else {
											echo '<input type="checkbox" id="labCheckbox"  class="flat-red" name="labCheckbox" checked="checked" value="1" disabled> Laboratorium';
											echo ' | <a href="'.base_url('lab/labcdaftar/pemeriksaan_lab').'/'.$data_pasien[0]['no_ipd'].'" target="_blank">Progress</a>';
										}
									}
									else { 
										if($row->lab=='0'){
										echo '<input type="checkbox" id="labCheckbox"  class="flat-red" name="labCheckbox"  value="1"> Laboratorium';
										} else {
											echo '<input type="checkbox" id="labCheckbox"  class="flat-red" name="labCheckbox" checked="checked" value="1" disabled> Laboratorium';
											echo ' | <a href="'.base_url('lab/labcdaftar/pemeriksaan_lab').'/'.$data_pasien[0]['no_ipd'].'" target="_blank">Progress</a>';
										}
									}?>
								</label>

								<label class="checkbox-inline no_indent">
								<?php if($row->status_pa>='1'){
										if($row->pa=='0'){
										echo '<input type="checkbox" id="paCheckbox"  class="flat-red" name="paCheckbox"  value="1"> Patologi Anatomi | '.$row->status_pa.' Done';
										} else {
											echo '<input type="checkbox" id="paCheckbox"  class="flat-red" name="paCheckbox" checked="checked" value="1" disabled> Patologi Anatomi';
											echo ' | <a href="'.base_url('pa/pacdaftar/pemeriksaan_pa').'/'.$data_pasien[0]['no_ipd'].'" target="_blank">Progress</a>';
										}
									}
									else { 
										if($row->pa=='0'){
										echo '<input type="checkbox" id="paCheckbox"  class="flat-red" name="paCheckbox"  value="1"> Patologi Anatomi';
										} else {
											echo '<input type="checkbox" id="paCheckbox"  class="flat-red" name="paCheckbox" checked="checked" value="1" disabled> Patologi Anatomi';
											echo ' | <a href="'.base_url('pa/pacdaftar/pemeriksaan_pa').'/'.$data_pasien[0]['no_ipd'].'" target="_blank">Progress</a>';
										}
									}?>
								</label>

								<label class="checkbox-inline no_indent">
								<?php 
									if($row->status_rad>='1'){
										if($row->rad=='0'){
										echo '<input type="checkbox" id="radCheckbox"  class="flat-red" name="radCheckbox"  value="1"> Radiologi | '.$row->status_rad.' Done';
										} else {
											echo '<input type="checkbox" id="radCheckbox"  class="flat-red" name="radCheckbox" checked="checked" value="1" disabled> Radiologi';
											echo ' | <a href="'.base_url('rad/radcdaftar/pemeriksaan_rad').'/'.$data_pasien[0]['no_ipd'].'" target="_blank">Progress</a>';
										}
									}
									else { 
										if($row->rad=='0'){
										echo '<input type="checkbox" id="radCheckbox"  class="flat-red" name="radCheckbox"  value="1"> Radiologi';
										} else {
											echo '<input type="checkbox" id="radCheckbox"  class="flat-red" name="radCheckbox" checked="checked" value="1" disabled> Radiologi';
											echo ' | <a href="'.base_url('rad/radcdaftar/pemeriksaan_rad').'/'.$data_pasien[0]['no_ipd'].'" target="_blank">Progress</a>';
										}
									}?>
								</label>

								<label class="checkbox-inline no_indent">
								<?php 
									if($row->status_obat>='1'){
										if($row->obat=='0'){
										echo '<input type="checkbox" id="obatCheckbox"  class="flat-red" name="obatCheckbox"  value="1"> Obat | '.$row->status_obat.' Done';
										} else {
											echo '<input type="checkbox" id="obatCheckbox"  class="flat-red" name="obatCheckbox" checked="checked" value="1" disabled> Obat';
											echo '';
										}
									}
									else { 
										if($row->obat=='0'){
										echo '<input type="checkbox" id="obatCheckbox"  class="flat-red" name="obatCheckbox"  value="1"> Obat';
										} else {
											echo '<input type="checkbox" id="obatCheckbox"  class="flat-red" name="obatCheckbox" checked="checked" value="1" disabled> Obat | <a href="'.base_url('farmasi/Frmcdaftar/permintaan_obat').'/'.$data_pasien[0]['no_ipd'].'" target="_blank">Progress</a>';
											echo ' ';
										}
									}?>
								</label>
							</div>

							<div class="col-xs-12" align="right">	
								<input type="hidden" class="form-control" value="<?php echo $data_pasien[0]['no_ipd'];?>" name="no_ipd"><br>
								<input type="hidden" class="form-control" value="<?php echo $linkheader;?>" name="linkheader"><br>
									<button type="submit" class="btn btn-primary btn-sm"> Simpan </button>
							</div>				
					</div>
					<?php } ?>
					<?php echo form_close();?>
				</div>
			</div>			
		</div>	
			</div>
		
	</section>