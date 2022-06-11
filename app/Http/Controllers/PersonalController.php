<?php namespace App\Http\Controllers;

use App\Department;
use App\Identifier;
use App\Role;
use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PersonalController extends Controller {

    /**
     * Create a new personal controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth'); //user login validation for all pages
        //$this->middleware('auth',['only'=>'create']);  //only validate create page
//        $this->middleware('auth',['except'=>'index','show']);  //validate all except index page

    }

    public function index()
    {
//        $personal=\Auth::user()->name;
      /*  $personal=\Auth::user();
        //$personal_roles=$personal->roles; //get the collection of roles
        $personal_roles=$personal->roles->first()->role; */ //get the roles of user :)

        $personal = \Auth::user();
//        dd($personal);
//        $personal_roles = \Auth::user()->roles->first()->role;
//        dd($personal_roles);
//        $personal_dept = $personal->departments->department;
//        dd($personal_dept);

        return view('personal.index',compact('personal'));
    }

//    public function create()
    public function staffList()  //for admin
    {
        $dropDown_dept = Department::pluck('department', 'id');
        $dropDown_role = Role::pluck('role', 'id');
//        $dropDown_sv = User::pluck('name', 'id');
        $personal = Role::with('users')->where('role', 'supervisor')->get(); //get sv roles and its users
        $dropDown_sv =  $personal[0]->users->pluck('name', 'id');
//        dd($dropDown_sv);

        $sv_staffs = User::all();


//        return view('personal.staff_list_for_Admin',compact('sv_staffs'));
        return view('personal.staff_list_for_Admin',compact('dropDown_dept','dropDown_role','dropDown_sv','sv_staffs'));
//        return view('personal.create',compact('dropDown_dept','dropDown_role','dropDown_sv'));
    }


    public function staffProfile() //for clerk
    {
//        $sv_staffs=[];
//        $users = User::all();
//        foreach($users as $x)
//        {
//            $role = $x->roles->first()->id;
//            if($role==2 || $role==3) //1-admin,2-staff, 3-supervisor, 4-financial clerk 5-financial manager
//            {
//                array_push($sv_staffs,$x);
//            }
//        }

        //should only sv and staff
        $sv_staffs = User::whereHas('roles',function($q)
        {
            $q->where(function ($query) {
                $query->where('role_id', '=', 2)    //2-staff
                    ->orWhere('role_id', '=', 3);   //3-sv
            });
        })->get();

//        dd($sv_staffs);
        return view('personal.supervisee_list',compact('sv_staffs'));
    }

    public function supervisee()
    {
        //get sv's staff
        $sv = \Auth::user();
        $sv_staffs = $sv->theStaffs;
//        dd($sv_staffs);

        return view('personal.supervisee_list',compact('sv_staffs'));
    }

    public function store(Request $request)
    {
        $inputData = json_decode($request->getContent(), true);  //return as array
//        dd($request);
//        dd($inputData);
        $personal = new User();
        $personal->name = $inputData["name"];
        $personal->noKP = $inputData["noKP"];
        $personal->password = Hash::make($inputData["noKP"]);
        $personal->email = $inputData["email"];
        $personal->homeAddress = $inputData["homeAddress"];
        $personal->dept_id = $inputData["dept_id"];
        $personal->branch = $inputData["branch"];
        $personal->position = $inputData["position"];
        $personal->salary = $inputData["salary"];
        $personal->save();

        $latest = User::all()->last();
        $latest->role = $inputData["role"];
        $latest->department = $latest->departments->department;
        $latest->sv = null;
//        dd($latest);

        DB::table('role_user')->insert(
            array(
                array(
                    'user_id' => $latest->id,
//                    'role_id' => $request->role
                    'role_id' => $inputData["role"]
                ),
            )
        );
//        if($request->role=="2")
        if($inputData["role"]=="2")
        {
            DB::table('supervision')->insert(
                array(
                    array(
                        'staff_id' => $latest->id,
//                        'sv_id' => $request->sv
                        'sv_id' => $inputData["sv"]
                    ),
                )
            );

            $latest->sv = $inputData["sv"];
        }

//        dd($personal);
        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$latest ) );

//        return view('personal.index',compact('personal'));
    }

    public function edit(Request $request,$user_id)
    {
//        $user = User::where('noKP',$inputData['noKP']);
        $user = User::find($user_id);
        $inputData = json_decode($request->getContent(), true);
//        dd($inputData);

        $user->name = $inputData["name"];
        $user->noKP = $inputData["noKP"];
        $user->email = $inputData["email"];
        $user->homeAddress = $inputData["homeAddress"];
        $user->dept_id = $inputData["dept_id"];
        $user->branch = $inputData["branch"];
        $user->position = $inputData["position"];
        $user->salary = $inputData["salary"];
        $user->roles()->sync([$inputData["role"]]);  //belongToMany must use array
//        dd($user->roles);

        if($inputData["role"]=="2")
        {
            $user->theSupervisors()->sync([$inputData["sv"]]);
//            $user->theSupervisors()->sync([4]);
//        dd($user->theSupervisors);
        }
        else
        {
            $user->theSupervisors()->sync([]);
        }

        $user->save();

        $user->role = $inputData["role"];
        $user->department = $user->departments->department;
        $user->sv = null;
        if($inputData["role"]=="2")
        {
            $user->sv = $inputData["sv"];
        }

        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$user ) );
    }

    public function editSalary(Request $request,$user_id)
    {
        $user = User::find($user_id);
        $inputData = json_decode($request->getContent(), true);

        $user->salary = $inputData["salary"];
        $user->save();
//dd($user);
        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$user ) );
    }





    public function password()
    {
//        $personal = \Auth::user();
        return view('auth.edit_password');
    }

    public function updatePassword(Request $request)
    {
        $personal = \Auth::user();
        $inputData = json_decode($request->getContent(), true);  //return as array
        //        echo json_encode( array('status'=>1,'errors'=>'', 'data'=>$inputData ) );

//        $inputData = $request->getContent();  //return string of json
//        $inputData = json_encode($inputData);  //still string
//        dd($inputData);


        if (Hash::check($inputData['oldPassword'], $personal->password)) {
            if(strcmp($inputData['newPassword'],$inputData['confirmPassword'])!==0)  //new password not equal
            {
                echo json_encode( array('status'=>0,'errors'=>'new', 'msg'=>'Kata laluan tidak sama!' ) );
            }
            else{
//                echo json_encode( array('status'=>1,'errors'=>'', 'data'=>json_encode($inputData) ) );
//                $personal->password = Hash::make($inputData['newPassword']);  //forget to save

                //update password
                $personal->fill([
                    'password' => Hash::make($inputData['newPassword'])
                ])->save();

                echo json_encode( array('status'=>1,'errors'=>'', 'msg'=>'Kata laluan telah dikemaskini!' ) );
            }
        }
        else
        {
            echo json_encode( array('status'=>0,'errors'=>'old', 'msg'=>'Kata laluan lama salah!' ) );
        }

//        dd($inputData->oldPassword);

//
//        return view('auth.edit_password',compact('personal'));
    }

//staffSalary index page--for Financial clerk
    public function staffSalary()
    {
        $staff = User::whereHas('roles',function($q)
        {
            $q->where(function ($query) {
                $query->where('role_id', '=', 2)    //2-staff
                    ->orWhere('role_id', '=', 3);   //3-sv
            });
        })->get();

        $month = Identifier::where('type', 'month')->get();
        $dropDown_month = $month->pluck('name', 'code');

        return view('personal.staffSalary',compact('staff','dropDown_month'));
    }

//staffSalary getList--for Financial clerk
    public function getStaffSalary(Request $request)
    {
        $inputData = json_decode($request->getContent(), true);
        $staff = User::whereHas('roles',function($q)
        {
            $q->where(function ($query) {
                $query->where('role_id', '=', 2)    //2-staff
                    ->orWhere('role_id', '=', 3);   //3-sv
            });
        })->get();

        foreach($staff as $x)
        {
            $x->otclaim_total = 0.00;
            $x->travelclaim_total = 0.00;
               $temp_otclaim = $x->claims()->where('type',1) //type 1=OT claim
                                            ->where('status', '=', 3) //status 3=approved
                                            ->where('year', '=', $inputData["year"]) //status 3=approved
                                            ->where('month', '=', $inputData["month"]) //status 3=approved
                                            ->first();
            if($temp_otclaim!=null)
            {
                // claim id
                $x->otclaim_id = $temp_otclaim->id;
                $x->otclaim_total = $temp_otclaim->total;
            }

            $temp_travelclaim = $x->claims()->where('type',2) //type 2=Travel claim
                                                ->where('status', '=', 3) //status 3=approved
                                                ->where('year', '=', $inputData["year"]) //status 3=approved
                                                ->where('month', '=', $inputData["month"]) //status 3=approved
                                                ->first();
            if($temp_travelclaim!=null)
            {
                // claim id
                $x->travelclaim_id = $temp_travelclaim->id;
                $x->travelclaim_total = $temp_travelclaim->total;
            }

            $x->totalSalary = $x->salary + $x->otclaim_total + $x->travelclaim_total;

        }

//        dd($staff);
        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$staff ) );
    }

}