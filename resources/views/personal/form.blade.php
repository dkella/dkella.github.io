<!-- Name Form Input -->
<div class="form-group">
    {!! Form::label('name','Nama:',['class' => 'col-sm-4']) !!}
    <div class="col-sm-8">
        {!! Form::text('name',null,['class' => 'form-control']) !!}
    </div>
</div>

<!-- no KP Form Input -->
<div class="form-group">
    {!! Form::label('noKP','No KP:',['class' => 'col-sm-4']) !!}
    <div class="col-sm-8">
        {!! Form::text('noKP',null,['class' => 'form-control']) !!}
    </div>
</div>

<!-- email Form Input -->
<div class="form-group">
    {!! Form::label('email','Email:',['class' => 'col-sm-4']) !!}
    <div class="col-sm-8">
        {!! Form::email('email',null,['class' => 'form-control']) !!}
    </div>
</div>

<!-- homeAddress Form Input -->
<div class="form-group">
    {!! Form::label('homeAddress','Alamat Kediaman:',['class' => 'col-sm-4']) !!}
    <div class="col-sm-8">
        {!! Form::textarea('homeAddress',null,['class' => 'form-control']) !!}
    </div>
</div>

<!-- Department Form Input -->
<div class="form-group">
    {!! Form::label('dept_id','Jabatan:',['class' => 'col-sm-4']) !!}
    <div class="col-sm-8">
        {!! Form::select('dept_id', $dropDown_dept,null,['class' => 'form-control']); !!}
    </div>
</div>

<!-- Branch Form Input -->
<div class="form-group">
    {!! Form::label('branch','Cawangan:',['class' => 'col-sm-4']) !!}
    <div class="col-sm-8">
        {!! Form::text('branch',null,['class' => 'form-control']) !!}
    </div>
</div>

<!-- Position Form Input -->
<div class="form-group">
    {!! Form::label('position','Jawatan:',['class' => 'col-sm-4']) !!}
    <div class="col-sm-8">
        {!! Form::text('position',null,['class' => 'form-control']) !!}
    </div>
</div>

<!-- user role Form Input -->
<div class="form-group">
    {!! Form::label('role','Jenis Pengguna:',['class' => 'col-sm-4']) !!}
    <div class="col-sm-8">
        {!! Form::select('role',$dropDown_role,null,['class' => 'form-control']) !!}
    </div>
</div>

<!-- Supervisor Form Input -->
<div class="form-group" style="display: none;">
    {!! Form::label('sv','Penyelia:',['class' => 'col-sm-4']) !!}
    <div class="col-sm-8">
        {!! Form::select('sv',$dropDown_sv,null,['class' => 'form-control']) !!}
    </div>
</div>

<!-- Salary Form Input -->
<div class="form-group">
    {!! Form::label('salary','Gaji:',['class' => 'col-sm-4']) !!}
    <div class="col-sm-8">
        {!! Form::text('salary',null,['class' => 'form-control']) !!}

    </div>
</div>

<!-- Submit Button Form Input -->
<!--<div class="form-group">-->
<!--    <div class="col-sm-offset-3 col-sm-5">-->
<!--         Form::submit($submitButtonText,['class' => 'btn btn-primary form-control', 'id' => 'add_update']) !!}-->
<!--    </div>-->
<!--    <div class="col-sm-4">-->
<!--         Form::button('Reset',['class' => 'btn btn-default form-control', 'id' => 'reset']) !!}-->
<!--    </div>-->
<!--</div>-->


@section('footer')

@endsection

<!--'name' => 'admin1',-->
<!--'noKP' => '',-->
<!--'email' => 'admin@example.com',-->
<!--'password' => \Illuminate\Support\Facades\Hash::make('password'),-->
<!--'position' => '',-->
<!--'dept_id' => $dept_acc,-->
<!--'branch' => '',-->
<!--'homeAddress' => '',-->
<!--'salary' => '',-->