<?php
	if(count($data_laporan_kunj)>0){
?>
<table id="example" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
		  <th>No</th>
		  <th>Bulan</th>		  						 
		  <th>Jumlah Pemeriksaan</th>		 
		</tr>
	</thead>
	<tbody>
	<?php	// print_r($pasien_daftar);
		$i=1;
		$tot_kunj=0;
		
		foreach($data_laporan_kunj as $row){
		//$no_medrec=$row->no_medrec;
		$tot_kunj=$tot_kunj+$row->jum_kunj;
	?>
	<tr>
	  <td><?php echo $i++;?></td>
	  <td><?php echo $tgl_indo->bulan(date('m', strtotime($row->bulan)));?></td>
	  <td><?php echo $row->jum_kunj;?></td>	  
	</tr>
	<?php } ?>
	</tbody>
</table>
<h4 align="center"><b>Total Pemeriksaan : <?php echo $tot_kunj;?><b></h4>
<hr>
<br>
<?php
	if(count($data_laporan_kunj)>0){
		echo "<h4 align='center'><b>$pemeriksaan_title</b></h4>";
		foreach($data_tindakan as $row1){

			$cek_id_tindakan=$row1->id_tindakan;
?>
	
<div class="box box-solid bg-light-blue-gradient collapsed-box">
    <div class="box-header">
        <h3 class="box-title"><?php echo $row1->nmtindakan; ?></h3>
        <div class="box-tools pull-right">
			<button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    <div class="box-body border-radius-none" style="background-color:ffffff">
		<div class="panel-body">
			<div class="form-inline">
				<?php echo form_open('pa/pacdaftar/by_date');?>
				<div class="col-lg-12">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width="5%"><b>No</b></th>
								<th width="15%"><b>No Medrec</b></th>
								<th width="15%"><b>No Register</b></th>
								<th width="30%"><b>Nama</b></th>
								<th width="35%"><b>Tanggal Pemeriksaan</b></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=1;
							foreach($data_pemeriksaan as $row2){
								if ($row2->id_tindakan==$cek_id_tindakan) {
							?>
								<tr>
									<td width="5%"><?php echo $i++;?></td>
									<td width="15%"><?php echo $row2->no_cm;?></td>
									<td width="15%"><?php echo $row2->no_register;?></td>
									<td width="30%"><?php echo $row2->nama;?></td>
									<td width="35%"><?php echo $row2->tgl;?></td>
								</tr>
							<?php
								} // if
							} // foreach data_pemeriksaan
							?>
							<tr>
								<td colspan="4"><p align="right"><b>Total</b></p></td>
								<td><p align="right"><b><?php echo $i-1;?></b></p></td>
							</tr>
							<?php //echo $space ?>
						</tbody>
					</table>	
				</div><!-- /.col-lg-6 -->
				<?php echo form_close();?>
			</div><!-- /inline -->
		</div><!-- /panel body -->
    </div><!-- /.box-body -->
</div><!-- /.box -->

<?php 
			}
		}//TUTUP IF 
	} else {
	echo $message_nodata;
} 
?>
	