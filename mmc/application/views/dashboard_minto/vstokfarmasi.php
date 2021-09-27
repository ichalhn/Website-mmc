<?php
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else if ($role_id == 37){
    $this->load->view("layout/header_dashboard");
} else {
    $this->load->view("layout/header_horizontal");
}
?>

<script src="<?php echo site_url(); ?>assets/plugins/highcharts/highcharts.js"></script>
<script src="<?php echo site_url(); ?>assets/plugins/highcharts/modules/exporting.js"></script>
<style type="text/css">
    tbody > tr > td {
        border: 2px solid #000;
    }
    .table-bordered td, .table-bordered th {
        border: 1px solid #000;
    }
</style>
<!-- Main content -->
<section class="content">
    <!-- <header class="floating-header">
<div class="floating-menu-btn">
  <div class="floating-menu-toggle-wrap">
    <div class="floating-menu-toggle">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </div>
  </div>
</div>
<div class="main-navigation-wrap">
  <nav class="main-navigation" data-back-btn-text="Back">
    <ul class="menu">
      <li class="delay-1"><a href="<?php echo site_url('dashboard'); ?>">Menu Utama</a></li>
      <li class="delay-1"><a href="<?php echo site_url('Change_password'); ?>">Ganti Password</a></li>
      <li class="delay-2"><a href="<?php echo site_url('logout'); ?>">Logout</a></li>
    </ul>
  </nav>
</div>
</header> -->
    <!-- Main row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="d-flex flex-wrap">
                            <h4 class="card-title">Laporan Stok</h4>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="display nowrap table table-hover table-bordered dataTable" id="example" style="font-size: 14px; border: 2px solid black;" >
                                <thead style="border: 2px solid black;">
                                <tr style="border: 2px solid black;">
                                    <td style="border: 2px solid black; vertical-align: middle;" width="5%"><center>#</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>GUDANG</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>NAMA OBAT</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>SATUAN</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>JUMLAH</center></td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--<div class="col-md-12">
            <div class="card card-outline-primary">
                <div class="card-body chart-responsive">
                    <div class="col-sm-12">
                        <div class="form-inline">
                            <div class="form-group">
                                <input style="width: 100px;" type="text" id="date_picker_awal" class="form-control form-control-sm date_picker_awal" placeholder="Tanggal awal" name="date_picker_awal" onchange="cek_tgl_awal(this.value)" required>&nbsp;
                                <input style="width: 100px;" type="text" id="date_picker_akhir" class="form-control form-control-sm date_picker_akhir" placeholder="Tanggal akhir" name="date_picker_akhir" onchange="cek_tgl_akhir(this.value)" required>&nbsp;
                                <button class="btn btn-primary btn-xs" type="submit" onclick="pilih_poli()"><i class="fa fa-search"></i> Cari</button>
                            </div>
                        </div>
                    </div>
                    <div class="chart" id="container" style="height: 450px;width: 100%;"></div>
                    <div class="overlay" id="overlay">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
    <!-- /.row -->
</section><!-- /.content -->

<script type='text/javascript'>
    var site = "<?php echo site_url();?>";
    $(document).ready(function() {

        $('#date_picker_awal').datepicker({
            format: "yyyy-mm-dd",
            endDate: "current",
            autoclose: true,
            todayHighlight: true,
        });
        $('#date_picker_akhir').datepicker({
            format: "yyyy-mm-dd",
            endDate: "current",
            autoclose: true,
            todayHighlight: true,
        });

        document.getElementById("date_picker_awal").required = true;
        document.getElementById("date_picker_akhir").required = true;

    });

    $(function() {
        objTable = $('#example').DataTable( {
            ajax: "<?php echo site_url('dashboard/data_stok'); ?>",
            columns: [
                { data: "no" },
                { data: "gudang" },
                { data: "obat" },
                { data: "satuan" },
                { data: "qty" }
            ],
            columnDefs: [
                { targets: [ 0 ], visible: true }
            ] ,
            searching: true,
            paging: true,
            bDestroy : true,
            bSort : false,
            "lengthMenu": [[50, 75, 100, -1], [50, 75, 100, "All"]]
        } );
    });
    var intervalSetting = function () {
        var tgl_akhir=document.getElementById("date_picker_akhir").value;
        var tgl_awal=document.getElementById("date_picker_awal").value;
        // if (tgl_akhir!='' && tgl_awal!=''){
        //   pilih_poli();
        // }
        objTable.ajax.reload();
        get_total();
    };
    // setInterval(intervalSetting, 3000);

    function cek_tgl_awal(tgl_awal){
        var tgl_akhir=document.getElementById("date_picker_akhir").value;
        if(tgl_akhir==''){
            //none :D just none
        }else if(tgl_akhir<tgl_awal){
            document.getElementById("date_picker_akhir").value = '';
        }
    }
    function cek_tgl_akhir(tgl_akhir){
        var tgl_awal=document.getElementById("date_picker_awal").value;
        if(tgl_akhir<tgl_awal){
            document.getElementById("date_picker_awal").value = '';
        }
    }
</script>

<?php
if ($role_id == 1) {
    $this->load->view("layout/footer_left");
} else {
    $this->load->view("layout/footer_horizontal");
}
?>