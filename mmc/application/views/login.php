<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<link rel="shortcut icon" href="<?php echo site_url('asset/images/favicon.ico'); ?>" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $this->config->item('web_title'); ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo site_url('asset/css/bootstrap.min.css'); ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo site_url('asset/font/font-awesome/css/font-awesome.min.css'); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo site_url('asset/css/AdminLTE.min.css'); ?>">

	<!-- jQuery 2.1.4 -->
    <script src="<?php echo site_url('asset/js/jQuery-2.1.4.min.js'); ?>"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo site_url('asset/js/bootstrap.min.js'); ?>"></script>
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
</head>
<body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
         <center><img src="<?php echo base_url()."asset/images/logos/".$this->config->item('logo_url'); ?>" style="max-width:200px;" class="img-round"></center>
		 <a href="#"><b><?php echo $this->config->item('web_title'); ?></b><br/><h4><?php echo $this->config->item('namars'); ?></h4></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <?php echo form_open('login'); ?>
			<fieldset>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
					<input class="form-control" placeholder="Username" name="username" id="username" type="text" autofocus>
				</div>
				<br />
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
					<input class="form-control" placeholder="Password" name="password" id="password" type="password" value="">
				</div>
				<input type="hidden" name="v_url" id="v_url" value="<?php //echo $v_url; ?>">
				<hr></hr>
				<!-- Change this to a button or input when using this as a form -->	
				<table width='100%'>
					<tr>
						<td width='60%'><a href='#'>Reset Password?</a><br/>
						SIMRS</td>
						<td width='40%'><input class="btn btn-block btn-success" type="submit" value="Log In"></td>
					</tr>
				</table>
			</fieldset>
		<?php echo form_close(); ?>
      </div><!-- /.login-box-body -->
		<p style="color:red;"><?php echo validation_errors();?></p>
    </div><!-- /.login-box -->
  </body>
</html>
