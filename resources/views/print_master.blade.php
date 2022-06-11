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

    <style>
        .boldText{
            font-weight: bold;
        }
        .red_text
        {
            color:red;
        }
        @yield('style')
    </style>



</head>
<body>

<div class="container">
    <div class="row">
        @yield('content')
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{ asset('/js/jquery-2.1.4.min.js') }}"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{ asset('/js/bootstrap.min.js') }}"></script>
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
                @yield('js_script_ready')
    });
    @yield('js_script')
</script>
@yield('footer')
</body>
</html>