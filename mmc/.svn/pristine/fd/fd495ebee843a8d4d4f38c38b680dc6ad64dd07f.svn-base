<?php 
if(!isset($_GET['rel'])){
?>
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
    <link rel="stylesheet" href="<?php echo site_url('asset/css/jquery-ui.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('asset/css/sweetalert.css'); ?>">    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo site_url('asset/font/font-awesome/css/font-awesome.min.css'); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo site_url('asset/css/AdminLTE.min.css'); ?>">
    <!-- Choose a skin from the css/skins to reduce the load. -->
    <link rel="stylesheet" href="<?php echo site_url('asset/css/skins/_all-skins.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('asset/css/jquery.autocomplete.css'); ?>">
    <!-- Morris charts -->
    <link rel="stylesheet" href="<?php echo site_url('asset/plugins/morris/morris.css'); ?>">
    
	<!-- jQuery 2.1.4 -->
    <script src="<?php echo site_url('asset/js/jQuery-2.1.4.min.js'); ?>"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo site_url('asset/js/jquery-ui.min.js'); ?>"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
		$.widget.bridge('uibutton', $.ui.button);
		var baseurl = "<?php print base_url(); ?>";
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo site_url('asset/js/bootstrap.min.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo site_url('asset/js/app.min.js'); ?>"></script>
    <script src="<?php echo site_url('asset/plugins/jquery.jclock.js'); ?>"></script>
    <script src="<?php echo site_url('asset/plugins/jquery.autocomplete.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo site_url('asset/plugins/datepicker/datepicker3.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('asset/plugins/daterangepicker/daterangepicker-bs3.css'); ?>">
    <script src="<?php echo site_url('asset/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
    <script src="<?php echo site_url('asset/plugins/jquery-validation/js/jquery.validate.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo site_url('asset/plugins/timepicker/bootstrap-timepicker.css'); ?>">
    <script src="<?php echo site_url('asset/plugins/timepicker/bootstrap-timepicker.js'); ?>"></script>
    <script src="<?php echo site_url('asset/js/hmis.js'); ?>"></script>

    <!-- ChartJS 1.0.1 -->
    <script src="<?php echo site_url('asset/plugins/chartjs/Chart.min.js'); ?>"></script> 

    <!-- Morris.js charts -->
    <script src="<?php echo site_url('asset/plugins/morris/morris.min.js'); ?>"></script> 
    <script src="<?php echo site_url('asset/plugins/morris/raphael-min.js'); ?>"></script> 
	
	<!-- Mask Money -->
	<script src="<?php echo site_url('asset/js/jquery.maskMoney.js'); ?>" type="text/javascript"></script>
	

	<!-- Data Table -->
	<link rel="stylesheet" href="<?php echo site_url('asset/css/smoothness/jquery-ui.css'); ?>">
	<link rel="stylesheet" href="<?php echo site_url('asset/css/dataTables.jqueryui.css'); ?>">
	<script src="<?php echo site_url('asset/js/jquery.dataTables.js'); ?>"></script>
	<script src="<?php echo site_url('asset/js/dataTables.jqueryui.js'); ?>"></script>
  <script src="<?php echo site_url('asset/js/sweetalert.min.js'); ?>"></script>  
	
	<!-- iCheck -->
	
	<link rel="stylesheet" href="<?php echo site_url('asset/plugins/iCheck/all.css'); ?>">
	<script src="<?php echo site_url('asset/plugins/iCheck/icheck.min.js'); ?>"></script>
	

	<!-- SELECT2 -->
	<link rel="stylesheet" href="<?php echo site_url('asset/plugins/select2/select2.min.css'); ?>">
	<script src="<?php echo site_url('asset/plugins/select2/select2.full.min.js'); ?>"></script>
	<!-- date range picker -->
  <script src="<?php echo site_url('asset/plugins/daterangepicker/moment.min.js'); ?>"></script>
  <script src="<?php echo site_url('asset/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo site_url(); ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><img src='<?php echo site_url().'asset/images/logos/'.$this->config->item('logo_url'); ?>' style="max-height:45px"></img></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><img src='<?php echo site_url().'asset/images/logos/'.$this->config->item('logo_url'); ?>' style="max-height:45px"></img> <?php echo $this->config->item('header_title'); ?></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
              <!-- Notifications: style can be found in dropdown.less -->
             
              <!-- Tasks: style can be found in dropdown.less -->
              <li class="dropdown tasks-menu">
                <a href="#">
                  <div id="jclock1" class="simpleclock"></div>
                </a>
              </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
				<?php 
				if ($user_info->foto==NULL || $user_info->foto=='') 
          $foto = site_url().'upload/user/unknown.png';
				else 
          $foto = site_url().'upload/user/'.$user_info->foto;
				?>				
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo $foto; ?>" class="user-image fotouser" alt="User Image">
                  <?php echo $user_info->username; ?><span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->                  
                  <li class="user-header">
					<div class="user-photo">
						<form id="chUserPhoto" class="photoForm" method="POST" enctype="multipart/form-data"><input type="file" name="userfile" id="userfile2" accept="image/jpeg, image/png, image/gif"/><input type="hidden" id="uid" name="uid" value="<?php echo $user_info->username; ?>"></form>
						<img src="<?php echo $foto; ?>" class="img-circle fotouser" alt="User Image">
						<a href="#" class="header-uphoto" title="Change Photo">&nbsp;<i class="fa fa-camera"> &nbsp;</i></a>
					</div>
					<div id="user-name" class="user-name">
						<p><span id="uname-txt"><?php echo $user_info->name; ?></span>&nbsp;<a href="#" title="Change Name"><i class="fa fa-edit" id="user-input"></i></a></p>
						<form id="chUserName">
						  <div class="input-group" id="user-txt">
							<input type="text" class="form-control" name="uname" value="<?php echo $user_info->name; ?>">
							<input type="hidden" id="uid" name="uid" value="<?php echo $user_info->username; ?>">
							<span class="input-group-btn">
							  <button class="btn btn-info btn-flat" type="submit">Simpan</button>
							</span>
						  </div>
						 </form>
					</div>
                  </li>
                  <!-- Menu Body -->
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
						<a href="#"  onClick="return openUrl('<?php echo site_url('user/Change_password'); ?>');" class="btn btn-default btn-flat">Change Password</a>
					</div>
                    <div class="pull-right">
                      <a href="<?php echo site_url('logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo $foto; ?>" class="img-circle fotouser" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php echo $user_info->username; ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MENU UTAMA</li>
			<li><a href="<?php echo site_url(); ?>"><i class="fa fa-home"></i> <span>Beranda</span></a></li>
			<?php echo buildMenu(); ?>       
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
	<div id="page-content">
<?php 
}
?>

<div id="page-content" >
    <!-- Content Header (Page header) -->
    <section class="content-header">
		<h1><?php echo $title; ?></h1>
        <ol class="breadcrumb">
			<?php echo buildBreadcrumb(); ?>
        </ol>
    </section>
</div>


