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
			{ data: "supplier" },
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
			{ data: "qty_beli" },
			{ data: "batch_no" },
			{ data: "expire_date" },
			{ data: "keterangan" }
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
		$.ajax({
		  dataType: "json",
		  type: 'POST',
		  data: {id:id},
		  url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpembelian_po/get_detail_list",
		  success: function( response ) {
				tableObat.clear().draw();
				tableObat.rows.add(response.data);
				tableObat.columns.adjust().draw(); 
		  }
		});	
		
		$('.datepicker').each(function(){
			$(this).datepicker();
		});
		/*
		$('.datepicker2').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true
		});  */
	});
	
	$('#btnAcc').click( function() {
		var vdata = [[]];
		var idata = -1;
		var qty, vbatch, vexdate;
		$('#tableObat').find('tr').each(function(i, val) {
			if (i>0){
				vbatch = $("#batch_no"+i).val();
				vexdate = $("#expire_date"+i).val();
				qty = $("#qty_beli"+i).val();
				if ((qty != "")&&(vbatch == "")){
					alert("Mohon lengkapi Batch No & Tanggal Expired!");
					$("#batch_no"+i).focus();
				}
				if ((vbatch != "")&&(vexdate == "")){
					alert("Mohon lengkapi Tanggal Expired!");
					$("#expire_date"+i).focus();
				}
				if (((qty != "")&&(vbatch != ""))&&(vexdate != "")){
					idata = idata + 1;
					var $elements = $(this).find('input')
					var serialized = $elements.serializeArray();
					vdata[idata] = serialized;
				}
			}
		});
		if (idata >= 0){
			$.ajax({
			  dataType: "html",
			  data: {json: vdata },
			  type: "POST",
			  url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpembelian_po/alokasi",
			  success: function( response ) {
				$('#detailModal').modal('hide');
				refreshAmprah();
			  }
			});
		}
        return false;
    } );
	
	$('#btnReset').click(function(){
		$('#tgl1').prop('disabled',false);
		$('#supplier_id').prop("disabled", false);
		$('#no_po').focus();
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
						<div class="modal-dialog modal-default modal-xl">
						  <!-- Modal content-->
						  <div class="modal-content">
							<div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal">&times;</button>
							  <h4 class="modal-title">Detail PO No : <span id="sDetailID"></span></h4>
							</div>
							<div class="modal-body">							
								<table id="tableObat" class="display" cellspacing="0" width="100%">
								  <thead>
								  <tr>
									<th>ID Obat</th>
									<th>Nama Obat</th>
									<th>Satuan</th>
									<th>Jml PO</th>
									<th>Jml Beli</th>
									<th>Batch No</th>
									<th>Expire</th>
									<th>Keterangan</th>
								  </tr>
								  </thead>
								</table>	
								<br>
							</div>
							<div class="modal-footer">
							  	<button id="btnAcc" class="btn btn-primary pull-right">Simpan</button>
							</div>
						  </div>
						</div>
					  </div>
</section>

<?php
  $this->load->view('layout/footer.php');
?>