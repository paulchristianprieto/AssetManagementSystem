@extends('layouts.app')

@section('content')


<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-md-8 offset-2">

			<h2 class="text-center">Vendors</h2>

			@if (Session::has('destroy_success'))
				<div class="row">
					<div class="col-12">
						<div class="alert alert-success">
							{{ Session::get('destroy_success') }}
						</div>
					</div>
				</div>
			@endif

			<div class="accordion" id="vendorsAccordion">

				@foreach ($vendors as $vendor)
				{{-- {{ dd($vendor) }} --}}

				<div class="card shadow bg-white rounded">
					<a data-toggle="collapse" data-target="#vendor-{{$vendor->id }}" aria-expanded="false" aria-controls="collapseOne"> 
						<div class="card-header" id="headingOne">
							<div class="mb-0">

								<span class="float-left">{{$vendor->name }}</span> {{-- / {{ $vendor->created_at->format('F d, Y - h:i') }}   --}}
								
								{{-- actions --}}
								<div class="float-right">
									<span>
										<a href="{{ route('vendors.show', ['vendor' => $vendor->id])}}" class="btn btn-secondary my-1 ">View</a>
									</span>

									<span>
										<a href="{{ route('vendors.edit', ['vendor' => $vendor->id])}}" class="btn btn-warning my-1 ">Edit</a>
									</span>

									<span class="float-right">
										<form action="{{ route('vendors.destroy', ['vendor' => $vendor->id ])}} " method="POST">
											@csrf
											@method('DELETE')
											<button class="btn btn-danger my-1">Remove</button>
										</form>
									</span>
								</div>
								
							</div>

						</div>
					</a>

					<div id="vendor-{{$vendor->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#vendorsAccordion">
						<div class="card-body">
							<h5 class="card-title text-center">Items</h5>

							<a href="{{ route('vendors.show', ['vendor' => $vendor->id])}}" class="btn btn-secondary btn-block my-1">View</a>

							<a href="{{ route('vendors.edit', ['vendor' => $vendor->id])}}" class="btn btn-warning btn-block my-1">Edit</a>

							<form action="{{ route('vendors.destroy', ['vendor' => $vendor->id ])}} " method="POST">
								@csrf
								@method('DELETE')
								<button class="btn btn-danger btn-block my-1">Remove</button>
							</form>
							
							<div class="container-fluid">
								<div class="row">
									@foreach($assets as $asset)
										{{-- {{dd($asset->vendor->id)}} --}}
										@if($asset->vendor->id == $vendor->id)
											<div class="col-12 col-md-6 card">
												<div class="card-img-top">
													<img class="img-thumbnail" src="{{ url('/public/' . $asset->image) }}" alt="">
												</div>
												<div class="card-title">
													{{ $asset->name }}
												</div>
											</div>
										@endif
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>

				@endforeach

			</div>
		</div>

		<div class="col-12 col-md-2">
			<p>Add Vendor <span><a href=" {{ route('vendors.create') }} " class="btn btn-success rounded-circle" >+</a></span></p>
		</div>

	</div>
</div>


@endsection