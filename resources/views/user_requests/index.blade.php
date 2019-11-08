@extends('layouts.app')


@section('content')
{{-- {{ dd($userRequests) }} --}}
<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-md-8 mx-auto">

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