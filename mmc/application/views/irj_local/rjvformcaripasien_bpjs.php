<?php
	$this->load->view('layout/header.php');
?>
<script type='text/javascript'>
$(function() {

	 $('#example').DataTable();
	 
	//$("#duplikat_id").hide();
	//$("#duplikat_kartu").hide();
	
	$('.auto_search_by_nocm').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_nocm',
		onSelect: function (suggestion) {
			$('#cari_no_cm').val(''+suggestion.no_cm);
			$('#no_medrec_baru').val(''+suggestion.no_medrec);
		}
	});
	
	$('.auto_search_by_nokartu').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_nokartu',
		onSelect: function (suggestion) {
			$('#cari_no_kartu').val(''+suggestion.no_kartu);
		}
	});
	
	$('.auto_search_by_noidentitas').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_noidentitas',
		onSelect: function (suggestion) {
			$('#cari_no_identitas').val(''+suggestion.no_identitas);
		}
	});

	$('.auto_search_by_nonrp').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_nonrp3',
		onSelect: function (suggestion) {
			$('#cari_no_nrp').val(''+suggestion.no_nrp);
		}
	});
	
	$('.auto_search_by_nama').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_nama'
		/*onSelect: function (suggestion) {
			$('#cari_no_identitas').val(''+suggestion.no_identitas);
		}
		*/
	});
	
	$('.auto_search_by_alamat').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_alamat'
		/*onSelect: function (suggestion) {
			$('#cari_no_identitas').val(''+suggestion.no_identitas);
		}
		*/
	});

	$('#cari_tgl').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  
		
});	

var ajaxku;

function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}

	
function cek_nokartu(no_medrec){
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcwebservice/check_no_kartu'); ?>";
    url=url+"/"+no_medrec;
    ajaxku.onreadystatechange=stateChangedSEP;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
}	
	
function stateChangedSEP(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("data_anggota").innerHTML = data;
			$('#data_webservice').modal('show');
		}else{
			document.getElementById("data_anggota").innerHTML = "Data Tidak Ditemukan";
		}
    }
}

function cek_search_per(val_search_per){
	//alert(val_search_per);
	if(val_search_per=='cm'){
		$("#cari_no_cm").css("display", ""); // To unhide
		$("#cari_no_kartu").css("display", "none");  // To hide
		$("#cari_no_identitas").css("display", "none");
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", "none"); 
		$("#cari_alamat").css("display", "none");
		$("#cari_tgl").css("display", "none");
	}
	else if(val_search_per=='kartu'){
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_kartu").css("display", ""); 
		$("#cari_no_identitas").css("display", "none");
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", "none"); 
		$("#cari_alamat").css("display", "none");
		$("#cari_tgl").css("display", "none");
	}
	else if(val_search_per=='identitas'){
		  // To hide
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", ""); 
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", "none");
		$("#cari_alamat").css("display", "none");	
		$("#cari_tgl").css("display", "none");
	}
	else if(val_search_per=='nama'){
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", "none"); 
		$("#cari_nama").css("display", ""); 
		$("#cari_no_nrp").css("display", "none"); 
		$("#cari_alamat").css("display", "none");	
		$("#cari_tgl").css("display", "none");
	} 
	else if(val_search_per=='nrp'){
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", "none"); 
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", ""); 
		$("#cari_alamat").css("display", "none");	
		$("#cari_tgl").css("display", "none");
	} 	
	else if(val_search_per=='alamat') {
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", "none"); 
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", "none");
		$("#cari_alamat").css("display", "");
		$("#cari_tgl").css("display", "none");
	}
	else {
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", "none"); 
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", "none"); 
		$("#cari_alamat").css("display", "none");
		$("#cari_tgl").css("display", "");
	}
}

function cek_no_identitas(no_identitas){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi_bpjs/cek_available_noidentitas')?>/"+no_identitas+"/",
		success: function(data){
			if (data>0) {
				document.getElementById("content_duplikat_id").innerHTML = "<i class=\"icon fa fa-ban\"></i> No Identitas \""+no_identitas+"\" Sudah Terdaftar ! <br>Silahkan masukkan no identitas lain...";
				$("#duplikat_id").show();
				document.getElementById("btn-submit").disabled= true;
				//$(window).scrollTop(0);
			} else {
				$("#duplikat_id").hide();
				document.getElementById("btn-submit").disabled= false;
			}
		},
		error: function (request, status, error) {
			alert(request.responseText);
		}
    });
}

function cek_no_kartu(no_kartu){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi_bpjs/cek_available_nokartu')?>/"+no_kartu+"/",
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
</script>
	
<?php echo $this->session->flashdata('success_msg'); ?>

<section class="content-header">
		
	<div class="small-box" style="background: #e4efe0">
		<div class="inner">
			<div class="container-fluid text-center"><br/>
				<div class="form-inline">
					<?php echo form_open('irj/rjcregistrasi_bpjs/pasien');?>
																		
					<select name="search_per" id="search_per" class="form-control"  onchange="cek_search_per(this.value)">
						<option value="cm">No MR</option>
						<option value="kartu">No Kartu</option>
						<option value="identitas">No Identitas</option>
						<option value="nama">Nama</option>
						<option value="nrp">NRP</option>
						<option value="alamat">Alamat</option>
						<option value="tgl">Tanggal Lahir</option>
					</select>
					<!--auto_search_by_nocm-->
					<input type="search" class="auto_search_by_nocm form-control" id="cari_no_cm" name="cari_no_cm" placeholder="Pencarian No MR">
					<input type="hidden" class="form-control" id="no_medrec_baru" name="no_medrec_baru" >
					<!--auto_search_by_nokartu-->
					<input type="search" style="width:450; display:none" class="auto_search_by_nokartu form-control" id="cari_no_kartu" name="cari_no_kartu" placeholder="Pencarian No Kartu">
					<!--auto_search_by_noidentitas-->
					<input type="search" style="width:450; display:none" class="auto_search_by_noidentitas form-control" id="cari_no_identitas" name="cari_no_identitas" placeholder="Pencarian No Identitas">
					<!--auto_search_by_nonrp-->
					<input type="search" style="width:450; display:none" class="auto_search_by_nonrp form-control" id="cari_no_nrp" name="cari_no_nrp" placeholder="Pencarian No NRP">
					<!--auto_search_by_nonrp-->
					<input type="search" style="width:450; display:none" class=" form-control" id="cari_nama" name="cari_nama" placeholder="Pencarian Nama">
					<!--auto_search_by_alamat-->
					<input type="search" style="width:450; display:none" class=" form-control" id="cari_alamat" name="cari_alamat" placeholder="Pencarian Alamat">

					<input type="search" style="width:450; display:none" class="form-control" id="cari_tgl" name="cari_tgl" placeholder="Pencarian Tgl Lahir">
					
					<button type="submit" class="btn btn-primary" type="button">Cari</button>
					
					<?php $url=site_url('irj/rjcregistrasi_bpjs/regpasien'); ?>
					<a href="<?php echo $url ?>" class="btn btn-danger" type="button">Tambah Pasien</a>
					
					<?php echo form_close();?>
						
				</div>		
			</div>
		</div>
	</div>
</section>

<section class="content" style="width:97%;margin:0 auto">
	<div class="row">
		
		<div class="tab-content">
			
				<div class="panel panel-default">
					<div class="panel-body">
						<br>
						<table id="example" class="display" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>No Medrec</th>
											<th>No Identitas</th>
											<th>No Kartu</th>
											<th>Nama</th>
											<th>NRP</th>
											<th>Hubungan</th>
											<th>Alamat</th>
											<th>Tgl Lahir</th>
											<th width="40px">Aksi</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>No Medrec</th>
											<th>No Identitas</th>
											<th>No Kartu</th>
											<th>Nama</th>
											<th>NRP</th>
											<th>Hubungan</th>
											<th>Alamat</th>
											<th>Tgl Lahir</th>
											<th>Aksi</th>
										</tr>
									</tfoot>
									<tbody>
										<?php
										if ($data_pasien!="") {
											foreach($data_pasien as $row){
											?>
											<tr>
												<td><?php echo $row->no_cm;?></td>
												<td><?php echo $row->jenis_identitas." - ".$row->no_identitas;?></td>
												<td><?php echo $row->no_kartu;?></td>
												<td><?php echo strtoupper($row->nama);?></td>
												<td><?php echo $row->no_nrp;?></td>
												<td><?php echo $row->hub_name;?></td>
												<td><?php echo $row->alamat;?></td>
												<td><?php echo date('d-m-Y',strtotime($row->tgl_lahir));?></td>
												<td>
													<a href="<?php echo site_url('irj/rjcregistrasi_bpjs/daftarulang/'.$row->no_medrec); ?>" class="btn btn-primary btn-xs" style='width:80px;'>Daftar Ulang</a><br>
													<a href="<?php echo site_url('medrec/Rme/histori/'.$row->no_cm); ?>" class="btn btn-danger btn-xs" target='_blank' style='width:80px;'>Rekam Medik</a>
												</td>
											</tr>
											<?php } 
											}
											?>
									</tbody>
								</table>
					</div><!-- end panel body -->
				</div><!-- end panel info-->
				
			</div><!-- end div id home -->
		</div><!-- end tab content -->
			
	
</section>
	
<?php
	$this->load->view('layout/footer.php');
?>
