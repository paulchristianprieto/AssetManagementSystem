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
						<h2 class="mb-0">
							<button 
								class="btn btn-block text-left" 
								type="button" 
								data-toggle="collapse" 
								data-target="#request-{{$request->id }}" 
								aria-expanded="false" 
								aria-controls="collapseOne">
								{{$request->request_number }} / {{ $request->category->name }}  
								{{-- @if (Session::has('transaction_updated') && Session::get('transaction_updated') == $transaction->id )
									<span class="badge badge-info"> Status Updated </span>
								@endif --}}

								{{-- @if ($transaction->status->name == "Pending")
									<span class="badge badge-warning float-right">{{$transaction->status->name }}</span>

								@else
									<span class="badge badge-success float-right">{{$transaction->status->name }}</span>

								@endif --}}
								
							</button>

						</h2>
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
												<form action="{{ route('requests.update', ['request'=> $request->id]) }} " method="POST" class="p-3 bg-secondary rounded">
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
												<a href=" {{ route('requests.show', ['request'=>$request->id]) }} " class="page-link text-center rounded">View Details</a>
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