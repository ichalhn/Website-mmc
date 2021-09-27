<?php
	$this->load->view('layout/header.php');
?>
<html>

	<?php 
	include('script_rjvpelayanan.php');	
	
	?>

<?php
	//$this->load->view('layout/header.php');
?>
<script>
$(function() {
	$('.auto_search_poli').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_poli',
		onSelect: function (suggestion) {
			$('#id_poli').val(''+suggestion.id_poli);
			$('#kd_ruang').val(''+suggestion.kd_ruang);
		}
	});
	$('#dirujuk_rj_ke_poli').hide();
	$('#pilih_dokter').hide();
	$('#div_tgl_kontrol').hide();
	$('#date_picker').datepicker({
		format: "yyyy-mm-dd",
		//endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});

	var lab="<?php echo $rujukan_penunjang->lab;?>";
	var pa="<?php echo $rujukan_penunjang->pa;?>";
	var rad="<?php echo $rujukan_penunjang->rad;?>";
	var obat="<?php echo $rujukan_penunjang->obat;?>";
	
	if(lab=='1' && pa=='1' && rad=='1' && obat=='1'){
		 document.getElementById("button_simpan_rujukan").disabled= true;
	}
	
});		
function pilih_ket_pulang(ket_plg){
	if(ket_plg=='PULANG'){
		$('#div_tgl_kontrol').show();
		$('#dirujuk_rj_ke_poli').hide();
		$('#pilih_dokter').hide();
		document.getElementById("btn_simpan").value = 'Simpan';
	} else {
		$('#div_tgl_kontrol').hide();
		if(ket_plg=='DIRUJUK_RAWATJALAN'){
			$('#dirujuk_rj_ke_poli').show();
			$('#pilih_dokter').show();
			//document.getElementById("btn_simpan").value = 'Cetak Karcis';
			document.getElementById("id_poli_rujuk").required = true;
			document.getElementById("id_dokter_rujuk").required = true;
			$('#div_tgl_kontrol').hide();
		}else{
			$('#dirujuk_rj_ke_poli').hide();
			$('#pilih_dokter').hide();
			document.getElementById("id_poli_rujuk").required = false;
			document.getElementById("id_dokter_rujuk").required = false;
			//document.getElementById("btn_simpan").value = 'Simpan';
		}
	}
}
function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}
function ajaxdokter(id_poli){
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi/data_dokter_poli'); ?>";
    url=url+"/"+id_poli;
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedDokter;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	
}
var ajaxku;
function stateChangedDokter(){
    var data;
	//alert(ajaxku.responseText);
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("id_dokter_rujuk").innerHTML = data;
		}
    }
	
}
</script>
<section class="content-header">
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading" align="center">Data Pasien</div>
					<div class="panel-body"><br/>
						<div class="form-inline">
							<div class="row">
						
								<div class="col-sm-4"><img height="100px" class="img-rounded" src="<?php 
									if($data_pasien_daftar_ulang->foto==''){
										echo site_url("upload/photo/unknown.png");
									}else{
										echo site_url("upload/photo/".$data_pasien_daftar_ulang->foto);
									}
									?>">
								</div>
								<table class="table-sm table-striped" style="font-size:15">
								  <tbody>
									<tr>
										<th>Nama</th>
										<td>:&nbsp;</td>
										<td><?php echo strtoupper($data_pasien_daftar_ulang->nama);?></td>
									</tr>
									<tr>
										<th>No. CM</th>
										<td>:&nbsp;</td>
										<td><?php echo $data_pasien_daftar_ulang->no_cm;?></td>
									</tr>
									<tr>
										<th>No. Register</th>
										<td>:&nbsp;</td>
										<td><?php echo $data_pasien_daftar_ulang->no_register;?></td>
									</tr>
									<tr>
										<th>Umur</th>
										<td>:&nbsp;</td>
										<td><?php echo $data_pasien_daftar_ulang->umurrj.' Tahun '.$data_pasien_daftar_ulang->ublnrj.' Bulan '.$data_pasien_daftar_ulang->uharirj.' Hari';?></td>
									</tr>
									<tr>
										<th>Gol Darah</th>
										<td>:&nbsp;</td>
										<td><?php echo $data_pasien_daftar_ulang->goldarah;?></td>
									</tr>
									<tr>
										<th>Tanggal Kunjungan</th>
										<td>:&nbsp;</td>
										<td><?php echo date('d-m-Y | H:i',strtotime($data_pasien_daftar_ulang->tgl_kunjungan));?></td>
									</tr>
									<tr>
										<th>Kelas</th>
										<td>:&nbsp;</td>
										<td><?php echo $kelas_pasien;?></td>
									</tr>
									<tr>
										<th>Cara Bayar</th>
										<td>:&nbsp;</td>
										<td><?php echo $data_pasien_daftar_ulang->cara_bayar;?></td>
									</tr>
								  </tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>			
		</div>	
</section>

	<section class="content-header">
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading" align="center">
							<ul class="nav nav-pills nav-justified">
								<li role="presentation" class="<?php echo $tab_fisik; ?>"><a data-toggle="tab" href="#tabfisik">Pemeriksaan Fisik</a></li>
								<li role="presentation" class="<?php echo $tab_tindakan; ?>"><a data-toggle="tab" href="#tabtindakan">Tindakan</a></li>
								<li role="presentation" class="<?php echo $tab_diagnosa; ?>"><a data-toggle="tab" href="#tabdiagnosa">Diagnosa</a></li>
								<li role="presentation" class="<?php //echo $tab_lab; ?>"><a data-toggle="tab" href="#tablab">Laboratorium</a></li>
								<li role="presentation" class="<?php //echo $tab_pa; ?>"><a data-toggle="tab" href="#tabpa">Patologi Anatomi</a></li>
								<li role="presentation" class="<?php //echo $tab_rad; ?>"><a data-toggle="tab" href="#tabrad">Radiologi</a></li>
								<li role="presentation" class="<?php //echo $tab_resep; ?>"><a data-toggle="tab" href="#tabresep">Resep</a></li>								
								<!--<li role="presentation" class="active"><a href="<?php //echo site_url('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register);?>">Tindakan</a></li>-->
							</ul>
						</div>
						
						<!--<div class="panel-body" style="display:block;overflow:auto;">
						<br/>-->
						<div class="tab-content">
							
							<div id="tabfisik" class="tab-pane fade in <?php echo $tab_fisik; ?>">	    						
								<?php include('rjvformfisik_view.php');  ?>
							</div> <!-- end div tab fisik -->
							
							<div id="tabtindakan" class="tab-pane fade in <?php echo $tab_tindakan; ?>">	    						
								<?php include('rjvformtindakan_view.php');  ?>
							</div> <!-- end div tab tindakan -->
							
							<div id="tabdiagnosa" class="tab-pane fade in <?php echo $tab_diagnosa; ?>">	    						
								<?php include('rjvformdiagnosa_view.php');  ?>
							</div> <!-- end div tab diagnosa -->

							<div id="tablab" class="tab-pane fade in <?php echo $tab_lab; ?>">	    								
								<?php include('form_lab.php');  ?>
							</div> <!-- end div tab lab -->

							<div id="tabpa" class="tab-pane fade in <?php echo $tab_pa; ?>">	    								
								<?php include('form_pa.php');  ?>
							</div> <!-- end div tab lab -->
							
							<div id="tabrad" class="tab-pane fade in <?php echo $tab_rad; ?>">	    								
								<?php include('form_rad.php');  ?>
							</div> <!-- end div tab lab -->
	
							<div id="tabresep" class="tab-pane fade in <?php echo $tab_resep; ?>">	    								
								<?php include('form_resep.php');  ?>
								<!--<?php echo form_open('irj/Rjcpelayanan/selesai_daftar_resep');?>
										<div class="form-inline" style="margin:15px;" align="right">
											<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
											<input type="hidden" class="form-control" value="<?php echo $no_resep;?>" name="no_resep">
											<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
											<div class="form-group">
												<!--<a href="<?php //echo site_url('irj/Rjcpelayanan/selesai_daftar_resep/'.$id_poli.'/'. $no_register); ?>" class="btn btn-primary btn-xl" id="button_selesai_obat">Selesai & Cetak</a>
											<button id="button_selesai_obat" class="btn btn-primary" id="button_selesai_obat">Selesai & Cetak</button>
											</div>
										</div>
										<?php echo form_close(); ?>-->
							</div> <!-- end div tab resep -->
						</div>
					</div>
				</div>
			</div>
		</section>
	<!-- Modal -->
<div class="modal fade" id="form-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Data</h4>
      </div>
	  
        <?php echo form_open('irj/rjcpelayanan/update_tindakan');?>
      <div class="modal-body">
		  <div style="display:block;overflow:auto;">
								<div class="form-group row">
								<p class="col-sm-2 form-control-label" id="tindakan">Tindakan</p>
										<div class="col-sm-8">
											<div class="form-inline">
												<input type="search" style="width:450px" class="auto_search_tindakan2 form-control" placeholder="" id="nmtindakan2" name="nmtindakan2" required>
												<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan2"  name="idtindakan2">
											</div>
										</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="operator">Pelaksana</p>
										<div class="col-sm-8">
											<div class="form-inline">
												<input type="search" style="width:450px" class="auto_search_operator2 form-control" placeholder="" id="nm_dokter2" name="nm_dokter2" required>
												<input type="text" class="form-control" placeholder="ID Dokter" id="id_dokter2" readonly name="id_dokter2" >
											</div>
										</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Biaya Poli</p>
									<div class="col-sm-8">
										<input type="number" min=0 class="form-control" value="" name="biaya_poli2" id="biaya_poli2">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qtyind">Qtyind</p>
									<div class="col-sm-8">
										<input type="number" class="form-control" value="1" name="qtyind2" id="qtyind2">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_dijamin">Dijamin</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="" name="dijamin2" id="dijamin2">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_vtot">Total</p>
									<div class="col-sm-8">
										<input type="number" min=0 class="form-control" value="" name="vtot2" id="vtot2">
									</div>
								</div>
		  </div>
      </div>
      <div class="modal-footer">
		<input type="hidden" class="form-control" value="" name="id_pelayanan_poli2" id="id_pelayanan_poli2">
		<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
		<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="reset" class="btn btn-default">Reset</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </div>
        <?php echo form_close();?>
  </div>
</div>
<!-- Modal -->

<?php
	$this->load->view('layout/footer.php');
?>
