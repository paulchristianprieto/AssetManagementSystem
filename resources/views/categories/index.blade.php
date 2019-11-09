@extends('layouts.app')

@section('content')


<div class="container-fluid ">
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

			{{-- Navigation --}}
			<nav>
				<ul class="nav nav-tabs">
					@foreach($categories as $category)
						<li class="nav-item">
							<a class="nav-link {{ ($category->id == $category_id) ? 'active font-weight-bold':''}} " href="{{route('category_filtered_assets', ['category_id' => $category->id]) }}">{{$category->name}}</a>
						</li>
					@endforeach
				</ul>
			</nav>
		
			@if (Session::has('destroy_success'))
				<div class="row">
					<div class="col-12">
						<div class="alert alert-success">
							{{ Session::get('destroy_success') }}
						</div>
					</div>
				</div>
			@endif
		

			@cannot('isAdmin')
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 mx-auto">
						<form action="{{ route('user_requests.store') }}" method="POST" class="text-center">
							@csrf

							<input type="hidden" name="category_id" value="{{$category->id}}">
							<div class="container-fluid my-3 col-12">
								<h3 class="font-weight-bold text-uppercase">Request a {{$categories[$category_id-1]->name }}</h3>
								<div class="mb-4">
									<span class="ml-2 badge-pill 

									{{ ($category_available_items[$category_id]) ? "badge-info": "badge-danger"}}
									"> 
										Available: {{ $category_available_items[$category_id] }}
									</span>
									@can('isAdmin')
										@if ($category_lent_items[$category_id])
										<span class="ml-2 badge-pill badge-warning"> 
											Lent: {{ $category_lent_items[$category_id] }}
										</span>
										@endif
									@endcan
								</div>

								
						        <div class="form-group row">
						        	<label for="borrow_date" class="form-check-label col-3 mx-auto col-form-label text-left">Borrow Date: </label>
						           	<div class="input-group date col-6 mx-auto " id="datetimepicker7" data-target-input="nearest">
						                <input placeholder="12/31/2018 00:00 AM" type="text" class="form-control datetimepicker-input" data-target="#datetimepicker7" id="borrow_date" name="borrow_date" />
						                <div class="input-group-append" data-target="#datetimepicker7" data-toggle="datetimepicker">
						                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
						                </div>
						            </div>
						        </div>
								{{-- <div class="row">
									<div class="col-8">
										<p >To</p>
									</div>
								</div> --}}
						        
								    
								<div class="form-group row">
						        	<label for="return_date" class="form-check-label mx-auto col-form-label col-3 text-left">Return Date: </label>
						           	<div class="input-group mx-auto date col-6" id="datetimepicker8" data-target-input="nearest">
						                <input placeholder="12/31/2018 00:00 AM" type="text" id="return_date" class="form-control datetimepicker-input" data-target="#datetimepicker8" name="return_date" />
						                <div class="input-group-append" data-target="#datetimepicker8" data-toggle="datetimepicker">
						                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
						                </div>
						            </div>
						        </div>

						        <div class="form-group row">
									<label for="quantity" class="col-3 mx-auto col-form-label text-left">Quantity: </label>
									<input type="number" class="input-group form-control mx-auto col-6" name="quantity" min="1" placeholder="1" aria-describedby="quantityError">
								
									@if ($errors->has('quantity'))
										<small id="quantityError" class="form-text text-muted alert-danger alert">
											Quantity is not valid.
										</small>							
									@endif
								</div>
								<div class="form-group row">
									<label for="description" class="col-3 mx-auto col-form-label text-left">Request Description (optional):</label>
									<textarea 
										name="description" 
										id="description" 
										class="form-control col-6 mx-auto " 
										min="1" 
										cols="30" 
										rows="5"
										aria-describedby="descriptionError"
										placeholder="Request Description" 
									></textarea>
									@if ($errors->has('description'))
										<small id="descriptionError" class="form-text text-muted alert-danger alert">
											Request description is too long. 
										</small>							
									@endif
								</div>

								<div class="form-group row">
									<div class="col-md-4">

									</div>
									<div class="col-md-8">
										
									</div>
									
								</div>
								<div class="row">
									<button class="btn btn-primary col-3 mx-auto" {{ ($category_available_items[$category_id] == 0) ? "disabled":"" }} >Submit Request</button>
									<div class="col-6 mx-auto"></div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			@endcannot


			@can('isAdmin')
			<div class="row">
				@foreach($assets as $asset)
				<div class="card col-4 m-2 mx-auto shadow p-3 mb-5 bg-white rounded">
					<div class="wrapper">
						<img class="card-img-top img-fluid" src="{{ url('/public/' . $asset->image) }}" alt="{{ $asset->name}}">
					</div>
					<h4 class="card-title text-center">{{ $asset->name }}</h4>
					<div class="row">
						<div class="col-12 mx-auto text-center">
							<span class="card-text badge  {{ ($asset->available == 1)? 'badge-success': 'badge-danger' }} ">
								{{ ($asset->available == 1) ? "Available: ": "Not Available: "}} {{$asset->quantity_available}} 
							</span>
							<span class="card-text badge  badge-warning">
								Lent: {{ $lent_items[$asset->id] }}
								{{-- {{ ($asset->available == 1) ? "Available: ": "Not Available: "}} {{$asset->quantity_available}}  --}}
							</span>
						</div>
					</div>
					<div class="card-body">
						<p class="card-text">Category: <strong class="float-right">{{ $asset->category->name }} </strong>
							
						</p>
						<p class="card-text">Vendor: <strong class="float-right">{{ $asset->vendor->name }} </strong>
							
						</p>
						<p class="card-text">SKU: <strong class="float-right" >{{ $asset->sku_number }}</strong></p>
						<p class="card-text">Condition: <strong class="float-right" >{{ $asset->asset_status->name }}</strong></p>
						<p class="card-text">Description: <strong class="float-right" >{{ $asset->description }}</strong></p>
						
						<div class="card-footer bg-transparent row ">
							<div class="col-6">
								<a href="{{ route('assets.show', ['asset' => $asset->id]) }}" class="btn btn-primary btn-block ">View Item</a>
							</div>
							<div class="col-6">
								<a href="{{ route('assets.edit', ['asset' => $asset->id]) }}" class="btn btn-warning btn-block ">Edit Item</a>
							</div>
							
						</div>
						
						
					</div>
				</div>

				@endforeach
			</div>
			@endcan
		</div>
		
		
		{{-- @can('isAdmin')
		<div class="col-12 col-md-2 my-3">
			<h5 class="text-center mb-3">Add Category</h5>
			<form action="{{ route('categories.store') }}" method="POST">
				@csrf
				<div class="form-group">
				    <label for="category" class="bmd-label-floating">Category Name: </label>
				    <input type="text" class="form-control" id="category" name="name">
				</div>
				<div class="form-group">
				    <label for="category_sku" class="bmd-label-floating">Category Code:</label>
				    <input type="text" class="form-control" id="category_sku" name="category_sku" placeholder="Ex. Monitor = MON">
				    
				</div>
				<div class="row">
					<button class="btn btn-light col-10 mx-auto my-2">Add Category</button>
				</div>
			</form>
		</div>
		@endcan --}}
		
		
	</div>
</div>



@endsection