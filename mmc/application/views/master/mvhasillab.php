<?php
  $this->load->view('layout/header.php');
?>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
      $('#example').DataTable( {
        "iDisplayLength": 50
      } );
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

  function delete_jenis_hasil_lab(id_jenis_hasil_lab){
    if (confirm('Yakin Menghapus Jenis Hasil Laboratorium?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/mchasillab/delete_jenis_hasil_lab')?>",
        data: {
          id_jenis_hasil_lab: id_jenis_hasil_lab
        },
        success: function(data){
          location.reload();
        },
        error: function(){
          location.reload();
        }
      });
    } 
  }

   function edit_jenis_hasil_lab(id_jenis_hasil_lab) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mchasillab/get_data_edit_hasil_lab')?>",
      data: {
        id_jenis_hasil_lab: id_jenis_hasil_lab
      },
      success: function(data){
        $('#edit_id_jenis_hasil_lab').val(data[0].id_jenis_hasil_lab);
        $('#edit_id_jenis_hasil_lab_hidden').val(data[0].id_jenis_hasil_lab);
        $('#edit_nmtindakan').val(data[0].nmtindakan);
        $('#edit_jenis_hasil').val(data[0].jenis_hasil);
        $('#edit_kadar_normal').val(data[0].kadar_normal);
        $('#edit_satuan').val(data[0].satuan);
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
          <h3 class="box-title">DAFTAR JENIS HASIL LABORATORIUM</h3>
        </div>
        <div class="box-body ">

          <div class="col-xs-9">
          </div>

          <?php echo form_open('master/mchasillab/insert_jenis_hasil_lab');?>
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Jenis Hasil Lab Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert Obat -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Jenis Hasil Lab</h4>
                </div>
                <div class="modal-body">
                  <div class="col-sm-12">
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_id_tindakan">Nama Tindakan</p>
                      <div class="col-sm-8">
                        <select  class="form-control select2" style="width: 100%" name="id_tindakan" id="id_tindakan" required="">
                          <option value="">-Pilih Tindakan-</option>
                          <?php                   
                            foreach($tindakan_lab as $row1){                                          
                              echo '<option value="'.$row1->idtindakan.'">'.$row1->nmtindakan.'</option>';                   
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_jenis_hasil">Nama Jenis Hasil</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="jenis_hasil" id="jenis_hasil">
                      </div>
                    </div>
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_kadar_normal">Kadar Normal</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="kadar_normal" id="kadar_normal">
                      </div>
                    </div>
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_satuan">Satuan</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="satuan" id="satuan">
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                  </div>
                </div>
    
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Insert Jenis Hasil Lab</button>
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
                <th>ID Tindakan</th>
                <th>Nama Tindakan</th>
                <th>Jenis hasil</th>
                <th>Kadar Normal</th>
                <th>Satuan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $i=1;
                  foreach($hasil_lab as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->id_tindakan;?></td>
                <td><?php echo $row->nmtindakan;?></td>
                <td><?php echo $row->jenis_hasil;?></td>
                <td><?php echo $row->kadar_normal;?></td>
                <td><?php echo $row->satuan;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_jenis_hasil_lab('<?php echo $row->id_jenis_hasil_lab;?>')"><h6>EDIT HASIL</h6></button>
                </td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="delete_jenis_hasil_lab('<?php echo $row->id_jenis_hasil_lab;?>')">HAPUS</button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

   <?php echo form_open('master/mchasillab/edit_hasil_lab');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Jenis Hasil lab</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id Jenis_hasil_lab</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_id_jenis_hasil_lab" id="edit_id_jenis_hasil_lab" disabled="">
                      <input type="hidden" class="form-control" name="edit_id_jenis_hasil_lab_hidden" id="edit_id_jenis_hasil_lab_hidden">
                    </div>
                  </div>

                   <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Tindakan Lab</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nmtindakan" id="edit_nmtindakan" disabled="">
                    </div>
                  </div>
              <!--     <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Jenis_hasil Lab</p>
                    <div class="col-sm-6">
                      <select id="edit_jenis_hasil" class="form-control" name="edit_jenis_hasil" required>
                        <option value="" disabled selected="">-Pilih Satuan Kecil-</option>
                        <?php 
                          foreach($satuan as $row){
                            echo '<option value="'.$row->nm_satuan.'">'.$row->nm_satuan.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div> -->
               <!--    <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Satuan Besar</p>
                    <div class="col-sm-6">
                      <select id="edit_satuanb" class="form-control" name="edit_satuanb" required>
                        <option value="" disabled selected="">-Pilih Satuan Besar-</option>
                        <?php 
                          foreach($satuan as $row){
                            echo '<option value="'.$row->nm_satuan.'">'.$row->nm_satuan.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div> -->
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama Hasil</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_jenis_hasil" id="edit_jenis_hasil">
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Kadar Normal</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_kadar_normal" id="edit_kadar_normal">
                    </div>
                  </div>
               <!--    <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Satuan</p>
                    <div class="col-sm-6">
                      <select id="edit_kel" class="form-control" name="edit_kel" required>
                        <option value="" disabled selected="">-Pilih Kelompok-</option>
                        <?php 
                          foreach($kelompok as $row){
                            echo '<option value="'.$row->nm_satuan.'">'.$row->nm_satuan.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div> -->
               <!--    <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Jenis</p>
                    <div class="col-sm-6">
                      <select id="edit_jenis_obat" class="form-control" name="edit_jenis_obat" required>
                        <option value="" disabled selected="">-Pilih Jenis-</option>
                        <?php 
                          foreach($jenis as $row){
                            echo '<option value="'.$row->nm_jenis.'">'.$row->nm_jenis.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div> -->
              <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Satuan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_satuan" id="edit_satuan">
                    </div>
                  </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit Jenis Hasil Lab</button>
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close();?>

</section>

<?php
  $this->load->view('layout/footer.php');
?>
