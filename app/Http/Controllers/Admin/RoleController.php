<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $permissions = Permission::pluck('name', 'id');
            return view('admin.role.index', compact('permissions'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

    }

    /**
     * Show the role list with associate permissions.
     * Server side list view using yajra datatables
     */

    public function role(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Role::orderBy('id', 'desc');
                return Datatables::of($data)
                ->addColumn('permissions', function ($data) {
                    $roles = $data->permissions()->get();
                    $badges = '';
                    foreach ($roles as $key => $role) {
                        $badges .= '<span class="badge badge-dark m-1">' . $role->name . '</span>';
                    }
                    if ($data->name == 'Super Admin') {
                        return '<span class="badge badge-success m-1">All permissions</span>';
                    }

                    return $badges;
                })

                ->addColumn('action', function ($data) {
                        if ($data->name == 'Super Admin') {
                            return '';
                        }
                            return '<a href="' . route('admin.role.edit', $data->id) . ' " class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a>

                            <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.role.destroy', $data->id) . ' " title="Delete"><i class="fa fa-trash-alt"></i></button>';
                    })
                    ->rawColumns(['permissions', 'action'])
                    ->make(true);
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function create()
    {
        try {
            $permissionGroups = Permission::select('group_name')
            ->groupBy('group_name')->orderBy('id','ASC')->get();
            return view('admin.role.create', compact('permissionGroups'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public static function getPermissionByGroupName($groupName)
    {
        $permissions = Permission::where('group_name', $groupName)->get();
        return $permissions;
    }

    /**
     * Store new roles with assigned permission
     * Associate permissions will be stored in table
     */

    public function store(Request $request)
    {
        try {
            $role = new Role();
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($request->permissions);

            return redirect()->route('admin.role.index')
            ->with('message', 'Role created successfully');

        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function edit($id)
    {
        try {
            $role = Role::findOrFail($id);
            $permissionGroups = Permission::select('group_name')->groupBy('group_name')->orderBy('id', 'ASC')->get();

            if ($role) {
                $role_permission = $role->permissions()->pluck('id')->toArray();
                $permissions = Permission::pluck('name', 'id');
            }

            return view('admin.role.edit', compact('role', 'role_permission', 'permissions', 'permissionGroups'));

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $role = Role::findOrfail($id);
            $role->name = $request->name;
            $role->update();

            $role->syncPermissions($request->permissions);

            return redirect()->route('admin.role.index')
            ->with('message', 'Role updated successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            if ($role) {
                $role->permissions()->delete();
            }
            $role->delete();
            return back()->with('message', 'Data deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
