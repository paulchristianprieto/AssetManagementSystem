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
					<a class="nav-link" href="{{ route('assets.create') }}">Add Asset</a>
					<a class="nav-link" href="{{ route('vendors.create') }}">Add Vendor</a>
					<a class="nav-link" href="{{ route('categories.create') }}">Add Category</a>
				</div>
			</div>
		</div>

		<div class="col-12 col-md-8 mx-auto py-3">
			<h3 class="text-center">
				Edit Vendor Info
			</h3>
			<hr>
			@if(Session::has('update_failed'))
				<div class="alert alert-warning">
					{{ Session::get('update_failed') }}
				</div>
			@endif

			@if (Session::has('update_success'))
				<div class="alert alert-success">
					{{ Session::get('update_success') }}
				</div>
			@endif

		</div>
	</div>
</div>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-md-8 mx-auto">
				<h3 class="text-center">
					Edit Vendor Info
				</h3>
				<hr>
				@if(Session::has('update_failed'))
					<div class="alert alert-warning">
						{{ Session::get('update_failed') }}
					</div>
				@endif

				@if (Session::has('update_success'))
					<div class="alert alert-success">
						{{ Session::get('update_success') }}
					</div>
				@endif
				<form action="{{ route('categories.update', ['category' => $category->id]) }} " method="POST" enctype="multipart/form-data" >
					@csrf
					@method('PUT')
					
					<div class="form-group">
					    <label for="category" class="bmd-label-floating">Category:</label>
					    <input type="text" class="form-control" id="category" name="name" value="{{ $category->name }}">
					</div>

					<div class="form-group">
					    <label for="category_sku" class="bmd-label-floating">Category Code:</label>
					    <input type="text" class="form-control" id="category_sku" name="category_sku" value="{{ $category->category_sku }}">
					    <span class="bmd-help">Ex. Monitor = MON</span>
					</div>

					<div class="form-group">
						<label for="description">Category Description (optional):</label>
						<textarea 
							name="description" 
							id="description" 
							class="form-control" 
							min="1" 
							cols="30" 
							rows="10"
						>{{ $category->description }}</textarea>
					</div>
					

					<button class="btn btn-dark btn-block">Save & Update</button>

				</form>
			</div>
			

		</div>
	</div>

@endsection