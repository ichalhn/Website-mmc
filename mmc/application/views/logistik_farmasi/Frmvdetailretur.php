<?php
	$this->load->view('layout/header.php');
	$i=1;
?>
<html>

<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2();
});

$(function() {
  $('#date_picker').datepicker({
      format: "yyyy-mm-dd",
      
      autoclose: true,
      todayHighlight: true,
    });  
  	
  });
  
	function retur(receiving_id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('logistik_farmasi/Frmcretur/get_data_detail_retur')?>",
      data: {
        receiving_id : receiving_id
      },
      success: function(data){
        $('#edit_id_obat').val(data[0].description);
        $('#edit_qty').val(data[0].quantity_purchased);
        alert(data);
      },
      error: function(){
        alert("error");
      }
    });
  } 
</script>

<script type="text/javascript">

//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#tabel_receiving').DataTable();
} );
//---------------------------------------------------------

var site = "<?php echo site_url();?>";

</script>
<section class="content-header">
	<?php echo $this->session->flashdata('success_msg');?>
</section>

<section class="content" style="width:97%;margin:0 auto">
 <div class="row">
  <div class="tab-content">
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
										foreach($receiving as $row){
										//$id_pelayanan_poli=$row->id_pelayanan_poli;
									?>
										<tr>
											<td><?php echo $i++ ; ?></td>
											<td><?php echo $row->description ; ?></td>
											<td><?php echo $row->item_unit_price; ?></td>
											<td><?php echo $ppn ?></td>
											<td><?php echo $row->quantity_purchased ; ?></td>
											<td><?php echo $row->item_cost_price; ?></td>
											<td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#retur" onclick="retur('<?php echo $row->receiving_id;?>')">Retur</button>  </td>
										</tr>
									<?php
										}
									?>
							</tbody>
						</table>
						<?php
						//echo $this->session->flashdata('message_nodata'); 
					?>
					 <div class="modal fade" id="retur" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">
		<?php
				echo form_open('logistik_farmasi/Frmcretur/selesai_retur');?>
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Detail Barang Retur</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id Obat</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_id_obat" id="edit_id_obat" disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Quantity</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_qty" id="edit_qty">
                    </div>
                  </div>
                  
                    </div>
                  </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-default" data-dismiss="modal">Submit</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>								
		<?php
		echo form_close();
		 ?>
	</div>
   </div>
  </div>
	<?php
echo form_open('logistik_farmasi/Frmcretur/cetak_faktur_retur');?>

		<div class="form-inline" align="right">
	<div class="input-group">
			<div class="form-group">
				<button class="btn btn-primary">Selesai & Cetak</button>
				
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
