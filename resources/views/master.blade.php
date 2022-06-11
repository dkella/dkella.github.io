<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		
		<title>Laravel 5-Kella</title>
		
		<!--  Bootstrap -->
        <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
        <!--  select2: Added 20160208 -->
        <link href="{{ asset('/css/select2.min.css') }}" rel="stylesheet">
        <style>
            body{
                padding-top:60px;
            }
        </style>


    	
	</head>
	<body>
        @include('partials.nav')
		<div class="container">
            @include('flash::message')
		    @yield('content')
		</div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="{{ asset('/js/jquery-2.1.4.min.js') }}"></script>
        <!--<script src="../../public/js/submit_jquery.js"></script>-->

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
        <!-- select2: Added 20160208 -->
        <script src="{{ asset('/js/select2.min.js') }}"></script>
	    <script>
            //$('#flash-overlay-modal').modal();
            $('div.alert').not('.alert-important').delay(3000).slideUp(300);
	    </script>
        @yield('footer')
	</body>
</html>