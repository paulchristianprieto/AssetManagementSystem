@extends('layouts.app')


@section('content')
	<div class="container">
		@if (Session::has('destroy_success'))
			<div class="row">
				<div class="col-12">
					<div class="alert alert-success">
						{{ Session::get('destroy_success') }}
					</div>
				</div>
			</div>
		@endif

		<div class="row">
			<div class="col-md-10 mx-auto text-center">

				<h2>Assets <span><a href=" {{ route('assets.create') }} " class="btn btn-light rounded-circle bg-success"><strong>+</strong></a></span></h2>

				
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-10 mx-auto">
				<div class="row">
					@foreach ($assets as $asset)
						<div class="col-12 card col-md-4"> 
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


			</div>
		</div>
	</div>


@endsection