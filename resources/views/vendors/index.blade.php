@extends('layouts.app')

@section('content')


<div class="container-fluid">
	<div class="row">
		<div class="col-12 col-md-8 offset-2">

			<h2 class="text-center">Vendors</h2>

			<div class="accordion" id="vendorsAccordion">

				@foreach ($vendors as $vendor)
				{{-- {{ dd($vendor) }} --}}

				<div class="card shadow bg-white rounded">
					<div class="card-header" id="headingOne">
						<h2 class="mb-0">
							<button 
								class="btn btn-block text-left" 
								type="button" 
								data-toggle="collapse" 
								data-target="#vendor-{{$vendor->id }}" 
								aria-expanded="false" 
								aria-controls="collapseOne">
								{{$vendor->name }} {{-- / {{ $vendor->created_at->format('F d, Y - h:i') }}   --}}
				
								
							</button>

						</h2>
					</div>

					<div id="vendor-{{$vendor->id }}" class="collapse" aria-labelledby="headingOne" data-parent="#vendorsAccordion">
						<div class="card-body">
							<h5 class="card-title text-center">Items</h5>

							<a href="{{ route('vendors.show', ['vendor' => $vendor->id])}}" class="btn btn-secondary btn-block my-1">View</a>
							<a href="{{ route('vendors.edit', ['vendor' => $vendor->id])}}" class="btn btn-warning btn-block my-1">Edit</a>
							<div class="table-responsive mb-3">

								<table class="table table-sm table-borderless">
									<tbody>
										<tr>
											<td>Customer Name:</td>
											{{-- <td><strong>{{$transaction->user->name }}</strong></td> --}}
										</tr>
										<tr>
											<td>Transaction Number:</td>
											{{-- <td><strong>{{ $transaction->transaction_number }}</strong></td> --}}
										</tr>
										<tr>
											<td>Mode of Payment:</td>
											{{-- <td>{{ $transaction->payment_mode->name }}</td> --}}
										</tr>
										<tr>
											<td>Status</td>
											{{-- <td>{{ $transaction->status->name }} --}}

												
										
										</tr>
										
										
									</tbody>
								</table>
							</div> {{-- End of table responsive --}}
						</div>
					</div>
				</div>

				@endforeach

			</div>
		</div>

		<div class="col-12 col-md-2">
			<p>Add Vendor <span><a href=" {{ route('vendors.create') }} " class="btn btn-success rounded-circle" >+</a></span></p>
		</div>

	</div>
</div>


@endsection