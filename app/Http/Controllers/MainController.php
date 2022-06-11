<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller {

    public function index()
    {
//        if(\Auth::guest())
//        {
//            return redirect('/login');
//        }
        $month = DB::table('identifiers')->where('type', 'month')->get();
        return view('auth.staff_index',compact('month'));
    }


}