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
					<div class="panel-heading" align="center">Rekap Biaya</div>
					<div class="panel-body">
						<br/>
						<div style="display:block;overflow:auto;">
							<table class="table">
							  <tbody>
								<tr>
									<th>No Faktur</th>
									<td>:</td>
									<td><?php echo $no_faktur;?></td>
									<th>Tanggal Permintaan</th>
									<td>:</td>
									<td><?php echo $receiving_time;?></td>
								</tr>
								<tr>
									<th>Receiving Id</th>
									<td>:</td>
									<td><?php echo $id_receiving;?></td>

								</tr>
								<tr>
									<th>Nama Supplier</th>
									<td>:</td>
									<td><?php echo $company_name->company_name;?></td>
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
								  <th>Harga</th>
								  <th>Banyak</th>
								  <th>Total</th>
								</tr>
							  </thead>
							  <tbody>
									<?php
										$i=1;
										$jumlah_vtot=0;
										foreach($receiving_item as $row){
									?>
										<tr>
										  <td><?php echo $i++;?></td>
										  <td><?php echo $row->description; ?></td>
										  <td><?php echo $row->item_unit_price; ?></td>
										  <td><?php echo $row->quantity_purchased;?></td>
										  <td>Rp <div class="pull-right"><?php echo number_format( $row->item_cost_price, 2 , ',' , '.' );
										  			$jumlah_vtot=$jumlah_vtot+$row->item_cost_price?>
										  	</div>
										  </td>
										</tr>
									<?php
										}
									?>
								
									<tr>
									  <th colspan="4">Total</th>
									  <th>Rp <div class="pull-right"><?php echo number_format( $jumlah_vtot, 2 , ',' , '.' );?></div></th>
									</tr>
								</tbody>
							</table>
							
						</div><!-- style overflow -->
						
						
				<div class="form-inline row" align="right" style="margin-right:10px;">
						
				<div class="input-group"><span class="input-group-addon">Rp</span>								
					<input type="text" class="form-control" placeholder="Diskon" name="diskon" id="diskon">				
					
					<span class="input-group-btn">
						<button type="btn" class="btn btn-primary" onclick="setTotakhir()">Input</button>
					</span>
				
				</div>	
					
				</div><br>
	
				<div class="form-group row ">
					<p class="col-lg-offset-4 col-sm-4 form-control-label" align="right" style="margin-top:7px;">Total Biaya setelah diskon : </p>
					<div class="col-sm-4 pull-right" style="width:29%;">
						<div class="input-group">
						<span class="input-group-addon">Rp</span>
							<input type="text" class="form-control" placeholder="0" name="totakhir" id="totakhir" disabled>
						</span>
						</div>
					</div>
				</div><br>


			<?php echo form_open('logistik_farmasi/Frmcpembelian/cetak_faktur');?>
		
		<div class="form-inline row" align="right" style="margin-right:10px;">
					
			<div class="input-group">			
				
				<input type="hidden" class="form-control" name="pilih" value="0" >
				<input type="hidden" class="form-control" name="totakhir_hide" id="totakhir_hide" >
				<input type="hidden" class="form-control" name="totakhir" value="<?php //echo $totakhir ?>">
				<input type="hidden" class="form-control" name="diskon" value="<?php //echo $diskon ?>">
				<input type="hidden" class="form-control" name="pilih" value="detail" >
				<input type="hidden" class="form-control" name="penyetor_hide" id="penyetor_hide">
				<input type="hidden" class="form-control" name="faktur_hidden" id="faktur_hidden" value="<?php echo $no_faktur ?>">
				<input type="hidden" class="form-control" name="jumlah_vtot" value="<?php echo $jumlah_vtot ?>">
				
				<span class="input-group-btn">

				<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">	
				<input type="hidden" class="form-control" name="diskon_hide" id="diskon_hide">
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

<script type='text/javascript'>	
var site = "<?php echo site_url();?>";
$(document).ready(function() {
	$("#totakhir").maskMoney({thousands:',', decimal:'.', affixesStay: true});
    	$("#diskon").maskMoney({thousands:',', decimal:'.', affixesStay: true});
    });

function setTotakhir(){
	var num = $('#diskon').maskMoney('unmasked')[0]; 
	$('#diskon_hide').val(num);
	$('#diskon_hide_2').val(num);	
	var total = "<?php echo $jumlah_vtot; ?>";	
	if(total-num>=0){
		$('#totakhir').val(total-num);
		$("#totakhir").maskMoney('mask');
		$('#totakhir_hide').val(total-num);
	}
	else
		alert("Diskon melebihi biaya total !");
}

function penyetorDetail(){ 
	var num = $('#penyetor').val(); 
	$('#penyetor_hide').val(num); 
}
</script>

<?php
	$this->load->view('layout/footer.php');
?>