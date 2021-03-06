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

  function edit_dokter(id_dokter) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcdokter/get_data_edit_dokter')?>",
      data: {
        id_dokter: id_dokter
      },
      success: function(data){
	//alert(data[0].id_dokter);
        $('#edit_id_dokter').val(data[0].id_dokter);
        $('#edit_id_dokter_hidden').val(data[0].id_dokter);
        $('#edit_nm_dokter').val(data[0].nm_dokter);
        $('#edit_nipeg').val(data[0].nipeg);
      	$('#edit_poli').val(data[0].id_poli).change();
      	$('#edit_biaya').val(data[0].id_biaya_periksa).change();
      	$('#old_poli').val(data[0].id_poli);
        $('#edit_ket').val(data[0].ket);
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
          <h3 class="box-title">DAFTAR DOKTER</h3>
        </div>
        <div class="box-body ">

          <div class="col-xs-9">
          </div>

          <?php echo form_open('master/mcdokter/insert_dokter');?>
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Dokter Baru</button>
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
                  <h4 class="modal-title">Tambah Dokter Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="col-sm-6">
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_nm_dokter">Nama Dokter</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="nm_dokter" id="nm_dokter">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_nipeg">Nipeg</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="nipeg" id="nipeg">
                      </div>
                    </div>
  		              <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_poli">Poli</p>
                      <div class="col-sm-8">
                        <select  class="form-control" style="width: 100%" name="poli" id="poli" >
                  				<option value="">-Pilih Poli-</option>
                  				<?php 									
                  					foreach($poli as $row1){						
                  						
                  						echo '<option value="'.$row1->id_poli.'">'.$row1->nm_poli.'</option>';											
                  					}
                  				?>
                  			</select>
                      </div>
                    </div>
  		              <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_biaya">Biaya Periksa</p>
                      <div class="col-sm-8">
                        <select  class="form-control" style="width: 100%" name="biaya" id="biaya" >
                  				<option value="">-Pilih Biaya Periksa-</option>
                  				<?php 									
                  					foreach($biaya as $row1){						
                  						echo '<option value="'.$row1->idtindakan.'">'.$row1->nmtindakan.'</option>';											
                  					}
                  				?>
                  			</select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_ket">Keterangan</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="ket" id="ket">
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 container">
                    <table width="100%" class="table table-bordered table-condensed">
                      <thead>
                        <tr>
                          <td><b><i>Untuk Dokter :</i></b></td>
                          <td><b><i>Isi Keterangan Dengan :</i></b></td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Instalasi Rawat Darurat</td>
                          <td>Dokter Jaga</td>
                        </tr>
                        <tr>
                          <td>Residen</td>
                          <td>Dokter Residen</td>
                        </tr>
                        <tr>
                          <td>Patologi Anatomi</td>
                          <td>Patologi Anatomi</td>
                        </tr>
                        <tr>
                          <td>Laboratorium</td>
                          <td>Patologi Klinik</td>
                        </tr>
                        <tr>
                          <td>Radiologi</td>
                          <td>Radiologi</td>
                        </tr>
                        <tr>
                          <td>Kamar Operasi</td>
                          <td>Operasi</td>
                        </tr>
                        <tr>
                          <td>Perawat Ruangan IRI</td>
                          <td>Perawat</td>
                        </tr>
                      </tbody>
                      
                    </table>
                  </div>
                  <div class="form-group row">
              <div class="col-sm-1"></div>
              </div>
                </div>
		
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Insert Dokter</button>
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
                <th>ID Dokter</th>
                <th>Nama Dokter</th>
                <th>Nipeg</th>
                <th>Poli</th>
                <th>Keterangan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $i=1;
                  foreach($dokter as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->id_dokter;?></td>
                <td><?php echo $row->nm_dokter;?></td>
                <td><?php echo $row->nipeg;?></td>
                <td><?php echo $row->nm_poli;?></td>
                <td><?php echo $row->ket;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_dokter('<?php echo $row->id_dokter;?>')">Edit Dokter</button>
                  <a type="button" class="btn btn-danger btn-xs" href="<?php echo base_url('master/mcdokter/delete_dokter/'.$row->id_dokter)?>" ><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('master/mcdokter/edit_dokter');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Dokter</h4>
                </div>
                <div class="modal-body">
                  <div class="col-sm-6">
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Id Dokter</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="edit_id_dokter" id="edit_id_dokter" disabled="">
                        <input type="hidden" class="form-control" name="edit_id_dokter_hidden" id="edit_id_dokter_hidden">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Nama Dokter</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="edit_nm_dokter" id="edit_nm_dokter">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Nipeg</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="edit_nipeg" id="edit_nipeg">
                      </div>
                    </div>
  		              <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_poli">Poli</p>
                      <div class="col-sm-8">
                        <select  class="form-control select2" style="width: 100%" name="edit_poli" id="edit_poli"  >
                  				<option value="">-Pilih Poli-</option>
                  				<?php 									
                  					foreach($poli as $row1){						
                  						
                  						echo '<option value="'.$row1->id_poli.'">'.$row1->nm_poli.'</option>';											
                  					}
                  				?>
                  			</select>
                      </div>
                    </div>
              		  <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_biaya">Biaya Periksa</p>
                      <div class="col-sm-8">
                        <select  class="form-control select2" style="width: 100%" name="edit_biaya" id="edit_biaya" >
                  				<option value="">-Pilih Biaya Periksa-</option>
                  				<?php 									
                  					foreach($biaya as $row1){						
                  						echo '<option value="'.$row1->idtindakan.'">'.$row1->nmtindakan.'</option>';											
                  					}
                  				?>
                  			</select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Keterangan *</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="edit_ket" id="edit_ket">
                      </div>
                    </div>
                  </div>
    		          <div class="col-sm-6 container">
                    <table width="100%" class="table table-bordered table-condensed">
                      <thead>
                        <tr>
                          <td><b><i>Untuk Dokter :</i></b></td>
                          <td><b><i>Isi Keterangan Dengan :</i></b></td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Instalasi Rawat Darurat</td>
                          <td>Dokter Jaga</td>
                        </tr>
                        <tr>
                          <td>Residen</td>
                          <td>Dokter Residen</td>
                        </tr>
                        <tr>
                          <td>Patologi Anatomi</td>
                          <td>Patologi Anatomi</td>
                        </tr>
                        <tr>
                          <td>Laboratorium</td>
                          <td>Patologi Klinik</td>
                        </tr>
                        <tr>
                          <td>Radiologi</td>
                          <td>Radiologi</td>
                        </tr>
                        <tr>
                          <td>Kamar Operasi</td>
                          <td>Operasi</td>
                        </tr>
                        <tr>
                          <td>Perawat Ruangan IRI</td>
                          <td>Perawat</td>
                        </tr>
                      </tbody>
                      
                    </table>
            		  </div>
            		  <div class="form-group row">
            			<div class="col-sm-1"></div>
            		  </div>
                </div>
		
                <div class="modal-footer">
		  <input type="hidden" class="form-control" name="old_poli" id="old_poli">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit Dokter</button>
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
