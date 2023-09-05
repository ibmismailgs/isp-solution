<x-app-layout>
	@push('css')
	<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
	@endpush

	@section('title', 'Client Billing History')
	<x-slot name="header">
		<div class="page-title-wrapper">
			<div class="page-title-heading">
				<div class="page-title-icon">
					<i class="fas fa-compass"></i>
				</div>
				<div>
					<h4>Client Billing History</h4>
				</div>
			</div>
		</div>
	</x-slot>

	<div class="container-fluid">
		<div class="page-header">
			<div class="d-inline">
				@if (Session::has('error'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					{{Session::get('error')}}
					<button title="Close Button" type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				@endif
			</div>
		</div>
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label for="subscriber_id">Choose Client <span class="text-red">*</span></label>

							<select name="subscriber_id" id="subscriber_id" class="form-control">
                                <option value=""> Choose Client</option>
                                @foreach ($data as $key => $item)
                                    <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                @endforeach
							</select>

							@error('subscriber_id')
							<span class="text-danger" role="alert">
								<p>{{ $message }}</p>
							</span>
							@enderror

						</div>
					</div>

				</div>

				<div class="row mt-30">
					<div class="col-sm-12">
						<button title="Submit Button" type="submit" id="search" class="btn btn-sm btn-primary float-left search"> Submit</button>
					</div>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<table id="example" class="table table-hover table-bordered ">
							<thead>
								<tr>
									<th>SN</th>
                                    <th>Billing Month</th>
                                    <th>Packages</th>
                                    <th>Connections </th>
                                    <th>Status</th>
                                    <th>Amount</th>
								</tr>
							</thead>

							<tbody>

							</tbody>

						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
	@push('js')
	<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
	<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
	<script>

		$('#search').on('click',function(event){
			event.preventDefault();
			var subscriber_id = $("#subscriber_id").val();
			var x = 1;

			var table =  $('#example').DataTable({
				order: [],
				lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
				processing: true,
				serverSide: true,
				"bDestroy": true,


				ajax: {
					url: "{{route('admin.billing-clients')}}",
					type: "POST",
					data:{
						'subscriber_id':subscriber_id,
					},
				},
				columns: [
				{
					"render": function() {
						return x++;
					}
				},
				{data: 'billing_month', name: 'billing_month'},
				{data: 'current_package', name: 'current_package'},
				{data: 'current_connection', name: 'current_connection'},
				{data: 'status', name: 'status'},
				{data: 'total_amount', name: 'total_amount'},
             ],
			});
		});
	</script>
	@endpush
</x-app-layout>
