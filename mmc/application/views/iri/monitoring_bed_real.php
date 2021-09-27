<?php $this->load->view("layout/header"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
<script>
setTimeout(function(){
   window.location.reload(1);
}, 300000);
</script>

<style>
	<style>
	.panel-heading {
		height : 105px;
		color : white;
	}

	.pull-right{
		font-size: 15px;
	}

	.col {
		position: relative;
		min-height: 1px;
		padding-right: 15px;
		padding-left: 15px;
		float: left;
		width: 25%;
		font-weight: bold;
		
	}
	.col-xs-53 {
		width: 33.33333333%;
		background-color:#F00;
		color:#FFF;
		float: left;
		position: relative;
		min-height: 1px;
		padding-right: 15px;
		padding-left: 15px
	}
	.col-xs-54 {
		width: 33.33333333%;
		background-color:#3C3;
		color:#FFF;
		float: left;
		position: relative;
		min-height: 1px;
		padding-right: 15px;
		padding-left: 15px
	}
	.col-xs-55 {
		width: 33.33333333%;
		background-color:#0000ff;
		color:#FFF;
		float: left;
		position: relative;
		min-height: 1px;
		padding-right: 15px;
		padding-left: 15px
	}
</style>

</style>


	<section class="content">
		<div class="row">			
			<div class="col-md-12">
				<table>
					<tr>
				    	<td> <b>Keterangan : </b> &nbsp;&nbsp;</td>
				        <td width="15%" bgcolor="#FF0000"></td>
				        <td>&nbsp;&nbsp;<b> = Isi </b>&nbsp;&nbsp;</td>
				        <td width="15%" bgcolor="#00CC00"></td>
				        <td>&nbsp;&nbsp;<b> = Kosong </b>&nbsp;&nbsp;</td>
						<td width="15%" bgcolor="#0000ff"></td>
				        <td>&nbsp;&nbsp;<b> = Jumlah Antrian </b></td>
				    </tr>
				</table>
				<br />
				<?php echo $this->session->flashdata('pesan');?>
				<!-- monitoring bed-->
					<?php
					$total_bed = 0;
					$total_isi = 0;
					$total_kosong = 0;
					$bor = 0;
					foreach ($list_bed as $r) { 
						$total_bed = $total_bed + $r['total_isi'] + $r['total_kosong'];
						$total_isi = $total_isi + $r['total_isi'];
						$total_kosong = $total_kosong + $r['total_kosong'];
					?>
					<div class="col" title="<?php echo $r['nmruang']; ?>">
    					<div class="panel panel-primary">
				            <div class="panel-heading" style="background-color: 00000 ">
				            	<!-- <i class="fa fa-bed fa-3x"></i> -->
								<span class="pull-right"><?php echo $r['nmruang']; ?> </span><br/>
								<!-- <span class="pull-left"><?php echo $r['idrg']; ?></span><br/> -->
       						 </div>
							<div class="panel-footer">
								<div class="row">
								<div class="col-xs-53 text-center">
									<div><?php echo $r['total_isi']; ?></div>
								</div>
								<div class="col-xs-54 text-center">
									<div><?php echo $r['total_kosong']; ?></div>
								</div>
								<div class="col-xs-55 text-center">
									<div><?php echo $r['total_reservasi'] - $r['total_batal'] ; ?></div>
								</div>
								</div>
							</div>
			        	</div>
				  	</div>
					<?php
					}
					$bor = round(($total_isi/$total_bed) * 100,2);	
					?>

					<div class="row" id="panel-jumlah">
					<div class="container-fluid">
					<br />
					<table class="table table-bordered">
						<tr>
					    	<td width="2%">Jumlah Bed</td>
					        <td width="2%"><span id="total_ruang"></span><?php echo $total_bed;?></td>
							<td width="2%">BOR</td>
					        <td width="2%"><span id="total_bor"></span><?php echo $bor;?></td>
					    </tr>
						<tr>
					    	<td width="2%">Jumlah Terisi</td>
					        <td width="2%"><span id="total_isi"></span><?php echo $total_isi;?></td>
							<td width="2%">Jumlah Kosong</td>
					        <td width="2%"><span id="total_kosong"></span><?php echo $total_kosong;?></td>
					    </tr>
					</table>
					</div>
					</div>
					<!--- end monitoring bed -->
				<!--- end panel -->
			</div>
		<!--- end col -->
			
		</div><!--- end row -->
	</section>
<?php $this->load->view("layout/footer"); ?>
