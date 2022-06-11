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
    <li><a href="{{ url('/supervisee') }}"><span class="glyphicon glyphicon-list-alt pull-left">&nbsp;</span>Supervisee</a></li>
<!--    <li>-->
<!--        <a class="dropdown-collapse" href="#" data-toggle="collapse" data-target="#claim_nav" >-->
<!--            <span class="glyphicon glyphicon-file pull-left">&nbsp;</span>-->
<!--            Tuntutan-->
<!--            <span class="glyphicon glyphicon-menu-down pull-right"></span>-->
<!--        </a>-->
<!--        <ul id="claim_nav" class="nav collapse">-->
<!--            <li><a href="/claimMileage">&nbsp; Tuntutan Perjalanan</a></li>-->
<!--            <li><a href="/claimOvertime">&nbsp; Tuntutan Overtime</a></li>-->
<!--        </ul>-->
<!--    </li>-->
<!--    <li><a href="/vehicle"><span class="glyphicon glyphicon-road pull-left">&nbsp;</span>Kenderaan</a></li>-->
    <li>
        <a class="dropdown-collapse" href="#" data-toggle="collapse" data-target="#verify_claim_nav" >
            <span class="glyphicon glyphicon-saved pull-left">&nbsp;</span>
            Pengesahan Tuntutan
            <span class="glyphicon glyphicon-menu-down pull-right"></span>
        </a>
        <ul id="verify_claim_nav" class="nav collapse">
            <li><a href="{{ url('/claimMileageVerify') }}">&nbsp; Pengesahan Tuntutan Perjalanan</a></li>
            <li><a href="{{ url('/claimOvertimeVerify') }}">&nbsp; Pengesahan Tuntutan Overtime</a></li>
        </ul>
    </li>
    <li>
        <a class="dropdown-collapse" href="#" data-toggle="collapse" data-target="#report_claim_nav" >
            <span class="glyphicon glyphicon-tasks pull-left">&nbsp;</span>
            Laporan Tuntutan
            <span class="glyphicon glyphicon-menu-down pull-right"></span>
        </a>
        <ul id="report_claim_nav" class="nav collapse">
            <li><a href="{{ url('/claimMileageReport') }}">&nbsp; Laporan Tuntutan Perjalanan</a></li>
            <li><a href="{{ url('/claimOvertimeReport') }}">&nbsp; Laporan Tuntutan Overtime</a></li>
        </ul>
    </li>
</ul>
