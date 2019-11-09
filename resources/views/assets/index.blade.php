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

		<div class="row">
			<div class="col-12 col-md-8 mx-auto text-center">
 
				<h2>Assets</h2>

				
			</div>
		</div>
		<div class="row">
			<div class="col-2">
				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
					<a class="nav-link" href="{{ route('assets.create') }}">Add Asset</a>

					<p class="nav-link">Filter By Categories: </p>
					{{-- {{dd($categories)}} --}}
					@foreach($categories as $category)
						<a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">{{$category->name}}</a>
					@endforeach

					<p class="nav-link">Filter By Vendors: </p>
					@foreach($vendors as $vendor)
						<a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">{{$vendor->name}}</a>
					@endforeach
				</div>
			</div>

			<div class="col-12 col-md-8 ">
				<div class="row">
					@foreach ($assets as $asset)
						<div class="card col-4 m-2 mx-auto shadow p-3 mb-5 bg-white rounded">
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
					@endforeach
				</div>


			</div>
		</div>
	</div>


@endsection