<?php $this->load->view("layout/header"); ?>
<?php $this->load->view("iri/layout/script_addon"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
<script>

function flag_tgl_pulang_sep(){
	var no_sep = "";
	$.ajax({
	    type:'POST',
	    url:'<?php echo base_url("iri/ricstatus/set_pulang_sep/"); ?>',
	    data:{
	    		'no_sep':  no_sep
	    	},
	    success:function(data){
    		
	    }
	});

	//alert(jumlah);
}

function hapus_sep(){
	var no_sep = "";
	$.ajax({
	    type:'POST',
	    url:'<?php echo base_url("iri/ricstatus/hapus_sep/"); ?>',
	    data:{
	    		'no_sep':  no_sep
	    	},
	    success:function(data){
    		
	    }
	});

	//alert(jumlah);
}



</script>
<div >
	<div >
		
		<!-- Keterangan page -->
		<section class="content-header">
			<h1>PASIEN DALAM PERAWATAN</h1>
			<ol class="breadcrumb">
				<li><a href="#"><i class="fa fa-home"></i> Home</a></li>
				<li><a href="#">Pasien</a></li>
			</ol>
		</section>
		<!-- /Keterangan page -->

        <!-- Main content -->
        <!-- <section class="content">
			<div class="row">
				<div class="col-sm-12">
					
				
					<div class="box box-success">
						<br/>
						<div class="box-body">
							<table id="dataTables-example" class="table table-bordered table-striped data-table">
								<thead>
									<tr>
										<th>Tgl. Masuk</th>
										<th>No. Register</th>
										<th>Nama</th>
										<th>Kelas</th>
										<th>No. Bed</th>
										<th>Penjamin</th>
										<th>Dokter Yang Merawat</th>
										<th>LOS</th>
										<th>Total Biaya</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
					
					
				</div>
			</div>
		</section> -->

		<section class="content">
				<div class="row">
					<?php echo $this->session->flashdata('pesan');?>
						<div class="panel panel-info">
							<div class="panel-body">
								<br/>
						<div style="display:block;overflow:auto;">
						<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
						  <thead>
							<tr>
								<th>No. Register</th>
								<th>No. MedRec</th>
								<th>Nama</th>
								<th>Kamar</th>
								<th>Kelas</th>
								<th>No. Bed</th>
								<th>Tgl. Masuk</th>
								<th>Dokter Yang Merawat</th>
								<th>Bayi</th>
								<th>Aksi</th>
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
						  	foreach ($list_pasien as $r) { ?>
						  	<tr>
						  		<td><?php echo $r['no_ipd']?></td>
						  		<td><?php echo $r['no_cm']?></td>
						  		<td><?php echo $r['nama']?></td>
						  		<td><?php echo $r['nmruang']?></td>
						  		<td><?php echo $r['kelas']?></td>
						  		<td><?php echo $r['bed']?></td>
						  		<td>
					  			<?php 						  		
						  		echo date('d F Y',strtotime($r['tglmasukrg']));
						  		?>
						  		</td>
						  		<td><?php echo $r['dokter']?></td>
						  		<td><?php 
						  			if($r['status_bayi'] == 0){
						  				echo "Tidak Punya";
						  			}else{
						  				echo "Punya";
						  			}
						  			?>
						  		</td>
						  		<td>
						  		<button type="button" class="btn btn-primary btn-sm" onclick="flag_tgl_pulang_sep()"><i class="fa fa-plusthick"></i> Flag Pulang BPJS</button>
						  		<button type="button" class="btn btn-primary btn-sm" onclick="hapus_sep()"><i class="fa fa-plusthick"></i> Hapus BPJS</button>
						  		</td>
						  	</tr>
						  	<?php
						  	}
						  	?>
							</tbody>
						</table>
						</div><!-- style overflow -->
					</div><!--- end panel body -->
				</div><!--- end panel -->
				</div><!--- end panel -->
			</section>
		<!-- /Main content -->
		
	</div>
</div>
<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
	});
	$('#calendar-tgl').datepicker();
</script>

<?php $this->load->view("layout/footer"); ?>
