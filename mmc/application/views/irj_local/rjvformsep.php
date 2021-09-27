<?php $this->load->view("layout/header"); ?>
	<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(function(){	
	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({      	
      	radioClass: 'iradio_flat-green'
    	});

	$(".select2").select2();
	$("#btnBIo").click(function(){
		alert("hi");
		$("p").show();
	});
	$("#tableCari").dataTable({"iDisplayLength": 25});
	$("#duplikat_id").hide();
	$("#duplikat_kartu").hide();

	
	
	$('.auto_search_by_nocm').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/ird/IrDRegistrasi/data_pasien',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#cari_no_medrec').val(''+suggestion.no_cm);
			$('#no_medrec_baru').val(''+suggestion.no_medrec);
		}
		
	});

	

	$('.auto_search_poli').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/ird/IrDRegistrasi/data_poli',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#id_poli').val(''+suggestion.id_poli);
			$('#kd_ruang').val(''+suggestion.kd_ruang);
		}
	});
	$('.auto_search_by_nokartu').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/ird/IrDRegistrasi/data_pasien_by_nokartu',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#cari_no_kartu').val(''+suggestion.no_kartu);
			$('#no_cmkartu').val(''+suggestion.no_medrec);
		}
	});
	$('.auto_search_by_noidentitas').autocomplete({
		// serviceUrl berisi URL ke controller/fungsi yang menangani request kita
		serviceUrl: site+'/ird/IrDRegistrasi/data_pasien_by_noidentitas',
		// fungsi ini akan dijalankan ketika user memilih salah satu hasil request
		onSelect: function (suggestion) {
			$('#cari_no_identitas').val(''+suggestion.no_identitas);
			$('#no_cmident').val(''+suggestion.no_medrec);
		}
	});

	$('.date_picker').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  

	$('#tgl_daftar').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  
});

</script>
<script>
        jQuery(document).ready(function($){
            $('.delete-sep').on('click',function(){
                var getLink = $(this).attr('href');
               swal({
  			   title: "Hapus Nomor SEP",
  			   text: "Yakin akan menghapus Nomor SEP ini?",
  			   type: "warning",
  			   showCancelButton: true,
  			   confirmButtonColor: "#DD6B55",
  			   confirmButtonText: "Hapus",
  			   closeOnConfirm: false
			   },function(){
                        window.location.href = getLink
                    });
                return false;
            });
        });
    </script>
<?php echo $this->session->flashdata('message'); ?>		
<?php echo $this->session->flashdata('notification'); ?>		

	<section class="content" style="width:97%;margin:0 auto">
		<div class="row">			
			
			<div class="box">
					<div class="box-title">
						<center><h4> Tabel Daftar SEP Pasien</h4><hr></div>
					<div class="box-body">
						<?php echo form_open('irj/rjcregistrasi/kelola_sep');?>
					<div class="col-lg-12">
					<div class="form-inline">						
						<!--<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Awal" name="tgl_awal" onchange="cek_tgl_awal(this.value)" required>-->
						<input type="text" id="date_picker" class="form-control date_picker" placeholder="yyyy-mm-dd" name="tgl0" required>						
						<input type="text" id="date_picker1" class="form-control date_picker" placeholder="yyyy-mm-dd" name="tgl1" required>
				  
						&nbsp;&nbsp;&nbsp;&nbsp;
						<button class="btn btn-primary" type="submit">Cari</button>
						
					</div>
					
				</div><!-- /inline -->
			<?php echo form_close();?>
						<br>
						<table id="tableCari"  class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
								  <th>No</th>
								  <th>No. SEP</th>								  
								  <th>No. Medrec</th>
								  <th>No Kartu</th>
								  <th>No. Register</th>
								  <th>Tgl Kunjungan</th>
								  <th>Tgl Pulang</th>
								  <th>Nama</th>
								  <th>Status</th>
								  <th>Ket Pulang</th>
								  <th>Aksi</th>
								</tr>
							  </thead>
							  <tbody><?php //if($search_per=='nama' || $search_per=='alamat') { ?>
								<?php if ($daftar_sep!=''){
								// print_r($pasien_daftar);
								$i=1;
									foreach($daftar_sep as $row){
									$no_medrec=$row->no_medrec;
									$no_register=$row->no_register;
								?>
									<tr>
										<td><?php echo $i++ ; ?></td>
										<td><?php echo $row->no_sep; ?></td>
										<td><?php echo $row->no_cm; ?></td>
										<td><?php echo $row->no_kartu; ?></td>										
										<td><?php echo $row->no_register; ?></td>										
										<td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan)).' | '. date("H:i", strtotime($row->tgl_kunjungan)); ?></td>						
										<td><?php echo $row->tgl_pulang; ?></td>
										<td><?php echo $row->nama; ?></td>
										<td><?php echo $row->status; ?></td>
										<td><?php echo $row->ket_pulang; ?></td>
										<td>
											<a class="btn btn-primary btn-xs" target="_blank" href="<?php echo site_url('irj/rjcregistrasi/cetak_ulang_sep/'.$row->no_register); ?>">Cetak</a>
											<a class="btn btn-success btn-xs" href="<?php echo site_url('irj/rjcregistrasi/update_tgl_pulang/'.$row->no_sep); ?>">Update</a>
											<a class="btn btn-danger btn-xs delete-sep" href="<?php echo site_url('irj/rjcregistrasi/hapus_sep/'.$row->no_sep); ?>">Hapus</a>																						
										</td>
									</tr>
								<?php
									}}
								?><?php
		//}
	?>
							  </tbody>
						</table>
						<br>
						<p>*) Update tanggal pulang SEP di BPJS</p>	
						<p>*) Hapus Nomor SEP di BPJS</p>	
				</div>	
	</div>
		
	</div><!--- end row -->
</section>
<?php $this->load->view("layout/footer"); ?>
