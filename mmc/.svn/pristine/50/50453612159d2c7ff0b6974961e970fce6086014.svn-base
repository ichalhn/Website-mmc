
<div class="panel-body">	
	<!-- table -->
		<br>
			<div style="display:block;overflow:auto;">
				<h3>Daftar Input User Radiologi</h3>
				<table id="tabel_tindakan" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Total</th>
							<th>User</th>							
						</tr>
					</thead>
				<tbody>
				<?php // print_r($pasien_daftar);
				$i=1;
					foreach($rad as $row){
				?>
				<tr>
					<td><?php echo $i++ ; ?></td>
					<td><?php echo $row->total ; ?></td>
					<td><?php echo $row->xinput ; ?></td>
				</tr>
				<?php } ?>

					</tbody>
				</table>
				<div class="form-inline " align="right" style="padding-top:30px;">
					<a href="<?php echo site_url("user/cuser/cetak_penunjang/rad/".$date_awal."/".$date_akhir);?>" class="btn btn-primary ">Cetak</a>								
				</div>
				<hr>
				<h3>Daftar Cetak Kwitansi Radiologi</h3>
				<table id="tabel_cetak_rad" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Total</th>
							<th>User</th>							
						</tr>
					</thead>
				<tbody>
				<?php // print_r($pasien_daftar);
				$i=1;
					foreach($cetak_rad as $row){
				?>
				<tr>
					<td><?php echo $i++ ; ?></td>
					<td><?php echo $row->total ; ?></td>
					<td><?php echo $row->xuser ; ?></td>
				</tr>
				<?php } ?>

					</tbody>
				</table>
				<div class="form-inline " align="right" style="padding-top:30px;">
					<a href="<?php echo site_url("user/cuser/cetak_penunjang/krad/".$date_awal."/".$date_akhir);?>" class="btn btn-primary ">Cetak</a>								
				</div>
			</div><!-- style overflow -->
</div> 
