<?php
	$this->load->view('layout/header.php');
?>
<html>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#example').DataTable();
	$('#tabel_diagnosa').DataTable();
	$(".select2").select2();
	$('.auto_diagnosa_pasien').autocomplete({
		serviceUrl: site+'iri/ricstatus/data_icd_1',
		onSelect: function (suggestion) {
			$('#id_diagnosa').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
			$('#diagnosa').val(''+suggestion.id_icd+'@'+suggestion.nm_diagnosa);
		}
	});
} );
//---------------------------------------------------------

$(function() {
	$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});  
			
});
</script>

<?php echo $this->session->flashdata('success_msg'); ?>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-body">
				
					<div style="display:block;overflow:auto;">
						<table class="table">
						  <tbody>
							<tr>
								<th>No CM</th>
								<td>:</td>
								<td><?php echo $data_pasien_daftar_ulang->no_medrec;?></td>
								<th>Nama</th>
								<td>:</td>
								<td><?php echo $data_pasien_daftar_ulang->nama;?></td>
							</tr>
							<tr>
								<th>No. Register</th>
								<td>:</td>
								<td><?php echo $data_pasien_daftar_ulang->no_register;?></td>
								<th>Tanggal Kunjungan</th>
								<td>:</td>
								<td><?php echo $data_pasien_daftar_ulang->tgl_kunjungan;?></td>
							</tr>
						  </tbody>
						</table>
						
					</div><!-- style overflow -->
					
					<div class="well" >
						<!-- form -->
						<?php echo form_open('irj/rjcmedrec/insert_diagnosa'); ?>
						
						<div class="form-group row">
											<p class="col-sm-2 form-control-label" id="lbl_diagnosa">Diagnosa *</p>
											<div class="col-sm-10">
												<div class="form-group">
													<input type="text" class="form-control input-sm auto_diagnosa_pasien"  name="id_diagnosa" id="id_diagnosa" required style="width:400px;font-size:15px;">
													<input type="hidden" class="form-control " name="diagnosa" id="diagnosa" >	
												</div>
											</div>
										</div>
						<div class="form-group row">
							<p class="col-sm-2 form-control-label" id="lbl_klasifikasi_diagnos">Klasifikasi *</p>
							<div class="col-sm-10">
								<!--<input type="text" class="form-control" value="" name="klasifikasi_diagnos">-->
								<div class="form-inline">
										<div class="form-group">
											<select id="prop" class="form-control" name="klasifikasi_diagnos" required>
											<option value="">-Pilih Klasifikasi-</option>
											<option value="utama" SELECTED>utama</option>';
											<option value="tambahan">tambahan</option>';
											</select>
										</div>
									</div>
							</div>
						</div>
						<div class="form-inline" align="right">
							<input type="hidden" name="no_register" value="<?php echo $data_pasien_daftar_ulang->no_register ?>">
							<div class="form-group">
								<button type="reset" class="btn btn-primary">Reset</button>
								<button type="submit" class="btn btn-primary">Simpan</button>
							</div>
						</div>
					<?php echo form_close();?>
					</div>

				</div>
			</div>
									
			<!-- table -->
			<div style="display:block;overflow:auto;">
				<table id="tabel_diagnosa" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
						  <th>No</th>
						  <th>Tanggal Kunjungan</th>
						  <th>Diagnosa</th>
						  <th>Klasifikasi Diagnosa</th>
						  <th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// print_r($pasien_daftar);
						$i=1;
						foreach($data_diagnosa_pasien as $row){
							$id_diagnosa_pasien=$row->id_diagnosa_pasien;
						?>
						<tr>
							<td><?php echo $i++ ; ?></td>
							<td><?php echo $row->tgl_kunjungan; ?></td>
							<td><?php echo $row->id_diagnosa.' - '.$row->diagnosa; ?></td>
							<td><?php echo $row->klasifikasi_diagnos; ?></td>
							<td>
								<!-- Button trigger modal -->
								<?php //echo '<a data-toggle="modal" data-id="" title="Add this item" class="open-form-edit btn btn-danger btn-xs" href="#form-edit" onclick="data_edit(\''.$row->diagnosa.'\',\''.$row->id_diagnosa.'\',\''.$row->klasifikasi_diagnos.'\',\''.$row->id_diagnosa_pasien.'\')">Hapus</a>';?>
								<a href="<?php echo site_url('irj/rjcmedrec/hapus_diagnosa/'.$data_pasien_daftar_ulang->no_register.'/'.$id_diagnosa_pasien); ?>" class="btn btn-danger btn-xs">Hapus</a>
							</td>
						</tr>
						<?php
							}
						?>
					</tbody>
				</table>
			</div><!-- style overflow -->
		</div>
		<?php
		//echo $this->session->flashdata('message_nodata'); 
		?>								
	</div>
</section>
<?php
	$this->load->view('layout/footer.php');
?>