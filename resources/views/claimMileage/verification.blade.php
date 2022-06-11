@extends('cms_master')

@section('style')
@endsection

@section('content')

<div class="row">
    <div class="col-lg-11 col-md-11 col-sm-11">
        <h1>Pengesahan Tuntutan Perjalanan</h1>
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
<div class="row">
    <div class="form-group">
        {!! Form::label('year','Tahun:',['class' => 'col-sm-offset-4 col-sm-1']) !!}
        <div class="col-sm-2">
            {!! Form::select('year', $arr_year,$cur_year,['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="form-group">
        {!! Form::label('month','Bulan:',['class' => 'col-sm-offset-4 col-sm-1']) !!}
        <div class="col-sm-2">
            {!! Form::select('month', $dropDown_month,$cur_month,['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<br>
@if (!empty($claims[0]))
<!--if there is return claims-->
<div class="row">
    <table class="table table-striped table-hover" style="font-size: 0.9em; display:none;" id="staff_claim_table">
        <thead>
        <tr>
            <!--        <th>Bulan</th>-->
            <!--        <th>Tahun</th>-->
            <th>Staff</th>
            <th>Jumlah (RM)</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($claims as $claim_staff)
        @if (!empty($claim_staff[0]))
        @foreach ($claim_staff as $claim)
        <!--    if and only if claim is not draft-->
        @if($claim->status!=1)
        <tr claim_id ="{{$claim->id}}" claim_year="{{ $claim->year }}" claim_month="{{ $claim->month }}">
            <td>{{ $claim->users->name}}</td>
            <td>{{  number_format($claim->total,2,".","") }}</td>
            @foreach ($status as $s)
            @if($s->code==$claim->status)
            <td>{{ $s->name}}</td>
            @endif
            @endforeach
            @if($claim->status!=1)
            @endif
            <td><a href="{{ url('/claimMileageVerify/showClaimDetail',$claim->id)}}">
                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                </a></td>
        </tr>
        <!--    END if claim is not draft-->
        @endif
        @endforeach
        @endif
        @endforeach
        </tbody>
    </table>
</div>
<div class="row" id="no_record" style="display:none">
    <p>Tiada rekod.</p>
</div>

@else
<div class="row" id="no_record">
    <p>Tiada rekod.</p>
</div>
@endif

<div class="row" id="claim_detail_row" style="display: none; border-radius: 5px; border:1px solid #e1e1e8; padding:5px; margin:5px;">  <!--#A0FFFF-->
    <table class="table table-striped table-hover" claim_id="" id="claim_detail_table" style="font-size: 0.9em;">
        <thead>
        <tr>
            <th>Tarikh</th>
            <th>Masa Mula</th>
            <th>Masa Tamat</th>
            <th>Kenyataan</th>
            <th>Jumlah jam</th>
            <th>Jumlah Perjalanan(KM)</th>
            <th>Status</th>
            <th>Catatan</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

@endsection

@section('js_script_ready')
    refreshTableContent();
    $('#year').on('change',function(){
        refreshTableContent();
    });

    $('#month').on('change',function(){
        refreshTableContent();
    <!--        alert('month change:'+_month+" "+_year);-->
    });

    $('.glyphicon-eye-open').on('click', function(e){
        e.preventDefault();
        $('#staff_claim_table > tbody > tr').css('background-color','white');

        $('#claim_detail_row').hide();
        $('#claim_detail_table').find('tbody').html('');

        var my_url = $(this).parent().attr('href');
        <!--    alert(my_url);-->
        //                       a       TD        TR
        var parentTR = $(this).parent().parent().parent();
        parentTR.css('background-color','#e6faff');
        $.ajax({
            type: "GET",
            url: my_url,
            async: false,  //wait this done runs
            dataType: "json",
            success: function(data){
                console.log(data);
                var arr_obj = data.data;
                <!--            insert claim_id-->
                $('#claim_detail_table').attr("claim_id",arr_obj[0].claim_id);

                for	(var index = 0; index < arr_obj.length; index++)
                {
                    var obj = arr_obj[index];
                    obj.date = obj.date.substring(0, 10);
                    $('#claim_detail_table_template').tmpl(obj).appendTo('#claim_detail_table');
                    <!--                console.error(obj);-->
                }

                $('#claim_detail_table').append('<tr>'
                                        +'<td colspan="9" id="errMsg" class="red_text"></td>'
                                        +'<td>'
                                        +'<button id="update_claim_status" type="button" class="btn btn-primary">Submit</button>'
                                        +'</td></tr>');
                $('#claim_detail_row').show();

            },
            error: function() {
                console.error("An error occurred while processing JSON file.");
            }
        });
    });

@endsection

@section('js_script')
    $(document).on('click','.verify_btn',function () {
        //                       BTN      TD       TR
        var parentTR = $(this).parent().parent();

        var _flag = parentTR.find( "td:eq(6)");
        _flag.text("Sah");
        _flag.attr("flag","3");
        <!--        var my_url = APP_URL+"/claimMileageVerify/verify/";-->
        <!--        updateClaimFlag(_setFlag,_setStatus,my_url,parentTR);-->
    });

    $(document).on('click','.disverify_btn',function () {
        var _reason = prompt("Sila masukan sebab dan klik 'OK' untuk menolak tuntutan, atau klik 'cancel' untuk batalkan penolakkan tuntutan.");

        if (_reason != null) {
    //                       BTN      TD       TR
            var parentTR = $(this).parent().parent();

            var _flag = parentTR.find( "td:eq(6)");
            _flag.text("Tidak Sah");
            _flag.attr("flag","4");

            var _reasonTD = parentTR.find( "td:eq(7)");
            _reasonTD.html(_reason);

            <!--       var my_url = APP_URL+"/claimMileageVerify/disverify/";-->
            <!--        updateClaimFlag(_setFlag,_setStatus,my_url,parentTR);-->
        }
    });

    $(document).on('click','#update_claim_status',function () {
        var _submitBtn = $(this);
        _submitBtn.text("Loading...");

        var _noAction = 0;
        var _Verify = 0;
        var _Reject = 0;

        var _status;
        $('#claim_detail_table >tbody >tr').each(function(){
            var _trFlag = $(this).children().eq(6).attr("flag");
            if(_trFlag=="0"){ //0-no action, 3-verified, 4-rejected
                _noAction++;
            }
            else if(_trFlag=="3")
            {
                _Verify++;
            }
            else if(_trFlag=="4")
            {
                _Reject++;
            }
        });

        <!--        alert(_noAction+" "+_Verify+" "+_Reject);-->
        if(_noAction==0) <!-- all status are set-->
        {
            <!--            Update each claim record status-->
            $('#claim_detail_table >tbody >tr').each(function(){
                var _row = $(this);
                var travelClaim_id = _row.attr('travelClaim_id');
                var my_url = APP_URL+"/claimMileageVerify/";
                var _trFlag = _row.children().eq(6).attr("flag");

                if(_trFlag=="3")    //3- verify
                {
                    my_url = my_url + "verify/" + travelClaim_id;
                    <!--                    updateClaimFlag(my_url);-->
                    $.ajax({
                        type: "GET",
                        url: my_url,
                        async: false,  //wait this done runs
                        dataType: "json",
                        success: function(data){
                            console.log("success verify:" + data);
                        },
                        error: function() {
                            console.error("An error occurred while processing JSON file.");
                        }
                    });
                }
                else if(_trFlag=="4")   //4-reject
                {
                    var _rejectReason = _row.children().eq(7).text();  //Catatan

                    var obj = new Object();
                    obj.rejectReason = _rejectReason;
                    var inputData = JSON.stringify(obj);
                    my_url = my_url + "disverify/" + travelClaim_id;
                    <!--                    updateClaimFlag(my_url);-->
                    $.ajax({
                        type: "PUT",
                        url: my_url,
                        data: inputData,
                        async: false,  //wait this done runs
                        contentType: "json",
                        processData: false, //for array of jason
                        success: function(data){
                            console.log("success disverify:" + data);
                        },
                        error: function() {
                            console.error("An error occurred while processing JSON file.");
                        }
                    });
                }
            });

            <!--            Update overall claim status-->
            if(_Reject==0 && _Verify>=0) <!-- all verified-->
            {
                _status = 5;   <!--            Verified-->
                _statusName = "verified";
            }
            else if(_Reject>=0 && _Verify==0) <!-- all rejected-->
            {
                _status = 4;   <!--            Rejected-->
                _statusName = "rejected";
            }
            else if(_Reject>=0 && _Verify>=0) <!-- half verified-->
            {
                _status = 6;   <!--            Pending-->
                _statusName = "pending";
            }

            <!--        call ajax update overall claim status-->
            var claim_id = $('#claim_detail_table').attr("claim_id");

            var my_url = APP_URL+"/claim/verify/" +claim_id;
            var obj = new Object();
            obj.status = _status;
            var inputData = JSON.stringify(obj);

            $.ajax({
                type: "PUT",
                url: my_url,
                data: inputData,
                contentType: 'json',
                processData: false, //for array of jason
                success: function(data){
                    console.log(data);

                    <!--     update status in staff list       -->
                    $('#staff_claim_table >tbody >tr').each(function(){
                        var _row = $(this);
                        var _row_claim_id = _row.attr('claim_id');
                        if(_row_claim_id==claim_id)
                        {
                            var _claim_status = _row.find( "td:eq(2)");
                            _claim_status.text(_statusName);
                        }
                    });
                    $('#claim_detail_row').hide();
                    $('#main_content').prepend('<div id="div_status" class="alert alert-success" role="alert">'
                        +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                        +'Status telah dikemaskini.</div>');

                    $('#div_status').delay(3000).slideUp(300);
                },
                error: function() {
                    console.error("An error occurred while processing JSON file.");
                }
            });

        }
        else
        {
            _submitBtn.text("Submit");
            $('#errMsg').text("Sila set status untuk semua tuntutan.");
        }
    });


    function refreshTableContent()
    {
        refreshDetailTable();
        var _year = $('#year').val();
        var _month = $('#month').val();
        var _count = 0;

        $('#staff_claim_table > tbody > tr').each(function(){
            var _tr = $(this);
            var tr_year = _tr.attr('claim_year');
            var tr_month = _tr.attr('claim_month');

            if(tr_year==_year && tr_month==_month)
            {
                _count++;
                _tr.show();
            }
            else
            {
                _tr.hide();
            }
        });

        if(_count==0)
        {
            $('#staff_claim_table').hide();
            $('#no_record').show();
        }
        else
        {
            $('#staff_claim_table').show();
            $('#no_record').hide();
        }
    }
    function refreshDetailTable()
    {
        $('#staff_claim_table > tbody > tr').css('background-color','white');
        $('#claim_detail_row').hide();
        $('#claim_detail_table').find('tbody').html('');
    }

@endsection
@section('footer')
<script id='claim_detail_table_template' type='text/x-jquery-tmpl'>
        <tr travelClaim_id="${id}">
            <td>${date}</td>
            <td>${startTime}</td>
            <td>${endTime}</td>
            <td>${travelDesc}</td>
            <td>${hour}</td>
            <td>${mileage}</td>
            <td flag="${flag}">${flagDesc}</td>
            <td>${rejectReason}</td>
            <td>
                <button class="verify_btn" status="3">Sah</button>
            </td>
            <td>
                <button class="disverify_btn" status="4">Tidak sah</button>
            </td>
        </tr>
    </script>
@endsection