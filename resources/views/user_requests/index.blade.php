@extends('layouts.app')


@section('content')
{{-- {{ dd($userRequests) }} --}}
<div class="container-fluid">
	<div class="row">
		<div class="col-2">
			<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
				{{-- <a class="nav-link" href="{{ route('assets.create') }}">Add Asset</a> --}}

				<p class="nav-link">Filter By Categories: </p>
				{{-- {{dd($categories)}} --}}
				@foreach($categories as $category)
					<a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">{{$category->name}}</a>
				@endforeach

			</div>
		</div>

		<div class="col-12 col-md-8 ">

			<nav>
				<div class="nav nav-tabs" id="nav-tab" role="tablist">
					<a class="nav-item nav-link active" id="nav-pending-tab" data-toggle="tab" href="#nav-pending" role="tab" aria-controls="nav-pending" aria-selected="true">Pending Requests</a>
					<a class="nav-item nav-link" id="nav-approved-tab" data-toggle="tab" href="#nav-approved" role="tab" aria-controls="nav-approved" aria-selected="false">Approved Requests</a>
					<a class="nav-item nav-link" id="nav-completed-tab" data-toggle="tab" href="#nav-completed" role="tab" aria-controls="nav-completed" aria-selected="false">Completed Requests</a>
				</div>
			</nav>

			<div class="tab-content" id="nav-tabContent">
				<div class="tab-pane fade show active" id="nav-pending" role="tabpanel" aria-labelledby="nav-pending-tab">
					<div class="row my-4">
						<div class="col-12 text-uppercase text-center">
							<h2 class="font-weight-bold">Pending Requests</h2>
						</div>
					</div>
					<div class="row" >
						<div class="col-10 mx-auto">
							<div class="accordion " id="requestsAccordion">
								@foreach ($userRequests as $request)
									@if($request->status_id == 1)
										{{-- {{ dd($request->category->name) }} --}}
										<div class="card shadow bg-white rounded">
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
													
													{{-- @can('isAdmin')
														<div class="col-3 text-center">
															<span>
																<a href=" {{ route('user_requests.show', ['user_request'=>$request->id]) }} " class="btn btn-success btn-outline-dark">View</a>
																<a href="{{ route('request_assign', ['user_request'=>$request->id]) }}" class="btn btn-info btn-outline-dark" >Approve</a>
															</span>
														</div>
													@endcan --}}
												</div>
											</div>

											<div id="request-{{$request->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#requestsAccordion">
												<div class="card-body ">
													{{-- Table --}}
													<div class="table-responsive table-bordered table-striped">
														<table class="table">
															<thead class="thead-dark">
																<tr>
																	<th scope="col"><strong>Request</strong></th>
																	<th scope="col">User</th>
																	<th scope="col">Description</th>
																	<th scope="col">Borrow Date</th>
																	<th scope="col">Return Date</th>
																	<th scope="col">Category</th>
																	<th scope="col">Quantity</th>
																	<th scope="col">Status</th>
																	<th scope="col">Action</th>
																</tr>
															</thead>
															<tbody>
																<tr>
																	<th scope="row">{{$request->request_number}} </th>
																	<td>{{$request->user->name}}</td>
																	<td>{{$request->description}}</td>
																	<td>{{$request->borrow_date}}</td>
																	<td>{{$request->return_date}}</td>
																	<td>{{$request->category->name}}</td>
																	<td>{{$request->quantity}}</td>
																	<td> <p class="badge badge-warning ">{{$request->status->name}}</p></td>
																	<td> 
																		<a href=" {{ route('user_requests.show', ['user_request'=>$request->id]) }} " class="btn btn-success btn-block btn-outline-dark">View</a>
																		<a href="{{ route('request_assign', ['user_request'=>$request->id]) }}" class="btn btn-info btn-block btn-outline-dark" >Approve</a>
																	</td>
																</tr>
														</table>
													</div>
													{{--  --}}
													<div class="my-3">
														<h3 class="text-center">Assets Available</h3>
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
				<div class="tab-pane fade" id="nav-approved" role="tabpanel" aria-labelledby="nav-approved-tab">...</div>
				<div class="tab-pane fade" id="nav-completed" role="tabpanel" aria-labelledby="nav-completed-tab">...</div>
			</div>

			<h2 class="text-center">Pending Requests</h2>

			<div class="accordion" id="requestsAccordion">
				@foreach ($userRequests as $request)
					@if($request->status_id == 1)
						{{-- {{ dd($request->category->name) }} --}}
						<div class="card shadow bg-white rounded">
							<div class="card-header" id="headingOne">
								<div class="row">
									<div class="col-9 ">
										<button 
											class="btn btn-block text-left" 
											type="button" 
											data-toggle="collapse" 
											data-target="#request-{{$request->id }}" 
											aria-expanded="false" 
											aria-controls="collapseOne">
											<h5 class="btn-block">
												<strong><span class="float-left">{{$request->request_number }}</span></strong>

												<span class="badge {{($request->status_id == 1) ? "badge-warning":"badge-success"}} float-right ">
													{{ 	$request->status->name }}
												</span>

											</h5> 
											
											
										</button>
									</div>
									
									@can('isAdmin')
									{{-- actions --}}
										<div class="col-3 text-center">
											<span>
												
												<a href="{{ route('request_assign', ['user_request'=>$request->id]) }}" class="btn btn-dark btn-raised bg-info">Approve</a>
												
											</span>

											{{-- <span class="float-right">
												<form action="{{ route('vendors.destroy', ['vendor' => $vendor->id ])}} " method="POST">
													@csrf
													@method('DELETE')
													<button class="btn btn-danger border-0">Remove</button>
												</form>
											</span> --}}
										</div>
									@endcan
								</div>

							</div>

							<div id="request-{{$request->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#requestsAccordion">
								<div class="card-body">
									<h5 class="card-title text-center">Summary</h5>
									<div class="table-responsive mb-3">

										<table class="table table-sm table-borderless">
											<tbody>
												<tr>
													<td>User Name:</td>
													<td><strong>{{$request->user->name }}</strong></td>
												</tr>
												<tr>
													<td>Request Number:</td>
													<td><strong>{{ $request->request_number }}</strong></td>
												</tr>
												<tr>
													<td>Status</td>
													<td> <span class="badge-warning badge">{{ $request->status->name }}</span></td>
												</tr>
												<tr>
													<td>Date</td>
													<td>{{$request->created_at->format('F d, Y')}}</td>
												</tr>
												<tr>
													<td>Total</td>
													<td> &#8369; {{ number_format($request->total, 2) }} </td>
												</tr>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="2">
															{{-- {{dd($request->id) }} --}}
														<a href=" {{ route('user_requests.show', ['user_request'=>$request->id]) }} " class="page-link text-center rounded">View Details</a>
													</td>
												</tr>
											</tfoot>
										</table>

									</div>
								</div>
							</div>
						</div>
					
					@endif
				@endforeach
			</div>

		</div>

	</div>

<div class="container-fluid mt-5">
	<div class="row">
		<div class="col-12 col-md-8 mx-auto">

			<h2 class="text-center">Approved Requests</h2>

			<div class="accordion" id="requestsAccordion">
				@foreach ($userRequests as $request)
					@if($request->status_id == 2)
						{{-- {{ dd($request->category->name) }} --}}

						<div class="card shadow bg-white rounded">
							<div class="card-header" id="headingOne">
								<div class="row">
									<div class="col-9">
										<button 
											class="btn btn-block text-left" 
											type="button" 
											data-toggle="collapse" 
											data-target="#request-{{$request->id }}" 
											aria-expanded="false" 
											aria-controls="collapseOne">
											<h5 class="btn-block">
												<strong><span class="float-left">{{$request->request_number }}</span></strong>

												<span class="badge {{($request->status_id == 2) ? "badge-primary":""}} float-right ">
													{{ 	$request->status->name }}
												</span>

											</h5> 
											
											
										</button>
									</div>
									
									
									{{-- actions --}}
									{{-- APPROVED TRANSACTIONS BUTTON --}}
									@can('isAdmin')

									<div class="col-3 float-right">
										<span>
											<a href="{{ route('request_returnpage', ['user_request'=>$request->id]) }}" class="btn btn-dark btn-raised bg-success">Mark as Returned</a>
										</span>

										{{-- <span class="float-right">
											<form action="{{ route('vendors.destroy', ['vendor' => $vendor->id ])}} " method="POST">
												@csrf
												@method('DELETE')
												<button class="btn btn-danger border-0">Remove</button>
											</form>
										</span> --}}
									</div>

									@endcan
								</div>

							</div>

							<div id="request-{{$request->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#requestsAccordion">
								<div class="card-body">
									<h5 class="card-title text-center">Summary</h5>
									<div class="table-responsive mb-3">

										<table class="table table-sm table-borderless">
											<tbody>
												<tr>
													<td>User Name:</td>
													<td><strong>{{$request->user->name }}</strong></td>
												</tr>
												<tr>
													<td>Request Number:</td>
													<td><strong>{{ $request->request_number }}</strong></td>
												</tr>
												<tr>
													<td>Status</td>
													<td> <span class="badge-primary badge">{{ $request->status->name }}</span></td>
												</tr>
												<tr>
													<td>Date</td>
													<td>{{$request->created_at->format('F d, Y')}}</td>
												</tr>
												<tr>
													<td>Total</td>
													<td> &#8369; {{ number_format($request->total, 2) }} </td>
												</tr>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="2">
															{{-- {{dd($request->id) }} --}}
														<a href=" {{ route('user_requests.show', ['user_request'=>$request->id]) }} " class="page-link text-center rounded">View Details</a>
													</td>
												</tr>
											</tfoot>
										</table>

									</div>
								</div>
							</div>
						</div>
					@endif
				@endforeach

		</div>
	</div>
	
</div>


<div class="container-fluid mt-5">
	<div class="row">
		<div class="col-12 col-md-8 mx-auto">

			<h2 class="text-center">Completed Requests</h2>

			<div class="accordion" id="requestsAccordion">
				@foreach ($userRequests as $request)
					@if($request->status_id == 3)
						{{-- {{ dd($request->category->name) }} --}}

						<div class="card shadow bg-white rounded">
							<div class="card-header" id="headingOne">
								<div class="row">
									<div class="col-12">
										<button 
											class="btn btn-block text-left" 
											type="button" 
											data-toggle="collapse" 
											data-target="#request-{{$request->id }}" 
											aria-expanded="false" 
											aria-controls="collapseOne">
											<h5 class="btn-block">
												<strong><span class="float-left">{{$request->request_number }}</span></strong>

												<span class="badge badge-success float-right ">
													{{ 	$request->status->name }}
												</span>

											</h5> 
											
											
										</button>
									</div>
								</div>

							</div>

							<div id="request-{{$request->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#requestsAccordion">
								<div class="card-body">
									<h5 class="card-title text-center">Summary</h5>
									<div class="table-responsive mb-3">

										<table class="table table-sm table-borderless">
											<tbody>
												<tr>
													<td>User Name:</td>
													<td><strong>{{$request->user->name }}</strong></td>
												</tr>
												<tr>
													<td>Request Number:</td>
													<td><strong>{{ $request->request_number }}</strong></td>
												</tr>
												<tr>
													<td>Status</td>
													<td> <span class="badge-success badge">{{ $request->status->name }}</span></td>
												</tr>
												<tr>
													<td>Date</td>
													<td>{{$request->created_at->format('F d, Y')}}</td>
												</tr>
												<tr>
													<td>Total</td>
													<td> &#8369; {{ number_format($request->total, 2) }} </td>
												</tr>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="2">
															{{-- {{dd($request->id) }} --}}
														<a href=" {{ route('user_requests.show', ['user_request'=>$request->id]) }} " class="page-link text-center rounded">View Details</a>
													</td>
												</tr>
											</tfoot>
										</table>

									</div>
								</div>
							</div>
						</div>
					@endif
				@endforeach
		</div>
	</div>
</div>




@endsection