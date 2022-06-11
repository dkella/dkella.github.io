<?php namespace App\Http\Controllers;

use App\Claim;
use App\Identifier;
use App\Task;
use App\Travelclaim;
use App\Travelconfig;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MileageController extends Controller {

    /**
     * Create a new overtime controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth'); //user login validation for all pages
        //$this->middleware('auth',['only'=>'create']);  //only validate create page
//        $this->middleware('auth',['except'=>'index','show']);  //validate all except index page

    }
    public function index()
    {

        $personal = \Auth::user();
        $claims= $personal->claims()->where('type',2)
                                    ->orderBy('year')
                                    ->orderBy('month')
                                    ->get(); //type 2=travel claim
//dd($claims);
        $month = DB::table('identifiers')->where('type', 'month')->get();
        $status = DB::table('identifiers')->where('type', 'claim_status')->get();

        return view('claimMileage.index',compact('claims','month','status'));
    }

    public function create()
    {
        $personal = \Auth::user();
        $state = "add";
        $travelConfig= Travelconfig::all();
        $claims= new Claim();
        $claims->year = (int) date('Y');
        $claims->month =(int) date('m');
        $month = DB::table('identifiers')->where('type', 'month')
            ->where('code',$claims->month)
            ->first();
//        dd($month->name);
        $vehicle = $personal->vehicles;
        $dropDown_task = Task::lists('task_name', 'id');
//        dd($dropDown_task);

//        return view('claimOverTime.create',compact('personal','claims','state','otConfig','dropDown_otRate','month'));
        return view('claimMileage.crud',compact('personal','claims','state','month','travelConfig','vehicle','dropDown_task'));

    }

    public function show($id)
    {
        $personal = \Auth::user();
        $claims = Claim::find($id);
        $state = "update";
        $travelConfig= Travelconfig::all();
        $month = DB::table('identifiers')->where('type', 'month')
            ->where('code',$claims->month)
            ->first();
//        dd($month);
        $vehicle = $personal->vehicles;
        $dropDown_task = Task::lists('task_name', 'id');

//        //testing
//        $travel_claim = $claims->travelclaim[0];
//        $task = $travel_claim->tasks;
//        dd($task);

        return view('claimMileage.crud',compact('personal','claims','state','month','travelConfig','vehicle','dropDown_task'));
    }

    public function printClaim($id)
    {
//        $personal = \Auth::user();
        $claims = Claim::find($id);
        $personal = $claims->users;
//        $state = "update";
        $travelConfig= Travelconfig::all();
        $month = DB::table('identifiers')->where('type', 'month')
            ->where('code',$claims->month)
            ->first();
//        dd($month);
        $vehicle = $personal->vehicles;
        return view('claimMileage.print',compact('personal','claims','month','travelConfig','vehicle'));
    }

    public function destroy($claim_id)
    {
        Claim::find($claim_id)->delete();
        Travelclaim::where('claim_id',$claim_id)->delete();   //delete all same claim_id
//        echo json_encode( array('status'=>1,'errors'=>'', 'data'=>json_encode($objModel) ) );
        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'Rekod telah dibuang.' ) );
    }


    public function edit(Request $request,$claim_id)
    {
//        $claim = Claim::find($claim_id);
        Travelclaim::where('claim_id',$claim_id)->delete();   //delete all same claim_id

        $inputData = json_decode($request->getContent(), true);
//        dd($inputData);
        $arrLength = sizeof($inputData);
        for($x = 0; $x < $arrLength; $x++) {
            $obj = new Travelclaim();
            $obj->date= $inputData[$x]['date'];
            $obj->startTime= $inputData[$x]['startTime'];
            $obj->endTime= $inputData[$x]['endTime'];
            $obj->hour= $inputData[$x]['hour'];
            $obj->task_id= $inputData[$x]['task_id'];
            $obj->travelDesc= $inputData[$x]['travelDesc'];
            $obj->mileage= $inputData[$x]['mileage'];
            $obj->claim_id = $claim_id;
            $obj->save();
        }

        return response()->json($inputData);
    }

    //Index page for Supervisor verification
    public function verification()
    {
        //get sv's staff
        $sv = \Auth::user();
        $sv_staffs = $sv->theStaffs; //this is array, we need to get one by one
//        dd($sv_staffs);
        foreach ($sv_staffs as $staff) {
            $claims[]= $staff->claims()->where('type',2)->get(); //type 2=Mileage claim
        }

//        dd($claims);

        $month = Identifier::where('type', 'month')->get();
        $dropDown_month = $month->lists('name', 'code');
//        dd($dropDown_month);

        $status = DB::table('identifiers')->where('type', 'claim_status')->get();
//        dd($status);
        return view('claimMileage.verification',compact('sv_staffs','claims','month','dropDown_month','status'));
    }

    public function showClaimDetail($id)
    {
        $travelClaim= Travelclaim::where('claim_id',$id)->get();
//        dd($otClaim);
        foreach($travelClaim as $claim)
        {
//            dd($claim->date);
            $date=date_create($claim->date);
            $claim->date = date_format($date,"Y-m-d");
//            echo $claim->date+"<br>";
            $claim->startTime = date('h:i A', strtotime( $claim->startTime));
            $claim->endTime = date('h:i A', strtotime( $claim->endTime));

            if($claim->flag==0)
            {
                $claim->flagDesc = "-";
            }
            else if($claim->flag==1)
            {
                $claim->flagDesc = "Lulus";
            }
            else if($claim->flag==2)
            {
                $claim->flagDesc = "Tidak Lulus";
            }
            else if($claim->flag==3)
            {
                $claim->flagDesc = "Sah";
            }
            else if($claim->flag==4)
            {
                $claim->flagDesc = "Tidak Sah";
            }

        }
//        dd($otClaim);

        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$travelClaim ) );
    }

    public function verifyClaim($id)
    {
        $travelClaim= Travelclaim::find($id);
        $travelClaim->toArray();
        $travelClaim->flag=3;
        $travelClaim->save();
//        dd($travelClaim);

        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$travelClaim ) );
    }

    public function disverifyClaim(Request $request,$id)
    {
        $inputData = json_decode($request->getContent(), true);
        $travelClaim= Travelclaim::find($id);
        $travelClaim->toArray();
        $travelClaim->flag=4;
        $travelClaim->rejectReason = $inputData["rejectReason"];
        $travelClaim->save();
//        dd($travelClaim);

        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$travelClaim ) );
    }

    //Index page for Financial Manager approval
    public function approval()
    {
//        $sv_staffs = User::all();   //should only sv and staff
        $sv_staffs = User::whereHas('roles',function($q)
        {
            $q->where(function ($query) {
                $query->where('role_id', '=', 2)        //2-staff
                    ->orWhere('role_id', '=', 3);   //3-sv
            });
        })->get();


//        dd($sv_staffs);

        foreach ($sv_staffs as $staff) {
            $claims[]= $staff->claims()->where('type',2)    //type 2=Mileage claim
                                    ->where(function ($query) {
                                        $query->where('status', '=', 5) //status 5=verified 3=approved
                                            ->orWhere('status', '=', 3)
                                            ->orWhere('status', '=', 7) //7=financial reject 8=financial pending
                                            ->orWhere('status', '=', 8);
                                    })
                                    ->get();
        }

//        dd($claims);

        $month = Identifier::where('type', 'month')->get();
        $dropDown_month = $month->lists('name', 'code');
//        dd($dropDown_month);

        $status = DB::table('identifiers')->where('type', 'claim_status')->get();
//        dd($status);
        return view('claimMileage.approval',compact('sv_staffs','claims','month','dropDown_month','status'));
    }


    public function approvalClaim($id)
    {
        $travelClaim= Travelclaim::find($id);
        $travelClaim->toArray();
        $travelClaim->flag=1;
        $travelClaim->save();
//        dd($travelClaim);

        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$travelClaim ) );
    }


    public function disapprovalClaim(Request $request,$id)
    {
        $inputData = json_decode($request->getContent(), true);
        $travelClaim= Travelclaim::find($id);
        $travelClaim->toArray();
        $travelClaim->flag=2;
        $travelClaim->fm_rejectReason = $inputData["rejectReason"];
        $travelClaim->save();
//        dd($travelClaim);

        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$travelClaim ) );
    }


//report_index for sv
    public function report_index()
    {
        //get sv's staff
        $sv = \Auth::user();
        $sv_staffs = $sv->theStaffs;
//        dd($sv_staffs);
        $month = Identifier::where('type', 'month')->get();
        $dropDown_month = $month->lists('name', 'code');

        $dropDown_staff =$sv_staffs->lists('name','id');


        return view('claimMileage.report',compact('sv_staffs','dropDown_month','dropDown_staff'));

    }

    //monthly report for sv
    public function monthlyReport(Request $request)
    {
        $inputData = json_decode($request->getContent(), true);

        //get sv's staff
        $sv = \Auth::user();
        $sv_staffs = $sv->theStaffs;

        $arr_result=null; //initialize
        foreach ($sv_staffs as $staff) {
            $result = DB::table('users')
                ->join('claims', 'users.id', '=', 'claims.user_id')
                ->select('users.name', 'claims.total')
                ->where('users.id',$staff->id) //this staff
                ->where('claims.type',2) //type 2=Mileage claim
                ->where('claims.status', '=', 3) //status 3=approved
                ->where('claims.year', '=', $inputData["year"]) //year =this.year
                ->where('claims.month', '=', $inputData["month"]) //month =this.month
                ->get();
            if($result!=null)
            {
                $arr_result[] = $result;
            }

        }
//        dd($arr_result);

        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$arr_result ) );

    }

//staff report for sv
    public function staffReport(Request $request)
    {
        $inputData = json_decode($request->getContent(), true);

        $result = DB::table('claims')
            ->join('identifiers', 'claims.month', '=', 'identifiers.code')
            ->select('identifiers.name', 'claims.total')
            ->where('claims.user_id',$inputData["staff"]) //this staff
            ->where('claims.type',2) //type 2=Mileage claim
            ->where('claims.status', '=', 3) //status 3=approved
            ->where('claims.year', '=', $inputData["year"]) //year =this.year
            ->where('identifiers.type', '=', "month")
            ->get();

        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$result ) );

    }


//report_index for fm
    public function fm_report_index()
    {
        $sv_staffs = User::whereHas('roles',function($q)
        {
            $q->where(function ($query) {
                $query->where('role_id', '=', 2)    //2-staff
                    ->orWhere('role_id', '=', 3);   //3-sv
            });
        })->get();

        $month = Identifier::where('type', 'month')->get();
        $dropDown_month = $month->lists('name', 'code');

        $dropDown_staff =$sv_staffs->lists('name','id');

        //get dropdownlist of sv
        $sv = User::whereHas('roles',function($q)
        {
            $q->where(function ($query) {
                $query->where('role_id', '=', 3);   //3-sv
            });
        })->get();
        $dropDown_sv =$sv->lists('name','id');

        $dropDown_task = Task::lists('task_name','id');

        return view('claimMileage.fm_report',compact('sv_staffs','dropDown_month','dropDown_staff','dropDown_sv','dropDown_task'));
    }


//yearly report for fm
    public function fm_yearlyReport(Request $request)
    {
        $inputData = json_decode($request->getContent(), true);

        $sv_staffs = User::whereHas('roles',function($q)
        {
            $q->where(function ($query) {
                $query->where('role_id', '=', 2)    //2-staff
                    ->orWhere('role_id', '=', 3);   //3-sv
            });
        })->get();


        $result = DB::table('users')
            ->join('claims', 'users.id', '=', 'claims.user_id')
            ->join('identifiers', 'claims.month', '=', 'identifiers.code')
//            ->select('claims.month','identifiers.name', 'claims.total')
            ->where('claims.type',2) //type 2=Mileage claim
            ->where('claims.status', '=', 3) //status 3=approved
            ->where('claims.year', '=', $inputData["year"]) //year =this.year
            ->where('identifiers.type', '=', "month")
            ->groupBy('identifiers.name')
            ->selectRaw('sum(claims.total) as total, identifiers.name')
//            ->lists('total','identifiers.name');
            ->orderBy('claims.month')
            ->get();
//dd($result);

        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$result ) );

    }


//monthly report for financial manager
    public function fm_monthlyReport(Request $request)
    {
        $inputData = json_decode($request->getContent(), true);

        $sv_staffs = User::whereHas('roles',function($q)
        {
            $q->where(function ($query) {
                $query->where('role_id', '=', 2)    //2-staff
                    ->orWhere('role_id', '=', 3);   //3-sv
            });
        })->get();

        $arr_result=null; //initialize
        foreach ($sv_staffs as $staff) {
            $result = DB::table('users')
                ->join('claims', 'users.id', '=', 'claims.user_id')
                ->select('users.name', 'claims.total')
                ->where('users.id',$staff->id) //this staff
                ->where('claims.type',2) //type 2=Mileage claim
                ->where('claims.status', '=', 3) //status 3=approved
                ->where('claims.year', '=', $inputData["year"]) //year =this.year
                ->where('claims.month', '=', $inputData["month"]) //month =this.month
                ->get();
            if($result!=null)
            {
                $arr_result[] = $result;
            }

        }
//        dd($arr_result);

        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$arr_result ) );

    }

//each sv's staff report for fm
    public function sv_staffReport(Request $request)
    {
        $inputData = json_decode($request->getContent(), true);

        //get sv's staff
        $sv = User::find($inputData["sv"]);
        $sv_staffs = $sv->theStaffs;

        $arr_result=null; //initialize
        foreach ($sv_staffs as $staff) {
            $result = DB::table('users')
                ->join('claims', 'users.id', '=', 'claims.user_id')
                ->select('users.name', 'claims.total')
                ->where('users.id',$staff->id) //this staff
                ->where('claims.type',2) //type 2=Mileage claim
                ->where('claims.status', '=', 3) //status 3=approved
                ->where('claims.year', '=', $inputData["year"]) //year =this.year
                ->where('claims.month', '=', $inputData["month"]) //month =this.month
                ->get();
            if($result!=null)
            {
                $arr_result[] = $result;
            }

        }

        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$arr_result ) );

    }





    public function showCorrection($id)
    {
        $personal = \Auth::user();
        $claims = Claim::find($id);
        $state = "update";
        $travelConfig= Travelconfig::all();
        $month = DB::table('identifiers')->where('type', 'month')
            ->where('code',$claims->month)
            ->first();
//        dd($month);
        $vehicle = $personal->vehicles;
        $dropDown_task = Task::lists('task_name', 'id');

        return view('claimMileage.correction',compact('personal','claims','state','month','travelConfig','vehicle','dropDown_task'));
    }


    public function editCorrection(Request $request,$claim_id)
    {
//        $claim = Claim::find($claim_id);
//        Travelclaim::where('claim_id',$claim_id)->delete();   //delete all same claim_id

        $inputData = json_decode($request->getContent(), true);
        $arrLength = sizeof($inputData);
        for($x = 0; $x < $arrLength; $x++) {

            $obj = Travelclaim::find($inputData[$x]['id']);

//            $obj = new Travelclaim();
            $obj->date= $inputData[$x]['date'];
            $obj->startTime= $inputData[$x]['startTime'];
            $obj->endTime= $inputData[$x]['endTime'];
            $obj->hour= $inputData[$x]['hour'];
            $obj->task_id= $inputData[$x]['task_id'];
            $obj->travelDesc= $inputData[$x]['travelDesc'];
            $obj->mileage= $inputData[$x]['mileage'];
            $obj->claim_id = $claim_id;
            $obj->save();
        }

        $staff = \Auth::user();

        $receiverName = "Supervisor";
        if($obj->flag==4) //4-supervisor reject
        {
            $receiver = $staff->theSupervisors()->first();
        }
        else if($obj->flag==2) //2-fm reject
        {
            $receiver = User::whereHas('roles',function($q)
            {
                $q->where(function ($query) {
                    $query->where('role_id', '=', 5);   //5-fm
                });
            })->get()->first();
        }
        $receiverName = $receiver->name;

        Mail::send('emails.claimUpdated',['receiverName' => $receiverName,'staffname' => $staff->name,'claimType' => 'Perjalanan'],function($message)
        {
            $message->to('kellaong@yahoo.com.my','Supervisor1')->subject('Tuntutan Perjalanan Dikemaskini');
        });

        return response()->json($inputData);
    }


}
