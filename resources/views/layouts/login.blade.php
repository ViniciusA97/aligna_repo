<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

        <title>Aligna - Login</title>

        <link rel="apple-touch-icon" href="{{ asset("assets/images/apple-touch-icon.png") }}">
        <link rel="shortcut icon" href="{{ asset("assets/images/favicon.ico") }}">

        <!-- Stylesheets -->
        <link rel="stylesheet" href="{{ asset("assets/global/css/bootstrap.min.css") }}">
        <link rel="stylesheet" href="{{ asset("assets/global/css/bootstrap-extend.min.css") }}">
        <link rel="stylesheet" href="{{ asset("assets/css/site.min.css") }}">
        <link rel="stylesheet" href="{{ asset("assets/css/custom.css") }}">
        <link type="text/css" rel="stylesheet" href="{{ asset("assets/skins/aligna.min.css") }}" id="skinStyle">

        <!-- Plugins -->
        <link rel="stylesheet" href="{{ asset("assets/global/vendor/animsition/animsition.css") }}">
        <link rel="stylesheet" href="{{ asset("assets/global/vendor/asscrollable/asScrollable.css") }}">
        <link rel="stylesheet" href="{{ asset("assets/global/vendor/switchery/switchery.css") }}">
        <link rel="stylesheet" href="{{ asset("assets/global/vendor/intro-js/introjs.css") }}">
        <link rel="stylesheet" href="{{ asset("assets/global/vendor/slidepanel/slidePanel.css") }}">
        <link rel="stylesheet" href="{{ asset("assets/global/vendor/flag-icon-css/flag-icon.css") }}">
        <link rel="stylesheet" href="{{ asset("assets/global/vendor/toastr/toastr.css") }}">
        <link rel="stylesheet" href="//min.gitcdn.xyz/repo/wintercounter/Protip/master/protip.min.css">

        @stack('styles')

        <!-- Fonts -->
        <link rel="stylesheet" href="{{ asset("assets/global/fonts/web-icons/web-icons.min.css") }}">
        <link rel="stylesheet" href="{{ asset("assets/global/fonts/brand-icons/brand-icons.min.css") }}">
        <link rel="stylesheet" href="{{ asset("assets/global/fonts/glyphicons/glyphicons.min.css?v4.0.2") }}">
        <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
        <script src="https://kit.fontawesome.com/24d9319656.js" crossorigin="anonymous"></script>

        <!--[if lt IE 9]>
        <script src="{{ asset("assets/global/vendor/html5shiv/html5shiv.min.js") }}"></script>
        <![endif]-->

        <!--[if lt IE 10]>
        <script src="{{ asset("assets/global/vendor/media-match/media.match.min.js") }}"></script>
        <script src="{{ asset("assets/global/vendor/respond/respond.min.js") }}"></script>
        <![endif]-->

        <!-- Scripts -->
        <script src="{{ asset("assets/global/vendor/breakpoints/breakpoints.js") }}"></script>
        <script>
        Breakpoints();
        </script>
    </head>
    <body id="app-body" class="animsition site-menubar-fold site-menubar-keep">
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <div id="header">
    </div>

    <div id="navSideBar">
    </div>

    <!-- Page -->
    <div>

        
        @show
        <div>
            @yield('content')
        </div><!-- end panel -->
    </div>
    <!-- End Page -->

    <div id="footer">
    </div>
    <!-- Core  -->
    <script src="{{ asset("assets/global/vendor/babel-external-helpers/babel-external-helpers.js") }}"></script>
    <script src="{{ asset("assets/global/vendor/jquery/jquery.js") }}"></script>
    <script src="{{ asset("assets/global/vendor/popper-js/umd/popper.min.js") }}"></script>
    <script src="{{ asset("assets/global/vendor/bootstrap/bootstrap.js") }}"></script>
    <script src="{{ asset("assets/global/vendor/animsition/animsition.js") }}"></script>
    <script src="{{ asset("assets/global/vendor/mousewheel/jquery.mousewheel.js") }}"></script>
    <script src="{{ asset("assets/global/vendor/asscrollbar/jquery-asScrollbar.js") }}"></script>
    <script src="{{ asset("assets/global/vendor/asscrollable/jquery-asScrollable.js") }}"></script>
    <script src="{{ asset("assets/global/vendor/ashoverscroll/jquery-asHoverScroll.js") }}"></script>

    <script src="{{ asset('js/laroute.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- Plugins -->
    <script src="{{ asset("assets/global/vendor/switchery/switchery.js") }}"></script>
    <script src="{{ asset("assets/global/vendor/intro-js/intro.js") }}"></script>
    <script src="{{ asset("assets/global/vendor/screenfull/screenfull.js") }}"></script>
    <!-- <script src="{{ asset("assets/global/vendor/slidepanel/jquery-slidePanel.js") }}"></script> -->
    <script src="{{ asset("assets/global/vendor/toastr/toastr.js") }}"></script>
    <script src="{{ asset("assets/js/jquery.mask.js") }}"></script>
    <script src="//min.gitcdn.xyz/repo/wintercounter/Protip/master/protip.min.js"></script>

    @stack('plugins')

    <!-- Scripts -->
    <script src="{{ asset("assets/global/js/Component.js") }}"></script>
    <script src="{{ asset("assets/global/js/Plugin.js") }}"></script>
    <script src="{{ asset("assets/global/js/Base.js") }}"></script>
    <script src="{{ asset("assets/global/js/Config.js") }}"></script>

    <script src="{{ asset("assets/js/Section/Menubar.js") }}"></script>
    <script src="{{ asset("assets/js/Section/GridMenu.js") }}"></script>
    <script src="{{ asset("assets/js/Section/Sidebar.js") }}"></script>
    <script src="{{ asset("assets/js/Section/PageAside.js") }}"></script>
    <script src="{{ asset("assets/js/Plugin/menu.js") }}"></script>

    <!-- Page -->
    <script src="{{ asset("assets/js/Site.js") }}"></script>
    <script src="{{ asset("assets/global/js/Plugin/asscrollable.js") }}"></script>
    <!-- <script src="{{ asset("assets/global/js/Plugin/slidepanel.js") }}"></script> -->
    <script src="{{ asset("assets/global/js/Plugin/switchery.js") }}"></script>
    <script src="{{ asset("assets/global/js/Plugin/toastr.js") }}"></script>
    <script src="{{ asset("assets/js/BaseApp.js") }}"></script>

    @if (session('success'))
        <script>
            toastr.success("{{ session('success') }}", {"newestOnTop": false, "progressBar": true})
        </script>
    @endif
    @if (session('action_error'))
        <script>
            toastr.error("{{ session('action_error') }}", {"newestOnTop": false, "progressBar": true})
        </script>
    @endif

    @stack('scripts')

    <script>
      (function(document, window, $){
        'use strict';

        var Site = window.Site;
        $(document).ready(function(){
          Site.run();
          $.protip();

          $(".toggle-filters").click(function(){
            $("#filters-panel").slideToggle();
            return false;
          });

          if($(".time").length > 0){
            $('.time').mask('00:00');
          }
        });
      })(document, window, jQuery);
    </script>
    </body>
</html>
