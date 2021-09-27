<?php
  $this->load->view('layout/header.php');
?>
<script type='text/javascript'>
var table_diagnosa;
  $(document).ready(function() {

    $('#edit_diagnosa').on('hidden.bs.modal', function () {
      document.getElementById("alert-modal-edit").innerHTML = '';
    });
    $('#add_diagnosa').on('hidden.bs.modal', function () {
      document.getElementById("alert-modal-add").innerHTML = '';
    });  

    table_diagnosa = $('#table-diagnosa').DataTable({ 
      "processing": true,
      "serverSide": true,
      "order": [],
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('master/diagnosa/get_diagnosa')?>",
        "type": "POST"
      },
      "columnDefs": [{ 
        "orderable": false, //set not orderable
        "width": "15%",
        "targets": 4 // column index 
      }],   
    });

  });

  function show_diagnosa(id_diagnosa){
    $.ajax({
        type: "GET",
        url: "<?php echo base_url().'master/diagnosa/show_diagnosa/'; ?>"+id_diagnosa,
        dataType: "JSON",
        success: function(data){
          $('#id_diagnosa').val(data.id);
          $('#edit_id_icd1').val(data.id_icd);
          $('#edit_nm_diagnosa').val(data.nm_diagnosa);
          $('#edit_diagnosa_indonesia').val(data.diagnosa_indonesia);
          $('#edit_diagnosa').modal('show');
        },
        error:function(event, textStatus, errorThrown) {
            swal("Error","Load data tidak berhasil.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
    });
  } 

  function update_diagnosa(){
    document.getElementById("submit_edit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'master/diagnosa/edit_diagnosa'; ?>",
        dataType: "JSON",
        data: $('#form_edit').serialize(),
        success: function(data){
          if (data == true) {
            document.getElementById("submit_edit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';            
            $('#edit_diagnosa').modal('hide');  
            table_diagnosa.ajax.reload();
            swal("Sukses", "diagnosa berhasil disimpan.", "success");
          } else {
              document.getElementById("alert-modal-edit").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Gagal menyimpan data.</div>';
              document.getElementById("submit_edit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
          }
        },
        error:function(event, textStatus, errorThrown) {
              document.getElementById("alert-modal-edit").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Gagal menyimpan data.</div>';
              document.getElementById("submit_edit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
    });
  }     

  function insert_diagnosa(){
    document.getElementById("submit_add").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'master/diagnosa/insert_diagnosa'; ?>",
        dataType: "JSON",
        data: $('#form_add').serialize(),
        success: function(data){
          if (data == true) {
            document.getElementById("submit_add").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';            
            $('#add_diagnosa').modal('hide');  
            table_diagnosa.ajax.reload();
            swal("Sukses", "diagnosa berhasil disimpan.", "success");
          } else {
              document.getElementById("alert-modal-add").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Gagal menyimpan data.</div>';
              document.getElementById("submit_add").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
          }
        },
        error:function(event, textStatus, errorThrown) {
              document.getElementById("alert-modal-add").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Gagal menyimpan data.</div>';
              document.getElementById("submit_add").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
    });
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
<div class="box box-danger color-palette-box">
        <div class="box-header with-border">
          <h3 class="box-title">Daftar Diagnosa</h3> 
        </div>
            <div class="box-body">
            <div class="col-md-12">
          <div class="box-tools pull-right" style="margin-bottom: 10px;">       
          <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_diagnosa">
            <i class="fa fa-plus"></i> Tambah Diagnosa
          </button>
          </div>  
           </div>    
                   <div class="col-md-12">       
              <div class="table-responsive">         
              <table id="table-diagnosa" class="table table-bordered table-hover" width="100%">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>ID Diagnosa</th>
                  <th>Diagnosa (English)</th>
                  <th>Diagnosa (Indonesia)</th>
                  <th class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                
                </tbody>
              </table>
              </div>
              </div>
            </div>
            <!-- /.box-body -->
      </div> <!-- .box -->
    </div>
  </div>
</section>

  <div class="modal modal-primary fade" id="edit_diagnosa" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="edit_diagnosa">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Edit diagnosa</h4>
          </div>
          <div class="modal-body">       
            <form class="form-horizontal" id="form_edit">  
            <input type="hidden" class="form-control" id="id_diagnosa" name="id_diagnosa">       
              <div class="box-body">
                <div id="alert-modal-edit"></div>                 
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">ID</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="edit_id_icd1" name="edit_id_icd1" required>
                    </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Diagnosa (English)</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="edit_nm_diagnosa" name="edit_nm_diagnosa" required>
                  </div>
                </div>    
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Diagnosa (Indonesia)</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="edit_diagnosa_indonesia" name="edit_diagnosa_indonesia" required>
                  </div>
                </div>                                                                          

              </div>  <!-- /.box-body -->
            </form>
          </div>  <!-- modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline" id="submit_edit" onclick="update_diagnosa()"><i class="fa fa-floppy-o"></i> Simpan</button>
          </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <div class="modal modal-primary fade" id="add_diagnosa" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="add_diagnosa">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Tambah diagnosa</h4>
          </div>
          <div class="modal-body">       
            <form class="form-horizontal" id="form_add">                 
              <div class="box-body">
                <div id="alert-modal-add"></div>                 
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">ID</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="add_id_icd1" name="add_id_icd1" required>
                    </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Diagnosa (English)</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="add_nm_diagnosa" name="add_nm_diagnosa" required>
                  </div>
                </div>   
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Diagnosa (Indonesia)</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="add_diagnosa_indonesia" name="add_diagnosa_indonesia" required>
                  </div>
                </div>                                                                          

              </div>  <!-- /.box-body -->
            </form>
          </div>  <!-- modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline" id="submit_add" onclick="insert_diagnosa()"><i class="fa fa-floppy-o"></i> Simpan</button>
          </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->  
<?php
  $this->load->view('layout/footer.php');
?>