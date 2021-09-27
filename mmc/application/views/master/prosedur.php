<?php
  $this->load->view('layout/header.php');
?>
<script type='text/javascript'>
var table_prosedur;
  $(document).ready(function() {

    $('#edit_prosedur').on('hidden.bs.modal', function () {
      document.getElementById("alert-modal-edit").innerHTML = '';
    });
    $('#add_prosedur').on('hidden.bs.modal', function () {
      document.getElementById("alert-modal-add").innerHTML = '';
    });  

    table_prosedur = $('#table-prosedur').DataTable({ 
      "processing": true,
      "serverSide": true,
      "order": [],
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('master/prosedur/get_prosedur')?>",
        "type": "POST"
      },
      "columnDefs": [{ 
        "orderable": false, //set not orderable
        "width": "20%",
        "targets": 3 // column index 
      }],   
    });

  });

  function show_prosedur(id_prosedur){
    $.ajax({
        type: "GET",
        url: "<?php echo base_url().'master/prosedur/show_prosedur/'; ?>"+id_prosedur,
        dataType: "JSON",
        success: function(data){
          $('#id_prosedur').val(data.id);
          $('#id_tind').val(data.id_tind);
          $('#nm_tindakan').val(data.nm_tindakan);
          $('#edit_prosedur').modal('show');
        },
        error:function(event, textStatus, errorThrown) {
            swal("Error","Load data tidak berhasil.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
    });
  } 

  function update_prosedur(){
    document.getElementById("submit_edit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'master/prosedur/edit_prosedur'; ?>",
        dataType: "JSON",
        data: $('#form_edit').serialize(),
        success: function(data){
          if (data == true) {
            document.getElementById("submit_edit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';            
            $('#edit_prosedur').modal('hide');  
            table_prosedur.ajax.reload();
            swal("Sukses", "Prosedur berhasil disimpan.", "success");
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

  function insert_prosedur(){
    document.getElementById("submit_add").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'master/prosedur/insert_prosedur'; ?>",
        dataType: "JSON",
        data: $('#form_add').serialize(),
        success: function(data){
          if (data == true) {
            document.getElementById("submit_add").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';            
            $('#add_prosedur').modal('hide');  
            table_prosedur.ajax.reload();
            swal("Sukses", "Prosedur berhasil disimpan.", "success");
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
          <h3 class="box-title">Daftar Prosedur</h3> 
        </div>
            <div class="box-body">
            <div class="col-md-12">
          <div class="box-tools pull-right" style="margin-bottom: 10px;">       
          <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add_prosedur">
            <i class="fa fa-plus"></i> Tambah Prosedur
          </button>
          </div>  
           </div>    
                   <div class="col-md-12">       
              <div class="table-responsive">         
              <table id="table-prosedur" class="table table-bordered table-hover" width="100%">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>ID Prosedur</th>
                  <th>Prosedur</th>
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

  <div class="modal modal-primary fade" id="edit_prosedur" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="edit_prosedur">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Edit Prosedur</h4>
          </div>
          <div class="modal-body">       
            <form class="form-horizontal" id="form_edit">  
            <input type="hidden" class="form-control" id="id_prosedur" name="id_prosedur">       
              <div class="box-body">
                <div id="alert-modal-edit"></div>                 
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">ID</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="id_tind" name="id_tind" required>
                    </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Prosedur</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="nm_tindakan" name="nm_tindakan" required>
                  </div>
                </div>                                                          

              </div>  <!-- /.box-body -->
            </form>
          </div>  <!-- modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline" id="submit_edit" onclick="update_prosedur()"><i class="fa fa-floppy-o"></i> Simpan</button>
          </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <div class="modal modal-primary fade" id="add_prosedur" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="add_prosedur">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">Tambah Prosedur</h4>
          </div>
          <div class="modal-body">       
            <form class="form-horizontal" id="form_add">                 
              <div class="box-body">
                <div id="alert-modal-add"></div>                 
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">ID</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="add_idtind" name="add_idtind" required>
                    </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Prosedur</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="add_nmtindakan" name="add_nmtindakan" required>
                  </div>
                </div>                                                          

              </div>  <!-- /.box-body -->
            </form>
          </div>  <!-- modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-outline" id="submit_add" onclick="insert_prosedur()"><i class="fa fa-floppy-o"></i> Simpan</button>
          </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->  
<?php
  $this->load->view('layout/footer.php');
?>