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
  <!-- Main row -->
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body chart-responsive">
          <!-- <h6 class="card-subtitle">Cari Data</h6> -->
          <div class="col-md-12">
            <div class="d-flex flex-wrap">                
                  <div class="form-group">
                    <input style="width: 100px;" type="text" id="date_picker_bln" class="form-control form-control-sm date_picker_bln" placeholder="Bulan" name="date_picker_bln" onchange="cek_tahun(this.value)" required value="<?php echo date("Y-m"); ?>">&nbsp;
                    <button class="btn btn-primary btn-xs" type="submit" onclick="cek_tahun()"><i class="fa fa-search"></i> Cari</button>
                  </div>                
                <div class="ml-auto">
                  <h4 class="vtot-heading" id="vtot" style="text-align: right"></h4>
                </div>
            </div>
          </div>
            <div class="col-md-12">
              <h6 class="card-subtitle">Ruangan</h6>
              <div class="table-responsive">
                <table class="display table table-hover table-bordered dataTable" id="example" style="font-size: 14px; border: 2px solid black;" >
                    <thead style="border: 2px solid black;">
                        <tr style="border: 2px solid black;">
                            <td style="border: 2px solid black; vertical-align: middle;"><center>#</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>TT</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>BOR</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>LOS</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>TOI</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>BTO</center></td>
                        </tr>
                    </thead>
                </table>              
              </div>
            </div>
            <div class="col-md-12">
              <h6 class="card-subtitle">Kelas</h6>
              <div class="table-responsive">
                <table class="display nowrap table table-hover table-bordered dataTable" id="example2" style="font-size: 14px; border: 2px solid black;" >
                    <thead style="border: 2px solid black;">
                        <tr style="border: 2px solid black;">
                            <td style="border: 2px solid black; vertical-align: middle;"><center>#</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>TT</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>BOR</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>LOS</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>TOI</center></td>
                            <td style="border: 2px solid black; vertical-align: middle;"><center>BTO</center></td>
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

    $('#date_picker_bln').datepicker({
      format: "yyyy-mm",
      endDate: "current",
      autoclose: true,
      todayHighlight: true,
      viewMode: "months", 
      minViewMode: "months",
    }); 

    // document.getElementById("date_picker").required = true;

    //date
    // var d = new Date();
    // var currDate = d.getDate();
    // var currMonth = d.getMonth()+1;
    // var currYear = d.getFullYear();

    // var firstThn = currYear;

    // $('#date_picker_bln').datepicker("setDate", firstThn);
    // $('#date_picker').datepicker("setDate", new Date(today.getFullYear()+1) );
    // $("#date_picker_bln").datepicker().datepicker("setDate", new Date());

    cek_tahun();

  });

  // var intervalSetting = function () {
  //   var tgl_akhir=document.getElementById("date_picker_akhir").value;
  //   var tgl_awal=document.getElementById("date_picker_awal").value;
  //   if (tgl_akhir!='' && tgl_awal!=''){
  //     pilih_tgl();
  //   }
  // };
  // setInterval(intervalSetting, 30000);
      
  function cek_tahun() {
    var bln_thn=document.getElementById("date_picker_bln").value;
    // var tgl_awal=document.getElementById("date_picker_awal").value;
    if(bln_thn!=""){
      $('#data-pendapatan').html("");
      $('#data-pendapatan').show();
      $('#overlay').show();
      //VTOT
      // $.ajax({
      //   type:'POST',
      //   dataType: 'json',
      //   url:"<?php echo base_url('Dashboard/get_data_vtot')?>",
      //   data: {
      //     tgl_akhir : tgl_akhir,
      //     tgl_awal : tgl_awal
      //   },
      //   success: function(data){
      //     var a = number_format(data, 2);
      //     $("#vtot").val(a);
      //     document.getElementById("vtot").innerHTML = "Total Pendapatan Rp."+a;
      //   },
      //   error: function(){
      //     alert("error");
      //   }
      // });
      //PIE
      // $.ajax({
      //   type:'POST',
      //   dataType: 'json',
      //   url:"<?php echo base_url('Dashboard/get_data_pendapatan')?>",
      //   data: {
      //     tgl_akhir : tgl_akhir,
      //     tgl_awal : tgl_awal
      //   },
      //   success: function(data){
      //     if(data ==""){
      //       alert("Data Kosong");
      //       $('#overlay').hide();
      //       $('#data-pendapatan').hide();
      //     } else {
      //       var seriesArr = [];
      //         $.each(data, function(key, data) {
      //           var series = {name : key, data : []};

      //           $.each(data.y, function(index, value) {
      //             series.data.push({y: value });
      //           });
      //           seriesArr.push(series);
      //         });
      //         console.log(seriesArr);

            

      //       $('#overlay').hide();

      //     }
      //   },
      //   error: function(){
      //     alert("error");
      //   }
      // });

      objTable = $('#example').DataTable( {
        ajax: "<?php echo site_url('dashboard/indikator_ruang'); ?>/"+bln_thn,
        columns: [
          { data: [0] },
          { data: [1] },
          { data: [2] },
          { data: [3] },
          { data: [4] },
          { data: [5] }
        ],
        columnDefs: [
          { targets: [ 0 ], visible: true }
        ] ,
        searching: false, 
        paging: false,
        bDestroy : true,
        bSort : false
      } );

      objTable1 = $('#example2').DataTable( {
        ajax: "<?php echo site_url('dashboard/indikator_kelas'); ?>/"+bln_thn,
        columns: [
          { data: [0] },
          { data: [1] },
          { data: [2] },
          { data: [3] },
          { data: [4] },
          { data: [5] }
        ],
        columnDefs: [
          { targets: [ 0 ], visible: true }
        ] ,
        searching: false, 
        paging: false,
        bDestroy : true,
        bSort : false
      } );
      // alert("Cek tahun");
    } else {
      alert("Pilih Tanggal Dulu");
    }
  }
      
  function show() {
    var bln_thn=document.getElementById("date_picker_bln").value;
    // var tgl_akhir=document.getElementById("date_picker_akhir").value;
    // var tgl_awal=document.getElementById("date_picker_awal").value;
    if(bln_thn!=""){
      $('#data-pendapatan').html("");
      $('#data-pendapatan').show();
      $('#overlay').show();
      //VTOT
      // $.ajax({
      //   type:'POST',
      //   dataType: 'json',
      //   url:"<?php echo base_url('Dashboard/get_data_vtot')?>",
      //   data: {
      //     bln_thn : bln_thn
      //   },
      //   success: function(data){
      //     var a = number_format(data, 2);
      //     $("#vtot").val(a);
      //     document.getElementById("vtot").innerHTML = "Total Pendapatan Rp."+a;
      //   },
      //   error: function(){
      //     alert("error");
      //   }
      // });
      //PIE
      // $.ajax({
      //   type:'POST',
      //   dataType: 'json',
      //   url:"<?php echo base_url('Dashboard/get_data_pendapatan')?>",
      //   data: {
      //     thn : thn
      //   },
      //   success: function(data){
      //     if(data ==""){
      //       alert("Data Kosong");
      //       $('#overlay').hide();
      //       $('#data-pendapatan').hide();
      //     } else {
      //       var donut = new Morris.Donut({
      //             // ID of the element in which to draw the chart.
      //             element: 'data-pendapatan',
      //             //color.
      //             colors: ['#247BA0','#70C1B3','#434F12','#4E6054','#FF1654','#FFE016'],
      //             // the chart.
      //             data: data,
                  
      //             hideHover: 'auto'
      //       });
      //       $('#overlay').hide();
      //     }
      //   },
      //   error: function(){
      //     alert("error");
      //   }
      // });
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