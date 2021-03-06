<?php
	$this->load->view('layout/header.php');
?>
<link rel="stylesheet" href="<?php echo site_url('asset/plugins/iCheck/flat/green.css'); ?>">
<script src="<?php echo site_url('asset/plugins/iCheck/icheck.min.js'); ?>"></script>
<script type='text/javascript'>

	//-----------------------------------------------Data Table
	$(document).ready(function() {
	    // $('#tabel_tindakan').DataTable();
		$('#tabel_diagnosa').DataTable();
		$("#biaya_lab").maskMoney({thousands:',', decimal:'.', affixesStay: true});
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
			url:"<?php echo base_url('lab/labcdaftar/get_biaya_tindakan')?>",
			data: {
				id_tindakan: id_tindakan,
				kelas : "<?php echo $kelas_pasien ?>"
			},
			success: function(data){
				$('#biaya_lab').val(data);
				$('#biaya_lab_hide').val(data);
				$('#qty').val('1');
				set_total();
			},
			error: function(){
				alert("error");
			}
	    });
	}

	function set_total() {
		var total = $("#biaya_lab").val() * $("#qty").val();	
		$('#vtot').val(total);
		$('#vtot_hide').val(total);
	}

	function hapus_data_pemeriksaan(id_pemeriksaan_lab)
	{
	  	swal({
		  	title: "Hapus Data",
		  	text: "Benar Akan Menghapus Data?",
		  	type: "info",
		  	showCancelButton: true,
		  	closeOnConfirm: false,
		  	showLoaderOnConfirm: true,
		},
		function(){
			$.ajax({
				type:'POST',
				dataType: 'json',
				url:"<?php echo base_url('lab/labcdaftar/hapus_data_pemeriksaan')?>/"+id_pemeriksaan_lab,
		        success: function(data)
		        {
		           	if(data.status) //if success close modal and reload ajax table
		            {
		            	// $('#myCheckboxes').iCheck('uncheck');
		                // $('#pemeriksaanModal').modal('hide');
		                $("#tabel_lab").load("<?php echo base_url('lab/labcdaftar/pemeriksaan_lab').'/'.$no_register;?> #tabel_lab");
		    			// swal("Data Pemeriksaan Berhasil Dihapus.");

		    			swal({
						  	title: "Data Pemeriksaan Berhasil Dihapus.",
						  	text: "Akan menghilang dalam 3 detik.",
						  	timer: 3000,
						  	showConfirmButton: false,
						  	showCancelButton: true
						});
		                // window.location.reload();
		            }
		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		            alert('Error hapus / hapus data');
		        }
		    });
		});
	}

	function save(){
		var a = document.getElementById('idtindakan').value;
		var b = document.getElementById('id_dokter').value;

		if(a==''){
			swal(
			  'Tindakan Kosong!',
			  'Isi Terlebih Dahulu!',
			  'error'
			);
		}else if(b==''){
			swal(
			  'Dokter Kosong!',
			  'Isi Terlebih Dahulu!',
			  'error'
			);
		}else{
			swal({
			  	title: "Tambah Data",
			  	text: "Benar Akan Menyimpan Data?",
			  	type: "info",
			  	showCancelButton: true,
			  	closeOnConfirm: false,
			  	showLoaderOnConfirm: true,
			},
			function(){
				$.ajax({
					url:"<?php echo base_url('lab/labcdaftar/insert_pemeriksaan')?>",
			        type: "POST",
			        data: $('#formInsertPemeriksaan').serialize(),
			        dataType: "JSON",
			        success: function(data)
			        {

			            if(data.status) //if success close modal and reload ajax table
			            {
			            	// $('#myCheckboxes').iCheck('uncheck');
			                // $('#pemeriksaanModal').modal('hide');
			                $("#tabel_lab").load("<?php echo base_url('lab/labcdaftar/pemeriksaan_lab').'/'.$no_register;?> #tabel_lab");
			    			// swal("Data Pemeriksaan Berhasil Disimpan.");
				    			
			    // 			swal({
							//   	title: "Data Pemeriksaan Berhasil Disimpan.",
							//   	text: "Akan menghilang dalam 3 detik.",
							//   	timer: 3000,
							//   	showConfirmButton: false,
							//   	showCancelButton: true
							// });

							swal(
							  'Sukses!',
							  'Data Pemeriksaan Berhasil Disimpan.',
							  'success'
							);
			                // window.location.reload();
			            }


			        },
			        error: function (jqXHR, textStatus, errorThrown)
			        {
			         	window.location.reload();
		        	}
		    	});
			});
		}
	}

	function save_banyak_data(){
		swal({
		  	title: "Tambah Data",
		  	text: "Benar Akan Menyimpan Data?",
		  	type: "info",
		  	showCancelButton: true,
		  	closeOnConfirm: false,
		  	showLoaderOnConfirm: true,
		},
		function(){
			$.ajax({
				url:"<?php echo base_url('lab/labcdaftar/save_pemeriksaan')?>",
		        type: "POST",
		        data: $('#formPemeriksaan').serialize(),
		        dataType: "JSON",
		        success: function(data)
		        {

		            if(data.status) //if success close modal and reload ajax table
		            {
		            	 $('#myCheckboxes').iCheck('uncheck');
		                $('#pemeriksaanModal').modal('hide');
		                $("#tabel_lab").load("<?php echo base_url('lab/labcdaftar/pemeriksaan_lab').'/'.$no_register;?> #tabel_lab");
		    			// swal("Data Pemeriksaan Berhasil Disimpan.");	
		    			swal({
						  	title: "Data Pemeriksaan Berhasil Disimpan.",
						  	text: "Akan menghilang dalam 3 detik.",
						  	timer: 3000,
						  	showConfirmButton: false,
						  	showCancelButton: true
						});
		                // window.location.reload();
		            }


		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		         	window.location.reload();
	        	}
	    	});
		});
	}

	function closepage() {
		window.open('', '_self', ''); window.close();
	}


</script>
<?php include('labvdatapasien.php');?>
<section class="content-header">
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">	
				<div class="panel-heading" align="center">
					<h4  align="center">Daftar Pemeriksaan <?php if($tgl_periksa!=''){echo ' | '.date('d-m-Y',strtotime($tgl_periksa)); }?></h4>
				</div>
				<div class="panel-body" style="display:block;overflow:auto;">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pemeriksaanModal">Add Pemeriksaan</button>
					<br/><br/>
					<!-- form -->
					<div class="well">
					<?php 
						$attributes = array('id' => 'formInsertPemeriksaan');
						echo form_open('lab/labcdaftar/insert_pemeriksaan', $attributes); ?>
						<div class="form-group row">
							<p class="col-sm-2 form-control-label" id="nmdokter">Dokter</p>
								<div class="col-sm-10">
									<div class="form-inline">
										<div class="form-group">
											<select id="id_dokter" class="form-control js-example-basic-single" name="id_dokter"  required>
												<option value="" disabled selected="">-Pilih Dokter-</option>
												<?php 
													foreach($dokter as $row){
														if($row->nm_dokter=="SMF LABORATORIUM"){
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
											<select id="idtindakan" class="form-control js-example-basic-single" name="idtindakan" onchange="pilih_tindakan(this.value)" required="">
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
									<input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>" name="biaya_lab" id="biaya_lab" disabled>
									<input type="hidden" class="form-control" value="" name="biaya_lab_hide" id="biaya_lab_hide">
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
							<input type="hidden" class="form-control" value="<?php echo $tgl_periksa;?>" name="tgl_periksa">
							<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
							<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
							<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
							<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
							<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
							<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
							
							<div class="form-group">
								<button type="reset" class="btn bg-orange">Reset</button>
		                		<button type="button" id="submit" onclick="save()" class="btn btn-primary">Simpan</button>
								<!-- <button type="submit" class="btn btn-primary">Simpan</button> -->
							</div>
						</div>
					<?php echo form_close();?>
					</div>
					<!-- table -->
					<br>
					<div class="row" id="form_table">
				        <div class="col-xs-12">
				          	<div class="box">
				            	<div class="box-header">
				              		<h3 class="box-title">Daftar Pemeriksaan</h3>
				            	</div>
					            <!-- /.box-header -->
					            <div class="box-body table-responsive no-padding">
					              	<table id="tabel_lab" class="table table-hover">
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
												<td><?php echo $row->biaya_lab ; ?></td>
												<td><?php echo $row->qty ; ?></td>
												<td><?php echo $row->vtot ; ?></td>
												<td>
													<a class="btn btn-danger btn-xs" href="javascript:void()" title="Hapus" onclick="hapus_data_pemeriksaan(<?php echo $row->id_pemeriksaan_lab ; ?>)">Hapus</a>
												</td>
											</tr>
										<?php
											}
										?>
										</tbody>
									</table>
					            </div>
				            <!-- /.box-body -->
				          	</div>
				          <!-- /.box -->
				        </div>
				    </div>
					<br>
					<?php
					echo form_open('lab/labcdaftar/selesai_daftar_pemeriksaan');?>
					<div class="form-inline" align="right">
						<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
						<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">

						<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
						<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">

						<div class="form-group">
						<?php if($roleid==4 or $roleid==1){
							echo '
								<button class="btn btn-primary">Selesai & Cetak</button>
		                	';
						} 
						if($roleid<>4 or $roleid==1){
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
										<select id="id_dokter" class="form-control js-example-basic-single" name="id_dokter" required="">
											<option value="" disabled selected="">-Pilih Dokter-</option>
											<?php 
												foreach($dokter as $row){
													if($row->nm_dokter=="SMF LABORATORIUM"){
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
					
					foreach($data_jenis_lab as $row1){
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
	                <button type="button" id="submit" onclick="save_banyak_data()" class="btn btn-primary">Save</button>
	                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	            </div>
					<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kunj">
					<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
					<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
					<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
					<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
					<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
					<input type="hidden" class="form-control" value="<?php echo $tgl_periksa;?>" name="tgl_periksa">
					<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
					<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
	                </form>
	        </div><!-- /.modal-content -->
	    </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</section>
<?php
	$this->load->view('layout/footer.php');
?>

<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2();
});
</script>