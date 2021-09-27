<?php $this->load->view("layout/header"); ?>

<script type='text/javascript'>
  var site = "<?php echo site_url();?>";
  var tgl_akhir=''; var tgl_awal='';
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

    tgl_akhir=document.getElementById("date_picker_akhir").value;
    tgl_awal=document.getElementById("date_picker_awal").value;    

    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('Cdashboard/get_data_pasien')?>",
       data: {
          tgl_akhir : tgl_akhir,
          tgl_awal : tgl_awal
        },
      complete: function(data,status) {
          if(status=='success'){
            document.getElementById("umum").innerHTML = 0;
            document.getElementById("bpjs").innerHTML = 0;
            document.getElementById("perusahaan").innerHTML = 0;
            document.getElementById("jamsoskes").innerHTML = 0;
            document.getElementById("pendumum").innerHTML = 0;
            document.getElementById("pendbpjs").innerHTML = 0;
            document.getElementById("pendperusahaan").innerHTML = 0;
            document.getElementById("pendjamsoskes").innerHTML = 0;

            if(data.responseText!='[]'){
              //console.log(data.responseText);
              for(i=0;i<4;i++){
                carabayar = data.responseJSON[i].cara_bayar.toUpperCase();;
                if(carabayar=="UMUM"){
                  document.getElementById("umum").innerHTML = data.responseJSON[i].jumlah;
                  document.getElementById("pendumum").innerHTML = "RP. "+ data.responseJSON[i].total;
                } else if(carabayar=="BPJS"){
                  document.getElementById("bpjs").innerHTML = data.responseJSON[i].jumlah;
                  document.getElementById("pendbpjs").innerHTML = "RP. "+ data.responseJSON[i].total;
                } else if(carabayar=="DIJAMIN"){
                  document.getElementById("perusahaan").innerHTML = data.responseJSON[i].jumlah;
                  document.getElementById("pendperusahaan").innerHTML = "RP. "+ data.responseJSON[i].total;
                } else if(carabayar=="JAMSOSKES"){
                document.getElementById("jamsoskes").innerHTML = data.responseJSON[i].jumlah;
                document.getElementById("pendjamsoskes").innerHTML = "RP. "+ data.responseJSON[i].total;
                }
              }
            }
          }
      },
      error: function(){
        alert("error");
      }
    }); 
  });

  var intervalSetting = function () {
    tgl_akhir=document.getElementById("date_picker_akhir").value;
    tgl_awal=document.getElementById("date_picker_awal").value;

    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('Cdashboard/get_data_pasien')?>",
       data: {
          tgl_akhir : tgl_akhir,
          tgl_awal : tgl_awal
        },
      complete: function(data,status) {
          if(status='success'){
            document.getElementById("umum").innerHTML = 0;
            document.getElementById("bpjs").innerHTML = 0;
            document.getElementById("jamsoskes").innerHTML = 0;
            document.getElementById("perusahaan").innerHTML = 0;
            document.getElementById("pendumum").innerHTML = 0;
            document.getElementById("pendbpjs").innerHTML = 0;
            document.getElementById("pendperusahaan").innerHTML = 0;
            document.getElementById("pendjamsoskes").innerHTML = 0;

            if(data.responseText!='[]'){
              for(i=0;i<4;i++){
              carabayar = data.responseJSON[i].cara_bayar.toUpperCase();;
              if(carabayar=="UMUM"){
                document.getElementById("umum").innerHTML = data.responseJSON[i].jumlah;
                document.getElementById("pendumum").innerHTML = "RP. "+ data.responseJSON[i].total;
              } else if(carabayar=="BPJS"){
                document.getElementById("bpjs").innerHTML = data.responseJSON[i].jumlah;
                document.getElementById("pendbpjs").innerHTML = "RP. "+ data.responseJSON[i].total;
              } else if(carabayar=="DIJAMIN"){
                document.getElementById("perusahaan").innerHTML = data.responseJSON[i].jumlah;
                document.getElementById("pendperusahaan").innerHTML = "RP. "+ data.responseJSON[i].total;
              } else if(carabayar=="JAMSOSKES"){
                document.getElementById("jamsoskes").innerHTML = data.responseJSON[i].jumlah;
                document.getElementById("pendjamsoskes").innerHTML = "RP. "+ data.responseJSON[i].total;
              }
             }
            }
          }
      },
      error: function(){
        alert("error");
      }
    });

    tgl_akhir=document.getElementById("date_picker_akhir").value;
    tgl_awal=document.getElementById("date_picker_awal").value;
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
    var tgl_akhir=document.getElementById("date_picker_akhir").value;
    var tgl_awal=document.getElementById("date_picker_awal").value;
    if(tgl_awal!="" && tgl_akhir!=""){
      $('#pasien').html("");
      $('#pasien').show();
      $('#overlay').show();
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('Cdashboard/get_data_pasien_range')?>",
        data: {
          tgl_akhir : tgl_akhir,
          tgl_awal : tgl_awal
        },        
        complete: function(data,status) {
          console.log(data.responseJSON[0]);
          if(status=='success'){
              if(data.responseText =='[]'){
            alert("Data Kosong");
            $('#overlay').hide();
            $('#pasien').hide();
          } else {
        
            document.getElementById("umum").innerHTML = 0;
            document.getElementById("bpjs").innerHTML = 0;
            document.getElementById("perusahaan").innerHTML = 0;
            document.getElementById("jamsoskes").innerHTML = 0;
            document.getElementById("pendumum").innerHTML = 0;
            document.getElementById("pendbpjs").innerHTML = 0;
            document.getElementById("pendperusahaan").innerHTML = 0;
            document.getElementById("pendjamsoskes").innerHTML = 0;
            
            for(i=0;i<4;i++){
              carabayar = data.responseJSON[i].cara_bayar.toUpperCase();;
              if(carabayar=="UMUM"){
              document.getElementById("umum").innerHTML = data.responseJSON[i].jumlah;
              document.getElementById("pendumum").innerHTML = "RP. "+ data.responseJSON[i].total;
              } else if(carabayar=="BPJS"){
              document.getElementById("bpjs").innerHTML = data.responseJSON[i].jumlah;
              document.getElementById("pendbpjs").innerHTML = "RP. "+ data.responseJSON[i].total;
              } else if(carabayar=="DIJAMIN"){
              document.getElementById("perusahaan").innerHTML = data.responseJSON[i].jumlah;
              document.getElementById("pendperusahaan").innerHTML = "RP. "+ data.responseJSON[i].total;
              } else if(carabayar=="JAMSOSKES"){
              document.getElementById("jamsoskes").innerHTML = data.responseJSON[i].jumlah;
              document.getElementById("pendjamsoskes").innerHTML = "RP. "+ data.responseJSON[i].total;
              }
            }
    
            var bar = new Morris.Bar({
              // ID of the element in which to draw the chart.
              element: 'pasien',
              // Chart data records -- each entry in this array corresponds to a point on
              // the chart.
              data: data.responseJSON,
              // The name of the data record attribute that contains x-values.
              xkey: "cara_bayar",
              // A list of names of data record attributes that contain y-values.
              ykeys: ['jumlah'],
              // Labels for the ykeys -- will be displayed when you hover over the
              // chart.
              labels: ['Jumlah Pasien']
            });
            $('#overlay').hide();
          }
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
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="fa fa-home"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">UMUM</span>
          <span class="info-box-number" id="umum"></span>
          <span class="info-box-number" id="pendumum"></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-green"><i class="fa fa-institution "></i></span>

        <div class="info-box-content">
          <span class="info-box-text">BPJS</span>
          <span class="info-box-number" id="bpjs"></span>
          <span class="info-box-number" id="pendbpjs"></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-yellow"><i class="fa fa-building-o"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">DIJAMIN</span>
          <span class="info-box-number" id="perusahaan"></span>
          <span class="info-box-number" id="pendperusahaan"></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-red"><i class="fa fa-building"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">JAMSOSKES</span>
          <span class="info-box-number" id="jamsoskes"></span>
          <span class="info-box-number" id="pendjamsoskes"></span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
      
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
                <button class="btn btn-primary" type="submit" onclick="pilih_poli()">Cari</button>
              </div>
            </div>
          </div>
          <div hidden class='chart' id='pasien' style='height: 450px;'></div>
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

<?php $this->load->view("layout/footer"); ?>