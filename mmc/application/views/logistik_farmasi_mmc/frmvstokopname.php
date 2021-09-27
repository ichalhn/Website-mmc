<?php
	$this->load->view('layout/header.php');
?>
<script type='text/javascript'>
$(document).ready(function() {
	$('#example2').DataTable();
	document.getElementById("cari_obat").focus();

	$('#cari_obat').autocomplete({
		serviceUrl: '<?php echo site_url();?>farmasi/Frmcdaftar/cari_data_obat_all',
		onSelect: function (suggestion) {
			$('#cari_obat').val(''+suggestion.nama);
			$("#id_obat").val(suggestion.idobat);
			$('#biaya_obat').val(suggestion.hargabeli);
			$("#harga_jual").val(suggestion.harga);
			$("#expire_date").val(suggestion.expire_date);
			$('#qty').val('1');
			//set_total() ;
		}
	});
});

function hapusSO(id_obat, batch_no){
	$.ajax({
		type: 'POST',
		url:"<?php echo base_url('logistik_farmasi/Frmcstok/delete_stokopname')?>",
		data: {id_obat:id_obat, batch_no:batch_no},
		success: function(data){
			window.location = "<?php echo base_url('logistik_farmasi/Frmcstok/stokOpname')?>";
		},
		error: function(request, error){
			console.log(arguments);
			alert(error);
		}
	});
}
</script>
<section class="content" style="width:97%;margin:0 auto">
	<div class="row">
		<div class="panel panel-info">
     		<div class="panel-body">
     		<?php echo form_open('logistik_farmasi/Frmcstok/insert_stokopname'); ?>
				<div class="form-group row">
					<p class="col-sm-2 form-control-label " id="tindakan">Obat</p>
					<div class="col-sm-6">
						<input type="search" class="form-control" id="cari_obat" name="cari_obat" placeholder="Pencarian Obat">
						<input type="hidden" name="id_obat" id="id_obat">
					</div>
				</div>
				<div class="form-group row">
					<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Beli</p>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="biaya_obat" id="biaya_obat" required>
					</div>
				</div>
				<div class="form-group row">
					<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Jual</p>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="harga_jual" id="harga_jual" required>
					</div>
				</div>
				<div class="form-group row">
					<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Expire Date</p>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="expire_date" id="expire_date" required>
					</div>
				</div>
				<div class="form-group row">
					<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Batch NO</p>
					<div class="col-sm-2">
						<input type="text" class="form-control" name="batch_no" id="batch_no" required>
					</div>
				</div>
				<div class="form-group row">
					<p class="col-sm-2 form-control-label" id="lbl_qtyind">Quantity Hasil SO</p>
					<div class="col-sm-2">
						<input type="number" class="form-control" name="qty" id="qty" min=1 required="">
					</div>
				</div>
				<div class="form-group row">
					<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Jenis Obat</p>
					<div class="col-sm-3">
						<select  class="form-control" style="width: 100%" name="jenis_obat" id="jenis_obat" required>
							<option value="">-Pilih Jenis-</option>
							<option value="ALKES">ALKES</option>
							<option value="BEBAS">BEBAS</option>
							<option value="INFUS">INFUS</option>
							<option value="INHALER">INHALER</option>
							<option value="INJEKSI">INJEKSI</option>
							<option value="KULKAS">KULKAS</option>
							<option value="NARKOTIK">NARKOTIK</option>
							<option value="PSIKOTROPIK">PSIKOTROPIK</option>
							<option value="SIRUP">SIRUP</option>
							<option value="SALEP">SALEP</option>
							<option value="TABLET">TABLET</option>
							<option value="TETES">TETES</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			<?php echo form_close();?>
     		</div><!-- end panel body -->
    	</div><!-- end panel info-->
    	<div class="panel panel-info">
    		<div class="panel-body">
    			<h3>Data Stok Opname</h3>
				<table id="example2" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th width="2%"><div align="center">ID<br>OBAT</div></th>
							<th><div align="center">NAMA OBAT</div></th>
							<th><div align="center">HARGA<br>BELI</div></th>
							<th><div align="center">HARGA<br>JUAL</div></th>
							<th><div align="center">JENIS OBAT<</div></th>
							<th><div align="center">EXPIRE<br>DATE</div></th>
							<th><div align="center">BATCH NO</div></th>
							<th><div align="center">QTY<br>SO</div></th>
							<th><div align="center">OPS</div></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=1;
						foreach($data_so as $row){
						?>
						<tr>
							<td><div align="center"><?php echo $row->id_obat;?></div></td>
							<td><?php echo $row->nm_obat;?></td>
							<td><div align="right"><?php echo number_format($row->hargabeli, '0', ',', '.');?></div></td>
							<td><div align="right"><?php echo number_format($row->hargajual, '0', ',', '.');?></div></td>
							<td><?php echo $row->jenis_obat;?></td>
							<td><div align="center"><?php echo $row->expire_date;?></div></td>
							<td><div align="center"><?php echo $row->batch_no;?></div></td>
							<td><div align="right"><?php echo number_format($row->qty, '0', ',', '.');?></div></td>
							<td>
								<button type="button" class="btn btn-block btn-danger btn-xs" onclick="hapusSO(<?=$row->id_obat?>, '<?=$row->batch_no?>')">Hapus</button>
								<button type="button" class="btn btn-block btn-info btn-xs" 
								onclick='window.location="<?php echo base_url('logistik_farmasi/Frmcstok/edit_hasil_so/'.$row->id_obat)?>"'>Ubah</button>
							</td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
     		</div>
    	</div>
   	</div><!-- end div id home -->
	<div class="modal fade" id="modal-edit" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
					<h4 class="modal-title">Ubah Hasil SO</h4>
				</div>
				<div id="edit_container">

				</div>
			</div>
		</div>
	</div>
</section>