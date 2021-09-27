<?php 
if(!isset($_GET['rel'])){
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HMIS | <?php //echo $title; ?></title>
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
    <script src="<?php echo site_url('asset/plugins/jquery.jclock.js'); ?>"></script>
    <script src="<?php echo site_url('asset/plugins/jquery.autocomplete.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo site_url('asset/plugins/datepicker/datepicker3.css'); ?>">
    <script src="<?php echo site_url('asset/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
    <script src="<?php echo site_url('asset/js/hmis.js'); ?>"></script>
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
          <span class="logo-mini"><b>A</b>LT</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>RS </b>Partria</span>
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
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo site_url('asset/images/user2-160x160.jpg'); ?>" class="user-image" alt="User Image">
                  <span class="hidden-xs">Alexander Pierce</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  
                  <!-- Menu Body -->
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-right">
                      <a href="#" class="btn btn-default btn-flat">Sign out</a>
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
              <img src="<?php echo site_url('asset/images/user2-160x160.jpg'); ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>Alexander Pierce</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MENU UTAMA</li>
      <?php echo buildMenu(); ?>       
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside> 
    <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
<?php 
}
?>     
  <div id="page-content">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1><?php //echo $title; ?></h1>
          <ol class="breadcrumb">
      <?php //echo buildBreadcrumb(); ?>
          </ol>
        </section>