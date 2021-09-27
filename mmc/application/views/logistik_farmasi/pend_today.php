<?php $this->load->view("layout/header"); ?>
<?php include('script_laprdpendapatan.php');	?>
<style>
hr {
 border-color:#7DBE64 !important;
}

thead {
 background: #c4e8b6 !important;
 color:#4B5F43 !important;
 background: -moz-linear-gradient(top,  #c4e8b6 0%, #7DBE64 100%) !important;
 background: -webkit-linear-gradient(top,  #c4e8b6 0%,#7DBE64 100%) !important;
 background: linear-gradient(to bottom,  #c4e8b6 0%,#7DBE64 100%) !important;
 filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c4e8b6', endColorstr='#7DBE64',GradientType=0 )!important;
}

</style>
<?php echo $message_nodata;?>	

<section class="content-header">
 <?php include('pend_cari.php'); ?>
</section>

<section class="content">
 <div class="row">
  <div class="panel panel-default" style="width:97%;margin:0 auto">
   <div class="panel-heading">  
    <h4  align="center">Laporan Keuangan Logistik Farmasi <?php echo $date_title;?></h4>
   </div>
   <div class="panel-body">
    <?php if($tampil_per=='TGL'){ 
    include('pend_tgl.php');
    } else if($tampil_per=='BLN'){ 
    include('pend_bln.php');
    } else {include('pend_thn.php');} ?>
   </div>
  </div>
</section>
<?php $this->load->view("layout/footer"); ?>