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
					Add Category
				</h3>
				<hr>
				<form action="{{ route('categories.store') }} " method="POST" enctype="multipart/form-data" >
					@csrf

					<div class="form-group row">
						<div class="form-group col-md-8">
							<label for="name">Category Name:</label>
							<input type="text" class="form-control" name="name" id="name" placeholder="Category Name" aria-describedby="nameError">
							@if ($errors->has('name'))
								<small id="nameError" class="form-text text-muted alert-danger alert">
									Category name is required.
								</small>							
							@endif
						</div>
						<div class="form-group col-md-4">
							<label for="category_sku">Category Code:</label>
							<input type="text" class="form-control" name="category_sku" id="category_sku" placeholder="CPU" aria-describedby="categoryError">
							@if ($errors->has('category_sku'))
								<small id="categoryError" class="form-text text-muted alert-danger alert">
									Asset category code is required. | Maximum 4 characters. | Must be unique.
								</small>							
							@endif
						</div>
					</div>

					<div class="form-group row">
						<div class="form-group col-md-12">
							<label for="description" class="bmd-label-floating">Category Description (optional):</label>
							<textarea 
								name="description" 
								id="description" 
								class="form-control" 
								min="1" 
								cols="30" 
								rows="5"
								aria-describedby="descriptionError"
								placeholder="Category Description" 
							></textarea>
							@if ($errors->has('description'))
								<small id="descriptionError" class="form-text text-muted alert-danger alert">
									Category description is too long. 
								</small>							
							@endif
						</div>
					</div>

					<button class="btn btn-dark btn-block col-4 mx-auto">Add Category</button>

				</form>
			</div>
			

		</div>
	</div>

@endsection