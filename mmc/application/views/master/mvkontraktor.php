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

  function edit_kontraktor(id_kontraktor) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mckontraktor/get_data_edit_kontraktor')?>",
      data: {
        id_kontraktor: id_kontraktor
      },
      success: function(data){
        $('#edit_id_kontraktor').val(data[0].id_kontraktor);
        $('#edit_id_kontraktor_hidden').val(data[0].id_kontraktor);
        $('#edit_nmkontraktor').val(data[0].nmkontraktor);
        $('#edit_jenis').val(data[0].jamsoskes);
      },
      error: function(){
        alert("error");
      }
    });
  }

  function hapus_kontraktor(id_kontraktor){
    if (confirm('Yakin Menghapus Kontraktor?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/mckontraktor/delete_kontraktor')?>",
        data: {
          id_kontraktor: id_kontraktor
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
          <h3 class="box-title">DAFTAR KONTRAKTOR</h3>
        </div>
        <div class="box-body ">

          <div class="col-xs-9">
          </div>

          <?php echo form_open('master/mckontraktor/insert_kontraktor');?>
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Kontraktor Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert Obat -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Kontraktor Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmkontraktor">Nama Kontraktor</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nmkontraktor" id="nmkontraktor">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmkontraktor">Jenis Kontraktor</p>
                    <div class="col-sm-6">
                      <select class="form-control" name="jamsoskes" id="jamsoskes" required>
                        <option value="0">Asuransi</option>
                        <option value="1">Jamsoskes</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Insert Kontraktor</button>
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
                <th>ID Kontraktor</th>
                <th>Nama Kontraktor</th>
                <th>Jenis Kontraktor</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $i=1;
                  foreach($kontraktor as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->id_kontraktor;?></td>
                <td><?php echo $row->nmkontraktor;?></td>
                <td><?php if($row->jamsoskes=='0'){
                    echo 'Asuransi';
                  }else{
                    echo 'Jamsoskes';
                  }?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_kontraktor('<?php echo $row->id_kontraktor;?>')"><h6>Edit Kontraktor</h6></button>
                  <button type="button" class="btn btn-primary btn-xs" onclick="hapus_kontraktor('<?php echo $row->id_kontraktor;?>')"><h6>Hapus Kontraktor</h6></button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('master/mckontraktor/edit_kontraktor');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Kontraktor</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id Kontraktor</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_id_kontraktor" id="edit_id_kontraktor" disabled="">
                      <input type="hidden" class="form-control" name="edit_id_kontraktor_hidden" id="edit_id_kontraktor_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama Kontraktor</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nmkontraktor" id="edit_nmkontraktor">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Jenis Kontraktor</p>
                    <div class="col-sm-6">
                      <select class="form-control" name="edit_jenis" id="edit_jenis" required>
                        <option value="0">Asuransi</option>
                        <option value="1">Jamsoskes</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit Kontraktor</button>
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