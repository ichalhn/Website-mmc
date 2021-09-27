<?php $this->load->view("layout/header"); ?>
<script>
var intervalSetting = function () { 
location.reload(); 
}; 
setInterval(intervalSetting, 120000);
</script>
	<?php
	include('script_formdaftar.php');	
	?>
	<?php
		if($message!=''){
	?>
		<div class="content-header">
			
				<?php if($message!='1'){ 
					if($message=='Berhasil'){?>
				
				<div class="alert alert-success alert-dismissable">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>				
				<h4><i class="icon fa fa-check"></i>
					Registrasi Berhasil
				</h4>
				<?php }else { ?>
				<div class="alert alert-danger alert-dismissable">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>				
				<h4><i class="icon fa fa-close"></i>
					<?php echo $message ?>
				</h4>
				<?php }} else {?>				
				
				<div class="alert alert-danger alert-dismissable">
					<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button><h4><i 					class="icon fa fa-close"></i>
					Data dengan <?php echo $search_per.' : "'.$cari ?>" Tidak Ditemukan
				</h4>
				<?php }?>	
				</div>
			
		</div>
	<?php
		}
	?>
			

	<section class="content" style="width:97%;margin:0 auto">
		<div class="row">			
			
			<div class="box">
					<div class="box-title">
						<center><h4> Daftar Pasien IRD Tanggal <b><?php echo date('d-m-Y', strtotime("-3 days")) ?></b> s/d <b><?php echo  date('d-m-Y') ?></b></h4><hr></div>
					<div class="box-body">
						
						<table id="tableCari"  class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
								  <th>No</th>
								  <th>No Medrec</th>
								  <th>No Register</th>
								  <th>Tgl Kunjungan</th>
								  <th>Nama</th>
								  <th>No Identitas</th>
								  <th>Pasien</th>
								  <th>Aksi</th>
								</tr>
							  </thead>
							  <tbody><?php //if($search_per=='nama' || $search_per=='alamat') { ?>
								<?php if ($daftar_pasien!=''){
								// print_r($pasien_daftar);
								$i=1;
									foreach($daftar_pasien as $row){
									$no_medrec=$row->no_medrec;
									$no_register=$row->no_register;
								?>
									<tr>
										<td><?php echo $i++ ; ?></td>
										<td><?php echo $row->no_cm; ?></td>										<td><?php echo $row->no_register; ?></td>										
										<td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan)).' | '. date("H:i", strtotime($row->tgl_kunjungan)); ?></td>										<td><?php echo strtoupper($row->nama); ?></td>					<td><?php echo $row->no_identitas; ?></td>
										<td><?php echo $row->cara_bayar;?></td>
																													
										<td>
											<a href="<?php echo site_url("ird/IrDRegistrasi/daftar_ird/".$no_register);?>" class="btn btn-danger btn-xs">Pilih</a>
										</td>
									</tr>
								<?php
									}}
								?><?php
		//}
	?>
							  </tbody>
						</table>
									
				</div>	
	</div>
	
</section>
<?php $this->load->view("layout/footer"); ?>
