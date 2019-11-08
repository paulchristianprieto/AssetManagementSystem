@extends('layouts.app')

@section('content')


<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-md-8 offset-2">


			<h2 class="text-center">Categories </h2>

			@if (Session::has('destroy_success'))
				<div class="row">
					<div class="col-12">
						<div class="alert alert-success">
							{{ Session::get('destroy_success') }}
						</div>
					</div>
				</div>
			@endif

			<div class="accordion" id="categoriesAccordion">

				@foreach ($categories as $category)
				

				<div class="card shadow bg-white rounded">
					<div class="card-header" id="headingOne">
						<div class="row">
							<div class="col-8">
								<button 
									class="btn btn-block text-left" 
									type="button" 
									data-toggle="collapse" 
									data-target="#category-{{$category->id}}" 
									aria-expanded="false" 
									aria-controls="collapseOne">
									<h5 class="btn-block"><strong><span class="float-left">{{$category->name }}</span></strong></h5> 
									<span class="ml-2 badge-pill 

									{{ ($category_available_items[$category->id]) ? "badge-info": "badge-danger"}}
									"> 
										Available: {{ $category_available_items[$category->id] }}
									</span>

									@can('isAdmin')
										@if ($category_lent_items[$category->id])
										<span class="ml-2 badge-pill badge-warning"> 
											Lent: {{ $category_lent_items[$category->id] }}
										</span>
										@endif
									@endcan
								</button>
							</div>
							<div class="col-4">
								<div class="float-right">

									@cannot('isAdmin')
									<span>
										<a href="{{ route('request_category', ['category_id' => $category->id])}}" class="btn btn-primary border-0">Request</a>
									</span>

									@endcannot
									@can('isAdmin')
									
									<span>
										<a href="{{ route('categories.show', ['category' => $category->id])}}" class="btn btn-secondary border-0">View</a>
									</span>

									<span>
										<a href="{{ route('categories.edit', ['category' => $category->id])}}" class="btn btn-warning border-0">Edit</a>
									</span>

									<span class="float-right">
										<form action="{{ route('categories.destroy', ['category' => $category->id ])}} " method="POST">
											@csrf
											@method('DELETE')
											<button class="btn btn-danger border-0">Remove</button>
										</form>
									</span>
									@endcan
								</div>
							</div>
						</div>
					</div>

					<div id="category-{{$category->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#categoriesAccordion">
						<div class="card-body">
							<h5 class="card-title text-center">Items</h5>
							
							<div class="container-fluid">
								<div class="row">
									@foreach($assets as $asset)

										@if($asset->category->id == $category->id)
											<div class="card col-4"> 
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
										@endif

									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>

				@endforeach

			</div>
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