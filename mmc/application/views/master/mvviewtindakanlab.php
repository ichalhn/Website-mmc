<?php
  $this->load->view('layout/header.php');
?>
<html>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    $('#example').DataTable( {
      "iDisplayLength": 50
    } );
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_flat-green'
    });
  } );
  //---------------------------------------------------------

  $(function() {
    $('#date_picker').datepicker({
      format: "yyyy-mm-dd",
      endDate: '0',
      autoclose: true,
      todayHighlight: true,
    });  
  });

</script>
<section class="content-header">
  <?php
    echo $this->session->flashdata('success_msg');
  ?>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">DAFTAR TARIF TINDAKAN</h3>
        </div>
        <div class="box-body ">
          <table id="example" class="display table-responsive" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>ID Tindakan</th>
                <th>Nama Tindakan</th>
                <th>Tarif Kelas III</th>
                <th>Tarif Kelas II</th>
                <th>Tarif Kelas I</th>
                <th>Tarif Kelas VIP</th>
                <th>Tarif Kelas VVIP</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>ID Tindakan</th>
                <th>Nama Tindakan</th>
                <th>Tarif Kelas III</th>
                <th>Tarif Kelas II</th>
                <th>Tarif Kelas I</th>
                <th>Tarif Kelas VIP</th>
                <th>Tarif Kelas VVIP</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $i=1;
                  foreach($viewtindakan as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->idtindakan;?></td>
                <td><?php echo $row->nmtindakan;?></td>
                <td><?php echo $row->iii;?></td>
                <td><?php echo $row->ii;?></td>
                <td><?php echo $row->i;?></td>
                <td><?php echo $row->vip;?></td>
                <td><?php echo $row->vvip;?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
  $this->load->view('layout/footer.php');
?>