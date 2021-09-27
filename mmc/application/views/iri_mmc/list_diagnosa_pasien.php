<?php $this->load->view("layout/header"); ?>
<?php $this->load->view("iri/data_pasien"); ?>
<?php $this->load->view("iri/layout/script_addon"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
<script>
	
function form_tambah_tindakan(){
	alert("test");
}


$('tindakan').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    alert(valueSelected);
});

// moris below

function pilih_tindakan(val){
	var temp = val.split("-");
	var cara_bayar = "$data_pasien[0]['carabayar']";

	$('#biaya_tindakan').val(temp[1]);
	$('#biaya_tindakan_hide').val(temp[1]);
	var qty = $('#qtyind').val();
	var total = qty * temp[1];
	$('#vtot').val(total);

	$.ajax({
	    type:'POST',
	    url:'<?php echo base_url("iri/rictindakan/get_tarif_by_jatah_id_kelas/"); ?>',
	    data:{
	    		'id_tindakan':temp[0],
	    		'cara_bayar':temp[0],
	    		'kelas':"<?php echo $data_pasien[0]['jatahklsiri']; ?>",
	    	},
	    success:function(data){
    		var obj = JSON.parse(data);
    		
    		if(!isEmpty(obj)){
    			$("#harga_satuan_jatah_kelas").val(obj[0]['total_tarif']);
    			$("#biaya_jatah_kelas").val(obj[0]['total_tarif']);
    			$('#vtot_kelas').val(obj[0]['total_tarif']);
    			$('#vtot').val(total - (obj[0]['total_tarif'] * qty) );
    			$('#biaya_tindakan').val(temp[1] - obj[0]['total_tarif']);
    		}else{
    			$("#harga_satuan_jatah_kelas").val('0');
    			$("#biaya_jatah_kelas").val('0');
    			//$('#vtot').val('0');
    		}
	    }
	});
}

function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }

    return true;
}

function set_total(val){
	var biaya_tindakan = $('#biaya_tindakan').val();
	var harga_satuan_jatah_kelas = $('#harga_satuan_jatah_kelas').val();

	var total = val * biaya_tindakan;
	var total_jatah_kelas = val * harga_satuan_jatah_kelas;
	$('#vtot').val(total);
	$('#vtot_kelas').val(total_jatah_kelas);
}

function insert_total(){
	var jumlah = $('#jumlah').val();

	// bawah
	//qty di set 1 karena hasil dari perhitungan sendiri


	var val = $('select[name=idtindakan]').val();
	var temp = val.split("-");
	var cara_bayar = "$data_pasien[0]['carabayar']";

	$('#biaya_tindakan').val(jumlah);
	$('#biaya_tindakan_hide').val(jumlah);
	var qty = 1;
	$('#qtyind').val(1)
	var total = qty * jumlah;
	$('#vtot').val(total);

	$.ajax({
	    type:'POST',
	    url:'<?php echo base_url("iri/rictindakan/get_tarif_by_jatah_id_kelas/"); ?>',
	    data:{
	    		'id_tindakan':temp[0],
	    		'cara_bayar':temp[0],
	    		'kelas':"<?php echo $data_pasien[0]['jatahklsiri']; ?>",
	    	},
	    success:function(data){
    		var obj = JSON.parse(data);
    		
    		if(!isEmpty(obj)){
    			$("#harga_satuan_jatah_kelas").val(obj[0]['total_tarif']);
    			$("#biaya_jatah_kelas").val(obj[0]['total_tarif']);
    			$('#vtot_kelas').val(obj[0]['total_tarif']);
    			$('#vtot').val(total - (obj[0]['total_tarif'] * qty) );
    			$('#biaya_tindakan').val(jumlah - obj[0]['total_tarif']);
    		}else{
    			$("#harga_satuan_jatah_kelas").val('0');
    			$("#biaya_jatah_kelas").val('0');
    			//$('#vtot').val('0');
    		}
	    }
	});

	//alert(jumlah);
}

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_diagnosa_pasien_2').autocomplete({
		serviceUrl: site+'iri/ricstatus/data_icd_1',
		onSelect: function (suggestion) {
			//$('#no_cm').val(''+suggestion.no_cm);
			$('#diagnosa2_name').val(suggestion.kode_icd+' - '+suggestion.nm_diagnosa);
			$('#id_row_diagnosa2').val(''+suggestion.kode_icd);
			$('#nm_diagnosa').val(''+suggestion.nm_diagnosa);
			// $('#nama').val(''+suggestion.nama);
			// $('.tanggal_lahir').val(''+suggestion.tanggal_lahir);
			// if(suggestion.jenis_kelamin=='L'){
			// 	$('#laki_laki').attr('selected', 'selected');
			// 	$('#perempuan').removeAttr('selected', 'selected');
			// }else{
			// 	$('#laki_laki').removeAttr('selected', 'selected');
			// 	$('#perempuan').attr('selected', 'selected');
			// }
			// $('#telp').val(''+suggestion.telp);
			// $('#hp').val(''+suggestion.hp);
			// $('#id_poli').val(''+suggestion.id_poli);
			// $('#poliasal').val(''+suggestion.poliasal);
			// $('#id_dokter').val(''+suggestion.id_dokter);
			// $('#dokter').val(''+suggestion.dokter);
			// $('#diagnosa').val(''+suggestion.diagnosa);
		}
	});
});

</script>

<div >
	<div >
        <!-- Main content -->
       <section class="content">
			
			<div class="row">
				<div class="col-sm-12">
				<?php echo $this->session->flashdata('pesan');?>
					<div class="panel panel-default">
						<div class="panel-heading" align="center">
							<ul class="nav nav-pills nav-justified">
							  <li role="presentation" class="active"><a data-toggle="tab" href="#tabtindakan">Diagnosa</a></li>
							  <!-- <li role="presentation" class=""><a data-toggle="tab" href="#tabdiagnosa">Diagnosa</a></li> -->							  
							</ul>
						</div>
						
						<div class="tab-content">
						  <div id="tabtindakan" class="tab-pane fade in active">	    								<div class="panel-body">						
							<!-- form -->
							<div class="well" >
							<form class="form-horizontal" action="<?php echo site_url('iri/rictindakan/tambah_diagnosa_proses'); ?>" method="post">
								<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="tindakan">Diagnosa</p>
										<div class="col-sm-8">
											<input type="text" value="" class="form-control input-sm auto_diagnosa_pasien_2" name="diagnosa2_name" id="diagnosa2_name" />
											<input type="hidden" value="" id="id_row_diagnosa2" name="id_row_diagnosa2" />
											<input type="hidden" value="" id="nm_diagnosa" name="nm_diagnosa" />
										</div>
								</div>
								<div class="form-inline" align="right">
								<input type="hidden"  name="no_ipd_h" id="no_ipd_h" value="<?php echo $data_pasien[0]['no_ipd'];?>" />
									<div class="form-group">
										<button type="submit" class="btn btn-primary">Tambah</button>
									</div>
								</div>
							</form>
							</div>

							<!-- table -->
								<br>
							<div style="display:block;overflow:auto;">
							<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
							  <thead>
								<tr>
								  <th>Kode Diagnosa</th>
								  <th>Diagnosa</th>
								  <th>Jenis Diagnosa</th>
								  <th>Aksi</th>
								</tr>
							  </thead>
							  <tbody>
							  	<?php
							  	if(!empty($diagnosa_masuk)){ ?>
							  	<tr>
									<td><?php echo $diagnosa_masuk[0]['id_icd'] ; ?></td>
									<td><?php echo $diagnosa_masuk[0]['nm_diagnosa'] ; ?></td>
									<td>Diagnosa Masuk</td>
									<td>
										-
									</td>
								</tr>
							  	<?php
							  	}
							  	?>
							  	<?php
							  	if(!empty($diagnosa1)){ ?>
							  	<tr>
									<td><?php echo $diagnosa1[0]['id_icd'] ; ?></td>
									<td><?php echo $diagnosa1[0]['nm_diagnosa'] ; ?></td>
									<td>Utama</td>
									<td>
										-
									</td>
								</tr>
							  	<?php
							  	}
							  	?>
								<?php
									foreach($diagnosa_pasien as $r){
								?>
									<tr>
										<td><?php echo $r['id_diagnosa'] ; ?></td>
										<td><?php echo $r['diagnosa'] ; ?></td>
										<td>Tambahan</td>
										<td>
											<a href="<?php echo base_url(); ?>iri/rictindakan/hapus_diagnosa/<?php echo $r['id_diagnosa_pasien'] ;?>/<?php echo $data_pasien[0]['no_ipd'];?>" class="btn btn-primary btn-xs">Hapus</a>
										</td>
									</tr>
								<?php
									}
								?>
							  </tbody>
							</table>
							</div><!-- style overflow -->
							<form class="form-horizontal" action="<?php echo site_url('iri/rictindakan/tambah_tindakan_real'); ?>" method="post">
							<br>
							<div class="form-inline" align="right">
								<input type="hidden"  name="no_ipd_h" id="no_ipd_h" value="<?php echo $data_pasien[0]['no_ipd'];?>" />
									<div class="form-group">
										<a href="<?php echo base_url(); ?>iri/rictindakan/pulang/<?php echo $data_pasien[0]['no_ipd'];?>"> <button type="button" class="btn btn-primary">Kembali</button>
									</div>
							</div>
						</div>
						  </div>
						<!-- <div id="tabdiagnosa" class="tab-pane fade">
						    	<?php
									//include('form_diagnosa.php');
								?>				 
						</div> -->

						
					</div>
				</div>
			</div>
		</section>
		<!-- /Main content -->
		
	</div>
</div>
<script>
	// $(function () {
	// 	$("#example1").DataTable();
	// });
	// $('#calendar-tgl').datepicker();
</script>
<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
	});
</script>
<?php $this->load->view("layout/footer"); ?>
