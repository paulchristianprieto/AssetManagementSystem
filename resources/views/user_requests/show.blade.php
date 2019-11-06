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

				<form action="#" method="POST">
					@for ($i = 1; $i <= $user_request->quantity ; $i++)
						<p>Assign an item  <span><button>Assign</button></span> </p>

					@endfor
				</form>

			</div>
		</div>
	</div>

@endsection