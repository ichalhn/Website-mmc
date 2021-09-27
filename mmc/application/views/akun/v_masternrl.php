<?php
  $this->load->view('layout/header.php');
?>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
	$(".select2").select2();
    	$('#example').DataTable();
	$('#param1_lain').hide();
	$('#param2_lain').hide();
	$('#edit_param1_lain').hide();
	$('#edit_param2_lain').hide();
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

  function edit_nrl(id_nrl) {
	$('#edit_koderek_akhir').val('').change();
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('akun/crsnrl/get_data_edit_nrl')?>",
      data: {
        id_nrl: id_nrl
      },
      success: function(data){
	//alert(data[0].id_nrl);
        $('#edit_id_nrl').val(data[0].id_nrl);
        $('#edit_id_nrl_hidden').val(data[0].id_nrl);
        $('#edit_param1').val(data[0].param1).change();
	$('#edit_param2').val(data[0].param2).change();
        $('#edit_param3').val(data[0].param3);
        $('#edit_jenis_tipe').val(data[0].tipe);
	$('#edit_koderek').val(data[0].koderek);$('#edit_koderek').change();
	//var koderekakhir = data[0].koderek_akhir;
	setTimeout(function(){
	  $('#edit_koderek_akhir').val(data[0].koderek_akhir).change();
	}, 1000);
	//$('#edit_koderek_akhir').val(data[0].koderek_akhir);	
      },      
      error: function(){
        alert("error");
      }
    });
  }

  function param1_change(param1){
	if(param1=='a'){
		$('#param1_lain').show();
		$("#param1_lain").prop('required',true);
	}else{
		$('#param1_lain').hide();
		$("#param1_lain").prop('required',false);
	}
  }

  function param2_change(param2){
	if(param2=='a'){
		$('#param2_lain').show();
		$("#param2_lain").prop('required',true);
	}else{
		$('#param2_lain').hide();
		$("#param2_lain").prop('required',false);
	}
  }

   function param1edit_change(param1){
	if(param1=='a'){
		$('#edit_param1_lain').show();
		$("#edit_param1_lain").prop('required',true);
	}else{
		$('#edit_param1_lain').hide();
		$("#edit_param1_lain").prop('required',false);
	}
  }

  function param2edit_change(param2){
	if(param2=='a'){
		$('#edit_param2_lain').show();
		$("#edit_param2_lain").prop('required',true);
	}else{
		$('#edit_param2_lain').hide();
		$("#edit_param2_lain").prop('required',false);
	}
  }

function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}

function ajaxkoderek(id,type){
    //alert(id);
		
    ajaxku = buatajax();
    var url="<?php echo site_url('akun/crsnrl/data_koderek_akhir'); ?>";
    url=url+"/"+id;
	if(type=='a'){
	    ajaxku.onreadystatechange=statekoderek;
	}else ajaxku.onreadystatechange=stateeditkoderek;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);	
}

function statekoderek(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
    document.getElementById("koderek_akhir").innerHTML = data
    }else{
    document.getElementById("koderek_akhir").value = "<option selected>Pilih Kode Rekening Akhir</option>";
    }
    }
}

function stateeditkoderek(){
    var data;
    if (ajaxku.readyState==4){
    	data=ajaxku.responseText;
	    if(data.length>=0){
	    document.getElementById("edit_koderek_akhir").innerHTML = data
	    }else{
	    document.getElementById("edit_koderek_akhir").value = "<option selected>Pilih Kode Rekening Akhir</option>";
	    }
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
          <h3 class="box-title">DAFTAR MASTER NRL</h3>
		<hr>
        </div>
	
        <div class="box-body ">

          <div class="col-xs-9">
          </div>

          <?php echo form_open('akun/crsnrl/insert_master_nrl');?>
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> Master NRL</i> </button>
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
                  <h4 class="modal-title">Tambah Master NRL Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Param 1</p>
                    <div class="col-sm-6">
                      	<select  class="form-control" style="width: 100%" name="param1" id="param1" required onchange="param1_change(this.value)">
				<option value="">-Pilih Param 1-</option>
				<?php 
					foreach($param1 as $row1){
						echo '<option value="'.$row1->param1.'">'.$row1->param1.'</option>';
					}
				?>
				<option value="a">Lainnya</option>
			</select>
			<input type="text" class="form-control" name="param1_lain" id="param1_lain" >
                    </div>			
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Param 2</p>
                    <div class="col-sm-6">
                      	<select  class="form-control" style="width: 100%" name="param2" id="param2" required onchange="param2_change(this.value)">
				<option value="">-Pilih Param 2-</option>
				<?php 
					foreach($param2 as $row1){
						echo '<option value="'.$row1->param2.'">'.$row1->param2.'</option>';
					}
				?>
				<option value="a">Lainnya</option>
			</select>
			<input type="text" class="form-control" name="param2_lain" id="param2_lain" >
                    </div>			
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_perkiraan">Param 3</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="param3" id="param3" required>
                    </div>
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_tipe">Tipe</p>
                    <div class="col-sm-6">
                      <select  class="form-control" style="width: 100%" name="jenis_tipe" id="jenis_tipe" required >
				<option value="">-Pilih Tipe-</option>
				<option value="N">Neraca</option>
				<option value="RL">Rugi/Laba</option>
			</select>
                    </div>
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_tl">Kode Rekening</p>
                    <div class="col-sm-6">
                      	<select  class="form-control select2" style="width: 100%" name="koderek" id="koderek" required onchange="ajaxkoderek(this.value,'a')" >
				<option value="">-Pilih Kode Rekening Awal-</option>
				<?php 
					foreach($rekening as $row1){
						echo '<option value="'.$row1->kode.'">('.$row1->kode.') '.$row1->perkiraan.'</option>';
					}
				?>
			</select>			
                    </div>
                  </div>		                    		  
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" ></p>
                    <div class="col-sm-6">
                      	<select  class="form-control select2" style="width: 100%" name="koderek0" id="koderek_akhir" required >
				<option value="">-Pilih Kode Rekening Akhir-</option>				
			</select>			
                    </div>			
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Insert Master NRL</button>
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
		<th>Param 1</th>
		<th>Param 2</th>
                <th>Param 3</th>
		<th>Tipe</th>
		<th>Kode Rekening</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
		<th>Param 1</th>
		<th>Param 2</th>
                <th>Param 3</th>
		<th>Tipe</th>
		<th>Kode Rekening</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $i=1;
                  foreach($master_nrl as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->param1;?></td>
                <td><?php echo $row->param2;?></td>
                <td><?php echo $row->param3;?></td>		
		<td><?php if($row->tipe=='N'){ echo 'Neraca';}else echo 'Rugi/Laba';?></td>
                <td><?php echo '('.$row->koderek.') '.$row->perkiraan; if($row->koderek_akhir!=''){echo ' <b>s/d</b> ('.$row->koderek_akhir.') '.$row->perkiraanakhir;}?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_nrl('<?php echo $row->id_nrl;?>')"><i class="fa fa-edit"></i></button>	 <a type="button" class="btn btn-danger btn-xs" href="<?php echo base_url('akun/crsnrl/delete_nrl/'.$row->id_nrl); ?>"><i class="fa fa-trash"></i></a>	  
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <?php echo form_open('akun/crsnrl/edit_nrl');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Master NRL</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_id_nrl" id="edit_id_nrl" disabled="true">
                      <input type="hidden" class="form-control" name="edit_id_nrl_hidden" id="edit_id_nrl_hidden">
                    </div>
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Param 1</p>
                    <div class="col-sm-6">
                      	<select  class="form-control" style="width: 100%" name="edit_param1" id="edit_param1" required onchange="param1edit_change(this.value)">
				<option value="">-Pilih Param 1-</option>
				<?php  
					foreach($param1 as $row1){
							echo '<option value="'.$row1->param1.'">'.$row1->param1.'</option>';
						
					}
				?>
				<option value="a">Lainnya</option>
			</select>
			<input type="text" class="form-control" name="edit_param1_lain" id="edit_param1_lain" >
                    </div>			
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Param 2</p>
                    <div class="col-sm-6">
                      	<select  class="form-control" style="width: 100%" name="edit_param2" id="edit_param2" required onchange="param2edit_change(this.value)">
				<option value="">-Pilih Param 2-</option>
				<?php 					
					foreach($param2 as $row1){						
						
							echo '<option value="'.$row1->param2.'">'.$row1->param2.'</option>';
						
					}
				?>
				<option value="a">Lainnya</option>
			</select>
			<input type="text" class="form-control" name="edit_param2_lain" id="edit_param2_lain" >
                    </div>			
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_perkiraan">Param 3</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_param3" id="edit_param3" required>
                    </div>
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_tipe">Tipe</p>
                    <div class="col-sm-6">
                      <select  class="form-control" style="width: 100%" name="edit_jenis_tipe" id="edit_jenis_tipe" required >
				<option value="">-Pilih Tipe-</option>
				<option value="N">Neraca</option>
				<option value="RL">Rugi/Laba</option>
			</select>
                    </div>
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_tl">Kode Rekening</p>
                    <div class="col-sm-6">
                      	<select  class="form-control select2" style="width: 100%" name="edit_koderek" id="edit_koderek" onchange="ajaxkoderek(this.value,'b')" required >
				<option value="">-Pilih Kode Rekening Awal-</option>
				<?php 
					foreach($rekening as $row1){
						echo '<option value="'.$row1->kode.'">('.$row1->kode.') '.$row1->perkiraan.'</option>';
					}
				?>
			</select>			
                    </div>			
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" ></p>
                    <div class="col-sm-6">
                      	<select  class="form-control select2" style="width: 100%" name="edit_koderek_akhir" id="edit_koderek_akhir"  >
				
				<option value="">-Pilih Kode Rekening Akhir-</option>	
				
			</select>			
                    </div>			
                  </div>

                </div>
                <div class="modal-footer">
		  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit Master NRL</button>
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
