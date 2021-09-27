<?php
	$this->load->view('layout/header.php');
?>
<html>
<script type='text/javascript'>
//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#example').DataTable({
    	"pageLength":100
    });
    $("#warn_kartu").hide();
	$('#input_kontraktor').hide();
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

var intervalSetting = function () {
		location.reload();
	};
setInterval(intervalSetting, 60000);
</script>
<script type='text/javascript'>
function edit_cara_bayar(no_register) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('irj/rjcpelayanan/get_data_by_register')?>",
      data: {
        no_register: no_register
      },
      success: function(data){
        $('#no_reg_hidden').val(data[0].no_register);
        $('#no_reg').val(data[0].no_register);
        $('#nm_pasien').val(data[0].nama);
      },
      error: function(){
        alert("error");
      }
    });
  }
var ajaxku;
var site = "<?php echo site_url();?>";
function pilih_cara_bayar(val_cara_bayar){
	if(val_cara_bayar=='DIJAMIN'){
		$('#input_kontraktor').show();

		document.getElementById("id_kontraktor").required = true;
		ajaxku = buatajax();
	    var url="<?php echo site_url('irj/rjcregistrasi/data_kontraktor'); ?>";
	    url=url+"/"+val_cara_bayar;
	    url=url+"/"+Math.random();
	    ajaxku.onreadystatechange=stateChangedKontraktor;
	    ajaxku.open("GET",url,true);
	    ajaxku.send(null);

	}else if(val_cara_bayar=='BPJS'){
		$('#input_kontraktor').show();
		document.getElementById("id_kontraktor").required = true;
		ajaxku = buatajax();
	    var url="<?php echo site_url('irj/rjcregistrasi/data_kontraktor'); ?>";
	    url=url+"/"+val_cara_bayar;
	    url=url+"/"+Math.random();
	    ajaxku.onreadystatechange=stateChangedKontraktor;
	    ajaxku.open("GET",url,true);
	    ajaxku.send(null);

	}else{
		$('#input_kontraktor').hide();
		document.getElementById("id_kontraktor").required = false;
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
function stateChangedKontraktor(){
    var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("id_kontraktor").innerHTML = data;
		}
    }
}

  
</script>
	<section class="content-header">
			<?php
				echo $this->session->flashdata('success_msg');
				echo $this->session->flashdata('notification');				
				echo $this->session->flashdata('notification_sep');				
			?>
				
			</section>
			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<!-- <div class="box-header">
								<h3 class="box-title">Daftar Antrian Pasien Poli <b></b></h3>
							</div> -->
							<div class="box-body">
								
								<!-- <?php echo form_open('irj/rjcpelayanan/kunj_pasien_poli_by_date');?> -->
						
								<!-- <div class="input-group" style="width: 20%;">
								  <input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required> -->
								  <!-- <input type="hidden" class="form-control" name="id_poli" value="<?php echo $id_poli;?>"> -->
								  <!-- <span class="input-group-btn">
									<button class="btn btn-primary" type="submit">Cari</button>
								  </span> -->
								</div><!-- /input-group -->
								
								<!-- <?php echo form_close();?> -->
								
								<table id="example" class="display" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>No Antrian</th>
											  <th>Tanggal Kunjungan</th>
											  <th>No Medrec</th>
											  <th>No Registrasi</th>
											  <th>Nama</th>
											  <th>Status</th>
											  <th>Kelas</th>
											  <th>Aksi</th>	
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>No Antrian</th>
											<th>Tanggal Kunjungan</th>
											<th>No Medrec</th>
											<th>No Registrasi</th>
											<th>Nama</th>
											<th>Status</th>
											<th>Kelas</th>
											<th>Aksi</th>
										</tr>
									</tfoot>
									<tbody>
										<?php
											// print_r($pasien_daftar);
											$i=1;
												foreach($pasien_daftar as $row){
												$no_register=$row->no_register;	
										?>
										<tr>
											<td><?php echo $row->no_antrian;?></td>
											<td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan)).' | '.date("H:i", strtotime($row->tgl_kunjungan));?></td>
											<td><?php echo $row->no_cm;?></td>
											<?php if($row->cara_bayar=='UMUM' and $row->unpaid>0 ){
												?>
											<td style="color: red !important;"><?php echo $row->no_register;?></td>
												<?php } else {?>
											<td><?php echo $row->no_register;?></td>
												<?php }?>
											<td><?php echo strtoupper($row->nama);?> </td>
											<td><?php echo strtoupper($row->cara_bayar);?></td>
											<td><?php echo $row->kelas_pasien;?></td>
											<td>
												<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal" onclick="edit_cara_bayar('<?php echo $row->no_register;?>')"><span> Edit Cara Bayar</span></button>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								<?php
									//echo $this->session->flashdata('message_nodata'); 
								?>								
							</div>
						</div>
					</div>

					<!-- Modal Edit Status-->
					<?php echo form_open('irj/rjcpelayanan/edit_cara_bayar');?>
		<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Obat Baru</h4>
                </div>
                <div class="modal-body">
                <input type="hidden" class="form-control" name="no_reg_hidden" id="no_reg_hidden">
                  
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">No Register</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="no_reg" id="no_reg" disabled>
                    </div>
                  </div>

                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Pasien</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nm_pasien" id="nm_pasien" disabled>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">Cara Bayar</p>
                    <div class="col-sm-6">
                      	<select id="cara_bayar" class="form-control" style="width: 100%" name="cara_bayar" onChange="pilih_cara_bayar(this.value)" required>
							<option value="">-Pilih Cara Bayar-</option>
								<?php
									foreach($cara_bayar as $row){
										echo '<option value="'.$row->cara_bayar.'">'.$row->cara_bayar.'</option>';
									}
								?>
						</select>
                    </div>
                  </div>

                  <div class="form-group row" id="input_kontraktor">
                  				<div class="col-sm-1"></div>
									<p class="col-sm-3 control-label" id="lbl_input_kontraktor">Dijamin Oleh</p>
									<div class="col-sm-6">
										<div class="form-inline">
												<select id="id_kontraktor" class="form-control select2" style="width: 100%" name="id_kontraktor">
													<option value="">-Pilih Penjamin-</option>
													
												</select>
										</div>
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
			</section>
<?php
	$this->load->view('layout/footer.php');
?>	
