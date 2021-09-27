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
      <div class="card">
        <div class="card-body chart-responsive">
          <!-- <h6 class="card-subtitle">Cari Data</h6> -->
          <div class="col-md-12">
            <div class="d-flex flex-wrap">                
                  <div class="form-group">
                    <input style="width: 100px;" type="text" id="date_picker_awal" class="form-control form-control-sm date_picker_awal" placeholder="Tanggal awal" name="date_picker_awal" onchange="cek_tgl_awal(this.value)" required>&nbsp;
                    <input style="width: 100px;" type="text" id="date_picker_akhir" class="form-control form-control-sm date_picker_akhir" placeholder="Tanggal akhir" name="date_picker_akhir" onchange="cek_tgl_akhir(this.value)" required>&nbsp;
                    <button class="btn btn-primary btn-xs" type="submit" onclick="pilih_tgl()"><i class="fa fa-search"></i> Cari</button>
                  </div>                
                <div class="ml-auto">
                  <h4 class="vtot-heading" id="vtot" style="text-align: right"></h4>
                </div>
            </div>
          </div>
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="display nowrap table table-hover table-bordered dataTable" id="example" style="font-size: 14px; border: 2px solid black;" >
                    <thead style="border: 2px solid black;">
                        <tr style="border: 2px solid black;">
                            <td style="border: 2px solid black; vertical-align: middle;"><center>#</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>Yanmasum</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>BPJS</td</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>Kerjasama</center></td>
                        </tr>
                    </thead>
                </table>              
              </div>
            </div>
          <div class="col-md-12">            
            <!-- <div class="chart" id="data-pendapatan" style="height: 450px;width: 100%;"></div> -->
            <!-- <div class="chart" id="container" style="height: 450px;width: 100%;"></div> -->
            <!-- <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div> -->
            <!-- <div class="overlay" id="overlay">
              <i class="fa fa-refresh fa-spin"></i>
            </div> -->
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

    var firstMonth = currYear + "-" + currMonth + "-" + 01;
    var endMonth = currYear + "-" + currMonth + "-" + currDate;

    $('#date_picker_awal').datepicker("setDate", firstMonth);
    $('#date_picker_akhir').datepicker("setDate", "0");

    // $('#overlay').hide();
    // $('#data-pendapatan').hide();

      // Radialize the colors
      Highcharts.setOptions({
          lang: {
              thousandsSep: '.'
          },
          colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
              return {
                  radialGradient: {
                      cx: 0.5,
                      cy: 0.3,
                      r: 1
                  },
                  stops: [
                      [0, color],
                      [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                  ]
              };
          })
      });
      pilih_tgl();

  });

  // var intervalSetting = function () {
  //   var tgl_akhir=document.getElementById("date_picker_akhir").value;
  //   var tgl_awal=document.getElementById("date_picker_awal").value;
  //   if (tgl_akhir!='' && tgl_awal!=''){
  //     pilih_tgl();
  //   }
  // };
  // setInterval(intervalSetting, 30000);

  function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
      prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
      sep = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep,
      dec = (typeof dec_point === 'undefined') ? ',' : dec_point,
      s = '',
      toFixedFix = function (n, prec) {
        var k = Math.pow(10, prec);
        return '' + Math.round(n * k) / k;
      };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
      s[1] = s[1] || '';
      s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
  }

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
      
  function pilih_tgl() {
    var tgl_akhir=document.getElementById("date_picker_akhir").value;
    var tgl_awal=document.getElementById("date_picker_awal").value;
    if(tgl_awal!="" && tgl_akhir!=""){
      $('#data-pendapatan').html("");
      $('#data-pendapatan').show();
      $('#overlay').show();
      //VTOT
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('Dashboard/get_data_vtot')?>",
        data: {
          tgl_akhir : tgl_akhir,
          tgl_awal : tgl_awal
        },
        success: function(data){
          var a = number_format(data, 2);
          $("#vtot").val(a);
          document.getElementById("vtot").innerHTML = "Total Pendapatan Rp."+a;
        },
        error: function(){
          alert("error");
        }
      });
      //PIE
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('Dashboard/get_data_pendapatan')?>",
        data: {
          tgl_akhir : tgl_akhir,
          tgl_awal : tgl_awal
        },
        success: function(data){
          if(data ==""){
            alert("Data Kosong");
            $('#overlay').hide();
            $('#data-pendapatan').hide();
          } else {
            var seriesArr = [];
              $.each(data, function(key, data) {
                var series = {name : key, data : []};

                $.each(data.y, function(index, value) {
                  series.data.push({y: value });
                });
                seriesArr.push(series);
              });
              console.log(seriesArr);

            // Create the chart
            // Highcharts.chart('container', {
            //     chart: {
            //         type: 'column'
            //     },
            //     title: {
            //         text: ''
            //     },
            //     subtitle: {
            //         text: ''
            //     },
            //     xAxis: {
            //         type: 'category'
            //     },
            //     yAxis: {
            //         title: {
            //             text: 'Total Pendapatan'
            //         }

            //     },
            //     legend: {
            //         enabled: false
            //     },
            //     plotOptions: {
            //         series: {
            //             borderWidth: 0,
            //             dataLabels: {
            //                 enabled: true,
            //                 formatter: function () {
            //                     return 'Rp. ' + Highcharts.numberFormat(this.y, 0,',','.');
            //                 }
            //             }
            //         }
            //     },

            //     tooltip: {
            //         headerFormat: '<span style="font-size:11px"><b>{series.name}</b></span><br>',
            //         pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> Rupiah<br/>'
            //     },

            //     series: [{
            //         name: 'Instalasi',
            //         colorByPoint: true,
            //         data: data
            //     }]
            // });
            
            
            // Highcharts.chart('container', {
            //   chart: {
            //     type: 'column'
            //   },
            //   title: {
            //     text: 'Pendapatan Rumah Sakit'
            //   },
            //   xAxis: {
            //     categories: [
            //       'rajal',
            //       'radar',
            //       'ranap',
            //       'penunjang'
            //     ],
            //     crosshair: true
            //   },
            //   yAxis: {
            //     min: 0,
            //     title: {
            //       text: 'Penapatan (Rp)'
            //     }
            //   },
            //   tooltip: {
            //     headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            //     pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            //       '<td style="padding:0"><b>Rp. {point.y:.1f}</b></td></tr>',
            //     footerFormat: '</table>',
            //     shared: true,
            //     useHTML: true
            //   },
            //   plotOptions: {
            //     column: {
            //       pointPadding: 0.2,
            //       borderWidth: 0
            //     }
            //   },
            //   series: seriesArr
            // });

            $('#overlay').hide();

          }
        },
        error: function(){
          alert("error");
        }
      });

      objTable = $('#example').DataTable( {
        ajax: "<?php echo site_url('dashboard/pendapatan_keseluruhan'); ?>/"+tgl_awal+"/"+tgl_akhir,
        columns: [
          { data: [0] },
          { data: [1] },
          { data: [2] },
          { data: [3] }
        ],
        columnDefs: [
          { targets: [ 0 ], visible: true }
        ] ,
        searching: false, 
        paging: false,
        bDestroy : true,
        bSort : false
      } );
    } else {
      alert("Pilih Tanggal Dulu");
    }
  }
      
  function show() {
    var tgl_akhir=document.getElementById("date_picker_akhir").value;
    var tgl_awal=document.getElementById("date_picker_awal").value;
    if(tgl_awal!="" && tgl_akhir!=""){
      $('#data-pendapatan').html("");
      $('#data-pendapatan').show();
      $('#overlay').show();
      //VTOT
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('Dashboard/get_data_vtot')?>",
        data: {
          tgl_akhir : tgl_akhir,
          tgl_awal : tgl_awal
        },
        success: function(data){
          var a = number_format(data, 2);
          $("#vtot").val(a);
          document.getElementById("vtot").innerHTML = "Total Pendapatan Rp."+a;
        },
        error: function(){
          alert("error");
        }
      });
      //PIE
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('Dashboard/get_data_pendapatan')?>",
        data: {
          tgl_akhir : tgl_akhir,
          tgl_awal : tgl_awal
        },
        success: function(data){
          if(data ==""){
            alert("Data Kosong");
            $('#overlay').hide();
            $('#data-pendapatan').hide();
          } else {
            var donut = new Morris.Donut({
                  // ID of the element in which to draw the chart.
                  element: 'data-pendapatan',
                  //color.
                  colors: ['#247BA0','#70C1B3','#434F12','#4E6054','#FF1654','#FFE016'],
                  // the chart.
                  data: data,
                  
                  hideHover: 'auto'
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
</script>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>