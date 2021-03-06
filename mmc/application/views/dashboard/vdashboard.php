<?php $this->load->view("layout/header"); ?>

<!-- Main content -->
<section class="content">
    <!-- Box 1 -->
    <div class="row">
      <!--<div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?php echo site_url('cdashboard/periodik_pendapatan'); ?>" target="_blank">
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
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?php echo site_url('cdashboard/pendapatan'); ?>" target="_blank">
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-pie-chart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Pendapatan</span>
              <span class="info-box-number">Keseluruhan</span>

              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
                  <span class="progress-description">
                    More info <i class="fa fa-arrow-circle-right"></i>
                  </span>
            </div>
            
          </div>
        </a>
        
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?php echo site_url('cdashboard/poliklinik'); ?>" target="_blank">
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-bar-chart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Seluruh</span>
              <span class="info-box-number">Poliklinik</span>

              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
                  <span class="progress-description">
                    More info <i class="fa fa-arrow-circle-right"></i>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </a>
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?php echo site_url('cdashboard/diagnosa'); ?>" target="_blank">
          <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-area-chart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Top 10</span>
              <span class="info-box-number">Diagnosa</span>

              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
                  <span class="progress-description">
                    More info <i class="fa fa-arrow-circle-right"></i>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </a>
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?php echo site_url('cdashboard/farmasi'); ?>" target="_blank">
          <div class="info-box bg-purple">
            <span class="info-box-icon"><i class="fa fa-line-chart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOP 10</span>
              <span class="info-box-number">Obat</span>

              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
                  <span class="progress-description">
                    More info <i class="fa fa-arrow-circle-right"></i>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
        <!-- /.info-box -->
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?php echo site_url('cdashboard/poli'); ?>" target="_blank">
          <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-line-chart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Per</span>
              <span class="info-box-number">Poliklinik</span>

              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
                  <span class="progress-description">
                    More info <i class="fa fa-arrow-circle-right"></i>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
        <!-- /.info-box -->
      </div>
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?php echo site_url('cdashboard/pasien'); ?>" target="_blank">
          <div class="info-box bg-teal">
            <span class="info-box-icon"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Pasien</span>
              <span class="info-box-number">Range Tgl</span>

              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
                  <span class="progress-description">
                    More info <i class="fa fa-arrow-circle-right"></i>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?php echo site_url('cdashboard/bed'); ?>" target="_blank">
          <div class="info-box bg-pink">
            <span class="info-box-icon"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Status Bed</span>
              <span class="info-box-number">Tempat Tidur</span>

              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
                  <span class="progress-description">
                    More info <i class="fa fa-arrow-circle-right"></i>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
        <!-- /.info-box -->
      </div>

      <div class="col-md-3 col-sm-6 col-xs-12">
        <a href="<?php echo site_url('iri/Ricmonitoring'); ?>" target="_blank">
          <div class="info-box bg-maroon">
            <span class="info-box-icon"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Monitoring</span>
              <span class="info-box-number">Tempat Tidur</span>

              <div class="progress">
                <div class="progress-bar" style="width: 100%"></div>
              </div>
                  <span class="progress-description">
                    More info <i class="fa fa-arrow-circle-right"></i>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </a>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- =========================================================== -->
</section><!-- /.content -->
<?php $this->load->view("layout/footer"); ?>