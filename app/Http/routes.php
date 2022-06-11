<?php

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//this is alike $bar = new Bar(new Baz);
/*class Baz{}
class Bar{

    public $baz;

    public function __construct(Baz $baz)
    {
        $this->baz = $baz;
    }
}*/
//interface BarInterface {}
//
//class Bar implements BarInterface {}
//class SecondBar implements BarInterface {}
//
///*App::bind('BarInterface', function()
//{
//    return new Bar;
//});*/
//
//App::bind('BarInterface', 'SecondBar');
////App::bind
////App()->bind
//
////App::bind('Bar', function()
////{
////    //dd('fetching');
////    return new Bar(new Baz);
////});
//
//
////Route::get('bar', function(Bar $bar){
//
////Route::get('bar', function(BarInterface $bar){
//Route::get('bar', function(){
//    //$bar=App::make('BarInterface');
//    //$bar=App()['BarInterface'];
//    $bar=App('BarInterface');
//
//
//    //dd($bar->baz);
//    dd($bar);
//});
//
//Route::get('/', 'WelcomeController@index');

Route::get('foo','FooController@foo');

//Route::get('about','PagesController@about');
Route::get('about',['middleware'=>'auth','uses'=>'PagesController@about']);
Route::get('contact', 'WelcomeController@contact');

Route::get('guest', ['middleware'=>'auth',function(){
    return 'This page will only show if the user is signed in';
}]);

Route::get('phpinfo', function(){
    return phpinfo();
});
/*
Route::get('articles','ArticlesController@index');
Route::get('articles/create','ArticlesController@create');
Route::get('articles/{id}','ArticlesController@show');  //This should always place at bottom
Route::post('articles','ArticlesController@store');
Route::get('articles/{id}/edit','ArticlesController@edit');
*/
//replace by resources:
Route::resource('articles','ArticlesController');

Route::get('tags/{tags}','TagsController@show');



/*Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);*/


/*Route::get('foo', ['middleware'=>'manager',function(){
    return 'This page may only be viewed by manager';
}]);*/

//-------------------MBJB------------------------------------
//Route::group(['middleware' => 'auth'], function(){
    Route::get('/login',['as' => 'login', 'uses' => 'AuthController@login']);
    Route::get('/logout',['as' => 'logout', 'uses' => 'AuthController@logout']);
    Route::post('/handleLogin',['as' => 'handleLogin', 'uses' => 'AuthController@handleLogin']);
    Route::get('/',['middleware'=>'auth','as' => '/', 'uses' => 'MainController@index']);

//});


//Route::get('/', 'MainController@index');



//Personal
Route::get('personal', 'PersonalController@index');
Route::get('personal/create', 'PersonalController@create');
Route::post('personal', 'PersonalController@store');
//Route::post('personal/edit','PersonalController@edit');
Route::put('personal/{user_id?}','PersonalController@edit');

//Password
Route::get('password', 'PersonalController@password');
Route::put('updatePassword', 'PersonalController@updatePassword');

//Supervisee
Route::get('supervisee', 'PersonalController@supervisee');
Route::get('staffList', 'PersonalController@staffList');  //for admin
Route::get('staffProfile', 'PersonalController@staffProfile');  //for financial clerk
Route::put('editSalary/{user_id?}','PersonalController@editSalary');  //for financial clerk



//Claim
Route::put('claim/{claim_id?}','ClaimsController@edit');        //edit status and total for both mileage and OT claim
Route::post('claimMileage/create','ClaimsController@store');   //create mileage overall claim
//Claim Update Status
Route::put('claim/verify/{id?}', 'ClaimsController@updateClaimStatus');  //FM approval use this also

//Mileage Claim
Route::get('claimMileage', 'MileageController@index');
Route::get('claimMileage/create', 'MileageController@create');
Route::get('claimMileage/{id}', 'MileageController@show');
Route::put('claimMileage/{claim_id?}','MileageController@edit');
Route::get('claimMileage/print/{id}', 'MileageController@printClaim');
Route::get('claimMileage/delete/{claim_id}', 'MileageController@destroy');

Route::get('claimMileage/correction/{claim_id}','MileageController@showCorrection');
Route::put('claimMileage/correction/{claim_id?}','MileageController@editCorrection');

//claimMileageVerification by Supervisor
Route::get('claimMileageVerify', 'MileageController@verification');
Route::get('claimMileageVerify/showClaimDetail/{id}', 'MileageController@showClaimDetail');  //FM approval use this also
Route::get('claimMileageVerify/verify/{id}', 'MileageController@verifyClaim');  //verify
Route::put('claimMileageVerify/disverify/{id?}', 'MileageController@disverifyClaim'); //reject

//claimMileageApproval by Financial Manager
Route::get('claimMileageApproval', 'MileageController@approval');
Route::get('claimMileageApproval/approval/{id}', 'MileageController@approvalClaim');  //approve
Route::put('claimMileageApproval/disapproval/{id?}', 'MileageController@disapprovalClaim'); //reject


//Mileage claim report for Supervisor
Route::get('claimMileageReport', 'MileageController@report_index');
Route::post('claimMileageReport/monthlyReport', 'MileageController@monthlyReport');
Route::post('claimMileageReport/staffReport', 'MileageController@staffReport');

//Mileage claim report for Finanial Manager
Route::get('fm_claimMileageReport', 'MileageController@fm_report_index');

Route::post('fm_claimMileageReport/yearlyReport', 'MileageController@fm_yearlyReport');
Route::post('fm_claimMileageReport/monthlyReport', 'MileageController@fm_monthlyReport');
Route::post('fm_claimMileageReport/staffReport', 'MileageController@staffReport');   //same as sv individual
Route::post('fm_claimMileageReport/sv_staffReport', 'MileageController@sv_staffReport');


//Overtime Claim
Route::get('claimOvertime', 'OvertimeController@index');
Route::get('claimOvertime/create', 'OvertimeController@create');
Route::get('claimOvertime/{id}', 'OvertimeController@show');
Route::post('claimOvertime/create','ClaimsController@store');
//Route::post('claimOvertime','OvertimeController@edit');
Route::put('claimOvertime/{claim_id?}','OvertimeController@edit');
Route::get('claimOvertime/print/{id}', 'OvertimeController@printClaim');
Route::get('claimOvertime/delete/{claim_id}', 'OvertimeController@destroy');

Route::get('claimOvertime/correction/{claim_id}','OvertimeController@showCorrection');
Route::put('claimOvertime/correction/{claim_id?}','OvertimeController@editCorrection');

//claimOvertimeVerification by Supervisor
Route::get('claimOvertimeVerify', 'OvertimeController@verification');
Route::get('claimOvertimeVerify/showClaimDetail/{id}', 'OvertimeController@showClaimDetail');
Route::get('claimOvertimeVerify/verify/{id}', 'OvertimeController@verifyClaim');  //verify
Route::put('claimOvertimeVerify/disverify/{id?}', 'OvertimeController@disverifyClaim'); //reject

//claimOvertimeApproval by Financial Manager
Route::get('claimOvertimeApproval', 'OvertimeController@approval');
Route::get('claimOvertimeApproval/approval/{id}', 'OvertimeController@approvalClaim');  //approve
Route::put('claimOvertimeApproval/disapproval/{id?}', 'OvertimeController@disapprovalClaim'); //reject

//Overtime claim report for Supervisor
Route::get('claimOvertimeReport', 'OvertimeController@report_index');
Route::post('claimOvertimeReport/monthlyReport', 'OvertimeController@monthlyReport');
Route::post('claimOvertimeReport/staffReport', 'OvertimeController@staffReport');

//Overtime claim report for Financial Manager
Route::get('fm_claimOvertimeReport', 'OvertimeController@fm_report_index');
Route::post('fm_claimOvertimeReport/yearlyReport', 'OvertimeController@fm_yearlyReport');
Route::post('fm_claimOvertimeReport/monthlyReport', 'OvertimeController@fm_monthlyReport');
Route::post('fm_claimOvertimeReport/staffReport', 'OvertimeController@staffReport');   //same as sv individual
Route::post('fm_claimOvertimeReport/sv_staffReport', 'OvertimeController@sv_staffReport');
//Route::post('fm_claimOvertimeReport/monthly_taskReport', 'OvertimeController@monthly_taskReport');


//Vehicle
//Route::get('vehicle', 'VehicleController@index');
//Route::get('vehicle/create', 'VehicleController@create');
Route::resource('vehicle','VehicleController');


//staffSalary --for F clerk
Route::get('staffSalary','PersonalController@staffSalary');
Route::post('staffSalary','PersonalController@getStaffSalary');