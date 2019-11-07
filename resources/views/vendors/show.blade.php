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
		<div class="row">
			<div class="col-12 col-md-9 mx-auto">
				<div class="card bg-light">
					<h1 class="text-center card-header ">{{ $vendor->name }}</h1>
					<div class="row card-img-top">
						<div class="col-6">
							<img src="{{ url('/public/' . $vendor->image)  }}" class="img-thumbnail">
						</div>
						<div class="col-6">
							<div class="row">
								<div class="col-4 ">
									<h4 class=""><small>Vendor Name:</small></h4>
								</div>
								<div class="col-8 ">
									<h4 class=""><strong>{{ $vendor->name }}</strong></h4>
								</div>

								<div class="col-4 ">
									<h4 class=""><small>Vendor SKU:</small></h4>
								</div>
								<div class="col-8 ">
									<h4 class=""><strong>{{ $vendor->vendor_sku }}</strong></h4>
								</div>

								<div class="col-4 ">
									<h6 class=""><small>Vendor Address:</small></h6>
								</div>
								<div class="col-8 ">
									<h6 class=""><strong>{{ $vendor->address }}</strong></h6>
								</div>

								<div class="col-4 ">
									<h6 class=""><small>Vendor Email:</small></h6>
								</div>
								<div class="col-8 ">
									<h6 class=""><strong>{{ $vendor->company_email }}</strong></h6>
								</div>

								<div class="col-4 ">
									<h6 class=""><small>Description:</small></h6>
								</div>
								<div class="col-8 ">
									<h6 class=""><strong>{{ $vendor->description }}</strong></h6>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer">
						<span class="float-right">
							<form action="{{ route('vendors.destroy', ['vendor' => $vendor->id ])}} " method="POST">
								@csrf
								@method('DELETE')
								<button class="btn btn-danger btn-outline-danger ml-1"><small class="text-muted">Delete Vendor</small></button>
							</form>
						</span>

						<a href="{{ route('vendors.edit', ['vendor' => $vendor->id ]) }}" class="btn btn-warning btn-outline-warning float-right"><small class="text-muted">Edit Vendor</small></a>

						
					</div>

				</div>
			</div>
		</div>
	</div>
	
@endsection