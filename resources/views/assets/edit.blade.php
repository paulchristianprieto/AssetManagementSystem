@extends('layouts.app')


@section('content')
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-md-8 mx-auto">
				<h3 class="text-center">
					Edit Asset Info
				</h3>
				<hr>
				<form action="{{ route('assets.update', ['asset' => $asset->id]) }} " method="POST" enctype="multipart/form-data" >
					@csrf
					@method('PUT')

					<input type="hidden" name="asset_status_id" value="1">
					<div class="form-group">
						<label for="name">Name:</label>
						<input type="text" name="name" id="name" class="form-control">
					</div>

					
					<div class="form-group">
						<label for="quantity">Quantity:</label>
						<input type="number" name="quantity" id="quantity" class="form-control" min="1" >
					</div>


					{{-- Input for image --}}
					<div class="form-group">
						<label for="image">Image (optional):</label>
						<input type="file" name="image" id="image" class="form-control-file">
					</div>

					{{-- Input for description --}}
					<div class="form-group">
						<label for="description">Description:</label>
						<textarea 
							name="description" 
							id="description" 
							class="form-control" 
							min="1" 
							cols="30" 
							rows="10"
						></textarea>
					</div>


					<div class="form-group">
						<label for="vendor">Asset Vendor:</label>
						<select class="form-control" id="vendor" name="vendor">
							@foreach ($vendors as $vendor)
								<option value="{{ $vendor->id }}" >{{ $vendor->name }}</option>
							@endforeach
					    </select>
					</div>

					<div class="form-group">
						<label for="category">Asset Category:</label>
						<select class="form-control" id="category" name="category">
							@foreach ($categories as $category)
								<option value="{{ $category->id }}" >{{ $category->name }}</option>
							@endforeach
					    </select>
					</div>

					<button class="btn btn-dark btn-block">Add Vendor</button>

				</form>
			</div>
			

		</div>
	</div>

@endsection