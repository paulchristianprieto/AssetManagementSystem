@extends('layouts.app')



@section('content')

<div class="container-fluid">
	<div class="row side-panel">
		<div class="col-2 bg-dark p-4">
			<div class="sticky-top">
				<div class="row m-4 " style="color:white;">
					<div class="col-12 text-center p-3" style="font-size: 24px;">
						<i class="far fa-user fa-5x"></i>
					</div>
					<div class="col-12 text-center">
						<h5 class="mt-2">{{Auth::user()->name}} </h5>
						<p>{{Auth::user()->email}} </p>
						<p>{{Auth::user()->role->name}} </p>
					</div>
				</div>
				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
					<a class="nav-link" href="{{ route('assets.create') }}">Add Asset</a>
					<a class="nav-link" href="{{ route('vendors.create') }}">Add Vendor</a>
					<a class="nav-link" href="{{ route('categories.create') }}">Add Category</a>
				</div>
			</div>
		</div>

		<div class="col-12 col-md-3 offset-1 py-3 bg-info rounded-lg my-4 p-5">
			{{-- Request details --}}
			<div class="sticky-top">
				<div class="row">
					<div class="col-12 ">
						<h3 class="text-center my-3 font-weight-bold float-left">Request Details:</h3>
					</div>
				</div>
				<hr>
				<div class="row mt-4">
					<div class="col-6">
						Request Number: 
					</div>
					<div class="col-6">
						<strong class="float-right text-capitalize">{{ $user_request->request_number }}</strong>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-6">
						Requestor Name: 
					</div>
					<div class="col-6">
						<strong class="float-right text-capitalize">{{ $user_request->user->name }}</strong>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-6">
						Borrow Date: 
					</div>
					<div class="col-6">
						<strong class="float-right">{{ \Carbon\Carbon::parse($user_request->borrow_date)->format('M d, Y @ H:i') }}</strong>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-6">
						Borrow Date: 
					</div>
					<div class="col-6">
						<strong class="float-right">{{ \Carbon\Carbon::parse($user_request->borrow_date)->format('M d, Y @ H:i') }}</strong>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-6">
						Return Date: 
					</div>
					<div class="col-6">
						<strong class="float-right">{{ \Carbon\Carbon::parse($user_request->return)->format('M d, Y @ H:i') }}</strong>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-6">
						Request Category: 
					</div>
					<div class="col-6">
						<strong class="float-right">{{ $user_request->category->name }}</strong>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-6">
						Request Quantity: 
					</div>
					<div class="col-6">
						<strong class="float-right">{{ $user_request->quantity }}</strong>
					</div>
				</div>
				<div class="row mt-2">
					<div class="col-6">
						Request Status: 
					</div>
					<div class="col-6">
						@if($user_request->status->id == 1)
							<strong class="float-right badge-warning badge">{{ $user_request->status->name }}</strong>
						@elseif($user_request->status->id == 2)
							<strong class="float-right badge-primary badge">{{ $user_request->status->name }}</strong>
						@elseif($user_request->status->id == 3)
							<strong class="float-right badge-success badge">{{ $user_request->status->name }}</strong>
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-5 py-3 ">
			{{-- Request asset --}}
			@if($user_request->status->id == 1)
				<div class="row">
					<div class="col-12">
						<div class="my-3">
							<h3 class="text-center">Available {{$user_request->category->name}} </h3>
						</div>
					</div>
				</div>

				<div class="row">
					@foreach ($assets as $asset)
					@if($asset->category_id == $user_request->category_id && $asset->quantity_available >= $user_request->quantity)
					<div class="col-6 p-2 mx-auto">
						<div class="card {{-- col-4 m-2 mx-auto --}} shadow p-3 mb-5 bg-white rounded">
							<div class="wrapper">
								<img class="card-img-top img-fluid" src="{{ url('/public/' . $asset->image) }}" alt="{{ $asset->name}}">
							</div>
							<h4 class="card-title text-center">{{ $asset->name }}</h4>
							<div class="row">
								<div class="col-12 mx-auto text-center">
									<span class="card-text badge  {{ ($asset->available == 1)? 'badge-success': 'badge-danger' }} ">
										{{ ($asset->available == 1) ? "Available: ": "Not Available: "}} {{$asset->quantity_available}} 
									</span>
									<span class="card-text badge  badge-warning">
										Lent: {{ $lent_items[$asset->id] }}
										{{-- {{ ($asset->available == 1) ? "Available: ": "Not Available: "}} {{$asset->quantity_available}}  --}}
									</span>
								</div>
							</div>
							<div class="card-body">
								<p class="card-text">Category: <strong class="float-right">{{ $asset->category->name }} </strong></p>
								<p class="card-text">Vendor: <strong class="float-right">{{ $asset->vendor->name }} </strong></p>
								<p class="card-text">SKU: <strong class="float-right" >{{ $asset->sku_number }}</strong></p>
								<p class="card-text">Condition: <strong class="float-right" >{{ $asset->asset_status->name }}</strong></p>
								<p class="card-text">Description: <strong class="float-right" >{{ $asset->description }}</strong></p>
								
								<div class="card-footer bg-transparent row ">
									<div class="col-6 mx-auto">
										<form action="{{ route('request_approve', ['user_request' => $user_request->id]) }}" method="POST">
											@csrf
											@method('PUT')
											<input type="hidden" value="{{$asset->id}}" name="asset_id">
											<button class="btn btn-primary btn-block">Assign Item</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					@endif
					@endforeach
				</div>
			@elseif($user_request->status->id == 2)
				<div class="row">
					<div class="col-12">
						<div class="my-3">
							<h3 class="text-center">Borrowed item</h3>
						</div>
					</div>
				</div>
				<div class="row">
					@foreach ($assets as $asset)
					@if($asset->category_id == $user_request->category_id && $asset->quantity_available >= $user_request->quantity)
					<div class="card mx-auto col-6 m-2 shadow p-3 mb-5 bg-white rounded">
						<div class="wrapper">
							<img class="card-img-top img-fluid" src="{{ url('/public/' . $asset->image) }}" alt="{{ $asset->name}}">
						</div>
						<h4 class="card-title text-center">{{ $asset->name }}</h4>
						<div class="row">
							<div class="col-12 mx-auto text-center">
								<span class="card-text badge  {{ ($asset->available == 1)? 'badge-success': 'badge-danger' }} ">
									{{ ($asset->available == 1) ? "Available: ": "Not Available: "}} {{$asset->quantity_available}} 
								</span>
								<span class="card-text badge  badge-warning">
									Lent: {{ $lent_items[$asset->id] }}
									{{-- {{ ($asset->available == 1) ? "Available: ": "Not Available: "}} {{$asset->quantity_available}}  --}}
								</span>
							</div>
						</div>
						<div class="card-body">
							<p class="card-text">Category: <strong class="float-right">{{ $asset->category->name }} </strong>
								
							</p>
							<p class="card-text">Vendor: <strong class="float-right">{{ $asset->vendor->name }} </strong>
								
							</p>
							<p class="card-text">SKU: <strong class="float-right" >{{ $asset->sku_number }}</strong></p>
							<p class="card-text">Condition: <strong class="float-right" >{{ $asset->asset_status->name }}</strong></p>
							<p class="card-text">Description: <strong class="float-right" >{{ $asset->description }}</strong></p>
							
							<div class="card-footer bg-transparent row ">
								
								<div class="col-12 mx-auto text-center">
									<form action="{{ route('request_return', ['user_request' => $user_request->id]) }}" method="POST">
										<div class="row">
											<div class="form-group col-12 ">
												<label for="asset_condition" class="float-left text-left">Condition: </label>
												<select class="form-control " id="vendor" name="vendor">
													@foreach ($asset_statuses as $asset_status)
														<option value="{{ $asset_status->id }}" >{{ $asset_status->name }}</option>
													@endforeach
											    </select>
											</div>
										</div>
										@csrf
										@method('PUT')
										<input type="hidden" value="{{$asset->id}}" name="asset_id">
										<button class="btn btn-primary btn-block col-8 mx-auto">Mark as Returned</button>
									</form>
								</div>
							</div>
						</div>
					</div>
					@endif
					@endforeach
				</div>
			@elseif($user_request->status->id == 3)
				<strong class="float-right badge-success badge">{{ $user_request->status->name }}</strong>
			@endif
			
		</div>
	</div>
</div>

{{-- <script>
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
 --}}
@endsection