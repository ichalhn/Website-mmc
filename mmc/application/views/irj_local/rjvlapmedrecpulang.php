<?php $this->load->view("layout/header"); ?>
<script>
$(document).ready(function() {
$('#tablePulangRJ').DataTable();

$('#date_picker1').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});
$('.js-example-basic-single').select2();
$('#date_picker2').datepicker({
				format: "yyyy-mm-dd",
				endDate: "current",
				autoclose: true,
				todayHighlight: true,
		});
});

</script>
<div class="container"  >
			<div class="row">
				<div class="form-inline">
					<?php echo form_open('irj/Rjcmedrec/lap_medrec');?>
						<div class="col-sm-12">
							<div class="form-inline">								
								<input type="text" id="date_picker1" class="form-control" placeholder="yyyy-mm-dd" name="date0">s/d
								<input type="text" id="date_picker2" class="form-control" placeholder="yyyy-mm-dd" name="date1">	
								<select name="id_poli" class="js-example-basic-single" required>
									<option value="SEMUA">SEMUA</option>
									<?php 
									foreach($select_poli as $row){
										echo '<option value="'.$row->id_poli.'@'.$row->nm_poli.'">'.$row->nm_poli.'</option>';
									}
									?>
								</select>
								<select name="cara_bayar" class="js-example-basic-single" required>
									<option value="SEMUA">SEMUA</option>
									<?php 
									foreach($select_carabayar as $row){
										echo '<option value="'.$row->cara_bayar.'">'.$row->cara_bayar.'</option>';
									}
									?>
								</select>
								<select name="cara_bayar" class="js-example-basic-single" required>
									<option value="SEMUA">SEMUA</option>
									<?php 
									foreach($select_kontraktor as $row){
										echo '<option value="'.$row->id_kontraktor.'">'.$row->cara_bayar.'</option>';
									}
									?>
								</select>
								<button class="btn btn-primary" type="submit">Cari</button>
													
							</div>
						</div><!-- /inline -->
					
				
			<?php echo form_close();?>
			</div>
		</div>
	</div>
<section class="content-header">
<div class="box" style="width:100%;margin:0 auto; padding-bottom:7px;">
	<div class="box-header" align="center"><b>Pasien Pulang Rawat Jalan <?php echo $poli;?><br> Tanggal <?php echo $tgl_awal;?> s/d <?php echo $tgl_akhir;?></b></div>
		
	<table id="tablePulangRJ" class="display" cellspacing="0" width="98%">
						<thead>
							<tr>
								<tr>
								  <th>No</th>
								  <th>No MR</th>
								  <th>No Register</th>
								  <th>Kunjungan</th>
								  <th>Nama</th>	
								  <th>JK</th>
								  <th>Usia</th>
								  <th>Poli</th>
								  <th>ICD</th>
								  <th>Diagnosa Baru</th>
								  <th>Diagnosa Lama</th>
								  <th>Jenis Pasien</th>
								  <th>Pangkat</th>
								  <th>Kesatuan</th>
								  <th>Keterangan</th>
								</tr>
							  <!--<th>No</th>
							  <th>No Medrec</th>
							  <th>No Register</th>
							  <th>Kunjungan</th>					
							  <th>Nama</th>								 
							  <th>L/P</th>
							  <th>Usia</th>
							  <th>Dokter</th>
							  <th>Diagnosa</th>-->
							</tr>
							</thead>
							<tfoot>
								<tr>
								  <th>No</th>
								  <th>No MR</th>
								  <th>No Register</th>
								  <th>Kunjungan</th>
								  <th>Nama</th>	
								  <th>JK</th>
								  <th>Usia</th>
								  <th>Poli</th>
								  <th>ICD</th>
								  <th>Diagnosa Baru</th>
								  <th>Diagnosa Lama</th>
								  <th>Jenis Pasien</th>
								  <th>Pangkat</th>
								  <th>Kesatuan</th>
								  <th>Keterangan</th>
								</tr>
							</tfoot>
							<tbody>
							<?php	 //print_r($list_medrec);
							$i=1;
								//$tot_kunj=0;
								foreach($list_medrec as $row){
								//$no_medrec=$row->no_medrec;
								//$tot_kunj=$tot_kunj+$row->jum_kunj;
							?>
								<tr>
								  <td><?php echo $i++;?></td>
								  <td><?php echo $row->no_cm;?></td>
								  <td><?php echo $row->no_register;?></td>
								  <td><?php echo $row->jns_kunj;?></td>
								  <td><?php echo strtoupper($row->nama);?></td>
								  <td><?php echo strtoupper($row->sex);?></td>
								  <td><?php echo $row->usia;?></td>
								  <td><?php echo strtoupper($row->poli);?></td>
								  <td><?php echo $row->icd;?></td>
								  <td><?php echo $row->diag_baru;?></td>
								  <td><?php echo $row->diag_lama;?></td>
								  <td><?php if($row->cara_bayar=='UMUM'){echo strtoupper($row->cara_bayar);}else{ if($row->cara_bayar=='DIJAMIN'){ echo $row->cara_bayar.' - '; } echo strtoupper($row->nmkontraktor); }?></td>
								  <td><?php echo $row->pangkat;?></td>
								  <td><?php echo $row->kesatuan;?></td>
								  <td><?php echo $row->no_nrp.' '.$row->hub_name;?></td>
								</tr>
										<?php } ?>
									</tbody>
								</table>
							<h4 align="center"><b>Total Kunjungan : </b><?php echo $i-1;?></h4>
							<div class="form-inline" align="right">
								<div class="form-group">
									<!--<a id="btnCetak" class="btn btn-primary" name="btnCetak" target="_blank" href="<?php echo site_url('irj/rjcmedrec/cetak_pdf/'.$tgl_awal.'/'.$tgl_akhir);?>">PDF</a>-->
									<?php if($i>0){ ?>
									<a id="btnDown" class="btn btn-primary" name="btnCetak" target="_blank" href="<?php echo site_url('irj/rjcmedrec/export_excel3/'.$tgl_awal.'/'.$tgl_akhir.'/'.$id_poli);?>">Excel</a>		
									<?php } ?>
								</div>
					</div>
	</div>
</section>
<?php $this->load->view("layout/footer"); ?>
