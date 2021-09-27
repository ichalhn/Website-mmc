<?php
	$this->load->view('layout/header.php');
?>

<div class="container-fluid">
	<section class="content-header">
	</section>
	<section class="content">
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading" align="center">Rekap Biaya</div>
				<div class="panel-body">
					<br/>
					<div style="display:block;overflow:auto;">
						<table class="table">
						  <tbody>
							<tr>
								<th>No CM</th>
								<td>:</td>
								<td><?php echo $data_pasien->no_cm;?></td>
								<th>Tanggal Kunjungan</th>
								<td>:</td>
								<td><?php echo $data_pasien->tgl;?></td>
							</tr>
							<tr>
								<th>No. Register</th>
								<td>:</td>
								<td><?php echo $data_pasien->no_register;?></td>
								<th>Kelas Pasien</th>
								<td>:</td>
								<td><?php echo $data_pasien->kelas;?></td>
							</tr>
							<tr>
								<th>Nama Pasien</th>
								<td>:</td>
								<td><?php echo $data_pasien->nama;?></td>
								<th></th>
								<td></td>
								<td></td>
							</tr>
						  </tbody>
						</table>
					
						<table class="table table-hover table-striped table-bordered">
						  <thead>
							<tr>
							  <th>No</th>
							  <th>Nama Pemeriksaan</th>
							  <th>Biaya</th>
							  <th>Banyak</th>
							  <th>Total</th>
							</tr>
						  </thead>
						  <tbody>
								<?php
									$i=1;
									$jumlah_vtot=0;
									foreach($data_pemeriksaan as $row){
								?>
									<tr>
									  <td><?php echo $i++;?></td>
									  <td><?php echo $row->jenis_tindakan; ?></td>
									  <td><?php echo $row->biaya_lab; ?></td>
									  <td><?php echo $row->qty;?></td>
									  <td>Rp <div class="pull-right"><?php echo number_format( $row->vtot, 2 , ',' , '.' );
									  			$jumlah_vtot=$jumlah_vtot+$row->vtot?>
									  	</div>
									  </td>
									</tr>
								<?php
									}
								?>
							
								<tr>
								  <th colspan="4">Total</th>
								  <th>Rp <div class="pull-right"><?php echo number_format( $jumlah_vtot, 2 , ',' , '.' );?></div></th>
								</tr>
							</tbody>
						</table>
					</div><!-- style overflow -->

					
					<div class="form-inline row" align="right" style="margin-right:10px;">
						<div class="input-group"><span class="input-group-addon">Rp</span>								
							<input type="text" class="form-control" placeholder="Diskon" name="diskon" id="diskon">				
							<span class="input-group-btn">
								<button type="btn" class="btn btn-primary" onclick="setTotakhir()">Input</button>
							</span>
						</div>		
					</div><br>


					<div class="form-group row ">
						<p class="col-lg-offset-4 col-sm-4 form-control-label" align="right" style="margin-top:7px;">Total Biaya setelah diskon : </p>
							<div class="col-sm-4 pull-right" style="width:29%;">
								<div class="input-group">
								<span class="input-group-addon">Rp</span>
									<input type="text" class="form-control" placeholder="0" name="totakhir" id="totakhir" disabled>
								</span>
								</div>
							</div>
					</div>
					
					<?php
						echo form_open('lab/labckwitansi/st_cetak_kwitansi_kt');
					?>
					
					<div class="form-inline" align="right">
						<div class="input-group">
							<input type="text" class="form-control" placeholder="Sudah Terima Dari" name="penyetor">
							<!--<a href="<?php //echo site_url('irj/rjckwitansi/st_cetak_kwitansi_kt/'.$no_lab);?>"><input type="button" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak"></a>-->
							<span class="input-group-btn">
								<button type="submit" class="btn btn-primary">Cetak</button>
							</span>
						</div>
					</div>
					<input type="hidden" class="form-control" name="no_lab" value="<?php echo $no_lab ?>">
					<input type="hidden" class="form-control" name="jumlah_vtot" value="<?php echo $jumlah_vtot ?>">
					<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
					<input type="hidden" class="form-control" placeholder="" name="diskon_hide" id="diskon_hide">
					<?php 
						echo form_close();
					
					?>
					
				
				</div>
			</div>
		</div>
	</section>
</div>

<script type='text/javascript'>
	var site = "<?php echo site_url();?>";

	$(document).ready(function() {
		$("#totakhir").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$("#diskon").maskMoney({thousands:',', decimal:'.', affixesStay: true});
	});

	function setTotakhir(){
		var num = $('#diskon').maskMoney('unmasked')[0]; 
		$('#diskon_hide').val(num);		
		var total = "<?php echo $jumlah_vtot; ?>";	
		if(total-num>=0){
			$('#totakhir').val(total-num);
			$("#totakhir").maskMoney('mask');
			$('#totakhir_hide').val(total-num);
		}
		else
			alert("Diskon melebihi biaya total !");
	}

	function penyetorDetail(){
		var num = $('#penyetor').val(); 
		$('#penyetor_hide').val(num); 
	}
</script>
<?php
	$this->load->view('layout/footer.php');
?>
