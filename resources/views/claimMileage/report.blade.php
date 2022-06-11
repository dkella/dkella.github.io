@extends('cms_master')

@section('style')
    .table-borderless tbody tr td, .table-borderless tbody tr th, .table-borderless thead tr th {
    border: none;
}
@endsection


@section('content')
<div class="row">
    <div class="col-lg-11 col-md-11 col-sm-11">
        <h2>Laporan Tuntutan Perjalanan</h2>
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

$arr_report_type = array("", "by month", "by individual");
?>

<div class="row">
    <div class="form-group">
        {!! Form::label('report_type','Jenis Laporan:',['class' => 'col-sm-offset-3 col-sm-2']) !!}
        <div class="col-sm-3">
            {!! Form::select('report_type', $arr_report_type,null,['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="row" id="row_year" style="display:none;">
    <div class="form-group">
        {!! Form::label('year','Tahun:',['class' => 'col-sm-offset-3 col-sm-2']) !!}
        <div class="col-sm-3">
            {!! Form::select('year', $arr_year,$cur_year,['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="row" id="row_month" style="display:none;">
    <div class="form-group">
        {!! Form::label('month','Bulan:',['class' => 'col-sm-offset-3 col-sm-2']) !!}
        <div class="col-sm-3">
            {!! Form::select('month', $dropDown_month,$cur_month,['class' => 'form-control']) !!}
        </div>
    </div>
</div>

<div class="row" id="row_staff" style="display:none;">
    <div class="form-group">
        {!! Form::label('staff','Staff:',['class' => 'col-sm-offset-3 col-sm-2']) !!}
        <div class="col-sm-3">
            {!! Form::select('staff', $dropDown_staff,null,['class' => 'form-control']) !!}
        </div>
    </div>
</div>
<button id="btn_generateReport" type="button" class="btn btn-primary" style="display:none;">Generate Report</button>

<br>

<div class="row" id="row_tbl_month_report" style="display:none;">
    <div class="col-md-5">
        <h3 id="table_title"></h3>
        <table class="table table-striped table-hover" id="month_report_table" style="font-size: 0.9em;">
            <thead>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div class="col-md-5" id="chart_div">

    </div>
</div>
<div class="row red_text" id="errMsg" style="display:none;"></div>
@endsection

@section('js_script_ready')

$('#report_type').on('change',function(){
    var report_type = $(this).val();
<!--    console.log("change");-->
    if(report_type=="1")    //by month
    {
<!--        alert("by year");-->
        $('#row_year').show();
        $('#row_month').show();
        $('#btn_generateReport').show();

        $('#row_staff').hide();
    }
    else if(report_type=="2")   //by individu
    {
<!--        alert("by individu");-->
        $('#row_year').show();
        $('#row_staff').show();
        $('#btn_generateReport').show();

        $('#row_month').hide();
    }
    else
    {
        $('#row_year').hide();
        $('#row_month').hide();
        $('#row_staff').hide();
        $('#btn_generateReport').hide();
    }

});

$('#btn_generateReport').on('click',function(){
    var report_type = $('#report_type').val();
    var obj = new Object();

    if(report_type=="1")    //by month
    {
        obj.year = $('#year').val();
        obj.month = $('#month').val();
        obj.month_name = $("#month option:selected").text();

        getMonthlyReport(obj);

    }
    else if(report_type=="2")   //by individu
    {
        obj.year = $('#year').val();
        obj.staff = $('#staff').val();
        obj.staff_name = $("#staff option:selected").text();

        getStaffReport(obj);
    }
});


@endsection


@section('js_script')

function getMonthlyReport(obj)
{
    $('#errMsg').hide();    <!--  hide #errMsg -->
    $('#row_tbl_month_report').hide();
    var url = APP_URL+"/claimMileageReport/monthlyReport";
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
                var month_total = 0;
                $('#month_report_table >tbody').html("");
                for(var i=0;i<arr_obj.length;i++)
                {
                    var _obj =arr_obj[i];
                    _obj = _obj[0];
    <!--                alert(_obj.name +' '+ _obj.total);-->
                    $('#month_report_table >tbody').append("<tr><td>"+ _obj.name +"</td><td>"+_obj.total.toFixed(2)+"</td></tr>");
                    month_total+=_obj.total;
                }
                $('#month_report_table >thead').html("<tr><th>Nama Staff</th><th>Jumlah Tuntutan(RM)</th></tr>");
                $('#month_report_table >tbody').append("<tr><th>Jumlah</th><th>"+month_total.toFixed(2)+"</th></tr>");

                $('#table_title').html("Tuntutan Perjalanan "+ obj.month_name + " " + obj.year);

                drawChart(arr_obj,obj.month_name,obj.year);  <!-- draw bar chart -->
                $('#row_tbl_month_report').show();
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


function getStaffReport(obj)
{
    $('#errMsg').hide();    <!--  hide #errMsg -->
    $('#row_tbl_month_report').hide();
    var url = APP_URL+"/claimMileageReport/staffReport";
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
            if(arr_obj[0]!=null)
            {
                var month_total = 0;
                $('#month_report_table >tbody').html("");
                for(var i=0;i<arr_obj.length;i++)
                {
                    var _obj =arr_obj[i];
<!--                    alert(_obj.name +' '+ _obj.total);-->
                    $('#month_report_table >tbody').append("<tr><td>"+ _obj.name +"</td><td>"+_obj.total.toFixed(2)+"</td></tr>");
                    month_total+=_obj.total;
                }
                $('#month_report_table >thead').html("<tr><th>Nama Staff</th><th>Jumlah Tuntutan(RM)</th></tr>");
                $('#month_report_table >tbody').append("<tr><th>Jumlah</th><th>"+month_total.toFixed(2)+"</th></tr>");

                $('#table_title').html("Tuntutan Perjalanan Tahun "+ obj.year +" bagi " + obj.staff_name);

                drawChartStaff(arr_obj,obj.staff_name,obj.year);  <!-- draw bar chart -->
                $('#row_tbl_month_report').show();
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
<!--    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->
    <script src="{{ asset('/js/loader.js') }}"></script> <!-- for global js function 160507 -->
    <script type="text/javascript">
       google.charts.load('current', {packages: ['corechart', 'bar']});

       function drawChart(arr_obj,month,year)
       {
           google.charts.setOnLoadCallback(drawChart2);
           function drawChart2() {
//               var data = google.visualization.arrayToDataTable([
//                   ["Element", "Jumlah"],
//                   ["Jan", 300.94],
//                   ["Feb", 320.49],
//                   ["March", 239.90],
//                   ["April", 350.94]
//               ]);

               var data = new google.visualization.DataTable();
               data.addColumn('string', 'Nama Staff');
               data.addColumn('number', 'Jumlah Tuntutan');

               for(var i=0;i<arr_obj.length;i++)
               {
                   var _obj =arr_obj[i];
                   _obj = _obj[0];
                   <!--                alert(_obj.name +' '+ _obj.total);-->
                   data.addRows([[_obj.name, _obj.total]]);
               }


               var view = new google.visualization.DataView(data);
               view.setColumns([0, 1]);

               var options = {
                   title: "Tuntutan Perjalanan "+ month +" "+ year,
                   width: 600,
                   height: 400,
                   bar: {groupWidth: "95%"},
                   legend: { position: "none" },
                   hAxis: {
                       title: 'Nama Staff'
                   },
                   vAxis: {
                       title: 'Jumlah Tuntutan (RM)'
                   },
               };
               var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
               chart.draw(view, options);
           }
       }

       function drawChartStaff(arr_obj,staff,year)
       {
           google.charts.setOnLoadCallback(drawChart2);
           function drawChart2() {

               var data = new google.visualization.DataTable();
               data.addColumn('string', 'Bulan');
               data.addColumn('number', 'Jumlah Tuntutan');

               for(var i=0;i<arr_obj.length;i++)
               {
                   var _obj =arr_obj[i];
                   <!--                alrt(_obj.name +' '+ _obj.total);-->
                   data.addRows([[_obj.name, _obj.total]]);
               }


               var view = new google.visualization.DataView(data);
               view.setColumns([0, 1]);

               var options = {
                   title: "Tuntutan Perjalanan Tahun " + year +" bagi " + staff,
                   width: 600,
                   height: 400,
                   bar: {groupWidth: "95%"},
                   legend: { position: "none" },
                   hAxis: {
                       title: 'Bulan'
                   },
                   vAxis: {
                       title: 'Jumlah Tuntutan (RM)'
                   },
               };
               var chart = new google.visualization.ColumnChart(document.getElementById("chart_div"));
               chart.draw(view, options);
           }
       }
    </script>



@endsection

