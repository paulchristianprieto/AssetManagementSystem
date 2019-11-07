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
					<a data-toggle="collapse" data-target="#category-{{$category->id }}" aria-expanded="false" aria-controls="collapseOne"> 
						<div class="card-header" id="headingOne">
							<div class="mb-0">

								<span class="float-left">{{$category->name }}</span> 
								<div class="float-right">
									<span>
										<a href="{{ route('request_category', ['category_id' => $category->id])}}" class="btn btn-primary border-0">Request</a>
									</span>

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
								</div>
								
							</div>

						</div>
					</a>

					<div id="category-{{$category->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#categoriesAccordion">
						<div class="card-body">
							<h5 class="card-title text-center">Items</h5>
							
							<div class="container-fluid">
								<div class="row">
									@foreach($assets as $asset)
										{{-- {{dd($asset->vendor->id)}} --}}
										@if($asset->category->id == $category->id)
											<div class="col-12 col-md-6 card">
												<div class="card-img-top">
													<img class="img-thumbnail" src="{{ url('/public/' . $asset->image) }}" alt="">
												</div>
												<div class="card-title">
													{{ $asset->name }}
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

	</div>
</div>


@endsection