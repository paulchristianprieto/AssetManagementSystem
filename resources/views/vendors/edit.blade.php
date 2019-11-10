@extends('layouts.app')


@section('content')
	<div class="container-fluid">
		<div class="row side-panel">
			<div class="col-2 bg-dark p-4 ">
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

			<div class="col-12 col-md-8 mx-auto py-3">
				<h3 class="text-center">
					Edit Vendor Information
				</h3>
				<hr>
				@if(Session::has('update_failed'))
					<div class="alert alert-warning">
						{{ Session::get('update_failed') }}
					</div>
				@endif

				@if (Session::has('update_success'))
					<div class="alert alert-success">
						{{ Session::get('update_success') }}
					</div>
				@endif
				<form action="{{ route('vendors.update', ['vendor' => $vendor->id]) }} " method="POST" enctype="multipart/form-data" >
					@csrf
					@method('PUT')
					<div class="form-group row">
						<div class="form-group col-md-8">
							<label for="name">Company Name:</label>
							<input type="text" class="form-control" name="name" id="name" placeholder="Company Name" aria-describedby="nameError" value="{{$vendor->name }}">
							@if ($errors->has('name'))
								<small id="nameError" class="form-text text-muted alert-danger alert">
									Vendor name is required.
								</small>							
							@endif
						</div>
						<div class="form-group col-md-4">
							<label for="sku_id">Vendor SKU Code:</label>
							<input type="text" class="form-control text-uppercase" name="sku_id" id="sku_id" placeholder="APL" aria-describedby="skuError" value="{{$vendor->vendor_sku }}">
							@if ($errors->has('sku_id'))
								<small id="skuError" class="form-text text-muted alert-danger alert">
									Vendor SKU Code is required. | Maximum 4 characters. | Must be unique.
								</small>							
							@endif
						</div>
					</div>
					<div class="form-group row">
						<div class="form-group col-md-8">
							<label for="address">Company Address:</label>
							<input type="text" class="form-control" name="address" id="address" placeholder="Makati City, Metro Manila" aria-describedby="addressError" value="{{$vendor->address}}">
							@if ($errors->has('address'))
								<small id="addressError" class="form-text text-muted alert-danger alert">
									Vendor address is required.
								</small>							
							@endif
						</div>
						<div class="form-group col-md-4">
							<label for="company_email">Company Email:</label>
							<input type="text" class="form-control" name="company_email" id="company_email" placeholder="help@apple.com" aria-describedby="companyError" value="{{$vendor->company_email}}">
							@if ($errors->has('company_email'))
								<small id="companyError" class="form-text text-muted alert-danger alert">
									Vendor company email is required. 
								</small>							
							@endif
						</div>
					</div>
					<div class="form-group row">
						@if($vendor->image)
						<div class="form-group col-md-6">
							<label for="description" class="bmd-label-floating">Company Description (optional):</label>
							<textarea 
								name="description" 
								id="description" 
								class="form-control" 
								min="1" 
								cols="30" 
								rows="15"
								aria-describedby="descriptionError"
								placeholder="Company Description" 
							>{{$vendor->description}}</textarea>
							@if ($errors->has('description'))
								<small id="descriptionError" class="form-text text-muted alert-danger alert">
									Vendor company description is too long. 
								</small>							
							@endif
						</div>
						<div class="form-group col-md-4 mx-auto">
							<label for="image">Company Image:</label>
							<div class="wrapper">
								<img class="img-fluid" src="{{ url('/public/' . $vendor->image) }}" alt="{{ $vendor->name}}">
							</div>
							<input type="file" name="image" id="image" class="form-control-file my-2" aria-describedby="image">
							@if ($errors->has('image'))
								<small id="image" class="form-text text-muted alert-danger alert">
									Vendor image is not an image.
								</small>							
							@endif
						</div>
						
						@else
						<div class="form-group col-md-8">
							<label for="description" class="bmd-label-floating">Company Description (optional):</label>
							<textarea 
								name="description" 
								id="description" 
								class="form-control" 
								min="1" 
								cols="30" 
								rows="5"
								aria-describedby="descriptionError"
								placeholder="Company Description" 
							>{{$vendor->description}}</textarea>
							@if ($errors->has('description'))
								<small id="descriptionError" class="form-text text-muted alert-danger alert">
									Vendor company description is too long. 
								</small>							
							@endif
						</div>
						<div class="form-group col-md-4">
							<label for="image">Company Image (optional):</label>
							<input type="file" name="image" id="image" class="form-control-file" aria-describedby="image">
							@if ($errors->has('image'))
								<small id="image" class="form-text text-muted alert-danger alert">
									Vendor image is not an image.
								</small>							
							@endif
						</div>
						@endif
					</div>
					<hr>
					<button class="btn btn-dark btn-block col-4 mx-auto">Save & Update</button>
				</form>
			</div>
		</div>
	</div>
@endsection