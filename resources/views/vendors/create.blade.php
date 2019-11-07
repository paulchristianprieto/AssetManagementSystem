@extends('layouts.app')


@section('content')
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-md-9 mx-auto">
				<h3 class="text-center">
					Add Vendor
				</h3>
				<hr>
				<form action="{{ route('vendors.store') }} " method="POST" enctype="multipart/form-data" >
					@csrf

					<div class="row p-0">
						<div class="form-group col-8">
							<label for="name" class="bmd-label-floating">Company Name:</label>
							<input type="text" name="name" id="name" class="form-control">

							@if ($errors->has('name'))
								<div class="alert alert-danger">
									<small class="mb-0"> Company name is required. </small>
								</div>
							@endif
						</div>

						
						<div class="form-group col-4">
							<label for="sku_id" class="bmd-label-floating">SKU ID:</label>
							<input type="text" name="sku_id" id="sku_id" class="form-control" min="1" >

							@if ($errors->has('sku_id'))
								<div class="alert alert-danger">
									<small class="mb-0">SKU ID is required. | Maximum 4 characters.</small>
								</div>
							@endif
						</div>
					</div>

					<div class="row">
						<div class="form-group col-12">
							<label for="address" class="bmd-label-floating">Company Address:</label>
							<input type="text" name="address" id="address" class="form-control" min="1" >

							@if ($errors->has('address'))
								<div class="alert alert-danger">
									<small class="mb-0">Company address is not valid.</small>
								</div>
							@endif
						</div>
					</div>

					<div class="row">
						<div class="form-group col-12">
							<label for="company_email" class="bmd-label-floating">Company Email:</label>
							<input type="text" name="company_email" id="company_email" class="form-control" min="1" >

							@if ($errors->has('company_email'))
								<div class="alert alert-danger">
									<small class="mb-0">Company email is required.</small>
								</div>
							@endif
						</div>
					</div>

					<div class="row">
					{{-- Input for image --}}
						<div class="form-group col-12">
							<label for="image" class="bmd-label-floating">Vendor Image (optional):</label>
							<input type="file" name="image" id="image" class="form-control-file">

							@if ($errors->has('image'))
								<div class="alert alert-danger">
									<small class="mb-0">Check if image is not greater than 3mb.</small>
								</div>
							@endif
						</div>
					</div>

					<div class="row">
					{{-- Input for description --}}
						<div class="form-group col-12">
							<label for="description" class="bmd-label-floating">Company Description (optional):</label>
							<textarea 
								name="description" 
								id="description" 
								class="form-control" 
								min="1" 
								cols="30" 
								rows="10"
							></textarea>
						</div>
					</div>

					<button class="btn bg-success btn-outline-light btn-block">Add Vendor</button>

				</form>
			</div>
			

		</div>
	</div>

@endsection