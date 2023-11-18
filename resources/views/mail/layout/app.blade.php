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
  </head>

    <body style="background-color: #{{ env('APP_COLOR')}};" data-open="click" data-menu="vertical-menu" data-col="1-column" class="vertical-layout vertical-menu 1-column  blank-page blank-page">
        <!-- ////////////////////////////////////////////////////////////////////////////-->
        <div class="app-content content container-fluid">
          <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body"><section class="flexbox-container">
        <div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1  box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 m-0">
                
                @yield('content')
            </div>
        </div>
    </section>
    
            </div>
          </div>
        </div>
        <!-- ////////////////////////////////////////////////////////////////////////////-->

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
