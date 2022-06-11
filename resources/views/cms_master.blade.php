<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />  <!-- new added in 160309-->

        <link rel="icon" href="{{ asset('/img/favicon.ico') }}" type="image/x-icon">
        <title>MBJB CMS</title>

        <!--  Bootstrap -->
        <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/jquery-ui.css') }}" rel="stylesheet">  <!-- for datepicker 160305 -->
        <link href="{{ asset('/css/jquery-ui.theme.css') }}" rel="stylesheet">  <!-- for timepicker 160310 -->
        <link href="{{ asset('/css/jquery.ui.timepicker.css') }}" rel="stylesheet">  <!-- for timepicker 160310 -->
<!--        <link href="{{ asset('/css/sidebar.css') }}" rel="stylesheet">  <!-- for sidebar 160315 -->

        <style>
            .boldText{
                font-weight: bold;
            }
            body{
                padding-top:155px;
                position: fixed;
                width:100%;
                /*height: 100vh;*/
            }

            .dropdown-submenu {
                position: relative;
            }

            .dropdown-submenu .dropdown-menu {
                top: 0;
                left: 100%;
                margin-top: -1px;
            }

            .red_text
            {
                color:red;
            }
            .modal-content
            {
                max-height:600px;
            }
            .modal-body
            {
                max-height:465px;
                overflow-y:auto;
            }
            /*hover main menu dropdown*/
            .dropdown {
                position: relative;
                display: inline-block;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f9f9f9;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            }

            .dropdown-content a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
            }

            .dropdown-content a:hover {background-color: #f1f1f1}

            .dropdown:hover .dropdown-content {
                display: block;
            }
            @yield('style')
        </style>



    </head>
    <body>
    @if(\Auth::user()->roles()->first()->role=="supervisor")
        @include('partials.sv_nav')
    @elseif(\Auth::user()->roles()->first()->role=="financial clerk")
        @include('partials.fc_nav')
    @elseif(\Auth::user()->roles()->first()->role=="financial manager")
        @include('partials.fm_nav')
    @elseif(\Auth::user()->roles()->first()->role=="admin")
        @include('partials.admin_nav')
    @else
        @include('partials.nav')
    @endif
        <div class="container-fluid">
            
        <!-- include 'flash::message'-->
            <div class="row">
                <div class="visible-lg visible-md hidden-sm col-md-2 sidebar">
                    @if(\Auth::user()->roles()->first()->role=="supervisor")
                        @include('partials.sv_sidebar')
                    @elseif(\Auth::user()->roles()->first()->role=="financial clerk")
                        @include('partials.fc_sidebar')
                    @elseif(\Auth::user()->roles()->first()->role=="financial manager")
                        @include('partials.fm_sidebar')
                    @elseif(\Auth::user()->roles()->first()->role=="admin")
                        @include('partials.admin_sidebar')
                    @else
                        @include('partials.sidebar')
                    @endif
                </div> <!-- end of side bar -->
                <div class="col-sm-9 col-md-10 main" id="main_content" style="max-height: 500px; overflow-y: auto;">
                    @yield('content')
                </div> <!-- end of main content -->

            </div>
        </div>
        <!-- device size trick-->
        <div id="users-device-size">
            <div id="xs" class="visible-xs"></div>
            <div id="sm" class="visible-sm"></div>
            <div id="md" class="visible-md"></div>
            <div id="lg" class="visible-lg"></div>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="{{ asset('/js/jquery-2.1.4.min.js') }}"></script>
        <!--<script src="../../public/js/submit_jquery.js"></script>-->

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
<!--        <script src="{{ asset('/js/jquery-ui.js') }}"></script> <!-- for datepicker 160305 -->
        <script src="{{ asset('/js/jquery.ui.timepicker.js') }}"></script> <!-- for timepicker 160305 -->
        <script src="{{ asset('/js/jquery.tmpl.js') }}"></script> <!-- for jquery template 160305 -->
        <script src="{{ asset('/js/jquery.validate.min.js') }}"></script> <!-- for form validation 160330 -->
        <script src="{{ asset('/js/cms.js') }}"></script> <!-- for global js function 160319 -->
        <script type="text/javascript">
            var APP_URL = {!! json_encode(url('/')) !!};
        </script>
        <script>
            $(document).ready(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

//                This is for double dropdown
//                $('.dropdown-submenu a.sub_dropdown').on("click", function(e){
//                    $(this).next('ul').toggle();
//                    e.stopPropagation();
//                    e.preventDefault();
//                });

                $('.sidebar').find('.dropdown-collapse').on("click", function(e){
                    var _this = $(this).find('span:eq(1)');
                    if(_this.hasClass('glyphicon-menu-down'))
                    {
                        _this.removeClass('glyphicon-menu-down');
                        _this.addClass('glyphicon-menu-up');
                    }
                    else if(_this.hasClass('glyphicon-menu-up'))
                    {
                        _this.removeClass('glyphicon-menu-up');
                        _this.addClass('glyphicon-menu-down');
                    }

                });

                //detect device size (trick)
                $( window ).resize(function() {
                    getScreenSize();
                });

                @yield('js_script_ready')
            });
            getScreenSize(); //call this before document is ready
            function getScreenSize()
            {
                var screen_size = $('#users-device-size').find('div:visible').first().attr('id');
//                    console.log(screen_size);
                switch (screen_size)
                {
                    case 'xs':
                    case 'sm':
//                            alert('small');
                        $('body').css('padding-top','65px');
                        $('#main_bar').css('top','0px');
                        break;
                    case 'md':
                    case 'lg':
//                            alert('large');
                        $('body').css('padding-top','155px');
                        $('#main_bar').css('top','90px');
                        break;
                }
            }
            @yield('js_script')


        </script>
        @yield('footer')
    </body>
</html>