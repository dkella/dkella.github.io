<div class="navbar-fixed-top visible-lg visible-md hidden-sm" style="1height:100px; min-height:25px; background-color: #ffffff;">
    <div class="container" style="text-align:center">
        <h1 style="margin: 0px; color: #000000; 1font-size:48px; font-size:4vw;"><img src="{{ asset('/img/MBJB.png') }}" width="8%;" style="min-height: 25px;"> Sistem Pengurusan Tuntutan MBJB</h1>
    </div>
</div>

<div class="navbar navbar-default navbar-fixed-top" id="main_bar" style="top:90px;">
    <div class="container">
        <div class="navbar-header">
            <a href="{{ url('/') }}" class="navbar-brand">Laman Utama</a>
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#">Peribadi <span class="caret"></span></a>
                    <div class="dropdown-content">
                        <a href="{{ url('/personal') }}">Maklumat Peribadi</a>
                        <a href="{{ url('/password') }}">Tukar kata laluan</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#">Tuntutan <span class="caret"></span></a>
                    <div class="dropdown-content">
                        <a href="{{ url('/claimMileage') }}">Tuntutan Perjalanan</a>
                        <a href="{{ url('/claimOvertime') }}">Tuntutan Overtime</a>
                    </div>
                </li>
<!--                <li class="dropdown">-->
<!--                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Tuntutan <span class="caret"></span></a>-->
<!--                    <ul class="dropdown-menu" aria-labelledby="themes">-->
<!---->
<!--                        <li><a href="/claimMileage">Tuntutan Perjalanan</a></li>-->
<!--                        <li><a href="/claimOvertime">Tuntutan Overtime</a></li>-->
<!---->
<!--                        <li class="dropdown-submenu">-->
<!--                            <a class="sub_dropdown" tabindex="-1" href="#">Permohonan <span class="caret"></span></a>-->
<!--                            <ul class="dropdown-menu">-->
<!--                                <li><a tabindex="-1" href="/claimMileage/create">Tuntutan Perjalanan</a></li>-->
<!--                                <li><a tabindex="-1" href="/claimOvertime/create">Tuntutan Overtime</a></li>-->
<!--                            </ul>-->
<!--                        </li>-->
<!---->
<!---->
<!--                    </ul>-->
<!--                </li>-->
                <li><a href="{{ url('/vehicle') }}">Kenderaan</a></li>
<!--                <li>-->
<!--                    <a class="dropdown-collapse" href="#" data-toggle="collapse" data-target="#personal_nav_main">-->
<!--                        Peribadi<span class="caret"></span>-->
<!--                    </a>-->
<!--                    <ul id="personal_nav_main" class="nav collapse">-->
<!--                        <li><a href="/personal">&nbsp; Maklumat Peribadi</a></li>-->
<!--                        <li><a href="#">&nbsp; Tukar kata laluan</a></li>-->
<!--                    </ul>-->
<!--                </li>-->


            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                <li><a href="{{ url('/login') }}">Login</a></li>
                <li><a href="{{ url('/auth/register') }}">Register</a></li>
                @else
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ url('/logout') }}">Logout</a></li>
                    </ul>
                </li>
                @endif
            </ul>

        </div>
    </div>
</div>


