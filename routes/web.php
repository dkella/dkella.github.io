<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\ClaimsController;
use App\Http\Controllers\MileageController;
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\VehicleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


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
// Route::group(['middleware' => 'auth'], function(){
    // Route::get('/login',['as' => 'login', 'uses' => 'AuthController@login']);
    // Route::get('/logout',['as' => 'logout', 'uses' => 'AuthController@logout']);
    // Route::post('/handleLogin',['as' => 'handleLogin', 'uses' => 'AuthController@handleLogin']);
    // Route::get('/',['middleware'=>'auth','as' => '/', 'uses' => 'MainController@index']);

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/handleLogin', [AuthController::class, 'handleLogin']);
    Route::get('/', [MainController::class, 'index']);
    // Route::get('/', 'App\Http\Controllers\MainController@index');
// });

//Personal
// Route::get('personal', 'PersonalController@index');
// Route::get('personal/create', 'PersonalController@create');
// Route::post('personal', 'PersonalController@store');
// Route::put('personal/{user_id?}','PersonalController@edit');

Route::get('personal', [PersonalController::class,'index']);
Route::get('personal/create', [PersonalController::class,'create']);
Route::post('personal', [PersonalController::class,'store']);
Route::put('personal/{user_id?}',[PersonalController::class,'edit']);

//Password
// Route::get('password', 'PersonalController@password');
// Route::put('updatePassword', 'PersonalController@updatePassword');
Route::get('password', [PersonalController::class,'password']);
Route::put('updatePassword', [PersonalController::class,'updatePassword']);

//Supervisee
Route::get('supervisee', [PersonalController::class,'supervisee']);
Route::get('staffList', [PersonalController::class,'staffList']);  //for admin
Route::get('staffProfile', [PersonalController::class,'staffProfile']);  //for financial clerk
Route::put('editSalary/{user_id?}',[PersonalController::class,'editSalary']);  //for financial clerk



//Claim
Route::put('claim/{claim_id?}',[ClaimsController::class,'edit']);        //edit status and total for both mileage and OT claim
Route::post('claimMileage/create',[ClaimsController::class,'store']);    //create mileage overall claim
//Claim Update Status
Route::put('claim/verify/{id?}', [ClaimsController::class,'updateClaimStatus']);  //FM approval use this also

//Mileage Claim
Route::get('claimMileage', [MileageController::class,'index']);
Route::get('claimMileage/create', [MileageController::class,'create']);
Route::get('claimMileage/{id}', [MileageController::class,'show']);
Route::put('claimMileage/{claim_id?}',[MileageController::class,'edit']);
Route::get('claimMileage/print/{id}', [MileageController::class,'printClaim']);
Route::get('claimMileage/delete/{claim_id}', [MileageController::class,'destroy']);

Route::get('claimMileage/correction/{claim_id}',[MileageController::class,'showCorrection']);
Route::put('claimMileage/correction/{claim_id?}',[MileageController::class,'editCorrection']);

//claimMileageVerification by Supervisor
Route::get('claimMileageVerify', [MileageController::class,'verification']);
Route::get('claimMileageVerify/showClaimDetail/{id}', [MileageController::class,'showClaimDetail']);  //FM approval use this also
Route::get('claimMileageVerify/verify/{id}', [MileageController::class,'verifyClaim']);  //verify
Route::put('claimMileageVerify/disverify/{id?}', [MileageController::class,'disverifyClaim']); //reject

//claimMileageApproval by Financial Manager
Route::get('claimMileageApproval', [MileageController::class,'approval']);
Route::get('claimMileageApproval/approval/{id}', [MileageController::class,'approvalClaim']);  //approve
Route::put('claimMileageApproval/disapproval/{id?}', [MileageController::class,'disapprovalClaim']); //reject


//Mileage claim report for Supervisor
Route::get('claimMileageReport', [MileageController::class,'report_index']);
Route::post('claimMileageReport/monthlyReport', [MileageController::class,'monthlyReport']);
Route::post('claimMileageReport/staffReport', [MileageController::class,'staffReport']);

//Mileage claim report for Finanial Manager
Route::get('fm_claimMileageReport', [MileageController::class,'fm_report_index']);

Route::post('fm_claimMileageReport/yearlyReport', [MileageController::class,'fm_yearlyReport']);
Route::post('fm_claimMileageReport/monthlyReport', [MileageController::class,'fm_monthlyReport']);
Route::post('fm_claimMileageReport/staffReport', [MileageController::class,'staffReport']);   //same as sv individual
Route::post('fm_claimMileageReport/sv_staffReport', [MileageController::class,'sv_staffReport']);


//Overtime Claim
Route::get('claimOvertime', [OvertimeController::class,'index']);
Route::get('claimOvertime/create', [OvertimeController::class,'create']);
Route::get('claimOvertime/{id}', [OvertimeController::class,'show']);
Route::post('claimOvertime/create', [ClaimsController::class,'store']);
//Route::post('claimOvertime',[OvertimeController::class,'edit']);
Route::put('claimOvertime/{claim_id?}',[OvertimeController::class,'edit']);
Route::get('claimOvertime/print/{id}', [OvertimeController::class,'printClaim']);
Route::get('claimOvertime/delete/{claim_id}', [OvertimeController::class,'destroy']);

Route::get('claimOvertime/correction/{claim_id}',[OvertimeController::class,'showCorrection']);
Route::put('claimOvertime/correction/{claim_id?}',[OvertimeController::class,'editCorrection']);

//claimOvertimeVerification by Supervisor
Route::get('claimOvertimeVerify', [OvertimeController::class,'verification']);
Route::get('claimOvertimeVerify/showClaimDetail/{id}', [OvertimeController::class,'showClaimDetail']);
Route::get('claimOvertimeVerify/verify/{id}', [OvertimeController::class,'verifyClaim']);  //verify
Route::put('claimOvertimeVerify/disverify/{id?}', [OvertimeController::class,'disverifyClaim']); //reject

//claimOvertimeApproval by Financial Manager
Route::get('claimOvertimeApproval', [OvertimeController::class,'approval']);
Route::get('claimOvertimeApproval/approval/{id}', [OvertimeController::class,'approvalClaim']);  //approve
Route::put('claimOvertimeApproval/disapproval/{id?}', [OvertimeController::class,'disapprovalClaim']); //reject

//Overtime claim report for Supervisor
Route::get('claimOvertimeReport', [OvertimeController::class,'report_index']);
Route::post('claimOvertimeReport/monthlyReport', [OvertimeController::class,'monthlyReport']);
Route::post('claimOvertimeReport/staffReport', [OvertimeController::class,'staffReport']);

//Overtime claim report for Financial Manager
Route::get('fm_claimOvertimeReport', [OvertimeController::class,'fm_report_index']);
Route::post('fm_claimOvertimeReport/yearlyReport', [OvertimeController::class,'fm_yearlyReport']);
Route::post('fm_claimOvertimeReport/monthlyReport', [OvertimeController::class,'fm_monthlyReport']);
Route::post('fm_claimOvertimeReport/staffReport', [OvertimeController::class,'staffReport']);   //same as sv individual
Route::post('fm_claimOvertimeReport/sv_staffReport', [OvertimeController::class,'sv_staffReport']);
//Route::post('fm_claimOvertimeReport/monthly_taskReport', [OvertimeController::class,'monthly_taskReport']);


//Vehicle
//Route::get('vehicle', 'VehicleController@index');
//Route::get('vehicle/create', 'VehicleController@create');
Route::resource('vehicle','VehicleController');
// Route::resource('vehicle',VehicleController::class);


//staffSalary --for F clerk
Route::get('staffSalary', [PersonalController::class,'staffSalary']);
Route::post('staffSalary',[PersonalController::class,'getStaffSalary']); 