<?php 
$this->load->view('layout/header.php'); ?>

<br>
<section class="content" style="width:97%;margin:0 auto">
	<div class="row">
<?php echo $this->session->flashdata('success_msg'); ?> <!-- content-header -->  
    <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Setting Cons ID Production</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="<?php echo base_url(); ?>master/konfigurasi_bpjs/update_bpjs">
              <div class="box-body">
                <div class="form-group">
                  <label for="service_url">Service URL</label>
                  <input class="form-control" id="service_url" name="service_url" type="text" value="<?php echo $data->service_url; ?>">
                </div>              
                <div class="form-group">
                  <label for="consid">Cons ID</label>
                  <input class="form-control" id="consid" name="consid" type="text" value="<?php echo $data->consid; ?>">
                </div>
                <div class="form-group">
                  <label for="secid">Sec ID</label>
                  <input class="form-control" id="secid" name="secid" type="text" value="<?php echo $data->secid; ?>">
                </div>
                <div class="form-group">
                  <label for="rsid">RS ID</label>
                  <input class="form-control" id="rsid" name="rsid" type="text" value="<?php echo $data->rsid; ?>">
                </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Simpan</button>
              </div>
            </form>
          </div>
          <!-- /.box -->



        </div> <!-- col-md-12 -->

</div>
</section>