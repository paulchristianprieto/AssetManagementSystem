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
				<h3 class="text-center">
					Add Asset
				</h3>
				<hr>
				<form action="{{ route('assets.store') }} " method="POST" enctype="multipart/form-data" id="asset-form" >
					@csrf
					<div class="form-group row">
						<div class="form-group col-md-8">
							<label for="name">Asset Name:</label>
							<input type="text" class="form-control" name="name" id="name" placeholder="Asset Name" aria-describedby="nameError">
							@if ($errors->has('name'))
								<small id="nameError" class="form-text text-muted alert-danger alert">
									Asset name is required.
								</small>							
							@endif
						</div>
						<div class="form-group col-md-4">
							<label for="quantity">Asset Quantity:</label>
							<input type="number" class="form-control" name="quantity" id="quantity" placeholder="1" min="1" aria-describedby="quantityError">
							@if ($errors->has('quantity'))
								<small id="quantityError" class="form-text text-muted alert-danger alert">
									Asset quantity is required.
								</small>							
							@endif
						</div>
					</div>
					<div class="form-group row">
						<div class="form-group col-md-8">
							<label for="description">Asset Description:</label>
							<textarea 
								name="description" 
								id="description" 
								class="form-control" 
								min="1" 
								cols="30" 
								rows="10"
								placeholder="Asset Description" 
								aria-describedby="descriptionError"
							></textarea>
							@if ($errors->has('description'))
								<small id="descriptionError" class="form-text text-muted alert-danger alert">
									Asset description is required.
								</small>							
							@endif
						</div>
						<div class="form-group col-md-4">
							<label for="image">Asset Image:</label>
							<input type="file" name="image" id="image" class="form-control-file" aria-describedby="imageError">
							@if ($errors->has('image'))
								<small id="imageError" class="form-text text-muted alert-danger alert">
									Asset image is required.
								</small>							
							@endif
							<div class="form-group row">
								<div class="form-group col-12 mt-3">
									<label for="vendor">Asset Vendor:</label>
									<select class="form-control" id="vendor" name="vendor" aria-describedby="vendorError">
										<option selected disabled>Select Vendor</option>
										@foreach ($vendors as $vendor)
											<option value="{{ $vendor->id }}" >{{ $vendor->name }}</option>
										@endforeach
								    </select>
								    @if ($errors->has('vendor'))
										<small id="vendorError" class="form-text text-muted alert-danger alert">
											Asset vendor is required.
										</small>							
									@endif
								</div>
								<div class="form-group col-12">
									<label for="category">Asset Category:</label>
									<select class="form-control" id="category" name="category" aria-describedby="categoryError">
										<option selected disabled>Select Category</option>
										@foreach ($categories as $category)
											<option value="{{ $category->id }}" >{{ $category->name }}</option>
										@endforeach
								    </select>
								    @if ($errors->has('category'))
										<small id="categoryError" class="form-text text-muted alert-danger alert">
											Asset category is required.
										</small>							
									@endif
								</div>
							</div>
						</div>
					</div>
					<button class="btn btn-dark btn-block col-4 mx-auto">Add Asset</button>
				</form>
			</div>
		</div>
	</div>

@endsection