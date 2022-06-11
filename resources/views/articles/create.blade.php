@extends('master')

@section('content')
    <h1>Write a New Article</h1>

    <hr>

    {!! Form::model($article= new \App\Article, ['url' => 'articles']) !!}
        @include('articles.form',['submitButtonText' => 'Add Article'])
    {!! Form::close() !!}

    <!-- when we say include, we got to views folder -->
    @include('errors.list')

@endsection