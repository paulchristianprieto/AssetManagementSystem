@extends('layouts.app')

@section('content')
	

	<p>Name: {{ $category->name }} </p>
	<p>Description: {{ $category->description }} </p>
	<p>Category code: {{ $category->category_sku }} </p>
	
@endsection