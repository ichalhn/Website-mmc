<?php $this->load->view("layout/header.php"); ?>
<br>
<section class="content">
			
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading" align="center">
							<ul class="nav nav-pills nav-justified">
							  <li role="presentation" class="active"><a data-toggle="tab" href="#tabtindakan">Dokter</a></li>
							  <!-- <li role="presentation" class=""><a data-toggle="tab" href="#tabdiagnosa">Diagnosa</a></li> -->							  
							</ul>
						</div>
						<table class="table" style="font-size:15;width:90%;margin: 0 auto;">
						  <tbody>
							<tr>
								<th>Nama</th>
								<td>:&nbsp;</td>
								<td><?php echo $data_pasien[0]['nama'];?></td>
								<th>No. MedRec</th>
								<td>:&nbsp;</td>
								<td><?php echo $data_pasien[0]['no_cm'];?></td>
								<th>No. Register</th>
								<td>:&nbsp;</td>
								<td><?php echo $data_pasien[0]['no_ipd'];?></td>							
							</tr>
						   </tbody>
						 </table>
						<div class="tab-content">
						  <div id="tabtindakan" class="tab-pane fade in active">	    								
							<div class="panel-body">						
							<!-- form -->

							<div class="well" >
							<form class="form-horizontal" action="<?php echo site_url('iri/rictindakan/tambah_drbersama'); ?>" method="post">								
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="operator">Dokter Rawat Bersama</p>
										<div class="col-sm-8">
											<select class="form-control js-example-basic-single" name="operatorTindakan" required>
											<option value="">-Pilih Dokter-</option>											
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
									<p class="col-sm-4 form-control-label" >Keterangan</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="ket" id="ket" maxlength="100">		
									</div>
								</div>
								
								<!-- <div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_vtot">Total Jatah Kelas</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="vtot_kelas" id="vtot_kelas" disabled>								<input type="hidden" class="form-control" name="vtot_hide" id="vtot_hide">
									</div>
								</div> -->
								
								<div class="form-inline" align="right" style="padding-right:20px;">
								<input type="hidden"  name="no_ipd_h" id="no_ipd_h" value="<?php echo $data_pasien[0]['no_ipd'];?>" />
								
									<div class="form-group">
										<button type="reset" class="btn btn-primary">Reset</button>
										<button type="submit" class="btn btn-primary">Tambah</button>
									</div>
								</div>
							</form>
							

							</div>


							
							<!-- table -->
								<br>
							<div style="display:block;overflow:auto;">
							<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
							  <thead>
								<tr>
								  <th>No</th>
								  <th>Nama Dokter</th>
								  <th>Keterangan</th>								 
								  <th>Aksi</th>
								</tr>
							  </thead>
							  <tbody>
								<?php
									$no=1;
									foreach($list_dokter_pasien as $r){
								?>
									<tr>
										<td><?php echo $no++; ?></td>
										<td><?php if($r['id_drtambahan']!='0'){echo $r['nm_dokter'];}else{?><input type="text" class="form-control input-sm auto_no_register_dokter" name="nmdokter" id="nmdokter" value="<?php if(isset($data_pasien[0]['dokter'])){echo $data_pasien[0]['dokter'];}?>">
										<input type="hidden" class="form-control input-sm" name="id_dokter" id="id_dokter" value="<?php if(isset($data_pasien[0]['id_dokter'])){echo $data_pasien[0]['id_dokter'];}?>"><?php }?></td>								
										<td><?php echo $r['ket'] ; ?></td>										
										<td>
											<?php if($r['id_drtambahan']=='0'){ ?> 
												<input type="button" class="btn btn-primary btn-sm" value="Edit" onclick="update_dokter('<?php echo $data_pasien[0]['no_ipd'];?>')">					
											<?php }else{?>
												<a href="<?php echo base_url(); ?>iri/rictindakan/hapus_drbersama/<?php echo $r['id_drtambahan'] ;?>/<?php echo $data_pasien[0]['no_ipd'];?>" class="btn btn-danger btn-xs">Hapus</a>
											<?php }?>
										</td>
									</tr>
								<?php
									}
								?>
							  </tbody>
							</table>
							</div><!-- style overflow -->														
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
	var site = "<?php echo site_url(); ?>";
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable({});
		$('.js-example-basic-single').select2();
		$('.auto_no_register_dokter').autocomplete({
		serviceUrl: site+'/iri/ricpendaftaran/data_dokter_autocomp',
		onSelect: function (suggestion) {
			$('#id_dokter').val(''+suggestion.id_dokter);
			$('#nmdokter').val(''+suggestion.nm_dokter);
		}
	});
	});

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
</script>
<?php $this->load->view("layout/footer.php"); ?>