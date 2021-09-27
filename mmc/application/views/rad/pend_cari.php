<div class="row">
	<div class="form-group">
		<?php echo form_open('rad/Radclaporan/data_pendapatan');?>
		<div class="col-lg-2" style="min-width:13%;">
			<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
				<option value="TGL">Tanggal</option>
				<option value="BLN">Bulan</option>
				<option value="THN">Tahun</option>
			</select>											
		</div>
		<div id="date_input">
			<div class="col-lg-2">
				<input type="text" id="date_picker_days" class="form-control" placeholder="Tanggal" name="date_picker_days" required onchange="cek_tgl(this.value)">
			</div>						
		</div>
		<div id="month_input">
			<div class="col-lg-2">
				<input type="text" id="date_picker_months" class="form-control" placeholder="Bulan" name="date_picker_months"></div>
			<div class="col-lg-2">
				<select name="jenis_pasien1" id="jenis_pasien1" class="form-control">
					<option value="">Semua</option>
					<option value="BPJS">BPJS</option>
					<option value="DIJAMIN / JAMSOSKES">DIJAMIN / JAMSOSKES</option>
					<option value="UMUM">Umum</option>
				</select>
			</div>					
		</div>
		<div id="year_input">
			<div class="col-lg-2">
				<input type="text" id="date_picker_years" class="form-control" placeholder="Tahun" name="date_picker_years">
			</div>		
			<div class="col-lg-2">
				<select name="jenis_pasien2" id="jenis_pasien2" class="form-control">
					<option value="">Semua</option>
					<option value="BPJS">BPJS</option>
					<option value="DIJAMIN / JAMSOSKES">DIJAMIN / JAMSOSKES</option>
					<option value="UMUM">Umum</option>
				</select>
			</div>									
		</div>		
		
		<div class="col-lg-1">
			<span class="input-group-btn">
				<button class="btn btn-primary" name="btnSubmit" id="btnSubmit" type="submit">Cari</button>
			</span>
		</div>
		
		<?php echo form_close();?>
	</div>				
</div>
