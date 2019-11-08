@extends('layouts.app')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-12 col-md-8 offset-2">
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

				<h2 class="mt-3 text-center">Return 
					{{-- ACCESS PIVOT --}}
					@foreach($user_request->assets as $asset)
						{{$asset->name}}
					@endforeach
				</h2>
				
				<div class="container-fluid">
					<div class="row">
						<div class="card-group col-12">


						@foreach($assets as $asset)
						{{-- {{dd($asset->id, $user_request->asset_id)}} --}}
							@if($asset->category_id == $user_request->category_id && $asset->id == $user_request->asset_id)
								<div class="card col-3"> 
									<div class="card-header">{{ $asset->sku_number }}</div>
									<img class="card-img-top img-fluid" src="{{ url('/public/' . $asset->image) }}">
									<div class="card-body">
										<h5 class="card-title">{{ $asset->name }}</h5>
										<p class="card-text">{{ $asset->category->name }}
											<span class="card-text badge float-right {{ ($asset->available == 1)? 'badge-success': 'badge-danger' }} ">
												{{ ($asset->available == 1) ? "Available: ": "Not Available: "}} {{$asset->quantity_available}} 
											</span>
										</p>
									</div>
									<div class="card-footer">

										<form action="{{ route('request_return', ['user_request' => $user_request->id]) }}" method="POST">
											@csrf
											@method('PUT')
											<input type="hidden" value="{{$asset->id}}" name="asset_id">
											<button class="btn btn-primary btn-outline-primary float-right"><small class="text-muted">Return Item</small></button>
										</form>
									</div>
								</div>
							@endif
						@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection