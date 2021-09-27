<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else if ($role_id == 37){
            $this->load->view("layout/header_dashboard");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?>
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
                <h4 class="card-title">URIKES</h4>
                <!-- <h6 class="card-subtitle">Total Pasien Hari ini </h6>           
                <div class="ml-auto">
                  <h4 class="dashboard-heading">Total Pasien : <b id="total_pasien"></b></h4>
                </div> -->   
            </div>
          </div>
          <div class="col-md-12">
              <div class="form-inline">
                <div class="form-group">
                  <input style="width: 100px;" type="text" id="date_picker_awal" class="form-control form-control-sm date_picker_awal" placeholder="Tanggal awal" name="date_picker_awal" onchange="cek_tgl_awal(this.value)" required>&nbsp;
                  <input style="width: 100px;" type="text" id="date_picker_akhir" class="form-control form-control-sm date_picker_akhir" placeholder="Tanggal akhir" name="date_picker_akhir" onchange="cek_tgl_akhir(this.value)" required>&nbsp;
                  <button class="btn btn-primary btn-xs" type="submit" onclick="pilih_poli()"><i class="fa fa-search"></i> Cari</button>
                </div>
              </div>
            </div>
          <div class="col-md-12">
            <!-- <h4 class="card-title"><center>Ruangan Rawat Inap</center></h4>
            <h6 class="card-subtitle">Total Pasien Hari ini </h6> -->

            <div class="table-responsive">
             <table class="display nowrap table table-hover table-bordered dataTable" id="example" style="font-size: 14px; border: 2px solid black;" >
                                <thead style="border: 2px solid black;">
                                <tr style="border: 2px solid black;">
                                    <td style="border: 2px solid black; vertical-align: middle;" width="5%"><center>#</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>TGL PERIKSA</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>NAMA PASIEN</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>UMUR</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>NRP/NIP</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>PANGKAT</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>KESATUAN</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>U</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>A</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>B</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>D</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>L</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>G</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>J</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>STATKES</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>Catatan</center></td>
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

  });

   $(function() {
    var date1=document.getElementById("date_picker_akhir").value;
    var date2=document.getElementById("date_picker_awal").value;
        objTable = $('#example').DataTable( {
            ajax: "<?php echo site_url('dashboard/data_pasien_urikes'); ?>",
            data: {
              tgl_akhir : date1,
              tgl_awal : date2
                },
            columns: [
                { data: "no" },
                { data: "tgl_kunjungan" },
                { data: "nama" },
                { data: "umur" },
                { data: "nip" },
                { data: "pangkat" },
                { data: "kesatuan" },
                { data: "sf_umum" },
                { data: "sf_atas" },
                { data: "sf_bawah" },
                { data: "sf_dengar" },
                { data: "sf_lihat" },
                { data: "sf_gigi" },
                { data: "sf_jiwa" },
                { data: "statkes" },
                { data: "catatan" }
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

   function pilih_poli() {
    var date2=document.getElementById("date_picker_akhir").value;
    var date1=document.getElementById("date_picker_awal").value;
        objTable = $('#example').DataTable( {
            ajax: "<?php echo site_url('dashboard/data_pasien_urikes'); ?>/"+date1+"/"+date2,
            columns: [
                { data: "no" },
                { data: "tgl_kunjungan" },
                { data: "nama" },
                { data: "umur" },
                { data: "nip" },
                { data: "pangkat" },
                { data: "kesatuan" },
                { data: "sf_umum" },
                { data: "sf_atas" },
                { data: "sf_bawah" },
                { data: "sf_dengar" },
                { data: "sf_lihat" },
                { data: "sf_gigi" },
                { data: "sf_jiwa" },
                { data: "statkes" },
                { data: "catatan" }
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
    }

</script>

<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>