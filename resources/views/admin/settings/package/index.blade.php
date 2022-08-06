<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/extensions/toastr.css')}}">
    @endpush
    @section('title', 'Package')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>List of Packages</h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('admin.package.create') }}" type="button" class="btn btn-sm btn-info">
                    <i class="fas fa-plus mr-1"></i>
                    Create
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="container-fluid">
    	<div class="page-header">
            <div class="d-inline">
                @if (Session::has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{Session::get('message')}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
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
    </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="example" class="table table-hover table-bordered ">
                            <thead>
                                <tr>
                                    <th>SN</th>
                                    <th>Connection</th>
                                    <th> Name</th>
                                    <th> Code</th>
                                    <th> Spreed</th>
                                    <th>Amount</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
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
    <script src="{{ asset('app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script>

        $(document).ready( function () {
        var searchable = [];
        var selectable = [];
         var i = 1;

        var dTable = $('#example').DataTable({
            order: [],
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            processing: true,
            responsive: false,
            serverSide: true,
            language: {
              processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
            },
            scroller: {
                loadingIndicator: false
            },
            pagingType: "full_numbers",
            ajax: {
                url: "{{route('admin.package-list')}}",
                type: "post"
            },

            columns: [
                {
                    "render": function() {
                        return i++;
                    }
                },

                {data: 'connections.name', name: 'connections'},
                {data: 'name', name: 'name'},
                {data: 'code', name: 'code'},
                {data: 'package_spreed', name: 'package_spreed'},
                {data: 'amount', name: 'amount'},
                {data: 'description', searchable: false, orderable: false},
                {data: 'status', searchable: false, orderable: false},
                {data: 'action', searchable: false, orderable: false}

            ],
            columnDefs: [{
                targets: [4],
                orderable: false
            }]
            });
        });

       // start delete function
    $('#example').on('click', '.btn-delete[data-remote]', function (e) {
        e.preventDefault();
        let url = $(this).data('remote');
        if (confirm('are you sure, want to delete this?')) {
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {submit: true, _method: 'delete', _token: "{{ csrf_token() }}"}
            }).always(function (data) {
                $('#example').DataTable().ajax.reload();
                if(data){
                    toastr.success('This data is successfully deleted.', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else{
                    toastr.error('Error!!. This data is not deleted.', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }
            });
        }
    });

    // end delete function

// {--status change start here --}

    $('.card').on('click', '.changeStatus', function (e) {
        e.preventDefault();

        var id = $(this).attr('getId');
        if (confirm('are you sure, want to change this status?')) {
            $.ajax({
                'url':"{{ route('admin.package-status') }}",
                'type':'post',
                'dataType':'text',

                'data':{id:id},

                success:function(data)
                {
                    $('#example').DataTable().ajax.reload();

                    if(data == "success"){
                        toastr.success('This status has been changed to Active.', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.error('This status has been changed to Inctive.', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }
                }
            });
        }

    })

    </script>

    @endpush
</x-app-layout>
