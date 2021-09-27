<?php
	$this->load->view('layout/header.php');
?>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
	//-----------------------------------------------Data Table
	$(document).ready(function() {
	    $('#example2').DataTable();
	} );
	//---------------------------------------------------------

	$(function() {
		$('.auto_cek_obat').autocomplete({
			serviceUrl: site+'farmasi/Frmcdaftar/cek_harga_obat',
			onSelect: function (suggestion) {
				$('#nama_obat').val(''+suggestion.nama_obat);
			}
		});
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});  
			
	});

			
	function cek_harga_obat() {
		var nama_obat = document.getElementById("nama_obat").value;
		$.ajax({
			type:'POST',
			url:"<?php echo base_url('farmasi/Frmcdaftar/cek_harga_obat')?>",
			data: {
				nama_obat: nama_obat
			},
			success: function(data){
				//alert(data);
				$('#tablemodal').html("");
				$('#tablemodal').append(data);
			},
			error: function(request, error){
				console.log(arguments);
				alert(error);
			}
	    });
	}
</script>
<section class="content-header">
	<?php
		echo $this->session->flashdata('success_msg');
	?>
</section>
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">DAFTAR ANTRIAN PASIEN FARMASI</h3>
				</div>
				<div class="box-body">
					<?php echo form_open('farmasi/Frmcdaftar/by_date');?>
					<div class="col-xs-3">
						<div class="input-group">
							<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div><!-- /input-group -->
					</div><!-- /.col-lg-6 -->
					<?php echo form_close();?>

					<?php echo form_open('farmasi/Frmcdaftar/by_no');?>
					<div class="col-xs-3">
						<div class="input-group">
							<input type="text" class="form-control" name="key" id="key" placeholder="No. Register" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div><!-- /input-group -->	
					</div><!-- /col-lg-6 -->
					<?php echo form_close();?>


					<div class="col-xs-3" align="right">
						<div class="input-group">
							<span class="input-group-btn">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#obatModal">Cek Harga Obat</button>
							</span>
						</div><!-- /input-group -->	
					</div><!-- /col-lg-6 -->
					<!-- Modal -->
					<div class="modal fade" id="obatModal" role="dialog">
						<div class="modal-dialog modal-success">
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Daftar Harga Obat</h4>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<div class="col-sm-6">
											<div class="input-group">
												<input type="text" class="form-control auto_cek_obat" name="nama_obat" id="nama_obat" placeholder="Nama Obat">
												<span class="input-group-btn">
													<button class="btn btn-primary" type="submit" onclick="cek_harga_obat()">Cari</button>
												</span>
											</div>
										</div>
									</div>
									
									<div class="form-group row">
										<div class="col-sm-12" id="tablemodal">	
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xs-3" align="right">
						<div class="input-group">
							<span class="input-group-btn">
								<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Registrasi Pasien Luar</button>
							</span>
						</div><!-- /input-group -->	
					</div><!-- /col-lg-6 -->
						<!-- Modal -->
					<?php echo form_open('farmasi/Frmcdaftar/daftar_pasien_luar');?>
					<div class="modal fade" id="myModal" role="dialog">
						<div class="modal-dialog modal-success">
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Registrasi Pasien Luar</h4>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="lbl_nama">Nama</p>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="nama" id="nama">
										</div>
									</div>
									<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="lbl_alamat">Alamat</p>
										<div class="col-sm-6">
											<input type="text" class="form-control" name="alamat" id="alamat">
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
									<button class="btn btn-primary" type="submit">Simpan</button>
								</div>
							</div>
						</div>
					</div>
					<?php echo form_close();?>
					
					<br>
					<br>
					<br>
					<table id="example2" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>No</th>
								<th>Tanggal Kunjungan</th>
								<th>No CM</th>
								<th>No Registrasi</th>
								<th>Nama</th>
								<th>Kelas</th>
								<th>Ruangan</th>
								<th>Bed</th>
								<th>Cara Bayar</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=1;
							foreach($farmasi as $row){
							$no_register=$row->no_register;
							?>
							<tr>
								<td><?php echo $i++;?></td>
								<td><?php echo date('d-m-Y | H:i',strtotime($row->tgl_kunjungan));?></td>
								<td><?php echo $row->no_cm;?></td>
								<td><?php echo $row->no_register;?></td>
								<td><?php echo $row->nama;?></td>
								<td><?php echo $row->kelas;?></td>
								<td><?php echo $row->idrg;?></td>
								<td><?php echo $row->bed;?></td>
								<td><?php echo $row->cara_bayar;?></td>
								<td>
					                <a href="<?php echo site_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register); ?>" class="btn btn-primary btn-sm">Resep</a>
					                <?php $getrdrj=substr($no_register, 0,2); 
					                if($getrdrj=='RJ' || $getrdrj =='RI'){?>
					                	<a href="<?php echo site_url('farmasi/Frmcdaftar/force_selesai/'.$no_register); ?>" class="btn btn-danger btn-sm">Selesai</a>
					                <?php } ?>					                 
								</td>
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
</section>
<?php
	$this->load->view('layout/footer.php');
?>