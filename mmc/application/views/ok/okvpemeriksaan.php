<?php
	$this->load->view('layout/header.php');
?>
<link rel="stylesheet" href="<?php echo site_url('asset/plugins/iCheck/flat/green.css'); ?>">
<script src="<?php echo site_url('asset/plugins/iCheck/icheck.min.js'); ?>"></script>
<script type='text/javascript'>

	$(document).ready(function() {
       	$('#jadwal_operasi').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true,
		});
	    $("#jam_jadwal_operasi").timepicker({
		    showInputs: false,
		    showMeridian: false
	    });
	    $('#tabel_tindakan').DataTable();
		$("#biaya_ok").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$("#vtot").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$('input').iCheck({
	    	checkboxClass: 'icheckbox_flat-green'
	  	});
	});
			
	function pilih_tindakan(id_tindakan) {
		$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('ok/okcdaftar/get_biaya_tindakan')?>",
			data: {
				id_tindakan: id_tindakan,
				kelas : "<?php echo $kelas_pasien ?>"
			},
			success: function(data){
				$('#biaya_ok').val(data);
				$('#biaya_ok_hide').val(data);
				$('#qty').val('1');
				set_total();
			},
			error: function(){
				alert("error");
			}
	    });
	}

	function set_total() {
		var total = $("#biaya_ok").val() * $("#qty").val();	
		$('#vtot').val(total);
		$('#vtot_hide').val(total);
	}

	function hapus_data_pemeriksaan(id_pemeriksaan_ok)
	{
	  if(confirm('Are you sure delete this data?'))
	  {
	    // ajax delete data to database
	   	$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('ok/okcdaftar/hapus_data_pemeriksaan')?>/"+id_pemeriksaan_ok,
	        success: function(data)
	        {
	           //if success reload ajax table
	          window.location.reload();
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            alert('Error adding / update data');
	        }
	    });
	  }
	}


</script>
	<?php include('okvdatapasien.php');?>
	<section class="content-header">
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">	
						<div class="panel-heading" align="center">
							<h4  align="center">Daftar Pemeriksaan</h4>
						</div>
						<div class="panel-body" style="display:block;overflow:auto;">

							<!-- form -->
							<div class="well">
							<?php echo form_open('ok/okcdaftar/insert_pemeriksaan'); ?>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="tindakan">Tindakan</p>
										<div class="col-sm-10">
											<div class="form-inline">
												<div class="form-group">
													<select id="idtindakan" class="form-control js-example-basic-single" name="idtindakan" onchange="pilih_tindakan(this.value)" required>
														<option value="" disabled selected="">-Pilih Tindakan-</option>
														<?php 
															foreach($tindakan as $row){
																echo '<option value="'.$row->idtindakan.'">'.$row->nmtindakan.' | Rp. '.number_format($row->total_tarif, 2 , ',' , '.' ).'</option>';
															}
														?>
													</select>
												</div>
											</div>
										</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nmdokter">Dokter 1</p>
									<div class="col-sm-10">
										<div class="form-inline">
											<div class="form-group">
												<select id="id_dokter" class="form-control js-example-basic-single" name="id_dokter1"  required>
													<option value="" disabled selected="">-Pilih Dokter 1-</option>
													<?php 
														foreach($dokter as $row){
															echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';	
														}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nmdokter2">Dokter 2</p>
									<div class="col-sm-10">
										<div class="form-inline">
											<div class="form-group">
												<select id="id_dokter2" class="form-control js-example-basic-single" name="id_dokter2">
													<option value="" selected="">-Pilih Dokter 2-</option>
													<?php 
														foreach($dokter as $row){
															echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';	
														}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nmdokter">Dokter Anastesi</p>
									<div class="col-sm-10">
										<div class="form-inline">
											<div class="form-group">
												<select id="id_dok_anes" class="form-control js-example-basic-single" name="id_dok_anes" >
													<option value="" selected="">-Pilih Dokter Anastesi-</option>
													<?php 
														foreach($dokter as $row){
															echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';	
														}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nmdokter">Jenis Anastesi</p>
									<div class="col-sm-6">
										<!-- <div class="form-inline">
											<div class="form-group"> -->
												<input type="text" class="form-control" name="jns_anes" id="jns_anes" placeholder="Jenis Anestesi">
											<!-- </div>
										</div> -->
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nmdokter">Dokter Anak</p>
									<div class="col-sm-10">
										<div class="form-inline">
											<div class="form-group">
												<select id="id_dok_anak" class="form-control js-example-basic-single" name="id_dok_anak" >
													<option value="" selected="">-Pilih Dokter Anak-</option>
													<?php 
														foreach($dokter as $row){
															echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';	
														}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nmdokter">Tanggal Operasi</p>
									<div class="col-sm-10">
										<div class="form-inline">
											<div class="form-group">
								                <div class='input-group date' id='jadwal_operasi'>
													<input type="text" id="jadwal_operasi" class="form-control" placeholder="Tanggal Operasi" name="jadwal_operasi" required="">
													<span class="input-group-addon">
								                        <span class="glyphicon glyphicon-calendar"></span>
								                    </span>
												</div>
								                <div class='input-group bootstrap-timepicker' id='jadwal_operasi'>
													<input type="text" id="jam_jadwal_operasi" class="form-control" placeholder="Jam Operasi" name="jam_jadwal_operasi" required="">
													<span class="input-group-addon">
								                        <span class="glyphicon glyphicon-time"></span>
								                    </span>
												</div>
											</div>
								            <!-- <div class="form-group">
								                <div class='input-group date' id='jadwal_operasi'>
								                    <input type='text' class="form-control" />
								                    <span class="input-group-addon">
								                        <span class="glyphicon glyphicon-calendar"></span>
								                    </span>
								                </div>
								            </div> -->
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_biaya_periksa">Biaya Pemeriksaan</p>
									<div class="col-sm-3">
										<div class="input-group">
											<span class="input-group-addon">Rp</span>
											<input type="text" class="form-control" value="<?php //echo $biaya_ok; ?>" name="biaya_ok" id="biaya_ok" disabled>
											<input type="hidden" class="form-control" value="" name="biaya_ok_hide" id="biaya_ok_hide">
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qty">Qtyind</p>
									<div class="col-sm-3">
										<input type="number" class="form-control" name="qty" id="qty" min=1 onchange="set_total(this.value)">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_vtot">Total</p>
									<div class="col-sm-3">
										<div class="input-group">
											<span class="input-group-addon">Rp</span>
											<input type="text" class="form-control" name="vtot" id="vtot" disabled>
											<input type="hidden" class="form-control" value="" name="vtot_hide" id="vtot_hide">
										</div>
									</div>
								</div>
								
								<div class="form-inline" align="right">
									<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kunj">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
									<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
									<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
									
									<div class="form-group">
										<button type="reset" class="btn bg-orange">Reset</button>
										<button type="submit" class="btn btn-primary">Simpan</button>
									</div>
								</div>
							<?php echo form_close();?>


							<!-- table -->
										<br>
									<div style="display:block;overflow:auto;">
										<table id="tabel_tindakan" class="display" cellspacing="0" width="100%">
											<thead>
												<tr>
												  	<th>No</th>
												  	<th width="15%">Jadwal Operasi</th>
												  	<th>Jenis Pemeriksaan</th>
												  	<th>Operator</th>
												  	<!-- <th>Dokter</th>
												  	<th>Operator Anestesi</th>
												  	<th>Dokter Anestesi</th>
												  	<th>Jenis Anestesi</th>
												  	<th>Dokter Anak</th> -->
												  	<th width="10%">Total Pemeriksaan</th>
												  	<th width="5%">Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$i=1;
														foreach($data_pemeriksaan as $row){
														
													?>
														<tr>
															<td><?php echo $i++ ; ?></td>
															<td><?php echo $row->tgl_operasi ; ?></td>
															<td><?php echo $row->jenis_tindakan.' ('.$row->id_tindakan.')' ; ?></td>
															<!-- <td><?php echo $row->nm_dokter.' ('.$row->id_dokter.')' ; ?></td>
															<td><?php echo $row->nm_opr_anes.' ('.$row->id_opr_anes.')' ; ?></td>
															<td><?php echo $row->nm_dok_anes.' ('.$row->id_dok_anes.')' ; ?></td>
															<td><?php echo $row->jns_anes ; ?></td>
															<td><?php echo $row->nm_dok_anak.' ('.$row->id_dok_anak.')' ; ?></td> -->
															<td>
																<?php
																	echo 'Dokter 1 : '.$row->nm_dokter.' ('.$row->id_dokter.')';
																	if($row->id_dokter2<>NULL)
																	echo '<br>Dokter 2 : '.$row->nm_dokter2.' ('.$row->id_dokter2.')';
																	if($row->id_dok_anes<>NULL)
																	echo '<br>Dokter Anestesi: '.$row->nm_dok_anes.' ('.$row->id_dok_anes.')';
																	if($row->jns_anes<>NULL)
																	echo '<br>Jenis Anestesi: '.$row->jns_anes;
																	if($row->id_dok_anak<>NULL)
																	echo '<br>Dokter Anak: '.$row->nm_dok_anak.' ('.$row->id_dok_anak.')';
																?> 

															</td>


															<td><?php echo 'Rp '.number_format( $row->vtot, 2 , ',' , '.' ); ?></td>
															<td>
																<a class="btn btn-danger btn-xs" href="javascript:void()" title="Hapus" onclick="hapus_data_pemeriksaan(<?php echo $row->id_pemeriksaan_ok ; ?>)">Hapus</a>
															</td>
														</tr>
													<?php
														}
													?>
											</tbody>
										</table>
									
									</div>
									<br>
								<?php
									echo form_open('ok/okcdaftar/selesai_daftar_pemeriksaan');?>
								<div class="form-inline" align="right">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<div class="form-group">
										<button class="btn btn-primary">Selesai & Cetak</button>
									</div>			
								<?php
									echo form_close();
								?>
								</div>			
						</div>
					</div>
				</div>
			</div>
		</section>


<?php
	$this->load->view('layout/footer.php');
?>

<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2();
});
</script>