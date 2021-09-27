<?php $this->load->view("layout/header"); ?>

  <!-- Main content -->
  <section class="content">
    <!-- Main row -->
    <div class="row">
      <div class="col-md-12">
        <!-- AREA CHART -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Jumlah Pasien Poli</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body chart-responsive">
            <div class="chart" id="kun-poli" style="height: 300px;"></div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <!-- AREA CHART -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">HEMODIALISA</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body chart-responsive">
            <div class="chart" id="poli-a" style="height: 300px;"></div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>

      <div class="col-md-6">
        <!-- AREA CHART -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">POLI BEDAH UMUM</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body chart-responsive">
            <div class="chart" id="poli-b" style="height: 300px;"></div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <!-- DONUT CHART -->
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Pendapatan</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body chart-responsive">
            <div class="chart" id="data-pendapatan" style="height: 450; position: relative;"></div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <!-- AREA CHART -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Semua Poli per Tgl</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body chart-responsive">
            <div class="chart" id="semua-poli" style="height: 300px;"></div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>

      <!-- /.col (LEFT) -->
      <div class="col-md-6">
        <!-- LINE CHART -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Per Poli</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body chart-responsive">
            <div class="chart" id="per-poli" style="height: 300px;"></div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col (RIGHT) -->
    </div>
      <!-- /.row -->
  </section><!-- /.content -->


<script>
  $(function () {
    "use strict";

    // AREA CHART
    var area = new Morris.Area({
      element: 'semua-poli',
      data: [
        {data: 'Tgl 1', item1: 100, item2: 55, item3: 100, item4: 75},
        {data: 'Tgl 2', item1: 100, item2: 78, item3: 100, item4: 100},
        {data: 'Tgl 3', item1: 100, item2: 78, item3: 78, item4: 78},
        {data: 'Tgl 4', item1: 100, item2: 78, item3: 78, item4: 78},
        {data: 'Tgl 5', item1: 100, item2: 98, item3: 100, item4: 55},
        {data: 'Tgl 6', item1: 100, item2: 98, item3: 75, item4: 55},
        {data: 'Tgl 7', item1: 100, item2: 98, item3: 45, item4: 100},
        {data: 'Tgl 8', item1: 100, item2: 100, item3: 78, item4: 75},
        {data: 'Tgl 9', item1: 100, item2: 98, item3: 100, item4: 98},
        {data: 'Tgl 10', item1: 100, item2: 98, item3: 75, item4: 75}
      ],
      xkey: 'data',
      ykeys: ['item1', 'item2', 'item3', 'item4'],
      labels: ['Poli 1', 'Poli 2','Poli 3', 'Poli 4'],
      hideHover: 'auto',
      parseTime:false
    });

    // LINE CHART
    var line = new Morris.Line({
      element: 'per-poli',
      resize: true,
      data: [
        {y: '1', item1: 2666},
        {y: '2', item1: 2778},
        {y: '3', item1: 4912},
        {y: '4', item1: 3767},
        {y: '5', item1: 6810},
        {y: '6', item1: 5670},
        {y: '7', item1: 4820},
        {y: '8', item1: 15073},
        {y: '9', item1: 10687},
        {y: '10', item1: 8432}
      ],
      xkey: 'y',
      ykeys: ['item1'],
      labels: ['Item 1'],
      lineColors: ['#3c8dbc'],
      hideHover: 'auto',
      parseTime:false
    });

    /*BAR CHART
    var bar = new Morris.Bar({
      element: 'bar-chart',
      data: [
        {y: 'Poli A', a: 100},
        {y: 'Poli B', a: 75},
        {y: 'Poli C', a: 50},
        {y: 'Poli D', a: 75},
        {y: 'Poli E', a: 50}
      ],
      barColors: ['#00a65a'],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Pasien'],
      formatter: function (y,a) { return (a) + '%'; },
    });

    BAR CHART JUMLAH KUNJUNGAN POLI
    var bar = new Morris.Bar({
      element: 'kun-poli2',
      data: [
        {y: 'Poli A', a: 212, b: 80, c: 90, d: 90},
        {y: 'Poli B', a: 264, b: 75, c: 55, d: 12},
        {y: 'Poli C', a: 332, b: 32, c: 123, d: 23},
        {y: 'Poli D', a: 223, b: 23, c: 153, d: 3},
        {y: 'Poli E', a: 123, b: 64, c: 23, d: 23},
        {y: 'Poli F', a: 232, b: 87, c: 23, d: 32},
        {y: 'Poli G', a: 323, b: 152, c: 90, d: 11}
      ],
      xkey: 'y',
      ykeys: ['a','b','c','d'],
      labels: ['Total Pasien','BPJS','UMUM','Perusahaan']
    });

    //DONUT CHART
    var donut = new Morris.Donut({
      element: 'data-pendapatan',
      resize: true,
      data: [
        {label: "IRI", value: 152000000},
        {label: "IRD", value: 53000000},
        {label: "IRJ", value: 42000000},
        {label: "FARMASI", value: 14000000},
        {label: "LABORATORIUM", value: 32000000},
        {label: "RADIOLOGI", value: 22000000}
      ],
      hideHover: 'auto'
    });
*/

    $.getJSON("<?php echo base_url('Beranda/get_data_kunjungan')?>", function (json) { 
            var bar = new Morris.Bar({
                        // ID of the element in which to draw the chart.
                        element: 'kun-poli',
                        // Chart data records -- each entry in this array corresponds to a point on
                        // the chart.
                        data: json,
                        // The name of the data record attribute that contains x-values.
                        xkey: "nama",
                        xLabelAngle: 60,
                        // A list of names of data record attributes that contain y-values.
                        ykeys: ['total'],
                        // Labels for the ykeys -- will be displayed when you hover over the
                        // chart.
                        labels: ['Jumlah Pasien']
                    });
        });

    $.getJSON("<?php echo base_url('Beranda/get_data_kunjungan_perhari/AA00')?>", function (json) { 
            var line = new Morris.Line({
                        // ID of the element in which to draw the chart.
                        element: 'poli-a',
                        // Chart data records -- each entry in this array corresponds to a point on
                        // the chart.
                        data: json,
                        // The name of the data record attribute that contains x-values.
                        xkey: "tgl",
                        xLabelAngle: 60,
                        // A list of names of data record attributes that contain y-values.
                        ykeys: ['total'],
                        // Labels for the ykeys -- will be displayed when you hover over the
                        // chart.
                        labels: ['Jumlah Pasien']
                    });
        });

    $.getJSON("<?php echo base_url('Beranda/get_data_kunjungan_perhari/BB00')?>", function (json) { 
            var line2 = new Morris.Line({
                        // ID of the element in which to draw the chart.
                        element: 'poli-b',
                        // Chart data records -- each entry in this array corresponds to a point on
                        // the chart.
                        data: json,
                        // The name of the data record attribute that contains x-values.
                        xkey: "tgl",
                        xLabelAngle: 60,
                        // A list of names of data record attributes that contain y-values.
                        ykeys: ['total'],
                        // Labels for the ykeys -- will be displayed when you hover over the
                        // chart.
                        labels: ['Jumlah Pasien']
                    });
        });

    $.getJSON("<?php echo base_url('Beranda/get_data_pendapatan')?>", function (json) { 
            var donut = new Morris.Donut({
                        // ID of the element in which to draw the chart.
                        element: 'data-pendapatan',
                        // the chart.
                        data: json,
                        
                        hideHover: 'auto'
                    });
        });

  });
</script>
<?php $this->load->view("layout/footer"); ?>