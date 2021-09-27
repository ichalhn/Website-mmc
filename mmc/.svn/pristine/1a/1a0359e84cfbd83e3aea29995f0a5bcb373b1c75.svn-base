<?php $this->load->view("layout/header"); ?>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(function(){
	$('.auto_search_poli').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/IrDRegistrasi/data_poli',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#nm_poli').val(''+suggestion.nm_poli+' ('+suggestion.id_poli+')');
			$('#id_poli').val(''+suggestion.id_poli);
			$('#kd_ruang').val(''+suggestion.kd_ruang);
		}
	});
});
</script>
<div class="content-wrapper">
	<div class="container-fluid"><br/>
	<div class="row">
	<?php echo form_open('ird/IrDRegistrasi/pasien_poli');?>
		<div class="col-lg-12">
			<div class="input-group">
				<input type="search" class="auto_search_poli form-control" name="nm_poli" id="nm_poli" placeholder="Cari Poli" required>
				<input type="hidden" class="form-control" name="id_poli" id="id_poli" required>
				<span class="input-group-btn">
					<button class="btn btn-primary" type="submit">Cari</button>
				</span>
			</div><!-- /input-group -->
		</div><!-- /.col-lg-6 -->
	<?php echo form_close();?>
	</div><!-- /.row --><br/>
	<div style="display:block;overflow:auto;">
		<table class="table table-hover table-striped">
		
	<?php 
				foreach($poliklinik as $row){
			?>
				<tr>
					<td>
						<a href="<?php echo site_url('IrDPelayanan/kunj_pasien_poli/'.$row->id_poli)?>">
							<?php
								echo $row->nm_poli.' ('.$row->id_poli.')';
							if($row->counter>0){
								echo '<span class="label label-danger pull-right">'.$row->counter.'</span>';
							}
							?>
						</a>
					</td>
				</tr>
			<?php
				}
			?>
		</table>
	</div>
</div>
</div>
<?php $this->load->view("layout/footer"); ?>
