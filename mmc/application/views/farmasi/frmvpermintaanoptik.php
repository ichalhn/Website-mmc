<?php
	$this->load->view('layout/header.php');
?>
<html>

<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2();
  $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green'
    });
});
</script>
<script type='text/javascript'>

//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#tabel_tindakan').DataTable();
	$('#tabel_diagnosa').DataTable();
} );
//---------------------------------------------------------

var site = "<?php echo site_url();?>";
		
function pilih_tindakan(id_resep) {
	if(id_resep!=''){
		$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('farmasi/Frmcdaftar/get_biaya_tindakan')?>",
			data: {
				id_resep: id_resep
			},
			success: function(data){
				//alert(data);
				$('#biaya_obat').val(data);
				$('#biaya_obat_hide').val(data);
				$('#qty').val('1');
				set_total() ;
			},
			error: function(){
				alert("error");
			}
    	});
	}
}

function pilih_kebijakan(kodemarkup) {
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('farmasi/Frmcdaftar/get_biaya_kebijakan')?>",
		data: {
			kodemarkup: kodemarkup
		},
		success: function(data){
			//alert(data);
			$('#fmarkup').val(data);
			set_total() ;
		},
		error: function(){
			alert("error");
		}
    });
}

function set_total() {
	var fmarkup = $("#fmarkup").val() ;
	var tuslah_non = $("#tuslah_non").val();
	var cara_bayar = "<?php echo $cara_bayar; ?>";
	var ppn = $("#ppn").val() ;
	var checked= $("#tuslah_cek").prop('checked');
	//alert ("tes"+ checked);
	if(cara_bayar=="BPJS"){
		var total = ($("#biaya_obat").val() * $("#qty").val()) ;
	}else{
		if (checked == true){
			//alert ("tes"+ checked);
			var total = ($("#biaya_obat").val() * $("#qty").val() * fmarkup * ppn + parseInt(tuslah_non)) ;	
		} else {
			var total = ($("#biaya_obat").val() * $("#qty").val() * fmarkup * ppn) ;	
		}
	    
	}

	$('#vtot').val(total);
	$('#vtot_hide').val(total);
}

function set_total_racikan() {
	var total = $("#biaya_racikan").val() * $("#qty_racikan").val() ;	
	$('#vtot_racikan').val(total);
	$('#vtot_racikan_hide').val(total);
}

function set_hasil_calculator() {
	var total = ($("#diminta").val() * $("#dibutuhkan").val()) / $("#dosis").val() ;	
	total = Math.round(total);
	$('#hasil_calculator').val(total);
	$('#hasil_calculator_hide').val(total);
	$("#qty_racikan").val(total) ;
	$("#qty_racikan_hidden").val(total) ;
	var total2 = $("#biaya_racikan").val() * total;	
	$('#vtot_racikan').val(total2);
	$('#vtot_racikan_hide').val(total2);
}

function edit_obat(id_resep_pasien) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('farmasi/Frmcdaftar/get_data_edit_obat')?>",
      data: {
        id_resep_pasien: id_resep_pasien
      },
      success: function(data){
      	$('#edit_no_register').val(data[0].no_register);
        $('#edit_id_obat').val(data[0].item_obat);
        $('#edit_id_obat_hidden').val(data[0].item_obat);
        $('#edit_nama_obat').val(data[0].nama_obat);
        $('#edit_biaya_obat').val(data[0].biaya_obat);
        $('#edit_qty').val(data[0].qty);
        $('#edit_signa').val(data[0].Signa);
      },
      error: function(){
        alert("error");
      }
    });
  }

function set_hasil_obat() {
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('farmasi/Frmcdaftar/get_biaya_resep')?>",
		data: {
			no_register: "<?php echo $no_register ?>"
		},
		success: function(data){
			var fmarkup = $("#fmarkup").val() ;
			var tuslah_racik = $("#tuslah_racik").val();
			var ppn = $("#ppn").val() ;
			var cara_bayar = "<?php echo $cara_bayar; ?>";
			//alert(data);	
			if(cara_bayar=='BPJS'){
				var total = data ;

			} else {
				var total = (data * fmarkup * ppn + parseInt(tuslah_racik)) ;
			}
			$('#vtot_x').val(total);
			$('#vtot_x_hide').val(total);
		},
		error: function(){
			alert("error");
		}
    });
}

function insert_total(){
	var jumlah = $('#jumlah').val();

	// bawah
	//qty di set 1 karena hasil dari perhitungan sendiri


	var val = $('select[name=idtindakan]').val();
	var temp = val.split("-");
	var cara_bayar = "$data_pasien[0]['carabayar']";

	$('#biaya_obat').val(jumlah);
	$('#biaya_obat_hide').val(jumlah);
	var qty = 1;
	$('#qtyind').val(1)
	var total = qty * jumlah;
	$('#vtot').val(total);

	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('farmasi/Frmcdaftar/get_biaya_resep')?>",
		data: {
			no_resep: "<?php echo $no_resep ?>",
			qty : qty
		},
		success: function(data){
			//alert(data);	
			$('#vtot_x').val(data);
			$('#vtot_x_hide').val(data);
		},
		error: function(){
			alert("error");
		}
    });
}

	function closepage() {
		window.open('', '_self', ''); window.close();
	}

</script>
	<?php
		echo $alert;
	?>	
	<?php include('frmvdatapasien.php');?>


<section class="content" style="width:97%;margin:0 auto">
					
								

 <div class="row">
  
  <ul class="nav nav-tabs my-tab nav-justified">
   <li class="<?php echo $tab_obat; ?>" role="presentation"><a data-toggle="tab" href="#obat" ><h4>Pemeriksaan  Mata</h4></a></li>
   <li class="<?php echo $tab_racik; ?>" role="presentation"><a data-toggle="tab" href="#racikan" ><h4>Kacamata</h4></a></li>
 
  </ul>
  <div class="tab-content">
   <div id="obat" class="tab-pane fade in <?php echo $tab_obat; ?>"> 
    
    <div class="panel panel-info">
     <div class="panel-body">
     <br>
     <?php echo form_open('farmasi/Frmcdaftar/insert_resep_optik'); ?>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label " id="lensa">Lensa</p>
										<div class="col-sm-10">
											<div class="form-inline">
												<div class="form-group">
													<select id="idlensa" class="form-control js-example-basic-single" name="idlensa" style="width:350px;" required>
														<option value="">-Pilih Jenis Lensa-</option>
														<?php 
														if ($jenis =='' or $jenis == null){?>
															<option value="BIPOCAL">BIPOCAL</option>
															<option value="MONOPOCAL">MONOPOCAL</option>
														<?php }
														else if($jenis == "BIPOCAL"){ ?>
															<option value="BIPOCAL" selected>BIPOCAL</option>
															<option value="MONOPOCAL">MONOPOCAL</option>
														<?php }else if($jenis == "MONOPOCAL"){?>
															<option value="BIPOCAL" >BIPOCAL</option>
															<option value="MONOPOCAL" selected>MONOPOCAL</option>
														<?php }?>														
													</select>
												</div>
											</div>
										</div>
								</div>
								
									<div class="form-group row">
											<h5 class="col-sm-2 form-control-label"><b>Left</b></h5><br><hr>
											<p class="col-sm-2 form-control-label">Sph</p>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="ldistsph" id="ldistsph" placeholder="Distance" value="<?php 
														if ($ldistsph == null){
															echo '';
														} else {
															echo $ldistsph;
														}?>">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="lreadsph" id="lreadsph" placeholder="Reading" value="<?php 
														if ($lreadsph == null){
															echo '';
														} else {
															echo $lreadsph;
														}?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<p class="col-sm-2 form-control-label">Cyl</p>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="ldistcyl" id="ldistcyl" placeholder="Distance" value="<?php 
														if ($ldistcyl == null){
															echo '';
														} else {
															echo $ldistcyl;
														}?>">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="lreadcyl" id="lreadcyl" placeholder="Reading" value="<?php 
														if ($lreadcyl == null){
															echo '';
														} else {
															echo $lreadcyl;
														}?>">
												</div>
											</div>
										</div>	
										<div class="form-group row">
											<p class="col-sm-2 form-control-label">Axis</p>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="ldistaxis" id="ldistaxis" placeholder="Distance" value="<?php 
														if ($ldistaxis == null){
															echo '';
														} else {
															echo $ldistaxis;
														}?>">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="lreadaxis" id="lreadaxis" placeholder="Reading" value="<?php 
														if ($lreadaxis == null){
															echo '';
														} else {
															echo $lreadaxis;
														}?>">
												</div>
											</div>
										</div>				
										<div class="form-group row">
											<p class="col-sm-2 form-control-label">/Base</p>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="ldistbase" id="ldistbase" placeholder="Distance" value="<?php 
														if ($ldistbase == null){
															echo '';
														} else {
															echo $ldistbase;
														}?>">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="lreadbase" id="lreadbase" placeholder="Reading" value="<?php 
														if ($lreadbase == null){
															echo '';
														} else {
															echo $lreadbase;
														}?>">
												</div>
											</div>
										</div>			
										
										<div class="form-group row">
											<h5 class="col-sm-2 form-control-label"><b>Right</b></h5><br><hr>
											<p class="col-sm-2 form-control-label">Sph </p>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="rdistsph" id="rdistsph" placeholder="Distance" value="<?php 
														if ($rdistsph == null){
															echo '';
														} else {
															echo $rdistsph;
														}?>">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="rreadsph" id="rreadsph" placeholder="Reading" value="<?php 
														if ($rreadsph == null){
															echo '';
														} else {
															echo $rreadsph;
														}?>">
												</div>
											</div>
										</div>	
										<div class="form-group row">
											<p class="col-sm-2 form-control-label">Cyl </p>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="rdistcyl" id="rdistcyl" placeholder="Distance" value="<?php 
														if ($rdistcyl == null){
															echo '';
														} else {
															echo $rdistcyl;
														}?>">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="rreadcyl" id="rreadcyl" placeholder="Reading" value="<?php 
														if ($rreadcyl == null){
															echo '';
														} else {
															echo $rreadcyl;
														}?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<p class="col-sm-2 form-control-label">Axis </p>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="rdistaxis" id="rdistaxis" placeholder="Distance" value="<?php 
														if ($rdistaxis == null){
															echo '';
														} else {
															echo $rdistaxis;
														}?>">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="rreadaxis" id="rreadaxis" placeholder="Reading" value="<?php 
														if ($rreadaxis == null){
															echo '';
														} else {
															echo $rreadaxis;
														}?>">
												</div>
											</div>
										</div>
										<div class="form-group row">
											<p class="col-sm-2 form-control-label">/Base </p>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="rdistbase" id="rdistbase" placeholder="Distance" value="<?php 
														if ($rdistbase == null){
															echo '';
														} else {
															echo $rdistbase;
														}?>">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="rreadbase" id="rreadbase" placeholder="Reading" value="<?php 
														if ($rreadbase == null){
															echo '';
														} else {
															echo $rreadbase;
														}?>">
												</div>
											</div>
										</div>	
										<div class="form-group row">
											<p class="col-sm-2 form-control-label">P.D </p>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="distpd" id="distpd" placeholder="Distance" value="<?php 
														if ($distpd == null){
															echo '';
														} else {
															echo $distpd;
														}?>">
												</div>
											</div>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="text" class="form-control" name="readpd" id="readpd" placeholder="Reading" value="<?php 
														if ($readpd == null){
															echo '';
														} else {
															echo $readpd;
														}?>">
												</div>
											</div>
										</div>								
																		
									
								<!--<div class="form-group row">
									<p class="col-sm-2 form-control-label " id="markup">Kebijakan Obat</p>
										<div class="col-sm-10">
											<div class="form-inline">
												<!--
												<input type="search" style="width:100%" class="auto_search_tindakan form-control" placeholder="" id="nmtindakan" name="nmtindakan" required>
												<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan"  name="idtindakan">
												-->
												<!--<div class="form-group">
													<select id="idmarkup" class="form-control" name="idmarkup" onchange="pilih_kebijakan(this.value)" required>
														<option value="">-Pilih Kebijakan-</option>
														<?php 
															foreach($get_data_markup as $row){
																echo '<option value="'.$row->kodemarkup.'">'.$row->ket_markup.'</option>';
															}
														?>
													</select>
												</div>
											</div>
										</div>
								</div>-->																
								
								<div class="form-inline" align="right">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
									<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
									<input type="hidden" class="form-control" value="<?php //echo $no_cm;?>" name="no_cm">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
									

									<?php
										if($no_resep!=''){
												echo "<input type='hidden' class='form-control' value=".$no_resep." name='no_resep'>";
										} else {
											
										}
									?>
									<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kun">
									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
									<!--<input type="hidden" class="form-control" value="<?php echo $no_resep;?>" name="no_resep">-->

									<div class="form-group">
										<button type="reset" class="btn bg-orange">Reset</button>
										<button type="submit" class="btn btn-primary">Simpan</button>
									</div>
								</div>
							<?php echo form_close();?>
     </div><!-- end panel body -->
    </div><!-- end panel info-->
   </div><!-- end div id home -->

   <div id="racikan" class="tab-pane fade in <?php echo $tab_racik; ?>"> 
    
    <div class="panel panel-info">
     <div class="panel-body">
     	<br>
      	<?php echo form_open('farmasi/Frmcdaftar/insert_permintaan'); ?>								
								<div class="form-group row">
									<p class="col-sm-2 form-control-label " id="tindakan">Item</p>
										<div class="col-sm-10">
											<div class="form-inline">
												<div class="form-group">
													<select id="idtindakan" class="form-control js-example-basic-single" name="idtindakan" onchange="pilih_tindakan(this.value)" style="width:350px;" required>
														<option value="">-Pilih Obat-</option>
														<?php 
															foreach($data_obat as $row){
																echo '<option value="'.$row->id_obat.'">'.$row->nm_obat.'</option>';
															}
														?>
													</select>
												</div>
											</div>
										</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga</p>
									<div class="col-sm-2">
										<input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>" name="biaya_obat" id="biaya_obat" disabled>
										<input type="hidden" class="form-control" value="" name="biaya_obat_hide" id="biaya_obat_hide">
									</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qtyind">Quantity</p>
									<div class="col-sm-2">
										<input type="number" class="form-control" name="qty" id="qty" min=1 onchange="set_total(this.value)">
									</div>
								</div>
								
										<input type="hidden" class="form-control" name="fmarkup" id="fmarkup" value="<?php echo $fmarkup ?>">
										<input type="hidden" class="form-control" name="tuslah_non" id="tuslah_non" value="<?php echo $tuslah_non ?>">
								
										<input type="hidden" class="form-control" name="ppn" id="ppn" value="<?php echo $ppn ?>" >							
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_vtot">Total</p>
									<div class="col-sm-2">
										<input type="text" class="form-control" name="vtot" id="vtot" disabled>
										<input type="hidden" class="form-control" value="" name="vtot_hide" id="vtot_hide">
									</div>
										<input type="checkbox" value="" width=30px height=30px name="tuslah_cek" id="tuslah_cek" onchange="set_total()" >
									<div><p><b>Tuslah</b></p></div>
								</div>								
								<div class="form-inline" align="right">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
									<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
									<input type="hidden" class="form-control" value="<?php //echo $no_cm;?>" name="no_cm">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
									

									<?php
										if($no_resep!=''){
												echo "<input type='hidden' class='form-control' value=".$no_resep." name='no_resep'>";
										} else {
											
										}
									?>
									<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kun">
									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
									<!--<input type="hidden" class="form-control" value="<?php echo $no_resep;?>" name="no_resep">-->

									<div class="form-group">
										<button type="reset" class="btn bg-orange">Reset</button>
										<button type="submit" class="btn btn-primary">Simpan</button>
									</div>
								</div>
							<?php echo form_close();?>  
     

  <br><br>    			
						



	</div>
   </div>
  </div>
 </div>
 </section>


		<section class="content-header">
		
		<!-- table -->
									<div style="display:block;overflow:auto;">
										<table id="tabel_tindakan" class="display" cellspacing="0" width="100%">
											<thead>
												<tr>
								  <th>No</th>
								  <th>Tanggal Permintaan</th>
								  <th>Item</th>
								  <th>Harga</th>
								  <th>Qty</th>
								  <th>Total</th>
								  <th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php
													// print_r($pasien_daftar);
													$i=1;
														foreach($data_tindakan_pasien as $row){
														//$id_pelayanan_poli=$row->id_pelayanan_poli;
														
													?>
														<tr>
															<td><?php echo $i++ ; ?></td>
															<td><?php echo $row->tgl_kunjungan; ?></td>
															<td><?php echo $row->nama_obat ; ?></td>
															<td><?php echo $row->biaya_obat; ?></td>
															<td><?php echo $row->qty ; ?></td>
															<td><?php echo $row->vtot ; ?></td>
															<td><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_obat('<?php echo $row->id_resep_pasien;?>')">Edit</button><a href="<?php echo site_url("farmasi/Frmcdaftar/hapus_data_pemeriksaan/".$row->no_register."/".$row->id_resep_pasien);?>" class="btn btn-danger btn-xs">Hapus</a></td>
														</tr>
													<?php
														}
													?>
											</tbody>
										</table>
									
									</div><!-- style overflow -->

									<br>
								<?php
							echo form_open('farmasi/frmcdaftar/selesai_daftar_pemeriksaan');?>
								
								<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
								<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
								<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
								<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
								<input type="hidden" class="form-control" value="optik" name="type">
								<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
								<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
								<div class="form-group row">
									
								</div>		
						
						<div class="form-inline" align="right">
							<?php if($roleid==12 or $roleid==1){
								echo '
									<button class="btn btn-primary">Akhiri & Cetak Faktur</button>
			                	';
							} 
							if($roleid<>12 or $roleid==1){
								echo '
									<button type="button" onclick="closepage()" class="btn btn-primary">Selesai & Cetak Faktur</button>
			                	';
							}
							?>
								
								<?php
							echo form_close();
							?>


						</div>
						<br>

						<?php echo form_open('farmasi/Frmcdaftar/edit_obat');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_id_obat" id="edit_id_obat" disabled="">
                      <input type="hidden" class="form-control" name="edit_id_obat_hidden" id="edit_id_obat_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Item</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nama_obat" id="edit_nama_obat" disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Biaya</p>
                    <div class="col-sm-6">
                      <input type="number" class="form-control" name="edit_biaya_obat" id="edit_biaya_obat" min="0" disabled="">
                    </div>
                  </div>                  	
								<div class="form-group row">
                   					<div class="col-sm-1"></div>
                    					<p class="col-sm-3 form-control-label">Quantity</p>
                    					<div class="col-sm-2">
                      						<input type="number" class="form-control" name="edit_qty" id="edit_qty" onchange="set_total(this.value)">
                    					</div>
                  				</div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit</button>
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close();?>
		</section>
<?php
	$this->load->view('layout/footer.php');
?>
