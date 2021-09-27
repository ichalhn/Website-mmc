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
          <!-- <p class="col-sm-2">Cari Data</p> -->
          <div class="col-sm-12">
            <div class="form-inline">
              <div class="form-group">
                <input style="width: 100px;" type="text" id="date_picker_awal" class="form-control form-control-sm date_picker_awal" placeholder="Tanggal awal" name="date_picker_awal" onchange="cek_tgl_awal(this.value)" required>&nbsp;
                <input style="width: 100px;" type="text" id="date_picker_akhir" class="form-control form-control-sm date_picker_akhir" placeholder="Tanggal akhir" name="date_picker_akhir" onchange="cek_tgl_akhir(this.value)" required>&nbsp;
                <select name="id_poli" id="id_poli" class="form-control form-control-sm">
                  <option value="" disabled selected="">-Pilih Poliklinik-</option>
                  <?php 
                    foreach($pilihpoli as $row){
                      echo '<option value="'.$row->id_poli.'">'.$row->nm_poli.'</option>';
                    }
                  ?>
                </select>
                <button class="btn btn-primary btn-xs" type="submit" onclick="pilih_poli()">Cari</button>&nbsp;
                <!-- <button class="btn btn-primary" type="submit" onclick="download_excel()">Download Excel</button> -->
              </div>
            </div>
          </div>
        </div>
        <div class="card-block chart-responsive">
          <!-- <div hidden class="chart" id="rawat" style="height: 450px;width: 100%;"></div> -->
          <div class="col-sm-12">
            <div class="chart" id="container1" style="height: 450px;width: 100%;"></div>
          </div>
          <div hidden class="overlay" id="overlay">
            <i class="fa fa-refresh fa-spin"></i>
          </div>
        </div>        
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
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

    document.getElementById("date_picker_awal").required = true;
    document.getElementById("date_picker_akhir").required = true;
    //date
    var d = new Date();
    var currDate = d.getDate();
    var currMonth = d.getMonth()+1;
    var currYear = d.getFullYear();

    var firstMonth = currYear + "-" + currMonth + "-" + 01;

    $('#date_picker_awal').datepicker("setDate", firstMonth);
    $('#date_picker_akhir').datepicker("setDate", "0");

     // Radialize the colors
      Highcharts.setOptions({
          colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
              return {
                  radialGradient: {
                      cx: 0.5,
                      cy: 0.3,
                      r: 0.7
                  },
                  stops: [
                      [0, color],
                      [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                  ]
              };
          })
      });
      // pilih_poli();
  });

  // var intervalSetting = function () {
  //   var tgl_akhir=document.getElementById("date_picker_akhir").value;
  //   var tgl_awal=document.getElementById("date_picker_awal").value;
  //   if (tgl_akhir!='' && tgl_awal!=''){
  //     pilih_poli();
  //   }
  // };
  // setInterval(intervalSetting, 30000);

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
      
  function pilih_poli() {
    // var id_rawat=document.getElementById("id_rawat").value;
    var tgl_akhir=document.getElementById("date_picker_akhir").value;
    var tgl_awal=document.getElementById("date_picker_awal").value;
    var id_poli=document.getElementById("id_poli").value;
    if(tgl_awal!="" && tgl_akhir!=""){
      $('#container1').html("");
      $('#container1').show();
      $('#container2').html("");
      $('#container2').show();
      $('#container3').html("");
      $('#container3').show();
      $('#overlay').show();
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('Dashboard/get_data_kunjungan_perhari')?>",
        data: {
          tgl_akhir : tgl_akhir,
          tgl_awal : tgl_awal,
          id_poli : id_poli
        },
        success: function(data){
          if(data ==""){
            alert("Data Kosong");
            $('#overlay').hide();
            $('#container1').hide();
          } else {


            // Create the chart
            Highcharts.chart('container1', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: ''
                },
                subtitle: {
                    text: ''
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Diagnosa Rawat Jalan'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    line: {
                        borderWidth: 1,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> Pasien<br/>'
                },

                series: [{
                    name: 'Pasien',
                    data: data
                }]
            });

            $('#overlay').hide();
          }
        },
        error: function(){
          alert("error");
        }
      });
    } else {
      alert("Pilih Tanggal Dulu");
    }
  }

  function download_excel() {
    var akhir=document.getElementById("date_picker_akhir").value;
    var awal=document.getElementById("date_picker_awal").value;
    if(awal!="" && akhir!=""){
      window.location.href = "<?php echo base_url('Dashboard/export_excel')?>/"+awal+"/"+akhir;
    } else {
      alert("Pilih Data Terlebih Dahulu.");
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