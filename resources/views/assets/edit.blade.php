@extends('layouts.app')


@section('content')
	{{-- passed asset from controller --}}
	{{-- {{dd($asset) }} --}}
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-md-8 mx-auto">
				<h3 class="text-center">
					Edit: {{$asset->name }}
				</h3>
				<hr>
				<form action="{{ route('assets.update', ['asset' => $asset->id]) }} " method="POST" enctype="multipart/form-data" >
					@csrf
					@method('PUT')

					<p>Asset SKU: <strong>{{$asset->sku_number }}</strong></p>
					<p>Available: 
						<input type="hidden" name="available" value="{{$asset->available}}">
						<strong>
							@if ($asset->available == 0 || $asset->quantity_available == 0)
								<span>NO</span>
							@else
								<span>YES</span>
							@endif
						</strong>

						<span>
							<div class="switch">
							    <label>
							      	
							      	@if ($asset->available = 1)
							      		<input type="checkbox" checked> Yes
							      	@else
							      		<input type="checkbox"> No
							      	@endif
							    </label>
							</div>
						</span>
					</p>

					
					<div class="form-group">
						<label for="name">Name:</label>
						<input type="text" name="name" id="name" class="form-control" value="{{$asset->name }}">
					</div>

					
					<div class="form-group">
						<label for="quantity">Quantity:</label>
						<input type="number" name="quantity" id="quantity" class="form-control" min="1" value="{{$asset->quantity_available}}">
					</div>


					{{-- Input for image --}}
					
					<div class="form-group">
						<label for="image">Image:</label>
						<img src="{{ url('/public/' . $asset->image )  }}" class="img-thumbnail">
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
						>{{$asset->description }}</textarea>
					</div>

					<div class="form-group">
						<label for="asset_status">Asset Status:</label>
						<select class="form-control" id="asset_status" name="asset_status_id">
							@foreach ($asset_statuses as $asset_status)
								<option 
									value="{{ $asset_status->id }}"
									@if ($asset->asset_status_id == $asset_status->id)
										selected 
									@endif
								>
									{{ $asset_status->name }}
								</option>
							@endforeach
					    </select>
					</div>


					<div class="form-group">
						<label for="vendor">Asset Vendor:</label>
						<select class="form-control" id="vendor" name="vendor">
							@foreach ($vendors as $vendor)
								<option 
									value="{{ $vendor->id }}"
									@if ($asset->vendor_id == $vendor->id)
										selected 
									@endif
								>
									{{ $vendor->name }}
								</option>
							@endforeach
					    </select>
					</div>

					<div class="form-group">
						<label for="category">Asset Category:</label>
						<select class="form-control" id="category" name="category">
							@foreach ($categories as $category)
								<option 
									value="{{ $category->id }}"
									@if ($asset->category_id == $category->id)
										selected 
									@endif
								>
									{{ $category->name }}
								</option>
							@endforeach
					    </select>
					</div>

					<button class="btn btn-dark btn-block">Save & Update</button>

				</form>
			</div>
			

		</div>
	</div>

@endsection