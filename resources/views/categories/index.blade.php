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


			<div class="container-fluid">
				<div class="row">
					<div class="col-12 mx-auto">
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


						<form action="{{ route('user_requests.store') }}" method="POST">
							@csrf

							<input type="hidden" name="category_id" value="{{$category->id}}">
							{{-- <div class="form-group container">
								<div class="row">
									<div class="col-6 p-0">
										<label for="borrow_date"> Borrow Date: </label>
										<input class="my-2" id="borrow_date" width="276" name="borrow_date" type="datetime-local" />
									</div>
									<div class="p-0 col-6">
										<label for="return_date"> Return Date: </label>
										<input class="my-2" id="return_date" width="276" name="return_date" type="datetime-local" />
									</div>
								</div>
							</div> --}}
							
							    <div class='col-md-5'>
							        <div class="form-group">
							           <div class="input-group date" id="datetimepicker7" data-target-input="nearest">
							                <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker7" name="borrow_date" />
							                <div class="input-group-append" data-target="#datetimepicker7" data-toggle="datetimepicker">
							                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
							                </div>
							            </div>
							        </div>
							    </div>
							    <div class='col-md-5'>
							        <div class="form-group">
							           <div class="input-group date" id="datetimepicker8" data-target-input="nearest">
							                <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker8" name="return_date" />
							                <div class="input-group-append" data-target="#datetimepicker8" data-toggle="datetimepicker">
							                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
							                </div>
							            </div>
							        </div>
							    </div>
							
							<div class="form-group">
								<input type="number" name="quantity">
							</div>
							

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

							<button class="btn btn-primary btn-outline-primary">Submit Request</button>
						</form>
					</div>
				</div>
			</div>

			@can('isAdmin')
			<div class="row">
				@foreach($assets as $asset)
				<div class="card col-4 m-2"> 
					<div class="card-header">{{ $asset->sku_number }}</div>
					<img class="card-img-top" src="{{ url('/public/' . $asset->image) }}" style="height: 150px;">
					<div class="card-body">
						<h5 class="card-title">{{ $asset->name }}</h5>
						<p class="card-text">{{ $asset->category->name }}
							<span class="card-text badge float-right {{ ($asset->available == 1)? 'badge-success': 'badge-danger' }} ">
								{{ ($asset->available == 1) ? "Available: ": "Not Available: "}} {{$asset->quantity_available}} 
							</span>
						</p>
					</div>
					<div class="card-footer">
						<a href="{{ route('assets.show', ['asset' => $asset->id]) }}" class="btn btn-primary btn-outline-primary float-right"><small class="text-muted">View Item</small></a>
					</div>
				</div>
				@endforeach
			</div>
			@endcan
		</div>

		@can('isAdmin')
		<div class="col-12 col-md-2">
			<form action="{{ route('categories.store') }}" method="POST">
				@csrf
				<div class="form-group">
				    <label for="category" class="bmd-label-floating">Category</label>
				    <input type="text" class="form-control" id="category" name="name">
				</div>
				<div class="form-group">
				    <label for="category_sku" class="bmd-label-floating">Category Code:</label>
				    <input type="text" class="form-control" id="category_sku" name="category_sku">
				    <span class="bmd-help">Ex. Monitor = MON</span>
				</div>
				<div class="row">
					<button class="btn btn-light bg-success col-10 mx-auto my-2">Add Category</button>
				</div>
			</form>
		</div>
		@endcan
		
		
	</div>
</div>



@endsection