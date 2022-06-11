$(document).ready(function(){
    //<!--    $("#date").datepicker();-->
//    $("#start_time").timepicker({'timeFormat': 'h:iA'});
//    $("#end_time").timepicker({'timeFormat': 'h:iA'});

    $('#start_time').timepicker({
        showPeriod: true,
        showLeadingZero: true
    });

    $('#end_time').timepicker({
        showPeriod: true,
        showLeadingZero: true
    });
    $('#btn_cancel').click(function(){
        var url = APP_URL+"/claimOvertime";
        window.location.href= url;
    });
    //<!--         first time set data for each row-->
    $('#claim_table > tbody > tr').each(function(){
        var _row=$(this);
        var obj = new Object();
        obj.date=_row.children().eq(0).text();
        obj.startTime=_row.children().eq(1).text();
        obj.endTime=_row.children().eq(2).text();
        obj.totalHour=parseInt(_row.children().eq(3).text());
        obj.hourA=parseFloat(_row.children().eq(4).text());
        obj.hourB=parseFloat(_row.children().eq(5).text());
        obj.hourC=parseFloat(_row.children().eq(6).text());
        obj.hourD=parseFloat(_row.children().eq(7).text());
        obj.hourE=parseFloat(_row.children().eq(8).text());
        obj.otDesc=_row.children().eq(9).text();
        obj.totalClaim=parseFloat(_row.children().eq(10).text());
        obj.isHoliday=_row.attr('isHoliday');
        _row.removeAttr('isHoliday');
//        obj.id =_row.children().eq(11).attr('claim_id_for_update');
        obj.id =_row.attr('claim_id');
        _row.removeAttr('claim_id');
    //    <!--                obj.total=$('#claim_total').text().substring(3);-->
        _row.data('object',obj);   <!-- add obj to tr :) -->
    });

    //<!--    when modal's add/update button is click-->
    $("#add_update").on("click", function(){
        inputValidation();
        if($('#errorMsg').html()=='')
        {
            var body=$(this).parent().siblings('.modal-body');
            var obj=new Object();

    //        var d = new Date(body.find('#date').val());
            obj.date=body.find('#date').val();
            obj.startTime=body.find('#start_time').val();
            obj.endTime=body.find('#end_time').val();

            obj.hourA=0;
            obj.hourB=0;
            obj.hourC=0;
            obj.hourD=0;
            obj.hourE=0;
//            obj.totalHour = calcTotalHour();

            obj.otDesc=body.find('#desc').val();
            obj.salary= parseFloat($("#salary").text().substring(3));
            obj.totalClaim=0.00;
            obj.totalHour=0.00;

    //        obj.ot_type=body.find('#ot_type').val();
    //        obj.is_holiday = body.find('#is_holiday').prop("checked");
            obj.isHoliday = body.find('#is_holiday').is(":checked");  //true(checked) or false
    //        obj.is_holiday = body.find('#is_holiday').attr("checked");  //checked
    //        obj.is_holiday = $("input[type=checkbox]:checked");
    //        console.log(obj);


            var _obj = getDayNightShiftHour();  //get day shift and/or night shift total hour
            if(obj.isHoliday==true)
            {
                if(_obj.dayShift!=0)
                {
    //                calcTotalClaim(salary,ot_type,totalHour)
                    obj.hourD +=_obj.dayShift;
//                    obj.totalClaim += parseFloat(calcTotalClaim(obj.salary,"D", obj.hourD));
                }
                if(_obj.nightShift!=0)
                {
                    obj.hourE +=_obj.nightShift;
//                    obj.totalClaim +=parseFloat(calcTotalClaim(obj.salary,"E", obj.hourE));
                }
            }
            else
            {
    //            get Day of week for the date
                var n = new Date(obj.date);
                var w = n.getDay();

                if(w==5 || w==6) //weekend in Johor (Friday/Saturday)
                {
                    if(_obj.dayShift!=0)
                    {
                        obj.hourB +=_obj.dayShift;
//                        obj.totalClaim += parseFloat(calcTotalClaim(obj.salary,"B", obj.hourB));
                    }
                    if(_obj.nightShift!=0)
                    {
                        obj.hourC +=_obj.nightShift;
//                        obj.totalClaim +=parseFloat(calcTotalClaim(obj.salary,"C", obj.hourC));
                    }
                }
    //            else if(w==4) //thursday morning shift 6am-4.30pm , use input validation to settle
    //            {
    //
    //            }
                else
                {
                    if(_obj.dayShift!=0)
                    {
                        obj.hourA +=_obj.dayShift;
//                        obj.totalClaim += parseFloat(calcTotalClaim(obj.salary,"A", obj.hourA));
                    }
                    if(_obj.nightShift!=0)
                    {
                        obj.hourB +=_obj.nightShift;
//                        obj.totalClaim += parseFloat(calcTotalClaim(obj.salary,"B", obj.hourB));
                    }
                }


            }

            // set hour's decimal place
            var hour_decimal_place =2;
            if(obj.hourA>0)
            {
                if((obj.hourA%1)!=0)
                {
                    obj.hourA = obj.hourA.toFixed(hour_decimal_place);  //toFixed number ->string conversion
                }
                // Calculate with not so accurate hour
                obj.totalClaim += parseFloat(calcTotalClaim(obj.salary,"A", obj.hourA));
            }
            if(obj.hourB>0)
            {
                if((obj.hourB%1)!=0)
                {
                    obj.hourB = obj.hourB.toFixed(hour_decimal_place);
                }
                // Calculate with not so accurate hour
                obj.totalClaim += parseFloat(calcTotalClaim(obj.salary,"B", obj.hourB));

            }
            if(obj.hourC>0)
            {
                if((obj.hourC%1)!=0)
                {
                    obj.hourC = obj.hourC.toFixed(hour_decimal_place);
                }
                // Calculate with not so accurate hour
                obj.totalClaim += parseFloat(calcTotalClaim(obj.salary,"C", obj.hourC));
            }
            if(obj.hourD>0)
            {
                if((obj.hourD%1)!=0)
                {
                    obj.hourD = obj.hourD.toFixed(hour_decimal_place);
                }
                // Calculate with not so accurate hour
                obj.totalClaim += parseFloat(calcTotalClaim(obj.salary,"D", obj.hourD));
            }
            if(obj.hourE>0)
            {
                if((obj.hourE%1)!=0)
                {
                    obj.hourE = obj.hourE.toFixed(hour_decimal_place);
                }
                // Calculate with not so accurate hour
                obj.totalClaim += parseFloat(calcTotalClaim(obj.salary,"E", obj.hourE));
            }

            //        obj.totalClaim=calcTotalClaim(obj);
            obj.totalClaim = obj.totalClaim.toFixed(2);  //toFixed number->string conversion
            obj.totalHour = parseFloat(obj.hourA) + parseFloat(obj.hourB)
                            + parseFloat(obj.hourC) + parseFloat(obj.hourD)
                            + parseFloat(obj.hourE);
//            alert(jQuery.type(obj.hourB));
            if((obj.totalHour%1)!=0)
            {
                obj.totalHour = obj.totalHour.toFixed(hour_decimal_place);
            }

            console.log(obj);
        //    <!--            alert(jQuery.type(obj.start_time));-->
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
            $('#myModal').modal('hide');
        }
    });
    //<!--        Show modal for adding record-->
    $('#add_record').on("click",function () {
        $('.modal-title').text("Tambah Rekod");
        $('#add_update').text("Tambah");
        $('#delete').hide();
        $('#modal_form')[0].reset();
        $('#errorMsg').html('');

        $('#myModal').modal('show');
    });
    //<!--        Save claims to DB-->
    $('#btn_save').click(function(){
//        event.preventDefault(); //prevent redirect/page refresh  //
//        $(this).button('loading');
        var _this = $(this);

        var claim_status=1; //1-draft,2-submitted,3-approved, 4-rejected
        updateOTClaim(claim_status,_this);

    });

    //<!--        Submit claims to SV and DB-->
    $('#btn_submit').click(function(){
//        $(this).button('loading');
        var _this = $(this);
        var claim_status=2; //1-draft,2-submitted,3-approved, 4-rejected
        updateOTClaim(claim_status,_this);

    });
    //<!--        Update claims to SV and DB-->
    $('#btn_correction').click(function(){
        $(this).button('loading');

        var claim_status=$('#claim_table').attr('claim_status'); //1-draft,2-submitted,3-approved, 4-rejected,
                            // 5-verified, 6-pending, 7-Financial reject, 8-Financial Pending
//        updateOTClaim(claim_status,_this);

        var url = APP_URL+"/claimOvertime/correction";
        //e.preventDefault();

        var arr_claim = [];
//        Get All data from table and save as Array of Object
        $('#claim_table > tbody > tr').each(function(){
            var _row=$(this);
            var _editTD = _row.children().eq(11);

            var attr = _editTD.attr("is_update");
// For some browsers, `attr` is undefined; for others, `attr` is false. Check for both.
            if (typeof attr !== typeof undefined && attr !== false)
            {   // Element has this attribute

                var obj=_row.data("object");

//        var _startHour = parseFloat(obj.startTime.substring(0,2));
                var _startMins = parseFloat(obj.startTime.substring(3,5));
//    var _endHour = parseFloat(obj.endTime.substring(0,2));
                var _endMins = parseFloat(obj.endTime.substring(3,5));

                var _startHour = change12Hto24H(obj.startTime);
                var _endHour = change12Hto24H(obj.endTime);

                //24H start and end time
                obj.startTime = _startHour.toString()+":"+_startMins.toString();
                obj.endTime = _endHour.toString()+":"+_endMins.toString();

//                obj.id = attr; //get ot claim ID
                arr_claim.push(obj);
            }
        });

        var inputData = JSON.stringify(arr_claim);
        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn_correction').val();

        var type = "PUT"; //for creating new resource
        var claim_id = $('#claim_table').attr('claim_id');
        var my_url = url;

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
//        console.error('send data: ',inputData);
        $.ajax({

            type: type,
            url: my_url,
            data: inputData,
//            dataType: 'json',
            contentType: 'json',  //for array of json
            processData: false, //for array of json
            async: false,  //wait this done runs
            success: function (data) {
                console.log('Success:',data);
                window.location.href= APP_URL+"/claimOvertime";

            },
            error: function (data) {
                console.log('Error:', data);

                $('body').html(data.responseText);  //easier to debug
            }
        });
    });


});  //end_of_document_ready

//$(document).on('click','#start_time',function(){
//    var _offset=$(this).offset();
//    setTimePickerPosition(_offset);
//});
//
//$(document).on('click','#end_time',function(){
//    var _offset=$(this).offset();
//    setTimePickerPosition(_offset);
//});
//
//function setTimePickerPosition(_offset)
//{
//    var _left=_offset.left;
//    var _top=_offset.top;
//    _top+=35;
//    $('#ui-timepicker-div').css('left',_left);
//    $('#ui-timepicker-div').css('top',_top);
//}

//function calcTotalHour() {
////    this cannot get the value when editting no clicking on the input
////    var _startHour = $('#start_time').timepicker('getHour');
////    var _startMins = $('#start_time').timepicker('getMinute');
////    var _endHour = $('#end_time').timepicker('getHour');
////    var _endMins = $('#end_time').timepicker('getMinute');
//
//    var _startTime = $('#start_time').val();
//    var _endTime = $('#end_time').val();
//    var _startHour = parseFloat(_startTime.substring(0,2));
//    var _startMins = parseFloat(_startTime.substring(3,5));
//    var _endHour = parseFloat(_endTime.substring(0,2));
//    var _endMins = parseFloat(_endTime.substring(3,5));
//
////    alert(_startTime.substring(6,8));
//    if((_startTime.substring(6,8)=="PM" && _startHour!=12) || (_startTime.substring(6,8)=="AM" && _startHour==12))
//    {
//        _startHour +=12;
//    }
//    if((_endTime.substring(6,8)=="PM" && _endHour!=12) || (_endTime.substring(6,8)=="AM" && _endHour==12))
//    {
//        _endHour +=12;
//    }
//
////    // put inside function getTimeRange(_startHour, _startMins, _endHour, _endMins)
////    var _totalHour = _endHour - _startHour;
////    if(_totalHour<0)
////    {
////        _totalHour+=24;
////    }
////    var _totalMinute = _endMins - _startMins;
////    if(_totalMinute<0)
////    {
////        _totalHour-=1;
////        _totalMinute+=60;
////    }
////    var _floatHour = _totalHour + (_totalMinute/60) ;
////    console.log(_totalHour +" hours "+_totalMinute + "mins == "+ _floatHour + "hour");
//
//    var _floatHour = getTimeRange(_startHour, _startMins, _endHour, _endMins);
//
//
//    return _floatHour;
//}


function getDayNightShiftHour()
{
    var _startTime = $('#start_time').val();
    var _endTime = $('#end_time').val();
//    var _startHour = parseFloat(_startTime.substring(0,2));
    var _startMins = parseFloat(_startTime.substring(3,5));
//    var _endHour = parseFloat(_endTime.substring(0,2));
    var _endMins = parseFloat(_endTime.substring(3,5));

//    alert(_startTime.substring(6,8));
//    if((_startTime.substring(6,8)=="PM" && _startHour!=12) || (_startTime.substring(6,8)=="AM" && _startHour==12))
//    {
//        _startHour +=12;
//    }
//    if((_endTime.substring(6,8)=="PM" && _endHour!=12) || (_endTime.substring(6,8)=="AM" && _endHour==12))
//    {
//        _endHour +=12;
//    }
    var _startHour = change12Hto24H(_startTime);
    var _endHour = change12Hto24H(_endTime);

    var temp_startTime = _startHour + (_startMins/60);
    var temp_endTime = _endHour + (_endMins/60);

    var _obj = new Object();
    _obj.morningShift = 0;
    _obj.nightShift = 0;
    if(temp_startTime>=6 && temp_startTime<=22)  //work from morning shift 06:00-22:00
    {
        if(temp_endTime>22 || temp_endTime<6)
        {
            _obj.dayShift = getTimeRange(_startHour, _startMins, 22, 0);
            _obj.nightShift = getTimeRange(22, 0, _endHour, _endMins);
        }
        else
        {
            _obj.dayShift = getTimeRange(_startHour, _startMins, _endHour, _endMins);
        }
    }
    else  //work from night shift 22:00-06:00
    {
        if(temp_endTime>=6 && temp_endTime<=22)
        {
            _obj.nightShift = getTimeRange(_startHour, _startMins, 6, 0);
            _obj.dayShift = getTimeRange(6, 0, _endHour, _endMins);
        }
        else
        {
            _obj.nightShift = getTimeRange(_startHour, _startMins, _endHour, _endMins);
        }
    }

    // Substract 7.30PM-8.00PM prayer hour from morning shift
    if(_obj.dayShift!=0)
    {
        if(temp_startTime>=6 && temp_startTime<=22)  //work from morning shift 06:00-22:00
        {
            if(temp_startTime<=19.5)
            {
                if(temp_endTime>19.5 && temp_endTime<20)
                {
                    _obj.dayShift-=((_endMins-30)/60);
                }
                else if(temp_endTime>20||temp_endTime<6)
                {
                    _obj.dayShift-=0.5;
                }
            }
        }
        else //work from night shift 22:00-06:00
        { //morning shift must starting at 6AM to temp_endTime (before 10PM)
            if(temp_endTime>19.5)
            {
                if(temp_endTime<20)
                {
                    _obj.dayShift-=((_endMins-30)/60);
                }
                else
                {
                    _obj.dayShift-=0.5;
                }
            }
        }

    }

    return _obj;
}

function getTimeRange(_startHour, _startMins, _endHour, _endMins)
{
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


//function calcTotalClaim(obj)
//{
//    var rate = $('#'+obj.ot_type).attr('rate');
//    var total= (obj.salary*12*obj.totalHour*rate)/2504;
//    total=total.toFixed(2);
//
//    console.log("(" + obj.salary + "*12*" + obj.totalHour + "*" + rate + ")/2504=" + total);
//
//    return total;
//
//}
function calcTotalClaim(salary,ot_type,totalHour)
{
    var rate = $('#'+ot_type).attr('rate');
    var total= (salary*12*totalHour*rate)/2504;
    total=total.toFixed(2);

    console.log("(" + salary + "*12*" + totalHour + "*" + rate + ")/2504=" + total);

    return total;

}

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
    $('#errorMsg').html('');

    var obj=_row.data('object');

    $('#date').val(obj.date);
    $('#start_time').val(obj.startTime);
    $('#end_time').val(obj.endTime);

//    $('#ot_type').prop('selectedIndex', _claim_index);

    if(obj.isHoliday==true)
    {
        $('#is_holiday').prop('checked','checked');
    }

    $('#desc').val(obj.otDesc);

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



$(document).on('click','#delete',function () {
    var row_index= $('#myModal').attr('row_index');
    var _row=$('#claim_table > tbody').find( "tr:eq("+row_index+")");
    _row.remove();
    refreshClaimTotal();
});

function refreshClaimTotal()
{
    var total=0.00;

    $('#claim_table > tbody > tr td:nth-child(11)').each(function(){
        var sub_total=$(this).text();
        total+=parseFloat(sub_total);
    });
    total = total.toFixed(2);
    var max_claim=$('#max_claim').text().substring(3);
    max_claim=parseFloat(max_claim);
    if(total<=max_claim)
    {
        $('#claim_total').text("RM "+total);
    }
    else
    {
        $('#claim_total').text("RM "+max_claim);
    }
}

//return new created claim_id
function createClaim(objClaim) //claim_type, claim_status, claim_month, claim_year and claim_total
{
    var url = APP_URL+"/claimOvertime/create";
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


function updateOTClaim(claim_status,_this)
{
    var url = APP_URL+"/claimOvertime";
    //e.preventDefault();

    var arr_claim = [];
//        Get All data from table and save as Array of Object
    $('#claim_table > tbody > tr').each(function(){
        var _row=$(this);
        var obj=_row.data("object");

//        var _startHour = parseFloat(obj.startTime.substring(0,2));
        var _startMins = parseFloat(obj.startTime.substring(3,5));
//    var _endHour = parseFloat(obj.endTime.substring(0,2));
        var _endMins = parseFloat(obj.endTime.substring(3,5));

        var _startHour = change12Hto24H(obj.startTime);
        var _endHour = change12Hto24H(obj.endTime);

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
        objClaim.type=1;  //1-overtime 2-travel
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
//            window.location.replace(url);
            window.location.href= url;

        },
        error: function (data) {
            console.log('Error:', data);

            $('body').html(data.responseText);  //easier to debug
        }
    });
}

function inputValidation()
{
//    var is_valid = true;
    var obj = new Object();

    obj.date = $('#date').val();
    obj.startTime = $('#start_time').val();
    obj.endTime = $('#end_time').val();
    obj.otDesc = $('#desc').val();
    obj.isHoliday = $('#is_holiday').is(":checked");  //true(checked) or false

    if(obj.date=="")
    {
        $('#date').focus();
        $('#errorMsg').html("Sila pilih tarikh.");
    }
    else if(obj.startTime=="")
    {
        $('#start_time').focus();
        $('#errorMsg').html("Sila pilih masa mula.");
    }
    else if(obj.endTime=="")
    {
        $('#end_time').focus();
        $('#errorMsg').html("Sila pilih masa tamat.");
    }
    else if(obj.otDesc=="")
    {
        $('#desc').focus();
        $('#errorMsg').html("Sila masukkan kenyataan.");
    }
    else
    {
        $('#errorMsg').html('');
        if(obj.isHoliday==false)
        {
//            get Day of week for the date
            var n = new Date(obj.date);
            var w = n.getDay();

            var _startTime = $('#start_time').val();
            var _endTime = $('#end_time').val();
            var _startHour = parseFloat(_startTime.substring(0,2));
            var _startMins = parseFloat(_startTime.substring(3,5));
            var _endHour = parseFloat(_endTime.substring(0,2));
            var _endMins = parseFloat(_endTime.substring(3,5));

//    alert(_startTime.substring(6,8));
            if((_startTime.substring(6,8)=="PM" && _startHour!=12) || (_startTime.substring(6,8)=="AM" && _startHour==12))
            {
                _startHour +=12;
            }
            if((_endTime.substring(6,8)=="PM" && _endHour!=12) || (_endTime.substring(6,8)=="AM" && _endHour==12))
            {
                _endHour +=12;
            }

            var temp_startTime = _startHour + (_startMins/60);
            var temp_endTime = _endHour + (_endMins/60);

            if(w==5 || w==6) //weekend in Johor (Friday/Saturday) working hour anytime
            {
                //do nothing
            }
            else if(w==4)  //working hour (9AM-4.30PM)
            {
                if(temp_startTime>=9 && temp_startTime<16.5)
                {
                    $('#start_time').focus();
                    $('#errorMsg').html("Masa berkerja pejabat 9:00AM - 4:30PM tidak boleh tuntut.");
                }
                else if(temp_endTime>=9 && temp_endTime<16.5)
                {
                    $('#end_time').focus();
                    $('#errorMsg').html("Masa berkerja pejabat 9:00AM - 4:30PM tidak boleh tuntut.");
                }
            }
            else    //working hour (9AM-6PM)
            {
                if(temp_startTime>=9 && temp_startTime<18)
                {
                    $('#start_time').focus();
                    $('#errorMsg').html("Masa berkerja pejabat 9:00AM - 6:00PM tidak boleh tuntut.");
                }
                else if(temp_endTime>=9 && temp_endTime<18)
                {
                    $('#end_time').focus();
                    $('#errorMsg').html("Masa berkerja pejabat 9:00AM - 6:00PM tidak boleh tuntut.");
                }

            }

        }
    }
}
