    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else if ($role_id == 37) {
            $this->load->view("layout/header_dashboard");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?> 

<!-- Main content -->
<section class="content">
    <!-- Box 1 -->
    <div class="row">
      <!--<div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?php //echo site_url('Dashboard/periodik_pendapatan'); ?>">
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-pie-chart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Periodik</span>
              <span class="info-box-number">Pendapatan</span>

              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
                  <span class="progress-description">
                    More info <i class="fa fa-arrow-circle-right"></i>
                  </span>
            </div>
             
          </div>
        </a>
      </div>-->
      <!-- /.col -->
      <div class="col-6 col-sm-6 col-md-6 col-lg-3">
        <a href="<?php echo site_url('Dashboard/pendapatan'); ?>">
          <div class="card">
            <div class="card-block p-10">
              <h5 class="font-medium m-0 text-center">Pendapatan Keseluruhan</h5>                                     
            </div>
          </div>
        </a>
      </div>

      <!-- /.col -->
      <div class="col-6 col-sm-6 col-md-6 col-lg-3">
      <a href="<?php echo site_url('Dashboard/poliklinik'); ?>">
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <div class="social-widget">
                        <div class="soc-header box-twitter"><i class="fa fa-bar-chart "></i></div>
                        <div class="soc-content">
                            <div class="col-md-12 b-r">
                                <h3 class="text-muted">Seluruh</h3>
                                <h5 class="font-medium">Poliklinik</h5>
                                <span class="progress-description">
                                  More info <i class="fa fa-arrow-circle-right"></i>
                                </span>
                            </div>
                            <!--<div class="col-6">
                                <span class="progress-description">
                                  More info <i class="fa fa-arrow-circle-right"></i>
                                </span>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </a>
        <a href="<?php echo site_url('Dashboard/poliklinik'); ?>">
          <div class="card">
            <div class="card-block p-10">
              <h5 class="font-medium m-0 text-center">Pendapatan Keseluruhan</h5>                                     
            </div>
          </div>
        </a>
      </div>

      <!-- /.col -->
      <div class="col-6 col-sm-6 col-md-6 col-lg-3">
      <a href="<?php echo site_url('Dashboard/diagnosa'); ?>">
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <div class="social-widget">
                        <div class="soc-header box-google"><i class="fa fa-area-chart "></i></div>
                        <div class="soc-content">
                            <div class="col-md-12 b-r">
                                <h3 class="text-muted">Top 10</h3>
                                <h5 class="font-medium">Diagnosa</h5>
                                <span class="progress-description">
                                  More info <i class="fa fa-arrow-circle-right"></i>
                                </span>
                            </div>
                            <!--<div class="col-6">
                                <span class="progress-description">
                                  More info <i class="fa fa-arrow-circle-right"></i>
                                </span>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </a>
      </div>

      <!-- /.col -->
      <div class="col-6 col-sm-6 col-md-6 col-lg-3">
       <a href="<?php echo site_url('Dashboard/farmasi'); ?>">
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <div class="social-widget">
                        <div class="soc-header box-linkedin"><i class="fa fa-line-chart "></i></div>
                        <div class="soc-content">
                            <div class="col-md-12 b-r">
                                <h3 class="text-muted">Top 10</h3>
                                <h5 class="font-medium">Obat</h5>
                                <span class="progress-description">
                                  More info <i class="fa fa-arrow-circle-right"></i>
                                </span>
                            </div>
                            <!--<div class="col-6">
                                <span class="progress-description">
                                  More info <i class="fa fa-arrow-circle-right"></i>
                                </span>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </a>
      </div>

      <!-- /.col -->
      <div class="col-6 col-sm-6 col-md-6 col-lg-3">
       <a href="<?php echo site_url('Dashboard/poli'); ?>">
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <div class="social-widget">
                        <div class="soc-header box-google"><i class="fa fa-line-chart "></i></div>
                        <div class="soc-content">
                            <div class="col-md-12 b-r">
                                <h3 class="text-muted">Per</h3>
                                <h5 class="font-medium">Poliklinik</h5>
                                <span class="progress-description">
                                  More info <i class="fa fa-arrow-circle-right"></i>
                                </span>
                            </div>
                            <!--<div class="col-6">
                                <span class="progress-description">
                                  More info <i class="fa fa-arrow-circle-right"></i>
                                </span>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </a>
      </div>

      <!-- /.col -->
      <div class="col-6 col-sm-6 col-md-6 col-lg-3">
       <a href="<?php echo site_url('Dashboard/pasien'); ?>">
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <div class="social-widget">
                        <div class="soc-header box-linkedin"><i class="fa fa-user "></i></div>
                        <div class="soc-content">
                            <div class="col-md-12 b-r">
                                <h3 class="text-muted">Pasien</h3>
                                <h5 class="font-medium">Range Tanggal</h5>
                                <span class="progress-description">
                                  More info <i class="fa fa-arrow-circle-right"></i>
                                </span>
                            </div>
                            <!--<div class="col-6">
                                <span class="progress-description">
                                  More info <i class="fa fa-arrow-circle-right"></i>
                                </span>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </a>
      </div>

     
      <!-- /.col -->
      <div class="col-6 col-sm-6 col-md-6 col-lg-3">
       <a href="<?php echo site_url('dashboard/bed'); ?>">
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <div class="social-widget">
                        <div class="soc-header box-twitter"><i class="fa fa-user "></i></div>
                        <div class="soc-content">
                            <div class="col-md-12 b-r">
                                <h3 class="text-muted">Monitoring</h3>
                                <h5 class="font-medium">Tempat Tidur</h5>
                                <span class="progress-description">
                                  More info <i class="fa fa-arrow-circle-right"></i>
                                </span>
                            </div>
                            <!--<div class="col-6">
                                <span class="progress-description">
                                  More info <i class="fa fa-arrow-circle-right"></i>
                                </span>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </a>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- =========================================================== -->
</section><!-- /.content -->
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 