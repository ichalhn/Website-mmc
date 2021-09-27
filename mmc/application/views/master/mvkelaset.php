<?php
  $this->load->view('layout/header.php');
?>
<html>
<script type='text/javascript'>
  $(function() {
  
  });

</script>
<section class="content-header">
  <?php
    echo $this->session->flashdata('success_msg');
  ?>
</section>

<section class="content" style="width:97%;margin:0 auto">
  <div class="row">
		<div class="tab-content">			
			<div class="panel panel-default">
				<div class="panel-body">
				  <table id="example" class="display" cellspacing="0" width="100%">
					<thead>
					  <tr>
						<th>No</th>
						<th>Kode</th>
						<th>Kelompok Aset</th>
						<th>Aksi</th>
					  </tr>
					</thead>
					<tfoot>
					  <tr>
						<th>No</th>
						<th>Kode</th>
						<th>Kelompok Aset</th>
						<th>Aksi</th>
					  </tr>
					</tfoot>
					<tbody>
					  <?php
						  $i=1;
						  foreach($table as $row){
					  ?>
					  <tr>
						<td><?php echo $i++;?></td>
						<td><?php echo $row->kd_skelbrg;?></td>
						<td><?php echo $row->ur_skel;?></td>
						<td>                  
							<center>
							<a href="<?php echo site_url("aset/delete_kel_aset/".$row->kd_skelbrg);?>" type="button" class="btn btn-primary btn-xs" title="Hapus"><i class="fa fa-trash"></i></a>
							</center>
						</td>
					  </tr>
					  <?php } ?>
					</tbody>
				  </table>
          
          <!-- View Modal -->
          
        </div>
      </div>
    </div>
</section>

<?php
  $this->load->view('layout/footer.php');
?>