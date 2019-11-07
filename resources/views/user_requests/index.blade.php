@extends('layouts.app')


@section('content')
{{-- {{ dd($userRequests) }} --}}
<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-md-8 mx-auto">

			<h2 class="text-center">Requests</h2>

			<div class="accordion" id="requestsAccordion">
				@foreach ($userRequests as $request)

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

										<span class="badge {{($request->status_id == 1) ? "badge-warning":"badge-success"}} float-right ">
											{{ 	$request->status->name }}
										</span>

									</h5> 
									
									
								</button>
							</div>
							
							
							{{-- actions --}}
							<div class="col-3 text-center">
								<span>
									<a href="{{ route('user_requests.show', ['request' => $request->id])}}" class="btn btn-dark btn-raised bg-info">Assign</a>
								</span>

								<span>
									<a href="{{ route('user_requests.edit', ['request' => $request->id])}}" class="btn btn-dark btn-raised bg-warning">Reject</a>
								</span>

								{{-- <span class="float-right">
									<form action="{{ route('vendors.destroy', ['vendor' => $vendor->id ])}} " method="POST">
										@csrf
										@method('DELETE')
										<button class="btn btn-danger border-0">Remove</button>
									</form>
								</span> --}}
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
											<td>{{ $request->status->name }}

												@can('isAdmin')
												<form action="{{ route('user_requests.update', ['request'=> $request->id]) }} " method="POST" class="p-3 bg-secondary rounded">
													@csrf
													@method('PUT')

													<label for="edit-request-{{$request->id}}">Change Status</label>
													<button class="btn btn-primary mb-1 float-right ">Change Status</button>
													<span>
														<select class="custom-select mb-1" id="edit-request-{{$request->id}}" name="status">
															@foreach($statuses as $status)

																<option value="{{ $status->id}} " 
																	@if ($request->status_id == $status->id)
																		selected
																	@endif
																> {{$status->name }} </option>

															@endforeach
														</select>
													</span>
												</form>
												@endcan
											</td>
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

				@endforeach

		</div>
	</div>
</div>




@endsection