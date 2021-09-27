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

  function edit_rekening(kode) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('akun/crsakun/get_data_edit_rekening')?>",
      data: {
        kode: kode
      },
      success: function(data){
	//alert(data[0].nrl);
        $('#edit_kode').val(data[0].kode);
        $('#edit_kode_hidden').val(data[0].kode);
        $('#edit_perkiraan').val(data[0].perkiraan);
	$('#edit_tipe').val(data[0].tipe);
        $('#edit_jenis_tl').val(data[0].tl);
        $('#edit_nb').val(data[0].nb);
	$('#edit_nrl').val(data[0].nrl);
	$('#edit_upkode').val(data[0].upkode);
	if(data[0].statusflag==null){
		$('#edit_flag').val(0);
	} else 	$('#edit_flag').val(data[0].statusflag);
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
        <div class="box-body ">

          <div class="col-xs-9">
          </div>

          <?php echo form_open('akun/crsakun/insert_koderekening');?>
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> Kode Rekening</i> </button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->
		<br>
          <!-- Modal Insert Obat -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Kode Rekening</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_kode_rek">Kode Rekening</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="kode_rek" id="kode_rek" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_perkiraan">Perkiraan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="perkiraan" id="perkiraan" required>
                    </div>
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_tl">TL</p>
                    <div class="col-sm-6">
                      	<select  class="form-control" style="width: 100%" name="jenis_tl" id="jenis_tl" required >
				<option value="">-Pilih jenis TL-</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>				
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
			</select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_tipe">Tipe</p>
                    <div class="col-sm-6">
                      <select  class="form-control" style="width: 100%" name="jenis_tipe" id="jenis_tipe" required >
				<option value="">-Pilih Tipe-</option>
				<option value="TOTAL">TOTAL</option>
				<option value="JURNAL">JURNAL</option>
			</select>
                    </div>
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nb">NB</p>
                    <div class="col-sm-6">
                      <select  class="form-control" style="width: 100%" name="jenis_nb" id="jenis_nb"  >
				<option value="">-Pilih NB-</option>
				<option value="K">KREDIT</option>
				<option value="D">DEBET</option>
			</select>
                    </div>
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nrl">NRL</p>
                    <div class="col-sm-6">
                      <select  class="form-control" style="width: 100%" name="jenis_nrl" id="jenis_nrl"  >
				<option value="">-Pilih NRL-</option>
				<option value="N">NERACA</option>
				<option value="R">RUGI LABA</option>
			</select>
                    </div>
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_upkode">Upkode</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="upkode" id="upkode">
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
		<th>KODE</th>
		<th>PERKIRAAN</th>
                <th>TL</th>
		<th>TIPE</th>
                <th>NB</th>
                <th>NRL</th>
                <th>Upkode</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
		<th>KODE</th>
		<th>PERKIRAAN</th>
                <th>TL</th>
		<th>TIPE</th>
                <th>NB</th>
                <th>NRL</th>
                <th>Upkode</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $i=1;
                  foreach($rekening as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->kode;?></td>
                <td><?php echo $row->perkiraan;?></td>
                <td><?php echo $row->tl;?></td>
                <td><?php echo $row->tipe;?></td>
				<td><?php echo $row->nb;?></td>
                <td><?php echo $row->nrl;?></td>
				<td><?php echo $row->upkode;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_rekening('<?php echo $row->kode;?>')"><i class="fa fa-edit"></i></button>	
					<a type="button" href="<?php echo base_url('akun/crsakun/delete_rekening/').'/'.$row->kode;?>" class="btn btn-danger btn-xs" ><i class="fa fa-trash"></i></a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('akun/crsakun/edit_rekening');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Kode Rekening</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Kode</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_kode" id="edit_kode" disabled="true">
                      <input type="hidden" class="form-control" name="edit_kode_hidden" id="edit_kode_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Perkiraaan</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_perkiraan" id="edit_perkiraan" required>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">TL</p>
                    <div class="col-sm-6">
                      	<select  class="form-control" style="width: 100%" name="edit_jenis_tl" id="edit_jenis_tl" required >
				<option value="">-Pilih jenis TL-</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
				<option value="6">6</option>
				<option value="7">7</option>
				<option value="8">8</option>
				<option value="9">9</option>
			</select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_tipe">Tipe</p>
                    <div class="col-sm-6">
                      <select  class="form-control" style="width: 100%" name="edit_tipe" id="edit_tipe" required >
				<option value="">-Pilih Tipe-</option>
				<option value="TOTAL">TOTAL</option>
				<option value="JURNAL">JURNAL</option>
			</select>
                    </div>
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nb">NB</p>
                    <div class="col-sm-6">
                      <select  class="form-control" style="width: 100%" name="edit_nb" id="edit_nb"  >
				<option value="">-Pilih NB-</option>
				<option value="K">KREDIT</option>
				<option value="D">DEBET</option>
			</select>
                    </div>
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nrl">NRL</p>
                    <div class="col-sm-6">
                      <select  class="form-control" style="width: 100%" name="edit_nrl" id="edit_nrl"  >
				<option value="">-Pilih NRL-</option>
				<option value="N">NERACA</option>
				<option value="R">RUGI LABA</option>
			</select>
                    </div>
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_upkode">Upkode</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_upkode" id="edit_upkode">
                    </div>
                  </div>
		   

                </div>
                <div class="modal-footer">
		  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xupdate">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                  <button class="btn btn-primary" type="submit">Simpan</button>
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
