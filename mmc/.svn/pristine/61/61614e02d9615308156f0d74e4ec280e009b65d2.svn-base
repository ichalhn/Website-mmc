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

  function edit_viewtindakan(idtindakan) {
    $('#edit_idviewtindakan').val("");
    $('#edit_idviewtindakan_hide').val("");
    $('#edit_nmviewtindakan').val("");
    $('#edit_kelas_vipa').val("");
    $('#edit_alkes_kelas_vipa').val("");
    $('#edit_kelas_vipb').val("");
    $('#edit_alkes_kelas_vipb').val("");
    $('#edit_kelas_1').val("");
    $('#edit_alkes_kelas_1').val("");
    $('#edit_kelas_2').val("");
    $('#edit_alkes_kelas_2').val("");
    $('#edit_kelas_3').val("");
    $('#edit_alkes_kelas_3').val("");
    $('#edit_kelas_3a').val("");
    $('#edit_alkes_kelas_3a').val("");
    // $('#edit_kelas_3b').val("");
    // $('#edit_alkes_kelas_3b').val("");
    $('#edit_paket').iCheck('uncheck');
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcviewtindakan/get_data_edit_viewtindakan')?>",
      data: {
        idtindakan: idtindakan
      },
      success: function(data){
        $('#edit_idviewtindakan').val(data[0].idtindakan);
        $('#edit_nmviewtindakan').val(data[0].nmtindakan);
        if(data[0].paket==1){
          $('#edit_paket').iCheck('check');
        }
        var i=0;
        for(i=0;i<7;i++){
          if(data[i].kelas=="VVIP"){
            $('#edit_kelas_vipa').val(data[i].total_tarif);
            $('#edit_alkes_kelas_vipa').val(data[i].tarif_alkes);
          }
          if(data[i].kelas=="VIP"){
            $('#edit_kelas_vipb').val(data[i].total_tarif);
            $('#edit_alkes_kelas_vipb').val(data[i].tarif_alkes);
          }
          if(data[i].kelas=="I"){
            $('#edit_kelas_1').val(data[i].total_tarif);
            $('#edit_alkes_kelas_1').val(data[i].tarif_alkes);
          }
          if(data[i].kelas=="II"){
            $('#edit_kelas_2').val(data[i].total_tarif);
            $('#edit_alkes_kelas_2').val(data[i].tarif_alkes);
          }
          if(data[i].kelas=="III"){
            $('#edit_kelas_3').val(data[i].total_tarif);
            $('#edit_alkes_kelas_3').val(data[i].tarif_alkes);
          }
          if(data[i].kelas=="UTAMA"){
            $('#edit_kelas_3a').val(data[i].total_tarif);
            $('#edit_alkes_kelas_3a').val(data[i].tarif_alkes);
          }
          // if(data[i].kelas=="III B"){
          //   $('#edit_kelas_3b').val(data[i].total_tarif);
          //   $('#edit_alkes_kelas_3b').val(data[i].tarif_alkes);
          // }
        }
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
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">DAFTAR TARIF TINDAKAN</h3>
        </div>
        <div class="box-body ">
          <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>ID Tindakan</th>
                <th>Nama Tindakan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>ID Tindakan</th>
                <th>Nama Tindakan</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $i=1;
                  foreach($viewtindakan as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->idtindakan;?></td>
                <td><?php echo $row->nmtindakan;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_viewtindakan('<?php echo $row->idtindakan;?>')"><h6>View Tarif Tindakan</h6></button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
          
          <!-- View Modal -->
          <div class="modal fade" id="editModal" role="dialog">
            <div class="modal-dialog modal-success">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Lihat Tarif Tindakan</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">ID Tindakan</p>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="edit_idviewtindakan" id="edit_idviewtindakan"  disabled="">
                    </div>
                    <div class="col-sm-3">
                      <input name="edit_paket" id="edit_paket" type="checkbox" class="flat-red" disabled=""> Tarif Paket
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Tindakan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nmviewtindakan" id="edit_nmviewtindakan"  disabled="">
                    </div>
                  </div>
                  <hr>
                  <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas VVIP</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="edit_kelas_vipa" id="edit_kelas_vipa" step="100" min="0" disabled="">
                    </div>
                    <div class="col-sm-1"></div>
                    <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="edit_alkes_kelas_vipa" id="edit_alkes_kelas_vipa" step="100" min="0" disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lbl_alamat">Tarif Kelas VIP</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="edit_kelas_vipb" id="edit_kelas_vipb" step="100" min="0" disabled="">
                    </div>
                    <div class="col-sm-1"></div>
                    <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="edit_alkes_kelas_vipb" id="edit_alkes_kelas_vipb" step="100" min="0" disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas UTAMA</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="edit_kelas_3a" id="edit_kelas_3a" step="100" min="0"  disabled="">
                    </div>
                    <div class="col-sm-1"></div>
                    <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="edit_alkes_kelas_3a" id="edit_alkes_kelas_3a" step="100" min="0"  disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas I</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="edit_kelas_1" id="edit_kelas_1" step="100" min="0" disabled="">
                    </div>
                    <div class="col-sm-1"></div>
                    <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="edit_alkes_kelas_1" id="edit_alkes_kelas_1" step="100" min="0" disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lbl_alamat">Tarif Kelas II</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="edit_kelas_2" id="edit_kelas_2" step="100" min="0" disabled="">
                    </div>
                    <div class="col-sm-1"></div>
                    <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="edit_alkes_kelas_2" id="edit_alkes_kelas_2" step="100" min="0"  disabled="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas III</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="edit_kelas_3" id="edit_kelas_3" step="100" min="0"  disabled="">
                    </div>
                    <div class="col-sm-1"></div>
                    <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="edit_alkes_kelas_3" id="edit_alkes_kelas_3" step="100" min="0"  disabled="">
                    </div>
                  </div>
                  <!-- <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lbl_nama">Tarif Kelas III B</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="edit_kelas_3b" id="edit_kelas_3b" step="100" min="0"  disabled="">
                    </div>
                    <div class="col-sm-1"></div>
                    <p class="col-sm-1 form-control-label" id="lbl_nama">Alkes</p>
                    <div class="col-sm-4">
                      <input type="number" class="form-control" name="edit_alkes_kelas_3b" id="edit_alkes_kelas_3b" step="100" disabled="">
                    </div>
                  </div> -->
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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