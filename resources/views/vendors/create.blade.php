@extends('layouts.app')


@section('content')
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-md-8 mx-auto">
				<h3 class="text-center">
					Add Vendor
				</h3>
				<hr>
				<form action="{{ route('vendors.store') }} " method="POST" enctype="multipart/form-data" >
					@csrf

					
					{{-- Input for name --}}
					<div class="form-group">
						<label for="name">Product Name:</label>
						<input type="text" name="name" id="name" class="form-control">

						@if ($errors->has('name'))
							<div class="alert alert-danger">
								<small class="mb-0">Product name is required.</small>
							</div>
						@endif
					</div>

					{{-- Input for price --}}
					<div class="form-group">
						<label for="price">Product Price:</label>
						<input type="number" name="price" id="price" class="form-control" min="1">
						@if ($errors->has('price'))
							<div class="alert alert-danger">
								<small class="mb-0">Product price is required.</small>
							</div>
						@endif
					</div>

					{{-- Input for category --}}
					<div class="form-group">
						<label for="category">Product Category:</label>
						<select class="form-control" id="category" name="category">

							{{-- @foreach ($categories as $category)
								<option value="{{ $category->id }}">{{ $category->name }}</option>
							@endforeach --}}
							
					    </select>
					</div>


					{{-- Input for image --}}
					<div class="form-group">
						<label for="image">Product Image:</label>
						<input type="file" name="image" id="image" class="form-control-file">
						@if ($errors->has('image'))
							{{-- {{dd($errors)}} --}}
							<div class="alert alert-danger">
								<small class="mb-0">Product image is required. Check if image is not greater than 3mb.</small>
							</div>
						@endif
					</div>

					{{-- Input for description --}}
					<div class="form-group">
						<label for="description">Product Description:</label>
						<textarea 
							name="description" 
							id="description" 
							class="form-control" 
							min="1" 
							cols="30" 
							rows="10"
						></textarea>
						@if ($errors->has('description'))
							<div class="alert alert-danger">
								<small class="mb-0">Product description is required.</small>
							</div>
						@endif
					</div>

					<button class="btn btn-dark btn-block">Add Item</button>

				</form>
			</div>
			

		</div>
	</div>

@endsection