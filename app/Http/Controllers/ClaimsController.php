<?php namespace App\Http\Controllers;

use App\Claim;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ClaimsController extends Controller {

//    public function create()
//    {
//        $personal = \Auth::user();
//        $state = "add";
////        $claim=$personal->claims->first();
////        $otClaim = $claim->otclaim->first();
////        dd($otClaim);
//        return view('claimOverTime.create',compact('personal','state'));
//    }


    public function edit(Request $request,$claim_id)
    {
        $inputData = json_decode($request->getContent(), true);
        $claim = Claim::find($claim_id);

        $claim->total = $inputData['claim_total'];
        $claim->status = $inputData['claim_status'];

        $claim->save();

        return response()->json($claim);
    }

    function store(Request $request)
    {
        $inputData = json_decode($request->getContent(), true);
        $claim = \Auth::user()->claims()->create($inputData); //This will simply create an article having user id
        //must make sure the $request object properties is same as Claims() properties
        return  response()->json(array('success' => true, 'last_insert_id' => $claim->id), 200);

    }

    public function updateClaimStatus(Request $request,$id)
    {
        $inputData = json_decode($request->getContent(), true);
//        dd($request);
//        dd($request->getContent());
//        dd($inputData["status"]);
        $claim= Claim::find($id);
        $claim->toArray();
        $claim->status=$inputData["status"];
        $claim->save();

        echo json_encode( array('status'=>1,'errors'=>'', 'message'=>'OK','data'=>$claim ) );
    }


}
