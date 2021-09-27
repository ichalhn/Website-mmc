<?php
	$this->load->view('layout/header.php');
?>
<script type="text/javascript">
  $(document).ready(function() {

  });	
</script>
	<!-- Content Header (Page header) -->	
	<section class="content">
		<div class="row">
			<div class="col-md-12">
<div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Form Input User</h3>
            </div>
            <div class="box-body">
						<br>
							<form id="idform" method="POST" enctype="multipart/form-data">	
								<div class="form-group row">
									<p class="col-lg-3 form-control-label">Username *</p>
									<div class="col-lg-6">
										<input type="text" class="form-control" placeholder=""  id="username" name="username" required>
										<input type="hidden" name="userid" id="userid" value=''>
									</div>
								</div>		
								<div class="form-group row">
									<p class="col-lg-3 form-control-label">Full Name *</p>
									<div class="col-lg-6">
										<input type="text" class="form-control" placeholder=""  id="name" name="name" required>
									</div>
								</div>								
								<div class="form-group row">
									<p class="col-lg-3 form-control-label">Password *</p>
									<div class="col-lg-6">
										<input type="password" class="form-control" placeholder="" name="password" id="password" required>
									</div>
								</div>		
								<div class="form-group row">
									<p class="col-lg-3 form-control-label">Retype Password *</p>
									<div class="col-lg-6">
										<input type="password" class="form-control" placeholder="" id="repassword" required>
									</div>
								</div>		
								<div class="form-group row">
									<p class="col-lg-3 form-control-label">Photo</p>
									<div class="col-lg-6">						
								<div class="input-group">
								  <span class="input-group-btn">
								    <span class="btn btn-info btn-flat" id="browseBtn">Browse</span>
								    <input name="userfile" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file" accept="image/jpeg, image/png, image/gif">
								  </span>
								  <span class="form-control"></span>
								</div>	<!-- input group -->	
<!-- 										<div class="input-group">
											<input type="file" name="userfile" style="display: none;" accept="image/jpeg, image/png, image/gif"/>
											<input type="text" name="foto" id="foto" class="form-control filefield browse" readonly="" value="" />
											<span class="input-group-btn">
												<button class="btn btn-info btn-flat" type="button" id="browseBtn">Browse</button>
											</span>
										</div>	 -->															
									</div>
								</div>		
								<div class="form-group row">
									<div class="col-lg-3">
									</div>
									<div class="col-lg-6">
										<div class="form-inline">
											<button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i> Reset</button>
											<button type="button" class="btn btn-primary" id="btn_save"><i class="fa fa-floppy-o"></i> Simpan</button>
											<!--<a href="#" class="btn btn-primary">Cetak Kartu</a>-->
										</div>
									</div>	
								</div>
							<?php echo form_close();?>
					</div>
					<!--- end panel body-->
				</div>
				<!--- end panel -->
			</div>
		<!--- end col -->
			<div class="col-md-12">
<div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar User</h3>
            </div>
            <div class="box-body">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="example">
								<thead>
									<tr>
										<th></th>
										<th>Username</th>
										<th>Name</th>
										<th class="text-center">Roles</th>
										<th class="text-center">Gudang</th>
										<th class="text-center">Poli</th>
										<th class="text-center">Ruangan</th>
										<th class="text-center">Aksi</th>
									</tr>
								</thead>
							</table>
						</div>
						<!-- /.table-responsive -->
					</div>
					<!-- end panel body-->
				</div>
				<div id="dialog-confirm"></div>
				<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="modalTitle"></h4>
							</div>
							<div class="modal-body">							
								<div class="table-responsive">
								<form id="detailForm" >
									<table class="table table-striped table-bordered table-hover" id="detailTable">
										<thead>
											<tr>
												<th></th>
												<th></th>
												<th>Role</th>
											</tr>
										</thead>
									</table>
								</form>
								</div>
								<!-- /.table-responsive -->
							</div>
							<div class="modal-footer">
								<button type="button" onclick="saveSetting()" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
				<!-- modal -->
				<div class="modal fade" id="myModalGdg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="modalTitleGdg"></h4>
							</div>
							<div class="modal-body">							
								<div class="table-responsive">
								<form id="detailFormGdg" >
									<table class="table table-striped table-bordered table-hover" id="detailTableGdg">
										<thead>
											<tr>
												<th></th>
												<th></th>
												<th>Gudang</th>
											</tr>
										</thead>
									</table>
								</form>
								</div>
								<!-- /.table-responsive -->
							</div>
							<div class="modal-footer">
								<button type="button" onclick="saveSettingGdg()" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					<!-- /.modal-dialog -->
				</div>
				<!-- /.modal -->
				<div class="modal fade" id="myModalPoli" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="modalTitlePoli"></h4>
							</div>
							<div class="modal-body">							
								<div class="table-responsive">
								<form id="detailFormPoli" >
									<table class="table table-striped table-bordered table-hover" id="detailTablePoli">
										<thead>
											<tr>
												<th></th>
												<th></th>
												<th>Poliklinik</th>
											</tr>
										</thead>
									</table>
								</form>
								</div>
								<!-- /.table-responsive -->
							</div>
							<div class="modal-footer">
								<button type="button" onclick="saveSettingPoli()" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
					</div>
					<!-- /.modal-dialog -->
					<div class="modal fade" id="myModalRuang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title" id="modalTitleRuang"></h4>
							</div>
							<div class="modal-body">							
								<div class="table-responsive">
								<form id="detailFormRuang" >
									<table class="table table-striped table-bordered table-hover" id="detailTableRuang">
										<thead>
											<tr>
												<th></th>
												<th></th>
												<th>Ruangan</th>
											</tr>
										</thead>
									</table>
								</form>
								</div>
								<!-- /.table-responsive -->
							</div>
							<div class="modal-footer">
								<button type="button" onclick="saveSettingRuang()" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
							</div>
						</div>
						<!-- /.modal-content -->
					</div>
				</div>
				<!--- end panel -->
			</div>
		<!--- end col -->
		</div><!--- end row -->
	</section>
	
  <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-success">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title"><b>Reset Password</b></h4>
		</div>
		<div class="modal-body">
		<div class="row">
			<div class="col-md-12">			
				<form id="editForm" class="form-horizontal">
				<div class="row">
					<div class="col-md-12">	
						<div class="form-group">
							<label class="control-label col-sm-4">Username</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="vusername" id="vusername" readonly>
								<input type="hidden" name="vuserid" id="vuserid">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">	
						<div class="form-group">
							<label class="control-label col-sm-4">Password</label>
							<div class="col-sm-8">
								<input type="password" class="form-control" name="vpassword" id="vpassword" required>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">	
						<div class="form-group">
							<label class="control-label col-sm-4">Retype Password</label>
							<div class="col-sm-8">
								<input type="password" class="form-control" name="vrepassword" id="vrepassword" required>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">	
						<div class="form-group">
							<label class="control-label col-sm-4"></label>
							<div class="col-sm-4">
								<button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
								<button class="btn btn-outline" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
							</div>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
		</div>
	 </div>
	</div>
  </div>
<?php
	$this->load->view('layout/footer.php');
?>


<script type='text/javascript'>
$(function() {
	objTable = $('#example').DataTable( {
			ajax: "<?php echo site_url('admin/userList'); ?>",
			columns: [
				{ data: "id" },
				{ data: "username" },
				{ data: "name" },
				{ data: "role" },
				{ data: "plus" },
				{ data: "poli" },
				{ data: "ruang" },
				{ data: "aksi" }
			],
			columnDefs: [
				{ targets: [ 0 ], visible: false }
			]	
		} );	
	
	$(":reset").click(function(){		
		$("#username").prop('disabled', false);
	});	
	$('#username').keypress(function( e ) {
    if(e.which === 32) 
        return false;
	});
	$( "#username" ).change(function() {
		var vnip = $("#username").val();
		$.ajax({
		  dataType: "json",
		  type: 'POST',
		  data: {id:vnip},
		  url: '<?php echo site_url('admin/userExist'); ?>',
		  success: function( response ) {
			if (response.exist){
				alert("Username "+vnip+" sudah terdaftar!");
				$("#username").val('');
				$('#username').focus();
			}
		  }
		})
	});
	$( "#password" ).change(function() {
		if ( ($('#password').val()!= '') && ($('#repassword').val() != '' )){
			if ( $('#password').val() != $('#repassword').val() ){
			alert('Please retype, password is missmatch!');
				$('#password').val('');
				$('#repassword').val('');
				$('#password').focus();
			}
		}
	});
	$( "#repassword" ).change(function() {
		if ( ($('#password').val()!= '') && ($('#repassword').val() != '' )){
			if ( $('#password').val() != $('#repassword').val() ){
				alert('Please retype, password is missmatch!');
				$('#password').val('');
				$('#repassword').val('');
				$('#password').focus();
			}
		}
	});
	$('#btn_save').on('click', function (e) {
		document.getElementById("btn_save").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
		var formData = new FormData($('#idform')[0]);
		$.ajax({
			dataType: "JSON",
			type: 'POST',
			// async: true,
			cache: false,
			contentType: false,
			processData: false,
			url: baseurl+'Admin/user_insert',
			data: formData,
			success: function (response) {
				if(response.success){ 
					document.getElementById("btn_save").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
					objTable.ajax.reload();
					$("#idform")[0].reset();
					swal("Sukses","Input User Berhasil.", "success");
				} else {
				document.getElementById("btn_save").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				swal("Error","Input User Gagal.", "error");
				}
			}
		});	
	});
	
	//=========== When (modal) POP-UP closed, remove class from TR Grid =================
	$('#myModal').on('hidden.bs.modal', function (e) {
		$("tr").removeClass('detailselected');
	});
	
		
	$('#editModal').on('shown.bs.modal', function(e) {
		e.preventDefault();
		$("#editForm")[0].reset();		
		var id = $(e.relatedTarget).data('id');
		var nm = $(e.relatedTarget).data('username');
		$('#vuserid').val(id);
		$('#vusername').val(nm);
		$( "#vpassword" ).focus();
		$( "#vpassword" ).change(function() {
			if ( ($('#vpassword').val()!= '') && ($('#vrepassword').val() != '' )){
				if ( $('#vpassword').val() != $('#vrepassword').val() ){
				alert('Please retype, password is missmatch!');
					$('#vpassword').val('');
					$('#vrepassword').val('');
					$('#vpassword').focus();
				}
			}
		});
		$( "#vrepassword" ).change(function() {
			if ( ($('#vpassword').val()!= '') && ($('#vrepassword').val() != '' )){
				if ( $('#vpassword').val() != $('#vrepassword').val() ){
					alert('Please retype, password is missmatch!');
					$('#vpassword').val('');
					$('#vrepassword').val('');
					$('#vpassword').focus();
				}
			}
		});
		
		
	});
	/**/
		$('#editForm').on('submit', function (e) {
			//alert("<?php echo site_url(); ?>");
			e.preventDefault();
			$.ajax({
				type: 'POST',
				data: $('#editForm').serialize(),
				url: '<?php echo site_url(); ?>/Admin/reset_password',
				dataType: "json",
				success: function (response) {
					//alert(JSON.stringify(response));
					if(response.success){						
						objTable.ajax.reload();
						$('#editModal').modal('hide');
						swal("Sukses","Reset Password Berhasil.", "success"); 												
					} else {
						swal("Error","Reset Password Gagal.", "error"); 	
					}
				}
			});
		});
});

var objTable2;
function setUserRole(vid,vname){
	if (objTable2!= null)
		objTable2.destroy();

	objTable2 = $('#detailTable').DataTable( {
		ajax: "<?php echo site_url('admin/userRoleList'); ?>/"+vid,
		columns: [
			{ data: "id" },
			{
				data:   "sts",
				render: function ( data, type, row ) {
					if ( type === 'display' ) {
						if (data==0){
							return "<input type='checkbox' name='checkApp' value='"+vid+"' onchange='chooseApp(this)'/>";
						}else{
							return "<input type='checkbox' name='checkApp' value='"+vid+"' onchange='chooseApp(this)' checked/>";
						}
					}
					return data;
				},
				className: "dt-body-center"
			},
			{ data: "role" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false },
			{ targets: [ 1 ], orderable: false },
			{ targets: [ 2 ], orderable: false }
		],
		paging: false,			
		searching: false,
		autoWidth: false
	} );	
	$('#modalTitle').html( "Set Role for User : <strong>"+vname+"</strong>");
}

var objTable3;
function setUserGudang(vid,vname){
	if (objTable3!= null)
		objTable3.destroy();

	objTable3 = $('#detailTableGdg').DataTable( {
		ajax: "<?php echo site_url('admin/userGdgList'); ?>/"+vid,
		columns: [
			{ data: "id" },
			{
				data:   "sts",
				render: function ( data, type, row ) {
					if ( type === 'display' ) {
						if (data==0){
							return "<input type='checkbox' name='checkGdg' value='"+vid+"' onchange='chooseApp(this)'/>";
						}else{
							return "<input type='checkbox' name='checkGdg' value='"+vid+"' onchange='chooseApp(this)' checked/>";
						}
					}
					return data;
				},
				className: "dt-body-center"
			},
			{ data: "nama" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false },
			{ targets: [ 1 ], orderable: false },
			{ targets: [ 2 ], orderable: false }
		],
		paging: false,			
		searching: false,
		autoWidth: false
	} );	
	$('#modalTitleGdg').html( "Gudang Access for User : <strong>"+vname+"</strong>");
}

var objTable4;
function setUserPoli(vid,vname){
	if (objTable4!= null)
		objTable4.destroy();

	objTable4 = $('#detailTablePoli').DataTable( {
		ajax: "<?php echo site_url('admin/userPoliList'); ?>/"+vid,
		columns: [
			{ data: "id" },
			{
				data:   "sts",
				render: function ( data, type, row ) {
					if ( type === 'display' ) {
						if (data==0){
							return "<input type='checkbox' name='checkPoli' value='"+vid+"' onchange='chooseApp(this)'/>";
						}else{
							return "<input type='checkbox' name='checkPoli' value='"+vid+"' onchange='chooseApp(this)' checked/>";
						}
					}
					return data;
				},
				className: "dt-body-center"
			},
			{ data: "nama" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false },
			{ targets: [ 1 ], orderable: false },
			{ targets: [ 2 ], orderable: false }
		],
		paging: false,			
		searching: false,
		autoWidth: false
	} );	
	$('#modalTitlePoli').html( "Poli Access for User : <strong>"+vname+"</strong>");
}

var objTable5;
function setUserRuang(vid,vname){
	if (objTable5!= null)
		objTable5.destroy();

	objTable5 = $('#detailTableRuang').DataTable( {
		ajax: "<?php echo site_url('admin/userRuangList'); ?>/"+vid,
		columns: [
			{ data: "id" },
			{
				data:   "sts",
				render: function ( data, type, row ) {
					if ( type === 'display' ) {
						if (data==0){
							return "<input type='checkbox' name='checkRuang' value='"+vid+"' onchange='chooseApp(this)'/>";
						}else{
							return "<input type='checkbox' name='checkRuang' value='"+vid+"' onchange='chooseApp(this)' checked/>";
						}
					}
					return data;
				},
				className: "dt-body-center"
			},
			{ data: "nama" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false },
			{ targets: [ 1 ], orderable: false },
			{ targets: [ 2 ], orderable: false }
		],
		paging: false,			
		searching: false,
		autoWidth: false
	} );	
	$('#modalTitleRuang').html( "Ruang Access for User : <strong>"+vname+"</strong>");
}

    $(document).on("click",".delete_user",function() {
      var getLink = $(this).attr('href');
      swal({
        title: "Hapus User",
        text: "Yakin akan menghapus user tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Hapus",
        showLoaderOnConfirm: true,
        closeOnConfirm: true
        }, function() {
			$.ajax({
				type: 'POST',
				url: getLink,
				dataType:'JSON',
				success: function(response) {
					if (response.success){
						objTable.ajax.reload();
						swal("Sukses","Berhasil menghapus data.", "success"); 
					}else swal("Error","Gagal menghapus data.", "error"); 
				}
			});           
      });
      return false;
    });

function saveSetting(){
	var vdata = [];
	var checkApp = $("#detailForm input:checkbox");
	var x=0;
	for (var i = 0; i < checkApp.length; i++) {
		if (checkApp[i].checked) {
			vdata[x] = {"roleid":objTable2.column( 0 ).data()[i],"userid":checkApp[i].value,"role":objTable2.column( 2 ).data()[i]};	
			x++;
		}
	}
	
	$.ajax({		
		type: 'POST',					
		url: '<?php echo site_url('admin/userRoleSave'); ?>',
		data: {vdata:vdata},
		dataType:'json',
		success: function( response ) {
			if (response.success){ 
				alert("Assign Role Berhasil");
				$('#myModal').modal('hide');
			}else 
				alert("Assign Role Gagal");
		}
	});	
}
function saveSettingGdg(){
	var vdata = [];
	var checkGdg = $("#detailFormGdg input:checkbox");
	var x=0;
	for (var i = 0; i < checkGdg.length; i++) {
		var uname=checkGdg[i].value;
		if (checkGdg[i].checked) {
			vdata[x] = {"id_gudang":objTable3.column( 0 ).data()[i],"userid":checkGdg[i].value,"nama_gudang":objTable3.column( 2 ).data()[i]};	
			x++;
		}
	}
	if(x==0){
		//delete
		$.ajax({		
		type: 'POST',					
		url: '<?php echo site_url('admin/userGdgDelete'); ?>',
		data: {vdata:uname},
		dataType:'json',
		success: function( response ) {			
			//if (response.success){ 
				alert("Akses Gudang Berhasil");
				$('#myModalGdg').modal('hide');
			//}else 
			//	alert("Akses Gudang Gagal");
		}
	});
	}else{
		$.ajax({		
		type: 'POST',					
		url: '<?php echo site_url('admin/userGdgSave'); ?>',
		data: {vdata:vdata},
		dataType:'json',
		success: function( response ) {
			if (response.success){ 
				alert("Akses Gudang Berhasil");
				$('#myModalGdg').modal('hide');
			}else 
				alert("Akses Gudang Gagal");
		}
	});
	}
	
	
}

function saveSettingPoli(){
	var vdata = [];
	var checkPoli = $("#detailFormPoli input:checkbox");
	var x=0;
	for (var i = 0; i < checkPoli.length; i++) {
		var uname=checkPoli[i].value;
		if (checkPoli[i].checked) {
			vdata[x] = {"id_poli":objTable4.column( 0 ).data()[i],"userid":checkPoli[i].value,"nm_poli":objTable4.column( 2 ).data()[i]};	
			x++;
		}
	}
	//alert(x);
	if(x==0){
		//delete
		$.ajax({		
		type: 'POST',					
		url: '<?php echo site_url('admin/userPoliDelete'); ?>',
		data: {vdata:uname},
		dataType:'json',
		success: function( response ) {
				alert("Akses Poli Berhasil");
				$('#myModalPoli').modal('hide');			
		}
	});
	}else{
	$.ajax({		
		type: 'POST',					
		url: '<?php echo site_url('admin/userPoliSave'); ?>',
		data: {vdata:vdata},
		dataType:'json',
		success: function( response ) {
			if (response.success){ 
				alert("Akses Poli Berhasil");
				$('#myModalPoli').modal('hide');
			}else 
				alert("Akses Poli Gagal");
		}
	});
	}
}

function saveSettingRuang(){
	var vdata = [];
	var checkRuang = $("#detailFormRuang input:checkbox");
	var x=0;
	for (var i = 0; i < checkRuang.length; i++) {
		var uname=checkRuang[i].value;
		if (checkRuang[i].checked) {			
			vdata[x] = {"id_ruang":objTable5.column( 0 ).data()[i],"userid":checkRuang[i].value,"nm_ruang":objTable5.column( 2 ).data()[i]};	
			x++;
		}
	}
	if(x==0){
		//delete
		$.ajax({		
		type: 'POST',					
		url: '<?php echo site_url('admin/userRuangDelete'); ?>',
		data: {vdata:uname},
		dataType:'json',
		success: function( response ) {
			//if (response.success){ 
				alert("Akses Ruang Berhasil");
				$('#myModalRuang').modal('hide');
			//}else 
			//	alert("Akses Gudang Gagal");
		}
	});
	}else{
		$.ajax({		
			type: 'POST',					
			url: '<?php echo site_url('admin/userRuangSave'); ?>',
			data: {vdata:vdata},
			dataType:'json',
			success: function( response ) {
				if (response.success){ 
					alert("Akses Ruang Berhasil");
					$('#myModalRuang').modal('hide');
				}else 
					alert("Akses Ruang Gagal");
			}
		});
	}
}
</script>