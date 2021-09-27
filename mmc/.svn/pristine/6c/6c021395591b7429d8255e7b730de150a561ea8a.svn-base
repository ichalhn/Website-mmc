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

  function delete_jenis_lab(id_jenis_lab){
    if (confirm('Yakin Menghapus Jenis Laboratorium?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/mcjenislab/delete_jenis_lab')?>",
        data: {
          id_jenis_lab: id_jenis_lab
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
          <h3 class="box-title">DAFTAR JENIS LABORATORIUM</h3>
        </div> -->
        <div class="box-body ">

          <div class="col-xs-9">
          </div>

          <?php echo form_open('master/mcjenislab/insert_jenis_lab');?>
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Jenis  Lab Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert Obat -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg"">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Jenis Lab</h4>
                </div>
                <div class="modal-body">
                  <div class="col-sm-12">
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_nama_jenis">Nama Jenis</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="nama_jenis" id="nama_jenis">
                      </div>
                    </div>
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_kode_jenis">Kode Jenis</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="kode_jenis" id="kode_jenis">
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
                  <button class="btn btn-primary" type="submit">Insert Jenis Lab</button>
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
                <th>Nama Jenis</th>
                <th>Kode Jenis</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $i=1;
                  foreach($jenis_lab as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->nama_jenis;?></td>
                <td><?php echo $row->kode_jenis;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="delete_jenis_lab('<?php echo $row->id;?>')">HAPUS</button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
  $this->load->view('layout/footer.php');
?>
