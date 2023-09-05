<x-app-layout>
    @push('css')
        <style>
            .group-name{
                text-transform: capitalize;
            }
        </style>
    @endpush
    @section('title', 'Edit Role')
    <x-slot name="header">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="fas fa-compass"></i>
                </div>
                <div>
                    <h4>Edit Role</h4>
                </div>
            </div>
            <div class="page-title-actions">
                <a title="Back Button" href="{{ route('admin.role.index') }}" type="button" class="btn btn-sm btn-dark">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Back
                </a>
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
	                <div class="card-header"><h3>{{ __('Edit Role')}}</h3></div>
	                <div class="card-body">
	                    <form class="forms-sample" method="POST" action="{{ route ('admin.role.update', $role->id)}}" >
	                    	@csrf
                            @method('PUT')
	                        <div class="row">
	                            <div class="col-sm-12">
	                                <div class="form-group">
	                                    <label for="role">{{ __('Role')}}<span class="text-red">*</span></label>
	                                    <input type="text" class="form-control is-valid" id="role" name="name" value="{{ $role->name }}" placeholder="Role Name" required>
	                                </div>
	                            </div>
	                            <div class="col-sm-12 mt-4">
                                    <div>
                                        <h6 for="exampleInputEmail3"><strong>{{ __('Assign Permission')}}</strong></h6>
                                        <div class="col-sm-4">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="all_permission_checkbox" value="">
                                                <span class="custom-control-label">All Permissions</span>
                                            </label>
                                        </div>
                                    </div><hr>
                                    @foreach ($permissionGroups as $permissionGroup)
                                        <div class="row mt-4">
                                            <div class="col-sm-2">
                                                <div class="form-group">
                                                    <label class="custom-control custom-checkbox group-name">
                                                        <input type="checkbox" class="custom-control-input" id="group_checkbox-{{$permissionGroup->group_name}}" value="{{$permissionGroup->group_name}}" onclick="groupWisePermissionSelect(this, 'permissions-{{ $permissionGroup->group_name }}')">
                                                        <span class="custom-control-label">
                                                            {{ $permissionGroup->group_name }} (Select All)
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php $permissions= App\Http\Controllers\Admin\RoleController::getPermissionByGroupName($permissionGroup->group_name); ?>
                                            @foreach($permissions as $key => $permission)
                                                <div class="col-sm-2">
                                                    <div class="form-group">
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input permissions-{{ $permissionGroup->group_name }}" id="item_checkbox" name="permissions[]" value="{{$permission->name}}"
                                                                @if(in_array($permission->id, $role_permission))
                                                                    checked
                                                                @endif>
                                                            <span class="custom-control-label">
                                                                {{ $permission->name }}
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach

	                                <div class="form-group">
	                                	<button title="Update Button" type="submit" class="btn btn-primary btn-rounded">{{ __('Update')}}</button>
	                                </div>
	                            </div>
	                        </div>
	                    </form>
	                </div>
	            </div>

    </div>
    @push('js')
        <script src="{{ asset('select2/dist/js/select2.min.js') }}"></script>

    <script>
        $('#all_permission_checkbox').on('click', function(){
            if($(this).is(':checked')){
                $('input[type=checkbox]').prop('checked', true);
            }else{
                $('input[type=checkbox]').prop('checked', false);
            }
        });

        function groupWisePermissionSelect(groupId, permissionClass){
            const permissionGroupId=$('#'+groupId.id);
            const permissionsClass= $('.'+permissionClass);

            if(permissionGroupId.is(':checked')){
                permissionsClass.prop('checked', true);
            }else{
                permissionsClass.prop('checked', false);
            }
        }
    </script>
    @endpush
</x-app-layout>
