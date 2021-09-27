<?php
	$this->load->view('layout/header.php');
?>
<html>
<script type='text/javascript'>
//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#example').DataTable({
    	"pageLength":100
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

var intervalSetting = function () {
		location.reload();
	};
setInterval(intervalSetting, 60000);
</script>
<script>
      //   jQuery(document).ready(function($){
      //       $('.delete-pelayanan').on('click',function(){
      //           var getLink = $(this).attr('href');
      //          swal({
  			 //   title: "Hapus Nomor SEP",
  			 //   text: "Yakin akan menghapus Nomor SEP ini?",
  			 //   type: "warning",
  			 //   showCancelButton: true,
  			 //   confirmButtonColor: "#DD6B55",
  			 //   confirmButtonText: "Hapus",
  			 //   closeOnConfirm: false
			   // },function(){
      //                   window.location.href = getLink
      //               });
      //           return false;
      //       });
      //   });
function hapus_pelayanan(id_poli,no_register,cara_bayar,status_sep,hapus) {
	if(hapus=='0'){
		textbtl="Yakin akan membatalkan pelayanan ini?";
	}else{
		textbtl="Yakin akan menghapus pelayanan ini?";
	}

	if (status_sep == 0 && cara_bayar == 'BPJS') {
               var getLink = '<?php echo base_url(); ?>irj/rjcpelayanan/pelayanan_batal/'+id_poli+'/'+no_register+'/'+hapus;
               swal({
  			   title: "Batalkan & Hapus SEP",
  			   text: textbtl,
  			   type: "warning",
  			   showCancelButton: true,
  			   confirmButtonColor: "#DD6B55",
  			   confirmButtonText: "Hapus",
  			   closeOnConfirm: false
			   },function(){
                        window.location.href = getLink
                    });
                return false;
	}
	else {
               var getLink = '<?php echo base_url(); ?>irj/rjcpelayanan/pelayanan_batal/'+id_poli+'/'+no_register+'/'+hapus;
               swal({ 
  			   title: "Batalkan Pelayanan",
  			   text: textbtl,
  			   type: "warning",
  			   showCancelButton: true,
  			   confirmButtonColor: "#DD6B55",
  			   confirmButtonText: "Hapus",
  			   closeOnConfirm: false
			   },function(){
                        window.location.href = getLink
                    });
                return false;
	}

}      
    </script>
	<section class="content-header">
			<?php
				echo $this->session->flashdata('success_msg');
				echo $this->session->flashdata('notification');				
				echo $this->session->flashdata('notification_sep');				
			?>
				
			</section>
			<section class="content">
				<div class="row">
					<div class="col-xs-12">
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">Daftar Antrian Pasien Poli <b><?php echo $nm_poli.' ('.$id_poli.')';?></b></h3>
							</div>
							<div class="box-body">
								
								<?php echo form_open('irj/rjcpelayanan/kunj_pasien_poli_by_date');?>
						
								<div class="input-group" style="width: 20%;">
								  <input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
								  <input type="hidden" class="form-control" name="id_poli" value="<?php echo $id_poli;?>">
								  <span class="input-group-btn">
									<button class="btn btn-primary" type="submit">Cari</button>
								  </span>
								</div><!-- /input-group -->
								
								<?php echo form_close();?>
								<br/>
								<table id="example" class="display" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>No Antrian</th>
											  <th>Tanggal Kunjungan</th>
											  <th>No Medrec</th>
											  <th>No Registrasi</th>
											  <th>Nama</th>
											  <th>Status</th>
											  <th>Kelas</th>
											  <th>Aksi</th>	
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>No Antrian</th>
											<th>Tanggal Kunjungan</th>
											<th>No Medrec</th>
											<th>No Registrasi</th>
											<th>Nama</th>
											<th>Status</th>
											<th>Kelas</th>
											<th>Aksi</th>
										</tr>
									</tfoot>
									<tbody>
										<?php
											// print_r($pasien_daftar);
											$i=1;
												foreach($pasien_daftar as $row){
												$no_register=$row->no_register;	
										?>
										<tr>
											<td><?php echo $row->no_antrian;?></td>
											<td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan)).' | '.date("H:i", strtotime($row->tgl_kunjungan));?></td>
											<td><?php echo $row->no_cm;?></td>
											<?php if($row->cara_bayar=='UMUM' and $row->unpaid>0 ){
												?>
											<td style="color: red !important;"><?php echo $row->no_register;?></td>
												<?php } else {?>
											<td><?php echo $row->no_register;?></td>
												<?php }?>
											<td><?php echo strtoupper($row->nama);?></td>
											<td><?php echo strtoupper($row->cara_bayar);?></td>
											<td><?php echo $row->kelas_pasien;?></td>
											<td>
												<a href="<?php echo site_url('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register); ?>" class="btn btn-primary btn-xs">Tindak</a>
												<!--<?php //if($row->cara_bayar=='UMUM' and $row->unpaid>=2 and $id_poli!='BA00'){
												?>
												<a href="javascript:void(0)" class="btn btn-primary btn-xs" disabled>Tindak</a>
												<!-- <a href="javascript:void(0)" class="btn btn-danger btn-xs" disabled>Batal</a> 
												
												<?php //} else {?>
												<a href="<?php //echo site_url('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register); ?>" class="btn btn-primary btn-xs">Tindak</a>
												<?php //} ?>-->
												<?php if($access=='1'){ ?>
												<button onclick="hapus_pelayanan('<?php echo $id_poli; ?>','<?php echo $no_register; ?>','<?php echo $row->cara_bayar; ?>',<?php echo $row->hapusSEP; ?>,'0')" class="btn btn-default btn-xs delete-pelayanan">Batal</button>
												<button onclick="hapus_pelayanan('<?php echo $id_poli; ?>','<?php echo $no_register; ?>','<?php echo $row->cara_bayar; ?>',<?php echo $row->hapusSEP; ?>,'1')" class="btn btn-danger btn-xs delete-pelayanan">Hapus</button>
												<?php } ?>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								<?php
									//echo $this->session->flashdata('message_nodata'); 
								?>								
							</div>
						</div>
					</div>
			</section>
<?php
	$this->load->view('layout/footer.php');
?>
