@extends('layouts.app')


@section('content')
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-md-8 mx-auto">
				Request for {{ $category->name }}
				{{-- {{ dd($category) }} --}}
				<form action="{{ route('requests.store') }}" method="POST">
					@csrf

					<input type="hidden" name="category_id" value="{{$category->id}}">
					<div class="form-group container">
						<div class="row">
							<div class="col-6 p-0">
								<label for="borrow_date"> Borrow Date: </label>
								<input class="my-2" id="borrow_date" width="276" name="borrow_date" />
							</div>
							<div class="p-0 col-6">
								<label for="return_date"> Return Date: </label>
								<input class="my-2" id="return_date" width="276" name="return_date" />
							</div>
						</div>
					</div>

					<div class="form-group">
					    <label for="quantity" class="bmd-label-floating">Quantity:</label>
					    <input type="number" class="form-control" id="quantity" name="quantity" min="1" >
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




<script>
    $('#borrow_date').datepicker({
        showOtherMonths: true
    });
    $('#return_date').datepicker({
        showOtherMonths: true
    });
</script>
@endsection