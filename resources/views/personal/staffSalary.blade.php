@extends('cms_master')

@section('style')
    .table-borderless tbody tr td, .table-borderless tbody tr th, .table-borderless thead tr th {
    border: none;
}
@endsection


@section('content')
<div class="row">
    <div class="col-lg-11 col-md-11 col-sm-11">
        <h2>Bayaran Gaji</h2>
    </div>
</div>

<hr>

<!--     Form::select('size', array('L' => 'Large', 'S' => 'Small')) -->
<?php
$cur_year= (int) date('Y');
$cur_month= (int) date('m');
for($i=2015;$i<=$cur_year;$i++)
{
    $arr_year[$i]=$i;

//echo '<option value='.$i.'>'.$i.'</option>';
}
//print_r($arr_year);

?>

<div class="row" id="row_year">
    <div class="form-group">
        {!! Form::label('year','Tahun:',['class' => 'col-sm-offset-4 col-sm-1']) !!}
        <div class="col-sm-2">
            {!! Form::select('year', $arr_year,$cur_year,['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="row" id="row_month">
    <div class="form-group">
        {!! Form::label('month','Bulan:',['class' => 'col-sm-offset-4 col-sm-1']) !!}
        <div class="col-sm-2">
            {!! Form::select('month', $dropDown_month,$cur_month,['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<br>
<div class="row" id="row_month">
    <button id="btn_getSalaryList" type="button" class="btn btn-primary col-sm-offset-6 col-sm-1">Submit</button>
</div>

<br>

<div class="row" id="row_tbl_salary" style="display:none;">
    <div class="col-md-offset-1 col-md-10">
        <h3 id="table_title"></h3>
        <table class="table table-striped table-hover" id="staffSalary_table" style="font-size: 0.9em;">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Gaji</th>
                    <th>Tuntutan KLM</th>
                    <th>Tuntutan Perjalanan</th>
                    <th>Jumlah Bayaran</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="row red_text" id="errMsg" style="display:none;"></div>
@endsection

@section('js_script_ready')


$('#btn_getSalaryList').on('click',function(){
    var report_type = $('#report_type').val();
    var obj = new Object();

    obj.year = $('#year').val();
    obj.month = $('#month').val();
<!--    obj.month_name = $("#month option:selected").text();-->

    getStaffSalary(obj);



});


@endsection


@section('js_script')

function getStaffSalary(obj)
{
    $('#errMsg').hide();
    var url = APP_URL+"/staffSalary";
    var inputData = JSON.stringify(obj);
    var type = "POST";

    $.ajax({
        type: type,
        url: url,
        data: inputData,
        dataType: 'json',
<!--        async: false,  //wait this done runs-->
        success: function (data) {
            console.log('Success:',data);
            var arr_obj = data.data;
            if(arr_obj!=null)
            {
                for(var i=0;i<arr_obj.length;i++)
                {
                    var _obj =arr_obj[i];
                    _obj.salary=parseFloat(_obj.salary).toFixed(2);
                    _obj.otclaim_total=_obj.otclaim_total.toFixed(2);
                    _obj.travelclaim_total=_obj.travelclaim_total.toFixed(2);
                    _obj.totalSalary=_obj.totalSalary.toFixed(2);

                    $('#staffSalary_table_template').tmpl(_obj).appendTo('#staffSalary_table');
<!--    clear print icon for 0.00 claim  -->
                    var _otClaim = $('#staffSalary_table >tbody tr:last').find( 'td:eq(2)');
<!--alert(jQuery.type(_otClaim.find("a >span").attr("otclaim_id")));-->
                    if(_otClaim.find("a >span").attr("otclaim_id")=="")
                    {
                        _otClaim.html("0.00");
                    }

                    var _travelClaim = $('#staffSalary_table >tbody tr:last').find( 'td:eq(3)');
                    if(_travelClaim.find("a >span").attr("travelclaim_id")=="")
                    {
                        _travelClaim.html("0.00");
                    }




                    $('#row_tbl_salary').show();
                }

            }
            else
            {
                $('#errMsg').html("Tiada Rekod");
                $('#errMsg').show();
            }
        },
        error: function (data) {
            console.log('Error:', data);
            $('body').html(data.responseText);  //easier to debug
        }
    });
}


@endsection
@section('footer')

<script src="{{ asset('/js/mileage.js') }}"></script> <!-- created on:160319 -->
<script id='staffSalary_table_template' type='text/x-jquery-tmpl'>
        <tr>
            <td>${name}</td>
            <td>${salary}</td>
            <td>${otclaim_total}&nbsp;
                <a href="{{ url('/claimOvertime/print/${otclaim_id}') }}" class="print_claim"><span class="glyphicon glyphicon-print" otclaim_id="${otclaim_id}" aria-hidden="true"></span></a>
            </td>
            <td>${travelclaim_total}&nbsp;
                <a href="{{ url('/claimMileage/print/${travelclaim_id}') }}" class="print_claim"><span class="glyphicon glyphicon-print" travelclaim_id="${travelclaim_id}" aria-hidden="true"></span></a>
            </td>
            <td>${totalSalary}</td>
        </tr>
    </script>
@endsection

