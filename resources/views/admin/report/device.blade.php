<x-app-layout>
	@push('css')
	<link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
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
					<h4>Client List By Devices</h4>
				</div>
			</div>
		</div>
	</x-slot>

	<!-- Main Content -->
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
							<label for="device_id">Choose Devices <span class="text-red">*</span></label>

							<select name="device_id" id="device_id" class="form-control">
                                <option value="">Choose device</option>
                                @foreach ($data as $key => $item)
                                    <option value="{{ $item->id }}"> {{ $item->name }} </option>
                                @endforeach
							</select>

							@error('device_id')
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
									<th> SN </th>
									<th> ID </th>
									<th> Name </th>
									<th> Amount </th>
									<th> Contact </th>
									<th> IP Address </th>
									<th> Action </th>
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
	<script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
	<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
	<script>

		$('#search').on('click',function(event){
			event.preventDefault();
			var device_id = $("#device_id").val();

			var table =  $('#example').DataTable({
				order: [],
				lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
				processing: true,
				serverSide: true,
				"bDestroy": true,

				ajax: {
					url: "{{route('admin.report-devices')}}",
					type: "POST",
					data:{
						'device_id':device_id,
					},
				},
				columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'subscriber_id', name: 'subscriber_id'},
				{data: 'name', name: 'name'},
				{data: 'package_amount', name: 'package_amount'},
				{data: 'contact_no', name: 'contact_no'},
				{data: 'ip_address', name: 'ip_address'},
				{data: 'action', searchable: false, orderable: false},
             ],
             dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [
                            {
                                extend: 'copy',
                                className: 'btn-sm btn-info',
                                title: 'Devices',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                }
                            },
                            {
                                extend: 'csv',
                                className: 'btn-sm btn-success',
                                title: 'Devices',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                }
                            },
                            {
                                extend: 'excel',
                                className: 'btn-sm btn-dark',
                                title: 'Devices',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                }
                            },
                            {
                                extend: 'pdf',
                                className: 'btn-sm btn-primary',
                                title: 'Devices',
                                pageSize: 'A2',
                                header: true,
                                footer: true,
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                }
                            },
                            {
                                extend: 'print',
                                className: 'btn-sm btn-danger',
                                title: 'Devices',
                                pageSize: 'A2',
                                header: true,
                                footer: true,
                                orientation: 'landscape',
                                exportOptions: {
                                    columns: ['0,1,2,3,4,5'],
                                    stripHtml: false
                                }
                            }
                        ],
                });
            });
	</script>
	@endpush
</x-app-layout>
