<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Lextorah Dashboard">
    <meta name="author" content="Fashola Benjamen">
    <title>@yield('title')</title>
    
    <link rel="apple-touch-icon" sizes="57x57" href="{{ env('BASE_PATH') }}images/icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ env('BASE_PATH') }}images/icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ env('BASE_PATH') }}images/icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ env('BASE_PATH') }}images/icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ env('BASE_PATH') }}images/icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ env('BASE_PATH') }}images/icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ env('BASE_PATH') }}images/icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ env('BASE_PATH') }}images/icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ env('BASE_PATH') }}images/icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ env('BASE_PATH') }}images/icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ env('BASE_PATH') }}images/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ env('BASE_PATH') }}images/icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ env('BASE_PATH') }}images/icon/favicon-16x16.png">
    <link rel="manifest" href="{{ env('BASE_PATH') }}images/icon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ env('BASE_PATH') }}images/icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ env('BASE_PATH') }}app-assets/css/bootstrap.css">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="{{ env('BASE_PATH') }}app-assets/fonts/icomoon.css">
    <link rel="stylesheet" type="text/css" href="{{ env('BASE_PATH') }}app-assets/fonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="{{ env('BASE_PATH') }}app-assets/vendors/css/extensions/pace.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="{{ env('BASE_PATH') }}app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="{{ env('BASE_PATH') }}app-assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="{{ env('BASE_PATH') }}app-assets/css/colors.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{ env('BASE_PATH') }}app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="{{ env('BASE_PATH') }}app-assets/css/core/menu/menu-types/vertical-overlay-menu.css">
    <link rel="stylesheet" type="text/css" href="{{ env('BASE_PATH') }}app-assets/css/core/colors/palette-gradient.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <!-- <link rel="stylesheet" type="text/css" href="../../assets/css/style.css"> -->
    <!-- END Custom CSS-->
    @yield('head')
  </head>
  <body data-open="click" data-menu="vertical-menu" data-col="2-columns" class="vertical-layout vertical-menu 2-columns  fixed-navbar">

    <!-- navbar-fixed-top-->
    <nav style="background-color:#{{ env('APP_COLOR') }};" class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-semi-dark navbar-shadow">
      <div class="navbar-wrapper">
        <div style="background-color:#{{ env('APP_COLOR') }};" class="navbar-header">
          <ul class="nav navbar-nav">
            <li class="nav-item mobile-menu hidden-md-up float-xs-left"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5 font-large-1"></i></a></li>
            <li class="nav-item"><a href="index.html" class="navbar-brand nav-link"><img alt="branding logo" src="{{ env('BASE_PATH') }}app-assets/images/logo/robust-logo-light.png" data-expand="{{ env('BASE_PATH') }}app-assets/images/logo/robust-logo-light.png" data-collapse="{{ env('BASE_PATH') }}app-assets/images/logo/robust-logo-small.png" class="brand-logo"></a></li>
            <li class="nav-item hidden-md-up float-xs-right"><a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container"><i class="icon-ellipsis pe-2x icon-icon-rotate-right-right"></i></a></li>
          </ul>
        </div>
        <div class="navbar-container content container-fluid">
          <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
            <ul class="nav navbar-nav">
              <li class="nav-item hidden-sm-down"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5">         </i></a></li>
              <li class="nav-item hidden-sm-down"><a href="#" class="nav-link nav-link-expand"><i class="ficon icon-expand2"></i></a></li>
            </ul>
            <ul class="nav navbar-nav float-xs-right">
              <li class="dropdown dropdown-language nav-item"><a id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link"><i class="flag-icon flag-icon-gb"></i><span class="selected-language">English</span></a>
               
              </li>
              <li class="dropdown dropdown-notification nav-item"><a href="#" data-toggle="dropdown" class="nav-link nav-link-label"><i class="ficon icon-bell4"></i><span class="tag tag-pill tag-default tag-danger tag-default tag-up">0</span></a>
                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                  <li class="dropdown-menu-header">
                    <h6 class="dropdown-header m-0"><span class="grey darken-2">Notifications</span><span class="notification-tag tag tag-default tag-danger float-xs-right m-0">0 New</span></h6>
                  </li>
                  <!--
                    <li class="list-group scrollable-container">
                      <a href="javascript:void(0)" class="list-group-item">
                        <div class="media">
                          <div class="media-left valign-middle"><i class="icon-cart3 icon-bg-circle bg-cyan"></i></div>
                          <div class="media-body">
                            <h6 class="media-heading">You have new order!</h6>
                            <p class="notification-text font-small-3 text-muted">Lorem ipsum dolor sit amet, consectetuer elit.</p><small>
                              <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">30 minutes ago</time></small>
                          </div>
                        </div>
                      </a>
                    </li>
                  -->
                  <li class="dropdown-menu-footer"><a href="javascript:void(0)" class="dropdown-item text-muted text-xs-center">Read all notifications</a></li>
                </ul>
              </li>
              
              <li class="dropdown dropdown-user nav-item"><a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link"><span class="avatar avatar-online"><img src="{{ env('BASE_PATH') }}app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"><i></i></span><span class="user-name">{{ Auth()->user()->fullname }}</span></a>
                <div class="dropdown-menu dropdown-menu-right"><a href="#" class="dropdown-item"><i class="icon-head"></i> Edit Profile</a>
                  <div class="dropdown-divider"></div><a href="{{ route('parent_logout') }}"
                  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="dropdown-item"><i class="icon-power3"></i> Logout</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <form id="logout-form" action="{{ route('parent_logout') }}" method="POST" class="d-none">
        @csrf
   </form>
    </nav>

    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <!-- main menu-->
    <div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
      <!-- main menu header-->
      <div class="main-menu-header">
        <input type="text" placeholder="Search" class="menu-search form-control round"/>
      </div>
      <!-- / main menu header-->
      <!-- main menu content-->
      <div  class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
          <li class=" nav-item"><a href=""><i class="icon-home3"></i><span data-i18n="nav.dash.main" class="menu-title">Dashboard</span></a>
          </li>
          
        </ul>
        
      </div>
      <!-- /main menu content-->
      <!-- main menu footer-->
      <!-- include includes/menu-footer-->
      <!-- main menu footer-->
    </div>
    <!-- / main menu-->

    <div class="app-content content container-fluid">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><!-- stats -->
            @yield('body')

        </div>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <footer class="footer footer-static footer-light navbar-border">
      <p class="clearfix text-muted text-sm-center mb-0 px-2"><span class="float-md-left d-xs-block d-md-inline-block">Copyright  &copy; 2021, All rights reserved. </span></p>
    </footer>

    <!-- BEGIN VENDOR JS-->
    <script src="{{ env('BASE_PATH') }}app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
    <script src="{{ env('BASE_PATH') }}app-assets/vendors/js/ui/tether.min.js" type="text/javascript"></script>
    <script src="{{ env('BASE_PATH') }}app-assets/js/core/libraries/bootstrap.min.js" type="text/javascript"></script>
    <script src="{{ env('BASE_PATH') }}app-assets/vendors/js/ui/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
    <script src="{{ env('BASE_PATH') }}app-assets/vendors/js/ui/unison.min.js" type="text/javascript"></script>
    <script src="{{ env('BASE_PATH') }}app-assets/vendors/js/ui/blockUI.min.js" type="text/javascript"></script>
    <script src="{{ env('BASE_PATH') }}app-assets/vendors/js/ui/jquery.matchHeight-min.js" type="text/javascript"></script>
    <script src="{{ env('BASE_PATH') }}app-assets/vendors/js/ui/screenfull.min.js" type="text/javascript"></script>
    <script src="{{ env('BASE_PATH') }}app-assets/vendors/js/extensions/pace.min.js" type="text/javascript"></script>

    <!-- BEGIN ROBUST JS-->
    <script src="{{ env('BASE_PATH') }}app-assets/js/core/app-menu.js" type="text/javascript"></script>
    <script src="{{ env('BASE_PATH') }}app-assets/js/core/app.js" type="text/javascript"></script>
    <!-- END ROBUST JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="{{ env('BASE_PATH') }}app-assets/js/scripts/pages/dashboard-lite.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL JS-->
    @yield('js')
  </body>
</html>
