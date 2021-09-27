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

  function edit_diagnosa(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcdiagnosa/get_data_edit_diagnosa')?>",
      data: {
        id: id
      },
      success: function(data){
        $('#edit_id').val(data[0].id);
        $('#edit_iddiagnosa').val(data[0].id_icd);
        $('#edit_nmdiagnosaeng').val(data[0].nm_diagnosa);
        $('#edit_nmdiagnosaind').val(data[0].diagnosa_indonesia);
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
          <h3 class="box-title">DAFTAR DIAGNOSA</h3>
        </div>
        <div class="box-body ">

          <div class="col-xs-9">
          </div>

          <?php echo form_open('master/mcdiagnosa/insert_diagnosa');?>
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Diagnosa Baru</button>
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
                  <h4 class="modal-title">Tambah Diagnosa Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">ID Diagnosa</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="iddiagnosa" id="iddiagnosa">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Nama Diagnosa Eng</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nmdiagnosaeng" id="nmdiagnosaeng">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Nama Diagnosa Ind</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nmdiagnosaind" id="nmdiagnosaind">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Insert Diagnosa</button>
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
                <th>ID</th>
                <th>Nama Diagnosa Eng</th>
                <th>Nama Diagnosa Ind</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>ID</th>
                <th>Nama Diagnosa Eng</th>
                <th>Nama Diagnosa Ind</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $i=1;
                  foreach($diagnosa as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->id_icd;?></td>
                <td><?php echo $row->nm_diagnosa;?></td>
                <td><?php echo $row->diagnosa_indonesia;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_diagnosa('<?php echo $row->id;?>')">Edit Diagnosa</button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('master/mcdiagnosa/edit_diagnosa');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Diagnosa</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">ID Diagnosa</p>
                    <div class="col-sm-6">
                      <input type="hidden" class="form-control" name="edit_id" id="edit_id">
                      <input type="text" class="form-control" name="edit_iddiagnosa" id="edit_iddiagnosa">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Nama Diagnosa Eng</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nmdiagnosaeng" id="edit_nmdiagnosaeng">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Nama Diagnosa Ind</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nmdiagnosaind" id="edit_nmdiagnosaind">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit Diagnosa</button>
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