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

var ajaxku;
function ajaxkota(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('ird/IrDRegistrasi/data_kotakab'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChanged;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_provinsi").value = res[0];
	document.getElementById("provinsi").value = res[1];
}

function ajaxkec(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('ird/IrDRegistrasi/data_kecamatan'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedKec;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_kotakabupaten").value = res[0];
	document.getElementById("kotakabupaten").value = res[1];
}

function ajaxkel(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('ird/IrDRegistrasi/data_kelurahan'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedKel;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_kecamatan").value = res[0];
	document.getElementById("kecamatan").value = res[1];
}
function setkel(id){
	var res=id.split("-");//it Works :D
	document.getElementById("id_kelurahandesa").value = res[0];
	document.getElementById("kelurahandesa").value = res[1];
}

function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}
function stateChanged(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
    document.getElementById("kota").innerHTML = data
    }else{
    document.getElementById("kota").value = "<option selected>Pilih Kota/Kab</option>";
    }
    }
}

function stateChangedKec(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
    document.getElementById("kec").innerHTML = data
    }else{
    document.getElementById("kec").value = "<option selected>Pilih Kecamatan</option>";
    }
    }
}

function stateChangedKel(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
    document.getElementById("kel").innerHTML = data
    }else{
    document.getElementById("kel").value = "<option selected>Pilih Kelurahan/Desa</option>";
    }
    }
}




function cek_no_kartu(no_kartu){
	if(no_kartu!=''){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_nokartu')?>/"+no_kartu+"/",
		success: function(data){
			//alert(data);
			if (data>0) {
				//alert("No Kartu '"+no_kartu+"' Sudah Terdaftar ! <br> Silahkan masukkan no kartu lain...");
				document.getElementById("content_duplikat_kartu").innerHTML = "<i class=\"icon fa fa-ban\"></i> No Kartu \""+no_kartu+"\" Sudah Terdaftar ! Silahkan masukkan no kartu lain...";
				$("#duplikat_kartu").show();
				document.getElementById("btn-submit").disabled= true;
			} else {
				$("#duplikat_kartu").hide();
				document.getElementById("btn-submit").disabled= false;
			}
		},
		error: function (request, status, error) {
			alert(request.responseText);
		}
	});
	}
}


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
										<td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan)).' | '. date("H:i", strtotime($row->tgl_kunjungan)); ?></td>										
										<td><?php echo strtoupper($row->nama); ?></td>					
										<td>
										<a href="<?php echo site_url("irj/rjcregistrasi/pasien_bpjs/".$no_register);?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o"></i> Detail</a>
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
