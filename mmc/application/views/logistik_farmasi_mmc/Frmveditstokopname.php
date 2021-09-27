<?php
	$this->load->view('layout/header.php');
?>
<script type='text/javascript'>
$(document).ready(function() {
	$('#example2').DataTable();
	document.getElementById("cari_obat").focus();

	$('#cari_obat').autocomplete({
		serviceUrl: '<?php echo site_url();?>farmasi/Frmcdaftar/cari_data_obat',
		onSelect: function (suggestion) {
			$('#cari_obat').val(''+suggestion.nama);
			$("#id_obat").val(suggestion.idobat);
			$('#biaya_obat').val(suggestion.hargabeli);
			$("#harga_jual").val(suggestion.harga);
			$("#expire_date").val(suggestion.expire_date);

			$('#qty').val('1');
			set_total() ;
		}
	});
});
</script>
<section class="content" style="width:97%;margin:0 auto">
	<div class="row">
		<div class="panel panel-info">
     		<div class="panel-body">
     		<?php echo form_open('logistik_farmasi/Frmcstok/edit_stokopname'); ?>
	          <div class="form-group row">
	            <p class="col-sm-2 form-control-label " id="tindakan">Obat</p>
	            <div class="col-sm-6">
	              <input type="search" class="form-control" id="cari_obat" name="cari_obat" placeholder="Pencarian Obat" 
	              value="<?=$itemso->nm_obat?>">
	              <input type="hidden" name="id_obat" id="id_obat" value="<?=$itemso->id_obat?>">
	            </div>
	          </div>
	          <div class="form-group row">
	            <p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Beli</p>
	            <div class="col-sm-4">
	              <input type="text" class="form-control" name="biaya_obat" id="biaya_obat" required value="<?=$itemso->hargabeli?>">
	            </div>
	          </div>
	          <div class="form-group row">
	            <p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Harga Jual</p>
	            <div class="col-sm-4">
	              <input type="text" class="form-control" name="harga_jual" id="harga_jual" required value="<?=$itemso->hargajual?>">
	            </div>
	          </div>
	          <div class="form-group row">
	            <p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Expire Date</p>
	            <div class="col-sm-4">
	              <input type="text" class="form-control" name="expire_date" id="expire_date" required value="<?=$itemso->expire_date?>">
	            </div>
	          </div>
	          <div class="form-group row">
	            <p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Batch NO</p>
	            <div class="col-sm-4">
	              <input type="text" class="form-control" name="batch_no" id="batch_no" required value="<?=$itemso->batch_no?>">
	            </div>
	          </div>
	          <div class="form-group row">
	            <p class="col-sm-2 form-control-label" id="lbl_qtyind">Quantity Hasil SO</p>
	            <div class="col-sm-4">
	              <input type="number" class="form-control" name="qty" id="qty" min=1 required="" value="<?=$itemso->qty?>">
	            </div>
	          </div>
	          <div class="form-group row">
	            <p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Jenis Obat</p>
	            <div class="col-sm-4">
	              <select  class="form-control" style="width: 100%" name="jenis_obat" id="jenis_obat" required>
	                <option value="">-Pilih Jenis-</option>
	                <option value="ALKES" <?=($itemso->jenis_obat == 'ALKES' ? 'selected' : '')?>>ALKES</option>
	                <option value="BEBAS" <?=($itemso->jenis_obat == 'BEBAS' ? 'selected' : '')?>>BEBAS</option>
	                <option value="INFUS" <?=($itemso->jenis_obat == 'INFUS' ? 'selected' : '')?>>INFUS</option>
	                <option value="INHALER" <?=($itemso->jenis_obat == 'INHALER' ? 'selected' : '')?>>INHALER</option>
	                <option value="INJEKSI" <?=($itemso->jenis_obat == 'INJEKSI' ? 'selected' : '')?>>INJEKSI</option>
	                <option value="KULKAS" <?=($itemso->jenis_obat == 'KULKAS' ? 'selected' : '')?>>KULKAS</option>
	                <option value="NARKOTIK" <?=($itemso->jenis_obat == 'NARKOTIK' ? 'selected' : '')?>>NARKOTIK</option>
	                <option value="PSIKOTROPIK" <?=($itemso->jenis_obat == 'PSIKOTROPIK' ? 'selected' : '')?>>PSIKOTROPIK</option>
	                <option value="SIRUP" <?=($itemso->jenis_obat == 'SIRUP' ? 'selected' : '')?>>SIRUP</option>
	                <option value="SALEP" <?=($itemso->jenis_obat == 'SALEP' ? 'selected' : '')?>>SALEP</option>
	                <option value="TABLET" <?=($itemso->jenis_obat == 'TABLET' ? 'selected' : '')?>>TABLET</option>
	                <option value="TETES" <?=($itemso->jenis_obat == 'TETES' ? 'selected' : '')?>>TETES</option>
	              </select>
	            </div>
	          </div>
	      </div>
	      <div class="modal-footer">
	          <!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> -->
	          <button type="submit" class="btn btn-primary">Simpan</button>
	      </div>
	      <?php 
	      echo form_close(); ?>
     		</div><!-- end panel body -->
    	</div><!-- end panel info-->
   	</div><!-- end div id home -->
</section>