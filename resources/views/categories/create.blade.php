@extends('layouts.app')


@section('content')
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-md-8 mx-auto">
				<h3 class="text-center">
					Add Category
				</h3>
				<hr>
				<form action="{{ route('categories.store') }} " method="POST" enctype="multipart/form-data" >
					@csrf

					<div class="form-group">
					    <label for="category" class="bmd-label-floating">Category:</label>
					    <input type="text" class="form-control" id="category" name="name">
					</div>

					<div class="form-group">
					    <label for="category_sku" class="bmd-label-floating">Category Code:</label>
					    <input type="text" class="form-control" id="category_sku" name="category_sku">
					    <span class="bmd-help">Ex. Monitor = MON</span>
					</div>

					<div class="form-group">
						<label for="description">Category Description (optional):</label>
						<textarea 
							name="description" 
							id="description" 
							class="form-control" 
							min="1" 
							cols="30" 
							rows="10"
						></textarea>
					</div>
					

					<button class="btn btn-dark btn-block">Save & Update</button>

				</form>
			</div>
			

		</div>
	</div>

@endsection