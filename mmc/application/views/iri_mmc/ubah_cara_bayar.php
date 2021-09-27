<?php $this->load->view("layout/header"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
<script>
$(function() {
	$('#carabayar').change();

});
function cek_kartu_bpjs(){
	$('#loading_bpjs').show();
	var no_bpjs = $('#no_bpjs').val();
	$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>iri/ricstatus/cek_kartu_bpjs/",
        data:   {
                    no_bpjs        : no_bpjs
                },
    }).done(function(msg) {
    	if(msg == ""){
    		document.getElementById("data_validasi").innerHTML = "Data Tidak Ditemukan";
    	}else{
    		document.getElementById("data_validasi").innerHTML = msg;
    	}
    	$('#modal_validasi').modal('show');
    	$('#loading_bpjs').hide();
    });
}

	$('#tgl_pulang').datepicker({
		format: 'yyyy-mm-dd'
	});

function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}

function stateChangedKontraktor(){
    var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("id_kontraktor").innerHTML = data;
		}
    }

    var kontraktor = "<?php echo $data_pasien[0]['id_kontraktor'];?>";
	if(kontraktor!=''){
		$('#id_kontraktor').val(kontraktor).change();
	}
}

function update_form_bpjs(cara_bayar){

	if(cara_bayar == "BPJS"){
		$('.form_bpjs').show();
		$('.form_perusahaan').hide();
		$('.form_perusahaan').hide();
		document.getElementById("id_kontraktor").required = true;

		ajaxku = buatajax();
	    var url="<?php echo site_url('irj/rjcregistrasi/data_kontraktor'); ?>";
	    url=url+"/"+cara_bayar;
	    url=url+"/"+Math.random();
	    ajaxku.onreadystatechange=stateChangedKontraktor;
	    ajaxku.open("GET",url,true);
	    ajaxku.send(null);
	}else if(cara_bayar == "DIJAMIN"){
		document.getElementById("id_kontraktor").required = true;

		$('.form_bpjs').hide();
		$('.form_perusahaan').show();
		ajaxku = buatajax();
	    var url="<?php echo site_url('irj/rjcregistrasi/data_kontraktor'); ?>";
	    url=url+"/"+cara_bayar;
	    url=url+"/"+Math.random();
	    ajaxku.onreadystatechange=stateChangedKontraktor;
	    ajaxku.open("GET",url,true);
	    ajaxku.send(null);
	}else{
		document.getElementById("id_kontraktor").required = false;

		$('.form_bpjs').hide();
		$('.form_perusahaan').hide();
	}
}

var site = "<?php echo site_url(); ?>";
$(function(){
	$('#loading_bpjs').hide();
	$('.js-example-basic-single').select2();

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
	    		alert("Request Pemeriksaan Radiologi Berhasil Dikirim. ");	
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
	    		alert("Request Pemeriksaan Laboratorium Berhasil Dikirim. ");
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

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_diagnosa_pasien').autocomplete({
		serviceUrl: site+'iri/ricstatus/data_icd_1',
		onSelect: function (suggestion) {
			//$('#no_cm').val(''+suggestion.no_cm);
			$('#diagnosa').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
			$('#diagnosa_id').val(''+suggestion.id_icd);
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

function ambil_sep(){
	$('#loading_bpjs').show();
	var no_bpjs = $('#no_bpjs').val();
	var nosjp = $('#nosjp').val();
	var diagnosa_id = $('#diagnosa_id').val();
	var no_cm_hidden = $('#no_cm_hidden').val();
	var noregasal_hidden = $('#noregasal_hidden').val();
	var ruang = $('#ruang').val();
	var ppk = $('#ppk').val();
	$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>iri/ricstatus/ambil_sep/",
        data:   {
                    no_bpjs        : no_bpjs,
                    noregasal_hidden        : noregasal_hidden,
                    ruang        : ruang,
                    nosjp        : nosjp,
                    diagnosa_id  : diagnosa_id,
                    no_cm        : no_cm_hidden,
                    ppk          : ppk
                },
    }).done(function(msg) {
    	obj = JSON.parse(msg);
    	if(obj.status == 0){
    		alert(obj.response);
    	}else{
    	  	$('#no_sep').val(obj.response);
			$('#no_sep_hidden').val(obj.response);
    	}
    	$('#loading_bpjs').hide();
    });
}
</script>
<section class="content-header">
		<div class="row">
			<div class="col-sm-6">
				<!-- Modal Validasi -->
						<div class="modal fade" id="modal_validasi" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						  <div class="modal-dialog modal-lg" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        <h4 class="modal-title" id="myModalLabel">Hasil Validasi</h4>
						      </div>
						      <div class="modal-body">
									<div id="data_validasi"></div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
						      </div>
						    </div>
						  </div>
						</div>	
						<!-- Modal -->

				<div class="panel panel-default">
					<div class="panel-heading" align="center">Data Pasien</div>
					<div class="panel-body"><br/>
				<div class="row">
					<div class="col-sm-3">
						<div align="center"><img height="100px" class="img-rounded" src="http://proj-devel.inti.co.id/hmis/upload/photo/unknown.png"></div>
					</div>
					<div class="col-sm-9">
					<form class="form-horizontal" action="<?php echo site_url('iri/ricpasien/update_cara_bayar'); ?>" method="post">
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
								<input type="hidden" name="no_cm_hidden" value="<?php echo $data_pasien[0]['no_cm']; ?>" id="no_cm_hidden">
							</tr>
							<tr>
								<th>No. Register</th>
								<td>:&nbsp;</td>
								<td><?php echo $data_pasien[0]['no_ipd'];?></td>
								<input type="hidden" name="noregasal_hidden" value="<?php echo $data_pasien[0]['no_ipd']; ?>" id="noregasal_hidden">
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
								<td><?php echo date("j F Y", strtotime($data_pasien[0]['tgl_masuk'])); ?></td>
							</tr>
							<tr>
								<th>Kelas</th>
								<td>:&nbsp;</td>
								<td><?php echo $data_pasien[0]['kelas'];?></td>
							</tr>
							<tr>
								<th>Total Pembayaran</th>
								<td>:&nbsp;</td>
								<td>Rp. <?php echo number_format($grand_total,0);?></td>
							</tr>
							<tr>
								<th>Cara Bayar</th>
								<td>:&nbsp;</td>
								<td>
								<select class="form-control input-sm" name="carabayar" id="carabayar" onchange="update_form_bpjs(this.value)">
									<?php
									foreach ($cara_bayar as $r) { 
										if($r['cara_bayar'] == $data_pasien[0]['carabayar']){ ?>
										<option value="<?php echo $r['cara_bayar'] ;?>" selected><?php echo $r['cara_bayar'] ;?></option>
										<?php
										}else{ ?>
										<option value="<?php echo $r['cara_bayar'] ;?>"><?php echo $r['cara_bayar'] ;?></option>
										<?php
										}
									?>
									<?php
									}
									?>
								</select>
							</tr>
							<tr>
								<th>Penjamin *)</th>
								<td>:&nbsp;</td>
								<td>
								<select id="id_kontraktor" class="form-control select2" style="width: 100%" name="id_kontraktor">
													<option value="">-Pilih Penjamin-</option>
													
												</select>
								</td>
							</tr>
							<tr>
								<th></th>
								<td>&nbsp;</td>
								<td>
								*) Untuk pasien BPJS dan Dijamin Perusahaan
								</td>
							</tr>
							<tr>
								<th>No.SJP / No.Surat</th>
								<td>:&nbsp;</td>
								<td>
								<input type="text" class="form-control input-sm" name="nosjp" value="<?php echo $data_pasien[0]['nosjp']; ?>" id="nosjp">
								</td>
							</tr>

							<tr>
								<th>Diagnosa Masuk</th>
								<td>:&nbsp;</td>
								<td>
								<input type="text" class="form-control input-sm auto_diagnosa_pasien" name="diagnosa" id="diagnosa" value="<?php echo $data_pasien[0]['diagmasuk'];?> - <?php echo $data_pasien[0]['nm_diagmasuk'];?>" ><div id="loading_diagnosa"></div>
								<input type="hidden" name="diagnosa_id" id="diagnosa_id" value="<?php echo $data_pasien[0]['diagmasuk'];?>" >
								</td>
							</tr>

							<tr>
								<th>Asal Rujukan</th>
								<td>:&nbsp;</td>
								<td>
								<select class="form-control js-example-basic-single" style="width:100%" name="ppk" id="ppk">
									<option value="">-Pilih Asal Rujukan-</option>
								<?php
								foreach ($ppk as $r) { 
									if($r['kd_ppk'] == $data_pasien[0]['kd_ppk']){ ?>
									<option value="<?php echo $r['kd_ppk'] ;?>" selected="true"><?php echo $r['nm_ppk'] ;?></option>
									<?php
									}else{ ?>	
									<option value="<?php echo $r['kd_ppk'] ;?>"><?php echo $r['nm_ppk'] ;?></option>
									<?php
									}
								?>
								<?php
								}
								?>
							</select>
								</td>
							</tr>

							<tr>
								<th>Ruang</th>
								<td>:&nbsp;</td>
								<td><input type="text" name="ruang" id="ruang" value="<?php echo $data_pasien[0]['idrg'].'-'.$data_pasien[0]['nmruang'].'-'.$data_pasien[0]['kelas'] ;?>" > </td>
							</tr>
							<tr>
								<th>No Kartu BPJS</th>
								<td>:&nbsp;</td>
								<td>
								<input type="text" class="form-control input-sm" name="no_bpjs" id="no_bpjs" value="<?php echo $data_pasien[0]['no_kartu']; ?>" >
								</td>
							</tr>
							<tr>
								<th></th>
								<td>&nbsp;</td>
								<td>
								<button type="button" class="btn btn-primary btn-sm" onclick="cek_kartu_bpjs()"><i class="fa fa-save"></i> Cek Kartu BPJS</button>
								<button type="button" class="btn btn-primary btn-sm" onclick="ambil_sep()"><i class="fa fa-save"></i> Ambil SEP</button>
								<div id="loading_bpjs">Loading...</div>
								</td>
							</tr>

							<tr>
								<th>No SEP</th>
								<td>:&nbsp;</td>
								<td><input type="text" class="form-control input-sm" name="no_sep" id="no_sep" disabled="true" value="<?php echo $data_pasien[0]['no_sep']?>">
									<input type="hidden" id="no_sep_hidden" name="no_sep_hidden" value="<?php echo $data_pasien[0]['no_sep']?>"></td>
							</tr>
							<tr>
								<th></th>
								<td>&nbsp;</td>
								<td>
								<button type="submit" class="btn btn-primary btn-sm" ><i class="fa fa-save"></i> UPDATE</button>
							</tr>
							<!-- <tr>
								<th></th>
								<td>&nbsp;</td>
								<td><a href="<?php echo base_url();?>iri/ricstatus/batalkan_pasien/<?php echo $data_pasien[0]['no_ipd'] ;?>"><input type="button" class="btn btn-primary btn-sm" value="Batalkan Pasien"></a></td>
							</tr> -->
							<tr>
								<th></th>
								<td>&nbsp;</td>
								<!-- <td><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'];?>" target="_blank"> <input type="button" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak Detail Pembayaran"></a></td> -->
								<!-- <td><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien_simple/<?php echo $data_pasien[0]['no_ipd'];?>" target="_blank"> <input type="button" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak Detail Pembayaran"></a></td> -->
							</tr>
						  </tbody>
						</table>
						</form>
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
		</div>
	</section>
<?php $this->load->view("layout/footer"); ?>