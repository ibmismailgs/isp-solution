<x-app-layout>
    @push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/extensions/toastr.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="container-fluid">
        <div class="page-header">
            <div class="d-inline">
                @if (Session::has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{Session::get('message')}}
                    <button title="Close Button" type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
            {data: 'subscriber_name', name: 'subscriber_name'},
            {data: 'subscriber_ip', name: 'subscriber_ip'},
            {data: 'current_area', name: 'current_area'},
            {data: 'area_name', name: 'area_name'},
            {data: 'status', searchable: false, orderable: false},
            ],
            columnDefs: [{
                targets: [4],
                orderable: false
            }]
        });
    });

        $('.card').on('click', '.changeStatus', function (e) {
            e.preventDefault();

            var id = $(this).attr('getId');
            swal({
                title: `Are you sure you ?`,
                text: `Want to change this status?`,
                buttons: true,
                dangerMode: true,
            }).then((statusChange) => {
            if (statusChange) {
            $.ajax({
                'url':"{{ route('admin.request-area-status') }}",
                'type':'post',
                'dataType':'text',
                'data':{id:id},
                success:function(data)
                {
                    $('#example').DataTable().ajax.reload();
                    if(data == "success"){
                        toastr.success('Request approved', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }
                }
            });
          }
        });
    })

    </script>
    @endpush
</x-app-layout>
