<?php
	$this->load->view('layout/header.php');
	$i=1;
?>
<html>

<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2({
            placeholder: "Select an option"
        });
});

$(function() {
  $('#date_picker').datepicker({
      format: "yyyy-mm-dd",
      
      autoclose: true,
      todayHighlight: true,
    });  
  	
  });
  
</script>
<script type="text/javascript">

//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#tabel_receiving').DataTable();
} );
//---------------------------------------------------------

var site = "<?php echo site_url();?>";

function pilih_tindakan(idobat) {
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('logistik_farmasi/Frmcpo/get_satuan_obat')?>" + "/" + idobat,
		data: {
			idobat: idobat
		},
		success: function(data){
			//alert(data);
			$('#satuank').val(data);
			$('#satuank_hide').val(data);
			$('#qty').val('1');
			
		},
		error: function(){
			alert("error");
		}
    });
}


function reset() {
	document.getElementById("insert").reset();
	$('#idobat').select2('data', '').change();
	$('#idobat').select2('val','').change();
	$('#idobat').empty().trigger('change');

}

</script>
<section class="content-header">
	<?php echo $this->session->flashdata('success_msg');?>
</section>
<?php
include('Frmvheaderpo.php');
?>
<section class="content" style="width:97%;margin:0 auto">
 <div class="row">

  <div class="tab-content">
    <div class="panel panel-info">
     <div class="panel-body">
     <?php echo form_open('logistik_farmasi/Frmcpo/insert_po'); ?>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label " id="tindakan">Obat</p>
										<div class="col-sm-10">
											<div class="form-inline">
												<div class="form-group">
													<select id="idobat" class="form-control js-example-basic-single" name="idobat" onchange="pilih_tindakan(this.value)" required>
														<option value="">-Pilih Obat-</option>
														<?php
															foreach($data_obat as $row){
																echo '<option value="'.$row->id_obat.'">'.$row->nm_obat.'</option>';
															}
														?>
													</select>
												</div>
											</div>
										</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_satuan">Satuan</p>
									<div class="col-sm-2">
										<input type="text" class="form-control" value="<?php //echo $satuank ?>" name="satuank" id="satuank" onchange="pilih_tindakan(this.value)" disabled=''>
										<input type="hidden" class="form-control" value="" name="satuank_hide" id="satuank_hide">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qtyind">Quantity</p>
									<div class="col-sm-2">
										<input type="number" class="form-control" name="qty" id="qty" min=1>
									</div>
								</div>
								<div class="form-group">
									<button type="reset" class="btn bg-orange" onclick="reset()" value="Reset Form">Reset</button>
									<button type="submit" class="btn btn-primary">Simpan</button>
								</div>
			</div>
							<div class="form-inline" align="right">
								<input type="hidden" class="form-control" value="<?php echo $id_po;?>" name="id_po">
								<input type="hidden" class="form-control" value="<?php echo $no_po;?>" name="no_po">
								<input type="hidden" class="form-control" value="<?php echo $i;?>" name="line">
								<input type="hidden" class="form-control" value="<?php echo $tgl_po;?>" name="tgl_po">
								<input type="hidden" class="form-control" value="<?php echo $supplier_id;?>" name="person_id">
								<input type="hidden" class="form-control" value="<?php echo $sumber_dana;?>" name="sumber_dana">
								<input type="hidden" class="form-control" value="<?php echo $gudang;?>" name="gudang">
 							</div>
		     </div>
							<?php echo form_close();?>
     </div><!-- end panel body -->
   </div><!-- end div id home -->
  
   
    <div class="panel panel-info">
     <div class="panel-body">
    			<div class="form-group row">
    			<div class="col-sm-12">
						<table id="tabel_receiving" class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
					<th>No</th>
					<th>Item Obat</th>
					<th>Qty</th>
					<th>Satuan</th>
					<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
									// print_r($pasien_daftar);
									$ppn=10;
										foreach($data_po_item as $row){
										//$id_pelayanan_poli=$row->id_pelayanan_poli;
									?>
										<tr>
											<td><?php echo $i++ ; ?></td>
											<td><?php echo $row->description ; ?></td>
											<td><?php echo $row->qty ; ?></td>
											<td><?php echo $row->satuank ; ?></td>
											<td><a href="<?php echo site_url("logistik_farmasi/Frmcpo/hapus_data_po/".$row->id_po."/".$row->item_id."/".$no_po);?>" class="btn btn-danger btn-xs">Hapus</a></td>

										</tr>
									<?php
										}
									?>
							</tbody>
						</table>

				</div>
				</div>

	
   </div>
  </div>
	<?php
echo form_open('logistik_farmasi/Frmcpo/faktur_po');?>

		<div class="form-inline" align="right">
	<div class="input-group">
			<div class="form-group">
				<button class="btn btn-primary">Selesai & Cetak</button>
				<input type="hidden" name="faktur_hidden" value="<?php echo $no_po ; ?>"></input>
			</div>
		</div>
	</div>
	<?php
	echo form_close();
	 ?>
 </div>

 </section>
						</div>
						<br>
					</div>

		</section>
<?php
	$this->load->view('layout/footer.php');
?>
