
<!-- Plate Number Form Input -->
<div class="form-group">
    {!! Form::label('plateNo','Nombor Plate:',['class' => 'col-sm-6']) !!}
    <div class="col-sm-6">
        {!! Form::text('plateNo',null,['class' => 'form-control']) !!}
    </div>
</div>

<!-- Vehicle Form Input -->
<div class="form-group">
    {!! Form::label('vehicleName','Kenderaan:',['class' => 'col-sm-6']) !!}
    <div class="col-sm-6">
        {!! Form::text('vehicleName',null,['class' => 'form-control']) !!}
    </div>
</div>

<!-- Engine size Form Input -->
<div class="form-group">
    {!! Form::label('engine','Saiz Engine(cc):',['class' => 'col-sm-6']) !!}
    <div class="col-sm-6">
        {!! Form::select('engine', ['175'=>'175 cc','660'=>'660 cc','850'=>'850 cc','1000'=>'1000 cc','1300'=>'1300 cc','1500'=>'1500 cc','2000'=>'2000 cc'],null,['class' => 'form-control']); !!}
    </div>
</div>

<!-- Classification Form Input -->
<div class="form-group">
    {!! Form::label('class_id','Kelas:',['class' => 'col-sm-6']) !!}
    <div class="col-sm-6">
        {!! Form::select('class_id', $dropDown_class,null,['class' => 'form-control', 'readonly' => 'readonly']); !!}
    </div>
</div>



<!-- Submit Button Form Input -->
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-5">
        {!! Form::submit($submitButtonText,['class' => 'btn btn-primary form-control', 'id' => 'add_update']) !!}
    </div>
    <div class="col-sm-4">
        {!! Form::button('Batal',['class' => 'btn btn-default form-control', 'id' => 'cancel']) !!}
    </div>
</div>

@section('footer')

@endsection