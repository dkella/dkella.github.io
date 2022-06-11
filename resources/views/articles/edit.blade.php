@extends('master')

@section('content')
    <h1>Edit: {{ $article->title}}</h1>
    <hr>

    {!! Form::model($article,['method' => 'PATCH', 'action' => ['ArticlesController@update',$article->id]]) !!}
        @include('articles.form',['submitButtonText'=>'Update Article'])
    {!! Form::close() !!}

    <!-- when we say include, we got to views folder -->
    @include('errors.list')

@endsection