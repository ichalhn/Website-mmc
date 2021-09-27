<?php $this->load->view("layout/header"); 
// echo json_encode($laboratorium); ?>
<section class="content-header">
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-success">
				<div class="panel-heading" align="center">Data Pasien</div>
				<div class="panel-body"><br/>
					<div class="form-inline">
					<div class="row">
					<?php if($data_pasien->foto == "") $foto = "unknown.png"; 
							else $foto = $data_pasien->foto;
					?>
					<div class="col-sm-4"><img height="100px" class="img-rounded" src="<?php echo site_url("upload/photo/".$foto);?>"></div>
					<table class="table-sm table-striped" style="font-size:15">
					  <tbody>
						<tr>
							<th>Nama</th>
							<td>:&nbsp;</td>
							<td><?php echo strtoupper($data_pasien->nama);?></td>
						</tr>
						<tr>
							<th>No. CM</th>
							<td>:&nbsp;</td>
							<td><?php echo $data_pasien->no_cm;?></td>
						</tr>
						<tr>
							<th>Umur</th>
							<td>:&nbsp;</td>
							<td><?php echo $data_pasien->umur;?></td>
						</tr>
						<tr>
							<th>Gol Darah</th>
							<td>:&nbsp;</td>
							<td><?php echo $data_pasien->goldarah;?></td>
						</tr>
					  </tbody>
					</table><br/><br/><br/>
					</div>
					</div>
				</div>
			</div>
		</div>		
		<div class="col-sm-6">
			<div class="panel panel-default">
				<div class="panel-body">		
				  <div class='chart' id='dashboardRme' style='height: 200px;'></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">		
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading" align="center">Detail Rekam Medik</div>
				<div class="panel-body">
					<div class="box box-primary box-solid collapsed-box">
						<div class="box-header with-border">
							<h3 class="box-title">Kunjungan Rawat Jalan</h3>
							<div class="box-tools pull-right">
								<button class="btn btn-primary btn-sm" data-widget="collapse">
								<i class="fa fa-plus"></i>
								</button>
							</div>
						</div>
						<div class="box-body" style="display: none;">
							<div class="col-lg-12">							
								<?php if (count($irj)>0){ ?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th width="10%"><b>Tanggal</b></th>
											<th width="10%"><b>No Register</b></th>
											<th width="20%"><b>Poliklinik</b></th>
											<th width="20%"><b>Keterangan</b></th>
											<th width="40%"><b>Uraian</b></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$temp = "";
										foreach($irj as $row2){
										?>										
										<tr>
										<?php
											if ($temp == $row2->no_register){
												
											}else{
												$temp = $row2->no_register;
												echo '<td width="10%" rowspan="'.$row2->jml.'">'.$row2->tanggal.'</td>'; 
												echo '<td width="10%" rowspan="'.$row2->jml.'">'.$row2->no_register.'</td>'; 
												echo '<td width="10%" rowspan="'.$row2->jml.'">'.$row2->tujuan.'</td>'; 
											}
										?>											
											<td width="20%"><?php echo $row2->keterangan;?></td>
											<td width="40%"><?php echo $row2->nmmedik;?></td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<?php }	else echo "Tidak ada data..";?>
							</div>
						</div>
					</div>
					<div class="box box-primary box-solid collapsed-box">
						<div class="box-header with-border">
							<h3 class="box-title">Kunjungan Rawat Darurat</h3>
							<div class="box-tools pull-right">
								<button class="btn btn-primary btn-sm" data-widget="collapse">
								<i class="fa fa-plus"></i>
								</button>
							</div>
						</div>
						<div class="box-body" style="display: none;">
							<div class="col-lg-12">							
								<?php if (count($ird)>0){ ?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th width="10%"><b>Tanggal</b></th>
											<th width="10%"><b>No Register</b></th>
											<th width="20%"><b>Keterangan</b></th>
											<th width="60%"><b>Uraian</b></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$temp = "";
										foreach($ird as $row2){
										?>										
										<tr>
										<?php
											if ($temp == $row2->no_register){
												
											}else{
												$temp = $row2->no_register;
												echo '<td width="10%" rowspan="'.$row2->jml.'">'.$row2->tanggal.'</td>'; 
												echo '<td width="10%" rowspan="'.$row2->jml.'">'.$row2->no_register.'</td>'; 
											}
										?>											
											<td width="20%"><?php echo $row2->keterangan;?></td>
											<td width="60%"><?php echo $row2->nmmedik;?></td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<?php }	else echo "Tidak ada data..";?>
							</div>
						</div>
					</div>
					<div class="box box-primary box-solid collapsed-box">
						<div class="box-header with-border">
							<h3 class="box-title">Kunjungan Rawat Inap</h3>
							<div class="box-tools pull-right">
								<button class="btn btn-primary btn-sm" data-widget="collapse">
								<i class="fa fa-plus"></i>
								</button>
							</div>
						</div>
						<div class="box-body" style="display: none;">
							<div class="col-lg-12">							
								<?php if (count($iri)>0){ ?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th width="10%"><b>Tanggal</b></th>
											<th width="10%"><b>No Register</b></th>
											<th width="20%"><b>Keterangan</b></th>
											<th width="60%"><b>Uraian</b></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$temp = "";
										foreach($iri as $row2){
										?>										
										<tr>
										<?php
											if ($temp == $row2->no_register){
												
											}else{
												$temp = $row2->no_register;
												echo '<td width="10%" rowspan="'.$row2->jml.'">'.$row2->tanggal.'</td>'; 
												echo '<td width="10%" rowspan="'.$row2->jml.'">'.$row2->no_register.'</td>'; 
											}
										?>											
											<td width="20%"><?php echo $row2->keterangan;?></td>
											<td width="60%"><?php echo $row2->nmmedik;?></td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<?php }	else echo "Tidak ada data..";?>
							</div>
						</div>
					</div>
					<div class="box box-primary box-solid collapsed-box">
						<div class="box-header with-border">
							<h3 class="box-title">Farmasi</h3>
							<div class="box-tools pull-right">
								<button class="btn btn-primary btn-sm" data-widget="collapse">
								<i class="fa fa-plus"></i>
								</button>
							</div>
						</div>
						<div class="box-body" style="display: none;">
							<div class="col-lg-12">				
								<?php if (count($farmasi)>0){ ?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th width="10%"><b>Tanggal</b></th>
											<th width="10%"><b>No Register</b></th>
											<th width="20%"><b>Obat</b></th>
											<th width="60%"><b>Keterangan</b></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$temp = "";
										foreach($farmasi as $row2){
										?>										
										<tr>
										<?php
											if ($temp == $row2->no_register){
												
											}else{
												$temp = $row2->no_register;
												echo '<td width="10%" rowspan="'.$row2->jml.'">'.$row2->tanggal.'</td>'; 
												echo '<td width="10%" rowspan="'.$row2->jml.'">'.$row2->no_register.'</td>'; 
											}
										?>											
											<td width="20%"><?php echo $row2->nmmedik;?></td>
											<td width="60%"><?php echo $row2->keterangan;?></td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>
								<?php }	else echo "Tidak ada data..";?>
							</div>
						</div>
					</div>
					<div class="box box-primary box-solid collapsed-box">
						<div class="box-header with-border">
							<h3 class="box-title">Laboratorium</h3>
							<div class="box-tools pull-right">
								<button class="btn btn-primary btn-sm" data-widget="collapse">
								<i class="fa fa-plus"></i>
								</button>
							</div>
						</div>
						<div class="box-body" style="display: none;">
							<div class="col-lg-12">
								<?php if (count($laboratorium)>0){ ?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th width="10%"><b>Tanggal</b></th>
											<th width="8%"><b>No Register</b></th>
											<th width="6%"><b>No Lab</b></th>
											<th><b>Jenis Pemeriksaan</b></th>
											<th><b>Jenis Hasil</b></th>
											<th><b>Hasil</b></th>
											<th><b>Kadar Normal</b></th>
											<th><b>Satuan</b></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$temptgl_kunjungan = "";
										$tempno_register = "";
										$tempno_lab = "";
										$tempjenis_tindakan = "";
										foreach($laboratorium as $row2){
										?>										
										<tr>
										<?php
											if ($temptgl_kunjungan == $row2->tgl_kunjungan){
												echo '<td></td>';
											}else{
												$temptgl_kunjungan = $row2->tgl_kunjungan;
												echo '<td>'.$row2->tgl_kunjungan.'</td>'; 
											}
											if ($tempno_register == $row2->no_register){
												echo '<td></td>';
											}else{
												$tempno_register = $row2->no_register;
												echo '<td>'.$row2->no_register.'</td>'; 
											}
											if ($tempno_lab == $row2->no_lab){
												echo '<td></td>';
											}else{
												$tempno_lab = $row2->no_lab;
												echo '<td>'.$row2->no_lab.'</td>'; 
											}
											if ($tempjenis_tindakan == $row2->jenis_tindakan){
												echo '<td></td>';
											}else{
												$tempjenis_tindakan = $row2->jenis_tindakan;
												echo '<td><b>'.$row2->jenis_tindakan.'</b></td>'; 
											}
										?>		
											<td><?php echo $row2->jenis_hasil;?></td>
											<td><?php echo $row2->hasil_lab;?></td>
											<td><?php echo $row2->kadar_normal;?></td>
											<td><?php echo $row2->satuan;?></td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>	
								<?php }	else echo "Tidak ada data..";?>
							</div>
						</div>
					</div>
					<div class="box box-primary box-solid collapsed-box">
						<div class="box-header with-border">
							<h3 class="box-title">Radiologi</h3>
							<div class="box-tools pull-right">
								<button class="btn btn-primary btn-sm" data-widget="collapse">
								<i class="fa fa-plus"></i>
								</button>
							</div>
						</div>
						<div class="box-body" style="display: none;">
							<div class="col-lg-12">
								<?php if (count($radiologi)>0){ ?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th width="10%"><b>Tanggal</b></th>
											<th width="10%"><b>No Register</b></th>
											<th width="20%"><b>No Medrec</b></th>
											<th width="60%"><b>Keterangan</b></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$temp = "";
										foreach($radiologi as $row2){
										?>										
										<tr>
										<?php
											if ($temp == $row2->no_register){
												
											}else{
												$temp = $row2->no_register;
												echo '<td width="10%" rowspan="'.$row2->jml.'">'.$row2->tanggal.'</td>'; 
												echo '<td width="10%" rowspan="'.$row2->jml.'">'.$row2->no_register.'</td>'; 
											}
										?>											
											<td width="20%"><?php echo $row2->no_cm;?></td>
											<td width="60%"><?php echo $row2->nmmedik;?></td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>	
								<?php }	else echo "Tidak ada data..";?>
							</div>
						</div>
					</div>
					<div class="box box-primary box-solid collapsed-box">
						<div class="box-header with-border">
							<h3 class="box-title">Patologi Anatomi</h3>
							<div class="box-tools pull-right">
								<button class="btn btn-primary btn-sm" data-widget="collapse">
								<i class="fa fa-plus"></i>
								</button>
							</div>
						</div>
						<div class="box-body" style="display: none;">
							<div class="col-lg-12">
								<?php if (count($patologi)>0){ ?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th width="10%"><b>Tanggal</b></th>
											<th width="10%"><b>No Register</b></th>
											<th width="20%"><b>No Medrec</b></th>
											<th width="60%"><b>Keterangan</b></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$temp = "";
										foreach($patologi as $row2){
										?>										
										<tr>
										<?php
											if ($temp == $row2->no_register){
												
											}else{
												$temp = $row2->no_register;
												echo '<td width="10%" rowspan="'.$row2->jml.'">'.$row2->tanggal.'</td>'; 
												echo '<td width="10%" rowspan="'.$row2->jml.'">'.$row2->no_register.'</td>'; 
											}
										?>	
											<td width="20%"><?php echo $row2->no_cm;?></td>
											<td width="40%"><?php echo $row2->nmmedik;?></td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>	
								<?php }	else echo "Tidak ada data..";?>
							</div>
						</div>
					</div>
					<div class="box box-primary box-solid collapsed-box">
						<div class="box-header with-border">
							<h3 class="box-title">Operasi</h3>
							<div class="box-tools pull-right">
								<button class="btn btn-primary btn-sm" data-widget="collapse">
								<i class="fa fa-plus"></i>
								</button>
							</div>
						</div>
						<div class="box-body" style="display: none;">
							<div class="col-lg-12">
								<?php if (count($operasi)>0){ ?>
								<table class="table table-bordered">
									<thead>
										<tr>
											<th width="10%"><b>Tanggal</b></th>
											<th width="10%"><b>No Register</b></th>
											<th width="20%"><b>No Medrec</b></th>
											<th width="60%"><b>Keterangan</b></th>
										</tr>
									</thead>
									<tbody>
										<?php
										$temp = "";
										foreach($operasi as $row2){
										?>										
										<tr>
										<?php
											if ($temp == $row2->no_register){
												
											}else{
												$temp = $row2->no_register;
												echo '<td width="10%" rowspan="'.$row2->jml.'">'.$row2->tanggal.'</td>'; 
												echo '<td width="10%" rowspan="'.$row2->jml.'">'.$row2->no_register.'</td>'; 
											}
										?>	
											<td width="20%"><?php echo $row2->no_cm;?></td>
											<td width="40%"><?php echo $row2->nmmedik;?></td>
										</tr>
										<?php
										}
										?>
									</tbody>
								</table>	
								<?php }	else echo "Tidak ada data..";?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
$(function() {
	var bar = new Morris.Bar({
	  // ID of the element in which to draw the chart.
	  element: 'dashboardRme',
	  // Chart data records -- each entry in this array corresponds to a point on
	  // the chart.
	  data: <?php echo $graph; ?>,
	  // The name of the data record attribute that contains x-values.
	  xkey: "nama",
	  xLabelAngle: 60,
	  // A list of names of data record attributes that contain y-values.
	  ykeys: ['total'],
	  // Labels for the ykeys -- will be displayed when you hover over the
	  // chart.
	  labels: ['Jumlah']
	});
});
</script>
<?php $this->load->view("layout/footer"); ?>