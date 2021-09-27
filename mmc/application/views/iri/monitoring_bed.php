<?php $this->load->view("layout/header"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
<script>
setTimeout(function(){
   window.location.reload(1);
}, 300000);

$(document).ready(function(){
	  var currentPosition = 0;
	  var slideWidth = 300;
	  var slides = $('.slide');
	  var numberOfSlides = slides.length;
	
	  // Remove scrollbar in JS
	  $('#slidesContainer').css('overflow', 'hidden');
	
	  // Wrap all .slides with #slideInner div
	  slides
		.wrapAll('<div id="slideInner"></div>')
		// Float left to display horizontally, readjust .slides width
		.css({
		  'float' : 'left',
		  'width' : slideWidth
		});
	
	  // Set #slideInner width equal to total width of all slides
	  $('#slideInner').css('width', slideWidth * numberOfSlides);
	
	  // Insert controls in the DOM
	 //  $('#slideshow')
		// .prepend('<span class="control" id="leftControl">Clicking moves left</span>')
		// .append('<span class="control" id="rightControl">Clicking moves right</span>');
	
	  // Hide left arrow control on first load
	  manageControls(currentPosition);
	
	  // Create event listeners for .controls clicks
	  $('.control')
		.bind('click', function(){
		// Determine new position
		currentPosition = ($(this).attr('id')=='rightControl') ? currentPosition+1 : currentPosition-1;
	
		// Hide / show controls
		manageControls(currentPosition);
		// Move slideInner using margin-left
		$('#slideInner').animate({
		  'marginLeft' : slideWidth*(-currentPosition)
		});
	  });
	
	  // manageControls: Hides and Shows controls depending on currentPosition
	  function manageControls(position){
	  			<?php
	  			$jumlah_slide = count($list_bed) / 3;
	  			?>
          		if(position >= <?php echo $jumlah_slide; ?>)
                {
                    position=0;
                    currentPosition=0;
                }
		// Hide left arrow if position is first slide
		if(position==0){ $('#leftControl').hide() } else{ $('#leftControl').show() }
		// Hide right arrow if position is last slide
		if(position==numberOfSlides-1){ $('#rightControl').hide() } else{ $('#rightControl').show() }
	  } 
	  
	  function Aplay(){
		// Determine new position
		currentPosition =  currentPosition+1 ;
	
		// Hide / show controls
		manageControls(currentPosition);
		// Move slideInner using margin-left
		$('#slideInner').animate({
		  'marginLeft' : slideWidth*(-currentPosition)
		});
          setTimeout(function(){Aplay();},5000);
	  }
	  setTimeout(Aplay(),20000);
	  
});    
</script>

<style>
	<style>
	.panel-footer{
		height : 200px;
	}

	.panel-heading {
		height : 105px;
		color : white;
	}

	.pull-right{
		font-size: 24px;
	}

	.col {
		position: relative;
		min-height: 1px;
		padding-right: 15px;
		padding-left: 15px;
		float: left;
		height: 200px;
		
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
		padding-left: 15px;
		font-size: 30px;
	}
	.col-xs-54 {
		width: 33.33333333%;
		background-color:#3C3;
		color:#FFF;
		float: left;
		position: relative;
		min-height: 1px;
		padding-right: 15px;
		padding-left: 15px;
		font-size: 30px;
	}
	.col-xs-55 {
		width: 33.33333333%;
		background-color:#0000ff;
		color:#FFF;
		float: left;
		position: relative;
		min-height: 10px;
		padding-right: 15px;
		padding-left: 15px;
		font-size: 30px;
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
				        <td>&nbsp;&nbsp;<b> = Jumlah Bed </b></td>
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
					$jumlah_bed = -1;
					$row = 3;
					foreach ($list_bed as $r) {
						$jumlah_bed = $jumlah_bed + 1; 
						$total_bed = $total_bed + $r['total_isi'] + $r['total_kosong'];
						$total_isi = $total_isi + $r['total_isi'];
						$total_kosong = $total_kosong + $r['total_kosong'];
					?>
					<!-- slide -->
					<?php
					if($row % 3 == 0){ ?>
					<div id="slideshow">
					    <div id="slidesContainer">
					      <div class="slide">
					<?php
					}
					?>
					      <!-- konten -->
					       	<div class="col" title="<?php echo $r['nmruang']; ?>">
		    					<div class="panel panel-primary">
						            <div class="panel-heading" style="background-color: 00000 ">
						            	<i class="fa fa-bed fa-3x"></i>
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
										<!-- <div class="col-xs-55 text-center">
											<div><?php echo $r['total_reservasi'] - $r['total_batal'] ; ?></div>
										</div> -->
										<div class="col-xs-55 text-center">
											<div><?php echo $r['total_isi'] + $r['total_kosong'] ; ?></div>
										</div>
										</div>
									</div>
					        	</div>
						  	</div>
						  	<!-- end konten -->
						  <?php
						  $row = $row + 1;
						  if($row % 3 == 0){ ?>
							   </div>
						    </div>
						  </div>
						  <?php
						  }
						  ?>
					  <!-- Slideshow HTML -->
					<!-- end slide -->
					<?php
					}
					$bor = round(($total_isi/$total_bed) * 100,2);	
					?>

					<div class="row" id="panel-jumlah">
					<div class="container-fluid">
					<br />
					<!-- <table class="table table-bordered">
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
					</table> -->
					</div>
					</div>
					<!--- end monitoring bed -->
				<!--- end panel -->
			</div>
		<!--- end col -->
			
		</div><!--- end row -->
	</section>
<?php $this->load->view("layout/footer"); ?>
