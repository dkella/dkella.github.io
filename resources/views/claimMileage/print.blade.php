@extends('print_master')


@section('content')

<form class="form-horizontal">
<fieldset>
<h4 class="text-uppercase" style="color: black; text-align: center;">Tuntutan Perjalanan Dalam Negeri bagi Bulan {{$month->name}} {{$claims->year}}</h4>

<div class="claim_form">
    <table border="0" cellpadding="2" style="font-size: 0.8em;">
        <tbody>
        <tr>
            <td style="width:17%">Nama</td>
            <td style="width:1%">:</td>
            <td style="width:28%">{{ $personal->name }}</td>
            <td style="width:10%">&nbsp;</td>
            <td style="width:15%">Ibu Pejabat</td>
            <td style="width:1%">:</td>
            <td style="width:29%">{{ $personal->branch }}</td>
        </tr>
        <tr>
            <td>Kad Pengenalan</td>
            <td>:</td>
            <td>{{ $personal->noKP }}</td>
            <td>&nbsp;</td>
            <td>Alamat Kediaman</td>
            <td>:</td>
            <td rowspan="2">{{ $personal->homeAddress }}</td>
        </tr>
        <tr>
            <td>Jawatan</td>
            <td>:</td>
            <td>{{ $personal->position }}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
<!--            <td>&nbsp;</td>-->
        </tr>
        <tr>
            <td>Kumpulan</td>
            <td>:</td>
            <td>Sokongan 2</td>
            <td>Gred</td>
            <td>Katergori</td>
            <td>:</td>
            <td>N17</td>
        </tr>
        <tr>
            <td>Gaji</td>
            <td>:</td>
            <td>RM {{  number_format($personal->salary,2,".","") }}</td>
            <td>&nbsp;</td>
            <td>Bahagian</td>
            <td>:</td>
            <td>{{ $personal->departments->department }}</td>
        </tr>
        <tr>
            <td>Elaun Memangku</td>
            <td>:</td>
            <td>RM   -   </td>
            <td>Kenderaan</td>
            <td>i. Jenis</td>
            <td>:</td>
            <td>{{ $personal->vehicles->vehicleName }} </td>
        </tr>
        <tr>
            <td>Elaun Tanggung Kerja</td>
            <td>:</td>
            <td>RM   -   </td>
            <td>&nbsp;</td>
            <td>ii. Nombor</td>
            <td>:</td>
            <td>{{ $personal->vehicles->plateNo }} </td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
                <table>
                    <tr>
                        <td style="border-top:1pt solid black;border-bottom:1pt solid black;">RM {{  number_format($personal->salary,2,".","") }}</td>
                    </tr>
                </table>
            </td>
            <td>&nbsp;</td>
            <td>iii. Kuasa</td>
            <td>:</td>
            <td>{{ $personal->vehicles->engine }}cc</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>iv. Kelas</td>
            <td>:</td>
            <td id="vehicle_class">{{ $personal->vehicles->travelconfig->vehicleClass }}</td>
        </tr>
        </tbody>
    </table>
</div>

<br>

<div class="claim_form">
    <table class="table-bordered" style="width: 100%; font-size: 0.75em;" id="claim_table" claim_id="{{ $claims->id }}">
        <thead>
        <tr>
            <td rowspan="2">TARIKH</td>
            <td colspan="2">Keluar dari <br>rumah * <br>(Tarikh/Hari)</td>
<!--            <td rowspan="2">Jam</td>-->
            <td rowspan="2">Jenis Tugasan</td>
            <td rowspan="2">Butir-butir perjalanan/ Lojing/ Harian atau elaun makan yang dituntut</td>
            <td rowspan="2">Hitung km dalam tugas</td>
            <td rowspan="2" colspan="2">Perbelanjaan sebenar yang telah dibelanjakan/ dibayar</td>
            <td rowspan="2" colspan="2">Tuntutan elaun Harian/ makan dan elaun Lojing (RM)</td>
            <!--            <td rowspan="2">RM</td>-->
        </tr>
        <tr>
            <td>Daripada/ hingga</td>
            <td>Jam</td>
        </tr>
        </thead>
        <tbody>
        @foreach($claims->travelclaim as $claim)
        <tr>
            <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$claim->date)->format('d.m.Y (l)') }}</td>
            <td>{{ date('h:i A', strtotime( $claim->startTime)) }} <br>{{ date('h:i A', strtotime( $claim->endTime)) }}</td>
<!--            <td></td>-->
            <td>{{ $claim->hour }}</td>
            <td>{{ $claim->tasks->task_name }}</td>
            <td>{{ $claim->travelDesc }}</td>
            <td>{{ $claim->mileage }}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="claim_form text-right">
    <strong>Total: <span class="red_text" id="claim_total">RM {{ number_format($claims->total,2,".","") }}</span></strong>
</div>
<br>


<!-- Try-->
<div class="claim_form">
    <table 1class="table" style="font-size: 0.6em;">
        <tbody>
        <tr>
            <td>Tempoh dan lamanya masa keluar dari Pejabat hendaklah disebutkan bagi menyokong <br>
                tuntutan elaun bermalam, elaun lojing harian, elaun makan dan sebagaimana yang <br>
                diarahkan okeh Ketua Jabatan
            </td>
            <td>Jumlah Kecil tuntutan yang dibutirkan di muka <br>
                belakang………………………………. <br>
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>A.   PENGAKUAN PEGAWAI YANG DITUNTUT</td>
            <td>Jumlah Kecil tuntutan yang dibutirkan dalam lampiran yang dikembarkan<br>
                ……………………………….
            </td>
            <td>&nbsp;</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>i. Perjalanan pada tarikh-tarikh tersebut adalah benar di atas urusan kerajaan.</td>
            <td>Jumlah hitung kilometer, Perbelanjaan dan elaun ……………………………….</td>
            <td>&nbsp;</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>ii. Tuntutan ini dibuat mengikut Pekeliling Perbensdaharaan Bil.2/92dan Peraturan Am<br>
                Bab "B"</td>
            <td>Jumlah perbelanjaan dan elaun-elaun……………….</td>
            <td>&nbsp;</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>iii. Perbelanjaan bertanda () berjumlah RM……………telah sebenarnya dilakukan dan<br>
                dibayar oleh saya sendiri tapi resit hilang</td>
            <td>Jumlah tuntutan Hitung Kilometer bagi bulan (seperti dikirakan dibawah)………………
            <td>&nbsp;</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>iv. Panggilan telefon sebanyak RM……………..adalah diatas urusan kerajaan.</td>
            <td>JUMLAH HITUNG KILOMETR, PERBELANJAAN DAN ELAUN-ELAUN YANG DITUNTUT<br>
                RM……………………………………………………………………………………………………</td>
            <td>&nbsp;</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td>v. butir-butir dalam tuntutan saya ini adalah benar  dan saya bertanggungjawab terhadapnya</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td colspan="2" style=" font-size: 1.3em; text-align: center;">Diakui tuntutan Elaun Perjalanan Bulan {{$month->name}} {{$claims->year}} belum lagi dituntut</td>
        </tr>
        </tbody>
    </table>
</div>
<!-- Try-->

<div class="claim_form">
<!--    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">-->
        <table border="0" style="font-size: 0.6em;">
            <tbody>
            <tr><td>&nbsp;</td>
                <td rowspan="11">
                    <table class="table-bordered" style="text-align: center; font-size: 1.3em;" id="calc_table">
                        <thead>
                        <tr>
                            <th rowspan="2">Hitung<br>(KM)</th>
                            <th colspan="4">Kadar Tuntutan(sen/km)</th>
                            <th rowspan="2">Motosikal ringan<br>dan m/skuter</th>
                            <th rowspan="2">Jumlah tuntutan<br>kelas** ({{ $personal->vehicles->travelconfig->vehicleClass }})</th>
                        </tr>
                        <tr>
                            <th>Kelas {{$travelConfig[0]-> vehicleClass}}</th>
                            <th>Kelas {{$travelConfig[1]-> vehicleClass}}</th>
                            <th>Kelas {{$travelConfig[2]-> vehicleClass}}</th>
                            <th>Kelas {{$travelConfig[3]-> vehicleClass}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>0</td>
                            @for ($x=0;$x<sizeof($travelConfig);$x++)
                            <td>{{ $travelConfig[$x]->rateA }}</td>
                            @endfor
                            <td>0.00</td>
                        </tr>
                        <tr>
                            <td>0</td>
                            @for ($x=0;$x<sizeof($travelConfig);$x++)
                            <td>{{ $travelConfig[$x]->rateB }}</td>
                            @endfor
                            <td>0.00</td>
                        </tr>
                        <tr>
                            <td>0</td>
                            @for ($x=0;$x<sizeof($travelConfig);$x++)
                            <td>{{ $travelConfig[$x]->rateC }}</td>
                            @endfor
                            <td>0.00</td>
                        </tr>
                        <tr>
                            <td>0</td>
                            @for ($x=0;$x<sizeof($travelConfig);$x++)
                            <td>{{ $travelConfig[$x]->rateD }}</td>
                            @endfor
                            <td>0.00</td>
                        </tr>
                        <tr>
                            <td class="boldText">&nbsp;</td>
                            <td class="boldText">Jumlah<br>(km)</td>
                            <td class="boldText">&nbsp;</td>
                            <td class="boldText">Tuntutan<br>(RM)</td>
                            <td class="boldText">{{ number_format($claims->total,2,".","") }}</td>
                            <td class="boldText">&nbsp;</td>
                            <td class="boldText">&nbsp;</td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Tandatangan:…………………………………………Tarikh:…………………………………</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><th>B.PENGAKUAN KETUA ATAU SEEPERTI YANG DIWAKILKAN</th></tr>
            <tr><td>Disahkan bahawa pegawai ini telah berada di tempat-tempat yang dinyatakan di dalam<br>
                    borang tuntutan ini pada tarikh-tarikh yang dicatatkan atas urusan rasmi dan boleh dibayar<br>
                    menurut Arahan Perbendaharaan, Peerintah Am dan Pekeliling Kerajaan
                </td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Tandatangan:…………………………………………Tarikh:…………………………………</td></tr>
            <tr><td>Nama Pegawai:</td></tr>
            </tbody>
        </table>
<!--    </div>-->


</div>


</fieldset>
</form>

@endsection

@section('js_script_ready')
    calcMileage();
@endsection

@section('js_script')
    function calcMileage()
    {
        var _km=0;
        $('#claim_table > tbody > tr').each(function(){
            var _row = $(this);
            _km+=parseInt(_row.children().eq(5).text());
        });
        <!--alert(_km);-->
<!--        testing-->
        var _tbody = $("#calc_table >tbody");
        var _row1 = _tbody.children().eq(0);
        var _row2 = _tbody.children().eq(1);
        var _row3 = _tbody.children().eq(2);
        var _row4 = _tbody.children().eq(3);
        var total=0.00;
<!--        rate-->
        var _vehicle_class = $('#vehicle_class').text();
        var _col;

        switch (_vehicle_class) {
            case "A":
                _col=1;
                break;
            case "B":
                _col=2;
                break;
            case "C":
                _col=3;
                break;
            case "D":
                _col=4;
                break;
            case "E":
                _col=5;
                break;
        }
        var rateA=parseFloat(_row1.children().eq(_col).text())/100;
        var rateB=parseFloat(_row2.children().eq(_col).text())/100;
        var rateC=parseFloat(_row3.children().eq(_col).text())/100;
        var rateD=parseFloat(_row4.children().eq(_col).text())/100;
<!--alert(_row1.children().eq(_col).text());-->
<!--        //    > 1700-->
        if(_km > 1700)
        {
            total = (500 * rateA) + (500 * rateB) + (700 * rateC) + ((_km-1700) * rateD);
            _row1.children().eq(0).text(500);
            _row2.children().eq(0).text(500);
            _row3.children().eq(0).text(700);
            _row4.children().eq(0).text(_km-1700);

            _row1.children().eq(6).text((500 * rateA).toFixed(2));
            _row2.children().eq(6).text((500 * rateB).toFixed(2));
            _row3.children().eq(6).text((700 * rateC).toFixed(2));
            _row4.children().eq(6).text(((_km-1700) * rateD).toFixed(2));
        }
<!--        //    1001-1700-->
        else if(_km > 1000)
        {
            total = (500 * rateA) + (500 * rateB) + ((_km-1000) * rateC);
            _row1.children().eq(0).text(500);
            _row2.children().eq(0).text(500);
            _row3.children().eq(0).text(_km-1000);

            _row1.children().eq(6).text((500 * rateA).toFixed(2));
            _row2.children().eq(6).text((500 * rateB).toFixed(2));
            _row3.children().eq(6).text(((_km-1000) * rateC).toFixed(2));
        }
<!--        //    501-1000-->
        else if(_km > 500)
        {
            total = (500 * rateA) + ((_km-500) * rateB);
            _row1.children().eq(0).text(500);
            _row2.children().eq(0).text(_km-500);

            _row1.children().eq(6).text((500 * rateA).toFixed(2));
            _row2.children().eq(6).text(((_km-500) * rateB).toFixed(2));
        }
<!--        //    0-500-->
        else
        {
            total = _km * rateA;
            _row1.children().eq(0).text(_km);
            _row1.children().eq(6).text(total.toFixed(2));
        }

        total = total.toFixed(2);
        $("#calc_table >tbody >tr").last().children().eq(2).text(_km);
        $("#calc_table >tbody >tr").last().children().eq(6).text(total);
    }

@endsection
