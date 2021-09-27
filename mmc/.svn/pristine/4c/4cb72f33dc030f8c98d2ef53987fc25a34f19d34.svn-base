<?php
	$this->load->view('layout/header.php');
?>
<script type='text/javascript'>
var table, ajaxku;

$(function() {
	table = $('#example').DataTable( {
        "order": [[ 0, "desc" ]]
    } );
	
	$(".select2").select2();

	$('.datepicker').datepicker({
      format: "yyyy-mm-dd",
      endDate: '0',
      autoclose: true,
      todayHighlight: true,
    }); 
	
	$('#pengguna_baru').autocomplete({
		serviceUrl: '<?php echo site_url();?>kepegawaian/Data_pegawai/by_nama',
		onSelect: function (suggestion) {
			$('#nip_baru').val(''+suggestion.nip);
			$('#id_unit_baru').val(''+suggestion.id_bagian);
			$('#id_unit_baru').val(''+suggestion.id_bagian).trigger('change');
		}
	});
	
	$('#id_unit_baru').change(function() {
		var id_unit = $('#id_unit_baru').val();
		$.ajax({
		  dataType: "html",
		  type: 'GET',
		  url: "<?php echo site_url(); ?>kepegawaian/Data_pegawai/get_unit/"+id_unit,
		  success: function( response ) {
			$('#unit_baru').val(response);
		  }
		});		
	});
	
	$('#mutasiModal').on('shown.bs.modal', function(e) {
		//get data-id attribute of the clicked element
		var id = $(e.relatedTarget).data('id');

		//populate the textbox		
		$.ajax({
		  dataType: "json",
		  type: 'POST',
		  data: {id:id},
		  url: "<?php echo site_url(); ?>Aset/detailAsset",
		  success: function( response ) {
			//alert(JSON.stringify(response.description));
			$('#asset_id').val(response.id);
			$('#vasset_number').val(response.asset_number);
			$('#vdescription').val(response.description);
			$('#vmerk').val(response.merk);
			$('#vserial_number').val(response.serial_number);
			$('#vtgl_perolehan').val(response.tgl_perolehan);
			$('#vjenis').val(response.kd_brg);
			$('#vjenistxt').val(response.ur_sskel);
			$('#kondisi_lama').val(response.kondisi);
			$('#vkondisi_lama').val(response.kondisi);
			$('#pengguna_lama').val(response.pengguna_nama);
			$('#nip_lama').val(response.pengguna_id);
			$('#unit_lama').val(response.unit);
			$('#id_unit_lama').val(response.unit_id);
			$('#lokasi_lama').val(response.lokasi);
			$('#pengguna_baru').val("");
			$('#unit_baru').val("");
			$('#lokasi_baru').val("");
			$('#kondisi_baru').val("");
			$('#no_bast').val("");
			$('#tgl_mutasi').val("");
		  }
		});		
		$('#no_bast').focus();
	});
})

function ajaxJenis(id){
	$.ajax({
		  dataType: "json",
		  data: {id:id},
		  type: "POST",
		  url: "<?php echo site_url(); ?>aset/get_select_jenis/",
		  success: function( response ) {
			//alert(JSON.stringify(response));
			$('#jenis').find('option').remove().end().append('<option value="">-Pilih Jenis-</option>')
			.val('');
			$.each(response, function(key,value) {   
				//alert(value.kd_brg);
				$('#jenis').append($("<option value='"+value.kd_brg+"'>"+value.ur_sskel+"</option>"));
			});
		  }
		});		
		$('#no_bast').focus();
}
</script>
<section class="content" style="width:97%;margin:0 auto">
	<div class="row">		
		<div class="tab-content">			
				<div class="panel panel-default">
					<div class="panel-body">
						<div class="row">
						  <div class="col-xs-9" id="alertMsg">	
								<?php echo $this->session->flashdata('alert_msg'); ?>
						  </div>
						  <div class="col-xs-3" align="right">
							<div class="input-group">
							  <span class="input-group-btn">
								<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> Tambah Aset</i> </button>
							  </span>
							</div><!-- /input-group --> 
							<br/> 
							<br/> 
						  </div>
						</div>
						<table id="example" class="display" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>Tgl.Perolehan</th>
											<th>Nomor Aset</th>
											<th>Deskripsi</th>
											<th>Jenis</th>
											<th>Merk</th>
											<th>Serial Number</th>
											<th>Kondisi</th>
											<th>Aksi</th>
											<th>Mutasi</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>Tgl.Perolehan</th>
											<th>Nomor Aset</th>
											<th>Deskripsi</th>
											<th>Jenis</th>
											<th>Merk</th>
											<th>Serial Number</th>
											<th>Kondisi</th>
											<th>Aksi</th>
											<th>Mutasi</th>
										</tr>
									</tfoot>
									<tbody>
										<?php
										if ($data_aset!="") {
											foreach($data_aset as $row){
											?>
											<tr>
												<td><?php echo $row->tgl_perolehan;?></td>
												<td><?php echo $row->asset_number;?></td>
												<td><?php echo $row->description;?></td>
												<td><?php echo $row->jenis;?></td>
												<td><?php echo $row->merk;?></td>
												<td><?php echo $row->serial_number;?></td>
												<td><?php echo $row->kondisi;?></td>
												<td>
													<center>
													<a href="<?php echo site_url("aset/deleteAset/".$row->id);?>" type="button" class="btn btn-primary btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>
													</center>
												</td>
												<td>
													<center>
													<button type="button" id="mutasiBtn" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#mutasiModal" data-id="<?php echo $row->id;?>" title="Mutasi"><i class="fa fa-street-view"></i></button>
													</center>
												</td>
											</tr>
											<?php } 
											}
											?>
									</tbody>
								</table>
					</div><!-- end panel body -->
				</div><!-- end panel info-->
				
					  <!-- Modal Insert-->
					  <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
						<div class="modal-dialog modal-default">

						  <?php echo form_open(site_url('aset/insertAsset'), array('id' => 'formAdd'));?>
						  <!-- Modal content-->
						  <div class="modal-content">
							<div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal">&times;</button>
							  <h4 class="modal-title">Entry Data Aset</h4>
							</div>
							<div class="modal-body">
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Nomor Aset</p>
								<div class="col-sm-6">
								  <input type="text" class="form-control" name="asset_number" id="asset_number" required>
								</div>
							  </div>
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Deskripsi</p>
								<div class="col-sm-6">
								  <input type="text" class="form-control" name="description" id="description" required>
								</div>
							  </div>
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Kelompok Aset</p>
								<div class="col-sm-6">
									<select name="skel" id="skel" class="form-control select2" onchange="ajaxJenis(this.value)" style="width: 100%">
										<option value="">-Pilih Kelompok-</option>
										<?php 
										foreach($skel as $row){
											echo '<option value="'.$row->kd_skelbrg.'">'.$row->kd_skelbrg.' - '.$row->ur_skel.'</option>';
										}
										?>
									</select>
								</div>
							  </div>
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Jenis</p>
								<div class="col-sm-6">
									<select name="jenis" id="jenis" class="form-control select2" style="width: 100%">
										<option value="">-Pilih Jenis-</option>
									</select>
								</div>
							  </div>
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Merk</p>
								<div class="col-sm-6">
								  <input type="text" class="form-control" name="merk" id="merk" required>
								</div>
							  </div>
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Serial Number</p>
								<div class="col-sm-6">
								  <input type="text" class="form-control" name="serial_number" id="serial_number" required>
								</div>
							  </div>
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Kondisi</p>
								<div class="col-sm-6">
								  <select  class="form-control" style="width: 100%" name="kondisi" id="kondisi" required >
									<option value="">-Pilih Kondisi-</option>
									<option value="BAIK">BAIK</option>
									<option value="RUSAK">RUSAK</option>
									<option value="HILANG">HILANG</option>
								</select>
								</div>
							  </div>							  
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Tgl Perolehan</p>
								<div class="col-sm-6">
								  <input type="text" class="form-control datepicker" name="tgl_perolehan" id="tgl_perolehan" required>
								</div>
							  </div>
							</div>
							<div class="modal-footer">
							  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
							  <button class="btn btn-primary" type="submit">Simpan</button>
							</div>
					  
					  <?php echo form_close();?>
						  </div>
						</div>
					  </div>
					  
					  <!-- Modal Insert-->
					  <div class="modal fade" id="mutasiModal" role="dialog" data-backdrop="static" data-keyboard="false">
						<div class="modal-dialog modal-default">

						  <?php echo form_open(site_url('aset/mutasiAsset'));?>
						  <!-- Modal content-->
						  <div class="modal-content">
							<div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal">&times;</button>
							  <h4 class="modal-title">Mutasi Aset</h4>
							</div>
							<div class="modal-body">
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Nomor Aset</p>
								<div class="col-sm-6">
								  <input type="hidden" class="form-control" name="asset_id" id="asset_id">
								  <input type="text" class="form-control" name="vasset_number" id="vasset_number" readonly="readonly" >
								</div>
							  </div>
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Deskripsi</p>
								<div class="col-sm-6">
								  <input type="text" class="form-control" name="vdescription" id="vdescription" disabled="disabled">
								</div>
							  </div>
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Jenis</p>
								<div class="col-sm-6">
								  <input type="text" class="form-control" name="vjenistxt" id="vjenistxt" disabled="disabled">
								  <input type="hidden" id="vjenis" name="vjenis">
								</div>
							  </div>
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Merk</p>
								<div class="col-sm-6">
								  <input type="text" class="form-control" name="vmerk" id="vmerk" readonly="readonly">
								</div>
							  </div>
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Serial Number</p>
								<div class="col-sm-6">
								  <input type="text" class="form-control" name="vserial_number" id="vserial_number" readonly="readonly">
								</div>
							  </div>
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Tgl Perolehan</p>
								<div class="col-sm-6">
								  <input type="text" class="form-control" name="vtgl_perolehan" id="vtgl_perolehan" readonly="readonly">
								</div>
							  </div>	
							  <hr/>
							  <div class="form-group row">
								<div class="col-sm-2 form-control-label">No. BAST</div>
								<div class="col-sm-4">
								  <input type="text" class="form-control" name="no_bast" id="no_bast">
								</div>
								<div class="col-sm-2 form-control-label">Tgl Mutasi</div>
								<div class="col-sm-4">
								  <input type="text" class="form-control datepicker" name="tgl_mutasi" id="tgl_mutasi">
								</div>
							  </div>	
							  <div class="form-group row">
								<div class="col-sm-2 form-control-label">Kondisi</div>
								<div class="col-sm-4">
								  <select  class="form-control" style="width: 100%" name="vkondisi_lama" id="vkondisi_lama" disabled="disabled">
									<option value="">-Pilih Kondisi-</option>
									<option value="BAIK">BAIK</option>
									<option value="RUSAK">RUSAK</option>
									<option value="HILANG">HILANG</option>
								  </select>
								  <input type="hidden" id="kondisi_lama" name="kondisi_lama" value="">
								</div>
								<div class="col-sm-2 form-control-label">Kondisi Baru</div>
								<div class="col-sm-4">
								  <select  class="form-control" style="width: 100%" name="kondisi_baru" id="kondisi_baru" required >
									<option value="">-Pilih Kondisi-</option>
									<option value="BAIK">BAIK</option>
									<option value="RUSAK">RUSAK</option>
									<option value="HILANG">HILANG</option>
								  </select>
								</div>
							  </div>	
							  <div class="form-group row">
								<div class="col-sm-2 form-control-label">Pemegang Lama</div>
								<div class="col-sm-4">
								  <input type="text" class="form-control" name="pengguna_lama" id="pengguna_lama" readonly="readonly">
								  <input type="hidden" name="nip_lama" id="nip_lama">
								</div>
								<div class="col-sm-2 form-control-label">Pemegang Baru</div>
								<div class="col-sm-4">
								  <input type="text" class="form-control" name="pengguna_baru" id="pengguna_baru" required>
								  <input type="hidden" name="nip_baru" id="nip_baru">
								</div>
							  </div>	
							  <div class="form-group row">
								<div class="col-sm-2 form-control-label">Unit Lama</div>
								<div class="col-sm-4">
								  <input type="text" class="form-control" name="unit_lama" id="unit_lama" readonly = "readonly">
								  <input type="hidden" name="id_unit_lama" id="id_unit_lama">
								</div>
								<div class="col-sm-2 form-control-label">Unit Baru</div>
								<div class="col-sm-4">
								  <input type="text" class="form-control" name="unit_baru" id="unit_baru" readonly="readonly">
								  <input type="hidden" name="id_unit_baru" id="id_unit_baru">
								</div>
							  </div>		
							  <div class="form-group row">
								<div class="col-sm-2 form-control-label">Lokasi Lama</div>
								<div class="col-sm-4">
								  <input type="text" class="form-control" name="lokasi_lama" id="lokasi_lama" readonly = "readonly">
								</div>
								<div class="col-sm-2 form-control-label">Lokasi Baru</div>
								<div class="col-sm-4">
								  <input type="text" class="form-control" name="lokasi_baru" id="lokasi_baru">
								</div>
							  </div>					  
							</div>
							<div class="modal-footer">
							  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
							  <button class="btn btn-primary" type="submit">Simpan</button>
							</div>
					  
					  <?php echo form_close();?>
						  </div>
						</div>
					  </div>
		</div><!-- end tab content -->
			
	</div><!--- end row --->
</section>
	
<?php
	$this->load->view('layout/footer.php');
?>