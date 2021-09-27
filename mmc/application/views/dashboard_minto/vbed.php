<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else if ($role_id == 37){
            $this->load->view("layout/header_dashboard");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?>
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
                <h4 class="card-title">Ruangan Rawat Inap</h4>
                <!-- <h6 class="card-subtitle">Total Pasien Hari ini </h6>           
                <div class="ml-auto">
                  <h4 class="dashboard-heading">Total Pasien : <b id="total_pasien"></b></h4>
                </div> -->   
            </div>
          </div>
          <div class="col-md-12">
            <!-- <h4 class="card-title"><center>Ruangan Rawat Inap</center></h4>
            <h6 class="card-subtitle">Total Pasien Hari ini </h6> -->
            <div class="table-responsive">
              <table class="display nowrap table table-hover table-bordered dataTable" id="example" style="font-size: 14px; border: 2px solid black;" >
                    <thead style="border: 2px solid black;">
                    <tr style="border: 2px solid black;">
                        <td colspan="2" style="border: 2px solid black; vertical-align: middle;" align="right"><b>TOTAL</b></td>
                        <td style="border: 2px solid black; vertical-align: middle;" align="center"><b><?=$kapasitas_tot?></b></td>
                        <td style="border: 2px solid black; vertical-align: middle;" align="center"><b><?=$isi_tot?></b></td>
                        <td style="border: 2px solid black; vertical-align: middle;" align="center"><b><?=$kosong_tot?></b></td>
                    </tr>
                    <tr style="border: 2px solid black;">
                        <!-- <td style="border: 2px solid black; vertical-align: middle;" align="center">#</td> -->
                        <td style="border: 2px solid black; vertical-align: middle;" align="center"><b>KELAS</b></td>
                        <td style="border: 2px solid black; vertical-align: middle;" align="center"><b>RUANG</b></td>
                        <!--<td>KAPASITAS REAL</td> -->
                        <td style="border: 2px solid black; vertical-align: middle;" align="center"><b>KAPASITAS</b></td>
                        <!--<td>CADANGAN</td> -->
                        <td style="border: 2px solid black; vertical-align: middle;" align="center"><b>ISI</b></td>
                        <td style="border: 2px solid black; vertical-align: middle;" align="center"><b>KOSONG</b></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      // $vvip_row   =0;
                      // $vip_row    =0;
                      // $utama_row  =0;
                      // $i_row      =0;
                      // $ii_row     =0;
                      // $iii_row    =0;
                      $kapasitas  =0;
                      $isi        =0;
                      $kosong     =0;
                      $kelas='';
                      foreach ($hasil as $row) {
                        if($kelas==$row->kelas){
                          echo '
                          <tr>
                            <td><a href="'.site_url('dashboard/bed').'/'.$row->lokasi.'"><b style="color:black">'.$row->lokasi.'</b></a></td>
                            <td><center>'.$row->bed_kapasitas_real.'</center></td>
                            <td><center>'.$row->bed_isi.'</center></td>
                            <td><center>'.$row->bed_kosong.'</center></td>
                          </tr>';
                        }else{
                          $kelas = $row->kelas;
                          echo '
                          <tr style="border-top: 2px solid black;">
                            <td style="border-right: 2px solid black; vertical-align: middle; vertical: center;" rowspan="';
                          if($row->kelas=='VVIP'){
                            echo $vvip_row;
                          }else if($row->kelas=='VIP'){
                            echo $vip_row;
                          }else if($row->kelas=='UTAMA'){
                            echo $utama_row;
                          }else if($row->kelas=='I'){
                            echo $i_row;
                          }else if($row->kelas=='II'){
                            echo $ii_row;
                          }else if($row->kelas=='III'){
                            echo $iii_row;
                          }
                          echo '"><b><center>'.$row->kelas.'</center></b></td>
                            <td><a href="'.site_url('dashboard/bed').'/'.$row->lokasi.'"><b style="color:black">'.$row->lokasi.'</b></a></td>
                            <td><center>'.$row->bed_kapasitas_real.'</center></td>
                            <td><center>'.$row->bed_isi.'</center></td>
                            <td><center>'.$row->bed_kosong.'</center></td>
                          </tr>';
                        }
                        $kapasitas  =$kapasitas + $row->bed_kapasitas_real;
                        $isi        =$isi + $row->bed_isi;
                        $kosong     =$kosong + $row->bed_kosong;
                        
                        // if($row->kelas=='VVIP'){
                        //   echo '<tr>
                        //     <td>'.$row->kelas.'</td>
                        //     <td>'.$row->lokasi.'</td>
                        //     <td>'.$row->bed_kapasitas_real.'</td>
                        //     <td>'.$row->bed_isi.'</td>
                        //     <td>'.$row->bed_kosong.'</td>
                        //   </tr>';
                        // }else if($row->kelas=='VIP'){
                        //   echo '<tr>
                        //     <td>'.$row->kelas.'</td>
                        //     <td>'.$row->lokasi.'</td>
                        //     <td>'.$row->bed_kapasitas_real.'</td>
                        //     <td>'.$row->bed_isi.'</td>
                        //     <td>'.$row->bed_kosong.'</td>
                        //   </tr>';
                        // }else if($row->kelas=='UTAMA'){
                        //   echo '<tr>
                        //     <td>'.$row->kelas.'</td>
                        //     <td>'.$row->lokasi.'</td>
                        //     <td>'.$row->bed_kapasitas_real.'</td>
                        //     <td>'.$row->bed_isi.'</td>
                        //     <td>'.$row->bed_kosong.'</td>
                        //   </tr>';
                        // }else if($row->kelas=='I'){
                        //   echo '<tr>
                        //     <td>'.$row->kelas.'</td>
                        //     <td>'.$row->lokasi.'</td>
                        //     <td>'.$row->bed_kapasitas_real.'</td>
                        //     <td>'.$row->bed_isi.'</td>
                        //     <td>'.$row->bed_kosong.'</td>
                        //   </tr>';
                        // }else if($row->kelas=='II'){
                        //   echo '<tr>
                        //     <td>'.$row->kelas.'</td>
                        //     <td>'.$row->lokasi.'</td>
                        //     <td>'.$row->bed_kapasitas_real.'</td>
                        //     <td>'.$row->bed_isi.'</td>
                        //     <td>'.$row->bed_kosong.'</td>
                        //   </tr>';
                        // }else if($row->kelas=='III'){
                        //   echo '<tr>
                        //     <td>'.$row->kelas.'</td>
                        //     <td>'.$row->lokasi.'</td>
                        //     <td>'.$row->bed_kapasitas_real.'</td>
                        //     <td>'.$row->bed_isi.'</td>
                        //     <td>'.$row->bed_kosong.'</td>
                        //   </tr>';
                        // }
                      }
                      echo '<tr>
                                <td colspan="2" style="border: 2px solid black; vertical-align: middle;" align="right"><b>TOTAL</b></td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center"><b>'.$kapasitas.'</b></td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center"><b>'.$isi.'</b></td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center"><b>'.$kosong.'</b></td>
                          </tr>';

                    ?>
                  </tbody>
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

  });

  $(function() {
    // objTable = $('#example').DataTable( {
    //     ajax: "<?php echo site_url('dashboard/data_bed'); ?>",
    //     columns: [
    //       { data: "rank" },
    //       { data: "kelas" },
    //       { data: "lokasi" },
    //       { data: "bed_kapasitas_real" },
    //       // { data: "bed_utama" },
    //       // { data: "bed_cadangan" },
    //       { data: "bed_isi" },
    //       { data: "bed_kosong" }
    //     ],
    //     columnDefs: [
    //       { targets: [ 0 ], visible: false }
    //     ],
    //     searching: false, 
    //     paging: false,
    //     bDestroy : true
    //   } );
  });
  // var intervalSetting = function () {
  //   objTable.ajax.reload();
  // };
  // setInterval(intervalSetting, 10000);

</script>

<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>