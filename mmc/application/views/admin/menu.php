<?php
	$this->load->view('layout/header.php');
?>
	<!-- Content Header (Page header) -->	
	<section class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-info">
					<div class="panel-heading" align="center" style="background-color:#00C0C5;color:#ffffff">Form Input</div>
					<div class="panel-body">
						<button class="btn btn-warning" id="btnAdd">Tambah Menu Baru</button>
						<hr/>
						<form id="idform" class='form-horizontal' action="<?php echo site_url('admin/menuSave'); ?>" method="post">
							<input type="hidden" id="id" name="id"/>
							<div class='form-group'>		
								<div class="col-sm-2"><label>Title</label></div>
								<div class='col-sm-10'><input type="text" id="title" name="title" class="form-control" /></div>
							</div>   
							<div class='form-group'>		
								<div class="col-sm-2"><label>URL</label></div>
								<div class='col-sm-10'><input type="text" id="url" name="url" class="form-control" /></div>
							</div>   
							<div class='form-group'>		
								<div class="col-sm-2"><label>Parent</label></div>
								<div class='col-sm-10'>								
									<?php echo form_dropdown(
										array(
											'name'=>'parent_id',
											'id'=>'parent_id',
											'class'=>'form-control'), 
										$parents, 
										' ');?>
								</div>
							</div>   
							<div class='form-group'>		
								<div class="col-sm-2"></div>
								<div class='col-sm-10'>
									<div class="form-inline">
										<button type="reset" class="btn btn-primary">Reset</button>
										<button type="button" class="btn btn-primary" id="btnSimpan">Simpan</button>
										<!--<a href="#" class="btn btn-primary">Cetak Kartu</a>-->
									</div>
								</div>
							</div>      							
						</form>
						<ul id="error_message_box"></ul>
						<div id="feedback_bar"></div>
					</div>
					<!--- end panel body--->
				</div>
				<!--- end panel --->
			</div>
		<!--- end col --->
			<div class="col-md-8">
				<div class="panel panel-info">
					<div class="panel-heading" align="center" style="background-color:#00C0C5;color:#ffffff">Atur Urutan Menu</div>
					<div class="panel-body">						
						<div id="accordion">
						<?php echo $sortMenu; ?>
						</div>
						<br/>
						<button id="btnRefresh" class="btn btn-warning">Refresh</button>
					</div>
					<!--- end panel body--->
				</div>
				<div id="dialog-confirm"></div>
				<!--- end panel --->
			</div>
		<!--- end col --->
		</div><!--- end row --->
	</section>
	
<?php
	$this->load->view('layout/footer.php');
?>


<script type='text/javascript'>
$(function() {
	$('#btnAdd').addClass('disabled');
	$( "#dialog-confirm" ).hide();
	$('#btnSimpan').click(function(){
		$.ajax({
			type: 'POST',
			url: $('#idform').attr( 'action' ),
			data: $('#idform').serialize(),
			success: function( response ) {
				if(!response.success)
				{
					//set_feedback(response.message,'error_message',true);
				}
				else
				{
					//set_feedback(response.message,'success_message',false);
					window.location.reload(true);
				}
			},
			dataType:'json'
		});
	});
	$('#accordion').accordion({
        collapsible: true,
        active: false,
        height: 'fill',
        header: '> div > .h3'
    }).sortable({
        items: '.s_panel',
		update: function (event, ui) {
			var a = $(this).sortable("serialize", {
				attribute: "id"
			});
			var r = $(this).sortable( "toArray" );
			$.ajax({
				data: {data:r},
				type: 'POST',
				url: '<?php echo site_url('admin/updateOrderMenu'); ?>',
				success: function( response ) {
					//alert(response);
				}
			});
		}
    });

    $('#accordion').on('accordionactivate', function (event, ui) {
        if (ui.newPanel.length) {
            $('#accordion').sortable('disable');
        } else {
            $('#accordion').sortable('enable');
        }
    });
	
	$( ".sortable" ).sortable({
		update: function (event, ui) {
			var a = $(this).sortable("serialize", {
				attribute: "id"
			});
			var r = $(this).sortable( "toArray" );
			$.ajax({
				data: {data:r},
				type: 'POST',
				url: '<?php echo site_url('admin/updateOrderMenu'); ?>',
				success: function( response ) {
					//alert(response);
				}
			});
		}
	});
		
	$( "#btnRefresh" ).click(function() {
		window.location.reload(true);
	});
	
	$( "#btnAdd" ).click(function() {		
		$("#id").val('');
		$("#title").val('');
		$("#url").val('');
		$("#parent_id").val(0);
	});
});

function editMenu(vid){
	$.ajax({
		data: {id:vid},
		type: 'POST',
		url: '<?php echo site_url('admin/menuInfo'); ?>',
		dataType:'json',
		success: function( response ) {
			$('#btnAdd').removeClass('disabled');
			$("#id").val(response.page_id);
			$("#title").val(response.title);
			$("#url").val(response.url);
			$("#parent_id").val(response.parent_id);			
		}
	});
	return false;
}

function dropMenu(vid){
	$.ajax({
		data: {id:vid},
		type: 'POST',
		url: '<?php echo site_url('admin/hasChildMenu'); ?>',
		dataType:'json',
		success: function( response ) {
			if (response.hasChild){
				$( "#dialog-confirm" ).html("Menu memiliki submenu. <br/>Menu tidak dapat dihapus.");
				$( "#dialog-confirm" ).dialog({
				  resizable: false,
				  modal: true,
				  buttons: {
					"Oke": function() {
					  $( this ).dialog( "close" );
					}
				  }
				});
			}else{
				$( "#dialog-confirm" ).html("Anda yakin akan menghapus menu?");
				$( "#dialog-confirm" ).dialog({
				  resizable: false,
				  modal: true,
				  buttons: {
					"Ya": function() {					  
						$.ajax({
							data: {id:vid},
							type: 'POST',
							url: '<?php echo site_url('admin/dropMenu'); ?>',
							dataType:'json',
							success: function( response ) {
								if (response.success) window.location.reload(true);
								else alert("Gagal menghapus");
							}
						});
					},
					"Batal": function() {
					  $( this ).dialog( "close" );
					}
				  }
				});
			
			}
		}
	});
	
	return false;
}
</script>