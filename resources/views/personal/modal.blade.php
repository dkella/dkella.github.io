<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Daftar Pengguna Baru</h4>
            </div>
            <div class="modal-body" style="padding: 20px 40px;">
                <form class="form-horizontal" id="myForm">

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

                    <div id="noKPErrMsg" class="col-sm-offset-4 col-sm-8 red_text"></div>

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

                    <!-- Salary Form Input -->
                    <div class="form-group">
                        {!! Form::label('salary','Gaji:',['class' => 'col-sm-4']) !!}
                        <div class="col-sm-8">
                            {!! Form::text('salary',null,['class' => 'form-control']) !!}

                        </div>
                    </div>
                    <div id="salaryErrMsg" class="col-sm-offset-4 col-sm-8 red_text"></div>
                </form>
            </div>
            <div class="modal-footer">
                <div id="errorMsg" class="pull-left red_text"></div>
                <button type="button" class="btn btn-primary" id="add_update">Daftar Pengguna</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
<!--                <button type="button" class="btn btn-primary" data-dismiss="modal" id="add_update">Tambah</button>-->
<!--                <button type="button" class="btn btn-danger" data-dismiss="modal" id="delete">Buang</button>-->
<!--                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>-->
            </div>
        </div>

    </div>
</div>
<!-- end of Modal -->
