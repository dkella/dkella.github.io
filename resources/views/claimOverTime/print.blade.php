@extends('print_master')
@section('style')
    .fraction {
        text-align : center;
        border-collapse : collapse;
    }
@endsection
@section('content')

<form class="form-horizontal">
    <fieldset>
        <h4 class="text-uppercase" style="color: black; text-align: center; font-size: 0.9em;">BAHAGIAN PENGUATKUASAAN</h4>
        <h4 class="text-uppercase" style="color: black; text-align: center; font-size: 0.9em;">MAJLIS BANDARAYA JOHOR BAHRU</h4>
        <h4 class="text-uppercase" style="color: black; text-align: center; font-size: 0.75em;">Tuntutan Kerja Lebih Masa bagi Bulan {{$month->name}} {{$claims->year}}</h4>

        <div class="claim_form">
            <table border="0" cellpadding="2" style="width: 100%; font-size: 0.75em;">
                <tbody>
                <tr>
                    <td style="width:10%">NAMA</td>
                    <td style="width:1%">:</td>
                    <td style="width:32%">{{ $personal->name }}</td>
                    <td style="width:12%">NO K/P</td>
                    <td style="width:1%">:</td>
                    <td style="width:28%">{{ $personal->noKP }}</td>
                    <td style="width:16%" rowspan="3"><img src="{{ asset('/img/MBJB.png') }}" width="70px;"></td>
                </tr>
                <tr>
                    <td>JAWATAN</td>
                    <td>:</td>
                    <td>{{ $personal->position }}</td>
                    <td>NO K'PUTER</td>
                    <td>:</td>
                    <td>P1234</td>
                </tr>
                <tr>
                    <td>JABATAN</td>
                    <td>:</td>
                    <td>{{ $personal->departments->department }}</td>
                    <td>GAJI</td>
                    <td>:</td>
                    <td id="salary">RM {{  number_format($personal->salary,2,".","") }}</td>

                </tr>
                </tbody>
            </table>
        </div>

        <br>

        <div class="claim_form">
            <table border="1" cellpadding="2" style="width: 100%; font-size: 0.75em; text-align: center;" id="claim_table" claim_id="{{ $claims->id }}">
                <thead>
                <tr style="background-color: #d3d3d3;">
                    <th rowspan="2">TARIKH</th>
                    <th colspan="2">MASA BERTUGAS</th>
                    <th rowspan="2">JAM</th>
                    <th colspan="5">JUMLAH K.L.M</th>
                    <th rowspan="2">KENYATAAN</th>
                </tr>
                <tr style="background-color: #d3d3d3;">
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
                <tr>
                    <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$claim->date)->format('Y-m-d') }}</td>
                    <td>{{ date('h:i A', strtotime( $claim->startTime)) }}</td>
                    <td>{{ date('h:i A', strtotime( $claim->endTime)) }}</td>
                    <td>{{ $claim->totalHour }}</td>
                    <td>{{ $claim->hourA }}</td>
                    <td>{{ $claim->hourB }}</td>
                    <td>{{ $claim->hourC }}</td>
                    <td>{{ $claim->hourD }}</td>
                    <td>{{ $claim->hourE }}</td>
                    <td style="text-align: left;">{{ $claim->otDesc }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <br>
        <div class="claim_form22">
            <table style="width:90%; font-size: 0.75em;" border="0" cellpadding="2" id="claim_count">
                <tbody>
                @foreach($otConfig as $x)
                    <tr>
                        <td>{{ $x->typeOT }}</td>
                        <td>{{ $x->description }}:</td>
                        <td>RM</td>
                        <td>
                            <table class="fraction" style="width:90%;" salary="{{ $personal->salary }}" rate="{{ $x->rate }}">
                                <tbody>
                                    <tr style="border-bottom:1pt solid black;">
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>2504</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td>=</td>
                        <td>RM</td>
                        <td style="text-align: right;" salary="{{ $personal->salary }}" rate="{{ $x->rate }}"></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
<!--        verification-->
        <br>
        <div class="claim_form22">
            <table style="font-size: 0.75em;" border="0" cellpadding="2">
                <tbody>
                <tr>
                    <td>1)</td>
                    <td colspan="3"><u>Pengakuan Yang Menuntut</u></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td rowspan="2">
                        <table>
                            <tbody>
                                <tr style="border-bottom:1pt solid black;"><td>1</td></tr>
                                <tr><td>3</td></tr>
                            </tbody>
                        </table>
                    </td>
                    <td rowspan="2">x</td>
                    <td rowspan="2">{{  number_format($personal->salary,2,".","") }}</td>
                    <td rowspan="2">=</td>
                    <td rowspan="2">{{ number_format($personal->salary/3,2,".","") }}</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="8">Dengan ini saya mengaku bahawa saya telah menjalankan tugas dengan membuat kerja lebih masa</td>
<!--                    <td>&nbsp;</td>-->
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="8">sebagaimana yang dinyatakan di atas</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>=</td>
                    <td>{{ number_format((($personal->salary/3)-$claims->total),2,".","") }}</td>
                </tr>
                <tr>
                    <td colspan="10">&nbsp;</td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td>TARIKH</td>
                    <td>:</td>
                    <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
                    <td>&nbsp;</td>
                    <td>TANDATANGAN</td>
                    <td>:</td>
                    <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>2)</td>
                    <td colspan="3"><u>Pengakuan Pegawai Penjaga</u></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="8">Dengan ini saya mengaku bahawa tuntutan kerja lebih masa yang dibuat oleh penuntut adalah perlu untuk</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="8">menjalankan tugas-tugas rasmi</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="10">&nbsp;</td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td>TARIKH</td>
                    <td>:</td>
                    <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
                    <td>&nbsp;</td>
                    <td>TANDATANGAN</td>
                    <td>:</td>
                    <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td>3)</td>
                    <td colspan="3"><u>Pengakuan Ketua Jabatan</u></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="8">Disahkan boleh dibayar menurut Arahan Perbendaharaan, Perintah Am dari Pekeliling Kerajaan</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="10">&nbsp;</td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td>TARIKH</td>
                    <td>:</td>
                    <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
                    <td>&nbsp;</td>
                    <td>TANDATANGAN</td>
                    <td>:</td>
                    <td><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </div>

    </fieldset>
</form>


@endsection

@section('js_script_ready')
    getTotalHour();
    getClaimTotal();

<!--    var _tbody = $('#claim_count > tbody');-->
<!--    _tbody.append('<tr><td>1)</td>'-->
<!--                    +'<td style="border-bottom:1pt solid black;" colspan="2">Pengakuan Yang Menuntut</td>'-->
<!--                +'</tr>'-->
<!--                +'<tr><td>&nbsp;</td>'-->
<!--                    +'<td>Dengan ini saya mengaku bahawa saya telah menjalankan tugas dengan membuat kerja lebih masa </td>'-->
<!--                +'</tr><tr></tr><tr></tr>'-->
<!--                +'<tr><td>&nbsp;</td>'-->
<!--                    +'<td>TARIKH</td>'-->
<!--                    +'<td>:</td>'-->
<!--                    +'<td style="border-bottom:1pt solid black;">&nbsp;</td>'-->
<!--                +'</tr>');-->

@endsection

@section('js_script')
    function getTotalHour()
    {
        var _tbody = $('#claim_table').find('tbody');
        var _totalHour = 0;
        var _totalHourA = 0;
        var _totalHourB = 0;
        var _totalHourC = 0;
        var _totalHourD = 0;
        var _totalHourE = 0;
        $('#claim_table > tbody > tr').each(function(){
            var _row = $(this);
            _totalHour += parseFloat(_row.children().eq(3).text());
            _totalHourA += parseFloat(_row.children().eq(4).text());
            _totalHourB += parseFloat(_row.children().eq(5).text());
            _totalHourC += parseFloat(_row.children().eq(6).text());
            _totalHourD += parseFloat(_row.children().eq(7).text());
            _totalHourE += parseFloat(_row.children().eq(8).text());
        });

        _tbody.append("<tr>"
            +"<td colspan='3'>JUMLAH</td>"
            +"<td>"+_totalHour+"</td>"
            +"<td>"+_totalHourA+"</td>"
            +"<td>"+_totalHourB+"</td>"
            +"<td>"+_totalHourC+"</td>"
            +"<td>"+_totalHourD+"</td>"
            +"<td>"+_totalHourE+"</td>"
            +"<td>&nbsp;</td>"
            +"</tr>"
        );
    }
    function getClaimTotal()
    {
        var lastTR = $('#claim_table > tbody > tr').last();
        var totalHour = [];
        totalHour.push(parseFloat(lastTR.children().eq(2).text()));  //hourA
        totalHour.push(parseFloat(lastTR.children().eq(3).text()));  //hourB
        totalHour.push(parseFloat(lastTR.children().eq(4).text()));  //hourC
        totalHour.push(parseFloat(lastTR.children().eq(5).text()));  //hourD
        totalHour.push(parseFloat(lastTR.children().eq(6).text()));  //hourE
<!--        alert(totalHour[2]);-->

        var count = 0;
        $('#claim_count > tbody > tr').each(function(){
            var _row = $(this);
            var _equationTable = _row.children().eq(3).find('table');
            var salary = _equationTable.attr("salary");
            var rate = _equationTable.attr("rate");
            var _col = _equationTable.find('tbody >tr').first().find('td').first();

            var _text = salary + " X 12 X " + totalHour[count] + " X " + rate;

            _col.text(_text);

            count++;
        });
<!--        calcualation-->
        count = 0;
        $('#claim_count > tbody > tr').each(function(){
            var _row = $(this);
            var _col = _row.children().eq(6);
            var salary = _col.attr("salary");
            var rate = _col.attr("rate");

            var _text = (salary*12*totalHour[count]*rate)/2504;
            _text = _text.toFixed(2);
            _col.text(_text);

            count++;
        });

<!--        get total-->
        var _tbody = $('#claim_count > tbody');
        var _totalClaim = 0;
        $('#claim_count > tbody > tr').each(function(){
            var _row = $(this);
            _totalClaim += parseFloat(_row.children().eq(6).text());
        });
        _totalClaim=_totalClaim.toFixed(2);

        _tbody.append("<tr>"
            +"<td colspan='2'>RINGGIT MALAYSIA</td>"
            +"<td colspan='2'>&nbsp;</td>"
            +"<td>JUMLAH</td>"
            +"<td>RM</td>"
            +"<td style='border-top:1pt solid black; border-bottom:1pt solid black; text-align: right;'>"+_totalClaim+"</td>"
            +"</tr>"
        );
    }
@endsection
