@extends('cms_master')
@section('style')
.table-borderless tbody tr td, .table-borderless tbody tr th, .table-borderless thead tr th {
border: none;
}
@endsection
@section('content')
<div class="col-lg-6 col-md-6">

    <div class="panel panel-default" id="staff_list">
        <div class="panel-heading">
            @if(Auth::user()->roles()->first()->id==3)  <!-- 3-supervisor, 4-financial clerk -->
                <h3 class="panel-title" session_role_id="{{Auth::user()->roles()->first()->id}}">Senarai Supervisee</h3>
            @elseif(Auth::user()->roles()->first()->id==4)
                <h3 class="panel-title" session_role_id="{{Auth::user()->roles()->first()->id}}">Senarai Staff</h3>
            @endif
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
            <tbody>
            <tr>
                <th>No Kp</th>
                <th>Nama</th>
                <th>&nbsp;</th>
            </tr>
            @foreach($sv_staffs as $x)
            <tr user_id="{{$x->id}}" name="{{$x->name}}" noKP="{{$x->noKP}}" position="{{$x->position}}"
                email="{{$x->email}}"
                department="{{$x->departments->department}}" salary="{{$x->salary}}"
                branch="{{$x->branch}}" homeAddress="{{$x->homeAddress}}"
            >
                <td>{{ $x->noKP}}</td>
                <td>{{ $x->name}}</td>
                <td><a href="#"><span class="glyphicon glyphicon-eye-open"></span></a> </td>
            </tr>
            @endforeach
            </tbody>
            </table>
        </div>
    </div>

</div>
<div  class="col-lg-6 col-md-6" id="staff_detail" style="display: none;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Maklumat Peribadi</h3>
        </div>
        <div class="panel-body">

        </div>
        <div id="errMsg" colspan="3" class="red_text pull-left" style="display:none;"></div>
    </div>
</div>
@endsection

@section('js_script_ready')
    $('.glyphicon-eye-open').on('click',function () {
        var _panel_body= $('#staff_detail').find('.panel-body');
        _panel_body.html('');

        //                     a      td        tr
        var _row = $(this).parent().parent().parent();
        <!--alert(_row.html());-->
<!--        alert(_row.attr('name'));-->
        var obj = new Object();
        obj.name = _row.attr('name');
        obj.email = _row.attr('email');
        obj.noKP = _row.attr('noKP');
        obj.position = _row.attr('position');
        obj.department = _row.attr('department');
        obj.salary = parseFloat(_row.attr('salary')).toFixed(2);
        obj.branch = _row.attr('branch');
        obj.homeAddress = _row.attr('homeAddress');

        $('#staff_table_template').tmpl(obj).appendTo(_panel_body);

        var session_role_id = $('#staff_list .panel-heading .panel-title').attr('session_role_id');
        if(session_role_id==4)  <!-- 3-sv, 4-financial clerk -->
        {
            _panel_body.append('<button id="update_salary">Kemaskini Gaji</button>');
            _panel_body.append('<button id="confirm_update_salary" user_id="'+_row.attr("user_id")+'">Kemaskini</button>');
            _panel_body.append('&nbsp;<button id="cancel_update_salary">Batal</button>');

            $('#confirm_update_salary').hide();
            $('#cancel_update_salary').hide();
        }


        $('#staff_detail').show();

    });

    $(document).on('click','#update_salary',function () {
        var _panel_body= $('#staff_detail').find('.panel-body');
        var tr_salary = _panel_body.find('table >tbody >tr:eq(5)'); <!--staff salary-->
        var td_salary = tr_salary.children().eq(2);
        td_salary.html('RM<input type="text" id="salary_textbox" value="'+td_salary.attr("salary")+'">');
        $('#update_salary').hide();
        $('#confirm_update_salary').show();
        $('#cancel_update_salary').show();
    });

<!--    //only allow numeric data with decimal point-->
    $(document).on("keypress","#salary_textbox",function (event) {
        //this.value = this.value.replace(/[^0-9\.]/g,'');
        $(this).val($(this).val().replace(/[^0-9\.]/g,''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            //display error message
            $("#errMsg").html("Sila masukkan nombor sahaja").show().fadeOut("slow");
            return false;
            //            event.preventDefault(); //use this or return false
        }
    });


    $(document).on('click','#confirm_update_salary',function () {
        var obj = new Object();
        obj.salary = $('#salary_textbox').val();

        $('#errMsg').hide();
        if(obj.salary=="")
        {
            $('#errMsg').html("Sila masukkan gaji.");
            $('#errMsg').show();
            $('#salary_textbox').focus();
            return;
        }
<!--        console.log(obj);-->
        var user_id = $(this).attr('user_id');
        var my_url = APP_URL+"/editSalary/"+user_id;

        var inputData = JSON.stringify(obj);

        $.ajax({
            type: "PUT",
            url: my_url,
            data: inputData,
            //            dataType: 'json',
            contentType: 'json',  //for array of jason
            processData: false, //for array of jason
            <!--            async: false,  //wait this done runs-->
            success: function (data) {
                console.log('Success:',data);

                var _panel_body= $('#staff_detail').find('.panel-body');
                var tr_salary = _panel_body.find('table >tbody >tr:eq(5)'); <!--staff salary-->
                var td_salary = tr_salary.children().eq(2);
                td_salary.attr('salary',obj.salary);
                td_salary.html('RM'+obj.salary);
                $('#update_salary').show();
                $('#confirm_update_salary').hide();
                $('#cancel_update_salary').hide();

                $('#staff_list >.panel-body >table >tbody >tr').each(function(){
                    var _row = $(this);
                    if(_row.attr("user_id")==user_id)
                    {
                        _row.attr("salary",obj.salary);
                    }
                });
            },
            error: function (data) {
                console.log('Error:', data);
                $('body').html(data.responseText);  //easier to debug
            }
        });

    });
    $(document).on('click','#cancel_update_salary',function () {
        var _panel_body= $('#staff_detail').find('.panel-body');
        var tr_salary = _panel_body.find('table >tbody >tr:eq(5)'); <!--staff salary-->
        var td_salary = tr_salary.children().eq(2);
        td_salary.html('RM'+td_salary.attr("salary"));
        $('#update_salary').show();
        $('#confirm_update_salary').hide();
        $('#cancel_update_salary').hide();
    });
@endsection
@section('footer')

<script id='staff_table_template' type='text/x-jquery-tmpl'>
    <table class="table table-borderless">
        <tbody>
            <tr>
                <th>Nama</th>
                <th>:</th>
                <td>${name}</td>
            </tr>
            <tr>
                <th>Email</th>
                <th>:</th>
                <td>${email}</td>
            </tr>
            <tr>
                <th>Jawatan</th>
                <th>:</th>
                <td>${position}</td>
                <!-- <td> $personal->roles->first()->role</td> -->
            </tr>
            <tr>
                <th>Jabatan</th>
                <th>:</th>
                <td>${department}</td>
            </tr>
            <tr>

                <th>No K/P</th>
                <th>:</th>
                <td>${noKP}</td>
            </tr>
            <tr>
                <th>Gaji</th>
                <th>:</th>
                <td salary=${salary}>RM${salary}</td>
            </tr>
            <tr>
                <th>Ibu Pejabat</th>
                <th>:</th>
                <td>${branch}</td>
            </tr>
            <tr>
                <th>Alamat Kediaman</th>
                <th>:</th>
                <td>${homeAddress}</td>
            </tr>

        </tbody>
    </table>


</script>
<!--<td>totalClaim</td>-->
@endsection