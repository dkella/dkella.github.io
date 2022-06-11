<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 2/22/16
 * Time: 2:23 PM
 */

namespace App\Http\composers;


use Illuminate\Contracts\View\View;

class NavigationComposer {

    public function __construct()
    {

    }
    public function compose(View $view)
    {
        //$view->with('latest',\App\Article::with->join()->where()->first());
        //include something or join something, or when there is specific condition
        //$view->with('latest',$this->articles->ofSomeType());
        $view->with('latest',\App\Article::latest()->first());
    }
} 