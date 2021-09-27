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
            <div class="col-md-12">
                <!-- AREA CHART -->
                <div class="card card-outline-primary">
                    <div class="card-footer">
                        <div class="col-sm-10">
                            <div class="form-inline">
                                <div class="form-group">
                                    <input style="width: 100px;" type="text" id="date_picker_awal" class="form-control form-control-sm date_picker_awal" placeholder="Tanggal awal" name="date_picker_awal" onchange="cek_tgl_awal(this.value)" required>&nbsp;
                                    <input style="width: 100px;" type="text" id="date_picker_akhir" class="form-control form-control-sm date_picker_akhir" placeholder="Tanggal akhir" name="date_picker_akhir" onchange="cek_tgl_akhir(this.value)" required>&nbsp;
                                    <button class="btn btn-primary btn-xs" type="submit" onclick="pilih_obat()">Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-block chart-responsive">
                        <!-- <p class="col-sm-2">Cari Data</p> -->
                        <!-- <div class="chart" id="obat" style="height: 450px;width: 100%;"></div> -->
                        <div class="table-responsive">
                        <table class="display nowrap table table-hover table-bordered dataTable" id="example" style="font-size: 14px; border: 2px solid black;" >
                            <thead style="border: 2px solid black;">
                            <tr style="border: 2px solid black;">
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">No</td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">No Faktur</td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">Tanggal</td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">Supplier</td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">Jatuh Tempo</td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">Total</td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">Aksi</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 0; $total = 0;
                            foreach ($pembelian as $row){
                                $no++; $total += $row->total_obat;
                                ?>
                                <tr>
                                    <td><?=$no?></td>
                                    <td><?=$row->no_faktur?></td>
                                    <td><?=$row->tgl_faktur?></td>
                                    <td><?=$row->company_name?></td>
                                    <td><?=$row->jatuh_tempo?></td>
                                    <td align="right"><?=number_format($row->total_obat, '0',',', '.')?></td>
                                    <td align="center"><button type="button" class="btn btn-danger"><i class="fa fa-search"></i> Detail</button></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="5"><h3>TOTAL</h3></td>
                                <td colspan="2" align="right"><h3>Rp. <?=number_format($total, '0',',', '.')?></h3></td>
                            </tr>
                            </tbody>
                        </table>
                        </div>

                        <div class="overlay" id="overlay">
                            <!--<i class="fa fa-refresh fa-spin"></i>-->
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->

    </section><!-- /.content -->
<?php
if ($role_id == 1) {
    $this->load->view("layout/footer_left");
} else {
    $this->load->view("layout/footer_horizontal");
}
?>