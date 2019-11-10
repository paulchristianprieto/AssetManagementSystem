@extends('layouts.app')

@section('content')

<div class="container-fluid ">

	@if (Session::has('destroy_success'))
		<div class="row">
			<div class="col-12">
				<div class="alert alert-success">
					{{ Session::get('destroy_success') }}
				</div>
			</div>
		</div>
	@endif

	
	<div class="row side-panel" >
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
			</div>
			
		</div>

		<div class="col-12 col-md-8 mx-auto py-3">
			<div class="row">
				<div class="col-12 col-md-8 mx-auto text-center">
					<h2>Vendors</h2>
				</div>
			</div>
			<hr>

			<div class="row">
				<div class="accordion col-12" id="vendorsAccordion">

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
							<div class="float-right col-2 text-center">
								<span>
									<a href="{{ route('vendors.show', ['vendor' => $vendor->id])}}" class="btn btn-dark bg-info btn-raised">View</a>
								</span>
								<span>
									<a href="{{ route('vendors.edit', ['vendor' => $vendor->id])}}" class="btn btn-dark bg-warning btn-raised">Edit</a>
								</span>
							</div>
						</div>

					</div>

					<div id="vendor-{{$vendor->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#vendorsAccordion">
						<div class="card-body ">
							{{-- {{ dd($assets) }} --}}
							<h4 class="card-title text-center">{{$vendor->name }}'s Products </h4>
							
							<div class="container-fluid">
								<div class="row">
									@foreach($assets as $asset)

										@if($asset->vendor->id == $vendor->id)
											<div class="col-4 p-2 mx-auto">
												<div class="card {{-- col-4 m-2 mx-auto --}} shadow p-3 mb-5 bg-white rounded">
													<div class="wrapper">
														<img class="card-img-top img-fluid" src="{{ url('/public/' . $asset->image) }}" alt="{{ $asset->name}}">
													</div>
													<h4 class="card-title text-center">{{ $asset->name }}</h4>
													<div class="row">
														<div class="col-12 mx-auto text-center">
															<span class="card-text badge  {{ ($asset->available == 1)? 'badge-success': 'badge-danger' }} ">
																{{ ($asset->available == 1) ? "Available: ": "Not Available: "}} {{$asset->quantity_available}} 
															</span>
															<span class="card-text badge  badge-warning">
																Lent: {{ $lent_items[$asset->id] }}
																{{-- {{ ($asset->available == 1) ? "Available: ": "Not Available: "}} {{$asset->quantity_available}}  --}}
															</span>
														</div>
													</div>
													<div class="card-body">
														<p class="card-text">Category: <strong class="float-right">{{ $asset->category->name }} </strong>
															
														</p>
														<p class="card-text">Vendor: <strong class="float-right">{{ $asset->vendor->name }} </strong>
															
														</p>
														<p class="card-text">SKU: <strong class="float-right" >{{ $asset->sku_number }}</strong></p>
														<p class="card-text">Condition: <strong class="float-right" >{{ $asset->asset_status->name }}</strong></p>
														<p class="card-text">Description: <strong class="float-right" >{{ $asset->description }}</strong></p>
														
														<div class="card-footer bg-transparent row ">
															<div class="col-6">
																<a href="{{ route('assets.show', ['asset' => $asset->id]) }}" class="btn btn-primary btn-block ">View Item</a>
															</div>
															<div class="col-6">
																<a href="{{ route('assets.edit', ['asset' => $asset->id]) }}" class="btn btn-warning btn-block ">Edit Item</a>
															</div>
															
														</div>
													</div>
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
		</div>
	</div>
</div>
			


@endsection