<?php
	$this->load->view('layout/header.php');
?>
<link rel="stylesheet" href="<?php echo site_url('asset/plugins/iCheck/flat/green.css'); ?>">
<script src="<?php echo site_url('asset/plugins/iCheck/icheck.min.js'); ?>"></script>
<script type='text/javascript'>

	//-----------------------------------------------Data Table
	$(document).ready(function() {
	    $('#tabel_tindakan').DataTable();
		$('#tabel_diagnosa').DataTable();
		$("#biaya_pa").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$("#vtot").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$('input').iCheck({
	    	checkboxClass: 'icheckbox_flat-green'
	  	});
	});
	//---------------------------------------------------------

	var site = "<?php echo site_url();?>";
			
	function pilih_tindakan(id_tindakan) {
		$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('pa/pacdaftar/get_biaya_tindakan')?>",
			data: {
				id_tindakan: id_tindakan,
				kelas : "<?php echo $kelas_pasien ?>"
			},
			success: function(data){
				$('#biaya_pa').val(data);
				$('#biaya_pa_hide').val(data);
				$('#qty').val('1');
				set_total();
			},
			error: function(){
				alert("error");
			}
	    });
	}

	function set_total() {
		var total = $("#biaya_pa").val() * $("#qty").val();	
		$('#vtot').val(total);
		$('#vtot_hide').val(total);
	}

	function hapus_data_pemeriksaan(id_pemeriksaan_pa)
	{
	  if(confirm('Are you sure delete this data?'))
	  {
	    // ajax delete data to database
	   	$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('pa/pacdaftar/hapus_data_pemeriksaan')?>/"+id_pemeriksaan_pa,
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

	function save(){
        $.ajax({
			url:"<?php echo base_url('pa/pacdaftar/save_pemeriksaan')?>",
	        type: "POST",
	        data: $('#formPemeriksaan').serialize(),
	        dataType: "JSON",
	        success: function(data)
	        {

	            if(data.status) //if success close modal and reload ajax table
	            {
	                $('#pemeriksaanModal').modal('hide');
	                window.location.reload();
	            }


	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	         	window.location.reload();
        	}
    	});
	}

	function closepage() {
		window.open('', '_self', ''); window.close();
	}


</script>
	<?php include('pavdatapasien.php');?>
	<section class="content-header">
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">	
						<div class="panel-heading" align="center">
							<h4  align="center">Daftar Pemeriksaan</h4>
						</div>
						<div class="panel-body" style="display:block;overflow:auto;">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pemeriksaanModal">Add Pemeriksaan</button>

						<br/><br/>

							<!-- form -->
							<div class="well">
							<?php echo form_open('pa/pacdaftar/insert_pemeriksaan'); ?>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nmdokter">Dokter</p>
										<div class="col-sm-10">
											<div class="form-inline">
												<div class="form-group">
													<select id="id_dokter" class="form-control js-example-basic-single" name="id_dokter"  required>
														<option value="" disabled selected="">-Pilih Dokter-</option>
														<?php 
															foreach($dokter as $row){
																if($row->nm_dokter=="SMF PATALOGI ANATOMI"){
																	echo '<option value="'.$row->id_dokter.'" selected>'.$row->nm_dokter.'</option>';
																}else{
																	echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
																}
															}
														?>
													</select>
												</div>
											</div>
										</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="tindakan">Pemeriksaan</p>
										<div class="col-sm-10">
											<div class="form-inline">
												<!--
												<input type="search" style="width:100%" class="auto_search_tindakan form-control" placeholder="" id="nmtindakan" name="nmtindakan" required>
												<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan"  name="idtindakan">
												-->
												<div class="form-group">
													<select id="idtindakan" class="form-control js-example-basic-single" name="idtindakan" onchange="pilih_tindakan(this.value)" required>
														<option value="" disabled selected="">-Pilih Pemeriksaan-</option>
														<?php 
															foreach($tindakan as $row){
																echo '<option value="'.$row->idtindakan.'">'.$row->nmtindakan.'</option>';
															}
														?>
													</select>
												</div>
											</div>
										</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_biaya_periksa">Biaya Pemeriksaan</p>
									<div class="col-sm-3">
										<div class="input-group">
											<span class="input-group-addon">Rp</span>
											<input type="text" class="form-control" value="<?php //echo $biaya_pa; ?>" name="biaya_pa" id="biaya_pa" disabled>
											<input type="hidden" class="form-control" value="" name="biaya_pa_hide" id="biaya_pa_hide">
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
												  	<th>Tanggal Pemeriksaan</th>
												  	<th>Dokter</th>
												  	<th>Jenis Pemeriksaan</th>
												  	<th>Biaya Pemeriksaan</th>
												  	<th>Qtyind</th>
												  	<th>Total</th>
												  	<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$i=1;
														foreach($data_pemeriksaan as $row){
														
													?>
														<tr>
															<td><?php echo $i++ ; ?></td>
															<td><?php echo $row->xupdate ; ?></td>
															<td><?php echo $row->nm_dokter.' ('.$row->id_dokter.')' ; ?></td>
															<td><?php echo $row->jenis_tindakan.' ('.$row->id_tindakan.')' ; ?></td>
															<td><?php echo $row->biaya_pa ; ?></td>
															<td><?php echo $row->qty ; ?></td>
															<td><?php echo $row->vtot ; ?></td>
															<td>
																<a class="btn btn-danger btn-xs" href="javascript:void()" title="Hapus" onclick="hapus_data_pemeriksaan(<?php echo $row->id_pemeriksaan_pa ; ?>)">Hapus</a>
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
								echo form_open('pa/pacdaftar/selesai_daftar_pemeriksaan');?>
								<div class="form-inline" align="right">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">

									<div class="form-group">
									<?php if($roleid==21 or $roleid==1){
										echo '
											<button class="btn btn-primary">Selesai & Cetak</button>
					                	';
									} 
									if($roleid<>21 or $roleid==1){
										echo '
											<button type="button" onclick="closepage()" class="btn btn-primary">Selesai & Close</button>
					                	';
									}
									?>
									</div>
								</div>						
								<?php
									echo form_close();
								?>
						</div>
					</div>
				</div>
			</div>
		</section>


		<div class="modal fade" id="pemeriksaanModal" role="dialog" data-backdrop="static" data-keyboard="false">
		    <div class="modal-dialog modal-success modal-lg">
		        <div class="modal-content">
		                <form action="#" id="formPemeriksaan" class="formPemeriksaan">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                    <span aria-hidden="true">&times;</span>
		                </button>
		                <h3 class="modal-title">Input Pemeriksaan</h3>
		            </div>
		            <div class="modal-body form">
						<div class="well-sm">
			            	<div class="form-group row">
								<p class="col-sm-2 form-control-label" id="nmdokter">Dokter</p>
								<div class="col-sm-10">
									<div class="form-inline">
										<div class="form-group">
											<select id="id_dokter" class="form-control js-example-basic-single" name="id_dokter"  required>
												<option value="" disabled selected="">-Pilih Dokter-</option>
												<?php 
													foreach($dokter as $row){
														if($row->nm_dokter=="SMF PATALOGI ANATOMI"){
															echo '<option value="'.$row->id_dokter.'" selected>'.$row->nm_dokter.'</option>';
														}else{
															echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
														}
													}
												?>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
						
						foreach($data_jenis_pa as $row1){
							echo '
							<div class="well" style="color:black">
			                    <div class="form-group row">
			                    	<p class="col-sm-12 form-control-label" id="nmdokter"><b>'.$row1->nama_jenis.'</b></p>
			                    ';
		                    foreach($tindakan as $row2){
								//echo '<div class="col-xs-3" style="background:#000000;border-style: dashed;">';
								if($row1->kode_jenis==substr($row2->idtindakan,0,2)){
									echo "<div class='col-sm-3' style='margin: 10px 0px 10px 0px;'> 
									<input type='checkbox' name='myCheckboxes[]' id='myCheckboxes' value='".$row2->idtindakan."' /> ".$row2->nmtindakan."</div>";
								}
							}
							echo '</div></div>';
						}

						?>
		            </div>
		            <div class="modal-footer">
		                <button type="button" id="submit" onclick="save()" class="btn btn-primary">Save</button>
		                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		            </div>
						<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kunj">
						<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
						<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
						<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
						<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
						<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
						<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
						<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
		                </form>
		        </div><!-- /.modal-content -->
		    </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
<?php
	$this->load->view('layout/footer.php');
?>

<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2();
});
</script>