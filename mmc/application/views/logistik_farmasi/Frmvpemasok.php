<?php $this->load->view('layout/header.php');?>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    $('#examplee').DataTable();
    $(".js-example-basic-single").select2();
  } );

  $(function() {
  $('#date_picker').datepicker({
  		format: "yyyy-mm-dd",

  		autoclose: true,
  		todayHighlight: true,
  	});

  });



	</script>


<section class="content-header">
	<?php echo $this->session->flashdata('success_msg');?>
</section>

<div class="panel-body" style="width:100%">
      <div class="col-md-16">
      <div class="panel panel-default">
        <div class="panel-heading">Daftar Pemasok</div>
          <div class="panel-body">
            <form action="http://localhost/hmis/logistik_farmasi/Frmcpemasok/insert_supplier" method="post" accept-charset="utf-8">
              <div class="col-md-1">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#myModal">Tambah Supplier</button>
                  </span>
                </div>
              </div>

              <div class="modal fade" id="myModal" role="dialog" aria-hidden="true" style="display: none;" data-keyboard="false" data-backdrop="static">
                <div class="modal-dialog modal-success">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button class="close" type="button" data-dismiss="modal">×</button>
                      <h4 class="modal-title">Tambah Pemasok Baru</h4>
                    </div>
                    <div class="modal-body">
                      <div class="form-group row">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Supplier Id</p>
                        <div class="col-sm-6">
                          <input name="person_id" class="form-control" id="person_id" type="text">
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Nama Supplier</p>
                        <div class="col-sm-6">
                          <input name="company_name" class="form-control" id="company_name" type="text">
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label" id="lbl_account">Account Number</p>
                        <div class="col-sm-6">
                          <input name="account_number" class="form-control" id="account_number" type="text">
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label" id="lbl_adress">No Telepon</p>
                        <div class="col-sm-6">
                          <input name="phone" class="form-control" id="phone" type="text">
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label" id="lbl_adress">Alamat Supplier</p>
                        <div class="col-sm-6">
                          <input name="adress" class="form-control" id="adress" type="text">
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label" id="lbl_zip">Kode Pos</p>
                        <div class="col-sm-6">
                          <input name="zip_code" class="form-control" id="zip_code" type="text">
                        </div>
                      </div>

                    </div>

                    <div class="modal-footer">
                      <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
                      <button class="btn btn-primary" type="submit">Submit</button>
                    </div>

                  </div>
                </div>
              </div>


            </form>
                <table id=examplee class="display"cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>no</th>
                      <th>Supplier ID</th>
                      <th>Nama Supplier</th>
                      <th>Account Number</th>
                      <th>Alamat</th>
                    </tr>
                  </thead>
                  <tfoot>
                  <tbody id=bodyt>
                    <?php
                        $i=1;
                        foreach($select_pemasok as $row){
                    ?>
                    <tr>
                      <td><?php echo $i++;?></td>
                      <td><?php echo $row->person_id;?></td>
                      <td><?php echo $row->company_name;?></td>
                      <td><?php echo $row->account_number;?></td>
                      <td><?php echo $row->adress;?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
          </div>
        </div>
      </div>
  </div>

<?php $this->load->view('layout/footer.php');?>
