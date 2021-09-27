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

  function edit_keltind(idkel_tind) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mckeltind/get_data_edit_keltind')?>",
      data: {
        idkel_tind: idkel_tind
      },
      success: function(data){
	//alert(data[0].idkel_tind);
        $('#edit_idkel_tind').val(data[0].idkel_tind);
        $('#edit_idkel_tind_hidden').val(data[0].idkel_tind);
        $('#edit_nama_kel').val(data[0].nama_kel);
	      $('#edit_desc_kel').val(data[0].desc_kel);
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
          <h3 class="box-title">DAFTAR KELOMPOK TINDAKAN</h3>
        </div>
        <div class="box-body ">
          <h3 class="box-title">DEFAULT KELOMPOK TINDAKAN SIMRS</h3>
          <table class="table table-hover" width="98%">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Kelompok</th>
                <th>ID</th>                
                <th>Deskripsi</th>
              </tr>
            </thead>

            <tbody>              
              <tr>
                <td>1</td>
                <td>Tindakan Poli</td>
                <td>BA, BB, BD, BE, BF, BG, BH, BI, BK, BQ, BR, BS, BW, BZ</td>
                <td>2 Digit pertama dari kode poli</td>              
              </tr> 
              <tr>
                <td>2</td>
                <td>Tindakan Operasi</td>
                <td>D</td>
                <td>1 Digit pertama dari kode tindakan dengan awalan D</td>              
              </tr>
              <tr>
                <td>3</td>
                <td>Tarif Ruangan</td>
                <td>1A</td>
                <td>2 Digit pertama dari kode tindakan dengan awalan 1A. Tarif Ruangan IRI</td>        
              </tr>
              <tr>
                <td>4</td>
                <td>Tindakan Administrasi</td>
                <td>1B</td>
                <td>2 Digit pertama dari kode tindakan dengan awalan 1B. Tindakan Administrasi RJ, RI</td>
              </tr>
              <tr>
                <td>5</td>
                <td>Tindakan LAB</td>
                <td>H</td>
                <td>1 Digit pertama dari kode tindakan dengan awalan H. Tarif Pemeriksaan LAB</td>
              </tr>
              <tr>
                <td>6</td>
                <td>Tindakan PA</td>
                <td>H</td>
                <td>1 Digit pertama dari kode tindakan dengan awalan P. Tindakan Pemeriksaan PA</td>
              </tr>
              <tr>
                <td>7</td>
                <td>Tindakan RAD</td>
                <td>L</td>
                <td>1 Digit pertama dari kode tindakan dengan awalan L. Tindakan Pemeriksaan Radiologi</td>
              </tr>
              <tr>
                <td>8</td>
                <td>Tindakan Umum Rawat Inap (IRI)</td>
                <td>N, C</td>
                <td>1 Digit pertama dari kode tindakan dengan awalan N. Tindakan umum ruangan rawat inap </td>
              </tr>
              <tr>
                <td>9</td>
                <td>Tindakan Umum Rawat Darurat (IGD)</td>
                <td>C, BA</td>
                <td>1 Digit pertama dari kode tindakan dengan awalan C dan 2 Digit pertama dari kode tindakan dengan awalan BA. Tindakan rawat darurat </td>
              </tr>
              <tr>
                <td>10</td>
                <td>Tindakan Umum ICU</td>
                <td>F</td>
                <td>1 Digit pertama dari kode tindakan dengan awalan F. Tindakan umum ruang ICU.</td>
              </tr>
              <tr>
                <td>10</td>
                <td>Tindakan Umum VK</td>
                <td>BE</td>
                <td>2 Digit pertama dari kode tindakan dengan awalan BE. Tindakan umum VK sama dengan poli kebidanan.</td>
              </tr>
            </tbody>
          </table>
          <hr>
          <div class="col-xs-9">
          </div>

          <?php echo form_open('master/mckeltind/insert_keltind');?>
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Kelompok Tindakan Baru</button>
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
                  <h4 class="modal-title">Tambah Kelompok Tindakan Baru</h4>
                </div>
                <div class="modal-body">
		              <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama_kel">ID Kelompok Tindakan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" placeholder="Ex: MU01" name="idkel_tind" id="idkel_tind">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama_kel">Nama Kelompok Tindakan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nama_kel" id="nama_kel">
                    </div>
                  </div>                  
		              <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_poli">Deskripsi </p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="desc_kel" id="desc_kel">
                    </div>
                  </div>                  		  
                </div>
		
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Insert Kelompok Tindakan</button>
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
                <th>Nama Kelompok Tindakan</th>                
                <th>Deskripsi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>ID</th>
                <th>Nama Kelompok Tindakan</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $i=1;//print_r($poli);
                  foreach($keltind as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->idkel_tind;?></td>
                <td><?php echo $row->nama_kel;?></td>
                <td><?php echo $row->desc_kel;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_keltind('<?php echo $row->idkel_tind;?>')"><i class="fa fa-edit"></i></button>
		  <a type="button" class="btn btn-danger btn-xs" href="<?php echo base_url('master/mckeltind/delete_keltind/'.$row->idkel_tind)?>" ><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('master/mckeltind/edit_keltind');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Kelompok Tindakan</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id Kelompok Tindakan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_idkel_tind" id="edit_idkel_tind" disabled>
                      <input type="hidden" class="form-control" name="edit_idkel_tind_hidden" id="edit_idkel_tind_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama Kelompok Tindakan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nama_kel" id="edit_nama_kel">
                    </div>
                  </div>                                 
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_poli">Deskripsi</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_desc_kel" id="edit_desc_kel">
                    </div>
                  </div>                  		  
                </div>
                </div>
		
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit Kelompok Tindakan</button>
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close();?>

        </div>
      </div>
    </div>
</section>

<?php
  $this->load->view('layout/footer.php');
?>
