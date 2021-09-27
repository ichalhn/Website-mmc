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

  function edit_kelas(kelas) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mckelas/get_data_edit_kelas')?>",
      data: {
        kelas: kelas
      },
      success: function(data){
	//alert(data[0].id_dokter);
        
        $('#edit_kelas').val(data[0].kelas);
        $('#edit_urutan').val(data[0].urutan);
        $('#edit_persen_jasa').val(data[0].persen_jasa);

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
          <h3 class="box-title">DAFTAR KELAS</h3>
        </div>
        <div class="box-body ">

          <div class="col-xs-9">
          </div>

          <?php echo form_open('master/mckelas/insert_kelas');?>
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Kelas Baru</button>
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
                  <h4 class="modal-title">Tambah Kelas Baru</h4>
                </div>
        <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Jenis Kelas</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="kelas" id="kelas">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Urutan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="urutan" id="urutan">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Besar Persentase Jasa(%)</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="persen_jasa" id="persen_jasa">
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
                <th>Jenis Kelas</th>
                <th>Urutan</th>
                 <th>Besar Persentase Jasa (%)</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $i=1;
                  foreach($kelas as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->kelas;?></td>
                <td><?php echo $row->urutan;?></td>
                <td><?php echo $row->persen_jasa;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_kelas('<?php echo $row->kelas;?>')">Edit Kelas</button>
                  <a type="button" class="btn btn-danger btn-xs" href="<?php echo base_url('master/mckelas/delete_kelas/'.$row->kelas)?>" ><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('master/mckelas/edit_kelas');?>
          <!-- Modal Edit Obat -->
 <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Kelas</h4>
                </div>
        <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Jenis Kelas</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_kelas" id="edit_kelas">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Urutan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_urutan" id="edit_urutan">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Besar Persentase Jasa(%)</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_persen_jasa" id="edit_persen_jasa">
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
