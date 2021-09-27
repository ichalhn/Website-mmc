<?php
  $this->load->view('layout/header.php');
?>
<html>
<script type='text/javascript'>
var tbl;
$(function() {  	
	tbl = $('#example').DataTable({
		ajax: "<?php echo site_url(); ?>master/Jabatan/list_data",
		columns: [
			{ data: "id_jabatan" },
			{ data: "nm_jabatan" },
			{ data: "aksi" }
		],
		destroy: true
	});	
	
	$('#addForm').on('submit', function (e) {
		e.preventDefault();
		var id = $(".id_jabatan").val();
		$.ajax({
		  dataType: "json",
		  type: 'POST',
		  data: {id:id},
		  url: "<?php echo site_url(); ?>master/Jabatan/is_exist",
		  success: function( response ) {
			if(response.exist > 0){
				alert("Kode "+id+" sudah terdata atas nama jabatan "+response.nama+"");
				$( ".id_jabatan" ).val('');
				$( ".id_jabatan" ).focus();
			}else{
				$.ajax({
					dataType: "json",
					type: 'post',
					data: $('#addForm').serialize(),
					url: '<?php echo site_url(); ?>master/Jabatan/save',
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
		$('#vid_jabatan').val(id);
		$('#vnm_jabatan').val(nm);
		$('#editForm').on('submit', function (e) {
			e.preventDefault();
			$.ajax({
			  dataType: "json",
			  type: 'POST',
			  data: $('#editForm').serialize(),
			  url: "<?php echo site_url(); ?>master/Jabatan/edit",
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
function deletejabatan(id){
	$.ajax({
		dataType: "json",
		type: 'post',
		data: {id:id},
		url: '<?php echo site_url(); ?>master/Jabatan/delete',
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
								<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> Tambah Jabatan</i> </button>
								</span>
							</div><!-- /input-group --> 
							<br/> 
							<br/> 
						</div>
					</div>
				  <table id="example" class="display" cellspacing="0" width="100%">
					<thead>
					  <tr>
						<th>Kode Jabatan</th>
						<th>Nama Jabatan</th>
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
				<h4 class="modal-title">Entry Data Jabatan</h4>
			</div>
			<div class="modal-body">				
			<form class="form-horizontal" id="addForm">
				<div class="form-group row">
					<label class="control-label col-sm-4">Kode Jabatan</label>
					<div class="col-sm-8">
						<input type="text" class="form-control id_jabatan" id="id_jabatan" name="id_jabatan" required />
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-4">Nama Jabatan</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="nm_jabatan" name="nm_jabatan" required />
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
				<h4 class="modal-title">Edit Data Jabatan</h4>
			</div>
			<div class="modal-body">				
			<form class="form-horizontal" id="editForm">
				<div class="form-group row">
					<label class="control-label col-sm-4">Kode Jabatan</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="vid_jabatan" name="vid_jabatan" readonly />
					</div>
				</div>
				<div class="form-group row">
					<label class="control-label col-sm-4">Nama Jabatan</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="vnm_jabatan" name="vnm_jabatan" required />
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