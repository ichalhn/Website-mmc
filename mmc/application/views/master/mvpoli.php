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

  function edit_poli(id_poli) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcpoli/get_data_edit_poli')?>",
      data: {
        id_poli: id_poli
      },
      success: function(data){
	//alert(data[0].id_poli);
        $('#edit_id_poli').val(data[0].id_poli);
        $('#edit_id_poli_hidden').val(data[0].id_poli);
        $('#edit_nm_poli').val(data[0].nm_poli);
	$('#edit_nm_pokpoli').val(data[0].nm_pokpoli);
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
          <h3 class="box-title">DAFTAR POLIKLINIK</h3>
        </div>
        <div class="box-body ">

          <div class="col-xs-9">
          </div>

          <?php echo form_open('master/mcpoli/insert_poli');?>
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Poliklinik Baru</button>
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
                  <h4 class="modal-title">Tambah Poliklinik Baru</h4>
                </div>
                <div class="modal-body">
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nm_poli">ID Poliklinik</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" placeholder="Ex: BB00" name="id_poli" id="id_poli">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nm_poli">Nama Poliklinik</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nm_poli" id="nm_poli">
                    </div>
                  </div>                  
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_poli">Nama Pokpoli</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nm_pokpoli" id="nm_pokpoli">
                    </div>
                  </div>                  		  
                </div>
		
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Insert Poliklinik</button>
                </div>
              </div>
            </div>
          </div>
          
          <?php echo form_close();?>
	<hr>
          <br/> 
          <br/> 

          <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>ID</th>
                <th>Nama Poliklinik</th>                
                <th>Keterangan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>ID</th>
                <th>Nama Poliklinik</th>
                <th>Keterangan</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $i=1;//print_r($poli);
                  foreach($poli as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->id_poli;?></td>
                <td><?php echo $row->nm_poli;?></td>
                <td><?php echo $row->nm_pokpoli;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_poli('<?php echo $row->id_poli;?>')"><i class="fa fa-edit"></i></button>
		  <a type="button" class="btn btn-danger btn-xs" href="<?php echo base_url('master/mcpoli/delete_poli/'.$row->id_poli)?>" ><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('master/mcpoli/edit_poli');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Poliklinik</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id Poliklinik</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_id_poli" id="edit_id_poli" disabled>
                      <input type="hidden" class="form-control" name="edit_id_poli_hidden" id="edit_id_poli_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama Poliklinik</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nm_poli" id="edit_nm_poli">
                    </div>
                  </div>                                 
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_poli">Nama Pokpoli</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nm_pokpoli" id="edit_nm_pokpoli">
                    </div>
                  </div>                  		  
                </div>
                </div>
		
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit Poliklinik</button>
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
