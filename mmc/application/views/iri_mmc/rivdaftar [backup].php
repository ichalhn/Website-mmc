<script>
var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto-ruang').autocomplete({
		serviceUrl: site+'/iri/ricreservasi/data_ruang',
		onSelect: function (suggestion) {
			$('#kode-ruang-pilih').val(''+suggestion.idrg);
			$('#nama-ruang-pilih').val(''+suggestion.nmruang);
		}
	});
});
</script>
<div class="wrapper">
	<div class="content-wrapper">
		
		<!-- Keterangan page -->
		<section class="content-header">
			<h1>DAFTAR ANTRIAN RESERVASI</h1>			
		</section>
		<!-- /Keterangan page -->

        <!-- Main content -->
        <section class="content">
			<div class="row">
				<div class="col-sm-12">
					<?php echo $this->session->flashdata('pesan');?>
					
					<!-- Table -->
					<div class="box box-success">
						<div class="row">
							<form class="form-horizontal" action="<?php echo site_url('iri/ricdaftar'); ?>" method="POST">
								<div class="col-sm-3"></div>
								<div class="col-sm-6">
									<div class="box-body">
										<div class="form-group">
											<div class="col-sm-3 control-label">Ruangan</div>
											<div class="col-sm-9" align="left">
												<span class="label-form-validation"></span>
												<div class="col-sm-3 input-left"><input type="text" class="form-control input-sm auto-ruang" id="kode-ruang-pilih" name="kode_ruang"></div>
												<div class="col-sm-9 input-right"><input type="text" class="form-control input-sm" id="nama-ruang-pilih" name="name_ruang" readonly></div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-3 control-label">Kelas</div>
											<div class="col-sm-2">
												<select class="form-control input-sm" name="kelas">
													<option value="-">-</option>
													<option value="I">I</option>
													<option value="II">II</option>
													<option value="III">III</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-3"></div>
											<div class="col-sm-9">
												<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Lihat</button>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
						
						<br/>
						<div class="box-body">
							<table id="dataTables-example" class="table table-bordered table-striped data-table">
								<thead>
									<tr>
										<th>No. Antri</th>
										<th>No. CM</th>
										<th>Reg. Asal</th>
										<th>Nama</th>
										<th>Ruang</th>
										<th>Kelas</th>
										<th>Infeksi</th>
										<th>HP</th>
										<th>Prioritas</th>
										<th>Ren. Masuk</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
					<!-- /Table -->
					
				</div>
			</div>
		</section>
		<!-- /Main content -->
		
		<!-- Modal -->
		<div class="modal fade bs-example-modal-sm" id="modal-approve" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
					</div>
					<div class="modal-body">
						Apakah kamu yakin ingin mengapprove ini?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-remove"></i> Tidak</button>
						<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Ya</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /Modal -->
		
	</div>
</div>
<script>
$(document).ready(function() {
	//console.log('masuk');
	var dataTable = $('#dataTables-example').DataTable( {
		"processing": true,
		"serverSide": true,
		"bPaginate": true,
		"bLengthChange": true,
		"bFilter": true,
		"bSort": true,
		"bInfo": true,
		"bAutoWidth": true,
		"ajax":{
			url :"<?php echo site_url('iri/ricdaftar/get_irna_antrian/'.$kode_ruang.'/'.$kelas.'/'); ?>", // json datasource
			type: "post",
			error: function(){  // error handling
				$(".employee-grid-error").html("");
				$("#dataTables-example").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
				$("#employee-grid_processing").css("display","none");
			}
		}
	});
	$('<button type="button" id="filter" class="btn btn-primary btn-sm"><i class="fa fa-search"></i></button>').appendTo('div.dataTables_filter');
	$("div.dataTables_filter input").unbind();
	$('#filter').click(function(e){
		var value = $('.dataTables_filter input').val();
        dataTable.columns(0).search(value).draw();
    });
});
</script>
