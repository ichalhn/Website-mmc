<?php $this->load->view("layout/header.php"); ?>
<br>
<?php $this->load->view("iri/data_pasien_edit"); ?>
<?php // $this->load->view("iri/layout/all_page_js_req"); ?>

<script>
$(document).ready(function(){
   	$('#tgl_tindakan').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
		endDate: '0',	
	});
	$('.js-example-basic-single').select2();
});
	
function form_tambah_tindakan(){
	alert("test");
}


$('tindakan').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    alert(valueSelected);
});

// moris below

function pilih_tindakan(val){
	var temp = val.split("-");
	var cara_bayar = "$data_pasien[0]['carabayar']";

	$('#biaya_tindakan').val(temp[1]);
	$('#biaya_tindakan_hide').val(temp[1]);

	$('#biaya_alkes').val(temp[3]);
	$('#biaya_alkes_hide').val(temp[3]);

	$('#paket').val(temp[2]);
	var qty = $('#qtyind').val();
	var total = ((parseInt(qty) * (parseInt(temp[1])  + parseInt(temp[3]))));
	$('#vtot').val(total);

	//buat nentuin jatah kelas. biar ada pengurangan aja. komen dulu ga ngerti soalnya. kwkwkwkw
	// $.ajax({
	//     type:'POST',
	//     url:'<?php echo base_url("iri/rictindakan/get_tarif_by_jatah_id_kelas/"); ?>',
	//     data:{
	//     		'id_tindakan':temp[0],
	//     		'cara_bayar':temp[0],
	//     		'kelas':"<?php echo $data_pasien[0]['jatahklsiri']; ?>",
	//     	},
	//     success:function(data){
 //    		var obj = JSON.parse(data);
    		
 //    		if(!isEmpty(obj)){
 //    			$("#harga_satuan_jatah_kelas").val(obj[0]['total_tarif']);
 //    			$("#biaya_jatah_kelas").val(obj[0]['total_tarif']);
 //    			$("#paket").val(obj[0]['paket']);
 //    			$("#biaya_alkes").val(obj[0]['tarif_alkes']);
 //    			$('#vtot_kelas').val(obj[0]['total_tarif']);
 //    			$('#vtot').val(total - (obj[0]['total_tarif'] * qty) );
 //    			$('#biaya_tindakan').val(temp[1] - obj[0]['total_tarif']);
 //    		}else{
 //    			$("#harga_satuan_jatah_kelas").val('0');
 //    			$("#biaya_jatah_kelas").val('0');
 //    			//$('#vtot').val('0');
 //    		}
	//     }
	// });
}

function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }

    return true;
}

function set_total(val){
	var biaya_tindakan = $('#biaya_tindakan').val();
	var biaya_alkes = $('#biaya_alkes').val();
	var harga_satuan_jatah_kelas = $('#harga_satuan_jatah_kelas').val();

	var harga_satuan_jatah_kelas = $('#harga_satuan_jatah_kelas').val();

	var total = (parseInt(val) * (parseInt(biaya_tindakan) + parseInt(biaya_alkes)));
	var total_jatah_kelas = val * harga_satuan_jatah_kelas;
	$('#vtot').val(total);
	$('#vtot_kelas').val(total_jatah_kelas);
}

function insert_total(){
	var jumlah = $('#jumlah').val();

	// bawah
	//qty di set 1 karena hasil dari perhitungan sendiri


	var val = $('select[name=idtindakan]').val();
	var temp = val.split("-");
	var cara_bayar = "$data_pasien[0]['carabayar']";

	$('#biaya_tindakan').val(jumlah);
	$('#biaya_tindakan_hide').val(jumlah);
	var qty = 1;
	$('#qtyind').val(1)
	var total = qty * jumlah;
	$('#vtot').val(total);

	$.ajax({
	    type:'POST',
	    url:'<?php echo base_url("iri/rictindakan/get_tarif_by_jatah_id_kelas/"); ?>',
	    data:{
	    		'id_tindakan':temp[0],
	    		'cara_bayar':temp[0],
	    		'kelas':"<?php echo $data_pasien[0]['jatahklsiri']; ?>",
	    	},
	    success:function(data){
    		var obj = JSON.parse(data);
    		
    		if(!isEmpty(obj)){
    			$("#harga_satuan_jatah_kelas").val(obj[0]['total_tarif']);
    			$("#biaya_jatah_kelas").val(obj[0]['total_tarif']);
    			$('#vtot_kelas').val(obj[0]['total_tarif']);
    			$('#vtot').val(total - (obj[0]['total_tarif'] * qty) );
    			$('#biaya_tindakan').val(jumlah - obj[0]['total_tarif']);
    		}else{
    			$("#harga_satuan_jatah_kelas").val('0');
    			$("#biaya_jatah_kelas").val('0');
    			//$('#vtot').val('0');
    		}
	    }
	});

	//alert(jumlah);
}

</script>
		<!-- Keterangan page -->
		<section class="content-header">
			<h1>Input Tindakan Pasien</h1>
			
		</section>
		<!-- /Keterangan page -->

        <!-- Main content -->
       <section class="content">
			<?php echo $this->session->flashdata('pesan');?>
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading" align="center">
							<ul class="nav nav-pills nav-justified">
							  <li role="presentation" class="active"><a data-toggle="tab" href="#tabtindakan">Tindakan</a></li>
							  <!-- <li role="presentation" class=""><a data-toggle="tab" href="#tabdiagnosa">Diagnosa</a></li> -->							  
							</ul>
						</div>
						
						<div class="tab-content">
						  <div id="tabtindakan" class="tab-pane fade in active">	    								
							<div class="panel-body">						
							<!-- form -->
							<div class="well" >
							<form class="form-horizontal" action="<?php echo site_url('iri/rictindakan/tambah_tindakan_kasir'); ?>" method="post">
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="tindakan">Tindakan</p>
										<div class="col-sm-8">
											<select id="prop" class="js-example-basic-single form-control" name="idtindakan" id="idtindakan" onchange="pilih_tindakan(this.value)" required>
											<option value="">-Pilih Tindakan-</option>
												<?php foreach($list_tindakan as $r){
												?>	
												<option value="<?php echo $r['idtindakan'].'-'.$r['total_tarif'].'-'.$r['paket'].'-'.$r['tarif_alkes'] ; ?>"><?php echo $r['idtindakan']." - ".$r['nmtindakan']." | Rp.".number_format($r['total_tarif'], 2 , ',' , '.' );?></option>;
												<?php
												}
												?>
												</select>
										</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="operator">Pelaksana</p>
										<div class="col-sm-8">
											<select class="form-control js-example-basic-single" name="operatorTindakan" required>
											<option value="">-Pilih Pelaksana-</option>											
											<?php foreach($list_dokter as $r){
											?>	
											<option value="<?php echo $r['id_dokter'] ; ?>"><?php echo $r['nm_dokter'] ;?></option>;
											<?php
											}
											?>		
											</select>
										</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="nmdokter">Waktu Tindakan</p>
									<div class="col-sm-8">
										<!-- <div class="form-inline"> -->
											<!-- <div class="col-sm-6"> -->
												<div class='input-group date' id='tgl_tindakan'>
													<input type="text" id="tgl_tindakan" class="form-control" placeholder="Tanggal Tindakan" name="tgl_tindakan" required="" value="<?php echo date('Y-m-d')?>">
													<span class="input-group-addon">
								                        <span class="glyphicon glyphicon-calendar"></span>
								                    </span>
												</div>
											<!-- </div> -->
										<!-- </div> -->
									</div>
								</div>

								<!-- <div class="form-group row">
									<p class="col-sm-4 form-control-label" id="dokter_anastesi">Dokter Anastesi *)</p>
										<div class="col-sm-8">
											<select class="form-control js-example-basic-single" name="dokter_anastesi">
											<option value="">-Pilih Dokter Anastesi-</option>											
											<?php foreach($list_dokter as $r){
											?>	
											<option value="<?php echo $r['id_dokter'] ; ?>"><?php echo $r['nm_dokter'] ;?></option>;
											<?php
											}
											?>		
											</select>
										</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="penata_anastesi">Penata Anastesi *)</p>
										<div class="col-sm-8">
											<select class="form-control js-example-basic-single" name="penata_anastesi" >
											<option value="">-Pilih Penata Anastesi-</option>											
											<?php foreach($list_dokter as $r){
											?>	
											<option value="<?php echo $r['id_dokter'] ; ?>"><?php echo $r['nm_dokter'] ;?></option>;
											<?php
											}
											?>		
											</select>
										</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="asisten_dokter">Asisten Dokter *)</p>
										<div class="col-sm-8">
											<select class="form-control js-example-basic-single" name="asisten_dokter" >
											<option value="">-Pilih Asisten Dokter-</option>											
											<?php foreach($list_dokter as $r){
											?>	
											<option value="<?php echo $r['id_dokter'] ; ?>"><?php echo $r['nm_dokter'] ;?></option>;
											<?php
											}
											?>		
											</select>
										</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="instrumen">Instrumen *)</p>
										<div class="col-sm-8">
											<select class="form-control js-example-basic-single" name="instrumen" >
											<option value="">-Pilih Instrumen-</option>											
											<?php foreach($list_dokter as $r){
											?>	
											<option value="<?php //echo $r['id_dokter'] ; ?>"><?php //echo $r['nm_dokter'] ;?></option>;
											<?php
											}
											?>		
											</select>
										</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="dokter_anak">Dokter Anak *)</p>
										<div class="col-sm-8">
											<select class="form-control js-example-basic-single" name="dokter_anak" >
											<option value="">-Pilih Dokter Anak-</option>											
											<?php foreach($list_dokter as $r){
											?>	
											<option value="<?php echo $r['id_dokter'] ; ?>"><?php echo $r['nm_dokter'] ;?></option>;
											<?php
											}
											?>		
											</select>
										</div>
								</div> -->
								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_biaya_poli">Biaya Tindakan</p>
									<div class="col-sm-8">
										<input type="number" min=0 class="form-control"  name="biaya_tindakan" id="biaya_tindakan" disabled>
										<input type="hidden" class="form-control" name="biaya_tindakan_hide" id="biaya_tindakan_hide">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_biaya_poli">Biaya Alkes</p>
									<div class="col-sm-8">
										<input type="number" min=0 class="form-control"  name="biaya_alkes" id="biaya_alkes" disabled>
										<input type="hidden" class="form-control" name="biaya_alkes_hide" id="biaya_alkes_hide">
									</div>
								</div>
								<!-- <div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_biaya_poli">Biaya Jatah Kelas</p>
									<div class="col-sm-8">
										<input type="number" min=0 class="form-control"  name="biaya_jatah_kelas" id="biaya_jatah_kelas" disabled>
									</div>
								</div> -->
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_qtyind">Qty</p>
									<div class="col-sm-8">
										<input type="number" class="form-control" value="1" name="qtyind" id="qtyind" min=1 onchange="set_total(this.value)">
									</div>
								</div>								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_vtot">Total</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="vtot" id="vtot" disabled>								<input type="hidden" class="form-control" name="vtot_hide" id="vtot_hide">
									</div>
								</div>

								
								<!-- *) Diisi hanya untuk tindakan Operasi Paket<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_vtot">Total Jatah Kelas</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="vtot_kelas" id="vtot_kelas" disabled>								<input type="hidden" class="form-control" name="vtot_hide" id="vtot_hide">
									</div>
								</div> -->
								
								<div class="form-inline" align="right" style="padding-right:20px;">
								<input type="hidden"  name="no_ipd_h" id="no_ipd_h" value="<?php echo $data_pasien[0]['no_ipd'];?>" />
								<input type="hidden"  name="harga_satuan_jatah_kelas" id="harga_satuan_jatah_kelas" />
								<input type="hidden"  name="paket" id="paket" />
									<div class="form-group">
										<button type="reset" class="btn btn-primary">Reset</button>
										<button type="submit" class="btn btn-primary">Tambah</button>
									</div>
								</div>
							</form>

							<FORM NAME="Calc">
								<TABLE BORDER=4>
								<TR>
								<TD>
								<INPUT TYPE="text"   NAME="Input" Size="16" id="jumlah">
								<br>
								</TD>
								</TR>
								<TR>
								<TD>
								<INPUT TYPE="button" NAME="one"   VALUE="  1  " OnClick="Calc.Input.value += '1'">
								<INPUT TYPE="button" NAME="two"   VALUE="  2  " OnCLick="Calc.Input.value += '2'">
								<INPUT TYPE="button" NAME="three" VALUE="  3  " OnClick="Calc.Input.value += '3'">
								<INPUT TYPE="button" NAME="plus"  VALUE="  +  " OnClick="Calc.Input.value += ' + '">
								<br>
								<INPUT TYPE="button" NAME="four"  VALUE="  4  " OnClick="Calc.Input.value += '4'">
								<INPUT TYPE="button" NAME="five"  VALUE="  5  " OnCLick="Calc.Input.value += '5'">
								<INPUT TYPE="button" NAME="six"   VALUE="  6  " OnClick="Calc.Input.value += '6'">
								<INPUT TYPE="button" NAME="minus" VALUE="  -  " OnClick="Calc.Input.value += ' - '">
								<br>
								<INPUT TYPE="button" NAME="seven" VALUE="  7  " OnClick="Calc.Input.value += '7'">
								<INPUT TYPE="button" NAME="eight" VALUE="  8  " OnCLick="Calc.Input.value += '8'">
								<INPUT TYPE="button" NAME="nine"  VALUE="  9  " OnClick="Calc.Input.value += '9'">
								<INPUT TYPE="button" NAME="times" VALUE="  x  " OnClick="Calc.Input.value += ' * '">
								<br>
								<INPUT TYPE="button" NAME="clear" VALUE="  c  " OnClick="Calc.Input.value = ''">
								<INPUT TYPE="button" NAME="zero"  VALUE="  0  " OnClick="Calc.Input.value += '0'">
								<INPUT TYPE="button" NAME="DoIt"  VALUE="  =  " OnClick="Calc.Input.value = eval(Calc.Input.value)">
								<INPUT TYPE="button" NAME="div"   VALUE="  /  " OnClick="Calc.Input.value += ' / '">
								<br>
								<INPUT TYPE="button" NAME="Masukkan Perhitungan"   VALUE="Masukkan Perhitungan" OnClick="insert_total()">
								</TD>
								</TR>
								</TABLE>
								</FORM>

							</div>


							
							<!-- table -->
								<br>
							<div style="display:block;overflow:auto;">
							<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
							  <thead>
								<tr>
								  <th>Tindakan</th>
								  <th>Pelaksana</th>
								  <th>Biaya Tindakan</th>
								  <th>Biaya Alkes</th>
								  <th>Qtyind</th>
								  <th>Total</th>
								  <th>Aksi</th>
								</tr>
							  </thead>
							  <tbody>
								<?php
									foreach($list_tindakan_pasien as $r){
								?>
									<tr>
										<td><?php echo $r['nmtindakan'] ; ?></td>
										<td><?php echo $r['nmdokter'] ; ?></td>
										<td>Rp. <?php echo number_format($r['tumuminap'] - $r['harga_satuan_jatah_kelas'],0) ; ?></td>
										<td>Rp. <?php echo number_format($r['tarifalkes'],0) ; ?></td>
										<td><?php echo $r['qtyyanri'] ; ?></td>
										<td>Rp. <?php echo number_format($r['vtot'] - $r['vtot_jatah_kelas'] + $r['tarifalkes'],0) ; ?></td>
										<td>
											<a href="<?php echo base_url(); ?>iri/rictindakan/hapus_tindakan_temp/<?php echo $r['id_jns_layanan'] ;?>/<?php echo $data_pasien[0]['no_ipd'];?>" class="btn btn-primary btn-xs">Hapus</a>
										</td>
									</tr>
								<?php
									}
								?>
							  </tbody>
							</table>
							</div><!-- style overflow -->
							<form class="form-horizontal" action="<?php echo site_url('iri/rictindakan/tambah_tindakan_real_kasir/edit'); ?>" method="post">
							<br>
							<div class="form-inline" align="right" style="padding-right:20px;">
								<input type="hidden"  name="no_ipd_h" id="no_ipd_h" value="<?php echo $data_pasien[0]['no_ipd'];?>" />
									<div class="form-group">
										<button type="submit" class="btn btn-primary">Simpan</button>
									</div>
							</div>
							</form>

							<hr>
							
							<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example2">
								  <thead>
									<tr>
									  <th>Tindakan</th>
									  <th>Pelaksana</th>
									  <th>Tgl Tindakan</th>
									  <th>Biaya Tindakan</th>
									  <th>Biaya Alkes</th>
									  <th>Qty</th>
									  <th>Total</th>
									  <th>Aksi</th>
									</tr>
								  </thead>
								  <tbody>
									<?php
									$total_bayar = 0;
									if(!empty($list_tindakan_pasien_real)){
										foreach($list_tindakan_pasien_real as $r){ ?>
										<tr>
											<td><?php echo $r['nmtindakan'] ; ?></td>
											<td><?php echo $r['nmdokter'] ; ?></td>
											<td><?php 
									  		echo date('d F Y', strtotime($r['tgl_layanan']));

											?></td>
											<td>Rp. <?php echo number_format($r['tumuminap'] - $r['harga_satuan_jatah_kelas'],0) ; ?></td>
											<td>Rp. <?php echo number_format($r['tarifalkes'],0) ; ?></td>
											<td><?php echo $r['qtyyanri'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'] - $r['vtot_jatah_kelas'],0) ; ?></td>
											<?php $total_bayar = $total_bayar + $r['vtot'] - $r['vtot_jatah_kelas'];?>
											<td>
											<?php if($access=='1'){ ?>
												<a href="<?php echo base_url(); ?>iri/rictindakan/hapus_tindakan/<?php echo $r['id_jns_layanan'] ;?>/<?php echo $data_pasien[0]['no_ipd'];?>/edit" class="btn btn-danger btn-xs">Hapus</a>
												<?php } ?>
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
											  <td colspan="6">Total Tindakan</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
						</div>
						<!-- <div id="tabdiagnosa" class="tab-pane fade">
						    	<?php
									//include('form_diagnosa.php');
								?>				 
						</div> -->
						
						
					</div>

				</div>

			</div>

		</div>
		<!-- /Main content -->

		</div>

		
		</section>
	
	
<script>
	// $(function () {
	// 	$("#example1").DataTable();
	// });
	// $('#calendar-tgl').datepicker();
</script>
<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
		var dataTable = $('#dataTables-example2').DataTable( {
			
		});
	});
</script>

<?php $this->load->view("layout/footer.php"); ?>