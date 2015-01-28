<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title><?= $config['sitename'] ?> <?= isset($config['pagename']) ? " | " . $config['pagename'] : "" ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="apple-touch-icon" href="/pages/ico/60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/pages/ico/76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/pages/ico/120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/pages/ico/152.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description" />
    <meta content="" name="author" />
     <!-- BEGIN Vendor CSS-->
    <link href="/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/jquery-scrollbar/jquery.scrollbar.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="/assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="/assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="/assets/plugins/dropzone/css/dropzone.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.4/styles/default.min.css">
	
    <!-- BEGIN Pages CSS-->
    <link href="/pages/css/pages-icons.css" rel="stylesheet" type="text/css">
    <link class="main-stylesheet" href="/pages/css/pages.css" rel="stylesheet" type="text/css" />

    <!--[if lte IE 9]>
        <link href="/pages/css/ie9.css" rel="stylesheet" type="text/css" />
    <![endif]-->

    <script type="text/javascript">
    window.onload = function() {
        // fix for windows 8
        if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
            document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="/pages/css/windows.chrome.fix.css" />'
    }
    </script>
</head>

<body class="fixed-header">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar" data-pages="sidebar">
      <div id="appMenu" class="sidebar-overlay-slide from-top">
      </div>
        <!-- BEGIN SIDEBAR HEADER -->
        <div class="sidebar-header">
	        <!--
            <img src="assets/img/logo_white.png" alt="logo" class="brand" data-src="assets/img/logo_white.png" data-src-retina="assets/img/logo_white_2x.png" width="93" height="25">
            -->
           <div class="sidebar-header-controls">
            <button data-pages-toggle="#appMenu" class="btn btn-xs sidebar-slide-toggle btn-link m-l-20" type="button"><i class="fa fa-angle-down fs-16"></i></button>
            <button data-toggle-pin="sidebar" class="btn btn-link visible-lg-inline" type="button"><i class="fa fs-12"></i></button>
          </div>
        </div>
        <!-- END SIDEBAR HEADER -->
        <!-- BEGIN SIDEBAR MENU -->
        <div class="sidebar-menu">
	        <ul class="menu-items">
	            <?php
		        if(user::isStudent()){
			        if(isset($config['assignment_do'])){
				        require 'menu-student-do.php';
			        }else{
				        require 'menu-student.php';
				    }
		        }elseif(user::isTeacher()){
			        require 'menu-teacher.php';
		        } 
		        ?>
				<li class="">
				    <a href="/apiv2.1/logout/">
				        <span class="title">Logout</span>				        
				    </a>
				    <span class="icon-thumbnail"><i class="fa fa-sign-out"></i>
				    </span>        				    
				</li>		        
	        </ul>
            <div class="clearfix"></div>
        </div>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
    <!-- START PAGE-CONTAINER -->
    <div class="page-container">
        <!-- START PAGE HEADER WRAPPER -->
        <!-- START HEADER -->
        <div class="header ">
            <!-- START MOBILE CONTROLS -->
            <!-- LEFT SIDE -->
            <div class="pull-left full-height visible-sm visible-xs">
                <!-- START ACTION BAR -->
                <div class="sm-action-bar">
                    <a href="#" class="btn-link toggle-sidebar" data-toggle="sidebar">
                        <span class="icon-set menu-hambuger"></span>
                    </a>
                </div>
                <!-- END ACTION BAR -->
            </div>
            <!-- RIGHT SIDE -->
            <div class="pull-right full-height visible-sm visible-xs">
                <!-- START ACTION BAR -->
                <div class="sm-action-bar">
                    <a href="#" class="btn-link" data-toggle="quickview" data-toggle-element="#quickview">
                        <span class="icon-set menu-hambuger-plus"></span>
                    </a>
                </div>
                <!-- END ACTION BAR -->
            </div>
            <!-- END MOBILE CONTROLS -->
            <div class=" pull-left sm-table">
                <div class="header-inner">
                    <div class="brand inline">
	                    <!--
                        <img src="assets/img/logo.png" alt="logo" data-src="assets/img/logo.png" data-src-retina="assets/img/logo_2x.png" width="93" height="25">
                        -->
                        <h3><i class="fa fa-code"></i> CodeTogether</h3>
                    </div>
                    <!-- BEGIN NOTIFICATION DROPDOWN -->
                    <ul class="notification-list no-margin hidden-sm hidden-xs b-grey b-l b-r no-style p-l-30 p-r-20">
                        <li class="p-r-15 inline">
                            <div class="dropdown">
                                <a href="javascript:;" id="notification-center" class="icon-set globe-fill" data-toggle="dropdown">
                                    <span class="bubble"></span>
                                </a>
                                <div class="dropdown-menu notification-toggle" role="menu" aria-labelledby="notification-center">
                                    <div class="notification-panel">
                                        <!-- START Notification Body-->
                                        <div class="notification-body scrollable">
                                             <!-- START Notification Item-->
                                            <div class="notification-item  clearfix">
                                                <div class="heading">
                                                    <a href="#" class="text-danger">
                                                        <i class="fa fa-exclamation-triangle m-r-10"></i>
                                                        <span class="bold">98% Server Load</span>
                                                        <span class="fs-12 m-l-10">Take Action</span>
                                                    </a>
                                                    <span class="pull-right time">
                                                        2 mins ago
                                                    </span>
                                                </div>
                                                <div class="option">
                                                    <a href="#" class="mark"></a>
                                                </div>
                                            </div>
                                             <!-- END Notification Item-->
                                        </div>
                                        <!-- END Notification Body-->
                                        <!-- START Notification Footer-->
                                        <div class="notification-footer text-center">
                                            <a href="#" class="">Read all notifications</a>
                                            <a data-toggle="refresh" class="portlet-refresh text-black pull-right" href="#">
                                                <i class="pg-refresh_new"></i>
                                            </a>
                                        </div>
                                         <!-- END Notification Footer-->
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="p-r-15 inline">
                            <a href="#" class="icon-set clip "></a>
                        </li>
                        <li class="p-r-15 inline">
                            <a href="#" class="icon-set grid-box"></a>
                        </li>
                    </ul>
                    <!-- END NOTIFICATION DROPDOWN -->
                    <?php
	                if(isset($config['assignment_do'])):
	                ?>
                    <a href="#" class="search-link" data-toggle="search"><i class="pg-search"></i>
	                    Java Documentation <span class="bold">Search</span>
	                </a> 
	                <?php
		            endif;
	                ?>
                </div>
            </div>
            <!--
            <div class=" pull-right">
                <div class="header-inner">
                    <a href="#" class="btn-link icon-set menu-hambuger-plus m-l-20 sm-no-margin hidden-sm hidden-xs" data-toggle="quickview" data-toggle-element="#quickview"></a>
                </div>
            </div>
            -->
            <div class=" pull-right">
                <!-- START User Info-->
                <div class="visible-lg visible-md m-t-10">
                    <div class="pull-left p-r-10 p-t-10 fs-16 font-heading">
                        <span class="semi-bold"><?= user::authService()['user_name'] ?></span>
                        <span class="text-master"></span>
                    </div>
                    <div class="thumbnail-wrapper d32 circular inline m-t-5">
                        <img src="<?= user::avatar() ?>" alt="" width="32" height="32">
                    </div>
                </div>
                <!-- END User Info-->
            </div>
        </div>
        <!-- END HEADER -->
        <!-- END PAGE HEADER WRAPPER -->      