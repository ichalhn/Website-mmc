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
                  <h4 class="card-title">Radiologi</h4>
                  <!-- <h6 class="card-subtitle">Total Pasien Hari ini </h6> -->              
                  <!-- <div class="ml-auto">
                    <h4 class="dashboard-heading">Total Pasien : <b id="total_pasien"></b></h4>
                  </div> -->
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-inline">
                <div class="form-group">
                  <input style="width: 100px;" type="text" id="date_picker_awal" class="form-control form-control-sm date_picker_awal" placeholder="Tanggal awal" name="date_picker_awal" onchange="cek_tgl_awal(this.value)" required>&nbsp;
                  <input style="width: 100px;" type="text" id="date_picker_akhir" class="form-control form-control-sm date_picker_akhir" placeholder="Tanggal akhir" name="date_picker_akhir" onchange="cek_tgl_akhir(this.value)" required>&nbsp;
                  <button class="btn btn-primary btn-xs" type="submit" onclick="pilih_rad()"><i class="fa fa-search"></i> Cari</button>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="display nowrap table table-hover table-bordered dataTable" id="example" style="font-size: 14px; border: 2px solid black;" >
                    <thead style="border: 2px solid black;">
                        <tr style="border: 2px solid black;">
                            <td style="border: 2px solid black; vertical-align: middle;"><center>#</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>NO RAD</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>NO REGISTER</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>NO RM</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>TGL KUNJUNGAN</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>NAMA</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>PEMERIKSAAN</center></td>
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

    document.getElementById("date_picker_awal").required = true;
    document.getElementById("date_picker_akhir").required = true;
    //date
    var d = new Date();
    var currDate = d.getDate();
    var currMonth = d.getMonth()+1;
    var currYear = d.getFullYear();

    // var firstMonth = currYear + "-" + currMonth + "-" + 01;

    // $('#date_picker_awal').datepicker("setDate", firstMonth);
    $('#date_picker_awal').datepicker("setDate", "0");
    $('#date_picker_akhir').datepicker("setDate", "0");

    $('#overlay').hide();
    // $('#kun-poli').hide();
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
    pilih_rad();
    // get_total();
  });

  $(function() {
    
  });
  var intervalSetting = function () {
    var tgl_akhir=document.getElementById("date_picker_akhir").value;
    var tgl_awal=document.getElementById("date_picker_awal").value;
    // if (tgl_akhir!='' && tgl_awal!=''){
    //   pilih_rad();
    // }
    objTable.ajax.reload();
    // get_total();
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
      
  function pilih_rad() {
    var tgl_akhir=document.getElementById("date_picker_akhir").value;
    var tgl_awal=document.getElementById("date_picker_awal").value;
    if(tgl_awal!="" && tgl_akhir!=""){
      // $('#kun-poli').html("");
      // $('#kun-poli').show();
      $('#overlay').show();
      // $.ajax({
      //   type:'POST',
      //   dataType: 'json',
      //   url:"<?php echo base_url('Dashboard/get_data_kunjungan')?>",
      //   data: {
      //     tgl_akhir : tgl_akhir,
      //     tgl_awal : tgl_awal
      //   },
      //   success: function(data){
      //     if(data ==""){
      //       alert("Data Kosong");
      //       $('#overlay').hide();
      //       // $('#kun-poli').hide();
      //     } else {

      //       Highcharts.chart('container', {
      //           chart: {
      //               type: 'column'
      //           },
      //           title: {
      //               text: ''
      //           },
      //           subtitle: {
      //               text: ''
      //           },
      //           xAxis: {
      //               type: 'category'
      //           },
      //           yAxis: {
      //               title: {
      //                   text: 'Total Pasien'
      //               }

      //           },
      //           legend: {
      //               enabled: false
      //           },
      //           plotOptions: {
      //               series: {
      //                   borderWidth: 0,
      //                   dataLabels: {
      //                       enabled: true,
      //                       format: '{point.y}'
      //                   }
      //               }
      //           },

      //           tooltip: {
      //               headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
      //               pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> Orang<br/>'
      //           },

      //           series: [{
      //               name: 'Poliklinik',
      //               colorByPoint: true,
      //               data: data
      //           }]
      //       });


      //       $('#overlay').hide();
      //     }
      //   },
      //   error: function(){
      //     alert("error");
      //   }
      // });

      objTable = $('#example').DataTable( {
        ajax: "<?php echo site_url('dashboard/kunj_rad'); ?>/"+tgl_awal+"/"+tgl_akhir,
        columns: [
          { data: "rank" },
          { data: "no_rad" },
          { data: "no_register" },
          { data: "no_cm" },
          { data: "tgl_kunjungan" },
          { data: "nama" },
          { data: "tindakan" }
        ],
        columnDefs: [
          { targets: [ 0 ], visible: true }
        ] ,
        searching: false, 
        paging: false,
        bDestroy : true,
        bSort : false
      } );
    }else{
      alert("Pilih Tanggal Dulu");
    }
    
  }
      
  // function get_total() {
  //   $.ajax({
  //     type:'POST',
  //     dataType: 'json',
  //     url:"<?php echo base_url('Dashboard/get_total_kunjungan_poli')?>",
  //     success: function(data){
  //         document.getElementById("total_pasien").innerHTML = data.total_pasien;
  //     },
  //     error: function(){
  //       alert("error");
  //     }
  //   });
  // }
</script>

<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>