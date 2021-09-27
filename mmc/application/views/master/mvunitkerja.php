<?php
  $this->load->view('layout/header.php');
?>
<html>
<script type='text/javascript'>
var tbl;
$(function() {  
	
	tbl = $('#example').DataTable({
		ajax: "<?php echo site_url(); ?>master/Unit_kerja/list_data",
		columns: [
			{ data: "id_bagian" },
			{ data: "nm_bagian" },
			{ data: "aksi" }
		],
		destroy: true
	});	
	
	$('#addForm').on('submit', function (e) {
		e.preventDefault();
		var id = $(".id_bagian").val();
		$.ajax({
		  dataType: "json",
		  type: 'POST',
		  data: {id:id},
		  url: "<?php echo site_url(); ?>master/Unit_kerja/is_exist",
		  success: function( response ) {
			if(response.exist > 0){
				alert("Kode "+id+" sudah terdata atas nama bagian "+response.nama+"");
				$( ".id_bagian" ).val('');
				$( ".id_bagian" ).focus();
			}else{
				$.ajax({
					dataType: "json",
					type: 'post',
					url: '<?php echo site_url(); ?>master/Unit_kerja/save',
					data: $('#addForm').serialize(),
					success: function (response) {
						if(response.success){
							$('#myModal').modal('hide');
							$( "#alertMsg" ).append(response.message);	
							tbl.ajax.reload();
						}
					}
				});
			}
		  }
		});
	});
	$('#editModal').on('shown.bs.modal', function(e) {
		//get data-id attribute of the clicked element
		var id = $(e.relatedTarget).data('id');
		var nm = $(e.relatedTarget).data('nm');
		$('#vid_bagian').val(id);
		$('#vnm_bagian').val(nm);
		$('#editForm').on('submit', function (e) {
			e.preventDefault();
			$.ajax({
			  dataType: "json",
			  type: 'POST',
			  data: $('#editForm').serialize(),
			  url: "<?php echo site_url(); ?>master/Unit_kerja/edit",
			  success: function( response ) {
				if(response.success){
					$('#editModal').modal('hide');
					$( "#alertMsg" ).append(response.message);	
					tbl.ajax.reload();
				}
			  }
			});
		});		
	});
})
function deleteBagian(id){
	$.ajax({
		dataType: "json",
		type: 'post',
		data: {id:id},
		url: '<?php echo site_url(); ?>master/Unit_kerja/delete',
		success: function (response) {
			if(response.success){
				$( "#alertMsg" ).append(response.message);	
				tbl.ajax.reload();
			}
		}
	});
}
</script>
<section class="content" style="width:97%;margin:0 auto">
  <div class="row">
		<div class="tab-content">			
			<div class="panel panel-default">
				<div class="panel-body">	
					<div class="row">
						<div class="col-xs-9" id="alertMsg">	
							<?php echo $this->session->flashdata('alert_msg'); ?>
						</div>
						<div class="col-xs-3" align="right">
							<div class="input-group">
								<span class="input-group-btn">
								<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> Tambah Unit</i> </button>
								</span>
							</div><!-- /input-group --> 
							<br/> 
							<br/> 
						</div>
					</div>
				  <table id="example" class="display" cellspacing="0" width="100%">
					<thead>
					  <tr>
						<th>Kode Bagian</th>
						<th>Nama Bagian</th>
						<th>Aksi</th>
					  </tr>
					</thead>
				  </table>
          
				</div>
			</div>
		</div>
    </div>
</section>
<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-success">
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Entry Data Unit Kerja</h4>
			</div>
			<div class="modal-body">				
			<form class="form-horizontal" id="addForm">
				<div class="form-group row">
					<label class="control-label col-sm-4">Kode Bagian</label>
					<div class="col-sm-8">
						<input type="text" class="form-control id_bagian" id="id_bagian" name="id_bagian" required />
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-4">Nama Bagian</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="nm_bagian" name="nm_bagian" required />
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-4"></div>
					<div class="col-sm-8">
						<button class="btn btn-primary" type="submit">Simpan</button>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
 </div>
<div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-success">
	  <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Data Unit Kerja</h4>
			</div>
			<div class="modal-body">				
			<form class="form-horizontal" id="editForm">
				<div class="form-group row">
					<label class="control-label col-sm-4">Kode Bagian</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="vid_bagian" name="vid_bagian" readonly />
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-4">Nama Bagian</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="vnm_bagian" name="vnm_bagian" required />
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-4"></div>
					<div class="col-sm-8">
						<button class="btn btn-primary" type="submit">Simpan</button>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
 </div>
<?php
  $this->load->view('layout/footer.php');
?>