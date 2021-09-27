<?php $this->load->view("layout/header"); ?>
	<?php
	include('script_formdaftar.php');	
	?>
<?php echo $this->session->flashdata('message'); ?>

	
	
	<?php
	include('search_panel.php');	
	?>		


	<section class="content" style="width:97%;margin:0 auto">
		<div class="row">			
			
			<div class="box">					
					<div class="box-body">
						
						<table id="tableCari"  class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
								  <th>No</th>
								  <th>No Medrec</th>
								  <th>Nama</th>
								  <th>No Identitas</th>
								  <th>Alamat</th>
								  <th>Tgl Lahir</th>
								  <th>Aksi</th>
								</tr>
							  </thead>
							  <tbody><?php //if($search_per=='nama' || $search_per=='alamat') { ?>
								<?php if ($data_cari!=''){
								// print_r($pasien_daftar);
								$i=1;
									foreach($data_cari as $row){
									$no_medrec=$row->no_medrec;
									
								?>
									<tr>
										<td><?php echo $i++ ; ?></td>
										<td><?php echo $row->no_cm; ?></td>										
										<td><?php echo strtoupper($row->nama); ?></td>										<td><?php echo $row->jenis_identitas." - ".$row->no_identitas; ?></td>
										<td><?php echo ucfirst($row->alamat);?></td>
										<td><?php echo date('d-m-Y',strtotime($row->tgl_lahir));?></td>
																													
										<td>
											<a href="<?php echo site_url("ird/IrDRegistrasi/index2/".$no_medrec);?>" class="btn btn-danger btn-xs">Pilih</a>
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
		
	</div><!--- end row --->
</section>
<?php $this->load->view("layout/footer"); ?>
