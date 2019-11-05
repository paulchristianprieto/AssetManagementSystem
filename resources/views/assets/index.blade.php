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
										&#8369; {{ $asset->category }}
									</strong>
								</p>
								
							</div>
						</div>
					@endforeach
				</div>


			</div>
		</div>
	</div>


@endsection