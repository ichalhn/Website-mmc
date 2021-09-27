<?php
  $this->load->view('layout/header.php');
?>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
	$(".select2").select2();
    	$('.example').DataTable();
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

     $('.month_picker').datepicker({
      	format: "yyyy",
	endDate: "current",
	autoclose: true,
	todayHighlight: true,
	viewMode: "years", 
	minViewMode: "years",
    }); 
  }); 

  function edit_nrl(id_trans_nrl) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('akun/crsnrl/get_data_edit_trans_nrl')?>",
      data: {
        id_trans_nrl: id_trans_nrl
      },
      success: function(data){
	//alert(data[0].id_nrl);
	
	$('#edit_id_nrl').text(data[0].id_nrl);
        $('#edit_id_nrl_hidden').val(data[0].id_nrl);
	$('#edit_id_trans_nrl_hidden').val(data[0].id_transaksi_nrl);
        $('#edit_bulan').text(dateFormat(data[0].bulan));
        $('#edit_nilai').val(data[0].nilai);
      },
      error: function(){
        alert("error");
      }
    });
  }

  function dateFormat(date1){
	var monthNames = [
	  "January", "February", "March",
	  "April", "May", "June", "July",
	  "August", "September", "October",
	  "November", "December"
		];

	var date = new Date(date1);
	var day = date.getDate();
	var monthIndex = date.getMonth();
	var year = date.getFullYear();

	console.log(day, monthNames[monthIndex], year);
	return monthNames[monthIndex] + ' ' + year;
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
          <h3 class="box-title">INPUT NRL</h3>
		<hr>
        </div>
	
        <div class="box-body ">
		<?php echo form_open('akun/crsnrl/add_new_transnrl');?>
			<div class="form-group row">
		            <div class="col-sm-1"></div>
		            <p class="col-sm-1 form-control-label" id="lbl_param1">Tipe</p>
		            <div class="col-sm-6">
		              <input type="text" class="form-control" name="detail_tipe" value="<?php if($detail_nrl->tipe=='N'){ echo 'Neraca';}else echo 'Rugi/Laba';?>" id="detail_tipe" disabled>
		            </div>
		          </div>			
		 	<div class="form-group row">
		            <div class="col-sm-1"></div>
		            <p class="col-sm-1 form-control-label" id="lbl_param1">Param 1</p>
		            <div class="col-sm-6">
		              <input type="text" class="form-control" name="detail_param1" value="<?php echo $detail_nrl->param1;?>" id="detail_param1" disabled>
		            </div>
		          </div>
		          <div class="form-group row">
		            <div class="col-sm-1"></div>
		            <p class="col-sm-1 form-control-label" id="lbl_param2">Param 2</p>
		            <div class="col-sm-6">
		             <input type="text" class="form-control" id="detail_param2" name="detail_param2" value="<?php echo $detail_nrl->param2;?>" disabled>
		            </div>
		          </div>
			  <div class="form-group row">
		            <div class="col-sm-1"></div>
		            <p class="col-sm-1 form-control-label" id="lbl_param3">Param 3</p>
		            <div class="col-sm-6">
		             <input type="text" class="form-control" id="detail_param3" name="detail_param3" value="<?php echo $detail_nrl->param3;?>" disabled>
		            </div>
		          </div>			  
			  <div class="form-group row">
		            <div class="col-sm-1"></div>
		            <p class="col-sm-1 form-control-label" id="lbl_bulan">Tahun</p>
		            <div class="col-sm-6">
		             <input type="text" class="form-control month_picker" placeholder="yyyy" id="detail_year" name="detail_year" >
		            </div>
		          </div>
			  <!--<div class="form-group row">
		            <div class="col-sm-1"></div>
		            <p class="col-sm-3 form-control-label" id="lbl_nilai">Nilai</p>
		            <div class="col-sm-6">
				<div class="input-group">
					 <span class="input-group-addon">Rp</span>
				             <input type="text" class="form-control" placeholder="" id="detail_nilai" name="detail_nilai" >
				</div>
		            </div>-->
		          </div>
			<div>
			<div class="form-group row">
		            
		          </div>
				<div class="col-sm-1"></div>
				<input type="hidden" id="id_nrl_hidden" name="id_nrl_hidden" value="<?php echo $detail_nrl->id_nrl;?>">
				<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
				<button id="btn-voucher" class="btn btn-primary " type="submit"><i class="fa fa-plus"></i> Transaksi NRL</button>
				 				
			</div>
			<?php echo form_close();?>
		<hr>
          <div class="col-xs-9">
          </div>          
		<?php $id_nrl=$detail_nrl->id_nrl; foreach($year_nrl as $row1){ ?>
		<div class="panel box box-danger">
                  <div class="box-header with-border">
                    <h4 class="box-title" >
                      <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $row1->year;?>">
                        Tahun <?php echo $row1->year;?>
                      </a>
                    </h4>
                  </div>
                  <div id="<?php echo $row1->year;?>" class="panel-collapse collapse">
                    <div class="box-body">
			
			
                     <table id="" class="display example" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
		<th>Bulan</th>
		<th>Tahun</th>
		<th>Nilai</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
		<th>Bulan</th>
		<th>Tahun</th>
		<th>Nilai</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              	<?php
                  $i=1;
		  
                  foreach($trans_nrl as $row){
			if($row1->year==date('Y', strtotime($row->bulan))){
			$id_transaksi_nrl=$row->id_transaksi_nrl;
              ?>
              <tr>
                <td><?php echo $i++;?></td>               
		<td><?php echo date('M', strtotime($row->bulan));?></td>
		<td><?php echo date('Y', strtotime($row->bulan));?></td>
                <td><?php echo number_format($row->nilai, 2 , ',' , '.' );?></td>
		<td>
                  	<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="edit_nrl('<?php echo $row->id_transaksi_nrl;?>',<?php echo $row->bulan;?>)"><i class="fa fa-edit"></i></button> 
                </td>
              </tr>
              <?php }} ?>
            </tbody>
          </table>
	<br>
	<div class="col-xs-9">
          </div> 
	  <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <a type="button" href="<?php echo base_url('akun/crsnrl/delete_trans_nrl/'.$id_nrl.'/'.$row1->year); ?>" class="btn btn-danger " ><i class="fa fa-trash"></i> Hapus</a>
              </span>
            </div><!-- /input-group --> 
          </div>
		
                    </div><hr>
                  </div> <?php } ?>
                </div>   
  </div>
</section>

<?php echo form_open('akun/crsnrl/edit_nilai_nrl');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Nilai NRL</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id</p>
                    <div class="col-sm-6">
                      <p name="edit_id_nrl" id="edit_id_nrl" ></p>
                      <input type="hidden" class="form-control" name="edit_id_nrl_hidden" id="edit_id_nrl_hidden">
			 <input type="hidden" class="form-control" name="edit_id_trans_nrl_hidden" id="edit_id_trans_nrl_hidden">
                    </div>
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <b><p class="col-sm-3 form-control-label">Bulan</p></b>
                    <div class="col-sm-6">                      	
			<b><p name="edit_bulan" id="edit_bulan" ></p></b>
                    </div>			
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nilai</p>
                    <div class="col-sm-6">                      	
			<input type="text" class="form-control" placeholder="ex: 100000000" name="edit_nilai" id="edit_nilai" required >
                    </div>			
                  </div>                  
                </div>
                <div class="modal-footer">
		  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit"><i class="fa fa-edit"></i> Transaksi NRL</button>		  
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close();?>
<?php
  $this->load->view('layout/footer.php');
?>
