<section class="content-header">
		
	<div class="small-box" style="background: #e4efe0">
		<div class="inner">
			<div class="container-fluid text-center"><br/>
				<div class="form-inline">
					<?php echo form_open('ird/IrDRegistrasi/index2');?>
																		
					<select name="search_per" id="search_per" class="form-control"  onchange="cek_search_per(this.value)">
						<option value="cm">No CM</option>
						<option value="kartu">No Kartu</option>						
						<option value="identitas">No Identitas</option>
						<option value="nama">Nama Pasien</option>
						<option value="alamat">Alamat</option>
					</select>
					
					<input type="search" class="auto_search_by_nocm form-control" id="cari_no_medrec" name="cari_no_medrec" placeholder="Cari No CM">
					<input type="hidden" class="form-control" id="no_medrec_baru" name="no_medrec_baru" >
					
					<input type="search" style="width:450; display:none" class="auto_search_by_nokartu form-control" id="cari_no_kartu" name="cari_no_kartu" placeholder="Pencarian No Kartu">
					<input type="hidden" style="width:450" class="form-control" id="no_cmkartu" name="no_cmkartu">

					<input type="search" style="width:450; display:none" class="auto_search_by_noidentitas form-control" id="cari_no_identitas" name="cari_no_identitas" placeholder="Cari No Identitas">
					<input type="hidden" style="width:450" class="form-control" id="no_cmident" name="no_cmident">

					<input type="search" style="width:450; display:none" class="form-control" id="cari_nama" name="cari_nama" placeholder="Cari Nama">
			
					<input type="search" style="width:450; display:none" class="form-control" id="cari_alamat" name="cari_alamat" placeholder="Cari Alamat">
					
					<button type="submit" class="btn btn-primary" type="button">Cari</button>
					
					<a href="<?php echo site_url();?>ird/IrDRegistrasi/tambah" class="btn btn-primary" type="button">Tambah Pasien</a>
					
					<?php echo form_close();?>
						
				</div>		
			</div>
		</div>
	</div>
	
</section>
