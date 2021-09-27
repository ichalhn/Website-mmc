<?php
	$this->load->view('layout/header.php');
?>
<link rel="stylesheet" href="<?php echo site_url('asset/plugins/iCheck/flat/green.css'); ?>">
<script src="<?php echo site_url('asset/plugins/iCheck/icheck.min.js'); ?>"></script>
<script type='text/javascript'>

	//-----------------------------------------------Data Table
	$(document).ready(function() {
	    // $('#tabel_tindakan').DataTable();				
		$('input').iCheck({
	    	checkboxClass: 'icheckbox_flat-green'
	  	});
	});
	//---------------------------------------------------------

	var site = "<?php echo site_url();?>";	

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
		                 window.location.reload();
		            }
		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		            alert('Error hapus / hapus data');
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

</section>
<?php
	$this->load->view('layout/footer.php');
?>