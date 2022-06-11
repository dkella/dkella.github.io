@extends('cms_master')
<style>
    .claim_form
    {
        margin:0px 80px;
    }
    .claim_form table
    {
        text-align: left;
    }
    .claim_form table tbody tr td
    {
        padding-right: 15px;
    }
    /*.claim_form table thead*/
    /*{*/
        /*text-align: center;*/
        /*font-weight: bold;*/
    /*}*/
    .red_text
    {
        color:red;

    }
</style>
@section('content')
<div id="test_print" class="well bs-component" style="text-align: center; margin-left:60px; margin-right: 60px; ">

@if(!empty($vehicle))
<form class="form-horizontal">
<fieldset>
<legend class="text-uppercase">Tuntutan Perjalanan Dalam Negeri bagi Bulan {{$month->name}} {{$claims->year}}</legend>

<div class="claim_form">
    <table border="0" cellpadding="2" style="font-size: 0.9em;">
        <tbody>
        <tr>
            <td style="width:10%">Nama</td>
            <td style="width:1%">:</td>
            <td style="width:40%">{{ $personal->name }}</td>
            <td style="width:10%">Ibu Pejabat</td>
            <td style="width:1%">:</td>
            <td style="width:38%">{{ $personal->branch }}</td>
        </tr>
        <tr>
            <td>Jawatan</td>
            <td>:</td>
            <td>{{ $personal->position }}</td>
            <td>Alamat Kediaman</td>
            <td>:</td>
            <td>{{ $personal->homeAddress }}
            </td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $personal->departments->department }}</td>
            <td>Kenderaan</td>
            <td>:</td>
            <td>{{ $personal->vehicles->vehicleName }} {{ $personal->vehicles->engine }}cc</td>
        </tr>
        <tr>

            <td>No K/P</td>
            <td>:</td>
            <td>{{ $personal->noKP }}</td>
            <td>Nombor</td>
            <td>:</td>
            <td>{{ $personal->vehicles->plateNo }}</td>
        </tr>
        <tr>
            <td>Gaji</td>
            <td>:</td>
            <td>RM {{  number_format($personal->salary,2,".","") }}</td>

            <td>Kelas</td>
            <td>:</td>
<!--            <td>D</td>-->
<!--            <td> $personal->vehicles->class_id </td>-->
            <td id="vehicle_class">{{ $personal->vehicles->travelconfig->vehicleClass }}</td>
        </tr>
        </tbody>
    </table>
</div>

<br>

<div class="claim_form">
    <table class="table-bordered" style="width: 100%; border-right:0px; border-bottom:0px;" id="claim_table" claim_id="{{ $claims->id }}" claim_status="{{ $claims->status}}">
        <thead>
        <tr>
            <th rowspan="2">TARIKH</th>
            <th colspan="2">MASA BERTUGAS</th>
            <th rowspan="2">JAM</th>
            <th rowspan="2">Jenis Tugasan</th>
            <th rowspan="2">KENYATAAN</th>
            <th rowspan="2">KM</th>
<!--            <th rowspan="2">RM</th>-->
            <th rowspan="2">Baiki</th>
        </tr>
        <tr>
            <th>MULA</th>
            <th>TAMAT</th>
        </tr>
        </thead>
        <tbody>
        @foreach($claims->travelclaim as $claim)
        <tr claim_id="{{$claim->id}}" rejectReason="{{ $claim->rejectReason }}" fm_rejectReason="{{ $claim->fm_rejectReason }}">
            <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$claim->date)->format('Y-m-d') }}</td>
            <td>{{ date('h:i A', strtotime( $claim->startTime)) }}</td>
            <td>{{ date('h:i A', strtotime( $claim->endTime)) }}</td>
            <td>{{ $claim->hour }}</td>
            <td task_id="{{$claim->tasks->id}}">{{ $claim->tasks->task_name }}</td>
            <td>{{ $claim->travelDesc }}</td>
            <td>{{ $claim->mileage }}</td>
<!--               4-sv rejected 2-fm reject -->
            @if($claim->flag==4 || $claim->flag==2)
            <td style="border:0px;"><a href="#" class="edit_modal" claim_status="{{$claim->flag}}">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                </a>
            </td>
            @else
            <td　style="border:0px;">&nbsp;</td>
            @endif

        </tr>
        @endforeach


        </tbody>
    </table>
</div>
<div class="claim_form text-right">
    <strong>Total: <span class="red_text" id="claim_total">RM {{ number_format($claims->total,2,".","") }}</span></strong>
</div>
<br>
<hr>
<!--<div class="divider"></div>-->
<div class="claim_form">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <table class="table-bordered" id="table_travelConfig">
            <thead 1style="text-align: center;">
            <tr>
                <td rowspan="2">Kelas </td>
                <td colspan="5">Kadar Tuntutan(sen/km)</td>
            </tr>
            <tr>
                <td>>=500 KM</td>
                <td>501-1000 KM</td>
                <td>1001-1700 KM</td>
                <td><1700 KM</td>
            </tr>
            </thead>
            <tbody>
            @foreach($travelConfig as $x)
            <tr>
                <th>{!! $x-> vehicleClass !!}</th>
                <td>{!! $x-> rateA !!}</td>
                <td>{!! $x-> rateB !!}</td>
                <td>{!! $x-> rateC !!}</td>
                <td>{!! $x-> rateD !!}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 form-group pull-right">
<!--        <button type="button" class="btn btn-primary" id="add_record">Tambah</button>-->
<!--        <button type="button" data-loading-text="Loading..." class="btn btn-primary" id="btn_submit" value="{{ $state }}">Hantar</button>-->
<!--        <button type="button" data-loading-text="Loading..." class="btn btn-primary" id="btn_save" value="{{ $state }}">Simpan</button>-->
        <button type="button" data-loading-text="Loading..." class="btn btn-primary" id="btn_correction" value="{{ $state }}">Kemaskini</button>
        <button type="button" class="btn btn-default" id="btn_cancel">Batal</button>
    </div>

</div>

<!--            <div class="form-group">
                <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" id="inputEmail" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword" class="col-lg-2 control-label">Password</label>
                <div class="col-lg-10">
                    <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> Checkbox
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="textArea" class="col-lg-2 control-label">Textarea</label>
                <div class="col-lg-10">
                    <textarea class="form-control" rows="3" id="textArea"></textarea>
                    <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label">Radios</label>
                <div class="col-lg-10">
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                            Option one is this
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                            Option two can be something else
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="select" class="col-lg-2 control-label">Selects</label>
                <div class="col-lg-10">
                    <select class="form-control" id="select">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                    <br>
                    <select multiple="" class="form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="reset" class="btn btn-default">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>-->

</fieldset>
</form>
@else
    <p>Tiada Kenderaan.Sila <a href="/vehicle">daftar kenderaan</a> terlebih dahulu. </p>
@endif
</div>





@include('claimMileage.modal')

@endsection


@section('footer')

    <script src="{{ asset('/js/mileage.js') }}"></script> <!-- created on:160319 -->
    <script id='claim_table_template' type='text/x-jquery-tmpl'>
        <tr>
            <td>${date}</td>
            <td>${startTime}</td>
            <td>${endTime}</td>
            <td>${hour}</td>
            <td task_id="${task_id}">${task_name}</td>
            <td>${travelDesc}</td>
            <td>${mileage}</td>
            <td is_update="1" style="border:0px;"><a href="#" class="edit_modal">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                </a>
            </td>
        </tr>
    </script>
@endsection