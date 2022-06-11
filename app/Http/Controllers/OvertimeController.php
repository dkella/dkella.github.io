<?php namespace App\Http\Controllers;

use App\Claim;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Identifier;
use App\Otclaim;
use App\Otconfig;
use App\Task;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class OvertimeController extends Controller {

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
        $claims= $personal->claims()->where('type',1)
                                    ->orderBy('year')
                                    ->orderBy('month')
                                    ->get(); //type 1=OT claim

        $month = DB::table('identifiers')->where('type', 'month')->get();
        $status = DB::table('identifiers')->where('type', 'claim_status')->get();
//        dd($status);
        return view('claimOverTime.index',compact('claims','month','status'));
    }

    public function create()
    {
        $personal = \Auth::user();
        $state = "add";
        $otConfig= Otconfig::all();
        $dropDown_otRate = Otconfig::pluck('description', 'typeOT');
//        $claim=$personal->claims->first();
//        $otClaim = $claim->otclaim->first();
//        dd($otClaim);

        $claims= new Claim();
        $claims->year = (int) date('Y');
        $claims->month =(int) date('m');
//        dd($claims);
        $month = DB::table('identifiers')->where('type', 'month')
                                        ->where('code',$claims->month)
                                        ->first();
//        dd($month->name);

        return view('claimOverTime.crud',compact('personal','claims','state','otConfig','dropDown_otRate','month'));
    }

    public function show($id)
    {
        $personal = \Auth::user();
        $claims = Claim::find($id);
        $state = "update";
        $otConfig= Otconfig::all();
        $dropDown_otRate = Otconfig::pluck('description', 'typeOT');
        $month = DB::table('identifiers')->where('type', 'month')
                                        ->where('code',$claims->month)
                                        ->first();

        return view('claimOverTime.crud',compact('personal','claims','state','otConfig','dropDown_otRate','month'));
    }

    public function printClaim($id)
    {
//        $personal = \Auth::user();
        $claims = Claim::find($id);
        $personal = $claims->users;
//        $state = "update";
        $otConfig= Otconfig::all();
        $dropDown_otRate = Otconfig::pluck('description', 'typeOT');
        $month = DB::table('identifiers')->where('type', 'month')
            ->where('code',$claims->month)
            ->first();
//        dd($month);

//        dd($claims->users);
        return view('claimOverTime.print',compact('personal','claims','otConfig','dropDown_otRate','month'));

    }

    public function destroy($claim_id)
    {
        Claim::find($claim_id)->delete();
        Otclaim::where('claim_id',$claim_id)->delete();   //delete all same claim_id

        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'Rekod telah dibuang.' ) );
    }

    public function edit(Request $request,$claim_id)
    {
//        $claim = Claim::find($claim_id);
        Otclaim::where('claim_id',$claim_id)->delete();   //delete all same claim_id

        $inputData = json_decode($request->getContent(), true);
        $arrLength = sizeof($inputData);
        for($x = 0; $x < $arrLength; $x++) {
            $obj = new Otclaim();
            $obj->date= $inputData[$x]['date'];
            $obj->startTime= $inputData[$x]['startTime'];
            $obj->endTime= $inputData[$x]['endTime'];
            $obj->totalHour= $inputData[$x]['totalHour'];
            $obj->hourA= $inputData[$x]['hourA'];
            $obj->hourB= $inputData[$x]['hourB'];
            $obj->hourC= $inputData[$x]['hourC'];
            $obj->hourD= $inputData[$x]['hourD'];
            $obj->hourE= $inputData[$x]['hourE'];
            $obj->otDesc= $inputData[$x]['otDesc'];
            $obj->totalClaim= $inputData[$x]['totalClaim'];
            $obj->isHoliday= $inputData[$x]['isHoliday'];
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
            $claims[]= $staff->claims()->where('type',1)->get(); //type 1=OT claim
        }

//        dd($claims);

/*//        to get each claim staff name
        foreach ($claims as $claimss){
            foreach ($claimss as $claim){
//            $user = $claim->users;
            $user = $claim->users->name;
            dd($user);
            }
        }*/

        $month = Identifier::where('type', 'month')->get();
        $dropDown_month = $month->pluck('name', 'code');
//        dd($dropDown_month);

        $status = DB::table('identifiers')->where('type', 'claim_status')->get();
//        dd($status);
        return view('claimOverTime.verification',compact('sv_staffs','claims','month','dropDown_month','status'));
    }

    public function showClaimDetail($id)
    {
        $otClaim= Otclaim::where('claim_id',$id)->get();
//        dd($otClaim);
        foreach($otClaim as $claim)
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

        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$otClaim ) );
    }

    public function verifyClaim($id)
    {
        $otClaim= Otclaim::find($id);
        $otClaim->toArray();
        $otClaim->flag=3;
        $otClaim->save();
//        dd($otClaim);

        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$otClaim ) );
    }

    public function disverifyClaim(Request $request,$id)
    {
        $inputData = json_decode($request->getContent(), true);
        $otClaim= Otclaim::find($id);
        $otClaim->toArray();
        $otClaim->flag = 4;
        $otClaim->rejectReason = $inputData["rejectReason"];
        $otClaim->save();
//        dd($otClaim);

        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$otClaim ) );
    }

    //Index page for for Financial Manager approval
    public function approval()
    {
//        $sv_staffs = User::all();   //should only sv and staff

        $sv_staffs = User::whereHas('roles',function($q)
                                    {
                                        $q->where(function ($query) {
                                            $query->where('role_id', '=', 2)    //2-staff
                                                ->orWhere('role_id', '=', 3);   //3-sv
                                        });
                                    })->get();
//        $sv_staffs = User::has('roles')->get();   //get user who has at least one role
//        dd($sv_staffs);

        foreach ($sv_staffs as $staff) {
            $claims[]= $staff->claims()->where('type',1) //type 1=OT claim
                                    ->where(function ($query) {
                                        $query->where('status', '=', 5) //status 5=verified 3=approved
                                            ->orWhere('status', '=', 3)
                                            ->orWhere('status', '=', 7) //7=financial reject 8=financial pending
                                            ->orWhere('status', '=', 8);
                                    })->get();
        }

        $month = Identifier::where('type', 'month')->get();
        $dropDown_month = $month->pluck('name', 'code');
//        dd($dropDown_month);

        $status = DB::table('identifiers')->where('type', 'claim_status')->get();
//        dd($status);
        return view('claimOverTime.approval',compact('sv_staffs','claims','month','dropDown_month','status'));
    }

    public function approvalClaim($id)
    {
        $otClaim= Otclaim::find($id);
        $otClaim->toArray();
        $otClaim->flag=1;
        $otClaim->save();
//        dd($otClaim);

        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$otClaim ) );
    }

    public function disapprovalClaim(Request $request,$id)
    {
        $inputData = json_decode($request->getContent(), true);
        $otClaim= Otclaim::find($id);
        $otClaim->toArray();
        $otClaim->flag = 2;
        $otClaim->fm_rejectReason = $inputData["rejectReason"];
        $otClaim->save();
        dd($otClaim);

        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$otClaim ) );
    }

//report_index for sv
    public function report_index()
    {
        //get sv's staff
        $sv = \Auth::user();
        $sv_staffs = $sv->theStaffs;
//        dd($sv_staffs);
        $month = Identifier::where('type', 'month')->get();
        $dropDown_month = $month->pluck('name', 'code');

        $dropDown_staff =$sv_staffs->pluck('name','id');


        return view('claimOvertime.report',compact('sv_staffs','dropDown_month','dropDown_staff'));
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
                ->where('claims.type',1) //type 1=OT claim
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

//        $staff = User::find($inputData["staff"]);
//        $claims =$staff->claims()
//                                ->select('month', 'total')
//                                ->where('type',1) //type 1=OT claim
//                                ->where('status', '=', 3) //status 3=approved
//                                ->where('year', '=', $inputData["year"]) //year =this.year
//                                ->get();
//
//        dd($claims);


            $result = DB::table('claims')
                ->join('identifiers', 'claims.month', '=', 'identifiers.code')
                ->select('identifiers.name', 'claims.total')
                ->where('claims.user_id',$inputData["staff"]) //this staff
                ->where('claims.type',1) //type 1=OT claim
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
        $dropDown_month = $month->pluck('name', 'code');

        $dropDown_staff =$sv_staffs->pluck('name','id');

        //get dropdownlist of sv
        $sv = User::whereHas('roles',function($q)
        {
            $q->where(function ($query) {
                $query->where('role_id', '=', 3);   //3-sv
            });
        })->get();
        $dropDown_sv =$sv->pluck('name','id');

        $dropDown_task = Task::pluck('task_name','id');

        return view('claimOvertime.fm_report',compact('sv_staffs','dropDown_month','dropDown_staff','dropDown_sv','dropDown_task'));
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
            ->where('claims.type',1) //type 1=OT claim
            ->where('claims.status', '=', 3) //status 3=approved
            ->where('claims.year', '=', $inputData["year"]) //year =this.year
            ->where('identifiers.type', '=', "month")
            ->groupBy('identifiers.name')
            ->selectRaw('sum(claims.total) as total, identifiers.name')
//            ->pluck('total','identifiers.name');
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
                ->where('claims.type',1) //type 1=OT claim
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
                ->where('claims.type',1) //type 1=OT claim
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

////task monthly report: each sv's staff report for fm
//    public function monthly_taskReport(Request $request)
//    {
//        $inputData = json_decode($request->getContent(), true);
//
//        //get sv's staff
//        $sv = User::find($inputData["sv"]);
//        $sv_staffs = $sv->theStaffs;
//
//        $arr_result=null; //initialize
//        foreach ($sv_staffs as $staff) {
//            $result = DB::table('users')
//                ->join('claims', 'users.id', '=', 'claims.user_id')
//                ->select('users.name', 'claims.total')
//                ->where('users.id',$staff->id) //this staff
//                ->where('claims.type',1) //type 1=OT claim
//                ->where('claims.status', '=', 3) //status 3=approved
//                ->where('claims.year', '=', $inputData["year"]) //year =this.year
//                ->where('claims.month', '=', $inputData["month"]) //month =this.month
//                ->get();
//            if($result!=null)
//            {
//                $arr_result[] = $result;
//            }
//
//        }
//
//        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$arr_result ) );
//
//    }


    public function showCorrection($id)
    {
        $personal = \Auth::user();
        $claims = Claim::find($id);
        $state = "update";
        $otConfig= Otconfig::all();
        $dropDown_otRate = Otconfig::pluck('description', 'typeOT');
        $month = DB::table('identifiers')->where('type', 'month')
            ->where('code',$claims->month)
            ->first();

        return view('claimOverTime.correction',compact('personal','claims','state','otConfig','dropDown_otRate','month'));
    }

    public function editCorrection(Request $request,$claim_id)
    {

//        Otclaim::where('claim_id',$claim_id)->delete();   //delete all same claim_id

        $inputData = json_decode($request->getContent(), true);
        $arrLength = sizeof($inputData);

//        dd($inputData);
        for($x = 0; $x < $arrLength; $x++) {

            $obj = Otclaim::find($inputData[$x]['id']);

//            dd($obj->otDesc);
//        dd($inputData[$x]);
//            $obj = new Otclaim();
            $obj->date= $inputData[$x]['date'];
            $obj->startTime= $inputData[$x]['startTime'];
            $obj->endTime= $inputData[$x]['endTime'];
            $obj->totalHour= $inputData[$x]['totalHour'];
            $obj->hourA= $inputData[$x]['hourA'];
            $obj->hourB= $inputData[$x]['hourB'];
            $obj->hourC= $inputData[$x]['hourC'];
            $obj->hourD= $inputData[$x]['hourD'];
            $obj->hourE= $inputData[$x]['hourE'];
            $obj->otDesc= $inputData[$x]['otDesc'];
            $obj->totalClaim= $inputData[$x]['totalClaim'];
            $obj->isHoliday= $inputData[$x]['isHoliday'];
            $obj->save();

//            dd($inputData);
        }
//        $data = ['0','1'];
//        Mail::send('emails.claimUpdated', $data, function($message)
//        {
//            $message->from('mbjbcms@gmail.com', 'MBJB CMS');
//
//            $message->to('kellaong@yahoo.com');
//
////            $message->attach($pathToFile);
//        });
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

        Mail::send('emails.claimUpdated',['receiverName' => $receiverName,'staffname' => $staff->name,'claimType' => 'Overtime'],function($message)
        {
            $message->to('kellaong@yahoo.com.my', 'Kella Ong')->subject('Tuntutan Overtime Dikemaskini');
        });

        return response()->json($inputData);
    }


}


