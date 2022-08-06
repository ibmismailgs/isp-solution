<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/extensions/toastr.css')}}">
    @endpush
    @section('title', 'Request Area')

    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>List of Request Areas</h4>
                </div>
            </div>
            {{-- <div class="page-title-actions">
                <a href="{{ route('admin.area.create') }}" type="button" class="btn btn-sm btn-info">
                    <i class="fas fa-plus mr-1"></i>
                    Create
                </a>
            </div> --}}
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
                                <th>Client Name</th>
                                <th>IP Address</th>
                                <th>Current Area </th>
                                <th>Requested Area </th>
                                <th>Status</th>
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
                url: "{{route('admin.request-area-lists')}}",
                type: "post"
            },

            columns: [
            {
                "render": function() {
                    return i++;
                }
            },
            {data: 'subscribers.name', name: 'subscribers'},
            {data: 'subscribers.ip_address', name: 'subscribers'},
            {data: 'current_area', name: 'current_area'},
            {data: 'areas.name', name: 'areas'},
            {data: 'status', searchable: false, orderable: false},
            ],
            columnDefs: [{
                targets: [4],
                orderable: false
            }]
        });
    });


    // {--status change start here --}

    $('.card').on('click', '.changeStatus', function (e) {
        e.preventDefault();

        var id = $(this).attr('getId');
        if (confirm('are you sure, want to approve this?')) {
            $.ajax({
                'url':"{{ route('admin.request-area-status') }}",
                'type':'post',
                'dataType':'text',

                'data':{id:id},

                success:function(data)
                {
                    $('#example').DataTable().ajax.reload();

                    if(data == "success"){
                        toastr.success('This request has been approved.', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.error('This request cancel.', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }
                }
            });
        }

    })

    </script>

    @endpush
</x-app-layout>
