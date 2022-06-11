<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PagesController extends Controller {

	//
	public function about()
	{
		//$name ='Kella <span style="color:pink;">Ong</span>';
		//return view('pages.about')->with('name',$name);
		/*
		return view('pages.about')->with([
			'first'=>'Kella',
		 	'last'=>'Ong' 
		]);
		*/
		/*
		$data=[];
		$data['first']='Happy';
		$data['last']='Meal';
		return view('pages.about',$data);
		*/
		/*
		$first='Happy';
		$last='Meal';
		return view('pages.about',compact('first','last'));
		*/
		
		//$people = [];

		$people = [
			'Stacy :0','Stacy ^_^', 'Stacy :D'
		];

		return view('pages.about',compact('people'));
	}

}
