<?php $this->load->view("layout/header"); ?>

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
  });

  var intervalSetting = function () {
    var tgl_akhir=document.getElementById("date_picker_akhir").value;
    var tgl_awal=document.getElementById("date_picker_awal").value;
    if (tgl_akhir!='' && tgl_awal!=''){
      pilih_poli();
    }
  };
  setInterval(intervalSetting, 300000);

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
    var id_poli=document.getElementById("id_poli").value;
    var tgl_akhir=document.getElementById("date_picker_akhir").value;
    var tgl_awal=document.getElementById("date_picker_awal").value;
    if(tgl_awal!="" && tgl_akhir!=""){
      $('#poli').html("");
      $('#poli').show();
      $('#overlay').show();
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('Cdashboard/get_data_kunjungan_perhari')?>",
        data: {
          id_poli: id_poli,
          tgl_akhir : tgl_akhir,
          tgl_awal : tgl_awal
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
              // Chart data records -- each entry in this array corresponds to a point on
              // the chart.
              data: data,
              // The name of the data record attribute that contains x-values.
              xkey: "tgl",
              xLabelAngle: 60,
              // A list of names of data record attributes that contain y-values.
              ykeys: ['total'],
              // Labels for the ykeys -- will be displayed when you hover over the
              // chart.
              labels: ['Jumlah Pasien']
            });
            $('#overlay').hide();
          }
        },
        error: function(){
          alert("error");
        }
      });
    }else{
      alert("Pilih Tanggal Dulu");
    }
    
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
                <input type="text" id="date_picker_awal" class="form-control date_picker_awal" placeholder="Tanggal awal" name="date_picker_awal" onchange="cek_tgl_awal(this.value)" required>
                <input type="text" id="date_picker_akhir" class="form-control date_picker_akhir" placeholder="Tanggal akhir" name="date_picker_akhir" onchange="cek_tgl_akhir(this.value)" required>
                <select name="id_poli" id="id_poli" class="form-control">
                  <option value="" disabled selected="">-Pilih Poliklinik-</option>
                  <?php 
                    foreach($pilihpoli as $row){
                      echo '<option value="'.$row->id_poli.'">'.$row->nm_poli.'</option>';
                    }
                  ?>
                </select>
                <button class="btn btn-primary" type="submit" onclick="pilih_poli()">Cari</button>
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