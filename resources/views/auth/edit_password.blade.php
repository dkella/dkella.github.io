@extends('cms_master')

@section('content')
<div class="row">

    <div id="errMsg" class="alert alert-dismissible" style="display: none;">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <p></p>
    </div>
</div>
<div class="row">
    <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-edit pull-left">&nbsp;</span><h3 class="panel-title">Penukaran Kata Laluan</h3>
            </div>
            <div class="panel-body">

                {!! Form::open(['url' => 'password', 'class' => 'form-horizontal','id' => 'edit_form']) !!}

                <!-- old password Form Input -->
                <div class="form-group">
                    {!! Form::label('old_password','Kata Laluan Lama:',['class' => 'col-sm-6 control-label']) !!}
                    <div class="col-sm-6">
                        {!! Form::password('old_password', ['class'=>'form-control']) !!}
                    </div>
                </div>

                <!-- new password Form Input -->
                <div class="form-group">
                    {!! Form::label('password','Kata Laluan Baru:',['class' => 'col-sm-6 control-label']) !!}
                    <div class="col-sm-6">
                        {!! Form::password('password', ['class'=>'form-control']) !!}
                    </div>
                </div>

                <!-- confirmation password Form Input -->
                <div class="form-group">
                    {!! Form::label('password_confirmation','Masukkan sekali lagi:',['class' => 'col-sm-6 control-label']) !!}
                    <div class="col-sm-6">
                        {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
                    </div>
                </div>

                <!-- Submit Button Form Input -->
                <div class="form-group">
                    <div class="col-sm-offset-7 col-sm-5">
                        {!! Form::button('Kemaskini',['class' => 'btn btn-primary form-control', 'id' => 'update']) !!}
                    </div>
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div> <!--end of row-->
@endsection

@section('js_script_ready')
    $('#update').on('click',function(){
<!--        reset error message-->
        $('#errMsg').hide();
        $('#errMsg').removeClass('alert-danger');
        $('#errMsg').removeClass('alert-success');
//                                             div     div
        var _parent_old = $('#old_password').parent().parent();
        var _parent_new = $('#password').parent().parent();
        var _parent_confirm = $('#password_confirmation').parent().parent();

        _parent_old.removeClass('has-error');
        _parent_new.removeClass('has-error');
        _parent_confirm.removeClass('has-error');


        var my_url = APP_URL+"/updatePassword";
        var obj = new Object();
        obj.oldPassword = $('#old_password').val();
        obj.newPassword = $('#password').val();
        obj.confirmPassword = $('#password_confirmation').val();


        if(obj.oldPassword=="")
        {
            _parent_old.addClass('has-error');
            $('#errMsg').find('p').text("Sila masukkan kata laluan lama");
            $('#errMsg').addClass('alert-danger');
            $('#errMsg').show();
        }
        else if(obj.newPassword=="")
        {
            _parent_new.addClass('has-error');
            $('#errMsg').find('p').text("Sila masukkan kata laluan");
            $('#errMsg').addClass('alert-danger');
            $('#errMsg').show();
        }
        else if(obj.confirmPassword=="")
        {
            _parent_confirm.addClass('has-error');
            $('#errMsg').find('p').text("Sila masukkan kata laluan sekali lagi");
            $('#errMsg').addClass('alert-danger');
            $('#errMsg').show();
        }
        else
        {

            var inputData = JSON.stringify(obj);
    <!--        console.error(inputData);-->
    <!--        return;-->
            $.ajax({
                type: "PUT",
                url: my_url,
                data: inputData,
                //            dataType: 'json',
                contentType: 'json',  //for array of jason
                processData: false, //for array of jason
    <!--            async: false,  //wait this done runs-->
                success: function (msg) { //message is string type
                    console.log('Success:',msg);
    <!--                $('body').append(msg);-->
                    var objMsg=JSON.parse(msg);  //JSON.parse whole string
    <!--                var data = objMsg.data;-->
    <!--                alert(data.oldPassword);-->
                    if(objMsg.status==1)  //1-OK 0-not ok
                    {
                        $('#errMsg').addClass('alert-success');
                    }
                    else
                    {
                        if(objMsg.errors=="old") //old password not match
                        {
                            _parent_old.addClass('has-error');
                        }
                        else if(objMsg.errors=="new") //new password not match
                        {
                            _parent_new.addClass('has-error');
                            _parent_confirm.addClass('has-error');
                        }

                        $('#errMsg').addClass('alert-danger');

                    }
                    $('#errMsg').find('p').text(objMsg.msg);
                    $('#errMsg').show();
    <!--                console.error(objMsg.msg);-->

                },
                error: function (data) {
                console.log('Error:', data);

                $('body').html(data.responseText);  //easier to debug
                }
            });
        } //end all field have value
    });
<!---->
<!--    var $editForm = $('#edit_form').validate({-->
<!--    // Rules for form validation-->
<!--    rules: {-->
<!--        old_password: {-->
<!--            required: true,-->
<!--            minlength: 8-->
<!--        },-->
<!--        password: {-->
<!--            required: true,-->
<!--            minlength: 8-->
<!--        },-->
<!--        password_confirmation: {-->
<!--            required: true,-->
<!--            minlength: 8-->
<!--        },-->
<!--    },-->
<!---->
<!--    // Messages for form validation-->
<!--    messages: {-->
<!--        old_password: {-->
<!--            required: 'Sila masukkan kata laluan lama.'-->
<!--        },-->
<!--        password: {-->
<!--            required: 'Sila masukkan kata laluan baru.'-->
<!--        },-->
<!--        password_confirmation: {-->
<!--            required: 'Sila masukkan kata laluan baru sekali lagi. '-->
<!--        },-->
<!--    },-->
<!---->
<!--    // Do not change code below-->
<!--    errorPlacement: function (error, element) {-->
<!--    error.insertAfter(element.parent());-->
<!--    }-->
<!--    });-->
<!---->
@endsection

