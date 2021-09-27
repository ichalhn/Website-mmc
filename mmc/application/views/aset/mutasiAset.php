<?php
	$this->load->view('layout/header.php');
?>
<script type='text/javascript'>
var tblAsset;
var vsearch, nip, id_unit;
vsearch = "cari_nama";
nip = "";
id_unit = "";
$(function() {
	tblAsset = $('#tblAsset').DataTable( {
		order: [[ 1, "desc" ]],
		columnDefs: [
			{ targets: [ 0 ], visible: false }
		]
    } );
	$('#cari_nama').focus();
	
	$('#cari_nama').autocomplete({
		serviceUrl: '<?php echo site_url();?>kepegawaian/Data_pegawai/by_nama',
		onSelect: function (suggestion) {
			//$('#vnip').val(''+suggestion.nip).trigger('change');
			$('#vnip').val(''+suggestion.nip);
		}
	});
	
	$('#cari_unit').autocomplete({
		serviceUrl: '<?php echo site_url();?>Aset/data_bagian_auto',
		onSelect: function (suggestion) {
			$('#id_unit').val(''+suggestion.id_bagian);
		}
	});
	
	$( "#search_per" ).change(function() {
		vsearch = $( "#search_per" ).val();
		//alert(vsearch);
		if(vsearch=='cari_nama'){
			$("#cari_nama").css("display", "");
			$("#cari_nip").val('');
			$("#cari_unit").val('');
			$("#id_unit").val('');
			$("#cari_nip").css("display", "none");
			$("#cari_unit").css("display", "none");
			$('#cari_nama').focus();
		}else if(vsearch=='cari_nip'){
			$("#cari_nama").val('');
			$("#vnip").val('');
			$("#cari_unit").val('');
			$("#id_unit").val('');
			$("#cari_nama").css("display", "none");
			$("#cari_nip").css("display", "");
			$("#cari_unit").css("display", "none");
			$('#cari_nip').focus();
		}else{	
			$("#cari_nama").val('');
			$("#vnip").val('');
			$("#cari_nip").val('');
			$("#cari_nama").css("display", "none");
			$("#cari_nip").css("display", "none");
			$("#cari_unit").css("display", "");
			$('#cari_unit').focus();
		}
	});
	
	$('#mutasiModal').on('shown.bs.modal', function(e) {
		//get data-id attribute of the clicked element
		var id = $(e.relatedTarget).data('id');

		//populate the textbox		
		$.ajax({
		  dataType: "json",
		  type: 'POST',
		  data: {id:id},
		  url: "<?php echo site_url(); ?>Aset/detailAssetMutasi",
		  success: function( response ) {
			//alert(JSON.stringify(response.description));
			$('#asset_id').val(response.id);
			$('#vasset_number').val(response.asset_number);
			$('#vdescription').val(response.description);
			$('#vmerk').val(response.merk);
			$('#vserial_number').val(response.serial_number);
			$('#vtgl_perolehan').val(response.tgl_perolehan);
			$('#vjenis').val(response.kd_brg);
			$('#vjenistxt').val(response.ur_sskel);
			$('#kondisi_lama').val(response.kondisi);
			$('#vkondisi_lama').val(response.kondisi);
			$('#pengguna_lama').val(response.pengguna_nama);
			$('#nip_lama').val(response.pengguna_id);
			$('#unit_lama').val(response.unit);
			$('#id_unit_lama').val(response.unit_id);
			$('#lokasi_lama').val(response.lokasi);
			$('#pengguna_baru').val(response.pengguna_baru);
			$('#unit_baru').val(response.unit_baru);
			$('#lokasi_baru').val(response.lokasi_baru);
			$('#kondisi_baru').val(response.kondisi_baru);
			$('#no_bast').val(response.no_bast);
			$('#tgl_mutasi').val(response.tgl_mutasi);
		  }
		});		
		$('#no_bast').focus();
	});
})		

function searchAsset(){
	if(vsearch=='cari_nama'){
		if ($("#vnip").val() =='')
			alert('Lengkapi kriteria pencarian!');
		else
			getDetail(vsearch,$("#vnip").val());
	}else if(vsearch=='cari_nip'){	
		if ($("#cari_nip").val() =='')
			alert('Lengkapi kriteria pencarian!');
		else
			getDetail(vsearch,$("#cari_nip").val());
	}else if(vsearch=='cari_unit'){	
		if ($("#id_unit").val() =='')
			alert('Lengkapi kriteria pencarian!');
		else
			getDetail(vsearch,$("#id_unit").val());
	}
}
function getDetail(vsearch,id) {
	tblAsset = $('#tblAsset').DataTable({
		ajax: "<?php echo site_url(); ?>Aset/mutasi_history/"+vsearch+"/"+id,
		columns: [
			{ data: "id" },
			{ data: "tgl_mutasi" },
			{ data: "asset_number" },
			{ data: "description" },
			{ data: "jenis" },
			{ data: "pengguna_baru" },
			{ data: "unit" },
			{ data: "aksi" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false }
		],
		destroy: true,
		order: [[ 1, "desc" ]]
	});	
};
</script>
<section class="content-header">		
	<div class="small-box" style="background: #e4efe0">
		<div class="inner">
			<div class="container-fluid text-center"><br/>
				<div class="form-inline">
					<select name="search_per" id="search_per" class="form-control">
						<option value="cari_nama">Nama</option>
						<option value="cari_nip">NIP</option>
						<option value="cari_unit">Unit</option>
					</select>					
					<input type="search" class="form-control" id="cari_nama" name="cari_nama" placeholder="Ketikkan Nama">
					<input type="hidden" class="form-control" id="vnip" name="vnip">
					<input type="search" style="width:450; display:none" class="form-control" id="cari_nip" name="cari_nip" placeholder="Ketikkan NIP">		
					<input type="search" style="width:450; display:none" class="form-control" id="cari_unit" name="cari_unit" placeholder="Ketikkan Unit">			
					<input type="hidden" class="form-control" id="id_unit" name="id_unit">		
					<button type="submit" class="btn btn-primary" type="button" onClick="searchAsset()">Cari</button>					
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
						<table id="tblAsset" class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th></th>
									<th>Tgl.Mutasi</th>
									<th>Nomor Aset</th>
									<th>Deskripsi</th>
									<th>Jenis</th>
									<th>Pengguna Baru</th>
									<th>Unit Baru</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th></th>
									<th>Tgl.Mutasi</th>
									<th>Nomor Aset</th>
									<th>Deskripsi</th>
									<th>Jenis</th>
									<th>Pengguna Baru</th>
									<th>Unit Baru</th>
									<th>Aksi</th>
								</tr>
							</tfoot>
							<tbody>
								<?php
								if ($data_aset!="") {
									foreach($data_aset as $row){
									?>
									<tr>
										<td><?php echo $row->id;?></td>
										<td><?php echo $row->tgl_mutasi;?></td>
										<td><?php echo $row->asset_number;?></td>
										<td><?php echo $row->description;?></td>
										<td><?php echo $row->jenis;?></td>
										<td><?php echo $row->pengguna_baru;?></td>
										<td><?php echo $row->unit_baru;?></td>
										<td>
											<center>
											<button type="button" id="mutasiBtn" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#mutasiModal" data-id="<?php echo $row->id;?>" title="Detail"><i class="fa fa-binoculars"></i></button>
											</center>
										</td>
									</tr>
									<?php } 
									}
									?>
							</tbody>
						</table>
					</div><!-- end panel body -->
				</div><!-- end panel info-->
				 <div class="modal fade" id="mutasiModal" role="dialog" data-backdrop="static" data-keyboard="false">
						<div class="modal-dialog modal-default">
						  <!-- Modal content-->
						  <div class="modal-content">
							<div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal">&times;</button>
							  <h4 class="modal-title">Mutasi Aset</h4>
							</div>
							<div class="modal-body">
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Nomor Aset</p>
								<div class="col-sm-6">
								  <input type="hidden" class="form-control" name="asset_id" id="asset_id">
								  <input type="text" class="form-control" name="vasset_number" id="vasset_number" readonly="readonly" >
								</div>
							  </div>
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Deskripsi</p>
								<div class="col-sm-6">
								  <input type="text" class="form-control" name="vdescription" id="vdescription" disabled="disabled">
								</div>
							  </div>
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Jenis</p>
								<div class="col-sm-6">
								  <input type="text" class="form-control" name="vjenistxt" id="vjenistxt" disabled="disabled">
								  <input type="hidden" id="vjenis" name="vjenis">
								</div>
							  </div>
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Merk</p>
								<div class="col-sm-6">
								  <input type="text" class="form-control" name="vmerk" id="vmerk" readonly="readonly">
								</div>
							  </div>
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Serial Number</p>
								<div class="col-sm-6">
								  <input type="text" class="form-control" name="vserial_number" id="vserial_number" readonly="readonly">
								</div>
							  </div>
							  <div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label">Tgl Perolehan</p>
								<div class="col-sm-6">
								  <input type="text" class="form-control" name="vtgl_perolehan" id="vtgl_perolehan" readonly="readonly">
								</div>
							  </div>	
							  <hr/>
							  <div class="form-group row">
								<div class="col-sm-2 form-control-label">No. BAST</div>
								<div class="col-sm-4">
								  <input type="text" class="form-control" name="no_bast" id="no_bast" readonly="readonly">
								</div>
								<div class="col-sm-2 form-control-label">Tgl Mutasi</div>
								<div class="col-sm-4">
								  <input type="text" class="form-control datepicker" name="tgl_mutasi" id="tgl_mutasi" readonly="readonly">
								</div>
							  </div>	
							  <div class="form-group row">
								<div class="col-sm-2 form-control-label">Kondisi</div>
								<div class="col-sm-4">
								  <select  class="form-control" style="width: 100%" name="vkondisi_lama" id="vkondisi_lama" disabled="disabled">
									<option value="">-Pilih Kondisi-</option>
									<option value="BAIK">BAIK</option>
									<option value="RUSAK">RUSAK</option>
									<option value="HILANG">HILANG</option>
								  </select>
								  <input type="hidden" id="kondisi_lama" name="kondisi_lama" value="">
								</div>
								<div class="col-sm-2 form-control-label">Kondisi Baru</div>
								<div class="col-sm-4">
								  <select  class="form-control" style="width: 100%" name="kondisi_baru" id="kondisi_baru" disabled="disabled">
									<option value="">-Pilih Kondisi-</option>
									<option value="BAIK">BAIK</option>
									<option value="RUSAK">RUSAK</option>
									<option value="HILANG">HILANG</option>
								  </select>
								</div>
							  </div>	
							  <div class="form-group row">
								<div class="col-sm-2 form-control-label">Pemegang Lama</div>
								<div class="col-sm-4">
								  <input type="text" class="form-control" name="pengguna_lama" id="pengguna_lama" readonly="readonly">
								  <input type="hidden" name="nip_lama" id="nip_lama">
								</div>
								<div class="col-sm-2 form-control-label">Pemegang Baru</div>
								<div class="col-sm-4">
								  <input type="text" class="form-control" name="pengguna_baru" id="pengguna_baru" readonly="readonly">
								  <input type="hidden" name="nip_baru" id="nip_baru">
								</div>
							  </div>	
							  <div class="form-group row">
								<div class="col-sm-2 form-control-label">Unit Lama</div>
								<div class="col-sm-4">
								  <input type="text" class="form-control" name="unit_lama" id="unit_lama" readonly = "readonly">
								  <input type="hidden" name="id_unit_lama" id="id_unit_lama">
								</div>
								<div class="col-sm-2 form-control-label">Unit Baru</div>
								<div class="col-sm-4">
								  <input type="text" class="form-control" name="unit_baru" id="unit_baru" readonly="readonly">
								  <input type="hidden" name="id_unit_baru" id="id_unit_baru">
								</div>
							  </div>		
							  <div class="form-group row">
								<div class="col-sm-2 form-control-label">Lokasi Lama</div>
								<div class="col-sm-4">
								  <input type="text" class="form-control" name="lokasi_lama" id="lokasi_lama" readonly = "readonly">
								</div>
								<div class="col-sm-2 form-control-label">Lokasi Baru</div>
								<div class="col-sm-4">
								  <input type="text" class="form-control" name="lokasi_baru" id="lokasi_baru" readonly="readonly">
								</div>
							  </div>					  
							</div>
						  </div>
						</div>
					  </div>
		</div><!-- end tab content -->
			
	</div><!--- end row --->
</section>
	
<?php
	$this->load->view('layout/footer.php');
?>