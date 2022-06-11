<?php namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests;
use App\Http\Requests\ArticleRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
//use Illuminate\Http\Request;
//use Request;

class ArticlesController extends Controller {

    /**
     * Create a new articles controller instance.
     */
    public function __construct()
    {
        //$this->middleware('auth'); //user login validation for all pages
        //$this->middleware('auth',['only'=>'create']);  //only validate create page
        $this->middleware('auth',['except'=>'index','show']);  //validate all except index page

    }
    function index(){
        //return \Auth::user()->name; //return session user's name
        //$articles=Article::all();  //get all
        //$articles=Article::latest()->get();   //get latest one //always order by descending
        //$articles=Article::latest()->where('published_at','<=',Carbon::now())->get();   //get latest one //always order by descending //where published_at <= today

        //$articles=Article::latest('published_at')->published()->get();   //get latest one //always order by descending //where published_at <= today
        $articles=\Auth::user()->articles()->latest('published_at')->published()->get(); //This will get articles that associate with session user
        //$articles=Article::orderBy('created_at','desc')->get();   //get latest one //always order by descending
	    //return response()->json($articles);

        //$latest = Article::latest()->first();
        //return view('articles.index',compact('articles','latest'));

        return view('articles.index',compact('articles'));

        //return view('articles.index')->with('articles',$articles);

    }

//    function show($id){
//        //$article=Article::findOrFail($id);  //If fail, echo ModelNotFoundException
//        $article=\Auth::user()->articles()->findOrFail($id);  //If fail, echo ModelNotFoundException  //only allow owner to view the article
//
//        //dd($article->published_at->addDays(1)->diffForHumans());
//        /*
//        $article=Article::find($id);
//        if(is_null($article))
//        {
//            Abort(404);
//        }
//        */
//        //dd('show');  //work like console.log('show'); :)
//        return view('articles.show',compact('article'));
//        //dd($article); //get element in json? or null
//        //return $article;
//    }

    public function show(Article $article)
    {
        return view('articles.show',compact('article'));
    }

    function create(){
        /*
        if(\Auth::guest())
        {
            return redirect('articles');
        }
        */
        //$tags = \App\Tag::all();
        $tags = \App\Tag::lists('name','id');
        return view('articles.create', compact('tags'));
    }
    function store(ArticleRequest $request){
        //$input =  Request::get('title');
        //return $input;

        /*
        $article = new Article();
        $article->title=$input['title'];
        $article->body=$input['body'];
        */

        //$article = new Article(['title' => $input['title'], 'body'=>$input['body']]);
        //return $article;
/*
        $input = Request::all();
        $input['published_at']=Carbon::now();
        Article::create($input);
        return redirect('articles');
*/
        /*
        $article = new Article($request->all());
        \Auth::user()->articles()->save($article); //This will simply create an article having user id
        */
        //array_add()
        //dd($request->input('tags'));
        $this->createArticle($request);

        /*
         $requestObj = $request->all();
         $requestObj['user_id']=Auth::user()->id;
         */
        //Auth::user();  //this refer to person who are currently signed in
        //Article::create($request->all());
/*
        //\Session::flash('flash_message','Your article has been created!');
        session()->flash('flash_message','Your article has been created!');
        session()->flash('flash_message_important',true);
        return redirect('articles');
  */
        /*
        return redirect('articles')->with([
            'flash_message'=>'Your article has been created!',
            'flash_message_important'=>true
         ]);
        */
        flash()->success('Your article has been created');
        //flash()->overlay('Your article has been successfully created!','Good Job'); //green colour

        return redirect('articles');
        //return Carbon::now();
    }
//    function edit($id){
    public function edit(Article $article){
        $tags = \App\Tag::lists('name','id');
//        $article=Article::findOrFail($id);
        return view('articles.edit',compact('article','tags'));
    }

    function update(Article $article, ArticleRequest $request){
        $article->update($request->all());
        $this->syncTags($article,$request->input('tag_list'));
        return redirect('articles');
    }

    /**
     * Sync up the list of tags in Database.
     *
     * @param ArticleRequest $request
     * @param $article
     */
    public function syncTags(Article $article, array $tags)
    {
        $article->tags()->sync($tags);
    }

    /**
     * Save a new article.
     *
     * @param ArticleRequest $request
     * @return mixed
     */
    private function createArticle(ArticleRequest $request)
    {
        $article = \Auth::user()->articles()->create($request->all()); //This will simply create an article having user id

        $this->syncTags($article,$request->input('tag_list'));

        return $article;
    }
}
