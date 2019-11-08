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
			<div class="col-12 col-md-10 mx-auto">
				<div class="row">
					<div class="col-12 col-md-6 mx-auto">
						<div class="card shadow p-3 mb-5 bg-white rounded">
							<img 
							src="{{ url('/public/' . $asset->image )  }}" 
							class="card-img-top"
							>
							<h5 class="card-title">
								{{ $asset->name }}
							</h5>
							<p class="card-subtitle">
								<strong>
									{{ $asset->category->name }}
								</strong>
							</p>
							<div class="card-body">
								<p class="card-text">{{ $asset->category->name }}
									<span class="card-text badge float-right {{ ($asset->available == 1)? 'badge-success': 'badge-danger' }} ">
										{{ ($asset->available == 1) ? "Available: ": "Not Available: "}} {{$asset->quantity_available}} 
									</span>
								</p>
							</div>

							<div class="row card-footer">
								{{-- <form class="col-4" action="{{ route('assets.show', ['asset' => $asset->id])}} " method="GET">
									@csrf
									<button class="btn btn-info btn-raised btn-block mt-3">View</button>
								</form> --}}

								<form class="col-8" action="{{ route('assets.edit', ['asset' => $asset->id])}} " method="GET">
									@csrf
									<button class="btn btn-info btn-raised btn-block mt-3">Edit</button>
								</form>
								

								<form class="col-4" action="{{ route('assets.destroy', ['asset' => $asset->id ])}} " method="POST">
									@csrf
									@method('DELETE')
									<button class="btn btn-danger btn-raised btn-block mt-3">Delete</button>
								</form>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection