<?php $this->load->view("layout/header"); ?>
<script>
$(document).ready(function() {
//$('#tablePulangRJ').DataTable();

$('#date_picker1').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});
$('.js-example-basic-single').select2();
$('#date_picker2').datepicker({
				format: "yyyy-mm-dd",
				endDate: "current",
				autoclose: true,
				todayHighlight: true,
		});
});

</script>
<div class="container"  >
			<div class="row">
				<div class="form-inline">
					<?php echo form_open('irj/Rjcmedrec/list_kunj_medrec');?>
						<div class="col-sm-12">
							<div class="form-inline">								
								<input type="text" id="date_picker1" class="form-control" placeholder="yyyy-mm-dd" name="date0">s/d
								<input type="text" id="date_picker2" class="form-control" placeholder="yyyy-mm-dd" name="date1">									
								<button class="btn btn-primary" type="submit">Cari</button>
													
							</div>
						</div><!-- /inline -->
					
				
			<?php echo form_close();?>
			</div>
		</div>
	</div>
<section class="content-header">
<div class="box" style="width:100%;margin:0 auto; padding-bottom:7px;">
	<div class="box-header" align="center"><b>Pasien Pulang Rawat Jalan<br> Tanggal <?php echo $tgl_awal;?> s/d <?php echo $tgl_akhir;?></b></div>
		
	<table class="table table-hover table-striped table-bordered"  width="95%">
						<thead>
							<tr>
								<tr>
								  <th>No</th>
								  <th>Poli</th>
								  <th>Baru</th>
								  <th>Lama</th>								  
								  <th>Militer</th>
								  <th>PNS</th>
								  <th>Non AL</th>	
								  <th>Keluarga</th>
								  <th>BPJS UMUM</th>
								  <th>UMUM</th>	
								  <th>Total</th>
								</tr>
							  <!--<th>No</th>
							  <th>No Medrec</th>
							  <th>No Register</th>
							  <th>Kunjungan</th>					
							  <th>Nama</th>								 
							  <th>L/P</th>
							  <th>Usia</th>
							  <th>Dokter</th>
							  <th>Diagnosa</th>-->
							</tr>
							</thead>
							
							<tbody>
							<?php	 //print_r($list_medrec);
							$i=1;
								$vtot1=0;$vtot2=0;$vtot3=0;$vtot4=0;$vtot5=0;$vtot6=0;$vtotpsn=0;$vtottotal=0;
								$vtotbaru=0;$vtotlama=0;
								foreach($data_kunj_pasien as $row){
								$vtot1=$vtot1+$row->MIL;
								$vtot2=$vtot2+$row->PNS;
								$vtot3=$vtot3+$row->NONAL;
								$vtot4=$vtot4+$row->KEL;
								$vtot5=$vtot5+$row->BPJSUMUM;
								$vtot6=$vtot6+$row->UMUM;
								$vtotpsn=$row->MIL+$row->PNS+$row->NONAL+$row->KEL+$row->BPJSUMUM+$row->UMUM;
								$vtottotal=$vtottotal+$vtotpsn;
								$vtotbaru=$vtotbaru+$row->baru;
								$vtotlama=$vtotlama+$row->lama;
							?>
								<tr>
								  <td><?php echo $i++;?></td>
								  <td><?php echo $row->nm_poli;?></td>
								  <td><?php echo $row->baru;?></td>
								  <td><?php echo $row->lama;?></td>
								  <td><?php echo $row->MIL;?></td>
								  <td><?php echo $row->PNS;?></td>
								  <td><?php echo $row->NONAL;?></td>
								  <td><?php echo $row->KEL;?></td>
								  <td><?php echo $row->BPJSUMUM;?></td>
								  <td><?php echo $row->UMUM;?></td>
								  <td><?php echo $vtotpsn;?></td>
								</tr>
										<?php } ?>
								<tr>
								  <td colspan="2" align="right">Total</td>
								  <td><?php echo $vtotbaru;?></td>
								  <td><?php echo $vtotlama;?></td>
								  <td><?php echo $vtot1;?></td>
								  <td><?php echo $vtot2;?></td>
								  <td><?php echo $vtot3;?></td>
								  <td><?php echo $vtot4;?></td>
								  <td><?php echo $vtot5;?></td>
								  <td><?php echo $vtot6;?></td>
								  <td><?php echo $vtottotal;?></td>
								</tr>
									</tbody>
								</table>
							<h4 align="center"><b>Total : </b><?php echo $vtot1+$vtot2+$vtot3+$vtot4+$vtot5+$vtot6;?></h4>
							<p>&nbsp;&nbsp;&nbsp;* Total tidak meliputi pasien baru dan lama</p>
							<div class="form-inline" align="right">
								<div class="form-group">
									<!--<a id="btnCetak" class="btn btn-primary" name="btnCetak" target="_blank" href="<?php echo site_url('irj/rjcmedrec/cetak_pdf/'.$tgl_awal.'/'.$tgl_akhir);?>">PDF</a>-->
									<?php if($i>0){ ?>
									<a id="btnDown" class="btn btn-primary" name="btnCetak" target="_blank" href="<?php echo site_url('irj/rjcmedrec/export_excel4/'.$tgl_awal.'/'.$tgl_akhir.'/');?>">Excel</a>		
									<?php } ?>
								</div>
					</div>
	</div>
</section>
<?php $this->load->view("layout/footer"); ?>
