<?php 
 if(!isset($_GET['rel'])){ 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">    
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_url('assets/images/mintohardjo.ico'); ?>">
    <title><?php echo $this->config->item('web_title'); ?></title>    
    <!-- <link href="<?php echo site_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet"> -->
    <link href="<?php echo site_url('assets/dashboard/css/bootstrap.min.css'); ?>" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/jqueryui/jquery-ui.css'); ?>">
    <link href="<?php echo site_url('assets/plugins/timepicker/bootstrap-timepicker.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo site_url('assets/plugins/bootstrap-daterangepicker/daterangepicker.css'); ?>" rel="stylesheet">    
    <link href="<?php echo site_url('assets/horizontal/css/style-dashboard.css'); ?>" rel="stylesheet">    
    <link href="<?php echo site_url('assets/horizontal/css/colors/blue.css'); ?>" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!--   <link rel="stylesheet" href="<?php echo site_url('assets/plugins/datatables/jquery.dataTables.min.css'); ?>"> -->
    <link rel="stylesheet" href="<?php echo site_url('assets/css/jquery.autocomplete.css'); ?>">
    <link href="<?php echo site_url('assets/plugins/clockpicker/dist/jquery-clockpicker.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/bootstrap-daterangepicker/daterangepicker.css'); ?>">    
    <link href="<?php echo site_url('assets/plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet" type="text/css">
    <style type="text/css">
      td.dataTables_empty { text-align: center; }
      .demo-checkbox label, .demo-radio-button label {
      min-width: 130px;
      margin-bottom: 0;
      }    
      a:focus { 
          color: #fff;
      }
      .main-navigation .menu li a {
        display: block;
        font-size: 12px;
        color: #999;
        text-transform: uppercase;
        text-decoration: none;
        letter-spacing: .1em;
        padding-left: 20px;
        padding-right: 20px;
        -webkit-transition: color 0.3s;
        -o-transition: color 0.3s;
        transition: color 0.3s;
      }
      .floating-menu-btn {
          display: block;
          position: fixed;
          z-index: 100;
          top: 10px;
          right: 35px;
          width: 46px;
          height: 46px;
          border-radius: 50%;
      }
      .floating-menu-btn .floating-menu-toggle .bar {
          width: 18px;
          margin: 0 0 4px 0;
      }
      .mobile-menu-toggle .bar, .floating-menu-toggle .bar {
          display: block;
          will-change: transform, opacity;
          width: 32px;
          height: 2px;
          margin: 0 0 6px 0;
          background: #333;
          opacity: 1;
          -webkit-transform: translate(0) rotate(0deg);
          -moz-transform: translate(0) rotate(0deg);
          -ms-transform: translate(0) rotate(0deg);
          -o-transform: translate(0) rotate(0deg);
          transform: translate(0) rotate(0deg);
          -webkit-transition: all 0.2s ease-out;
          -o-transition: all 0.2s ease-out;
          transition: all 0.2s ease-out;
      }
      .floating-header {
          position: absolute;
          z-index: 100;
          display: block;
          width: 100%;
          /*padding: 35px*/
      }

      .floating-header .site-logo {
          max-width:79px;
          padding: 0;
          margin: 0 !important
      }

      .floating-header+* {
          padding-top: 10px
      }

      @media screen and (max-width: 768px) {
          .floating-header {
              padding: 25px 15px
          }
          .floating-header+* {
              padding-top: 5px
          }
      }

      .floating-header .main-navigation-wrap {
          position: fixed;
          z-index: 110;
          display: table;
          width: 300px;
          height: 100%;
          top: 110px;
          left: 50%;
          margin-left: -150px;
          overflow: hidden;
          visibility: hidden
      }

      .floating-header .main-navigation {
          position: relative;
          display: table-cell;
          vertical-align: middle;
          top: auto;
          right: auto;
          padding: 0;
          text-align: center;
          top: -110px;
          overflow: hidden;
          opacity: 0;
          -webkit-transform: translateY(35px);
          -moz-transform: translateY(35px);
          -ms-transform: translateY(35px);
          -o-transform: translateY(35px);
          transform: translateY(35px);
          -webkit-transition: all 0.35s 0.2s;
          -o-transition: all 0.35s 0.2s;
          transition: all 0.35s 0.2s
      }

      .floating-header .main-navigation .menu {
          display: inline-block;
          width: 100%;
          -webkit-transform: translate3d(0, 0, 0);
          -moz-transform: translate3d(0, 0, 0);
          -ms-transform: translate3d(0, 0, 0);
          -o-transform: translate3d(0, 0, 0);
          transform: translate3d(0, 0, 0);
          -webkit-transition: all 0.4s cubic-bezier(0.86, 0, 0.07, 1);
          -o-transition: all 0.4s cubic-bezier(0.86, 0, 0.07, 1);
          transition: all 0.4s cubic-bezier(0.86, 0, 0.07, 1)
      }

      .floating-header .main-navigation .menu.off-view {
          -webkit-transform: translate3d(-100%, 0, 0);
          -moz-transform: translate3d(-100%, 0, 0);
          -ms-transform: translate3d(-100%, 0, 0);
          -o-transform: translate3d(-100%, 0, 0);
          transform: translate3d(-100%, 0, 0)
      }

      .floating-header .main-navigation .menu.in-view {
          -webkit-transform: translate3d(0, 0, 0);
          -moz-transform: translate3d(0, 0, 0);
          -ms-transform: translate3d(0, 0, 0);
          -o-transform: translate3d(0, 0, 0);
          transform: translate3d(0, 0, 0)
      }

      .floating-header .main-navigation .menu>li {
          position: static;
          border-bottom: none
      }

      .floating-header .main-navigation .menu>li>a {
          padding-top: 9px;
          padding-bottom: 9px
      }

      .floating-header .main-navigation .menu li {
          display: block
      }

      .floating-header .main-navigation .menu li a {
          display: block;
          font-size: 16px
      }

      .floating-header .main-navigation .menu li.menu-item-has-children>.sub-menu {
          position: absolute;
          display: block;
          width: 100%;
          height: auto;
          top: 0;
          left: auto;
          right: -100%;
          padding: 0;
          -webkit-box-shadow: none;
          box-shadow: none;
          -webkit-transform: translate3d(100%, 0, 0);
          -moz-transform: translate3d(100%, 0, 0);
          -ms-transform: translate3d(100%, 0, 0);
          -o-transform: translate3d(100%, 0, 0);
          transform: translate3d(100%, 0, 0);
          -webkit-transition: all 0.4s cubic-bezier(0.86, 0, 0.07, 1);
          -o-transition: all 0.4s cubic-bezier(0.86, 0, 0.07, 1);
          transition: all 0.4s cubic-bezier(0.86, 0, 0.07, 1)
      }

      .floating-header .main-navigation .menu li.menu-item-has-children>.sub-menu>li>a {
          padding-top: 9px;
          padding-bottom: 9px
      }

      .floating-header .main-navigation .menu li.menu-item-has-children>.sub-menu.in-view {
          -webkit-transform: translate3d(0, 0, 0);
          -moz-transform: translate3d(0, 0, 0);
          -ms-transform: translate3d(0, 0, 0);
          -o-transform: translate3d(0, 0, 0);
          transform: translate3d(0, 0, 0)
      }

      .floating-header .main-navigation .menu li.menu-item-has-children>.sub-menu.off-view {
          -webkit-transform: translate3d(-100%, 0, 0);
          -moz-transform: translate3d(-100%, 0, 0);
          -ms-transform: translate3d(-100%, 0, 0);
          -o-transform: translate3d(-100%, 0, 0);
          transform: translate3d(-100%, 0, 0)
      }

      .floating-header .main-navigation .menu li.menu-item-has-children:hover .sub-menu {
          -webkit-animation: none;
          -o-animation: none;
          animation: none
      }

      .floating-header .main-navigation.is-visible {
          visibility: visible;
          opacity: 1;
          -webkit-transform: translateY(0);
          -moz-transform: translateY(0);
          -ms-transform: translateY(0);
          -o-transform: translateY(0);
          transform: translateY(0)
      }

      .ie .floating-header .main-navigation-wrap .main-navigation,
      .edge .floating-header .main-navigation-wrap .main-navigation,
      .firefox .floating-header .main-navigation-wrap .main-navigation {
          top: 0
      }

      .android .floating-header .main-navigation-wrap .main-navigation,
      .ios .floating-header .main-navigation-wrap .main-navigation {
          -webkit-transition: all 0.25s 0s;
          -o-transition: all 0.25s 0s;
          transition: all 0.25s 0s
      }
      .floating-menu-btn {
          display: block;
          position: fixed;
          z-index: 100;
          top: 5px;
          right: 35px;
          width: 46px;
          height: 46px;
          border-radius: 50%
      }

      .floating-menu-btn:before {
          display: block;
          position: absolute;
          z-index: -1;
          content: "";
          width: 46px;
          height: 46px;
          background-color: #fff;
          border-radius: 50%;
          -webkit-transform-origin: center 30%;
          -moz-transform-origin: center 30%;
          -ms-transform-origin: center 30%;
          transform-origin: center 30%;
          -webkit-transform: scale(1);
          -moz-transform: scale(1);
          -ms-transform: scale(1);
          -o-transform: scale(1);
          transform: scale(1);
          -webkit-transition: all 0.35s ease-out;
          -o-transition: all 0.35s ease-out;
          transition: all 0.35s ease-out;
          -webkit-box-shadow: 0px 12px 18px 0px rgba(0, 0, 0, 0.26);
          box-shadow: 0px 12px 18px 0px rgba(0, 0, 0, 0.26)
      }

      .floating-menu-btn .floating-menu-toggle-wrap {
          position: absolute;
          z-index: 1;
          width: 46px;
          height: 46px;
          border-radius: 50%;
          top: 28px;
          left: 27px;
          cursor: pointer
      }

      .floating-menu-btn .floating-menu-toggle {
          display: block;
          width: 18px;
          right: auto;
          left: 50%;
          margin-top: -10px;
          margin-left: -13px
      }

      .floating-menu-btn .floating-menu-toggle .bar {
          width: 18px;
          margin: 0 0 4px 0
      }

      .floating-menu-btn .floating-menu-toggle .bar:last-child {
          margin-bottom: 0
      }

      .floating-menu-btn.expanded .floating-menu-toggle {
          -webkit-transform: rotate(-180deg);
          -moz-transform: rotate(-180deg);
          -ms-transform: rotate(-180deg);
          -o-transform: rotate(-180deg);
          transform: rotate(-180deg)
      }

      .floating-menu-btn.expanded .floating-menu-toggle .bar:nth-child(1) {
          -webkit-transform: translate(-9px, 3px) rotate(-45deg) scale(0.5, 1);
          -moz-transform: translate(-9px, 3px) rotate(-45deg) scale(0.5, 1);
          -ms-transform: translate(-9px, 3px) rotate(-45deg) scale(0.5, 1);
          -o-transform: translate(-9px, 3px) rotate(-45deg) scale(0.5, 1);
          transform: translate(-9px, 3px) rotate(-45deg) scale(0.5, 1)
      }

      .floating-menu-btn.expanded .floating-menu-toggle .bar:nth-child(3) {
          -webkit-transform: translate(-9px, -3px) rotate(45deg) scale(0.5, 1);
          -moz-transform: translate(-9px, -3px) rotate(45deg) scale(0.5, 1);
          -ms-transform: translate(-9px, -3px) rotate(45deg) scale(0.5, 1);
          -o-transform: translate(-9px, -3px) rotate(45deg) scale(0.5, 1);
          transform: translate(-9px, -3px) rotate(45deg) scale(0.5, 1)
      }

      .floating-menu-btn.expanded:before {
          -webkit-transform: scale(80);
          -moz-transform: scale(80);
          -ms-transform: scale(80);
          -o-transform: scale(80);
          transform: scale(80)
      }

      @media screen and (max-width: 768px) {
          .floating-menu-btn {
              right: 15px
          }
          .table-mobile {font-family: Arial; font-size: 9pt;}
      }
      .clickable-row {
          cursor: pointer;
      }
    </style>
    <style type="text/css">
      @media screen and (max-width: 768px) {
        .card-body {
          padding-left: 3px;
          padding-right: 3px;
        }
        .dashboard-heading {
          font-size: 14px;
          font-weight: bold;
        }
        .ml-auto {
          float: none;
          margin: 0 auto;
          text-align: center;
          width: 100%;
        }
      }
    </style>
    <style type="text/css">
      td.dataTables_empty { text-align: center; }
      .demo-checkbox label, .demo-radio-button label {
      min-width: 130px;
      margin-bottom: 0;
      }    
      a:focus { 
          color: #fff;
      }
      body {
        background: #ededed;
      }

      .bg-dark {
          background-color: #4d545d!important;
      }
      
      .page-wrapper-dashboard {
        padding-top: 30px;
        background-color: #ededed;
      }
      
      @media screen and (max-width: 768px) {
        .page-wrapper-dashboard {
          padding-top: 15px;
          background-color: #ededed;
        }
        .header-dashboard {
          font-size: 14px;
        }
      }
      @media screen and (max-width: 480px) {
        .page-wrapper-dashboard {
          padding-top: 15px;     
        }
        .header-dashboard {
          font-size: 12px;
        }
      }
      
    </style>
    <script src="<?php echo site_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/jqueryui/jquery-ui.js'); ?>"></script>    
    <script src="<?php echo site_url('assets/plugins/bootstrap/js/tether.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/js/bootstrap3-typeahead.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/hmis.js'); ?>"></script>    
    <script src="<?php echo site_url('assets/horizontal/js/jquery.slimscroll.js'); ?>"></script>
    <script src="<?php echo site_url('assets/horizontal/js/waves.js'); ?>"></script>
    <script src="<?php echo site_url('assets/horizontal/js/sidebarmenu.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/sparkline/jquery.sparkline.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/horizontal/js/custom.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/moment/moment.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/clockpicker/dist/jquery-clockpicker.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/timepicker/bootstrap-timepicker.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>   
    <script src="<?php echo site_url('assets/plugins/jquery.autocomplete.js'); ?>"></script>    
    <script src="<?php echo site_url('assets/plugins/sweetalert/sweetalert.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/sweetalert/jquery.sweet-alert.custom.js'); ?>"></script>    
    <script src="<?php echo site_url('assets/js/jquery.maskMoney.js'); ?>" type="text/javascript"></script>    
    <script src="<?php echo site_url('assets/plugins/jquery-validation/js/jquery.validate.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/js/validation.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/validator.js'); ?>" type="text/javascript"></script>    
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/select2/dist/css/select2.min.css'); ?>">
    <script src="<?php echo site_url('assets/plugins/select2/dist/js/select2.full.min.js'); ?>"></script>    
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/icheck/skins/all.css'); ?>">
    <script src="<?php echo site_url('assets/plugins/icheck/icheck.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/morrisjs/morris.min.js'); ?>"></script> 
    <script src="<?php echo site_url('assets/plugins/raphael/raphael-min.js'); ?>"></script>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
      var $floatingMenuToggle = $('.floating-menu-toggle-wrap'),
          $floatingMenu = $('.floating-header .main-navigation'),
          $floatingMenuItem = $('.floating-header .main-navigation .menu > li');
      if($floatingMenu.length) {
        $floatingMenuItem.each(function(index, element) {
          $(element).addClass('delay-' + index);
        });

        $floatingMenuToggle.click(function() {
          var clicks = $(this).data('clicks');
          if (clicks) {
            $floatingMenu.removeClass('is-visible');
            setTimeout(function(){
              $floatingMenuToggle.parent().removeClass('expanded');
            }, 500);
          } else {
            $floatingMenuToggle.parent().addClass('expanded');
            $floatingMenu.addClass('is-visible');
          }
          $(this).data("clicks", !clicks);
        });
      }

      // Back Button
      var backBtnText = $floatingMenu.data( 'back-btn-text' ),
          subMenu = $( '.floating-header .main-navigation .sub-menu' );

      subMenu.each( function () {
        $( this ).prepend( '<li class="back-btn"><a href="#"><i class="fa fa-arrow-left" aria-hidden="true"></i>' + backBtnText + '</a></li>' );
      } );

      var hasChildLink = $( '.floating-header .menu-item-has-children > a' ),
        backBtn = $( '.floating-header .main-navigation .sub-menu .back-btn' );

      backBtn.on('click', function (e) {
        var self = this,
          parent = $( self ).parent(),
          siblingParent = $( self ).parent().parent().siblings().parent(),
          menu = $( self ).parents( '.menu' );

        parent.removeClass( 'in-view' );
        siblingParent.removeClass( 'off-view' );

        e.stopPropagation();
      });

      hasChildLink.on( 'click', function ( e ) {
        var self = this,
          parent = $( self ).parent().parent(),
          menu = $( self ).parents( '.menu' );

        parent.addClass( 'off-view' );
        $( self ).parent().find( '> .sub-menu' ).addClass( 'in-view' );

        e.preventDefault();
        return false;
      });
      $(".clickable-row").click(function() {
          window.location = $(this).data("href");
      });
    });
    /******************************************************************/ 
    </script>    
  </head>

  <body class="fix-sidebar card-no-border"> 
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
     <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="<?php echo site_url('dashboard'); ?>">
          <img src="<?php echo base_url()."assets/images/logos/".$this->config->item('logo_url'); ?>" width="30" height="30" class="d-inline-block align-top" alt="">
          RSAL MINTOHARDJO
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="<?php echo site_url('dashboard'); ?>">Menu Utama <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo site_url('user/Change_password'); ?>">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo site_url('/logout'); ?>">Logout</a>
            </li>
          </ul>
        </div>
      </nav>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" style="margin-left: 0px;">
        <div class="page-wrapper-dashboard">

        <div class="col-md-12">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div id="container-fluid" class="container-fluid">
<?php 
 }
?>            
