    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tambah rekod</h4>
                </div>
                <div class="modal-body" style="padding: 20px 40px;">
                    <div id="rejectReason_id" style="display: none;" class="alert alert-danger">
                    </div>
                    <form class="form-horizontal" id="modal_form">

                            <!-- Date Form Input -->
                            <div class="form-group">
                                {!! Form::label('date','Tarikh:',['class' => 'col-sm-4']) !!}
                                <div class="col-sm-8">
                                    {!! Form::input('date','date',null,['class' => 'form-control']) !!}

                                </div>
                            </div>

                            <!-- Starting Time Form Input -->
                            <div class="form-group">
                                {!! Form::label('start_time','Masa Bertugas Mula:',['class' => 'col-sm-4']) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('start_time',null,['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <!-- End Time Form Input -->
                            <div class="form-group">
                                {!! Form::label('end_time','Masa Bertugas Tamat:',['class' => 'col-sm-4']) !!}
                                <div class="col-sm-8">
                                    {!! Form::text('end_time',null,['class' => 'form-control']) !!}
                                </div>
                            </div>

                            <!-- Is Holiday Tick box -->
                            <div class="form-group">

                                <div class="col-sm-offset-4 col-sm-8">
                                    {!! Form::checkbox('is_holiday',null,false,['id'=>'is_holiday']) !!}
                                    {!! Form::label('is_holiday','Hari Kelepasan?') !!}
                                </div>
                            </div>

                            <!-- OT type Form Input -->
<!--                            <div class="form-group">-->
<!--                                {!! Form::label('ot_type','Jenis K.L.M:',['class' => 'col-sm-4']) !!}-->
<!--                                <div class="col-sm-8">-->
<!--                                    {!! Form::select('ot_type', $dropDown_otRate,null,['class' => 'form-control']); !!}-->
<!--                                </div>-->
<!--                            </div>-->

                            <!-- Description Form Input -->
                            <div class="form-group">
                                {!! Form::label('desc','Kenyataan:',['class' => 'col-sm-4']) !!}
                                <div class="col-sm-8">
                                    {!! Form::textarea('desc',null,['class' => 'form-control']) !!}
                                </div>
                            </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <div id="errorMsg" class="pull-left red_text"></div>
                    <button type="button" class="btn btn-primary" id="add_update">Tambah</button>
                    <button type="button" class="btn btn-danger" id="delete">Buang</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </div>

        </div>
    </div>
    <!-- end of Modal -->
