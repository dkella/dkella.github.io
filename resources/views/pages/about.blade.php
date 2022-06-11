@extends('master')

@section('content')
	@if (!isset($first))
		<h1>About Kella </h1>
	@else
		<h1>About: {{ $first }} {{ $last }}</h1> <!-- escape style or script alert, no semicolon(;) after $name-->
	@endif
	
	
	{{-- @if(!empty($people))   --}} {{--comment --}}
	@if(count($people))
	<h3>People I Like to bully:</h3>
	<ul>
		@foreach ($people as $person)
		<li>{{$person}}</li>
		@endforeach
	</ul>
	@endif
 	
 
	<p>Whether you're building your own website or are just browsing for information on a business, 
	organization, or individual, the 'About Us' page is a vital part of ...</p>
@endsection