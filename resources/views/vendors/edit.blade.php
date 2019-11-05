@extends('layouts.app')


@section('content')
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-md-8 mx-auto">
				<h3 class="text-center">
					Edit Vendor Info
				</h3>
				<hr>
				<form action="{{ route('vendors.update', ['vendor' => $vendor->id]) }} " method="POST" enctype="multipart/form-data" >
					@csrf

					
					<div class="form-group">
						<label for="name">Company Name:</label>
						<input type="text" name="name" id="name" class="form-control" value="{{ $vendor->name }}">

						@if ($errors->has('name'))
							<div class="alert alert-danger">
								<small class="mb-0">Company name is required.</small>
							</div>
						@endif
					</div>

					
					<div class="form-group">
						<label for="sku_id">SKU ID:</label>
						<input type="text" name="sku_id" id="sku_id" class="form-control" min="1" value="{{ $vendor->vendor_sku}}" >

						@if ($errors->has('sku_id'))
							<div class="alert alert-danger">
								<small class="mb-0">SKU ID is required.</small>
							</div>
						@endif
					</div>


					<div class="form-group">
						<label for="address">Company Address:</label>
						<input type="text" name="address" id="address" class="form-control" min="1" value="{{ $vendor->address }}" >

						@if ($errors->has('address'))
							<div class="alert alert-danger">
								<small class="mb-0">Company address is required.</small>
							</div>
						@endif
					</div>


					<div class="form-group">
						<label for="company_email">Company Email:</label>
						<input type="text" name="company_email" id="company_email" class="form-control" min="1" value="{{ $vendor->company_email }}" >

						@if ($errors->has('company_email'))
							<div class="alert alert-danger">
								<small class="mb-0">Company company_email is required.</small>
							</div>
						@endif
					</div>


					{{-- Input for image --}}

					@if ($vendor->image)
						<img src="{{ $vendor->$image }}">
					@endif

					<div class="form-group">
						<label for="image">Vendor Image (optional):</label>
						<input type="file" name="image" id="image" class="form-control-file">

						@if ($errors->has('image'))
							<div class="alert alert-danger">
								<small class="mb-0">Check if image is not greater than 3mb.</small>
							</div>
						@endif
					</div>

					{{-- Input for description --}}
					<div class="form-group">
						<label for="description">Company Description (optional):</label>
						<textarea 
							name="description" 
							id="description" 
							class="form-control" 
							min="1" 
							cols="30" 
							rows="10"
						>{{ $vendor->description }}</textarea>
					</div>

					<button class="btn btn-dark btn-block">Update</button>

				</form>
			</div>
			

		</div>
	</div>

@endsection