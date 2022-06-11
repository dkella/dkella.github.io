@extends('cms_master')
@section('style')
    .table-borderless tbody tr td, .table-borderless tbody tr th, .table-borderless thead tr th {
        border: none;
    }
@endsection
@section('content')
    <div class="col-lg-12 col-md-12">
        <button type="button" class="btn btn-primary" id="reg_new_user">Daftar Pengguna Baru</button>
    </div>
    <div class="col-lg-12 col-md-12">
        &nbsp;
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Senarai Pengguna</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered" id="staff_list">
                    <thead>
                        <tr>
                            <th>No KP</th>
                            <th>Nama</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($sv_staffs as $x)
                    <tr user_id="{{$x->id}}" name="{{$x->name}}" noKP="{{$x->noKP}}" position="{{$x->position}}"
                        email="{{$x->email}}" role_id="{{$x->roles->first()->id}}"
                        @if(sizeof($x->theSupervisors)!=0)
                            sv_id="{{$x->theSupervisors->first()->id}}"
                        @endif
                        dept_id="{{$x->departments->id}}" department="{{$x->departments->department}}"
                        salary="{{$x->salary}}" branch="{{$x->branch}}" homeAddress="{{$x->homeAddress}}"
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
            <div class="panel-footer">
                <button type="button" class="btn btn-primary" id="edit_staff">Kemaskini</button>
            </div>
        </div>
    </div>
    @include('personal.modal')
@endsection

@section('js_script_ready')
    $('#role').on('change',function(){
        var sv_parent = $('#sv').parent().parent();
        if($(this).val()==2)
        {
            sv_parent.show();
        }
        else
        {
            sv_parent.hide();
        }

    });

<!--    register new user-->
    $('#reg_new_user').on('click',function(){
        $('#errorMsg').html('');
        $('#myForm')[0].reset();
        $('#sv').parent().parent().hide();  <!-- hide sv Dropdown-->
        $('.modal-title').text("Daftar Pengguna Baru");
        $('#add_update').text("Daftar Pengguna");
        $('#myModal').modal('show');

    });
<!--    update user info-->
    $('#edit_staff').on('click',function(){
        var row_index = $('#edit_staff').attr('row_index');
        var user_id = $('#edit_staff').attr('user_id');
        $('#errorMsg').html('');
        $('#myForm')[0].reset();
        $('#sv').parent().parent().hide();  <!-- hide sv Dropdown-->
        $('.modal-title').text("Kemaskini Maklumat Pengguna");
        $('#add_update').text("Kemaskini");
        $('#add_update').attr('row_index',row_index);
        $('#add_update').attr('user_id',user_id);


        var _row=$('#staff_list > tbody').find( "tr:eq("+row_index+")");
<!--        alert(_row.html());-->
        var obj = new Object();
        obj.name = _row.attr('name');
        obj.noKP = _row.attr('noKP');
        obj.email = _row.attr('email');
        obj.position = _row.attr('position');
        obj.dept_id=_row.attr('dept_id');
        obj.department = _row.attr('department');
<!--        obj.salary = _row.attr('salary');-->
        obj.salary = parseFloat(_row.attr('salary')).toFixed(2);
        obj.branch = _row.attr('branch');
        obj.homeAddress = _row.attr('homeAddress');

        obj.role= _row.attr('role_id');
        obj.sv= _row.attr('sv_id');
        console.log(obj);
<!--        to be continued-->
        $('#name').val(obj.name);
        $('#noKP').val(obj.noKP);
        $('#email').val(obj.email);
        $('#homeAddress').val(obj.homeAddress);
        $('#dept_id').val(obj.dept_id);
        $('#branch').val(obj.branch);
        $('#position').val(obj.position);
        $('#role').val(obj.role);
        if(obj.role==2)
        {
            $('#sv').val(obj.sv);
            $('#sv').parent().parent().show();  <!-- show sv Dropdown-->
        }
        $('#salary').val(obj.salary);


        $('#myModal').modal('show');

    });

    $(document).on('click','.glyphicon-eye-open',function () {
        //                      a    td          tr
        var _row = $(this).parent().parent().parent();
<!--        alert(_row.html());-->
        var row_index = _row.index();
<!--        $('#edit_staff').removeAttr('row_index');-->
        $('#edit_staff').attr('row_index',row_index);

        var _panel_body= $('#staff_detail').find('.panel-body');
        _panel_body.html('');

        //                     a      td        tr
        var _row = $(this).parent().parent().parent();
        var obj = new Object();
        obj.name = _row.attr('name');
        obj.email = _row.attr('email');
        obj.noKP = _row.attr('noKP');
        obj.position = _row.attr('position');
<!--        obj.dept_id=_row.attr('dept_id');-->
        obj.department = _row.attr('department');
<!--        obj.salary = _row.attr('salary');-->
        obj.salary = parseFloat(_row.attr('salary')).toFixed(2);
        obj.branch = _row.attr('branch');
        obj.homeAddress = _row.attr('homeAddress');

        $('#staff_table_template').tmpl(obj).appendTo(_panel_body);

        var user_id = _row.attr('user_id');
        $('#edit_staff').attr('user_id',user_id);

        $('#staff_detail').show();

    });

<!--//only allow numeric data with decimal point-->
$("#salary").on("keypress",function (event) {
<!--    //this.value = this.value.replace(/[^0-9\.]/g,'');-->
    $(this).val($(this).val().replace(/[^0-9\.]/g,''));
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
<!--        //display error message-->
        $("#salaryErrMsg").html("Sila masukkan nombor sahaja").show().fadeOut("slow");
        return false;
<!--        //            event.preventDefault(); //use this or return false-->
    }
});

<!--//only allow numeric data with decimal point-->
$("#noKP").on("keypress",function (event) {
<!--    //this.value = this.value.replace(/[^0-9\.]/g,'');-->
    $(this).val($(this).val().replace(/[^0-9\.]/g,''));
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
<!--        //display error message-->
        $("#noKPErrMsg").html("Sila masukkan nombor sahaja").show().fadeOut("slow");
        return false;
<!--        //            event.preventDefault(); //use this or return false-->
    }
});

<!--var min = 12;-->
<!--$("#noKP").keydown(function() {-->
<!--    if(this.value.length != min) {-->
<!--<!--    // Min notice-->-->
<!--        $('#noKP').focus();-->
<!--        $('#errorMsg').html("12 digit sahaja.");-->
<!--    } else {-->
<!--<!--    // Current count-->-->
<!--$('#errorMsg').html("");-->
<!--    }-->
<!--});-->

<!--    when modal's add/update button is click-->
$("#add_update").on("click", function(){
    var body=$(this).parent().siblings('.modal-body');
    var obj=new Object();

    obj.name=body.find('#name').val();
    obj.noKP=body.find('#noKP').val();
    obj.email=body.find('#email').val();
    obj.homeAddress=body.find('#homeAddress').val();
    obj.dept_id=body.find('#dept_id').val();
    obj.department=body.find('#dept_id option:selected').text();
<!--alert(obj.department);-->
    obj.branch= body.find('#branch').val();
    obj.position= body.find('#position').val();
    obj.role= body.find('#role').val();
    obj.salary= body.find('#salary').val();
<!--    input validation-->
    if(obj.name=="")
    {
        $('#name').focus();
        $('#errorMsg').html("Sila isikan nama.");
    }
    else if(obj.noKP=="")
    {
        $('#noKP').focus();
        $('#errorMsg').html("Sila isikan nombor Kad Pengenalan.");
    }
    else if(obj.email=="")
    {
        $('#email').focus();
        $('#errorMsg').html("Sila isikan email.");
    }
    else if(obj.homeAddress=="")
    {
        $('#homeAddress').focus();
        $('#errorMsg').html("Sila isikan Alamat Kediaman.");
    }
    else if(obj.branch=="")
    {
        $('#branch').focus();
        $('#errorMsg').html("Sila isikan cawangan.");
    }
    else if(obj.position=="")
    {
        $('#position').focus();
        $('#errorMsg').html("Sila isikan jawatan.");
    }
    else if(obj.salary=="")
    {
        $('#salary').focus();
        $('#errorMsg').html("Sila isikan gaji.");
    }
    else if(obj.noKP.length!=12)
    {
        $('#noKP').focus();
        $('#errorMsg').html("Sila masukkan 12 digit sahaja.");
    }
    else
    {
        var is_exist = false;
        if($('#add_update').text()!="Kemaskini")
        {
            $('#staff_list >tbody>tr').each(function(){
                var _this = $(this);
                var _noKP = _this.children().eq(0).text();

                if(obj.noKP==_noKP)
                {
                    $('#noKP').focus();
                    $('#errorMsg').html("no KP ini telah berdaftar. Sila isikan no KP lain.");
                    is_exist = true;
                }
            });
        }
        if(is_exist==true)
        {
            return false;
        }
<!--    input validation end-->

        if(obj.role==2)
        {
            obj.sv= body.find('#sv').val();
        }

        if($('#add_update').text()=="Daftar Pengguna")
        {
            var my_url = APP_URL+"/personal";
            var inputData = JSON.stringify(obj);
            $.ajax({
                type: "POST",
                url: my_url,
                data: inputData,
                //            dataType: 'json',
                contentType: 'json',  //for array of jason
                processData: false, //for array of jason
    <!--            async: false,  //wait this done runs-->
                success: function (data) {
                    console.log('Success:',data);
                    var return_data = JSON.parse(data);  <!-- as the type of data is string, JSON.parse is needed -->
                    var return_obj = return_data.data;
    <!--                alert(jQuery.type(return_data));-->

                    $('#staff_list_template').tmpl(return_obj).appendTo('#staff_list');
                    <!--    $('#claim_table > tbody tr:last').data('object',obj);   //<!-- add obj to tr :) -->
                    $('#myModal').modal('hide');
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('body').html(data.responseText);  //easier to debug
                }
            });

        }
        else
        {
    <!--        var my_url = APP_URL+"/personal/edit";-->

            var user_id = $('#add_update').attr('user_id');
            var my_url = APP_URL+"/personal/"+user_id;

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

                    var return_data = JSON.parse(data);  <!-- as the type of data is string, JSON.parse is needed -->
                    var return_obj = return_data.data;
                    <!--                alert(jQuery.type(return_data));-->

                    var row_index = $('#add_update').attr('row_index');
                    var _row = $('#staff_list > tbody').find( "tr:eq("+row_index+")");
                    _row.replaceWith($('#staff_list_template').tmpl(return_obj));  <!-- _row.index() will become -1 -->
    <!--                update detail list-->
                    $('#staff_list > tbody').find( "tr:eq("+row_index+")").find('.glyphicon-eye-open').click();
                    $('#myModal').modal('hide');
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('body').html(data.responseText);  //easier to debug
                }
            });
        }
    } <!-- end validation-->
<!---->
<!--    refreshClaimTotal();-->
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
                    <th>No K/P</th>
                    <th>:</th>
                    <td>${noKP}</td>
                </tr>
                <tr>
                    <th>Gaji</th>
                    <th>:</th>
                    <td>RM ${salary}</td>
                </tr>
                <tr>
                    <th>Alamat Kediaman</th>
                    <th>:</th>
                    <td>${homeAddress}</td>
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
                    <th>Ibu Pejabat</th>
                    <th>:</th>
                    <td>${branch}</td>
                </tr>
            </tbody>
        </table>
    </script>
    <script id='staff_list_template' type='text/x-jquery-tmpl'>
        <tr user_id ="${id}" name="${name}" noKP="${noKP}" position="${position}"
            email="${email}" role_id="${role}" sv_id="${sv}"
            dept_id="${dept_id}" department="${department}" salary="${salary}"
            branch="${branch}" homeAddress="${homeAddress}"
            >
            <td>${noKP}</td>
            <td>${name}</td>
            <td><a href="#"><span class="glyphicon glyphicon-eye-open"></span></a> </td>
        </tr>
    </script>
@endsection

<!--obj.name=body.find('#name').val();-->
<!--obj.noKP=body.find('#noKP').val();-->
<!--obj.email=body.find('#email').val();            no-->
<!--obj.homeAddress=body.find('#homeAddress').val();-->
<!--obj.dept_id=body.find('#dept_id').val();-->
<!--obj.branch= body.find('#branch').val();-->
<!--obj.position= body.find('#position').val();-->
<!--obj.role= body.find('#role').val();             no-->
<!--obj.sv= body.find('#sv').val();                 no-->
<!--obj.salary= body.find('#salary').val();-->