<?php $this->load->view("layout/header"); ?>
<!-- Main content -->
<section class="content">
  <!-- Main row -->
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-success">
        <div class="panel-heading" align="center" ><h4>Ruangan Rawat Inap</h4></div>
          <div class="panel-body">
            
            <!-- <h6 class="card-subtitle">Total Pasien Hari ini </h6> -->
            <div class="table-responsive">
              <table class="display nowrap table table-hover table-striped table-bordered dataTable" id="example" style="font-size: 14px">
                  <thead>
                      <tr>
                          <td>#</td>
                          <td>KELAS</td>
                          <td>RUANG</td>
                          <td>KAPASITAS</td>
                          <td>ISI</td>
                          <td>KOSONG</td>
                      </tr>
                  </thead>
              </table>
              
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
  <!-- /.row -->
</section><!-- /.content -->

<script type='text/javascript'>
  var site = "<?php echo site_url();?>";
  $(document).ready(function() {

  });

  $(function() {
    objTable = $('#example').DataTable( {
        ajax: "<?php echo site_url('cdashboard/data_bed'); ?>",
        columns: [
          { data: "rank" },
          { data: "kelas" },
          { data: "nmruang" },
          { data: "bed_kapasitas_real" },
          { data: "bed_isi" },
          { data: "bed_kosong" }
        ],
        columnDefs: [
          { targets: [ 0 ], visible: true }
        ] ,
        searching: false, 
        paging: false,
        bDestroy : true,
        dom : 'Bfrtip',
          buttons: [
          'pageLength','copy', 'excel', 'pdf', 'print'
          ]
      } );
  });
  var intervalSetting = function () {
    objTable.ajax.reload();
  };
  setInterval(intervalSetting, 10000);

</script>
<?php $this->load->view("layout/footer"); ?>
