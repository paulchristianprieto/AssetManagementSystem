@extends('layouts.app')


@section('content')
{{-- {{ dd($userRequests) }} --}}
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
					<a class="nav-link" href="{{ route('assets.create') }}"><i class="fas fa-plus-circle"></i> Add Asset</a>
					<a class="nav-link" href="{{ route('vendors.create') }}"><i class="fas fa-plus-circle"></i> Add Vendor</a>
					<a class="nav-link" href="{{ route('categories.create') }}"><i class="fas fa-plus-circle"></i> Add Category</a>
				</div>
				<p class="nav-link mb-0 mt-2">Filter By Categories: </p>
				@foreach($categories as $category)
					<a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">{{$category->name}}</a>
				@endforeach
			</div>
		</div>

		<div class="col-12 col-md-8 mx-auto py-3">

			<nav>
				<div class="nav nav-tabs" id="nav-tab" role="tablist">
					<a class="nav-item nav-link active" id="nav-pending-tab" data-toggle="tab" href="#nav-pending" role="tab" aria-controls="nav-pending" aria-selected="true">Pending Requests</a>
					<a class="nav-item nav-link" id="nav-approved-tab" data-toggle="tab" href="#nav-approved" role="tab" aria-controls="nav-approved" aria-selected="false">Approved Requests</a>
					<a class="nav-item nav-link" id="nav-completed-tab" data-toggle="tab" href="#nav-completed" role="tab" aria-controls="nav-completed" aria-selected="false">Completed Requests</a>
				</div>
			</nav>

			@if (Session::has('request_destroy_success'))
	            <div class="row">
	                <div class="col-12 mt-2">
	                    <div class="alert alert-success">
	                        {{ Session::get('request_destroy_success') }}
	                    </div>
	                </div>
	            </div>
	        @endif

			<div class="tab-content" id="nav-tabContent">
				<div class="tab-pane fade show active" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
					<div class="row my-4">
						<div class="col-12 text-uppercase text-center">
							<h2 class="font-weight-bold">Pending Requests</h2>
						</div>
					</div>

					<div class="row" >
						<div class="col-12 mx-auto">
							<div class="accordion " id="requestsAccordion">
								@foreach ($userRequests as $request)
									@if($request->status_id == 1)
										{{-- {{ dd($request->category->name) }} --}}
										<div class="card shadow bg-white rounded ">
											<div class="card-header" id="headingOne">
												<div class="row">
													<div class="{{ (Auth::user()->role_id === 2) ? "col-12": "col-12"}} ">
														<button 
															class="btn btn-block text-left" 
															type="button" 
															data-toggle="collapse" 
															data-target="#request-{{$request->id }}" 
															aria-expanded="false" 
															aria-controls="collapseOne">
															<h5 class="btn-block text-capitalize">
																<strong><span class="float-left">Name: {{$request->user->name}} | Request: {{$request->category->name }} | Quantity: {{$request->quantity}} </span></strong>

																<span class="badge {{($request->status_id == 1) ? "badge-warning":"badge-success"}} float-right ">
																	{{ 	$request->status->name }}
																</span>

															</h5> 
															
															
														</button>
													</div>
												</div>
											</div>

											<div id="request-{{$request->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#requestsAccordion">
												<div class="card-body ">
													{{-- Table --}}
													<div class="table-responsive table-bordered table-striped table-hover">
														<table class="table">
															<thead class="thead-dark">
																<tr>
																	<th scope="col"><strong>Request</strong></th>
																	<th scope="col">User</th>
																	@if($request->description)
																		<th scope="col">Description</th>
																	@endif
																	
																	<th scope="col">Borrow Date</th>
																	<th scope="col">Return Date</th>
																	<th scope="col">Category</th>
																	<th scope="col">Quantity</th>
																	<th scope="col">Status</th>
																	@can('isAdmin')
																	<th scope="col">Actions</th>
																	@endcan

																</tr>
															</thead>
															<tbody>
																<tr>
																	<th scope="row">{{$request->request_number}} </th>
																	<td>{{$request->user->name}}</td>
																	@if($request->description)
																		<td>{{$request->description}}</td>
																	@endif
																	<td>{{ \Carbon\Carbon::parse($request->borrow_date)->format('M d, Y @ H:i') }}</td>
																	<td>{{ \Carbon\Carbon::parse($request->return_date)->format('M d, Y @ H:i') }}</td>
																	<td>{{$request->category->name}}</td>
																	<td>{{$request->quantity}}</td>
																	<td> <p class="badge badge-warning ">{{$request->status->name}}</p></td>
																	@can('isAdmin')
																	    
																	<td>
																		<a href=" {{ route('user_requests.show', ['user_request'=>$request->id]) }} " class="btn btn-primary btn-block">View</a>
																		<form action="{{ route('user_requests.destroy', ['user_request' => $request->id ])}} " method="POST">
																			@csrf
																			@method('DELETE')
																			<button class="btn btn-danger btn-block mt-2">Decline</button>
																		</form>
																	</td>
																	@endcan
																	{{-- <td> 
																		<a href=" {{ route('user_requests.show', ['user_request'=>$request->id]) }} " class="btn btn-success btn-block btn-outline-dark">View</a>
																		<a href="{{ route('request_assign', ['user_request'=>$request->id]) }}" class="btn btn-info btn-block btn-outline-dark" >Approve</a>
																	</td> --}}
																</tr>
														</table>
													</div>
													{{-- Assigning assets --}}
													<div class="container-fluid">
														<div class="row">
															<div class="col-12">
																<div class="my-3">
																	<h3 class="text-center">Available {{$request->category->name}} </h3>
																</div>
															</div>
														</div>
														<div class="row">
															@foreach ($assets as $asset)
															@if($asset->category_id == $request->category_id && $asset->quantity_available >= $request->quantity)
															<div class="col-4 p-2 mx-auto">
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
																		@can('isAdmin')
																	    
																		<div class="card-footer bg-transparent row ">
																			<div class="col-6 mx-auto">
																				<form action="{{ route('request_approve', ['user_request' => $request->id]) }}" method="POST">
																					@csrf
																					@method('PUT')
																					<input type="hidden" value="{{$asset->id}}" name="asset_id">
																					<button class="btn btn-primary btn-block">Assign Item</button>
																				</form>
																			</div>
																		</div>
																		@endcan

																	</div>
																</div>
															</div>
															@endif
															@endforeach
														</div>
													</div>													
												</div>
											</div>
										</div>
									
									@endif
								@endforeach
							</div>
						</div>
					</div>
				</div>
				{{-- End of pending requests --}}
				<div class="tab-pane fade" id="nav-approved" role="tabpanel" aria-labelledby="nav-approved-tab">
					<div class="row my-4">
						<div class="col-12 text-uppercase text-center">
							<h2 class="font-weight-bold">Approved Requests</h2>
						</div>
					</div>
					<div class="row" >
						<div class="col-12 mx-auto">
							<div class="accordion " id="requestsAccordion">
								@foreach ($userRequests as $request)
									@if($request->status_id == 2)
										{{-- {{ dd($request->category->name) }} --}}
										<div class="card shadow bg-white rounded ">
											<div class="card-header" id="headingOne">
												<div class="row">
													<div class="{{ (Auth::user()->role_id === 2) ? "col-12": "col-12"}} ">
														<button 
															class="btn btn-block text-left" 
															type="button" 
															data-toggle="collapse" 
															data-target="#request-{{$request->id }}" 
															aria-expanded="false" 
															aria-controls="collapseOne">
															<h5 class="btn-block text-capitalize">
																<strong><span class="float-left">Name: {{$request->user->name}} | Request: {{$request->category->name }} | Quantity: {{$request->quantity}} </span></strong>

																<span class="badge {{($request->status_id == 1) ? "badge-warning":"badge-success"}} float-right ">
																	{{ 	$request->status->name }}
																</span>

															</h5> 
															
															
														</button>
													</div>
												</div>
											</div>
											<span>
											

											<div id="request-{{$request->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#requestsAccordion">
												<div class="card-body ">
													{{-- Table --}}
													<div class="table-responsive table-bordered table-striped table-hover">
														<table class="table">
															<thead class="thead-dark">
																<tr>
																	<th scope="col"><strong>Request</strong></th>
																	<th scope="col">User</th>
																	@if($request->description)
																		<th scope="col">Description</th>
																	@endif
																	
																	<th scope="col">Borrow Date</th>
																	<th scope="col">Return Date</th>
																	<th scope="col">Category</th>
																	<th scope="col">Quantity</th>
																	<th scope="col">Status</th>
																
																	    
																	<th scope="col">Actions</th>
																	
																</tr>
															</thead>
															<tbody>
																<tr>
																	<th scope="row">{{$request->request_number}} </th>
																	<td>{{$request->user->name}}</td>
																	@if($request->description)
																		<td>{{$request->description}}</td>
																	@endif
																	<td>{{ \Carbon\Carbon::parse($request->borrow_date)->format('M d, Y @ H:i') }}</td>
																	<td>{{ \Carbon\Carbon::parse($request->return_date)->format('M d, Y @ H:i') }}</td>
																	<td>{{$request->category->name}}</td>
																	<td>{{$request->quantity}}</td>
																	<td> <p class="badge badge-warning ">{{$request->status->name}}</p></td>
																	<td>
																		<a href=" {{ route('user_requests.show', ['user_request'=>$request->id]) }} " class="btn btn-primary btn-block">View</a>
																		{{-- <form action="{{ route('user_requests.destroy', ['user_request' => $request->id ])}} " method="POST">
																			@csrf
																			@method('DELETE')
																			<button class="btn btn-danger btn-block mt-2">Delete</button>
																		</form> --}}
																	</td>
																	{{-- <td> 
																		<a href=" {{ route('user_requests.show', ['user_request'=>$request->id]) }} " class="btn btn-success btn-block btn-outline-dark">View</a>
																		<a href="{{ route('request_assign', ['user_request'=>$request->id]) }}" class="btn btn-info btn-block btn-outline-dark" >Approve</a>
																	</td> --}}
																</tr>
														</table>
													</div>
													{{-- Assigning assets --}}
													<div class="container-fluid">
														<div class="row">
															<div class="col-12">
																<div class="my-3">
																	<h3 class="text-center">Borrowed item</h3>
																</div>
															</div>
														</div>
														<div class="row">
															
															@foreach ($assets as $asset)
															@if( $asset->id == $request->asset_id )
															<div class="card mx-auto col-4 m-2 shadow p-3 mb-5 bg-white rounded">
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
																	@can('isAdmin')
																	
																	<div class="card-footer bg-transparent row ">
																		
																		<div class="col-12 mx-auto text-center">
																			<form action="{{ route('request_return', ['user_request' => $request->id]) }}" method="POST">
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
																	@endcan
																</div>
															</div>
															@endif
															@endforeach
														</div>
													</div>													
												</div>
											</div>
										</div>
									
									@endif
								@endforeach
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="nav-completed" role="tabpanel" aria-labelledby="nav-completed-tab">
					<div class="row my-4">
						<div class="col-12 text-uppercase text-center">
							<h2 class="font-weight-bold">Completed Requests</h2>
						</div>
					</div>
					<div class="row" >
						<div class="col-12 mx-auto">
							<div class="accordion " id="requestsAccordion">
								@foreach ($userRequests as $request)
									@if($request->status_id == 3)
										{{-- {{ dd($request->category->name) }} --}}
										<div class="card shadow bg-white rounded ">
											<div class="card-header" id="headingOne">
												<div class="row">
													<div class="{{ (Auth::user()->role_id === 2) ? "col-12": "col-12"}} ">
														<button 
															class="btn btn-block text-left" 
															type="button" 
															data-toggle="collapse" 
															data-target="#request-{{$request->id }}" 
															aria-expanded="false" 
															aria-controls="collapseOne">
															<h5 class="btn-block text-capitalize">
																<strong><span class="float-left">Name: {{$request->user->name}} | Request: {{$request->category->name }} | Quantity: {{$request->quantity}} </span></strong>

																<span class="badge {{($request->status_id == 1) ? "badge-warning":"badge-success"}} float-right ">
																	{{ 	$request->status->name }}
																	
																</span>
															</h5> 
														</button>
													</div>
												</div>
											</div>

											<div id="request-{{$request->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#requestsAccordion">
												<div class="card-body ">
													{{-- Table --}}
													<div class="table-responsive table-bordered table-striped table-hover">
														<table class="table">
															<thead class="thead-dark">
																<tr>
																	<th scope="col"><strong>Request</strong></th>
																	<th scope="col">User</th>
																	@if($request->description)
																		<th scope="col">Description</th>
																	@endif
																	
																	<th scope="col">Borrow Date</th>
																	<th scope="col">Return Date</th>
																	<th scope="col">Category</th>
																	<th scope="col">Quantity</th>
																	<th scope="col">Status</th>
																	@can('isAdmin')
																	<th scope="col">Actions</th>
																	@endcan
																</tr>
															</thead>
															<tbody>
																<tr>
																	<th scope="row">{{$request->request_number}} </th>
																	<td>{{$request->user->name}}</td>
																	@if($request->description)
																		<td>{{$request->description}}</td>
																	@endif
																	<td>{{ \Carbon\Carbon::parse($request->borrow_date)->format('M d, Y @ H:i') }}</td>
																	<td>{{ \Carbon\Carbon::parse($request->return_date)->format('M d, Y @ H:i') }}</td>
																	<td>{{$request->category->name}}</td>
																	<td>{{$request->quantity}}</td>
																	<td> <p class="badge badge-warning ">{{$request->status->name}}</p></td>
																	@can('isAdmin')
																	<td>
																		<a href=" {{ route('user_requests.show', ['user_request'=>$request->id]) }} " class="btn btn-primary btn-block">View</a>
																		{{-- <form action="{{ route('user_requests.destroy', ['user_request' => $request->id ])}} " method="POST">
																			@csrf
																			@method('DELETE')
																			<button class="btn btn-danger btn-block mt-2">Delete</button>
																		</form> --}}
																	</td>
																	@endcan
																	{{-- <td> 
																		<a href=" {{ route('user_requests.show', ['user_request'=>$request->id]) }} " class="btn btn-success btn-block btn-outline-dark">View</a>
																		<a href="{{ route('request_assign', ['user_request'=>$request->id]) }}" class="btn btn-info btn-block btn-outline-dark" >Approve</a>
																	</td> --}}
																</tr>
														</table>
													</div>
													{{-- Assigning assets --}}
													<div class="container-fluid">
														<div class="row">
															<div class="col-12">
																<div class="my-3">
																	<h3 class="text-center">Assigned Asset </h3>
																</div>
															</div>
														</div>
														<div class="row">
															@foreach ($assets as $asset)
															@if($asset->category_id == $request->category_id && $asset->quantity_available >= $request->quantity)
															<div class="card mx-auto col-4 m-2 shadow p-3 mb-5 bg-white rounded">
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
																	
																	
																</div>
															</div>
															@endif
															@endforeach
														</div>
													</div>													
												</div>
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
	</div>
</div>




@endsection