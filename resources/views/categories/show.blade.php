@extends('layouts.app')

@section('content')
	
<div class="container-fluid">
	<div class="row side-panel">
		<div class="col-2 bg-dark p-4">
			<div class="sticky-top">
				<div class="row m-4 " style="color:white;">
					<div class="col-12 text-center p-3" style="font-size: 24px;">
						<i class="far fa-user fa-5x"></i>
					</div>
					<div class="col-12 text-center">
						<h5 class="mt-2">{{Auth::user()->name}} </h5>
						<p>{{Auth::user()->email}} </p>
						<p>{{Auth::user()->role->name}} </p>
					</div>
				</div>
				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
					<a class="nav-link" href="{{ route('assets.create') }}"><i class="fas fa-plus-circle"></i> Add Asset</a>
					<a class="nav-link" href="{{ route('vendors.create') }}"><i class="fas fa-plus-circle"></i> Add Vendor</a>
					<a class="nav-link" href="{{ route('categories.create') }}"><i class="fas fa-plus-circle"></i> Add Category</a>
				</div>
				<p class="nav-link mb-0 mt-2">View Category: </p>
				@foreach($categories as $indiv_category)
					<a class="nav-link" href="{{ route('categories.show', ['category'=> $indiv_category->id]) }}">{{$indiv_category->name}}</a>
				@endforeach
			</div>
		</div>

		<div class="col-12 col-md-6 mx-auto py-3">
			<h3 class="text-center">
				Category Information
			</h3>
			<div class="row mt-4 shadow p-3 mb-5 bg-white rounded-lg">
				<div class="col-10 mx-auto">
					<div class="row mt-2">
						<div class="col-5 mx-auto text-left">
							<h5>Category Name:</h5> 
						</div>
						<div class="col-7 mx-auto text-right">
							<h4 class="float-right" >{{ $category->name }}</h4>
						</div>
					</div>
					@if($category->description)
					<div class="row mt-2">
						<div class="col-5 mx-auto text-left">
							<h5>Category Description:</h5> 
						</div>
						<div class="col-7 mx-auto text-right">
							<h4 class="float-right" >{{ $category->description }}</h4>
						</div>
					</div>
					@endif
					<div class="row mt-2">
						<div class="col-5 mx-auto text-left">
							<h5>Category Code:</h5> 
						</div>
						<div class="col-7 mx-auto text-right">
							<h4 class="float-right" >{{ $category->category_sku }}</h4>
						</div>
					</div>
					@can('isAdmin')
					<div class="card-footer bg-transparent row">
						<form class="col-8" action="{{ route('categories.edit', ['category' => $category->id]) }}" method="GET">
							@csrf
							<button class="btn btn-info btn-block mt-3">Edit</button>
						</form>
						<form class="col-4" action="{{ route('categories.destroy', ['category' => $category->id ])}}" method="POST">
							@csrf
							@method('DELETE')
							<button class="btn btn-danger btn-block mt-3">Delete</button>
						</form>
					</div>
					@endcan
				</div>
			</div>
		</div>
	</div>
</div>
@endsection