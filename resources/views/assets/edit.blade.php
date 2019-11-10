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
				<a class="nav-link" href="{{ route('assets.create') }}">Add Asset</a>
				<a class="nav-link" href="{{ route('vendors.create') }}">Add Vendor</a>
				<a class="nav-link" href="{{ route('categories.create') }}">Add Category</a>
			</div>
			
		</div>

		<div class="col-12 col-md-8 mx-auto py-3">
			<h3 class="text-center">Edit Asset Information: </h3>
			<h3 class="text-center text-uppercase"><strong>{{ $asset->sku_number }}</strong></h3>
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
			<form action="{{ route('assets.update', ['asset' => $asset->id]) }} " method="POST" enctype="multipart/form-data" id="asset-form" >
				@csrf
				@method('PUT')

				<div class="form-group row">
					<div class="form-group col-md-8">
						<label for="name">Asset Name:</label>
						<input type="text" class="form-control" name="name" id="name" placeholder="Asset Name" aria-describedby="nameError" value="{{$asset->name}}">
						@if ($errors->has('name'))
							<small id="nameError" class="form-text text-muted alert-danger alert">
								Asset name is required.
							</small>							
						@endif
					</div>
					<div class="form-group col-md-4">
						<label for="quantity">Asset Quantity:</label>
						<input type="number" class="form-control" name="quantity" id="quantity" placeholder="1" min="1" aria-describedby="quantityError" value="{{$asset->quantity_available}}">
						@if ($errors->has('quantity'))
							<small id="quantityError" class="form-text text-muted alert-danger alert">
								Asset quantity is required.
							</small>							
						@endif
					</div>
				</div>

				<div class="form-group row">
					<div class="col-2">
						<label for="category" class="col-form-label col-12">Asset Category:</label>
					</div>
					<select class="form-control col-2 float-left" id="category" name="category" aria-describedby="categoryError">
						@foreach ($categories as $category)
							<option value="{{ $category->id }}" {{ ($category->id == $asset->category_id)? "selected":"" }} >{{ $category->name }}</option>
						@endforeach
				    </select>
				    @if ($errors->has('category'))
						<small id="categoryError" class="form-text text-muted alert-danger alert">
							Asset category is required.
						</small>							
					@endif

					<div class="col-2">
						<label for="vendor" class="col-form-label col-12">Asset Vendor:</label>
					</div>
					<select class="form-control col-2" id="vendor" name="vendor" aria-describedby="vendorError">
						@foreach ($vendors as $vendor)
							<option value="{{ $vendor->id }}" {{ ($vendor->id == $asset->vendor_id)? "selected":"" }}>{{ $vendor->name }}</option>
						@endforeach
				    </select>
				    @if ($errors->has('vendor'))
						<small id="vendorError" class="form-text text-muted alert-danger alert">
							Asset vendor is required.
						</small>							
					@endif

					<div class="col-2">
						<label for="asset_status" class="col-form-label col-12">Asset Status:</label>
					</div>
					<select class="form-control col-2" id="asset_status" name="asset_status_id" aria-describedby="vendorError">
						@foreach ($asset_statuses as $asset_status)
							<option value="{{ $asset_status->id }}" {{ ($asset_status->id == $asset->asset_status_id)? "selected":"" }} >{{ $asset_status->name }}</option>
						@endforeach
				    </select>
				    @if ($errors->has('asset_status'))
						<small id="asset_status" class="form-text text-muted alert-danger alert">
							Asset Status is required.
						</small>							
					@endif
				</div>

				<div class="form-group row">
					<div class="col-3 offset-1">
						<div class="wrapper">
							<img class="img-fluid" src="{{ url('/public/' . $asset->image) }}" alt="{{ $asset->name}}">
						</div>
					</div>
					<div class="col-2">
						
					</div>
					<div class="col-6">
						<div class="form-group row">
							<div class="col-12 mx-auto">
								<label for="description">Asset Description:</label>
								<textarea 
									name="description" 
									id="description" 
									class="form-control" 
									min="1" 
									cols="30" 
									rows="5"
									placeholder="Asset Description" 
									aria-describedby="descriptionError"
								>{{$asset->description}}</textarea>
								@if ($errors->has('description'))
									<small id="descriptionError" class="form-text text-muted alert-danger alert">
										Asset description is required.
									</small>							
								@endif
							</div>
						</div>

						<div class="form-group row">
							<div class="col-12  mx-auto">
								<label for="image">Change Asset Image:</label>
								<input type="file" name="image" id="image" class="form-control-file" aria-describedby="imageError">
							</div>
						</div>
					</div>

				</div>

				<hr>
				<button class="btn btn-dark btn-block col-4 mx-auto">Save & Update</button>
			</form>
		</div>
	</div>
</div>


	
@endsection