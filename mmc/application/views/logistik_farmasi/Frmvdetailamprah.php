<?php
	$this->load->view('layout/header.php');
	$i=1;
?>
<html>

<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2({
            placeholder: "Select an option"
        });
});

$(function() {
  $('#date_picker').datepicker({
      format: "yyyy-mm-dd",
      
      autoclose: true,
      todayHighlight: true,
    });  
  	
  });
  
</script>
<script type="text/javascript">

//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#tabel_receiving').DataTable();
} );
//---------------------------------------------------------

var site = "<?php echo site_url();?>";

function pilih_tindakan(idobat) {
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('logistik_farmasi/Frmcpembelian/get_biaya_obat')?>",
		data: {
			idobat: idobat
		},
		success: function(data){
			//alert(data);
			$('#biaya_obat').val(data);
			$('#biaya_obat_hide').val(data);
			$('#qty').val('1');
			set_total() ;
		},
		error: function(){
			alert("error");
		}
    });
}



function set_total() {
	var biaya_obat = $('input[name=biaya_obat]').val();
	var qty_obat = $('input[name=qty]').val();
	var ttl = biaya_obat * qty_obat;
	var total =ttl+(ttl*0.1);

	$('#vtot_x').val(total);
	$('#vtot_x_hide').val(total);
}

function reset() {
	document.getElementById("insert").reset();
	$('#idobat').select2('data', '').change();
	$('#idobat').select2('val','').change();
	$('#idobat').empty().trigger('change');

}

/*function insert_total(){
	var jumlah = $('#jumlah').val();

	// bawah
	//qty di set 1 karena hasil dari perhitungan sendiri


	var val = $('select[name=idobat]').val();
	var temp = val.split("-");

	$('#biaya_obat').val(jumlah);
	$('#biaya_obat_hide').val(jumlah);
	var qty = 1;
	$('#qty').val(1)
	var total = qty * jumlah;
	$('#vtot_x').val(total);

	$.ajax({
		type:'POST',
		dataType: 'json',
		//url:"<?php echo base_url('farmasi/Frmcpembelian/get_biaya_obat')?>",
		data: {
			idobat: "<?php echo $id_obat ?>",
			qty : qty
		},
		success: function(data){
			//alert(data);
			$('#vtot_x').val(data);
			$('#vtot_x_hide').val(data);
		},
		error: function(){
			alert("error");
		}
    });
}*/


</script>
<section class="content-header">
	<?php echo $this->session->flashdata('success_msg');?>
</section>
<?php
include('Frmvamprah.php');
?>
<section class="content" style="width:97%;margin:0 auto">
 <div class="row">

  <div class="tab-content">
    <div class="panel panel-info">
     <div class="panel-body">
     <?php echo form_open('logistik_farmasi/Frmcamprah/insert_amprah'); ?>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label " id="tindakan">Obat</p>
										<div class="col-sm-10">
											<div class="form-inline">
												<div class="form-group">
													<select id="id_obat" class="form-control js-example-basic-single" name="id_obat" onchange="pilih_tindakan(this.value)" required>
														<option value="">-Pilih Obat-</option>
														<?php
															foreach($data_obat as $row){
																echo '<option value="'.$row->id_obat.'">'.$row->nm_obat.'</option>';
															}
														?>
													</select>
												</div>
											</div>
										</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qtyind">Quantity Amprah</p>
									<div class="col-sm-2">
										<input type="number" class="form-control" name="qty_amprah" id="qty_amprah" min=1>
									</div>
								</div>
								<div class="form-group">
									<button type="reset" class="btn bg-orange" onclick="reset()" value="Reset Form">Reset</button>
									<button type="submit" class="btn btn-primary">Simpan</button>
								</div>
			</div>
							<div class="form-inline" align="right">
								<input type="hidden" class="form-control" value="<?php echo $id_amprah;?>" name="id_amprah">
								<input type="hidden" class="form-control" value="<?php echo $i;?>" name="line">
								<input type="hidden" class="form-control" value="<?php echo $tgl_amprah;?>" name="tgl
								_amprah">
								<input type="hidden" class="form-control" value="<?php echo $user;?>" name="user">
								
 							</div>
		     </div>
							<?php echo form_close();?>
     </div><!-- end panel body -->
   </div><!-- end div id home -->
  
   
    <div class="panel panel-info">
     <div class="panel-body">
    			<div class="form-group row">
    			<div class="col-sm-12">
						<table id="tabel_receiving" class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
					<th>No</th>
					<th>Item Obat</th>
					<th>Qty Amprah</th>
					<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php
									// print_r($pasien_daftar);
									$ppn=10;
										foreach($data_receiving_amprah as $row){
										//$id_pelayanan_poli=$row->id_pelayanan_poli;
									?>
										<tr>
											<td><?php echo $i++ ; ?></td>
											<td><?php echo $row->nama_obat; ?></td>
											<td><?php echo $row->qty_req; ?></td>
											<td><a href="<?php echo site_url("logistik_farmasi/Frmcamprah/hapus_data_amprah/".$row->id_amprah."/".$row->id_obat);?>" class="btn btn-danger btn-xs">Hapus</a></td>

										</tr>
									<?php
										}
									?>
							</tbody>
						</table>

				</div>
				</div>

	
   </div>
  </div>
	<?php
echo form_open('logistik_farmasi/Frmcamprah/faktur_amprah');?>

		<div class="form-inline" align="right">
	<div class="input-group">
			<div class="form-group">
				<button class="btn btn-primary">Selesai & Cetak</button>
				<input type="hidden" name="faktur_hidden" value="<?php echo $id_amprah ; ?>"></input>
			</div>
		</div>
	</div>
	<?php
	echo form_close();
	 ?>
 </div>

 </section>
						</div>
						<br>
					</div>

		</section>
<?php
	$this->load->view('layout/footer.php');
?>
