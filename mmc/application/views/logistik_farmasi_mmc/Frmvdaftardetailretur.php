<?php
  $this->load->view('layout/header.php');
?>
<html>
<script type='text/javascript'>
//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#example').DataTable();
} );
//---------------------------------------------------------
function retur_barang(){
  var total = parseInt($("#edit_quantity_purchased").val()) - parseInt($("#edit_quantity").val())  ;  
  $('#edit_stok').val(total);
  $('#edit_stok').maskMoney('mask');
  $('#edit_stok_hide').val(total);
}
function lihat_detail(batch_no, itemid) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('logistik_farmasi/Frmcretur/edit_data_retur')?>",
      data: {
        batch_no : batch_no,
        item_id : itemid
      },
      success: function(data){
        $('#edit_description').val(data[0].description);
        $('#edit_batch_no').val(data[0].batch_no);
        $('#edit_item_id').val(data[0].item_id);
        $('#edit_quantity_purchased').val(data[0].quantity_purchased);
		$('#edit_quantity').prop('min', 0);
		$('#edit_quantity').prop('max', data[0].quantity_purchased );
		
      },
      error: function(){
        alert("error");
      }
    });
  } 

  function retur_stok(batch_no) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('logistik_farmasi/Frmcretur/edit_stok')?>",
      data: {
        batch_no : batch_no
      },
      success: function(data){
        $('#edit_qty').val(data[0].qty);
      },
      error: function(){
        alert("error");
      }
    });
  } 


$(function() {
$('#date_picker').datepicker({
    format: "yyyy-mm-dd",
    endDate: '0',
    autoclose: true,
    todayHighlight: true,
  });  
    
});

var site = "<?php echo site_url();?>";
    
</script>
<section class="content-header">
  <?php
    echo $this->session->flashdata('success_msg');
  ?>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">NO FAKTUR >> <span style="color: red; "><?=$no_faktur?></span> </h3>
        </div>
        <div class="box-body">
          <table id="example" class="display" cellspacing="0" width="100%">
              <thead>
              <tr>
                <th><p align="center">No</p></th>
                <th><p align="center">Nama Barang</p></th>
                <th><p align="center">No Batch</p></th>
                <th><p align="center">Harga<br>Beli</p></th>
                <th><p align="center">Harga<br>Jual</p></th>
                <th><p align="center">Qty Beli</p></th>
                <th><p align="center">Qty<br>Item</p></th>
                <th><p align="center">Qty Retur</p></th>
                <th><p align="center">Stok</p></th>
                <th><p align="center">Aksi</p></th>
               
              </tr>
              </thead>
             <tbody>
              
              <?php
              // print_r($pasien_daftar);
                $i=1;
                foreach($retur_barang as $row){
                $qty_item = $row->qty_beli * $row->jml_kemasan;
              ?>
                <tr>
                  <td><?=$i++?></td>
                  <td><?=$row->nm_obat?></td>
                  <td><?=$row->batch_no?></td>
                  <td><div align="right"><?=number_format($row->hargabeli, '2', ',', '.')?></td>
                  <td><div align="right"><?=number_format($row->hargajual, '2', ',', '.')?></td>
                  <td><div align="right"><?=number_format($row->qty_beli, '2', ',', '.')?></td>
                  <td><div align="right"><?=number_format($qty_item, '2', ',', '.')?></td>
                  <td><div align="right"><?=number_format($row->quantity_retur, '2', ',', '.')?></td>
                  <td><div align="right"><?=number_format($row->stok, '2', ',', '.')?></td>

                  <td>
                   <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#lihatdetail" onclick="lihat_detail('<?=$row->batch_no?>', '<?=$row->item_id?>')">Retur Barang</button>
                  </td>
                </tr>
              <?php
                }
              ?>
              </tbody>
            </table>
            <br/>
            <a href="<?php echo site_url('logistik_farmasi/Frmcretur/'); ?>" class="btn btn-danger btn-sm">Kembali</a>

        <?php echo form_open('logistik_farmasi/Frmcretur/edit_data_stok');?> 
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="lihatdetail" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Detail Retur</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama Barang</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_description" id="edit_description" disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">No Batch</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_batch_no" id="edit_batch_no" readonly>
                      <input type="hidden" class="form-control" name="edit_item_id" id="edit_item_id">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Quantity Awal</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_quantity_purchased" id="edit_quantity_purchased" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" >Quantity Retur</p>
                    <div class="col-sm-6">
                      <input type="number" class="form-control" name="edit_quantity" id="edit_quantity" oninput ="retur_barang(this.value)" required>
                    </div>
                  </div>
                   <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" >Stok</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_stok" id="edit_stok" disabled="">
                      <input type="hidden" class="form-control" name="edit_stok_hide" id="edit_stok_hide">
                      <input type="hidden" class="form-control" name="edit_faktur" id="edit_faktur" value="<?php echo $no_faktur;?>">
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                <input type="hidden" class="form-control" name="receiving_id" id="receiving_id" value="<?php echo $no_faktur;?>">
                  <button type="submit" class="btn btn-primary btn-sm">Retur Barang</button>
                   <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Kembali</button>
                  
                </div>
              </div>
            </div>
          </div>  
         <?php echo form_close();?>            
        
        </div>
      </div>
    </div>
</section>
<?php
  $this->load->view('layout/footer.php');
?>