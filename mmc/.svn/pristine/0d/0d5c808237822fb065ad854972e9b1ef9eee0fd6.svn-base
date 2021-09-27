<?php
	$this->load->view('layout/header.php');
?>
<script type='text/javascript'>
var table;

$(function() {
	table = $('#example').DataTable({
		"serverSide" : true,
		"processing" : true,
		"ajax" : '<?php echo site_url('master/Jenis_aset/dataJenisAsset'); ?>'
	});
})

</script>
<section class="content" style="width:97%;margin:0 auto">
	<div class="row">		
		<div class="tab-content">			
				<div class="panel panel-default">
					<div class="panel-body">
						<!--<div class="row">
						  <div class="col-xs-9">
								<?php //echo $this->session->flashdata('alert_msg'); ?>
						  </div>
						  <div class="col-xs-3" align="right">
							<div class="input-group">
							  <span class="input-group-btn">
								<button type="button" class="btn btn-primary pull-right " data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> Tambah Jenis Aset</i> </button>
							  </span>
							</div>
						  </div> /col-lg-6 
						</div>-->
						<table id="example" class="display" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Kode</th>
									<th>Jenis Aset</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tfoot>
								<tr>
									<th>Kode</th>
									<th>Jenis Aset</th>
									<th>Aksi</th>
								</tr>
							</tfoot>
							<tbody>
							</tbody>
						</table>
					</div><!-- end panel body -->
				</div><!-- end panel info-->
		</div><!-- end tab content -->
			
	</div><!--- end row --->
</section>
	
<?php
	$this->load->view('layout/footer.php');
?>