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

   $('.month_picker').datepicker({
      format: "yyyy-mm",
      endDate: '0',
      autoclose: true,
      todayHighlight: true,
    });  
  }); 

  function edit_nrl(id_nrl) {
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
	$('#edit_koderek').val(data[0].koderek).change();
	$('#edit_koderek_akhir').val(data[0].koderek_akhir).change();
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
          <h3 class="box-title">Transaksi NRL</h3>
		<hr>
        </div>
	
        <div class="box-body ">		 
          <div class="col-xs-9">
          </div>    

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
		  $id_nrl=$row->id_nrl;
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->param1;?></td>
                <td><?php echo $row->param2;?></td>
                <td><?php echo $row->param3;?></td>		
		<td><?php if($row->tipe=='N'){ echo 'Neraca';}else echo 'Rugi/Laba';?></td>
                <td><?php echo '('.$row->koderek.') '.$row->perkiraan; if($row->koderek_akhir!=''){echo ' <b>s/d</b> ('.$row->koderek_akhir.') '.$row->perkiraanakhir;}?></td>
                <td>
                  <a type="button" class="btn btn-primary btn-xs" href="<?php echo base_url('akun/crsnrl/transaksi/'.$id_nrl); ?>"><i class="fa fa-plus"></i></a>	  
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
