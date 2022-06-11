<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\FooRepository;
use Illuminate\Http\Request;

class FooController extends Controller {

    //constructor injection
/*    private $repository;

    public function __construct(FooRepository $repository)
    {

        $this->repository = $repository;
    }

    public function  foo()
    {
        //this is not a good practice, hence create a constructor
        //$repository = new \App\Repositories\FooRepository();

        return $this->repository->get();
    }*/

    //if u require the repository once, use method injection
    //else use constructor injection

    //method injection
    public function  foo(FooRepository $repository)
    {
        return $repository->get();
    }

}
