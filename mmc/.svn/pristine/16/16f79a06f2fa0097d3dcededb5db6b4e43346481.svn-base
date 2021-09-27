<?php
  $this->load->view('layout/header.php');
?>
<style >
  
  .date_picker{z-index:+1 !important;}
  .datepicker{z-index:1151 !important;}
</style>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
	var save_method; //for save method string
    	var table;

  $(document).ready(function() {
	$(".select2").select2();
	var ok = "<?php echo $ok; ?>";
	var novoucher = "<?php echo $novoucher; ?>";
	var tutup = "<?php echo $tutupvoucher; ?>";
	var tgltrans = "<?php echo $tglentry; ?>";
	var newket = "<?php echo $ket; ?>";
	//alert(novoucher);
	if(novoucher!=''){		
		$('#new_no_voucher').val(novoucher);		
		$('#trans_novoucher').val(novoucher);
		$('#new_ket').val(newket);
		$('#trans_novoucher_hidden').val(novoucher);
		//alert($('#trans_novoucher').val());
		$('#new_tgl_entry').val(tgltrans.substr(0,10));
		$('#new_no_voucher').attr('disabled', true); 
		$('#new_tgl_entry').attr('disabled', true); 
		$('#new_ket').attr('disabled', true); 
		$('#btn-voucher').attr('disabled', true);	

			//datatables	
        table = $('#table').DataTable({ 

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('akun/crsakun/ajax_list')?>"+"/"+novoucher,
                "type": "POST"
            },
	    drawCallback : function() {
	       processInfo(this.api().page.info(), tutup);
	    },	    
            //Set column definition initialisation properties.
            "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },
            ],

        });
	}else 
		$('#btn-add-trans').attr('disabled', true);
	//alert(ok+' '+tutup);
	if(ok=='1'){
		
		if(tutup=='' || tutup=='0000-00-00 00:00:00'){
			$('#btn-tutup').attr('disabled', false);
			document.getElementById('btn-tutup').href ="<?php echo site_url('akun/crsakun/close_voucher')?>"+"/"+novoucher;
		}else{		
			$('#btn-tutup').attr('disabled', true);
			document.getElementById('btn-tutup').href ='javascript: void(0)';		
		}
	}else{
		
		$('#btn-tutup').attr('disabled', true);
		document.getElementById('btn-tutup').href ='javascript: void(0)';
		
	}

	if(tutup!='' && tutup!='0000-00-00 00:00:00'){
		$('#btn-add-trans').attr('disabled', true);		
	}

    $('#table').DataTable();

	

	/*var tbl = table.page.info();
	if(tbl["recordsTotal"]==0){
		alert(tbl["recordsTotal"]);
		
	}*/

	
  } );
  //---------------------------------------------------------

  $(function() {
    $('.date_picker').datepicker({
      format: "yyyy-mm-dd",
      endDate: '0',
      autoclose: true,
      todayHighlight: true,
    });  

	
  }); 

	function processInfo(info, tutup) {
	    console.log(info["recordsTotal"]);
	    //do your stuff here
		if(info["recordsTotal"]==0){
			$('#btn-tutup').attr('disabled', true);
			document.getElementById('btn-tutup').href ='javascript: void(0)';
		}		
	} 

  function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax 
    }

  function add_transaksi(novoucher)
    {
        $('#edit_novoucher_hidden').val(novoucher);
    }

  function add_voucher()
    {
        var voucher = $('#new_no_voucher').val();
	var tgltrans = $('#new_tgl_transaksi').val();
	
	$.ajax({
		url : "<?php echo base_url('akun/crsakun/add_new_voucher')?>",
		data : { novoucher : voucher, tgltransaksi : tgltrans },	
		type : 'POST',
		cache: false,
		success : function(succ) {
			alert(succ);
			$('#new_no_voucher').val(voucher);
			$('#new_tgl_transaksi').val(tgltrans.substr(0,10));
			$('#new_no_voucher').attr('disabled', true); 
			$('#new_tgl_transaksi').attr('disabled', true); 
			$('#btn-voucher').attr('disabled', true);
			 //window.location.href = "<?php echo base_url('akun/crsakun/voucher/')?>"+voucher;
		},
		error : function(err) {
			alert(err);
		}
	});

    }

  function edit_voucher(novoucher) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('akun/crsakun/get_data_edit_transaksi')?>",
      data: {
        novoucher: novoucher
      },
      success: function(data){
	alert(data[0].novoucher);
        $('#edit_novoucher').val(data[0].novoucher);
        $('#edit_novoucher_hidden').val(data[0].novoucher);
        $('#edit_tgl_transaksi').val(data[0].tgltransaksi.substr(0,10));
	$('#edit_tgl_entry').val(data[0].tglentry.substr(0,10));
        $('#edit_tutup').val(data[0].tutupvoucher);
        $('#edit_tgl_validasi').val(data[0].tglvalidasi.substr(0,10));
      },
      error: function(){
        alert("error");
      }
    });
  }
	


</script>
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
          <h3 class="box-title">DAFTAR VOUCHER</h3>
		<hr>
        </div>
	
        <div class="box-body ">
		 <?php echo form_open('akun/crsakun/add_new_voucher');?>
		 	<div class="form-group row">
				<div class="col-sm-1"></div>
				<p class="col-sm-3 form-control-label" id="lbl_no_voucher">Kode Voucher</p>
				<div class="col-sm-6">
				  <input type="text" class="form-control" name="new_no_voucher" id="new_no_voucher" required>
				</div>
			  </div>
			  <div class="form-group row">
				<div class="col-sm-1"></div>
				<p class="col-sm-3 form-control-label" id="lbl_tgl_trans">Tanggal Entry</p>
				<div class="col-sm-6">
				 <input type="text" class="form-control date_picker" placeholder="" id="new_tgl_entry" name="new_tgl_entry" value="" required>
				</div>
			  </div>
			<div>
			<div class="form-group row">
		          <div class="col-sm-1"></div>
		            <p class="col-sm-3 form-control-label" id="lbl_ket_new">Keterangan</p>
		            <div class="col-sm-6">
		              <textarea id="new_ket" name="new_ket" rows="10%" cols="50%" style="color:black !important"></textarea>
		            </div>
		          </div>
			<div class="form-group row">
				<div class="col-sm-1"></div>
				<div class="col-sm-3"></div>
				<div class="col-sm-6">
				<button id="btn-voucher" class="btn btn-primary " type="submit">Simpan</button>
				 <?php echo form_close();?>
				<a id="btn-tutup"  class="btn btn-success">Tutup Voucher</a>
				</div>
			</div>
		
				
		<hr>
         

	  
          <div class="col-sm-12" align="right">		
            
                <button type="button" id="btn-add-trans" class="btn btn-primary " data-toggle="modal" data-target="#addTransModal"><i class="fa fa-plus"> Transaksi Baru</i> </button>              
		<hr>
            </div>

          <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
              	<th>Aksi</th>
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
              	<th>Aksi</th>
                
              </tr>
            </tfoot>
            <tbody>
             
            </tbody>
          </table>

          <?php echo form_open('akun/crsakun/add_new_transaksi');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="addTransModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Add Transaksi</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">No Voucher</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="trans_novoucher" id="trans_novoucher" disabled="true">
			<input type="hidden" class="form-control" name="trans_novoucher_hidden" id="trans_novoucher_hidden">
                    </div>
                  </div>
		   <div class="form-group row">
		            <div class="col-sm-1"></div>
		            <p class="col-sm-3 form-control-label" id="lbl_tgl_trans">Tanggal Transaksi</p>
		            <div class="col-sm-6">
		             <input type="text" class="form-control date_picker" placeholder="" id="trans_tgltrans" name="trans_tgltrans" value="" required>
		            </div>
		          </div>
			<div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Kode Rekening</p>
                    <div class="col-sm-6">
                      <select  class="form-control select2" style="width: 100%" name="trans_koderek" id="trans_koderek" required >
				<option value="">-Pilih Kode Rekening-</option>
				<?php 
					foreach($rekening as $row1){
						echo '<option value="'.$row1->kode.'">'.$row1->perkiraan.'</option>';
					}
				?>
			</select>
                    </div>
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nilai</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" placeholder="ex: 1000000" name="trans_nilai" id="trans_nilai">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nb">Tipe</p>
                    <div class="col-sm-6">
                      <select  class="form-control" style="width: 100%" name="trans_tipe" id="trans_tipe" required >
				<option value="">-Pilih Tipe-</option>
				<option value="K">KREDIT</option>
				<option value="D">DEBET</option>
			</select>
                    </div>
                  </div>
		  <div class="form-group row">
		            <div class="col-sm-1"></div>
		            <p class="col-sm-3 form-control-label" id="lbl_pic">Penanggung Jawab</p>
		            <div class="col-sm-6">
		              <textarea id="trans_pic" name="trans_pic" rows="10%" cols="37%" style="color:black !important"></textarea>
		            </div>
		  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_ket">Keterangan</p>
                    <div class="col-sm-6">
                      <textarea id="trans_ket" name="trans_ket" rows="10%" cols="37%" style="color:black !important"></textarea>
                    </div>
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_bt">BT</p>
                    <div class="col-sm-6">
                      <select  class="form-control select2" style="width: 100%" name="trans_bt" id="trans_bt" >
				<option value="">-Pilih BT-</option>
				<?php 									
					foreach($bt as $row1){						
						
						echo '<option value="'.$row1->tipe.'-'.$row1->kode.'">('.$row1->tipe.') '.$row1->mataanggaran.'</option>';											
					}
				?>
			</select>
                    </div>
                  </div>		  		   

                </div>
                <div class="modal-footer">
		  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit"><i class="fa fa-plus"> Transaksi</i></button>
                </div>
              </div>
            </div>
          </div>
          <?php echo form_close();?>
	 

        </div>
      </div>
    </div>
  </div>
</section>

<?php
  $this->load->view('layout/footer.php');
?>
