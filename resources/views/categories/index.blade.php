@extends('layouts.app')

@section('content')


<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-md-8 offset-2">


			<h2 class="text-center">Categories </h2>

			@if (Session::has('destroy_success'))
				<div class="row">
					<div class="col-12">
						<div class="alert alert-success">
							{{ Session::get('destroy_success') }}
						</div>
					</div>
				</div>
			@endif
			{{-- Navigation --}}
			<nav>
				<ul class="nav nav-tabs">
					@foreach($categories as $category)
						<li class="nav-item">
							<a class="nav-link {{ ($category->id == $category_id) ? 'active font-weight-bold':''}} " href="{{route('category_filtered_assets', ['category_id' => $category->id]) }}">{{$category->name}}</a>
						</li>
					@endforeach
				</ul>
			</nav>

			@foreach($assets as $asset)

			<div class="card col-4"> 
				<div class="card-header">{{ $asset->sku_number }}</div>
				<img class="card-img-top" src="{{ url('/public/' . $asset->image) }}" style="height: 150px;">
				<div class="card-body">
					<h5 class="card-title">{{ $asset->name }}</h5>
					<p class="card-text">{{ $asset->category->name }}
						<span class="card-text badge float-right {{ ($asset->available == 1)? 'badge-success': 'badge-danger' }} ">
							{{ ($asset->available == 1) ? "Available: ": "Not Available: "}} {{$asset->quantity_available}} 
						</span>
					</p>
				</div>
				<div class="card-footer">
					<a href="{{ route('assets.show', ['asset' => $asset->id]) }}" class="btn btn-primary btn-outline-primary float-right"><small class="text-muted">View Item</small></a>
				</div>
			</div>
			@endforeach
		</div>

		@can('isAdmin')
		<div class="col-12 col-md-2">
			<form action="{{ route('categories.store') }}" method="POST">
				@csrf
				<div class="form-group">
				    <label for="category" class="bmd-label-floating">Category</label>
				    <input type="text" class="form-control" id="category" name="name">
				</div>
				<div class="form-group">
				    <label for="category_sku" class="bmd-label-floating">Category Code:</label>
				    <input type="text" class="form-control" id="category_sku" name="category_sku">
				    <span class="bmd-help">Ex. Monitor = MON</span>
				</div>
				<div class="row">
					<button class="btn btn-light bg-success col-10 mx-auto my-2">Add Category</button>
				</div>
			</form>
		</div>
		@endcan

	</div>
</div>


@endsection