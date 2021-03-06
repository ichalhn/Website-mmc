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

    $('#sepuluh_persen').click(function(){
		$("#hidden_margin").val('0.1');
	});
	$('#nol_persen').click(function(){
		$("#hidden_margin").val('0');
	});
} );
//---------------------------------------------------------

var site = "<?php echo site_url();?>";

function pilih_tindakan(idobat) {
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('logistik_farmasi/Frmcpembelian/get_biaya_obat')?>",
		data: {
			idobat: idobat
		},
		success: function(data){
			//alert(data);
			$('#biaya_obat').val(data[0].hargabeli);
			$('#biaya_obat_hide').val(data[0].hargabeli);
			$('#satuank').val(data[0].satuank);
			$('#qty').val('0');
			set_total() ;
		},
		error: function(){
			alert("error");
		}
    });
}



function set_total() {
	var biaya_obat = $('#biaya_obat').val();
	var margin = $('#hidden_margin').val();;
	var qty_obat = $('#qty').val();
	var ttl = biaya_obat*qty_obat;
	var total =ttl+(ttl*margin);

	$('#biaya_obat_hide').val(biaya_obat);
	$('#vtot_x').val(total);
	$('#vtot_x_hide').val(total);
}

function set_total_diskon() {
	var biaya_obat = $('#vtot_x').val();
	var diskon = $('#diskon').val();
	var ttl = biaya_obat-diskon;
	// var total =ttl+(ttl*0.1);

	// $('#biaya_obat_hide').val(biaya_obat);
	$('#vtot_x').val(ttl);
	$('#vtot_x_hide').val(ttl);
}

function reset() {
	document.getElementById("insert").reset();
	$('#idobat').select2('data', '').change();
	$('#idobat').select2('val','').change();
	$('#idobat').empty().trigger('change');

}

/*function insert_total(){
	var jumlah = $('#jumlah').val();

	// bawah
	//qty di set 1 karena hasil dari perhitungan sendiri


	var val = $('select[name=idobat]').val();
	var temp = val.split("-");

	$('#biaya_obat').val(jumlah);
	$('#biaya_obat_hide').val(jumlah);
	var qty = 1;
	$('#qty').val(1)
	var total = qty * jumlah;
	$('#vtot_x').val(total);

	$.ajax({
		type:'POST',
		dataType: 'json',
		//url:"<?php echo base_url('farmasi/Frmcpembelian/get_biaya_obat')?>",
		data: {
			idobat: "<?php echo $id_obat ?>",
			qty : qty
		},
		success: function(data){
			//alert(data);
			$('#vtot_x').val(data);
			$('#vtot_x_hide').val(data);
		},
		error: function(){
			alert("error");
		}
    });
}*/


</script>
<section class="content-header">
	<?php echo $this->session->flashdata('success_msg');?>
</section>
<?php
include('Frmvdetailpembelian.php');
?>
<section class="content" style="width:97%;margin:0 auto">
 <div class="row">

  <div class="tab-content">
    <div class="panel panel-info">
     <div class="panel-body">
     <?php echo form_open('logistik_farmasi/Frmcpembelian/insert_pembelian'); ?>
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
									<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Obat</p>
									<div class="col-sm-2">
										<input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>" name="biaya_obat" id="biaya_obat" onkeypress="set_total(this.value)">
										<input type="hidden" class="form-control" value="" name="biaya_obat_hide" id="biaya_obat_hide">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">PPN</p>
									<label class="radio-inline" style="right:-15px;">
               							 <input type="radio" name="ppn" id="nol_persen" value="0" >0 %</input>
									</label>
									<label class="radio-inline" style="right:-15px;">
										<input type="radio" name="ppn" id="sepuluh_persen" value="0.1" checked>10 %</input>
									</label>
									<input type="hidden" class="form-control" value="" name="hidden_margin" id="hidden_margin" step="0.1">
									<!-- <div class="col-sm-2">
										<input type="text" class="form-control" value="10%" name="" id="" disabled>
										<input type="hidden" class="form-control" value="" name="" id="">
									</div> -->
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_satuan">Satuan</p>
									<div class="col-sm-2">
										<input type="text" class="form-control" value="<?php //echo $satuank ?>" name="satuank" id="satuank" onkeypress="set_satuan(this.value)">
										<input type="hidden" class="form-control" value="" name="satuank_hide" id="satuank_hide">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qtyind">Quantity</p>
									<div class="col-sm-2">
										<input type="number" class="form-control" name="qty" id="qty" min=1 onchange="set_total(this.value)">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_diskon">Diskon</p>
									<div class="col-sm-2">
										<input type="text" class="form-control" name="diskon" id="diskon" onchange="set_total_diskon(this.value)">
										<input type="hidden" class="form-control" name="diskon_hide" id="diskon_hide">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_vtot">Total</p>
									<div class="col-sm-2">
										<input type="text" class="form-control" name="vtot_x" id="vtot_x">
										<input type="hidden" class="form-control" name="vtot_x_hide" id="vtot_x_hide">
									</div>
								</div>
								<div class="form-group row">
        							<p class="col-sm-2 form-control-label" id="lnobatch">No Batch</p>
        							<div class="col-sm-6">
          								<input type="text" class="form-control" name="batch_no" id="batch_no" value="1">
        							</div>
      							</div>
      							<div class="form-group row">
        							<p class="col-sm-2 form-control-label" id="lexpiredate">Expire Date</p>
        							<div class="col-sm-6">
          								<input type="text" id="date_picker" class="form-control" placeholder="Expire Date" name="expire_date" required>
        							</div>
      							</div>
								<div class="form-group">
									<button type="reset" class="btn bg-orange" onclick="reset()" value="Reset Form">Reset</button>
									<button type="submit" class="btn btn-primary">Simpan</button>
								</div>
			</div>
							<div class="form-inline" align="right">
								<input type="hidden" class="form-control" value="<?php echo $id_receiving;?>" name="receiving_id">
								<input type="hidden" class="form-control" value="<?php echo $no_faktur;?>" name="no_faktur">
								<input type="hidden" class="form-control" value="" name="jenis">
								<input type="hidden" class="form-control" value="<?php echo $i;?>" name="line">
								<input type="hidden" class="form-control" value="<?php echo $receiving_time;?>" name="receiving_time">
								<input type="hidden" class="form-control" value="<?php echo $supplier_id;?>" name="person_id">
								<input type="hidden" class="form-control" value="<?php echo $payment_type;?>" name="payment_type">
								<input type="hidden" class="form-control" value="<?php echo $no_faktur;?>" name="no_faktur">
								<input type="hidden" class="form-control" value="<?php echo $total_price;?>" name="total">
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
					<th>Harga Obat</th>
					<th>PPN(%)</th>
					<th>Qty</th>
					<th>Total</th>
					<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
									// print_r($pasien_daftar);
									$ppn=10;
										foreach($data_receiving_item as $row){
										//$id_pelayanan_poli=$row->id_pelayanan_poli;
									?>
										<tr>
											<td><?php echo $i++ ; ?></td>
											<td><?php echo $row->description ; ?></td>
											<td><?php echo $row->item_unit_price; ?></td>
											<td><?php echo $ppn ?></td>
											<td><?php echo $row->quantity_purchased ; ?></td>
											<td><?php echo $row->item_cost_price; ?></td>
											<td><a href="<?php echo site_url("logistik_farmasi/Frmcpembelian/hapus_data_receiving/".$row->id_receivings_item."/".$row->item_id."/".$no_faktur);?>" class="btn btn-danger btn-xs">Hapus</a></td>

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
echo form_open('logistik_farmasi/Frmcpembelian/faktur_pembelian');?>

		<div class="form-inline" align="right">
	<div class="input-group">
			<div class="form-group">
				<button class="btn btn-primary">Selesai & Cetak</button>
				<input type="hidden" name="faktur_hidden" value="<?php echo $no_faktur ; ?>"></input>
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
