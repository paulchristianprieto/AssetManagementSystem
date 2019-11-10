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
			@if (Session::has('destroy_success'))
				<div class="row">
					<div class="col-12">
						<div class="alert alert-success">
							{{ Session::get('destroy_success') }}
						</div>
					</div>
				</div>
			@endif
			<div class="row mt-4 shadow p-3 mb-5 bg-white rounded-lg">
				<div class="col-4">
					<div class="wrapper">
						<img class="card-img-top img-fluid" src="{{ url('/public/' . $asset->image) }}" alt="{{ $asset->name}}">
					</div>
				</div>
				<div class="col-8 p-4">
					<div class="row">
						<div class="col-12">
							<h2 class="card-title float-right text-uppercase"><strong>{{ $asset->name }}</strong></h2>
						</div>
					</div>

					<div class="row">
						<div class="col-12 mx-auto text-right">
							<h5>
								<span class="card-text badge  {{ ($asset->available == 1)? 'badge-success': 'badge-danger' }} ">
									{{ ($asset->available == 1) ? "Available: ": "Not Available: "}} {{$asset->quantity_available}} 
								</span>
							</h5>
						</div>
						<div class="col-12 mx-auto text-right">
							<h5>
								<span class="card-text badge badge-warning">
									Lent: {{ $lent_items[$asset->id] }}
									{{-- {{ ($asset->available == 1) ? "Available: ": "Not Available: "}} {{$asset->quantity_available}}  --}}
								</span>
							</h5>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-4 mx-auto text-left">
							<h5>Quantity Owned:</h5> 
						</div>
						<div class="col-8 mx-auto text-right">
							<h4 class="float-right" ><strong>{{ $lent_items[$asset->id] + $asset->quantity_available }}</strong></h4>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-4 mx-auto text-left">
							<h5>Asset SKU:</h5> 
						</div>
						<div class="col-8 mx-auto text-right">
							<h4 class="float-right text-uppercase" ><strong>{{ $asset->sku_number }}</strong></h4>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-4 mx-auto text-left">
							<h5>Asset Category:</h5> 
						</div>
						<div class="col-8 mx-auto text-right">
							<h4 class="float-right" ><strong>{{ $asset->category->name }}</strong></h4>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-4 mx-auto text-left">
							<h5>Asset Vendor:</h5> 
						</div>
						<div class="col-8 mx-auto text-right">
							<h4 class="float-right" ><strong>{{ $asset->vendor->name }}</strong></h4>
						</div>
					</div>
					
					<div class="row mt-2">
						<div class="col-4 mx-auto text-left">
							<h5>Asset Description:</h5> 
						</div>
						<div class="col-8 mx-auto text-right">
							<h4 class="float-right" ><strong class="float-right" >{{ $asset->description }}</strong></h4>
						</div>
					</div>
					<div class="row mt-2">
						<div class="col-4 mx-auto text-left">
							<h5>Asset Status:</h5> 
						</div>
						<div class="col-8 mx-auto text-right">
							<h4 class="float-right" ><strong class="float-right" >{{ $asset->asset_status->name }}</strong></h4>
						</div>
					</div>
					@can('isAdmin')
					<div class="card-footer bg-transparent row">
						<form class="col-8" action="{{ route('assets.edit', ['asset' => $asset->id]) }}" method="GET">
							@csrf
							<button class="btn btn-info btn-block mt-3">Edit</button>
						</form>
						<form class="col-4" action="{{ route('assets.destroy', ['asset' => $asset->id ])}}" method="POST">
							@csrf
							<button class="btn btn-danger btn-block mt-3">Delete</button>
						</form>
					</div>
					@endcan
				</div>
				
			</div>
		</div>
	</div>
</div>
	
@endsection