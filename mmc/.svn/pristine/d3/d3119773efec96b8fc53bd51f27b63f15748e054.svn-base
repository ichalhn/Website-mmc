
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
		$('#date_picker_days').datepicker({
				format: "yyyy-mm-dd",
				endDate: "current",
				autoclose: true,
				todayHighlight: true,
		}); 
		$('#date_picker_months').datepicker({
				format: "yyyy-mm",
				endDate: "current",
				autoclose: true,
				todayHighlight: true,
				viewMode: "months", 
				minViewMode: "months",
		}); 
		$('#date_picker_years').datepicker({
				format: "yyyy",
				endDate: "current",
				autoclose: true,
				todayHighlight: true,
				format: "yyyy",
				viewMode: "years", 
				minViewMode: "years",
		});
		$('#date_picker_days').show();
		$('#date_picker_months').hide();
		$('#date_picker_years').hide();
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
	function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='TGL'){
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker_days").required = true;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker_days').show();
			$('#date_picker_months').hide();
			$('#date_picker_years').hide();
		}else if(val_tampil_per=='BLN'){
			document.getElementById("date_picker_days").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker_days").required = false;
			document.getElementById("date_picker_months").required = true;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker_days').hide();
			$('#date_picker_months').show();
			$('#date_picker_years').hide();
		}else{
			document.getElementById("date_picker_days").value = '';
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker_days").required = false;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = true;
			$('#date_picker_days').hide();
			$('#date_picker_months').hide();
			$('#date_picker_years').show();
		}
	}
	
	var site = "<?php echo site_url();?>";
	$(function(){
            $('.auto_search_poli').autocomplete({
                // serviceUrl berisi URL ke controller/fungsi yang menangani request kita
                serviceUrl: site+'/irj/Rjcautocomplete/data_poli',
                // fungsi ini akan dijalankan ketika user memilih salah satu hasil request
                onSelect: function (suggestion) {
                    $('#id_poli').val(''+suggestion.id_poli);
                }
            });
        });
</script>

			<div class="box box-solid bg-light-blue-gradient collapsed-box">
                <div class="box-header">
                  <h3 class="box-title">PENCARIAN DATA</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-primary btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  </div>
                </div>
                <div class="box-body border-radius-none" style="background-color:ffffff">
					<div class="panel-body">
						<ul class="nav nav-tabs">
							<li><a href="#pane_cari_semua" data-toggle="tab">Semua Poli</a></li>
							<li><a href="#pane_cari_poli" data-toggle="tab">Pilih Poli</a></li>
						</ul>
						<div id="myTabContent" class="tab-content">
							<div class="tab-pane fade active in"  id="pane_cari_semua">
								<div class="form-inline">
									<?php echo form_open('irj/Rjclaporan/data_keuangan');?>
									<div class="col-lg-2">
											<input type="text" id="date_picker1" class="form-control" placeholder="Tanggal Awal" name="tgl_awal" required onchange="cek_tgl_awal(this.value)">
									</div><!-- /col-lg-2 -->
									<div class="col-lg-2">
											<input type="text" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="tgl_akhir" required onchange="cek_tgl_akhir(this.value)">
									</div><!-- /col-lg-2 -->
									<div class="col-lg-2">
											<span class="input-group-btn">
												<button class="btn btn-primary" type="submit">Cari</button>
											</span>
									</div><!-- /col-lg-2 -->
									<?php echo form_close();?>
								</div><!-- /inline -->
							</div>
							<div class="tab-pane fade"  id="pane_cari_poli">
								<div class="row">
								<div class="form-inline">
									<?php echo form_open('irj/Rjclaporan/data_keuangan_poli');?>
									<div class="col-lg-10">
										<div class="form-inline">
											<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
												<option value="TGL">Tanggal</option>
												<option value="BLN">Bulan</option>
												<option value="THN">Tahun</option>
											</select>
											<input type="text" id="date_picker_days" class="form-control" placeholder="yyyy-mm-dd" name="date_picker_days">
											<input type="text" id="date_picker_months" class="form-control" placeholder="yyyy-mm" name="date_picker_months">
											<input type="text" id="date_picker_years" class="form-control" placeholder="yyyy" name="date_picker_years">
											
											<input type="search" style="width:430;"class="auto_search_poli form-control" id="nm_poli" placeholder="Nama Poli" name="nm_poli" required>
											<input type="text" size="6" class="form-control" placeholder="" id="id_poli" readonly name="id_poli">
										</div>
									</div><!-- /inline -->
									<div class="col-lg-2">
										<span class="input-group-btn">
											<button class="btn btn-primary" type="submit">Cari</button>
										</span>
									</div>
								</div>
									<?php echo form_close();?>
								</div>
							</div>
						</div><!-- /tab-content -->
					</div><!-- /panel body -->
                </div><!-- /.box-body -->
			</div><!-- /.box -->