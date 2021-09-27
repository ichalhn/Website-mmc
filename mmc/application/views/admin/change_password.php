<?php
	$this->load->view('layout/header.php');
?>
	<!-- Content Header (Page header) -->	
	<section class="content">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading" align="center" style="background-color:#00C0C5;color:#ffffff">Form Change Password</div>
					<div class="panel-body">		
						<form id="editForm" class="form-horizontal" method="POST" action="<?php echo site_url('user/Change_password/save'); ?>">
						<div class="row">
							<div class="col-md-12">	
								<div class="form-group">
									<label class="control-label col-sm-4">Current Password</label>
									<div class="col-sm-8">
										<input type="password" class="form-control" name="currpass" id="currpass" required>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">	
								<div class="form-group">
									<label class="control-label col-sm-4">Password</label>
									<div class="col-sm-8">
										<input type="password" class="form-control" name="newpass" id="newpass" required>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">	
								<div class="form-group">
									<label class="control-label col-sm-4">Retype Password</label>
									<div class="col-sm-8">
										<input type="password" class="form-control" name="renewpass" id="renewpass" required>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">	
								<div class="form-group">
									<label class="control-label col-sm-4"></label>
									<div class="col-sm-4">
										<button class="btn btn-primary" type="submit">Simpan</button>
									</div>
								</div>
							</div>
						</div>
						</form>
						<div class="row">
						  <div class="col-md-12" id="alertMsg">	
								<?php echo $this->session->flashdata('alert_msg'); ?>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
	$this->load->view('layout/footer.php');
?>


<script type='text/javascript'>
$(function() {
	$('#currpass').focus();
	
	$( "#newpass" ).change(function() {
		if ( ($('#newpass').val()!= '') && ($('#renewpass').val() != '' )){
			if ( $('#newpass').val() != $('#renewpass').val() ){
			alert('Please retype, newpass is missmatch!');
				$('#newpass').val('');
				$('#renewpass').val('');
				$('#newpass').focus();
			}
		}
	});
	$( "#renewpass" ).change(function() {
		if ( ($('#newpass').val()!= '') && ($('#renewpass').val() != '' )){
			if ( $('#newpass').val() != $('#renewpass').val() ){
				alert('Please retype, newpass is missmatch!');
				$('#newpass').val('');
				$('#renewpass').val('');
				$('#newpass').focus();
			}
		}
	});
})
</script>