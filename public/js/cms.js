$(document).on('click','#start_time',function(){
    var _offset=$(this).offset();
    setTimePickerPosition(_offset);
});

$(document).on('click','#end_time',function(){
    var _offset=$(this).offset();
    setTimePickerPosition(_offset);
});

function setTimePickerPosition(_offset)
{
    var _left=_offset.left;
    var _top=_offset.top;
    _top+=35;
    $('#ui-timepicker-div').css('left',_left);
    $('#ui-timepicker-div').css('top',_top);
}

function change12Hto24H(fullTime) //01.34PM  => return 13
{
    var _hour12 = parseFloat(fullTime.substring(0,2));
    var _hour24=_hour12;
    if((fullTime.substring(6,8)=="PM" && _hour12!=12) || (fullTime.substring(6,8)=="AM" && _hour12==12))
    {
        _hour24 =_hour12 + 12;
    }
    return _hour24;
}

//open window for printing purpose
$(document).on('click','.print_claim', function(e){
    e.preventDefault();
    var _url = $(this).attr('href');
    var _print_window = window.open(_url, "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=700, height=700");
    _print_window.print();
});