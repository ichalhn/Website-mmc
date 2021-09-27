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

	$('#date_picker').datepicker({
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
<?php echo $this->session->flashdata('message'); ?>		

	<section class="content" style="width:97%;margin:0 auto">
		<div class="row">			
			
			<div class="box">
					<div class="box-title">
						<center><h4> Daftar Pasien IRJ Tanggal <b><?php echo date('d-m-Y', strtotime("-6 days")) ?></b> s/d <b><?php echo  date('d-m-Y') ?></b></h4><hr></div>
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
								  <th>Poliklinik</th>
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
										<td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan)).' | '. date("H:i", strtotime($row->tgl_kunjungan)); ?></td>										<td><?php echo strtoupper($row->nama); ?></td>										<td><?php echo $row->no_identitas; ?></td>
										<td><?php echo $row->nm_poli;?></td>
																													
										<td>
											<a href="<?php echo site_url("irj/rjcpelayanan/pelayanan_tindakan/".$row->id_poli."/".$no_register);?>" class="btn btn-danger btn-xs">Tindak</a>
											<a href="<?php echo site_url('medrec/Rme/histori/'.$row->no_cm); ?>" class="btn btn-danger btn-xs" target='_blank' style='width:80px;'>Rekam Medik</a>
											<a href="<?php echo site_url("irj/rjcregistrasi/cetak_tracer/".$no_register);?>" target="_blank" class="btn btn-warning btn-xs">Tracer</a>
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
		
	</div><!--- end row -->
</section>
<?php $this->load->view("layout/footer"); ?>
