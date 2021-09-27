<?php
  $this->load->view('layout/header.php');
?>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
	var table = null;
  $(document).ready(function() {
    $('#example').DataTable();
  } );
  //---------------------------------------------------------
	$('#tgl_valid').hide();
  $(function() {
    $('#date_picker').datepicker({
      format: "yyyy-mm-dd",
      endDate: '0',
      autoclose: true,
      todayHighlight: true,
    });  
  }); 

	function detail(novoucher,tutupvoucher,tglvalid){
		
		$("#ajax_loader").show();
		$('#cuba').hide();		
		//datatables
		if(table!=null){
			table.destroy();
		}
		table = $('#table').DataTable({ 

		    "processing": true, //Feature control the processing indicator.
		    "serverSide": true, //Feature control DataTables' server-side processing mode.
		    "order": [], //Initial no order.

		    // Load data for the table's content from an Ajax source
		    "ajax": {
		        "url": "<?php echo site_url('akun/crsakun/ajax_list2')?>"+"/"+novoucher,
		        "type": "POST"
		    },  
		    drawCallback : function() {
		       	
				 
				$('#novouch1').val(novoucher);	
				$('#novouch2').val(novoucher);	
				//alert(tutupvoucher=='0000-00-00 00:00:00');
				if(tutupvoucher=='0000-00-00 00:00:00'){
					$('#open').attr('disabled', true);
					document.getElementById('open').href ="javascript: void(0)";
				}else{
					$('#open').attr('disabled', false);
					document.getElementById('open').href ="<?php echo site_url('akun/crsakun/open_voucher')?>"+"/"+novoucher;
				}

				if(tglvalid!='0000-00-00 00:00:00' && tglvalid!=''){
					$('#tgl_valid').show();
					$('#tgl').val(tglvalid);
					$('#valid').hide();
					document.getElementById('ketvouch').disabled =true;
					$('#open').attr('disabled', true);
					document.getElementById('open').href ="javascript: void(0)";
				}else{
					$('#valid').show();
					$('#tgl_valid').hide();
					document.getElementById('ketvouch').disabled =false;
					if(tutupvoucher=='0000-00-00 00:00:00' || tutupvoucher==''){						
						$('#valid').attr('disabled', true);
						$('#open').attr('disabled', true);
						document.getElementById('open').href ="javascript: void(0)";						
					}else{
						document.getElementById('open').href ="<?php echo site_url('akun/crsakun/open_voucher')?>"+"/"+novoucher;
						$('#open').attr('disabled', false);
												
						$('#valid').attr('disabled', false);
						document.getElementById('valid').href ="<?php echo site_url('akun/crsakun/valid_voucher')?>"+"/"+novoucher;
					}
				}
				
				$.ajax({
					  type:'POST',
					  dataType: 'json',
					  url:"<?php echo base_url('akun/crsakun/get_data_edit_voucher')?>",
					  data: {
						kode: novoucher
					  },
					  success: function(data){
						//alert(data[0].statusflag);
						$('#ketvouch').val(data[0].ket);
						$('#ket1').val(data[0].ket);
						$('#ket2').val(data[0].ket);
						$("#ajax_loader").hide();						
					  },
					  error: function(){
						alert("error");
					  }
					});
					
				$('#cuba').show();
		    },  
		    //Set column definition initialisation properties.
		    "columnDefs": [
		    { 
		        "targets": [ -1 ], //last column
		        "orderable": false, //set not orderable
		    },
		    ],

		});
		
		
	}
	
	function ket(ketval) {
		$('#ket1').val(ketval);
		$('#ket2').val(ketval);
	}
	
  function edit_rekening(kode) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('akun/crsakun/get_data_edit_rekening')?>",
      data: {
        kode: kode
      },
      success: function(data){
	//alert(data[0].statusflag);
        $('#edit_kode').val(data[0].kode);
        $('#edit_kode_hidden').val(data[0].kode);
        $('#edit_perkiraan').val(data[0].perkiraan);
	$('#edit_tipe').val(data[0].tipe);
        $('#edit_jenis_tl').val(data[0].tl);
        $('#edit_nb').val(data[0].nb);
	$('#edit_nrl').val(data[0].nrl);
	$('#ket').val(data[0].ket);
	$('#edit_upkode').val(data[0].upkode);
	if(data[0].statusflag==null){
		$('#edit_flag').val(0);
	} else 	$('#edit_flag').val(data[0].statusflag);
      },
      error: function(){
        alert("error");
      }
    });
  }


</script>
<style>
#editModal .modal-dialog
{
    width: 90%; /* your width */
}

#editModal .modal-body
{
    color: black !important; 
}


</style>
<section class="content-header">
  <?php
    echo $this->session->flashdata('success_msg');
  ?>
</section>

<section class="content">
  <div class="row" id="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">DAFTAR VOUCHER VALID</h3>
		<hr>
        </div>
	
        <div class="box-body ">

          <div class="col-xs-9">
          </div>
          <br/> 
          <br/> 

          <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
				<th>No Voucher</th>
				<th>Tgl Entry</th>
				<th>Tutup Voucher</th>
                <th>Tgl Validasi</th>
              	<th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
				<th>No Voucher</th>
                <th>Tgl Entry</th>
			<th>Tutup Voucher</th>
                <th>Tgl Validasi</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $i=1;
                  foreach($valid as $row){
					 
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->novoucher;?></td>
                <td><?php echo date('d-m-Y', strtotime($row->tglentry));?></td>
                <td><?php if($row->tutupvoucher=='0000-00-00 00:00:00' || $row->tutupvoucher==''){echo '-';} else echo date('d-m-Y', strtotime($row->tutupvoucher)).' | '.date('H:i:s', strtotime($row->tutupvoucher));?></td>
                <td><?php if($row->tglvalidasi=='0000-00-00 00:00:00' || $row->tglvalidasi==''){echo '-';} else echo date('d-m-Y', strtotime($row->tglvalidasi)).' | '.date('H:i:s', strtotime($row->tglvalidasi));?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal" onclick="detail('<?php echo $row->novoucher;?>','<?php echo $row->tutupvoucher;?>','<?php echo $row->tglvalidasi;?>')"><i class="fa fa-edit"></i></button>		  
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false" >
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header" >
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Detail Voucher</h4>
                </div>
				
                <div class="modal-body" style="min-height:200px;">
				<div id='ajax_loader' style="position: fixed; left: 50%; top: 25%; display: none;">
					<img src="https://www.drupal.org/files/issues/ajax-loader.gif"></img>
				</div>
				<div id="cuba">
                   <table id="table" class="display" cellspacing="0" width="100%">
			    <thead>
			      <tr>
				<th>No</th>
				<th>No Voucher</th>
				<th>Tgl Transaksi</th>
				<th>Kode Rekening</th>
				<th>Nilai</th>
				<th>Tipe</th>
				<th>BT</th>
				<th>PIC</th>
				<th>Keterangan</th>
			      </tr>
			    </thead>
			    <tfoot>
			      <tr>
				<th>No</th>
				<th>No Voucher</th>
				<th>Tgl Transaksi</th>
				<th>Kode Rekening</th>
				<th>Nilai</th>
				<th>Tipe</th>
				<th>BT</th>
				<th>PIC</th>
				<th>Keterangan</th>
			      </tr>
			    </tfoot>
			    <tbody>			     
			    </tbody>
			  </table>
			<br>
			<div class="form-group row">
		          <div class="col-sm-1"></div>
		            <p class="col-sm-3 form-control-label" id="lbl_ket_new" style="color:white;">Keterangan</p>
		            <div class="col-sm-6">
		              <textarea id="ketvouch" name="ketvouch" rows="4%" cols="50%" style="color:black !important" onchange="ket(this.value)"></textarea>
		            </div>
		          </div>
				  
			<div class="form-group row" id="tgl_valid">
		            <div class="col-sm-1"></div>
		            <p class="col-sm-3 form-control-label" style="color:white;">Tanggal Validasi</p>
		            <div class="col-sm-6">
		              <input type="text" class="form-control" name="tgl" id="tgl" disabled>
		            </div>
		          </div>
                </div>
				</div>
		 
                <div class="modal-footer">
					<div class="col-sm-9">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
					<div class="col-sm-2">
						<?php echo form_open('akun/crsakun/open_voucher');?>
							<input type="hidden" name="novouch1" id="novouch1" >
							<input type="hidden" name="ket1" id="ket1" >
							<button class="btn btn-primary" id="open" type="submit" >Buka Voucher</button>
						<?php echo form_close(); ?>
					</div>
					<div class="col-sm-1">
						<?php echo form_open('akun/crsakun/valid_voucher');?>
							<input type="hidden" name="novouch2" id="novouch2" >
							<input type="hidden" name="ket2" id="ket2" >
							<button class="btn btn-success" id="valid" type="submit">Validasi</button>
						<?php echo form_close(); ?>
					</div>
                </div>
              </div>
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
