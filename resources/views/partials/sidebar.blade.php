<!--<ul class="nav nav-sidebar well">-->
<!--    <li class="active"><a href="/">Laman Utama <span class="sr-only">(current)</span></a></li>-->
<!--    <li class="dropdown" id="testsidebar">-->
<!--        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Peribadi<span class="caret"></span></a>-->
<!--        <ul class="dropdown-menu">-->
<!--            <li><a href="#">Maklumat Peribadi</a></li>-->
<!--            <li><a href="#">Tukar kata laluan</a></li>-->
<!--        </ul>-->
<!--    </li>-->
<!--    <li><a href="#">Tuntutan</a></li>-->
<!--    <li><a href="#">Kenderaan</a></li>-->
<!---->
<!--</ul>-->

<ul class="nav nav-pills nav-stacked" style="background-color: #e6faff;">
    <li class="active"><a href="/"><span class="glyphicon glyphicon-home pull-left">&nbsp;</span>Laman Utama</a></li>
<!--    <li class="disabled"><a href="#">Disabled</a></li>-->
    <li>
        <a class="dropdown-collapse" href="#" data-toggle="collapse" data-target="#personal_nav">
            <span class="glyphicon glyphicon-user pull-left">&nbsp;</span>
                Peribadi
            <span class="glyphicon glyphicon-menu-down pull-right"></span>
        </a>
        <ul id="personal_nav" class="nav collapse">
            <li><a href="{{ url('/personal') }}">&nbsp; Maklumat Peribadi</a></li>
            <li><a href="{{ url('/password') }}">&nbsp; Tukar kata laluan</a></li>
        </ul>
    </li>
    <li>
        <a class="dropdown-collapse" href="#" data-toggle="collapse" data-target="#claim_nav" >
            <span class="glyphicon glyphicon-file pull-left">&nbsp;</span>
                Tuntutan
            <span class="glyphicon glyphicon-menu-down pull-right"></span>
        </a>
        <ul id="claim_nav" class="nav collapse">
            <li><a href="{{ url('/claimMileage') }}">&nbsp; Tuntutan Perjalanan</a></li>
            <li><a href="{{ url('/claimOvertime') }}">&nbsp; Tuntutan Overtime</a></li>
        </ul>
    </li>
<!--    <li class="dropdown">-->
<!--        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">-->
<!--            Tuntutan <span class="caret"></span>-->
<!--        </a>-->
<!--        <ul class="dropdown-menu">-->
<!--            <li><a href="/claimMileage">Tuntutan Perjalanan</a></li>-->
<!--            <li><a href="/claimOvertime">Tuntutan Overtime</a></li>-->
            <!--            <li class="divider"></li>-->
            <!--            <li><a href="#">Separated link</a></li>-->
<!--        </ul>-->
<!--    </li>-->
    <li><a href="{{ url('/vehicle') }}"><span class="glyphicon glyphicon-road pull-left">&nbsp;</span>Kenderaan</a></li>
</ul>
