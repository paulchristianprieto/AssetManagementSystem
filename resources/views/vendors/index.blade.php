@extends('layouts.app')

@section('content')


<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-md-9 mx-auto">

			<h2 class="text-center">Vendors <span><a href=" {{ route('vendors.create') }} " class="btn btn-light rounded-circle bg-success"><strong>+</strong></a></span></h2>

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
					<div class="card-header" id="headingOne">
						<div class="row">
							<div class="col-10">
								<button 
									class="btn btn-block text-left" 
									type="button" 
									data-toggle="collapse" 
									data-target="#vendor-{{$vendor->id }}" 
									aria-expanded="false" 
									aria-controls="collapseOne">
									<h5 class="btn-block"><strong><span class="float-left">{{$vendor->name }}</span></strong></h5> 
									
								</button>
							</div>
							
							
							{{-- actions --}}
							<div class="float-right col-2">
								<span>
									<a href="{{ route('vendors.show', ['vendor' => $vendor->id])}}" class="btn btn-dark bg-info btn-raised">View</a>
								</span>

								<span>
									<a href="{{ route('vendors.edit', ['vendor' => $vendor->id])}}" class="btn btn-dark bg-warning btn-raised">Edit</a>
								</span>

								{{-- <span class="float-right">
									<form action="{{ route('vendors.destroy', ['vendor' => $vendor->id ])}} " method="POST">
										@csrf
										@method('DELETE')
										<button class="btn btn-danger border-0">Remove</button>
									</form>
								</span> --}}
							</div>
						</div>

					</div>

					<div id="vendor-{{$vendor->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#vendorsAccordion">
						<div class="card-body">
							{{-- {{ dd($assets) }} --}}
							<h6 class="card-title text-center">{{$vendor->name }}'s Products </h6>
							
							<div class="container-fluid">
								<div class="row">
									<div class="card-group">
									@foreach($assets as $asset)

										@if($asset->vendor->id == $vendor->id)
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
										@endif

									@endforeach
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				@endforeach

			</div>
		</div>

		

	</div>
</div>


@endsection