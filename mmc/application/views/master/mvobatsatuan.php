<?php
  $this->load->view('layout/header.php');
?>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    $('#example').DataTable( {
      "iDisplayLength": 50
    } );
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

  function edit_satuan(id_satuan) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcobatsatuan/get_data_edit_satuan')?>",
      data: {
        id_satuan: id_satuan
      },
      success: function(data){
        $('#edit_id_satuan').val(data[0].id_satuan);
        $('#edit_id_satuan_hidden').val(data[0].id_satuan);
        $('#edit_nm_satuan').val(data[0].nm_satuan);
      },
      error: function(){
        alert("error");
      }
    });
  }

  function hapus_satuan(id_satuan){
    if (confirm('Yakin Menghapus Satuan?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/mcobatsatuan/delete_satuan')?>",
        data: {
          id_satuan: id_satuan
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
        <!-- <div class="box-header">
          <h3 class="box-title">DAFTAR KONTRAKTOR</h3>
        </div> -->
        <div class="box-body ">

          <div class="col-xs-9">
          </div>

          <?php echo form_open('master/mcOBATsatuan/insert_satuan');?>
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Satuan Obat Baru</button>
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
                  <h4 class="modal-title">Tambah Satuan Obat Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nm_satuan">Nama Satuan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nm_satuan" id="nm_satuan">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Insert Satuan Obat</button>
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
                <th>ID Satuan</th>
                <th>Nama Satuan Obat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $i=1;
                  foreach($satuan as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->id_satuan;?></td>
                <td><?php echo $row->nm_satuan;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_satuan('<?php echo $row->id_satuan;?>')"><h6>Edit Satuan</h6></button>
                  <button type="button" class="btn btn-primary btn-xs" onclick="hapus_satuan('<?php echo $row->id_satuan;?>')"><h6>Hapus Satuan</h6></button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('master/mcobatsatuan/edit_satuan');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Satuan Obat</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id Satuan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_id_satuan" id="edit_id_satuan" disabled="">
                      <input type="hidden" class="form-control" name="edit_id_satuan_hidden" id="edit_id_satuan_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama Satuan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nm_satuan" id="edit_nm_satuan">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit Satuan</button>
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