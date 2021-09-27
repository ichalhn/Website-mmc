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
								<td><?php echo $data_pasien[0]['carabayar'];?> </td>
							</tr>
							<tr>
								<th></th>
								<td> &nbsp;</td>
								<td><?php echo $data_pasien[0]['nmkontraktor'];?></td>
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
	</section>