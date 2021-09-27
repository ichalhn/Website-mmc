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

  function edit_carabayar(cara_bayar) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mccara_bayar/get_data_edit_carabayar')?>",
      data: {
        cara_bayar: cara_bayar
      },
      success: function(data){
	//alert(data[0].id_dokter);
        
        $('#edit_cara_bayar').val(data[0].cara_bayar);
        $('#edit_klsrawatjalan').val(data[0].klsrawatjalan);
        $('#edit_kode').val(data[0].kode);
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
          <h3 class="box-title">DAFTAR CARA BAYAR</h3>
        </div>
        <div class="box-body ">

          <div class="col-xs-9">
          </div>

          <?php echo form_open('master/mccara_bayar/insert_carabayar');?>
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Cara Bayar Baru</button>
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
                  <h4 class="modal-title">Tambah Cara Bayar Baru</h4>
                </div>
        <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Jenis Cara Bayar</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="cara_bayar" id="cara_bayar">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Kelas Rawat</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="klsrawatjalan" id="klsrawatjalan">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Kode</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="kode" id="kode">
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
                <th>Jenis Cara Bayar</th>
                <th>Kelas Rawat</th>
                <th>Kode</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $i=1;
                  foreach($cara_bayar as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->cara_bayar;?></td>
                <td><?php echo $row->klsrawatjalan;?></td>
                <td><?php echo $row->kode;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_carabayar('<?php echo $row->cara_bayar;?>')">Edit Cara Bayar</button>
                  <a type="button" class="btn btn-danger btn-xs" href="<?php echo base_url('master/mccara_bayar/delete_carabayar/'.$row->cara_bayar)?>" ><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('master/mccara_bayar/edit_carabayar');?>
          <!-- Modal Edit Obat -->
 <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Cara Bayar</h4>
                </div>
        <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Jenis Cara Bayar</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_cara_bayar" id="edit_cara_bayar">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Kelas Rawat</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_klsrawatjalan" id="edit_klsrawatjalan">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Kode</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_kode" id="edit_kode">
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
