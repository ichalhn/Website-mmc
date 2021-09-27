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

  
  function hapus_gudang(id_gudang){
    if (confirm('Yakin Menghapus gudang?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/mcgudang/delete_gudang')?>",
        data: {
          id_gudang: id_gudang
        },
        success: function(data){
          location.reload();
        },
        error: function(){
          alert("error");
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
        <div class="box-header">
          <h3 class="box-title">DAFTAR GUDANG & TPO</h3>
        </div>
        <div class="box-body ">

          <div class="col-xs-9">
          </div>

          <?php echo form_open('master/mcgudang/insert_gudang');?>
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Gudang Baru</button>
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
                  <h4 class="modal-title">Tambah Gudang Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmgudang">Nama gudang</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nama_gudang" id="nama_gudang">
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Insert gudang</button>
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
                <th>ID Gudang</th>
                <th>Nama Gudang</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>ID Gudang</th>
                <th>Nama Gudang</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $i=1;
                  foreach($gudang as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->id_gudang;?></td>
                <td><?php echo $row->nama_gudang;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" onclick="hapus_gudang('<?php echo $row->id_gudang;?>')"><h6>Hapus Gudang</h6></button>
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