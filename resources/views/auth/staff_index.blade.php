@extends('cms_master')

@section('content')
<?php
$cur_year= (int) date('Y');
$cur_month= (int) date('m');
$days=cal_days_in_month(CAL_GREGORIAN,$cur_month,$cur_year);  //get current month's total days
?>
<h1>Berita Baru</h1>
<hr>

<p>
    Sila Hantar Borang Permohonan sebelum {!!$days!!}
    @foreach($month as $m)
        @if($m->code==$cur_month)
            {{$m->name}}
        @endif
    @endforeach
    {!!$cur_year!!}.

</p>




@endsection