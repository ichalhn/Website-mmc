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

  function edit_kebijakan(id_kebijakan) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcobat/get_data_edit_kebijakan')?>",
      data: {
        id_kebijakan: id_kebijakan
      },
      success: function(data){
        $('#edit_id_kebijakan').val(data[0].id_kebijakan);
        $('#edit_id_kebijakan_hidden').val(data[0].id_kebijakan);
        $('#edit_keterangan').val(data[0].keterangan);
        $('#edit_nilai').val(data[0].nilai);
      },
      error: function(){
        alert("error");
      }
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
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">DAFTAR KEBIJAKAN</h3>
        </div>
        <div class="box-body ">
          <div class="col-xs-9">
          </div><!-- /col-lg-3 -->

          <?php echo form_open('master/mcobat/insert_kebijakan');?>
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Kebijakan</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert Kebijakan -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Kebijakan Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">

                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_id_kebijakan">Id Kebijakan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="id_kebijakan" id="id_kebijakan">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_keterangan">Keterangan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="keterangan" id="keterangan">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nilai">Nilai</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nilai" id="nilai">
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Insert Kebijakan</button>
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
                <th>ID Kebijakan</th>
                <th>Keterangan</th>
                <th>Nilai</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>ID Kebijakan</th>
                <th>Keterangan</th>
                <th>Nilai</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody id="bodyt">
              <?php
                  $i=1;
                  foreach($kebijakan as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->id_kebijakan;?></td>
                <td><?php echo $row->keterangan;?></td>
                <td><?php echo $row->nilai;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_kebijakan('<?php echo $row->id_kebijakan;?>')">Edit Kebijakan</button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('master/mcobat/edit_kebijakan');?>
          <!-- Modal Edit Kebijakan -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Kebijakan</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_id_kebijakan">Id Kebijakan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_id_kebijakan" id="edit_id_kebijakan" disabled="">
                      <input type="hidden" class="form-control" name="edit_id_kebijakan_hidden" id="edit_id_kebijakan_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_keterangan">Keterangan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_keterangan" id="edit_keterangan">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nilai">Nilai</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nilai" id="edit_nilai">
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit Kebijakan</button>
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