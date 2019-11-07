@extends('layouts.app')



@section('content')


	<div class="container">
		<div class="row">
			<div class="col-12 col-md-10 mx-auto">
				<h3 class="text-center">Request Details</h3>
				<hr>
				{{-- "id" => 4
			    "request_number" => "1_DefC4R5Xnj_1573025948"
			    "description" => "123"
			    "borrow_date" => "2019-01-01 13:00:00"
			    "return_date" => "2019-05-02 01:00:00"
			    "quantity" => 123
			    "status_id" => 1
			    "user_id" => 1
			    "category_id" => 1
			    "asset_id" => null
			    --}}
				{{-- {{ dd($user_request) }} --}}

				<div class="row">
					<div class="offset-2 col-4">
						Request Number: 
					</div>
					<div class="col-4">
						{{ $user_request->request_number }}
					</div>
				</div>

				<div class="row">
					<div class="offset-2 col-4">
						User: 
					</div>
					<div class="col-4">
						{{ $user_request->user->name }}
					</div>
				</div>

				<div class="row">
					<div class="offset-2 col-4">
						Description: 
					</div>
					<div class="col-4">
						{{ $user_request->description }}
					</div>
				</div>

				<div class="row">
					<div class="offset-2 col-4">
						Borrow Date: 
					</div>
					<div class="col-4">
						{{ $user_request->borrow_date }}
					</div>
				</div>

				<div class="row">
					<div class="offset-2 col-4">
						Return Date: 
					</div>
					<div class="col-4">
						{{ $user_request->return_date }}
					</div>
				</div>

				<div class="row">
					<div class="offset-2 col-4">
						Status: 
					</div>
					<div class="col-4">
						{{ $user_request->status->name }}
					</div>
				</div>

				<div class="row">
					<div class="offset-2 col-4">
						Category: 
					</div>
					<div class="col-4">
						{{ $user_request->category->name }}
					</div>
				</div>

				<div class="row">
					<div class="offset-2 col-4">
						Quantity: 
					</div>
					<div class="col-4">
						{{ $user_request->quantity }}
					</div>
				</div>
				
				{{-- {{ dd($asset) }} --}}
				@if($user_request->asset_id)
					
					<div class="card col-6 mx-auto mt-4"> 
						<h3 class="card-title text-center">Assigned Asset</h3>
						<img class="card-img-top img-fluid" src="{{ url('/public/' . $asset->image) }}">
						<div class="card-body">
							<h5 class="card-title">{{ $asset->name }}</h5>
							<p class="card-text">
								Type: {{ $asset->category->name }}
							</p>
							<p class="card-text">
								Condition: {{ $asset->asset_status->name }}
							</p>
						</div>
						<div class="card-footer">
							<a href="{{ route('assets.show', ['asset' => $asset->id]) }}" class="btn btn-primary btn-outline-primary float-right"><small class="text-muted">View Item</small></a>
						</div>
					</div>
				</div>

				@endif


				{{-- <div class="mt-3">

					<button id="add" class="btn bg-info btn-raised col-3 mt-2">Add an Asset</button>

					<form action="{{ route('user_requests.update', ['user_request' => $user_request->id]) }} " method="POST">
						@csrf
						@method('PUT')
						<input type="hidden" name="request_id" value="{{ $user_request->id }} ">
						<div id='tickets' class='box-body' data-size={{ $user_request->quantity }} >
						    <!-- all the .row elements will be here -->
						</div>
						<button class="btn bg-primary btn-raised col-3 mt-3">Submit</button>
					</form>
				</div> --}}
				
			</div>
		</div>
	</div>
<script>
	function addRow()
        {

            var newRow = $('<div>', {class: "row mt-2"});
            newRow.append($("<p>", {class: "col-2"}).append("Quantity: "));
            newRow.append($('<div>', {class: "col-4"})
                    .append($('<input>', {type: "number", name: "quantity[]", class: "form-control", placeholder: "Quantity"})));
			
			var newRow2 = $('<div>', {class: "row mt-2"});
			newRow2.append($("<p>", {class: "col-2"}).append("Asset: "));
			newRow2.append($("<select>", {class:'form-control col-4 ml-2', name:'category_item_id[]'})
			@foreach($category_items as $category_item)
				
            	.append("<option value='{{$category_item->id}}'>{{$category_item->name}}</option>")
			
			@endforeach
            
            )
            $('.box-body').append(newRow).append(newRow2);
        }
</script>

@endsection