<?php
  $this->load->view('layout/header.php');
?>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    	$('#example').DataTable();
	$(".select2").select2();
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

  function edit_ppk(kd_ppk) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcppk/get_data_edit_ppk')?>",
      data: {
        kd_ppk: kd_ppk
      },
      success: function(data){
        $('#edit_kd_ppk').val(data[0].kd_ppk);
        $('#edit_kd_ppk_hidden').val(data[0].kd_ppk);
        $('#edit_nm_ppk').val(data[0].nm_ppk);
        $('#edit_kabupaten').val(data[0].kabupaten);
        $('#edit_alamat_ppk').val(data[0].alamat_ppk);
       
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
          <h3 class="box-title">DAFTAR MASTER PPK</h3>
        </div>
        <div class="box-body ">

          <div class="col-xs-9">
          </div>

          <?php echo form_open('master/mcppk/insert_ppk');?>
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah PPK Baru</button>
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
                  <h4 class="modal-title">Tambah PPK Baru</h4>
                </div>
        <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Kode PPK</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="kd_ppk" id="kd_ppk">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Nama PPK</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nm_ppk" id="nm_ppk">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Kabupaten</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="kabupaten" id="kabupaten">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Alamat</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="alamat_ppk" id="alamat_ppk">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button class="btn btn-primary" type="submit">Simpan</button>
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
                <th>Kode PPK</th>
                <th>Nama PPK</th>
                <th>Alamat</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $i=1;
                  foreach($ppk as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->kd_ppk;?></td>
                <td><?php echo $row->nm_ppk;?></td>
                <td><?php echo $row->alamat_ppk;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_ppk('<?php echo $row->kd_ppk;?>')">Edit PPK</button>
                  <a type="button" class="btn btn-danger btn-xs" href="<?php echo base_url('master/mcppk/delete_ppk/'.$row->kd_ppk)?>" ><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('master/mcppk/edit_ppk');?>
          <!-- Modal Edit Obat -->
 <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit PPK</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Kode PPK</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_kd_ppk" id="edit_kd_ppk" disabled="">
                      <input type="hidden" class="form-control" name="edit_kd_ppk_hidden" id="edit_kd_ppk_hidden">
                    </div>
                  </div>
                </div>

                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Nama PPK</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nm_ppk" id="edit_nm_ppk">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Kabupaten</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_kabupaten" id="edit_kabupaten">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Alamat</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_alamat_ppk" id="edit_alamat_ppk">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit</button>
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
