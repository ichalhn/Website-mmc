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
    $('#example').DataTable();

	//datatables
        table = $('#table').DataTable({ 

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('akun/crsakun/ajax_list1')?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "orderable": false, //set not orderable
            },{ 
                "targets": [ 5 ], //last column
                "visible": false, //set not orderable
            }
            ]
        });
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

  function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax 
    }

  function add_transaksi(novoucher)
    {
        $('#edit_novoucher_hidden').val(novoucher);
    }

  function edit_voucher(kode) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('akun/crsakun/get_data_edit_voucher')?>",
      data: {
        kode: kode
      },
      success: function(data){
	//alert(data[0].deleted);
        $('#edit_novoucher').val(data[0].novoucher);
        $('#edit_novoucher_hidden').val(data[0].novoucher);
        //$('#edit_tgl_transaksi').val(data[0].tgltransaksi.substr(0,10));
	$('#edit_tgl_entry').val(data[0].tglentry.substr(0,10));
	if(data[0].tutupvoucher!=null){
        	$('#edit_tutup').val(data[0].tutupvoucher.substr(0,10));
	}
	if(data[0].tglvalidasi!=null){
        	$('#edit_tgl_validasi').val(data[0].tglvalidasi.substr(0,10));
	}
	$('#edit_ket').val(data[0].ket);
	$('#edit_flag').val(data[0].deleted).change();
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
        <div class="box-body ">
	
          <div class="col-xs-9">
          </div>

          
          <div class="col-xs-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <a type="button" class="btn btn-primary pull-right" href="<?php echo base_url('akun/crsakun/voucher/'); ?>"><i class="fa fa-plus"> Kode Voucher</i> </a>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->
		
          
          <br/> 
          <br/> 
		<hr>
          <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
				<th>Kode Voucher</th>
                <th>Tgl Entry</th>
				<th>Tutup Voucher</th>
                <th>Tgl Validasi</th>
				<th>Status</th>
              	<th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
				<th>Kode Voucher</th>
                <th>Tgl Entry</th>
				<th>Tutup Voucher</th>
                <th>Tgl Validasi</th>
				<th>Status</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
             
            </tbody>
          </table>

         

	 <?php echo form_open('akun/crsakun/edit_voucher');?>
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Voucher</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Kode Voucher</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_novoucher" id="edit_novoucher" disabled="true">
                      <input type="hidden" class="form-control" name="edit_novoucher_hidden" id="edit_novoucher_hidden">
                    </div>
                  </div>                  
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Tanggal Entry</p>
                    <div class="col-sm-6">
                      	<input type="text" class="form-control date_picker" placeholder="" id="edit_tgl_entry" name="edit_tgl_entry" value="">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_tipe">Tutup Voucher</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control date_picker" placeholder="" id="edit_tutup" name="edit_tutup" value="" disabled readonly>
                    </div>
                  </div>
		  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nb">Tanggal Validasi</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control date_picker" placeholder="" id="edit_tgl_validasi" name="edit_tgl_validasi" value="" disabled readonly>
                    </div>
                  </div>
		  <div class="form-group row">
		    <div class="col-sm-1"></div>
		      <p class="col-sm-3 form-control-label" id="lbl_ket_new">Keterangan</p>
		      <div class="col-sm-6">
		          <textarea id="edit_ket" name="edit_ket" rows="10%" cols="37%" style="color:black !important"></textarea>
		      </div>
		  </div>
		  <!--
		   <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_flag">Status</p>
                    <div class="col-sm-6">
                      <select  class="form-control" style="width: 100%" name="edit_flag" id="edit_flag" required >
				<option value="">-Pilih Status-</option>
				<option value="0">Aktif</option>
				<option value="1">Non Aktif</option>
			</select>
                    </div>
                  </div>
			-->
                </div>
                <div class="modal-footer">
		  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xupdate">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit">Edit voucher</button>
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
