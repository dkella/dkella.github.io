<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <table class="table-bordered">
        <thead 1style="text-align: center;">
        <tr>
            <td rowspan="2">KM</td>
            <td colspan="5">Kadar Tuntutan(sen/km)</td>
        </tr>
        <tr>
            <td>Kelas A</td>
            <td>Kelas B</td>
            <td>Kelas C</td>
            <td>Kelas D</td>
            <td>Kelas E</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>>=500</td>
            <?php $arrlength = count($travelConfig); ?>
            @for($x = 0; $x < $arrlength; $x++)
            <td>{!! $travelConfig[$x]-> rateA !!}</td>
            @endfor
        </tr>
        <tr>
            <td>501-1000</td>
            @for($x = 0; $x < $arrlength; $x++)
            <td>{!! $travelConfig[$x]-> rateB !!}</td>
            @endfor
        </tr>
        <tr>
            <td>1001-1700</td>
            @for($x = 0; $x < $arrlength; $x++)
            <td>{!! $travelConfig[$x]-> rateC !!}</td>
            @endfor
        </tr>
        <tr>
            <td><1700</td>
            @for($x = 0; $x < $arrlength; $x++)
            <td>{!! $travelConfig[$x]-> rateD !!}</td>
            @endfor
        </tr>
        </tbody>
    </table>
</div>