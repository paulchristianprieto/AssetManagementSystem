@extends('layouts.app')

@section('content')


<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-md-8 offset-2">


			{{-- <h2 class="text-center">Categories </h2> --}}

			@if (Session::has('destroy_success'))
				<div class="row">
					<div class="col-12">
						<div class="alert alert-success">
							{{ Session::get('destroy_success') }}
						</div>
					</div>
				</div>
			@endif
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

			@cannot('isAdmin')
			<div class="container-fluid">
				<div class="row">
					<div class="col-12 mx-auto">
						<form action="{{ route('user_requests.store') }}" method="POST">
							@csrf

							<input type="hidden" name="category_id" value="{{$category->id}}">
							<div class="container-fluid my-3 col-8">
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

								<div class="row">
									<div class='col-md-6'>
								        <div class="form-group">
								        	<label for="borrow_date" class="form-check-label">Borrow Date: </label>
								           	<div class="input-group date" id="datetimepicker7" data-target-input="nearest">
								                <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker7" id="borrow_date" name="borrow_date" />
								                <div class="input-group-append" data-target="#datetimepicker7" data-toggle="datetimepicker">
								                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
								                </div>
								            </div>
								        </div>
								    </div>
								    <div class='col-md-6'>
								        <div class="form-group">
								        	<label for="return_date" class="form-check-label">Borrow Date: </label>
								           	<div class="input-group date" id="datetimepicker8" data-target-input="nearest">
								                <input type="text" id="return_date" class="form-control datetimepicker-input" data-target="#datetimepicker8" name="return_date" />
								                <div class="input-group-append" data-target="#datetimepicker8" data-toggle="datetimepicker">
								                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
								                </div>
								            </div>
								        </div>
								    </div>

								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="quantity">Quantity: </label>
											<input type="number" class="input-group form-control" name="quantity">
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="description">Request Description (optional):</label>
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
								</div>
								
								<button class="btn btn-primary">Submit Request</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			@endcannot

			@can('isAdmin')
			<div class="row">
				@foreach($assets as $asset)
				<div class="card col-4 m-2">
					<div class="wrapper">
						<img class="card-img-top img-fluid" src="{{ url('/public/' . $asset->image) }}" alt="{{ $asset->name}}">
					</div>
					<h4 class="card-title text-center">{{ $asset->name }}</h4>
					<div class="card-body">
						<p class="card-text">{{ $asset->category->name }} 
							<span class="card-text badge float-right {{ ($asset->available == 1)? 'badge-success': 'badge-danger' }} ">
								{{ ($asset->available == 1) ? "Available: ": "Not Available: "}} {{$asset->quantity_available}} 
							</span>
						</p>
						<p class="card-text">{{ $asset->vendor->name }} 
							<span class="card-text badge float-right badge-warning">
								Lent: 1{{ dd($category_lent_items) }}
								{{-- {{ ($asset->available == 1) ? "Available: ": "Not Available: "}} {{$asset->quantity_available}}  --}}
							</span>
						</p>
						
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
		
		@can('isAdmin')
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
		@endcan
		
		
	</div>
</div>



@endsection