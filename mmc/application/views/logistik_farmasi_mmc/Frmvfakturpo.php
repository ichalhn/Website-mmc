<?php
	$this->load->view('layout/header.php');
?>

<?php echo $this->session->flashdata('message_no_tindakan'); ?>


<script type='text/javascript'>
	$(function() {
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});  
	});
</script>

	<div class="container-fluid">
		<section class="content-header">
		</section>
		<section class="content">
			<div class="row">
				<div class="panel panel-default">
					<div class="panel-heading" align="center">Rekap PO</div>
					<div class="panel-body">
						<br/>
						<div style="display:block;overflow:auto;">
							<table class="table">
							  <tbody>
								<tr>
									<th>No PO</th>
									<td>:</td>
									<td><?php echo $no_po;?></td>
									<th>Tanggal Permintaan</th>
									<td>:</td>
									<td><?php echo $tgl_po;?></td>
								</tr>
								<tr>
									<th>Id PO</th>
									<td>:</td>
									<td><?php echo $id_po;?></td>

								</tr>
								<tr>
									<th>Nama Supplier</th>
									<td>:</td>
									<td><?php echo $company_name;?></td>
									<th>Id Supplier</th>
									<td>:</td>
									<td><?php echo $supplier_id;?></td>
									<th></th>
									<td></td>
									<td></td>
								</tr>
								
							  </tbody>
							</table>
						
							<table class="table table-hover table-striped table-bordered">
							  <thead>
								<tr>
								  <th>No</th>
								  <th>Nama Obat</th>
								  <th>Banyak</th>
								</tr>
							  </thead>
							  <tbody>
									<?php
										$i=1;
										foreach($po_item as $row){
									?>
										<tr>
										  <td><?php echo $i++;?></td>
										  <td><?php echo $row->description; ?></td>
										  <td><?php echo $row->qty;?></td>
										</tr>
									<?php
										}
									?>
								
								</tbody>
							</table>
							
						</div><!-- style overflow -->
						
						


			<?php echo form_open('logistik_farmasi/Frmcpo/cetak_faktur');?>
		
		<div class="form-inline row" align="right" style="margin-right:10px;">
					
			<div class="input-group">			
				
				<input type="hidden" class="form-control" name="faktur_hidden" id="faktur_hidden" value="<?php echo $no_po ?>">
				
				<span class="input-group-btn">

				<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">	
				<button type="submit" class="btn btn-primary">Cetak</button></span>
					
			</div>			
		</div>
		<br>
		<?php echo form_close();?>
	</div>
	
	
										
						
					
					</div>
				</div>
			</div>
		</section>
	</div>

<?php
	$this->load->view('layout/footer.php');
?>