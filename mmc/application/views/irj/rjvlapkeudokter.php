<?php
	include('rjvheader.php');
	include('rjvfooter.php');
	
?>
<html>
<?php
	head();
?>
<script type='text/javascript'>
	$(document).ready(function () {
        $('#date_picker1').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
        });
        $('#date_picker2').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
        });  
    });
	function cek_tgl_awal(tgl_awal){
		var tgl_akhir=document.getElementById("date_picker2").value;
		if(tgl_akhir==''){
		//none :D just none
		}else if(tgl_akhir<tgl_awal){
			document.getElementById("date_picker2").value = '';
		}
	}
	function cek_tgl_akhir(tgl_akhir){
		var tgl_awal=document.getElementById("date_picker1").value;
		if(tgl_akhir<tgl_awal){
			document.getElementById("date_picker1").value = '';
		}
	}
</script>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php
	include('rjvnav.php');
?>
<div class="content-wrapper">
	<div class="container-fluid">
		<section class="content-header">
			<legend>Laporan Pendapatan Dokter Instalasi Rawat Jalan</legend>
			<div class="box box-solid bg-light-blue-gradient collapsed-box">
                <div class="box-header">
                  <h3 class="box-title">PENCARIAN DATA</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body border-radius-none" style="background-color:ffffff">
					<div class="panel-body">
						<div class="form-inline">
							<?php echo form_open('irj/Rjclaporan/data_keu_dokter');?>
							<div class="col-lg-2">
									<input type="text" id="date_picker1" class="form-control" placeholder="Tanggal Awal" name="tgl_awal" required onchange="cek_tgl_awal(this.value)">
							</div>
							<div class="col-lg-2">
									<input type="text" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="tgl_akhir" required onchange="cek_tgl_akhir(this.value)">
							</div>
							<div class="col-lg-2">
									<span class="input-group-btn">
										<button class="btn btn-primary" type="submit">Cari</button>
									</span>
							</div>
							<?php echo form_close();?>
						</div><!-- /inline -->
					</div><!-- /panel body -->
                </div><!-- /.box-body -->
			</div><!-- /.box -->
		</section>
		<section class="content">
			<div class="row">
				<div class="panel panel-info">
					<div class="panel-heading" align="center" style="background-color:#529BC5;color:#ffffff">Laporan Pendapatan Dokter <?php echo $date_title; ?></div>
					<div class="panel-body">
						<div style="display:block;overflow:auto;">
							<table class="table table-hover table-striped table-bordered">
							  <thead>
								<tr>
								  <th width="5%">No</th>
								  <th width="10%">ID Dokter</th>
								  <th>Nama Dokter</th>
								  <th>Total Pendapatan</th>
								</tr>
							  </thead>
							  <tbody>
							  
						<?php
							$i=1;
							$vtot=0;
							foreach($data_pendapatan_dokter as $row){
							$vtot=$vtot+$row->jumlah_keu_dokter;
						?>
							<tr>
								<td><?php echo $i++;?></td>
								<td><?php echo $row->id_dokter;?></td>
								<td><?php echo $row->nm_dokter;?></td>
								<td>Rp <div class="pull-right"><?php echo number_format( $row->jumlah_keu_dokter, 2 , ',' , '.' );?></div></td>
							</tr>
						<?php
							}
						?>
							<tr>
								<td colspan="3"><b>Total</b></td>
								<td>Rp <div class="pull-right"><b><?php echo number_format( $vtot, 2 , ',' , '.' );?></b></div></td>
							</tr>
							  </tbody>
							 </table>
							<div class="form-inline" align="right">
								<div class="form-group">
									<a target="_blank" href="<?php echo site_url('irj/Rjclaporan/lap_keu_dokter/'.$tgl_awal.'/'.$tgl_akhir);?>"><input type="button" class="btn btn-primary" value="Cetak"></a>
								</div>
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