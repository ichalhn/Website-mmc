<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<!--<link rel="shortcut icon" type="image/ico" href="http://www.datatables.net/favicon.ico">-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HMIS</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo site_url('asset/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('asset/css/jquery-ui.css'); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo site_url('asset/font/font-awesome/css/font-awesome.min.css'); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo site_url('asset/css/AdminLTE.min.css'); ?>">
    <!-- Choose a skin from the css/skins to reduce the load. -->
    <link rel="stylesheet" href="<?php echo site_url('asset/css/skins/_all-skins.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('asset/css/jquery.autocomplete.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('asset/css/hmis.css'); ?>">

	<!-- jQuery 2.1.4 -->
    <script src="<?php echo site_url('asset/js/jQuery-2.1.4.min.js'); ?>"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo site_url('asset/js/jquery-ui.min.js'); ?>"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo site_url('asset/js/bootstrap.min.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo site_url('asset/js/app.min.js'); ?>"></script>
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
<style>

</style>
</head>

<body background="<?php echo base_url(); ?>asset/images/light-green-background.jpg">
   <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">

		<div class="login-panel panel panel-default" style="margin-top:10%;">
                    <div class="panel-body">
                         <h1 style="color:#fc6917;"><center>404</center></h1>
                         <h3><center>Page Not Found or File Not Exist !</center></h3>                   
                    </div>
		</div>
		<br>
		<div>
		<center><a class="btn btn-default" href="<?php echo base_url(); ?>" style="background-color:white;width:100px;color:#fc6917;"><h5><b>H O M E</b></h5></a><a class="btn btn-default" onclick="goBack()" style="background-color:white;width:100px;color:#fc6917;"><h5><b>B A C K</b></h5></a></center>
		</div>												
            </div>
        </div>
	<footer class="footer navbar-fixed-bottom" style="background-color:white;height:50px;">
		<div style="width:70%; margin:0 auto;padding-top:10px;">
			<div class="pull-right hidden-xs">
			  <b>Version</b> 1.0.0
			</div>
			<strong>Copyright &copy; 2016.</strong> All rights reserved.
		</div>
      </footer>
    </div>

<script type="text/javascript">
$(document).ready(function() {
	
	//alert(referrer);
});
function goBack(){
	var referrer =  document.referrer;
	window.location= referrer;
}

/*
$(function() {

});
*/
</script>
</body>
</html>
