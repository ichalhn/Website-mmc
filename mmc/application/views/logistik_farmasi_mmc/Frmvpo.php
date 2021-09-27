<?php
  $this->load->view('layout/header.php');
?>
<script type='text/javascript'>
var table, tblObat;
$(function() {
	$('.datepicker').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true
	});  
	table = $('#example').DataTable({
		ajax: "<?php echo site_url(); ?>logistik_farmasi/Frmcpo/get_po_list",
		columns: [
			{ data: "id_po" },
			{ data: "no_po" },
			{ data: "tgl_po" },
			{ data: "company_name" },
			{ data: "sumber_dana" },
			{ data: "user" },
			{ data: "status" },
			{ data: "aksi" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false }
		],
		bFilter: true,
		bPaginate: true,
		destroy: true,
		order:  [[ 2, "asc" ],[ 1, "asc" ]]
	});
	tableObat = $('#tableObat').DataTable({
		//ajax: "<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_amprah_detail_list",
		columns: [
			{ data: "item_id" },
			{ data: "description" },
			{ data: "satuank" },
			{ data: "qty_po" },
			{ data: "hargabeli" },
			{ data: "subtotal" }
			//{ data: "jml_kemasan" },
			//{ data: "harga_item" }
			//{ data: "subtotal", render: $.fn.dataTable.render.number('.', ',', 0, '') }
		],
		bFilter: true,
		bPaginate: true,
		destroy: true,
		order:  [[ 0, "asc" ]]
	});
	
	$('#no_po').autocomplete({
		serviceUrl: '<?php echo site_url();?>logistik_farmasi/Frmcpo/auto_no_po',
		onSelect: function (suggestion) {
			$.ajax({
			  dataType: "json",
			  data: {id: suggestion.id },
			  type: "POST",
			  url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpo/get_info",
			  success: function( response ) {
				//alert(JSON.stringify(response));
				$('#tgl0').val(response.tgl_po);
				$('#tgl1').val('');
				$('#tgl1').prop('disabled',true);
				$('#supplier_id').val(response.supplier_id);
				$('#supplier_id').prop("disabled", true);
			  }
			});		
			$('#btnCari').focus();
		}
	});
	$('#btnCari').click(function(){
		refreshPO();
	});
	
	$('#detailModal').on('shown.bs.modal', function(e) {
		//get data-id attribute of the clicked element
		var id = $(e.relatedTarget).data('id');
		var no = $(e.relatedTarget).data('no');
		$('#sDetailID').html(no);
		$('#hideIdPO').val(id);
		$.ajax({
		  dataType: "json",
		  type: 'POST',
		  data: {id:id},
		  url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpo/get_detail_list",
		  success: function( response ) {
				tableObat.clear().draw();
				tableObat.rows.add(response.data);
				tableObat.columns.adjust().draw(); 

				$("#totals").html('<h3>' + response.total + '</h3>');
		  }
		});	
	});
	
	$('#btnOK').click( function() {
		$('#detailModal').modal('hide');
    });
	
	$('#btnReset').click(function(){
		$('#tgl1').prop('disabled',false);
		$('#supplier_id').prop("disabled", false);
		$('#no_po').focus();
	});
	$('#btnCetak').click( function() {
		var id = $('#hideIdPO').val();
		var win = window.open(baseurl+'download/logistik_farmasi/PO/FP_'+id+'.pdf', '_blank');
		if (win) {
			//Browser has allowed it to be opened
			win.focus();
		} else {
			//Browser has blocked it
			alert('Please allow popups for this website');
		}
	});
});

function refreshPO(){
	$.ajax({
		url: '<?php echo site_url(); ?>logistik_farmasi/Frmcpo/get_po_list',
		type: 'POST',
		data: $('#frmCari').serialize(),
		dataType: "json",
		success: function (response) {
			//alert(JSON.stringify(response.data));
			table.clear().draw();
			table.rows.add(response.data);
			table.columns.adjust().draw(); 
		}
	});
}

function export_excel(){
	var d = new Date();
	tglawal = document.getElementById("tgl0").value;
	if(tglawal === ""){
		tglawal = "<?php echo date('Y-m-d');?>"
	}
	tglakhir = document.getElementById("tgl1").value;
	if(tglakhir === ""){
		tglakhir = "<?php echo date('Y-m-d');?>"
	}
	url = "<?php echo base_url('logistik_farmasi/Frmcpo/export_excel')?>";
	swal({
	  	title: "Export To Excel",
	  	text: "Benar Akan Export?",
	  	type: "info",
	  	showCancelButton: true,
	  	closeOnConfirm: false,
	  	showLoaderOnConfirm: true,
	},
	function(){
		window.open(url+'/'+tglawal+'/'+tglakhir, "_blank");
		// alert(url+'/'+tglawal+'/'+tglakhir);
		swal({
		  	title: "Data Excel Berhasil Di download.",
		  	text: "Akan menghilang dalam 3 detik.",
		  	timer: 3000,
		  	showConfirmButton: false,
		  	showCancelButton: true
		});
	});
}
    
</script>

<section class="content">		
	<div style="background: #e4efe0">
		<div class="inner">
			<div class="container-fluid"><br>
					<form id="frmCari" class="form-horizontal">
						<div class="form-group row">
							<label class="col-sm-2 control-label">Nomor PO</label>
							<div class="col-sm-4">
							  <input type="text" class="form-control" name="no_po" id="no_po" >
							</div>
							<div class="col-sm-6">
							  <a type="button" class="btn btn-primary pull-right" href="<?php echo site_url('logistik_farmasi/Frmcpo/form');?>"><i class="fa fa-plus"> &nbsp;Tambah PO</i> </a>	
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">Tanggal PO</label>
							<div class="col-sm-2">
							  <input type="text" class="form-control datepicker" name="tgl0" id="tgl0" >
							</div>
							<label class="col-sm-1 control-label">s/d</label>
							<div class="col-sm-2">
							  <input type="text" class="form-control datepicker" name="tgl1" id="tgl1" >
							</div>
							<div class="col-sm-5">
		                		<button type="button" id="submit" onclick="export_excel()" class="btn btn-primary pull-right"><i class="fa fa-print"> &nbsp;Export Excel</i> </button>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2 control-label">Supplier</label>
							<div class="col-sm-4">
							  <select name="supplier_id" id="supplier_id" class="form-control" style="width:100%" required="">
								<option value="" selected>---- Pilih Supplier ----</option>
								<?php
								  foreach($select_pemasok as $row){
									echo '<option value="'.$row->person_id.'">'.$row->company_name.'</option>';
								  }
								?>
							  </select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-2">
							</div>
							<div class="col-sm-10">
							  <button type="button" id="btnCari" class="btn btn-primary">Cari</button>
							  <button type="reset" id="btnReset" class="btn btn-primary">Reset</button>
							</div>
						</div>					
					</form>	
					
			</div>
		</div>
	</div>
</section>
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
			<div class="row">
			  <div class="col-xs-9" id="alertMsg">	
					<?php echo $this->session->flashdata('alert_msg'); ?>
			  </div>
			</div>
        </div>
        <div class="box-body">
            <div class="modal-body">
				<table id="example" class="display" cellspacing="0" width="100%">
				  <thead>
				  <tr>
					<th>ID PO</th>
					<th>No. PO</th>
					<th>Tgl PO</th>
					<th>Supplier</th>
					<th>Sumber Dana</th>
					<th>User</th>
					<th>Status</th>
					<th>Aksi</th>
				  </tr>
				  </thead>
				</table>		
			</div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Insert-->
  <div class="modal fade" id="detailModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-default modal-lg">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title">Detail PO No : <span id="sDetailID"></span></h4>
		</div>
		<div class="modal-body table-responsive">							
			<table id="tableObat" class="display" cellspacing="0" width="100%">
			  <thead>
			  <tr>
				<th><p align="center">ID Obat</p></th>
				<th><p align="center">Nama Obat</p></th>
				<th><p align="center">Satuan</p></th>
				<th><p align="center">Jml PO</p></th>
				<th><p align="center">Harga Beli</p></th>
				<th><p align="center">Subtotal</p></th>
			  </tr>
			  </thead>
			</table>
			<table cellspacing="0" width="100%" class="display">
				<thead>
					<tr>
						<th width="80%"><div align="right"><h3>Total</h3></div></th>
						<th width="20%"><div align="right" id="totals"></div></th>
					</tr>
				</thead>
			</table>	
			<br>
		</div>
		<div class="modal-footer">
			<button id="btnOK" class="btn btn-primary pull-right">OK</button>
			<span class="pull-right">&nbsp;&nbsp;</span><input type="hidden" id="hideIdPO">
			<button id="btnCetak" class="btn btn-primary pull-right">Lihat Faktur</button>
		</div>
	  </div>
	</div>
  </div>
</section>

<?php
  $this->load->view('layout/footer.php');
?>