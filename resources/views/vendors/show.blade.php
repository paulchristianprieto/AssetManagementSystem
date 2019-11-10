@extends('layouts.app')

@section('content')

{{-- 	"id" => 1
	"name" => "HP"
	"vendor_sku" => "HP"
	"image" => "images/2019-11-07-07-17-20_P4qksaM9Pn_onepiece-bg.jpeg"
	"address" => "Intellectual Property Center, Upper Mc Kinley Road, ,McKinley Hill Cyberpark, Taguig, 1634 Metro Manila"
	"company_email" => "helpdesk@hp.com"
	"description" => "At HP we don't just believe in the power of technology. We believe in the power of people when technology works for them."
	"created_at" => null
	"updated_at" => "2019-11-07 07:17:20"
	"deleted_at" => null --}}

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
					<a class="nav-link" href="{{ route('assets.create') }}"><i class="fas fa-plus-circle"></i> Add Asset</a>
					<a class="nav-link" href="{{ route('vendors.create') }}"><i class="fas fa-plus-circle"></i> Add Vendor</a>
					<a class="nav-link" href="{{ route('categories.create') }}"><i class="fas fa-plus-circle"></i> Add Category</a>
				</div>
				
			</div>
		</div>

		<div class="col-12 col-md-8 mx-auto py-3">
			<div class="card bg-light shadow mb-5 rounded-lg">
				<h1 class="text-center card-header ">Vendor Information</h1>
				<div class="row card-img-top p-5">
					@if($vendor->image)
					<div class="col-6">
						<img src="{{ url('/public/' . $vendor->image)  }}" class="img-thumbnail">
					</div>
					<div class="col-6">
						<div class="row">
							<div class="col-4 mt-2">
								<h4 class=""><small>Vendor Name:</small></h4>
							</div>
							<div class="col-8 ">
								<h4 class=""><strong>{{ $vendor->name }}</strong></h4>
							</div>

							<div class="col-4 mt-2">
								<h4 class=""><small>Vendor SKU:</small></h4>
							</div>
							<div class="col-8 ">
								<h4 class=""><strong>{{ $vendor->vendor_sku }}</strong></h4>
							</div>

							<div class="col-4 mt-2">
								<h6 class=""><small>Vendor Address:</small></h6>
							</div>
							<div class="col-8 ">
								<h6 class=""><strong>{{ $vendor->address }}</strong></h6>
							</div>

							<div class="col-4 mt-2">
								<h6 class=""><small>Vendor Email:</small></h6>
							</div>
							<div class="col-8 ">
								<h6 class=""><strong>{{ $vendor->company_email }}</strong></h6>
							</div>

							<div class="col-4 mt-2">
								<h6 class=""><small>Description:</small></h6>
							</div>
							<div class="col-8 ">
								<h6 class=""><strong>{{ $vendor->description }}</strong></h6>
							</div>
						</div>
					</div>
					@else
					<div class="col-12">
						<div class="row">
							<div class="col-4 mt-2">
								<h4 class="">Vendor Name:</h4>
							</div>
							<div class="col-8 ">
								<h4 class=""><strong>{{ $vendor->name }}</strong></h4>
							</div>

							<div class="col-4 mt-2">
								<h4 class="">Vendor SKU:</h4>
							</div>
							<div class="col-8 ">
								<h4 class=""><strong>{{ $vendor->vendor_sku }}</strong></h4>
							</div>

							<div class="col-4 mt-2">
								<h5 class="">Vendor Address:</h5>
							</div>
							<div class="col-8 ">
								<h5 class=""><strong>{{ $vendor->address }}</strong></h5>
							</div>

							<div class="col-4 mt-2">
								<h5 class="">Vendor Email:</h5>
							</div>
							<div class="col-8 ">
								<h5 class=""><strong>{{ $vendor->company_email }}</strong></h5>
							</div>

							<div class="col-4 mt-2">
								<h5 class="">Description:</h5>
							</div>
							<div class="col-8 ">
								<h5 class=""><strong>{{ $vendor->description }}</strong></h5>
							</div>
						</div>
					</div>
					@endif
				</div>
				<div class="card-footer bg-transparent row ">
					<div class="col-6 mx-auto">
						<div class="row">
							<form class="col-8 " action="{{ route('vendors.edit', ['vendor' => $vendor->id]) }}" method="GET">
								@csrf
								<button class="btn btn-info btn-block mt-3">Edit</button>
							</form>
							<form class="col-4" action="{{ route('vendors.destroy', ['vendor' => $vendor->id ])}}" method="POST">
								@csrf
								@method('DELETE')
								<button class="btn btn-danger btn-block mt-3">Delete</button>
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
	</div>
</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-md-9 mx-auto">
				
			</div>
		</div>
	</div>
	
@endsection