<x-app-layout>
	@push('css')
	<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
	@endpush

	@section('title', 'Client List')
	<x-slot name="header">
		<div class="page-title-wrapper">
			<div class="page-title-heading">
				<div class="page-title-icon">
					<i class="fas fa-compass"></i>
				</div>
				<div>
					<h4>Client List</h4>
				</div>
			</div>
			{{-- <div class="page-title-actions">
				<a href="{{ route('admin.bank.index') }}" type="button" class="btn btn-sm btn-dark">
					<i class="fas fa-arrow-left mr-1"></i>
					Back
				</a>
			</div> --}}
		</div>
	</x-slot>

	<!-- Main Content -->
	<div class="container-fluid">
		<div class="page-header">
			<div class="d-inline">
				@if (Session::has('error'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					{{Session::get('error')}}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
							<label for="connection_id">Choose Connection <span class="text-red">*</span></label>

							<select name="connection_id" id="connection_id" class="form-control">
                                <option value=""> Choose Connection</option>
                                @foreach ($data as $key => $item)
                                    <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                @endforeach
							</select>

							@error('connection_id')
							<span class="text-danger" role="alert">
								<p>{{ $message }}</p>
							</span>
							@enderror

						</div>
					</div>

				</div>

				<div class="row mt-30">
					<div class="col-sm-12">
						<button type="submit" id="search" class="btn btn-sm btn-primary float-left search"> Submit</button>
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
									<th> SN </th>
									<th> ID </th>
									<th> Name </th>
									<th> Amount </th>
									<th> Contact </th>
									<th> IP Address </th>
									<th> Address </th>
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
			var connection_id = $("#connection_id").val();
			var x = 1;

			var table =  $('#example').DataTable({
				order: [],
				lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
				processing: true,
				serverSide: true,
				"bDestroy": true,
				language: {
					processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
				},

				ajax: {
					url: "{{route('admin.report-connections')}}",
					type: "POST",
					data:{
						'connection_id':connection_id,
					},
				},
				columns: [
				{
					"render": function() {
						return x++;
					}
				},
				{data: 'subscriber_id', name: 'subscriber_id'},
				{data: 'name', name: 'name'},
				{data: 'packages.amount', name: 'packages'},
				{data: 'contact_no', name: 'contact_no'},
				{data: 'ip_address', name: 'ip_address'},
				{data: 'action', searchable: false, orderable: false},
             ],
			});
		});
	</script>
	@endpush
</x-app-layout>
