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

				<button id="add">Add an Asset</button>

				<form action="{{ route('user_requests.update', ['user_request' => $user_request->id]) }} " method="POST">
					@csrf
					@method('PUT')
					<div id='tickets' class='box-body' data-size={{ $user_request->quantity }} >
					    <!-- all the .row elements will be here -->
					</div>
					<button>Submit</button>
				</form>

				
			</div>
		</div>
	</div>


<script>
	function addRow()
        {

            var newRow = $('<div>', {class: "row"});
            newRow.append($('<div>', {class: "col-xs-4"})
                    .append($('<input>', {type: "number", name: "quantity[]", class: "form-control", placeholder: "Quantity"})));
			newRow.append($("<select>", {class:'form-control', id:'d', name:'category[]'})
			@foreach($category_items as $category_item)
				
            	.append("<option value='1''>{{$category_item->name}}</option>")
			
			@endforeach
            
            )
            $('.box-body').append(newRow);
        }
</script>

@endsection