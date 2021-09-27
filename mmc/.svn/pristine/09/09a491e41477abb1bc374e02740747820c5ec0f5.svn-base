<?php
	$this->load->view('layout/header.php');
?>
	<link rel="stylesheet" href="<?php echo site_url('asset/css/buttons.dataTables.min.css'); ?>">
    <script src="<?php echo site_url('asset/js/dataTables.buttons.min.js'); ?>"></script>
    <script src="<?php echo site_url('asset/js/buttons.flash.min.js'); ?>"></script>
    <script src="<?php echo site_url('asset/js/jszip.min.js'); ?>"></script>
    <script src="<?php echo site_url('asset/js/pdfmake.min.js'); ?>"></script>
    <script src="<?php echo site_url('asset/js/vfs_fonts.js'); ?>"></script>
    <script src="<?php echo site_url('asset/js/buttons.html5.min.js'); ?>"></script>
    <script src="<?php echo site_url('asset/js/buttons.print.min.js'); ?>"></script>
<section class="content">
	<div class="row">
		<div class="col-md-12">			
			<div class="box">
				<div class="box-body">		<!--
					<div class="row pull-right">
					  <div class="col-xs-12">
						<div class="input-group">
						  <span class="input-group-btn">
							<a type="button" class="btn btn-primary" href="<?php //echo site_url("kepegawaian/Duk/export_to_pdf"); ?>" target="_blank"><i class="fa fa-plus"> Cetak PDF</i> </a>
						  </span>
						  <span class="input-group-btn">
							<a type="button" class="btn btn-primary"><i class="fa fa-plus"> Download Excel</i> </a>
						  </span>
						</div>
						<br/> 
						<br/> 
					  </div>
					</div>				 --> 		
					<table id="dtDuk" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th></th>
								<th>NIP</th>
								<th>Nama</th>
								<th>Golongan</th>
								<th>Pangkat</th>
								<th>Bagian</th>
								<th>Sub Bagian</th>
							</tr>
						</thead>
					</table>
				</div><!-- end panel body -->
			</div><!-- end panel info-->				 
		</div><!-- end tab content -->			
	</div><!--- end row --->
</section>

<script type='text/javascript'>
$(function() {
	var tblDuk;
	tblDuk = $('#dtDuk').DataTable({
		ajax: "<?php echo site_url(); ?>kepegawaian/Duk/data",
		columns: [
			{ data: "id_golongan" },
			{ data: "nip" },
			{ data: "nm_pegawai" },
			{ data: "nm_golongan" },
			{ data: "pangkat" },
			{ data: "nm_bagian" },
			{ data: "nm_subag" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false }
		],
		order: [[ 0, "desc" ]],
        dom: 'Bfrtip',
        buttons: [{
			extend: 'csvHtml5',
			text: 'Save as CSV',
			title: 'data_duk_'+$.datepicker.formatDate('yymmdd', new Date())
        }]
	});	
})
</script>

<?php
	$this->load->view('layout/footer.php');
?>