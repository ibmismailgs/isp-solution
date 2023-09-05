<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $roles = Role::pluck('name', 'id');
            return view('admin.permission.index', compact('roles'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

    }

    /**
     * Show the role list with associate permissions.
     * Server side list view using yajra datatables
     */

    public function permission(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Permission::orderBy('id', 'desc');
            return Datatables::of($data)

            ->make(true);
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Store new roles with assigned permission
     * Associate permissions will be stored in table
     */

    public function store(PermissionRequest $request)
    {
        try {
            $permission = new Permission();
            $permission->name = $request->name;
            $permission->save();
            $permission->syncRoles($request->roles);

            return redirect()->route('admin.permission.index')
            ->with('message', 'Permission created successfully');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function edit($id)
    {
        try {
            $permissionId = [];
            $permission = Permission::find($id);
            $data = Role::all();
            foreach ($permission->roles as $role) {
                $permissionId[] = $role->id;
            }
            return view('admin.permission.edit', compact('data', 'permission', 'permissionId'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $permission = Permission::find($id);
            $permission->name = $request->name;
            $permission->update();
            $permission->syncRoles($request->roles);

            return redirect()->route('admin.permission.index')
            ->with('message', 'Permission created successfully');
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }


    public function destroy($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            if ($permission) {
                $permission->roles()->delete();
            }
            $permission->delete();
            return back()->with('message', 'Data deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function getPermissionBadgeByRole(Request $request)
    {
        $badges = '';
        if ($request->id) {
            $role = Role::find($request->id);
            $permissions = $role->permissions()->pluck('name', 'id');
            foreach ($permissions as $key => $permission) {
                $badges .= '<span class="badge badge-dark m-1">' . $permission . '</span>';
            }
        }

        if ($role->name == 'Super Admin') {
            $badges = 'Super Admin has all the permissions!';
        }

        return $badges;
    }
}
