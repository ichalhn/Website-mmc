<?php $this->load->view("layout/header"); ?>

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
      url:"<?php echo base_url('Cdashboard/get_data_periodik')?>",
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

  <!-- Main row -->
  <div class="row">
    <div class="col-md-12">
      <!-- AREA CHART -->
      <div class="box box-primary">
        <div class="box-body chart-responsive">
          <p class="col-sm-2">Cari Data</p>
          <div class="col-sm-10">
            <div class="form-inline">
              <div class="form-group">
                <input type="text" id="date_picker" class="form-control date_picker" placeholder="Tanggal awal" name="date_picker" required>
                <button class="btn btn-primary" type="submit" onclick="cek_periodik()">Cari</button>
              </div>
            </div>
          </div>
          <div hidden class='chart' id='poli' style='height: 450px;'></div>
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


<?php //include('script_json.php'); ?>
<?php $this->load->view("layout/footer"); ?>