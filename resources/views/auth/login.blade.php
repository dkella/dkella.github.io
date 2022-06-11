@extends('app')

@section('content')
<div class="navbar-fixed-top" style="min-height:25px; background-color: deepskyblue;">
    <div class="container" style="text-align:center">
        <h1 style="margin: 0px; color: #ffffff;font-size:4vw;"><img src="{{ asset('/img/MBJB.png') }}" width="8%;" style="min-height: 25px;"> Sistem Pengurusan Tuntutan MBJB</h1>
    </div>
</div>
<div class="container-fluid" style="padding-top:25px;">
    <div class="row">
        <div class="col-md-6 col-md-offset-3" style="margin-top: 10%;">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
<!--                        <strong>Whoops!</strong> There were some problems with your input.<br><br>-->
<!--                        <ul>-->
                            @foreach ($errors->all() as $error)
                            <!--<li>--><strong>{{ $error }}</strong> <!--</li>-->
                            @endforeach
<!--                        </ul>-->
                    </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/handleLogin') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">No Kad Pengenalan</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="noKP">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Kata Laluan</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>

<!--                        <div class="form-group">-->
<!--                            <div class="col-md-6 col-md-offset-4">-->
<!--                                <div class="checkbox">-->
<!--                                    <label>-->
<!--                                        <input type="checkbox" name="remember"> Remember Me-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-8">
                                <button type="submit" class="btn btn-primary">Login</button>

                                <!--								<a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your Password?</a>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
