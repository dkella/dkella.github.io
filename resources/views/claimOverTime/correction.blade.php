@extends('cms_master')
@section('style')
    .claim_form
    {
        margin: 0px 50px;
    }
    .claim_form table
    {
        text-align: left;
    }
    .claim_form table tbody tr td
    {
        padding-right: 15px;
    }
    #claim_table tbody tr:hover
    {
        cursor: pointer;
        background-color: #E8E8E8 ;
    }
    #claim_table thead tr th
    {
        1valign: middle;
        vertical-align: middle;
        text-align: center;
    }

@endsection
@section('content')
<div class="well bs-component" style="text-align: center;">
    <form class="form-horizontal">
        <fieldset>
            <legend>Tuntutan Kerja Lebih Masa bagi Bulan {{$month->name}} {{$claims->year}}</legend>

            <div class="claim_form">
                <table border="0" cellpadding="2">
                    <tbody>
                    <tr>
                        <td style="width:10%">Nama</td>
                        <td style="width:1%">:</td>
                        <td style="width:40%">{{ $personal->name }}</td>
                        <td style="width:10%">No K/P</td>
                        <td style="width:1%">:</td>
                        <td style="width:38%">{{ $personal->noKP }}</td>
                    </tr>
                    <tr>
                        <td>Jawatan</td>
                        <td>:</td>
                        <td>{{ $personal->position }}</td>
                        <td>Gaji</td>
                        <td>:</td>
                        <td id="salary">RM {{  number_format($personal->salary,2,".","") }}</td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td>{{ $personal->departments->department }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <br>

            <div class="claim_form">
                <table style=" width: 100%; border-right:0px; border-bottom:0px;" class="table table-bordered" id="claim_table" claim_id="{{ $claims->id }}" claim_status="{{ $claims->status}}">
                    <thead>
                    <tr>
                        <th rowspan="2">TARIKH</th>
                        <th colspan="2">MASA BERTUGAS</th>
                        <th rowspan="2">JAM</th>
                        <th colspan="5">JUMLAH K.L.M</th>
                        <th rowspan="2">KENYATAAN</th>
                        <th rowspan="2">RM</th>
                        <th rowspan="2">Baiki</th>
                    </tr>
                    <tr>
                        <th>MULA</th>
                        <th>TAMAT</th>
                        <th>A</th>
                        <th>B</th>
                        <th>C</th>
                        <th>D</th>
                        <th>E</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($claims->otclaim as $claim)
                        <tr isHoliday="{{ $claim->isHoliday }}" claim_id="{{$claim->id}}" rejectReason="{{ $claim->rejectReason }}" fm_rejectReason="{{ $claim->fm_rejectReason }}">
                            <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$claim->date)->format('Y-m-d') }}</td>
                            <td>{{ date('h:i A', strtotime( $claim->startTime)) }}</td>
                            <td>{{ date('h:i A', strtotime( $claim->endTime)) }}</td>
                            <td>{{ $claim->totalHour }}</td>
                            <td>{{ $claim->hourA }}</td>
                            <td>{{ $claim->hourB }}</td>
                            <td>{{ $claim->hourC }}</td>
                            <td>{{ $claim->hourD }}</td>
                            <td>{{ $claim->hourE }}</td>
                            <td>{{ $claim->otDesc }}</td>
                            <td>{{ number_format($claim->totalClaim,2) }}</td>
<!--                            4-sv rejected 2-fm reject -->
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

            <div class="claim_form text-left">
                <strong>
                    <span class="red_text">**</span>Jumlah Tuntutan Kerja Lebih Masa tidak boleh Melebihi 1/3 daripada gaji:<span class="red_text" id="max_claim">RM {{ number_format($personal->salary/3,2,".","") }}</span>
                </strong>
            </div>

            <div class="claim_form text-right">
                <strong>Jumlah Tuntutan: <span class="red_text" id="claim_total">RM {{ number_format($claims->total,2,".","") }}</span></strong>
            </div>

            <br>

            <div class="claim_form">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <table class="table-bordered" id="table_otConfig">
                        <thead 1style="text-align: center;">
                        <tr>
                            <td colspan="2">JENIS KERJA LEBIH MASA (K.L.M)</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($otConfig as $x)
                        <tr id="{{ $x->typeOT }}" rate="{{ $x->rate }}">
                            <td>{{ $x->typeOT }}</td>
                            <td>{{ $x->description }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 form-group">
<!--                    <button type="button" class="btn btn-primary" id="add_record">Tambah</button>-->

<!--                    <button type="button" data-loading-text="Loading..." class="btn btn-primary" id="btn_submit" value="{{ $state }}">Hantar</button>-->
<!--                    <button type="button" data-loading-text="Loading..." class="btn btn-primary" id="btn_save" value="{{ $state }}">Simpan</button>-->
                    <button type="button" data-loading-text="Loading..." class="btn btn-primary" id="btn_correction" value="{{ $state }}">Kemaskini</button>
                    <button type="button" class="btn btn-default" id="btn_cancel">Batal</button>
                </div>

            </div>

        </fieldset>
    </form>
</div>

@include('claimOverTime.modal')


@endsection


@section('footer')

    <script src="{{ asset('/js/overtime.js') }}"></script> <!-- created on:160309 -->
    <script id='claim_table_template' type='text/x-jquery-tmpl'>
        <tr>
            <td>${date}</td>
            <td>${startTime}</td>
            <td>${endTime}</td>
            <td> ${totalHour}</td>
            <td> ${hourA}</td>
            <td> ${hourB}</td>
            <td> ${hourC}</td>
            <td> ${hourD}</td>
            <td> ${hourE}</td>
            <td> ${otDesc}</td>
            <td> ${totalClaim}</td>
            <td is_update="1" style="border:0px;"><a href="#" class="edit_modal">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                </a>
            </td>
        </tr>
    </script>

@endsection