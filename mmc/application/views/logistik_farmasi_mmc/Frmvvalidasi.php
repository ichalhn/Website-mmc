<?php
  $this->load->view('layout/header.php');
?>
<script type='text/javascript'>
//-----------------------------------------------Data Table
$(document).ready(function() {
     $('#example').DataTable( {
        initComplete: function () {
            this.api().columns('.filter_gudang_asal').every( function () {
                var column = this;
                var select = $('#select_gudang_asal')
                    // .appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );

            this.api().columns('.filter_gudang_tujuan').every( function () {
                var column = this;
                var select = $('#select_gudang_tujuan')
                    // .appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    } );
} );
//---------------------------------------------------------

function validasi(id_inventory) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('logistik_farmasi/Frmcvalidasi/get_data_detail_retur')?>",
      data: {
        id_inventory : id_inventory
      },
      success: function(data){  
        $("#id_gudang_asal option").attr("disabled", false);
        $("#id_gudang_tujuan option").attr("disabled", false);
        $('#edit_batch_no_dis').val(data[0].batch_no);
        $('#edit_batch_no').val(data[0].batch_no);
        $('#id_temporary').val(data[0].id_temporary);
        $('#id_inventory').val(data[0].id_inventory);
        $('#id_obat').val(data[0].id_obat);
        $('#company_name').val(data[0].company_name);
        $('#edit_gudang_awal').val(data[0].nama_gudang_asal);
        $('#edit_gudang_tujuan').val(data[0].nama_gudang_tujuan);
        $('#hide_gudang_awal').val(data[0].id_gudang);
        $('#hide_gudang_tujuan').val(data[0].id_gudang_tujuan);
        $('#edit_description_dis').val(data[0].nm_obat);
        $('#edit_description').val(data[0].nm_obat);
        $('#edit_qty_dis').val(data[0].qty);
        $('#edit_qty').val(data[0].qty);
         $('#edit_expire_dis').val(data[0].expire_date);
         $('#edit_expire').val(data[0].expire_date);
         $("#id_gudang_asal option[value='"+data[0].id_gudang+"']").attr("disabled", true);
         $("#id_gudang_tujuan option[value='"+data[0].id_gudang_tujuan+"']").attr("disabled", true);
        //alert(data[0].id_gudang);

      },
      error: function(){
        alert("error");
      }
    });
  } 

  function detail_gudang(nm_gudang) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('logistik_farmasi/Frmcvalidasi/get_data_detail_gudang')?>",
      data: {
        nm_gudang : nm_gudang
      },
      success: function(data){    
        $('#edit_batch_no').val(data[0].batch_no);
        $('#edit_description').val(data[0].nm_obat);
        $('#edit_qty').val(data[0].qty);
        $('#edit_expire').val(data[0].expire_date);
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
          <h3 class="box-title">DAFTAR BARANG</h3>
        </div>
        
        <div class="box-body">
          <div class="form-group row">
             <p class="col-sm-2 form-control-label" id="lidgudang">Pilihan Gudang Asal</p>
             <div class="col-sm-3">
                <select name="id_gudang_asal" class="form-control js-example-basic-single" id="select_gudang_asal">
                </select>
             </div>
          </div>
          <div class="form-group row">
             <p class="col-sm-2 form-control-label" id="lidgudang">Pilihan Gudang Tujuan</p>
             <div class="col-sm-3">
                <select name="id_gudang_tujuan" class="form-control js-example-basic-single" id="select_gudang_tujuan">
                </select>
             </div>
          </div>
          <table id="example" class="display" cellspacing="0" width="100%">
              <thead>
              <tr>
                <th>No</th>
                <th class="filter_gudang_asal">Asal</th>
                <th class="filter_gudang_tujuan">Tujuan</th>
                <th>Batch Number</th>
                <th>Nama Obat</th>
                <th>Quantity</th>
                <th>Expire Date</th>
                <th>Aksi</th>
              </tr>
              </thead>
              <tbody>
              
              <?php
              // print_r($pasien_daftar);
                $i=1;
                foreach($data_barang as $row){
                $batch_no=$row->batch_no;
              ?>
                <tr>
                  <td><?php echo $i++;?></td>
                  <td><?php echo $row->nama_gudang_asal;?></td>
                  <td><?php echo $row->nama_gudang_tujuan;?></td>
                  <td><?php echo $row->batch_no;?></td>
                  <td><?php echo $row->nm_obat;?></td>
                  <td><?php echo $row->qty;?></td>
                  <td><?php echo $row->expire_date;?></td>
                  
                  <td>
                    <a type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#lihatdetail" onclick="validasi('<?php echo $row->id_temporary;?>')">Validasi</a> 
                  </td>
                </tr>
              <?php

                 
                }
              ?>
              </tbody>
            </table>
          <?php
            //echo $this->session->flashdata('message_nodata'); 
          ?>  

          <!-- Modal Edit Obat -->
          <div class="modal fade" id="lihatdetail" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">
    <?php
        echo form_open('logistik_farmasi/Frmcvalidasi/insert_validasi');?>
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Detail Barang</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Batch Number</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_batch_no_dis" id="edit_batch_no_dis" disabled="">
                      <input type="hidden" class="form-control" name="edit_batch_no" id="edit_batch_no">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama Barang</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_description_dis" id="edit_description_dis" disabled="">
                      <input type="hidden" class="form-control" name="edit_description" id="edit_description">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Expire Date</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_expire_dis" id="edit_expire_dis" disabled="">
                      <input type="hidden" class="form-control" name="edit_expire" id="edit_expire">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Quantity</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_qty_dis" id="edit_qty_dis" disabled="">
                      <input type="hidden" class="form-control" name="edit_qty" id="edit_qty">
                    </div>
                  </div>
                   <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Quantity Yang Diterima</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_mutasi" id="edit_mutasi">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Gudang Awal</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_gudang_awal" id="edit_gudang_awal" disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Gudang Tujuan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_gudang_tujuan" id="edit_gudang_tujuan" disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                  <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lpaymethod">Status</p>
                      <div class="col-sm-6">
                        <select class="form-control" name="payment_type" id="pay_method">
                          <option value="" disabled selected>----- Pilih Status -----</option>
                          <option value="1">Terima</option>
                          <option value="2">Tolak</option>
                        </select>
                      </div>
                  </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" class="form-control" name="id_obat" id="id_obat">
                    <input type="hidden" class="form-control" name="hide_gudang_awal" id="hide_gudang_awal">
                    <input type="hidden" class="form-control" name="hide_gudang_tujuan" id="hide_gudang_tujuan">
                    <input type="hidden" class="form-control" name="id_inventory" id="id_inventory">
                    <input type="hidden" class="form-control" name="id_temporary" id="id_temporary">
                    
                  <button type="submit" class="btn btn-default">Selesai</button>
                </div>
              </div>
            </div>
          </div>              
        </div>
      </div>
    </div>
        <?php
    echo form_close();
     ?>
</section>
<?php
  $this->load->view('layout/footer.php');
?>