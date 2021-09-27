<?php
	include('rjvheader.php');
	include('rjvfooter.php');
	
?>
<html>
<?php
	head();
?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php
	include('rjvnav.php');
?>
<div class="content-wrapper">
	<div class="container-fluid">
		<section class="content-header">
			<legend>Laporan Keuangan Instalasi Rawat Jalan</legend>
	<?php
		include('rjvlapkeupencarian.php');
	?>
		</section>
		<section class="content">
			<div class="row">
				<div class="panel panel-info">
					<div class="panel-heading" align="center" style="background-color:#529BC5;color:#ffffff"><?php echo $date_title; ?></div>
					<div class="panel-body">
							<div style="display:block;overflow:auto;">
							<table class="table table-hover table-striped table-bordered">
							  <thead>
								<tr>
								  <th width="5%">No</th>
								  <th><?php echo $field1;?></th>
								  <th width="20%">Total Keuangan</th>
								</tr>
							  </thead>
							  <tbody>
						<?php
							$i=1;
							$vtot=0;
							foreach($data_laporan_keu as $row){
							$vtot=$vtot+$row->jumlah_keu;
						?>
							<tr>
								<td><?php echo $i++;?></td>
								<td><?php echo $row->val_field1;?></td>
								<td>Rp <div class="pull-right"><?php echo number_format( $row->jumlah_keu, 2 , ',' , '.' );?></div></td>
							</tr>
						<?php
							}
						?>
							<tr>
								<td colspan="2"><b>Total</b></td>
								<td><b>Rp <div class="pull-right"><?php echo number_format( $vtot, 2 , ',' , '.' );?></div></b></td>
							</tr>
							  </tbody>
							 </table>
							<div class="form-inline" align="right">
								<div class="form-group">
									<a target="_blank" href="<?php echo site_url('irj/Rjclaporan/lap_keu_poli/'.$date.'/'.$tampil_per.'/'.$id_poli);?>"><input type="button" class="btn btn-primary" value="Cetak"></a>
								</div>
							</div>
					</div><!--- end panel body --->
				</div><!--- end panel --->
			</div><!--- end row --->
		</section>
	</div><!--- end container --->
</div><!-- content-wrapper -->
<?php
	foot();
?>
</div><!-- wrapper -->
</body>
</html>