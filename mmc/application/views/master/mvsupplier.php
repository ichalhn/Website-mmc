<?php
  $this->load->view('layout/header.php');
?>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    $('#example').DataTable();
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

  function edit_supplier(id_supplier) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/Mcsupplier/get_data_edit_supplier')?>",
      data: {
        id_supplier: id_supplier
      },
      success: function(data){
        $('#edit_id_supplier').val(data[0].person_id);
        $('#edit_id_supplier_hidden').val(data[0].person_id);
        $('#edit_nmsupplier').val(data[0].company_name);
        $('#edit_accountnumber').val(data[0].account_number);
        $('#edit_adress').val(data[0].adress);
        $('#edit_zip_code').val(data[0].zip_code);
        $('#edit_phone').val(data[0].phone);
      },
      error: function(){
        alert("error");
      }
    });
  }

  function hapus_supplier(id_supplier){
    if (confirm('Yakin Menghapus supplier?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/Mcsupplier/delete_supplier')?>",
        data: {
          id_supplier: id_supplier
        },
        success: function(data){
          location.reload();
        },
        error: function(){
          alert("error");
        }
      });
    } 
  }


</script>
<section class="content-header">
  <?php
    echo $this->session->flashdata('success_msg');
  ?>
</section>

<section class="content">
  <div class="row" id="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">DAFTAR SUPPLIER</h3>
        </div>
        <div class="box-body ">

          <div class="col-xs-9">
          </div>

          <?php echo form_open('master/mcsupplier/insert_supplier');?>
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Supplier Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert Supplier -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Supplier Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmsupplier">Nama Supplier</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nmsupplier" id="nmsupplier">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_accountnumber">Account Number</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="accountnumber" id="accountnumber">
                    </div>
                  </div>
                   <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_adress">Alamat</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="adress" id="adress">
                    </div>
                  </div>
                   <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_zip_code">Zip Code</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="zip_code" id="zip_code">
                    </div>
                  </div>
                   <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_phone">Phone</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="phone" id="phone">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Insert Supplier</button>
                </div>
              </div>
            </div>
          </div>
          
          <?php echo form_close();?>
          <br/> 
          <br/> 

          <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>ID Supplier</th>
                <th>Nama Supplier</th>
                <th>Account Number</th>
                <th>Telepon</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>ID supplier</th>
                <th>Nama supplier</th>
                <th>Account Number</th>
                <th>Telephon</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $i=1;
                  foreach($suppliers as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->person_id;?></td>
                <td><?php echo $row->company_name;?></td>
                 <td><?php echo $row->account_number;?></td>
                 <td><?php echo $row->phone;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_supplier('<?php echo $row->person_id;?>')"><h6>Edit supplier</h6></button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('master/Mcsupplier/edit_supplier');?>
          <!-- Modal Edit-->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit supplier</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id supplier</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_id_supplier" id="edit_id_supplier" disabled="">
                      <input type="hidden" class="form-control" name="edit_id_supplier_hidden" id="edit_id_supplier_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama supplier</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nmsupplier" id="edit_nmsupplier">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Account Number</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_accountnumber" id="edit_accountnumber">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Alamat</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_adress" id="edit_adres">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Kode POS</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_zip_code" id="edit_zip_code">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">No.Telepone</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_phone" id="edit_phone">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit supplier</button>
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close();?>

        </div>
      </div>
    </div>
  </div>
</section>

<?php
  $this->load->view('layout/footer.php');
?>