@extends('cms_master')

@section('style')
.table-borderless tbody tr td, .table-borderless tbody tr th, .table-borderless thead tr th {
    border: none;
}
@endsection
@section('content')
        <div id="vehicle_info" class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
        @if (!empty($vehicle))
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Maklumat Kenderaan</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-borderless col-lg-12 col-md-12 col-sm-12 col-xs-12" 1cellspacing="10" 1cellpadding="10">
                        <tbody>
                            <tr>
                                <th>Nombor Plate</th>
                                <th>:</th>
                                <td>{{ $vehicle->plateNo }}</td>
                            </tr>
                            <tr>
                                <th 1style="width:29%">Kenderaan</th>
                                <th 1style="width:1%">:</th>
                                <td 1style="width:70%">{{ $vehicle->vehicleName }}</td>
                            </tr>
                            <tr>
                                <th>Saiz Engine</th>
                                <th>:</th>
                                <td>{{ $vehicle->engine }}cc</td>
                            </tr>
                            <tr>
                                <th>Kelas</th>
                                <th>:</th>
                                <!--        <td> $vehicle->class_id </td>-->
                                <td>{{ $vehicle->travelconfig->vehicleClass }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="float:right;">
                        <button type="button" class="btn btn-default" id="btn_update" vehicle_id="{{ $vehicle->id}}" style="vertical-align: text-bottom;">Kemaskini</button>
                    </div>
                </div>
            </div>
        @else
            <p>Tiada kenderaan.<a href="#" id="new_vehicle">Daftar kenderaan</a> </p>
        @endif
    </div>
    <div id="vehicle_form" class="col-lg-4 col-md-5 col-sm-12 col-xs-12" style="display:none;">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <span class="glyphicon glyphicon-edit pull-left">&nbsp;</span><h3 class="panel-title">Kemaskini Kenderaan</h3>
            </div>
            <div class="panel-body">
                <!-- update vehicle -->
                @if (!empty($vehicle))
                    {!! Form::model($vehicle,['method' => 'PATCH', 'action' => ['VehicleController@update',$vehicle->id], 'class' => 'form-horizontal','id' =>'form1']) !!}
                        @include('vehicle.form',['submitButtonText'=>'Kemaskini'])
                    {!! Form::close()!!}

                <!-- Add new vehicle-->
                @else
                    {!! Form::model($vehicle= new \App\Vehicle, ['url' => 'vehicle', 'class' => 'form-horizontal']) !!}
                        @include('vehicle.form',['submitButtonText' => 'Daftar'])
                    {!! Form::close() !!}
                @endif


            </div>
        </div>
    </div>
    <div id="errMsg"  class="red_text pull-left" style="display:none;"></div>

@endsection

@section('js_script_ready')
    $('#new_vehicle').on('click', function(){
        $('#vehicle_form h3').html('Daftar Kenderaan');
        $('#vehicle_info').hide();
        $('#vehicle_form').show();
    });
    $('#btn_update').on('click', function(){
        $('#vehicle_form h3').html('Kemaskini Kenderaan');
        $('#vehicle_info').hide();
        $('#vehicle_form').show();
    });

    $('#add_update').on('click',function(e){
<!--        var _input = $('#form1 :input');-->
<!--        console.log(_input);-->
        $('#errMsg').hide();
        if($('#plateNo').val()=="")
        {
            $('#errMsg').html("Sila masukkan nombor plate.");
            $('#errMsg').show();
            $('#plateNo').focus();
            e.preventDefault();
        }
        else if($('#vehicleName').val()=="")
        {
            $('#errMsg').html("Sila masukkan nama kenderaan.");
            $('#errMsg').show();
            $('#vehicleName').focus();
            e.preventDefault();
        }
        else if($('#engine').val()=="")
        {
            $('#errMsg').html("Sila pilih saiz engine.");
            $('#errMsg').show();
            $('#engine').focus();
            e.preventDefault();
        }
    });

    $('#cancel').on('click',function(){
        $('#vehicle_info').show();
        $('#vehicle_form').hide();
    });

    $('#engine').on('change',function(){
        var engine_size = parseInt($(this).val());
<!--        alert(jQuery.type(engine_size));-->
<!--        alert(engine_size);-->
        if(engine_size > 1400)
        {
            $('#class_id').prop('selectedIndex', 0);
        }
        else if(engine_size > 1000 && engine_size <= 1400)
        {
            $('#class_id').prop('selectedIndex', 1);
        }
        else if(engine_size > 800 && engine_size <= 1000)
        {
            $('#class_id').prop('selectedIndex', 2);
        }
        else if(engine_size > 175 && engine_size <= 800)
        {
            $('#class_id').prop('selectedIndex', 3);
        }
        else if(engine_size <= 175)
        {
            $('#class_id').prop('selectedIndex', 4);
        }



    });

@endsection