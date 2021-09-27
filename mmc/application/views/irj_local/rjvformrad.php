<script type='text/javascript'>

//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#tabel_radtind').DataTable();	
  $(".select2").select2();
} );
//---------------------------------------------------------

var site = "<?php echo site_url();?>";
		
function pilih_tindakan_rad(id_tindakan) {
   // alert("<?php echo site_url('irj/rjcpelayanan/get_biaya_tindakan'); ?>");
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('rad/radcdaftar/get_biaya_tindakan')?>",
		data: {
			id_tindakan: id_tindakan,
			kelas : "<?php echo $kelas_pasien ?>"
		},
		success: function(data){
			//alert(data);
			/*
			$('#biaya_tindakan').val(data[0]);
			$('#biaya_tindakan').maskMoney('mask');
			$('#biaya_tindakan_hide').val(data[0]);
			*/
			$('#biaya_rad').val(data);
			$('#biaya_rad_hide').val(data);
			$('#biaya_rad').maskMoney('mask');
			$('#qty_rad').val('1').change();			
		},
		error: function(){
			alert("error");
		}
    });
}

function set_total_rad() {
	var total = $("#biaya_rad_hide").val() * $("#qty_rad").val();	
	$('#vtot_rad').val(total);
	$('#vtot_rad').maskMoney('mask');
	$('#vtot_rad_hide').val(total);
}

</script>


<div class="panel-body">
	
		<div class="well">
		
		<?php echo form_open('irj/rjcpelayanan/insert_rad'); ?>
			<div class="form-group row">
				<p class="col-sm-2 form-control-label" id="nmdokter">Dokter</p>
					<div class="col-sm-5">
						
							<!--<input type="search" style="width:100%" class="auto_search_tindakan form-control" placeholder="" id="nmtindakan" name="nmtindakan" required>
							<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan"  name="idtindakan">-->
						<select id="id_dokter" class="form-control select2" name="id_dokter"  required style="width:100%;">
						<option value="" disabled selected="">-Pilih Dokter-</option>
						<?php foreach($dokter_rad as $row){
							echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
						} ?>
						</select>
					
				</div>
			</div>
			<div class="form-group row">
				<p class="col-sm-2 form-control-label" id="tindakan">Pemeriksaan</p>
					<div class="col-sm-5">
					<!--
					<input type="search" style="width:100%" class="auto_search_tindakan form-control" placeholder="" id="nmtindakan" name="nmtindakan" required>
					<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan"  name="idtindakan">-->
					<select id="idtindakan" class="form-control select2" name="idtindakan" onchange="pilih_tindakan_rad(this.value)" required style="width:100%;">
					<option value="" disabled selected="">-Pilih Pemeriksaan-</option>
					<?php foreach($tindakan_rad as $row){ 
						echo '<option value="'.$row->idtindakan.'">'.$row->nmtindakan.'</option>';
					}?>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Biaya Pemeriksaan</p>
					<div class="col-sm-3">
						<div class="input-group">
						<span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" value="<?php //echo $biaya_rad; ?>" name="biaya_rad" id="biaya_rad" disabled>
						<input type="hidden" class="form-control" value="" name="biaya_rad_hide" id="biaya_rad_hide">
					</div></div>
			</div>
			<div class="form-group row">
				<p class="col-sm-2 form-control-label" id="lbl_qtyind">Qtyind</p>
					<div class="col-sm-2">
						<input type="number" class="form-control" name="qty_rad" id="qty_rad" min=1 onchange="set_total_rad(this.value)">				</div>
			</div>
			<div class="form-group row">
				<p class="col-sm-2 form-control-label" id="lbl_vtot">Total</p>
					<div class="col-sm-3">
						<div class="input-group">
						 <span class="input-group-addon">Rp</span>
						 <input type="text" class="form-control" name="vtot_rad" id="vtot_rad" disabled>
						 <input type="hidden" class="form-control" value="" name="vtot_rad_hide" id="vtot_rad_hide">
					</div></div>
			</div>
			<div class="form-inline" align="right">
				<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kunj">
				<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
				<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
				<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
				<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
				<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
				<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
				<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
			<?php	if($no_rad!=''){ echo "<input type='hidden' class='form-control' value=".$no_rad." name='no_rad'>";
				} else { //echo "<input type='hidden' class='form-control' value=".$no_rad." name='no_rad'>";
			}?>
			<div class="form-group">
				<button id="button_rad_reset" type="reset" class="btn bg-orange">Reset</button>					
				<button id="button_rad_simpan" type="submit" class="btn btn-primary">Simpan</button>			
			</div>
		</div>
		<?php echo form_close();?>
		<!-- table -->
		<br>
		<div style="display:block;overflow:auto;">
			<table id="tabel_radtind" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
					  	<th>No</th>
					  	<th>Tanggal Pemeriksaan</th>
					  	<th>Dokter</th>
					  	<th>Jenis Pemeriksaan</th>
					  	<th>Biaya Pemeriksaan</th>
					  	<th>Qtyind</th>
					  	<th>Total</th>
					  	<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php
				
				$i=1;
				if($data_rad_pasien!=Array()){
				foreach($data_rad_pasien as $row){
				//$id_pelayanan_poli=$row->id_pelayanan_poli;
				?>
					<tr>
						<td><?php echo $i++ ; ?></td>
						<td><?php echo date("d-m-Y", strtotime($row->xupdate)).' | '. date("H:i", strtotime($row->xupdate)); ?></td>
						<td><?php echo $row->nm_dokter.' ('.$row->id_dokter.')' ; ?></td>
						<td><?php echo $row->jenis_tindakan.' ('.$row->id_tindakan.')' ; ?></td>
						<td><?php echo number_format( $row->biaya_rad, 2 , ',' , '.' );?></td>
						<td><?php echo $row->qty ; ?></td>
						<td><?php echo number_format( $row->vtot, 2 , ',' , '.' );?></td>
						<td><!-- Button trigger modal -->
							<?php if ($a_rad =="closed") {
								echo "<a href=\"javascript: void(0)\" class=\"btn btn-danger btn-xs\">Hapus</a>";
								} else { echo "<a href=\"".site_url("irj/rjcpelayanan/hapus_data_rad/".$row->no_register."/".$row->no_rad.'/'.$row->id_pemeriksaan_rad.'/'.$id_poli)."\" class=\"btn btn-danger btn-xs\">Hapus</a>";
							}?>	
						</td>
					</tr>
					<?php }	} ?>
				</tbody>
				</table>
				</div><!-- style overflow -->
				<br>
				<div class="form-inline" align="right">
					<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
						<div class="form-group">
						<?php	 
							if($rujukan_penunjang->rad=='1' and $rujukan_penunjang->status_rad=='0'){
echo '<a  href="' .site_url('irj/rjcpelayanan/selesai_daftar_rad/'.$no_register.'/'.$id_poli).'" class="btn btn-primary btn-xl">Selesai</a>
';} else { echo '<a   class="btn btn-primary btn-xl" disabled>Selesai</a>';
} ?>									
							<!--<a href="<?php echo site_url('ird/IrDPelayanan/selesai_daftar_rad/'.$no_register); ?>" class="btn btn-primary btn-xl">Selesai</a>-->
						</div>
				</div>
		</div>
				</div>
