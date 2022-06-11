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
        $dropDown_class = Travelconfig::pluck('vehicleClass', 'id');
        return view('vehicle.index',compact('vehicle','dropDown_class'));
    }

    function store(VehicleRequest $request){
        $vehicle = \Auth::user()->vehicles()->create($request->all());
        $dropDown_class = Travelconfig::pluck('vehicleClass', 'id');
        // flash()->success('Pendaftaran Berjaya.');
        return redirect('vehicle');
    }

    function update($id, Request $request){
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($request->all());
        return back();
    }

}