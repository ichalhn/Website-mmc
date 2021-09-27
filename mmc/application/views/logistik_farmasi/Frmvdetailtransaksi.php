<?php
	$this->load->view('layout/header.php');
	$i=1;
?>
<script src="<?php echo site_url('asset/plugins/jquery-ui.min.js'); ?>"></script>
<style type="text/css">
    .ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight {
        border: 1px solid #dad55e;
        background: #fffa90;
        color: #777620;
        font-weight: normal;
    }
    .ui-widget-content {
        font-size: 15px;
    }
    .ui-widget-content .ui-state-active {
        font-size: 15px;
    }
    .ui-autocomplete-loading {
        background: white url("<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>") right 10px center no-repeat;
    }
    .ui-autocomplete { max-height: 270px; overflow-y: scroll; overflow-x: scroll;}
</style>
<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2({
            placeholder: "Select an option"
        });

    $('#date_picker').datepicker({
        format: "yyyy-mm-dd",
        endDate: '0',
        autoclose: true,
        todayHighlight: true
    });
});

$(function() {
    $("#jml_kemasan").change(function(){
        var jml = $("#jml_kemasan").val();
        var harga = $("#biaya_obat").val();

        total = parseFloat(harga)/ parseFloat(jml);
        $("#hargak").val(total.toFixed(0));
    });

    $("#cari_obat").autocomplete({
        minLength: 2,
        source : function( request, response ) {
            $.ajax({
                url: '<?php echo site_url('logistik_farmasi/Frmcpo/cari_data_obat_new')?>',
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {
                    if(!data.length){
                        var result = [{
                            label: 'Data tidak ditemukan',
                            value: response.term
                        }];
                        response(result);
                    } else {
                        response(data);
                    }
                }
            });
        },
        minLength: 1,
        select: function (event, ui) {
            $('#cari_obat').val(ui.item.value);
            $("#id_obat").val(ui.item.idobat);
            $('#biaya_obat').val(ui.item.harga_po);
            $('#biaya_obat_hide').val(ui.item.harga_po);
            $('#qty').val('1');
            set_total() ;

            $('#biaya_obat').focus();

            //alert(ui.item.harga_po);
        }
    }).on("focus", function () {
        $(this).autocomplete("search", $(this).val());
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
		url:"<?php echo base_url('logistik_farmasi/Frmcpembelian/get_biaya_obat')?>",
		data: {
			idobat: idobat
		},
		success: function(data){
			//alert(data);
			$('#biaya_obat').val(data);
			$('#biaya_obat_hide').val(data);
			$('#qty').val('1');
			set_total() ;

            $('#biaya_obat').focus();
		},
		error: function(){
			alert("error");
		}
    });
}



function set_total() {
	var biaya_obat = $('input[name=biaya_obat]').val();
	var qty_obat = $('input[name=qty]').val();
	var ttl = biaya_obat * qty_obat;
	/*var total =ttl+(ttl*0.1);

	$('#vtot_x').val(total);
	$('#vtot_x_hide').val(total);*/

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
		//url:"//echo base_url('farmasi/Frmcpembelian/get_biaya_obat')?>",
		data: {
			idobat: "//echo $id_obat ?>",
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
                                     <p class="col-sm-2 form-control-label">Nama Obat</p>
                                     <div class="col-sm-10">
                                         <input type="search" class="form-control" id="cari_obat" name="cari_obat" placeholder="Pencarian Obat">
                                         <input type="hidden" name="id_obat" id="id_obat">
                                     </div>
                                 </div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Obat</p>
									<div class="col-sm-2">
										<input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>" name="biaya_obat" id="biaya_obat" onkeypress="set_total(this.value)">
										<input type="hidden" class="form-control" value="" name="biaya_obat_hide" id="biaya_obat_hide">
									</div>
								</div>
								<div class="form-group row" style="display: none">
									<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">PPN</p>
									<div class="col-sm-2">
										<input type="text" class="form-control" value="10%" name="" id="" disabled>
										<input type="hidden" class="form-control" value="" name="" id="">
									</div>
								</div>
                                 <div class="form-group row">
                                     <p class="col-sm-2 form-control-label" id="lbl_qtyind">Jumlah PO</p>
                                     <div class="col-sm-2">
                                         <input type="number" class="form-control" name="qty" id="qty" min=1 onchange="set_total(this.value)">
                                     </div>
                                 </div>
                                 <div class="form-group row">
                                     <p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Satuan Besar PO</p>
                                     <div class="col-sm-3">
                                         <select id="satuanbesar" class="form-control select2" name="satuanbesar">
                                             <option value="">-Satuan Besar-</option>
                                             <?php
                                             foreach ($obat_satuan as $row) {
                                                 echo "<option value='".$row->id_satuan."'>".$row->nm_satuan."</option>";
                                             }
                                             ?>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group row">
                                     <p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Jumlah Kemasan</p>
                                     <div class="col-sm-2">
                                         <input type="number" class="form-control" name="jml_kemasan" id="jml_kemasan" min=1 >
                                     </div>
                                 </div>
                                 <div class="form-group row">
                                     <p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Satuan Kemasan (item)</p>
                                     <div class="col-sm-3">
                                         <select id="satuankecil" class="form-control select2" name="satuankecil">
                                             <option value="">-Satuan Kecil-</option>
                                             <?php
                                             foreach ($obat_satuan as $row) {
                                                 echo "<option value='".$row->id_satuan."'>".$row->nm_satuan."</option>";
                                             }
                                             ?>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="form-group row">
                                     <p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Satuan</p>
                                     <div class="col-sm-2">
                                         <input type="text" class="form-control" name="hargak" id="hargak">
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
          								<input type="text" class="form-control" name="batch_no" id="batch_no">
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
                    <th>Batch No</th>
                    <th>Harga Obat</th>
                    <th>Harga PO</th>
                    <th>Qty</th>
					<th>Total</th>
					<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
									// print_r($pasien_daftar);
                                $new_faktur = str_replace("/", "-", $no_faktur);
									$ppn=10; $ttot = 0;
										foreach($data_receiving_item as $row){
										    $ttot += $row->item_cost_price;
										//$id_pelayanan_poli=$row->id_pelayanan_poli;
									?>
										<tr>
											<td><?php echo $i++ ; ?></td>
											<td><?php echo $row->description ; ?></td>
                                            <td align="center"><?php echo $row->batch_no ?></td>
                                            <td align="right"><?php echo number_format($row->item_unit_price, '0',',', '.'); ?></td>
                                            <td align="right"><?php echo number_format($row->harga_po, '0',',', '.'); ?></td>
                                            <td align="right"><?php echo number_format($row->quantity_purchased, '0',',', '.'); ?></td>
                                            <td align="right"><?php echo number_format($row->item_cost_price, '0',',', '.'); ?></td>
											<td><a href="<?php echo site_url("logistik_farmasi/Frmcpembelian/hapus_data_receiving/".$row->receiving_id."/".$row->item_id."/".$new_faktur."/".$row->batch_no);?>" class="btn btn-danger btn-xs">Hapus</a></td>

										</tr>
									<?php
										}
									?>
							</tbody>
						</table>

				</div>
                    <div class="col-sm-6">
                        <h3>Total Pembelian:</h3>
                    </div>
                    <div class="col-sm-6" align="right">
                        <h3>Rp. <?=number_format($ttot, '2', ',', '.')?></h3>
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
