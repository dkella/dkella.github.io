@extends('cms_master')
@section('style')
.table-borderless tbody tr td, .table-borderless tbody tr th, .table-borderless thead tr th {
    border: none;
}
@endsection
@section('content')
<div class="col-lg-8 col-md-8">

    <h1>Maklumat Peribadi</h1>
    <hr>

    <table class="table table-borderless" 1border="0" 1cellpadding="2">
        <tbody>
        <tr>
            <th 1style="width:10%">Nama</th>
            <th 1style="width:1%">:</th>
            <td 1style="width:40%">{{ $personal->name}}</td>
        </tr>
        <tr>
            <th>Jawatan</th>
            <th>:</th>
            <td>{{ $personal->position}}</td>
           <!-- <td> $personal->roles->first()->role</td> -->
        </tr>
        <tr>
            <th>Jabatan</th>
            <th>:</th>
    <!--        <td>Penguatkuasaan</td>-->
            <td>{{ $personal->departments->department}}</td>
        </tr>
        <tr>

            <th>No K/P</th>
            <th>:</th>
            <td>{{ $personal->noKP}}</td>
        </tr>
        <tr>
            <th>Gaji</th>
            <th>:</th>
            <td>RM {{ $personal->salary}}</td>
        </tr>
        <tr>
            <th>Ibu Pejabat</th>
            <th>:</th>
            <td>{{ $personal->branch}}</td>
        </tr>
        <tr>
            <th>Alamat Kediaman</th>
            <th>:</th>
            <td>{{ $personal->homeAddress}}
            </td>
        </tr>
        </tbody>
    </table>
    <p class="red_text">*Sebarang penukaran, sila menghubungi Admin.</p>
</div>
<!---->
<!--<h1>Maklumat Kenderaan</h1>-->
<!---->
<!--<hr>-->
<!---->
<!--<table border="0" cellpadding="2">-->
<!--    <tbody>-->
<!--    <tr>-->
<!--        <td style="width:10%">Kenderaan</td>-->
<!--        <td style="width:1%">:</td>-->
<!--        <td style="width:40%">Perodua Kancil 660cc</td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td>Nombor</td>-->
<!--        <td>:</td>-->
<!--        <td>JFH 1681</td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td>Kelas</td>-->
<!--        <td>:</td>-->
<!--        <td>D</td>-->
<!--    </tr>-->
<!--    </tbody>-->
<!--</table>-->
@endsection