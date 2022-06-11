@extends('cms_master')

@section('style')
@endsection

@section('content')

    <div class="row">
        <div class="col-lg-11 col-md-11 col-sm-11">
            <h1>Tuntutan Kerja Lebih Masa</h1>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1" style="vertical-align: bottom;">
            <button onclick="window.location='{{ url('/claimOvertime/create')}}';">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            </button>
        </div>
    </div>

    <hr>
    @if (!empty($claims[0]))
        <!--if there is return claims-->
        <table class="table table-striped table-hover" style="font-size: 0.9em;">
            <thead>
            <tr>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Jumlah (RM)</th>
                <th>Status</th>
<!--                <th>Kemaskini</th>-->
<!--                <th>Print</th>-->
<!--                <th>Buang</th>-->
            </tr>
            </thead>
            <tbody>
            @foreach ($claims as $claim)
                <tr>
                    @foreach ($month as $m)
                        @if($m->code==$claim->month)
                            <td>{{ $m->name}}</td>
                        @endif
                    @endforeach
                    <td>{{ $claim->year}}</td>
                    <td>{{  number_format($claim->total,2,".","") }}</td>
                    @foreach ($status as $s)
                        @if($s->code==$claim->status)
                        <td>{{ $s->name}}</td>
                        @endif
                    @endforeach
<!--                                1-draft             4- sv reject        7- fm reject-->
                    @if($claim->status==1)
                    <td><a href="{{ url('/claimOvertime',$claim->id)}}">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    </a></td>
<!--                                4- sv reject    6-pending-->
                    @elseif($claim->status==4 || $claim->status==6)
                    <td><a href="{{ url('/claimOvertime/correction',$claim->id)}}">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    </a></td>
<!--                                7- fm reject    8-fm pending-->
                    @elseif($claim->status==7 || $claim->status==8)
                    <td><a href="{{ url('/claimOvertime/correction',$claim->id)}}">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    </a></td>
                    @else
                    <td>&nbsp;</td>
                    @endif
                    <td><a href="{{ url('/claimOvertime/print',$claim->id)}}" class="print_claim">
                            <span class="glyphicon glyphicon-print" aria-hidden="true"></span>
                        </a></td>
<!--                                1-draft             4- sv reject        7- fm reject-->
                    @if($claim->status==1)
                    <td><a href="{{ url('/claimOvertime/delete',$claim->id)}}" class="delete_record">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        </a></td>
                    @else
                    <td>&nbsp;</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <p>Tiada rekod.<a href="{{ url('/claimOvertime/create')}}">Tambah rekod</a> </p>
    @endif



@endsection
@section('js_script_ready')
<!--    $('#btn_new').click(function(){-->
<!--        var url = APP_URL+ '/claimOvertime/create';-->
<!--        location.href =url;-->
<!--    });-->

<!--    $('.print_claim').on('click', function(e){-->
<!--        e.preventDefault();-->
<!--        var _url = $(this).attr('href')-->
<!--        var _print_window = window.open(_url, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=700, height=700");-->
<!--        _print_window.print();-->
<!--    });-->

    $('.delete_record').on('click', function(e){
        e.preventDefault();
        var my_url = $(this).attr('href');
        <!--    alert(my_url);-->
        //                     TD        TR
        var parentTR = $(this).parent().parent();
        <!--    alert(parentTR.html());-->
        <!--    var answer = confirm("Are you sure you want to delete the record?")-->
        var answer = confirm("Adakah anda pasti untuk buang rekod tersebut?")

        if (answer) {
            $(parentTR).fadeOut("slow", "swing"); //.remove();

            $.ajax({
                type: "GET",
                url: my_url,
                dataType: "json",
                success: function(data){
                    console.log(data);
                },
                error: function() {
                    console.error("An error occurred while processing JSON file.");
                }
            });

        }
    });

@endsection

@section('footer')
@endsection