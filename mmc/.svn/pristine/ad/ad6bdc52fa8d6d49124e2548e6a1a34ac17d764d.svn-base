<?php
	$this->load->view('layout/header.php');
?>
	<script>

	
	</script>
	<!-- Content Header (Page header) -->	
	<section class="content">
		<div class="row">
			<div class="col-md-8">
				<div class="panel panel-info">
					<div class="panel-heading" align="center">Konfigurasi</div>
					<div class="panel-body">
					<?php
echo form_open_multipart('admin/configSave/',array('id'=>'config_form'));
?>
<fieldset id="config_info">

							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Judul Web</p>
								<div class="col-sm-8">
									<?php echo form_input(array(
									'name'=>'web_title',
									'id'=>'web_title',
									'class'=>'form-control', 'value'=>$this->config->item('web_title')));?>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Judul Header</p>
								<div class="col-sm-8">
									<?php echo form_input(array(
									'name'=>'header_title',
									'id'=>'header_title',
									'class'=>'form-control', 'value'=>$this->config->item('header_title')));?>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Gambar Logo Header</p>
								<div class="col-sm-8">		
									<div class="input-group">
										<input type="file" name="userfile" accept="image/jpeg, image/png, image/gif"/>
										<input type="text" name="logo_url" id="logo_url" class="form-control filefield browse" readonly="" value="<?php echo $this->config->item('logo_url'); ?>" />
										<span class="input-group-btn">
											<button class="btn btn-info btn-flat" type="button" id="browseBtn">Browse</button>
										</span>
									</div>
								</div>								
							</div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Skin</p>
								<div class="col-sm-8">
									<?php echo form_input(array(
									'name'=>'skin',
									'id'=>'skin',
									'class'=>'form-control', 'value'=>$this->config->item('skin')));?>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Nama RS</p>
								<div class="col-sm-8">
									<?php echo form_input(array(
									'name'=>'namars',
									'id'=>'namars',
									'class'=>'form-control', 'value'=>$this->config->item('namars')));?>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Nama RS Singkat</p>
								<div class="col-sm-8">
									<?php echo form_input(array(
									'name'=>'namasingkat',
									'id'=>'namasingkat',
									'class'=>'form-control', 'value'=>$this->config->item('namasingkat')));?>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Alamat</p>
								<div class="col-sm-8">
									<?php echo form_input(array(
									'name'=>'alamat',
									'id'=>'alamat',
									'class'=>'form-control', 'value'=>$this->config->item('alamat')));?>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Kota</p>
								<div class="col-sm-8">
									<?php echo form_input(array(
									'name'=>'kota',
									'id'=>'kota',
									'class'=>'form-control', 'value'=>$this->config->item('kota')));?>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Telepon</p>
								<div class="col-sm-8">
									<?php echo form_input(array(
									'name'=>'telp',
									'id'=>'telp',
									'class'=>'form-control', 'value'=>$this->config->item('telp')));?>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-4 form-control-label" ></div>
								<div class="col-sm-8">		
									<?php 
									echo form_submit(array(
										'name'=>'submit',
										'id'=>'submit',
										'class'=>'form-control', 'value'=>'Simpan',
										'class'=>'btn btn-primary')
									);
									?>
								</div>
							</div>
					</div>
					
</fieldset>
<?php
echo form_close();
?>

				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-info">
					<div class="panel-heading" align="center">Skin</div>
					<div class="panel-body">
						<ul class="list-unstyled clearfix">
							<li style="float:left; width: 33.33333%; padding: 5px;">
								<a class="clearfix full-opacity-hover" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" data-skin="skin-blue" href="javascript:void(0);">
								<div>
								<span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span>
								<span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
								</div>
								<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
								</div>
								</a>
								<p class="text-center no-margin">Blue</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
								<a class="clearfix full-opacity-hover" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" data-skin="skin-black" href="javascript:void(0);">
								<div class="clearfix" style="box-shadow: 0 0 2px rgba(0,0,0,0.1)">
								<span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span>
								<span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span>
								</div>
								<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #222;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
								</div>
								</a>
								<p class="text-center no-margin">Black</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
								<a class="clearfix full-opacity-hover" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" data-skin="skin-purple" id="data-skin" href="#" onClick="changeSkin('skin-purple')">
								<div>
								<span class="bg-purple-active" style="display:block; width: 20%; float: left; height: 7px;"></span>
								<span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
								</div>
								<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
								</div>
								</a>
								<p class="text-center no-margin">Purple</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
								<a class="clearfix full-opacity-hover" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" data-skin="skin-green" href="javascript:void(0);">
								<div>
								<span class="bg-green-active" style="display:block; width: 20%; float: left; height: 7px;"></span>
								<span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
								</div>
								<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
								</div>
								</a>
								<p class="text-center no-margin">Green</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
								<a class="clearfix full-opacity-hover" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" data-skin="skin-red" href="javascript:void(0);">
								<div>
								<span class="bg-red-active" style="display:block; width: 20%; float: left; height: 7px;"></span>
								<span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
								</div>
								<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
								</div>
								</a>
								<p class="text-center no-margin">Red</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
								<a class="clearfix full-opacity-hover" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" data-skin="skin-yellow" href="javascript:void(0);">
								<div>
								<span class="bg-yellow-active" style="display:block; width: 20%; float: left; height: 7px;"></span>
								<span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
								</div>
								<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
								</div>
								</a>
								<p class="text-center no-margin">Yellow</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
								<a class="clearfix full-opacity-hover" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" data-skin="skin-blue-light" href="javascript:void(0);">
								<div>
								<span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span>
								<span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
								</div>
								<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
								</div>
								</a>
								<p class="text-center no-margin" style="font-size: 12px">Blue Light</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
								<a class="clearfix full-opacity-hover" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" data-skin="skin-black-light" href="javascript:void(0);">
								<div class="clearfix" style="box-shadow: 0 0 2px rgba(0,0,0,0.1)">
								<span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span>
								<span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span>
								</div>
								<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
								</div>
								</a>
								<p class="text-center no-margin" style="font-size: 12px">Black Light</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
								<a class="clearfix full-opacity-hover" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" data-skin="skin-purple-light" href="javascript:void(0);">
								<div>
								<span class="bg-purple-active" style="display:block; width: 20%; float: left; height: 7px;"></span>
								<span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
								</div>
								<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
								</div>
								</a>
								<p class="text-center no-margin" style="font-size: 12px">Purple Light</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
								<a class="clearfix full-opacity-hover" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" data-skin="skin-green-light" href="javascript:void(0);">
								<div>
								<span class="bg-green-active" style="display:block; width: 20%; float: left; height: 7px;"></span>
								<span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
								</div>
								<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
								</div>
								</a>
								<p class="text-center no-margin" style="font-size: 12px">Green Light</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
								<a class="clearfix full-opacity-hover" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" data-skin="skin-red-light" href="javascript:void(0);">
								<div>
								<span class="bg-red-active" style="display:block; width: 20%; float: left; height: 7px;"></span>
								<span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
								</div>
								<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
								</div>
								</a>
								<p class="text-center no-margin" style="font-size: 12px">Red Light</p>
							</li>
							<li style="float:left; width: 33.33333%; padding: 5px;">
								<a class="clearfix full-opacity-hover" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" data-skin="skin-yellow-light" href="javascript:void(0);">
								<div>
								<span class="bg-yellow-active" style="display:block; width: 20%; float: left; height: 7px;"></span>
								<span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
								</div>
								<div>
								<span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
								<span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
								</div>
								</a>
								<p class="text-center no-margin" style="font-size: 12px;">Yellow Light</p>
							</li>
						</ul>
					</div>
					<!--- end panel body--->
				</div>
				<!--- end panel --->
			</div>
		<!--- end col --->
			<div class="col-md-8">
			</div>
		<!--- end col --->
		</div><!--- end row --->
	</section>
	
<?php
	$this->load->view('layout/footer.php');
?>
