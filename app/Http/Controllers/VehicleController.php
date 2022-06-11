<?php namespace App\Http\Controllers;

use App\Travelconfig;
use App\Vehicle;
use App\Http\Requests\VehicleRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class VehicleController extends Controller {

    public function index()
    {
        $vehicle = \Auth::user()->vehicles;
        $dropDown_class = Travelconfig::lists('vehicleClass', 'id');
        return view('vehicle.index',compact('vehicle','dropDown_class'));
    }

    function store(VehicleRequest $request){
//        dd($request->all());
        $vehicle = \Auth::user()->vehicles()->create($request->all());
        $dropDown_class = Travelconfig::lists('vehicleClass', 'id');
        flash()->success('Pendaftaran Berjaya.');
//        $this->createArticle($request);
//
//        flash()->success('Your article has been created');
//
//        return redirect('vehicle',compact('vehicle','dropDown_class'));
        return redirect('vehicle');
    }

    function update($id, Request $request){
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($request->all());

//        response()->json($vehicle);
        return back();
    }

}
