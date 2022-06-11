$(document).ready(function(){
    $('#start_time').timepicker({
        showPeriod: true,
        showLeadingZero: true
    });

    $('#end_time').timepicker({
        showPeriod: true,
        showLeadingZero: true
    });

    $('#btn_cancel').click(function(){
        var url = APP_URL+"/claimMileage";
        window.location.href= url;
//        window.print();
//        $('#test_print').print();
    });

    //<!--         first time set data for each row-->
    $('#claim_table > tbody > tr').each(function(){
        var _row=$(this);
//        alert(_row.text());
        var obj = new Object();
        obj.date=_row.children().eq(0).text();
        obj.startTime=_row.children().eq(1).text();
        obj.endTime=_row.children().eq(2).text();
        obj.hour=parseInt(_row.children().eq(3).text());
        obj.task_id=parseInt(_row.children().eq(4).attr('task_id'));
        obj.travelDesc=_row.children().eq(5).text();
        obj.mileage=_row.children().eq(6).text();

        obj.id =_row.attr('claim_id');
        _row.removeAttr('claim_id');
//        obj.totalClaim=parseFloat(_row.children().eq(6).text());
//        console.error(obj);
        _row.data('object',obj);   <!-- add obj to tr :) -->

//        var obj2=_row.data('object');
//        alert(obj2.id);
//        console.error(obj2);
    });

    //<!--        Show modal for adding record-->
    $('#add_record').on("click",function () {
        $('.modal-title').text("Tambah Rekod");
        $('#add_update').text("Tambah");
        $('#delete').hide();
        $('#modal_form')[0].reset();

        $('#myModal').modal('show');
    });

    //only allow numeric data with decimal point
    $("#mileage").on("keypress",function (event) {
        //this.value = this.value.replace(/[^0-9\.]/g,'');
        $(this).val($(this).val().replace(/[^0-9\.]/g,''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            //display error message
            $("#mileageErrMsg").html("Sila masukkan nombor sahaja").show().fadeOut("slow");
            return false;
//            event.preventDefault(); //use this or return false
        }
    });


    //<!--    when modal's add/update button is click-->
    $("#add_update").on("click", function(){
        var body=$(this).parent().siblings('.modal-body');
        var obj=new Object();

//        var d = new Date(body.find('#date').val());
        obj.date=body.find('#date').val();
        obj.startTime=body.find('#start_time').val();
        obj.endTime=body.find('#end_time').val();

//        obj.mileage=parseFloat(body.find('#mileage').val());
        obj.mileage=body.find('#mileage').val();
        obj.task_id = body.find('#task_id').val();
        obj.task_name = body.find('#task_id option:selected').text();
        obj.travelDesc=body.find('#desc').val();

//        obj.totalClaim=calcTotalClaim(obj);

        if(obj.date=="")
        {
            $('#errMsg').html("Sila pilih tarikh");
            $('#errMsg').show();
            $('#date').focus();
            return;
        }
        if(obj.startTime=="")
        {
            $('#errMsg').html("Sila pilih masa mula");
            $('#errMsg').show();
            $('#start_time').focus();
            return;
        }
        if(obj.endTime=="")
        {
            $('#errMsg').html("Sila pilih masa tamat");
            $('#errMsg').show();
            $('#end_time').focus();
            return;
        }

        obj.hour = calcTotalHour();
        if(obj.hour%1!=0)
        {
            var temp = obj.hour.toString().split(".");
            if(temp[1].length>2)
            {
                obj.hour = obj.hour.toFixed(2);
            }
        }

        if(obj.mileage=="")
        {
            $('#errMsg').html("Sila isi jumlah perjalanan");
            $('#errMsg').show();
            $('#mileage').focus();
            return;
        }
        obj.mileage=parseFloat(obj.mileage);
        if(obj.task_id=="")     //this never run
        {
            $('#errMsg').html("Sila pilih jenis tugas");
            $('#errMsg').show();
            $('#task_id').focus();
            return;
        }
        if(obj.travelDesc=="")
        {
            $('#errMsg').html("Sila isi kenyataan");
            $('#errMsg').show();
            $('#desc').focus();
            return;
        }


        console.log(obj);

        if($('#add_update').text()=="Tambah")
        {
            $('#claim_table_template').tmpl(obj).appendTo('#claim_table');
            $('#claim_table > tbody tr:last').data('object',obj);   //<!-- add obj to tr :) -->
        }
        else
        {
            var row_index= $('#myModal').attr('row_index');
            var _row=$('#claim_table > tbody').find( "tr:eq("+row_index+")");

            var _row_obj=_row.data("object");
            obj.id = _row_obj.id;

            _row.replaceWith($('#claim_table_template').tmpl(obj)); //<!-- _row.index() will become -1 -->
            //        <!--                Hence, cannot use _row anymore-->
            $('#claim_table > tbody').find( "tr:eq("+row_index+")").data('object',obj);   //<!-- add obj to tr :) -->


        }

        refreshClaimTotal();

        $('#myModal').modal("hide");
        $('#errMsg').hide();
    });

    //<!--        Save claims to DB-->
    $('#btn_save').click(function(){
//        event.preventDefault(); //prevent redirect/page refresh  //
//        $(this).button('loading');
        var _this = $(this);
        var claim_status=1; //1-draft,2-submitted,3-approved, 4-rejected
        updateTravelClaim(claim_status,_this);

    });

    //<!--        Submit claims to SV and DB-->
    $('#btn_submit').click(function(){
//        $(this).button('loading');
        var _this = $(this);
        var claim_status=2; //1-draft,2-submitted,3-approved, 4-rejected
        updateTravelClaim(claim_status,_this);

    });

    //<!--        Update claims to SV and DB-->
    $('#btn_correction').click(function(){
        $(this).button('loading');

        var claim_status=$('#claim_table').attr('claim_status'); //1-draft,2-submitted,3-approved, 4-rejected,
        // 5-verified, 6-pending, 7-Financial reject, 8-Financial Pending
//        updateOTClaim(claim_status);

        var url = APP_URL+"/claimMileage/correction";

        var arr_claim = [];
//        Get All data from table and save as Array of Object
        $('#claim_table > tbody > tr').each(function(){
            var _row=$(this);

            var _editTD = _row.children().eq(7);

            var attr = _editTD.attr("is_update");
// For some browsers, `attr` is undefined; for others, `attr` is false. Check for both.
            if (typeof attr !== typeof undefined && attr !== false)
            {   // Element has this attribute

                var obj=_row.data("object");

                var _startHour = change12Hto24H(obj.startTime);
                var _endHour = change12Hto24H(obj.endTime);
                var _startMins = parseFloat(obj.startTime.substring(3,5));
                var _endMins = parseFloat(obj.endTime.substring(3,5));

                //24H start and end time
                obj.startTime = _startHour.toString()+":"+_startMins.toString();
                obj.endTime = _endHour.toString()+":"+_endMins.toString();

                arr_claim.push(obj);

            }
        });

        var inputData = JSON.stringify(arr_claim);

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn_correction').val();

        var type = "PUT"; //for creating new resource
        var claim_id = $('#claim_table').attr('claim_id');
        var my_url = url;

        console.log(inputData);
//        return;
        if (state == "update")
        {
            var objClaim = new Object();
            objClaim.claim_id=claim_id;
            objClaim.claim_status=claim_status;
            objClaim.claim_total=$('#claim_total').text().substring(3);
            //claim_id,claim_status and claim_total
            updateClaim(objClaim);
        }
        my_url += '/' + claim_id;
//alert(my_url);
        $.ajax({

            type: type,
            url: my_url,
            data: inputData,
//            dataType: 'json',
            contentType: 'json',  //for array of jason
            processData: false, //for array of jason
            async: false,  //wait this done runs
            success: function (data) {
                console.log('Success:',data);
                window.location.href= APP_URL+"/claimMileage";

            },
            error: function (data) {
                console.log('Error:', data);

                $('body').html(data.responseText);  //easier to debug
            }
        });

    });//#btn_correction


}); //end  document ready


//<!--    There will be new tr created, hence cannot put inside document.ready-->
//$(document).on('click','#claim_table > tbody > tr',function () {
//    var _row = $(this);
$(document).on('click','.edit_modal',function () {
//                 a    td          tr
    var _row = $(this).parent().parent();
    var row_index = _row.index();
    $('#myModal').attr('row_index',row_index);

//    <!--        reset modal and put table row value to it-->
    $('#modal_form')[0].reset();

    var obj=_row.data('object');

    $('#date').val(obj.date);
    $('#start_time').val(obj.startTime);
    $('#end_time').val(obj.endTime);
    $('#task_id').val(obj.task_id);
    $('#mileage').val(obj.mileage);
    $('#desc').val(obj.travelDesc);


    //new add
    var attr = $(this).attr("claim_status");
    var rejectReason = "";
// For some browsers, `attr` is undefined; for others, `attr` is false. Check for both.
    if (typeof attr !== typeof undefined && attr !== false) {
        // Element has this attribute
        if(attr==4) //4-reject
        {
            rejectReason = _row.attr("rejectReason");
            $('#rejectReason_id').html("<strong>Sebab penolakan:  </strong>"+rejectReason);
            $('#rejectReason_id').show();
        }
        else if(attr==2)    //2- fm_reject
        {
            rejectReason = _row.attr("fm_rejectReason");
            $('#rejectReason_id').html("<strong>Sebab penolakan:  </strong>"+rejectReason);
            $('#rejectReason_id').show();
        }
    }

    $('.modal-title').text("Kemaskini Rekod");
    $('#add_update').text("Kemaskini");
    $('#delete').show();

    $('#myModal').modal('show');
});
//end click on tr

//Delete record
$(document).on('click','#delete',function () {
    var row_index= $('#myModal').attr('row_index');
    var _row=$('#claim_table > tbody').find( "tr:eq("+row_index+")");
    _row.remove();
    refreshClaimTotal();
});

function calcTotalHour() {
    var _startTime = $('#start_time').val();
    var _endTime = $('#end_time').val();
    var _startMins = parseFloat(_startTime.substring(3,5));
    var _endMins = parseFloat(_endTime.substring(3,5));

//    alert(_startTime.substring(6,8));

    var _startHour = change12Hto24H(_startTime);
    var _endHour = change12Hto24H(_endTime);

    var _totalHour = _endHour - _startHour;
    if(_totalHour<0)
    {
        _totalHour+=24;
    }
    var _totalMinute = _endMins - _startMins;
    if(_totalMinute<0)
    {
        _totalHour-=1;
        _totalMinute+=60;
    }
    var _floatHour = _totalHour + (_totalMinute/60) ;
    console.log(_totalHour +" hours "+_totalMinute + "mins == "+ _floatHour + "hour");

    return _floatHour;
}

function calcTotalClaim(_km)
{
    var _vehicle_class = $('#vehicle_class').text();
    var _row;
    $('#table_travelConfig > tbody >tr >th').each(function(){
        if($(this).text()==_vehicle_class)
        {
            //     th       tr
            _row=$(this).parent();
        }
//        var _row=$(this);
//        var _class= _row.find('th').text();
//        alert(_class);
    });
    var rateA=parseFloat(_row.find('td:eq(0)').text());
    var rateB=parseFloat(_row.find('td:eq(1)').text());
    var rateC=parseFloat(_row.find('td:eq(2)').text());
    var rateD=parseFloat(_row.find('td:eq(3)').text());

//    var _km=obj.mileage;
    var total=0.00;

//    > 1700
    if(_km > 1700)
    {
        total = (500 * rateA) + (500 * rateB) + (700 * rateC) + ((_km-1700) * rateD);
    }
//    1001-1700
    else if(_km > 1000)
    {
        total = (500 * rateA) + (500 * rateB) + ((_km-1000) * rateC);
    }
//    501-1000
    else if(_km > 500)
    {
        total = (500 * rateA) + ((_km-500) * rateB);
    }
//    0-500
    else
    {
        total = _km * rateA;
    }
    total/=100;
    total = total.toFixed(2);

    return total;
}

function refreshClaimTotal()
{
    var total_mileage=0;
    $('#claim_table > tbody > tr td:nth-child(7)').each(function(){
        var sub_total=$(this).text();
        total_mileage+=parseFloat(sub_total);
    });

    var mileage = total_mileage.toFixed(2);
    var total= calcTotalClaim(mileage);

    $('#claim_total').text("RM "+total);

}

function updateTravelClaim(claim_status,_this)
{
    var url = APP_URL+"/claimMileage";

    var arr_claim = [];
//        Get All data from table and save as Array of Object
    $('#claim_table > tbody > tr').each(function(){
        var _row=$(this);
        var obj=_row.data("object");


        var _startHour = change12Hto24H(obj.startTime);
        var _endHour = change12Hto24H(obj.endTime);
        var _startMins = parseFloat(obj.startTime.substring(3,5));
        var _endMins = parseFloat(obj.endTime.substring(3,5));

        //24H start and end time
        obj.startTime = _startHour.toString()+":"+_startMins.toString();
        obj.endTime = _endHour.toString()+":"+_endMins.toString();

        arr_claim.push(obj);
    });

    if(arr_claim.length==0)
    {
        alert("Tiada rekod! sila klik butang \"Tambah\" untuk masukkan rekod");
        return;
    }
    _this.button('loading');

    var inputData = JSON.stringify(arr_claim);

    //used to determine the http verb to use [add=POST], [update=PUT]
    var state = $('#btn_save').val();
//    var type = "POST"; //for creating new resource
//    var claim_id = $('#claim_table').attr('claim_id');
//    var my_url = url;
//
//    if (state == "update"){
//        type = "PUT"; //for updating existing resource
//        my_url += '/' + claim_id;
//    }

    var type = "PUT"; //for creating new resource
    var claim_id = $('#claim_table').attr('claim_id');
    var my_url = url;

    console.log(inputData);

//Create new claim
    if (state == "add")
    {
        var c_date = new Date();  //Current Date
        var c_month = c_date.getMonth()+1;
        var c_year = c_date.getFullYear();

        var objClaim = new Object();
        objClaim.type=2;  //1-overtime 2-travel
        objClaim.status=claim_status;  //1-draft 2-submitted 3-approved 4-pending 5-rejected
        objClaim.month=c_month;
        objClaim.year=c_year;
        objClaim.total=$('#claim_total').text().substring(3);

        claim_id = createClaim(objClaim);
        //return claim_id here
    }
//Update new claim
    else if (state == "update")
    {
        var objClaim = new Object();
        objClaim.claim_id=claim_id;
        objClaim.claim_status=claim_status;
        objClaim.claim_total=$('#claim_total').text().substring(3);
        //claim_id,claim_status and claim_total
        updateClaim(objClaim);
    }
    my_url += '/' + claim_id;
//alert(my_url);
    $.ajax({

        type: type,
        url: my_url,
        data: inputData,
//            dataType: 'json',
        contentType: 'json',  //for array of jason
        processData: false, //for array of jason
        async: false,  //wait this done runs
        success: function (data) {
            console.log('Success:',data);
            window.location.href= url;

        },
        error: function (data) {
            console.log('Error:', data);

            $('body').html(data.responseText);  //easier to debug
        }
    });
}

//return new created claim_id
function createClaim(objClaim) //claim_type, claim_status, claim_month, claim_year and claim_total
{
    var url = APP_URL+"/claimMileage/create";
    var inputData = JSON.stringify(objClaim);
    var type = "POST"; //for create new record

    var claim_id;
    console.error(inputData);
    $.ajax({

        type: type,
        url: url,
        data: inputData,
        dataType: 'json',
        async: false,  //wait this done runs
        success: function (data) {
            console.log('Success:',data);
            claim_id = data.last_insert_id;
//            alert(claim_id);
        },
        error: function (data) {
            console.log('Error:', data);

            $('body').html(data.responseText);  //easier to debug
        }
    });

    return claim_id;
}


function updateClaim(objClaim)  //claim_id,claim_status and claim_total
{
    var url = APP_URL+"/claim/"+objClaim.claim_id;
    var inputData = JSON.stringify(objClaim);
    var type = "PUT"; //for update
    console.error(inputData);
    $.ajax({

        type: type,
        url: url,
        data: inputData,
        dataType: 'json',
//        contentType: 'json',  //for array of jason
//        processData: false, //for array of jason
        async: false,  //wait this done runs
        success: function (data) {
            console.log('Sucess:',data);

        },
        error: function (data) {
            console.log('Error:', data);

            $('body').html(data.responseText);  //easier to debug
        }
    });
}