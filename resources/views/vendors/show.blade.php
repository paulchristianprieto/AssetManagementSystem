@extends('layouts.app')

@section('content')
	

	<p>Name: {{ $vendor->name }} </p>
	<p>Description: {{ $vendor->description }} </p>
	<p>Address: {{ $vendor->address }} </p>
	<p>Company Email: {{ $vendor->company_email }} </p>
	
@endsection