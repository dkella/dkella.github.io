@extends('cms_master')

@section('content')

    <div class="row">
        <div id="vehicle_form" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-edit pull-left">&nbsp;</span><h3 class="panel-title">Daftar Pengguna Baru</h3>
                </div>
                <div class="panel-body">
<!--                    <form class="form-horizontal" id="myForm">-->
                        {!! Form::model($personal= new \App\User, ['url' => 'personal','id' => 'myForm','class' => 'form-horizontal']) !!}

                        @include('personal.form',['submitButtonText' => 'Daftar Pengguna'])
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>


            <!-- when we say include, we got to views folder -->
    @include('errors.list')

@endsection


@section('js_script_ready')
<!--    $('#reset').on('click',function(){-->
<!--<!--        $('#myForm')[0].reset();-->-->
<!--        console.log($('#myForm')[0]);-->
<!--    });-->
    $('#role').on('change',function(){
<!--        alert($(this).val());-->
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

@endsection