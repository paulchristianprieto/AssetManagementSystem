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
						<div class="col-12 col-md-4">
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
								<a href="{{ route('assets.show', ['asset' => $asset->id])}}" class="btn btn-secondary btn-block my-1">View</a>

								<a href="{{ route('assets.edit', ['asset' => $asset->id])}}" class="btn btn-warning btn-block my-1">Edit</a>

								<form action="{{ route('assets.destroy', ['asset' => $asset->id ])}} " method="POST">
									@csrf
									@method('DELETE')
									<button class="btn btn-danger btn-block my-1">Remove</button>
								</form>
							</div>

						</div>
					@endforeach
				</div>


			</div>
		</div>
	</div>


@endsection