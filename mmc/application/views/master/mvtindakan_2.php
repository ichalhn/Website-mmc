<?php
  $this->load->view('layout/header.php');
?>
<html>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    $('#example').DataTable();
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });
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

  function edit_tindakan(idtindakan) {
    $('#edit_idtindakan').val("");
    $('#edit_idtindakan_hide').val("");
    $('#edit_nmtindakan').val("");
    <?php
        foreach($kelas as $row){
          echo '$("#edit_alkes_kelas_'.$row->kelas.'").val("");';
        }
    ?>
    
    $('#edit_paket').iCheck('uncheck');
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mctindakan_2/get_data_edit_tindakan')?>",
      data: {
        idtindakan: idtindakan
      },
      success: function(data){
        $('#edit_idtindakan').val(data[0].idtindakan);
        $('#edit_idtindakan_hide').val(data[0].idtindakan);
        $('#edit_nmtindakan').val(data[0].nmtindakan);
        $('#edit_idkel_tind').val(data[0].idkel_tind).change();
        if(data[0].paket==1){
          $('#edit_paket').iCheck('check');
        }

        <?php
            $i=0;
            foreach($kelas as $row){
              echo '
                if(data['.$i.'].kelas=="'.$row->kelas.'"){
                  $("#edit_jasa_sarana_'.$row->kelas.'").val(data['.$i.'].jasa_sarana);
                  $("#edit_jasa_pelayanan_'.$row->kelas.'").val(data['.$i.'].jasa_pelayanan);
                  $("#edit_total_'.$row->kelas.'").val(data['.$i.'].total_tarif);
                  $("#edit_hidden_total_'.$row->kelas.'").val(data['.$i.'].total_tarif);
                }';
                $i++;
            }
        ?>

      },
      error: function(){
        alert("error");
      }
    });
  }

  function download_excel() {
    window.location.href = "<?php echo base_url('master/mctindakan_2/export_excel')?>";
  }

  function edit()
  {
    $('#btnEdit').text('saving...'); //change button text
    $('#btnEdit').attr('disabled',true); //set button disable 
    var url;

    url = "<?php echo site_url('master/mctindakan_2/edit_tindakan')?>";  

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#formedit').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            $('#editModal').modal('hide');

            $('#btnEdit').text('Edit Tindakan'); //change button text
            $('#btnEdit').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            $('#editModal').modal('hide');
            // alert('Error adding / update data');
            $('#btnEdit').text('Edit Tindakan'); //change button text
            $('#btnEdit').attr('disabled',false); //set button enable 

        }
    });
  }


<?php
    foreach($kelas as $row){
      echo '
        function set_total_'.$row->kelas.'() {
          var v_sar = $("#jasa_sarana_'.$row->kelas.'").val();
          var v_pel = $("#jasa_pelayanan_'.$row->kelas.'").val() ;
          
          var total = parseInt(v_sar)+parseInt(v_pel) ; 

          $("#total_'.$row->kelas.'").val(total);
          $("#hidden_total_'.$row->kelas.'").val(total);
        }
      ';
      echo '
        function edit_set_total_'.$row->kelas.'() {
          var v_sar = $("#edit_jasa_sarana_'.$row->kelas.'").val();
          var v_pel = $("#edit_jasa_pelayanan_'.$row->kelas.'").val() ;
          
          var total = parseInt(v_sar)+parseInt(v_pel) ; 

          $("#edit_total_'.$row->kelas.'").val(total);
          $("#edit_hidden_total_'.$row->kelas.'").val(total);
        }
      ';
    }
?>

</script>
<section class="content-header">
  <?php
    echo $this->session->flashdata('success_msg');
  ?>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <!-- <div class="box-header">
          <h3 class="box-title">DAFTAR TINDAKAN</h3>
        </div> -->
        <div class="box-body ">

          <?php echo form_open('master/mctindakan_2/insert_tindakan');?>
          <div class="col-xs-3">
            <div class="input-group">
              <span class="input-group-btn">
                <button class="btn btn-primary" type="submit" onClick="download_excel()">Download Excel</button>
              </span>
            </div><!-- /input-group -->
          </div><!-- /col-lg-6 -->
          <div class="col-xs-9" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Tindakan</button>
              </span>
            </div><!-- /input-group -->
          </div><!-- /col-lg-6 -->

          <!-- Modal -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Tindakan</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">ID Tindakan</p>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="idtindakan" id="idtindakan"  maxlength="6" required>
                    </div>
                    <div class="col-sm-3">
                      <input name="paket" id="paket" type="checkbox" class="flat-red"> Tarif Paket
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Tindakan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nmtindakan" id="nmtindakan" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_biaya">Kelompok Tindakan</p>
                    <div class="col-sm-6">
                      <select  class="form-control select2" style="width: 100%" name="idkel_tind" id="idkel_tind" > 
                        <?php                   
                          foreach($kel_tindakan as $row1){           
                            echo '<option value="'.$row1->idkel_tind.'">'.$row1->nama_kel.'</option>';                      
                          }
                        ?>
                        </select>
                    </div>
                  </div>
                  <div class="box-body table-responsive no-padding">
                      <table class="table" width="100%">
                        <tr>
                          <td>Kelas</td>
                          <td>Jasa Sarana</td>
                          <td>Jasa Pelayanan</td>
                          <td>Total Harga</td>
                        </tr>
                        <?php
                            $i=1;
                            foreach($kelas as $row){
                              echo '<tr>
                                      <td>'.$row->kelas.'</td>
                                      <td>
                                        <input value="0" type="number" class="form-control" name="jasa_sarana_'.$row->kelas.'" id="jasa_sarana_'.$row->kelas.'" step="50" min="0" onchange="set_total_'.$row->kelas.'(this.value)">
                                      </td>
                                      <td>
                                        <input value="0" type="number" class="form-control" name="jasa_pelayanan_'.$row->kelas.'" id="jasa_pelayanan_'.$row->kelas.'" step="50" min="0" onchange="set_total_'.$row->kelas.'(this.value)">
                                      </td>
                                      <td>
                                        <input value="0" disabled type="text" class="form-control" name="total_'.$row->kelas.'" id="total_'.$row->kelas.'" step="50" min="0">
                                        <input value="0" type="hidden" class="form-control" name="hidden_total_'.$row->kelas.'" id="hidden_total_'.$row->kelas.'" step="50" min="0">
                                      </td>
                                    </tr>';
                            }
                        ?>
                    </table>
                  </div>
                  <?php
                      // $i=1;
                      // foreach($kelas as $row){
                      //   echo '<div class="form-group row">
                      //     <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas '.$row->kelas.'</p>
                      //     <div class="col-sm-4">
                      //       <input type="number" class="form-control" name="kelas_'.$row->kelas.'" id="kelas_'.$row->kelas.'" step="50" min="0">
                      //     </div>
                      //     <div class="col-sm-2"></div>
                      //   </div>';
                      // }
                  ?>
                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Insert Tindakan</button>
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
                <?php
                    $i=1;
                    foreach($kelas as $row){
                      echo '<th>Tarif Kelas '.$row->kelas.'</th>';
                    }
                ?>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>ID Tindakan</th>
                <th>Nama Tindakan</th>
                <?php
                    $i=1;
                    foreach($kelas as $row){
                      echo '<th>Tarif Kelas '.$row->kelas.'</th>';
                    }
                ?>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $j=1;
                  foreach($tindakan as $row){
              ?>
              <tr>
                <td><?php echo $j++;?></td>
                <td><?php echo $row->idtindakan;?></td>
                <td><?php echo $row->nmtindakan;?></td>

                <?php
                    $i=1;
                    foreach($kelas as $row1){
                      $naon = $row1->kelas;
                      $naon = strtolower($naon);
                      $vtot = 0;
                      if($row->$naon!=""){
                        $vtot = $row->$naon;
                      }
                      echo '<td>'.$vtot.'</td>';
                    }
                ?>
                <!-- <td><?php echo $row->iii;?></td>
                <td><?php echo $row->ii;?></td>
                <td><?php echo $row->i;?></td>
                <td><?php echo $row->vip;?></td>
                <td><?php echo $row->vvip;?></td> -->
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onClick="edit_tindakan('<?php echo $row->idtindakan;?>')"><i class="fa fa-edit"></i></button>
                  <a type="button" class="btn btn-danger btn-xs" href="<?php echo base_url('master/mctindakan_2/delete_tindakan/'.$row->idtindakan)?>" ><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>


          <!-- eDIT Modal -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Tindakan</h4>
                </div>
                <div class="modal-body">
                  <form action="#" id="formedit" class="form-horizontal">
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_nama">ID Tindakan</p>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="edit_idtindakan" id="edit_idtindakan"  disabled="">
                        <input type="hidden" class="form-control" name="edit_idtindakan_hide" id="edit_idtindakan_hide">
                      </div>
                      <div class="col-sm-3">
                        <input name="edit_paket" id="edit_paket" type="checkbox" class="flat-red"> Tarif Paket
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Tindakan</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_nmtindakan" id="edit_nmtindakan" required>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_biaya">Kelompok Tindakan</p>
                      <div class="col-sm-6">
                        <select  class="form-control select2" style="width: 100%" name="edit_idkel_tind" id="edit_idkel_tind" > 
                          <?php                   
                            foreach($kel_tindakan as $row1){           
                              echo '<option value="'.$row1->idkel_tind.'">'.$row1->nama_kel.'</option>';                      
                            }
                          ?>
                        </select>
                      </div>
                    </div>

                    <div class="box-body table-responsive no-padding">
                        <table class="table" width="100%">
                          <tr>
                            <td>Kelas</td>
                            <td>Jasa Sarana</td>
                            <td>Jasa Pelayanan</td>
                            <td>Total Harga</td>
                          </tr>
                          <?php
                              $i=1;
                              foreach($kelas as $row){
                                echo '<tr>
                                        <td>'.$row->kelas.'</td>
                                        <td>
                                          <input value="0" type="number" class="form-control" name="edit_jasa_sarana_'.$row->kelas.'" id="edit_jasa_sarana_'.$row->kelas.'" step="50" min="0" onchange="edit_set_total_'.$row->kelas.'(this.value)">
                                        </td>
                                        <td>
                                          <input value="0" type="number" class="form-control" name="edit_jasa_pelayanan_'.$row->kelas.'" id="edit_jasa_pelayanan_'.$row->kelas.'" step="50" min="0" onchange="edit_set_total_'.$row->kelas.'(this.value)">
                                        </td>
                                        <td>
                                          <input value="0" disabled type="text" class="form-control" name="edit_total_'.$row->kelas.'" id="edit_total_'.$row->kelas.'" step="50" min="0">
                                          <input value="0" type="hidden" class="form-control" name="edit_hidden_total_'.$row->kelas.'" id="edit_hidden_total_'.$row->kelas.'" step="50" min="0">
                                        </td>
                                      </tr>';
                              }
                          ?>
                      </table>
                    </div>

                    <?php
                        // $i=1;
                        // foreach($kelas as $row){
                        //   echo '<div class="form-group row">
                        //           <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas '.$row->kelas.'</p>
                        //           <div class="col-sm-4">
                        //             <input type="number" class="form-control" name="edit_kelas_'.$row->kelas.'" id="edit_kelas_'.$row->kelas.'" step="50" min="0">
                        //           </div>
                        //         </div>';
                        // }
                    ?>
                  </div>
                </form>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="button" id="btnEdit" onclick="edit()" class="btn btn-primary">Edit Tindakan</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
  $this->load->view('layout/footer.php');
?>
