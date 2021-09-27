<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else if ($role_id == 37){
            $this->load->view("layout/header_dashboard");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?> 

<script type='text/javascript'>
  var site = "<?php echo site_url();?>";
  $(document).ready(function() {

    $('#date_picker').datepicker({
        format: "yyyy",
        endDate: "current",
        autoclose: true,
        todayHighlight: true,
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years",
    }); 
    
    var tgl1 = new Date().getFullYear();
    $('#date_picker').datepicker("setDate", tgl1.toString());
    document.getElementById("date_picker").required = true;
   
  });

  var intervalSetting = function () {
    cek_periodik();
  };
  setInterval(intervalSetting, 300000);
      
  function cek_periodik() {
    var tahun=document.getElementById("date_picker").value;
    $('#poli').html("");
    $('#poli').show();
    $('#overlay').show();
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('Dashboard/get_data_periodik')?>",
      data: {
        tahun : tahun
      },
      success: function(data){
        if(data ==""){
          alert("Data Kosong");
          $('#overlay').hide();
          $('#poli').hide();
        } else {
          var line = new Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'poli',
            data: data,
            xkey: 'y',
            ykeys: ['a', 'b', 'c'],
            labels: [ tahun-2 , tahun-1 ,tahun],
            lineColors: ['#37619d', '#22aa22','#ff4400'],
            parseTime: false
          });
          $('#overlay').hide();
        }
      },
      error: function(){
        alert("error");
      }
    });
    
  }
</script>

<!-- Main content -->
<section class="content">
<header class="floating-header"> 
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
  </header>
  <!-- Main row -->
  <div class="row">
    <div class="col-md-12">
      <!-- AREA CHART -->
      <div class="card card-outline-primary">
        <div class="card-block chart-responsive">
          <div class='chart' id='poli' style='height: 450px;width: 100%;'></div>
          <div class="overlay" id="overlay">
            <i class="fa fa-refresh fa-spin"></i>
          </div>
        </div>
        <div class="card-footer">
          <p class="col-sm-2">Cari Data</p>
          <div class="col-sm-10">
            <div class="form-inline">
              <div class="form-group">
                <input type="text" id="date_picker" class="form-control date_picker" placeholder="Tanggal awal" name="date_picker" required>
                <button class="btn btn-primary" type="submit" onclick="cek_periodik()">Cari</button>
              </div>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
  <!-- /.row -->
</section><!-- /.content -->


<?php //include('script_json.php'); ?>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>