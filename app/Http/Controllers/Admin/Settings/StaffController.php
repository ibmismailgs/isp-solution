<?php

namespace App\Http\Controllers\Admin\Settings;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Admin\Settings\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('admin.settings.staff.index');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $roles = Role::orderBy('id', 'desc')->get();
            return view('admin.settings.staff.create', compact('roles'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = array(
            'name.required' => 'Enter your name',
            'birth_date.required' => 'Enter birth date',
            'join_date.required' => 'Enter join date',
            'gender.required' => 'Choose a gender',
            'designation.required' => 'Enter your designation',
            'salary.required' => 'Enter your salary',
            'contact_no.required' => 'Enter your contact number',
            'email.required' => 'Enter your email',
            'address.required' => 'Enter your address',
            'password.required' => 'Create password',
        );

        $this->validate($request, array(
            'name' => 'required|string|',
            'birth_date' => 'required|',
            'join_date' => 'required|',
            'gender' => 'required|',
            'designation' => 'required|',
            'salary' => 'required|numeric',
            'contact_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|unique:staff,contact_no,NULL,id,deleted_at,NULL',
            'email' => 'required|string|unique:staff,email,NULL,id,deleted_at,NULL',
            'image.*' => 'max:2048',
            'password' => 'required|min:6',

        ), $messages);


        DB::beginTransaction();

        try {
            $data = new Staff();
            $data->name = $request->name;
            $data->birth_date = Carbon::parse($request->birth_date)->format('Y-m-d');
            $data->join_date = Carbon::parse($request->join_date)->format('Y-m-d');
            $data->gender = $request->gender;

            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->image = $filename;
            }

            $data->contact_no = $request->contact_no;
            $data->designation = $request->designation;
            $data->salary = $request->salary;
            $data->password = Hash::make($request->password);
            $data->email = $request->email;
            $data->address = $request->address;
            $data->status = $request->status;
            $data->description = $request->description;
            $data->role = 3;
            $data->save();

            $user = new User();
            $user->staff_id = $data->id;
            $user->name = $request->name;
            $user->type = 3;
            $user->status = 1;
            $user->email  = $request->email;
            $user->password  = Hash::make($request->password);
            $user->save();
            $user->assignRole($request->role);

            DB::table('model_has_roles')->insert([
                'role_id' => 3,
                'model_type' => 'App\\Models\\User',
                'model_id' => $user->id,
            ]);

            DB::commit();

            return redirect()->route('admin.staff.index')
            ->with('message', 'Staff created successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function staff(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Staff::orderBy('id', 'desc')->get();
                return Datatables::of($data)
                    ->addColumn('status', function ($data) {
                        if (Auth::user()->can('staff_status')) {
                        $button = ' <div class="custom-control custom-switch">';
                        $button .= ' <input type="checkbox" class="custom-control-input changeStatus" id="customSwitch' . $data->id . '" getId="' . $data->id . '" name="status"';

                        if ($data->status == 1) {
                            $button .= "checked";
                        }
                        $button .= '><label for="customSwitch' . $data->id . '" class="custom-control-label" for="switch1"></label></div>';
                        return $button;
                    }
                    else{
                        return "--";
                    }
                    })

                    ->addColumn('gender', function (Staff $data) {
                        if ($data->gender == 1) {
                            return 'Male';
                        } elseif($data->gender == 2) {
                            return 'Female';
                        }else{
                            return 'Other';
                        }
                    })

                    ->addColumn('action', function (Staff $data) {

                        if (Auth::user()->can('staff_show')) {
                            $details =  '<a href="' . route('admin.staff-profile', $data->id) . ' " class="btn btn-sm btn-info" title="Profile"><i class="fa fa-user" aria-hidden="true"></i></a> ';
                         } else {
                                 $details = " ";
                         }

                        if (Auth::user()->can('staff_show')) {
                        $show = ' <a href="' . route('admin.staff.show', $data->id) . ' " class="btn btn-sm btn-primary" title="Show"><i class="fa fa-eye"></i></a> ';}
                        else{
                            $show = " ";
                        }
                        if (Auth::user()->can('staff_edit')) {
                       $edit=' <a href="' . route('admin.staff.edit', $data->id) . ' " class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';}
                       else{
                        $edit = " ";
                       }

                       if (Auth::user()->can('staff_delete')) {
                    $delete = ' <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.staff.destroy', $data->id) . ' " title="Delete" ><i class="fa fa-trash-alt"></i></button> ';}
                    else{
                        $delete = " ";
                    }
                    return $details.$show.$edit.$delete;

                    })

                    ->addIndexColumn()
                    ->rawColumns(['status', 'action', 'gender'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = Staff::findOrFail($id);
            $roles = Role::orderBy('id', 'desc')->get();
            return view('admin.settings.staff.show', compact('data', 'roles'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = Staff::findOrFail($id);
            $roles = Role::orderBy('id', 'desc')->get();
            return view('admin.settings.staff.edit', compact('data', 'roles'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = array(
            'name.required' => 'Enter your name',
            'birth_date.required' => 'Enter birth date',
            'join_date.required' => 'Enter join date',
            'gender.required' => 'Choose a gender',
            'image.required' => 'Upload a profile picture',
            'designation.required' => 'Enter your designation',
            'salary.required' => 'Enter your salary',
            'contact_no.required' => 'Enter your contact number',
            'email.required' => 'Enter your email',
            'address.required' => 'Enter your address',
        );

        $this->validate($request, array(
            'name' => 'required|',
            'birth_date' => 'required|',
            'join_date' => 'required|',
            'gender' => 'required|',
            'designation' => 'required|',
            'salary' => 'required|',
            'contact_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|unique:staff,contact_no,' . $id . ',id,deleted_at,NULL',
            'email' => 'required|unique:staff,email,' . $id . ',id,deleted_at,NULL',
            'image.*' => 'max:2048'
        ), $messages);

        DB::beginTransaction();

        try {
            $data = Staff::findOrFail($id);
            $data->name = $request->name;
            $data->birth_date = Carbon::parse($request->birth_date)->format('Y-m-d');
            $data->join_date = Carbon::parse($request->join_date)->format('Y-m-d');
            $data->gender = $request->gender;

            // Store Image
            if (request()->has('image')) {
                @unlink(public_path('img/') . $data->image);
                $file = $request->file('image');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->image = $filename;
            }

            $data->contact_no = $request->contact_no;
            $data->designation = $request->designation;
            $data->salary = $request->salary;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->address = $request->address;
            $data->status = $request->status;
            $data->description = $request->description;
            $data->update();

            $user = User::where('staff_id', $id)->first();
            $user->staff_id = $data->id;
            $user->name = $request->name;
            $user->email  = $request->email;
            $user->password  = Hash::make($request->password);
            $user->update();
            $user->syncRoles($request->role);
            DB::commit();

            return redirect()->route('admin.staff.index')
            ->with('message', 'Staff updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        try {
            $data =  Staff::findOrFail($id);
            if ($data) {
                $user = User::where('staff_id', $id)->first();
                DB::table('model_has_roles')->where('role_id', 3)->where('model_id', $user->id)->delete();
                $user->delete();
                $data->delete();
                return redirect()->route('admin.staff.index')
                ->with('message', 'Staff deleted successfully');
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function StatusChange(Request $request)
    {
        $id = $request->id;
        $status_check   = Staff::findOrFail($id);
        $status         = $status_check->status;

        if ($status == 1) {
            $status_update = 0;
        } else {
            $status_update = 1;
        }

        $data           = array();
        $data['status'] = $status_update;
        Staff::where('id', $id)->update($data);
        if ($status_update == 1) {
            return "success";
        } else {
            return "failed";
        }
    }

    public function StaffProfile($id)
    {
        try {
            $data = Staff::findOrFail($id);
            $roles = Role::orderBy('id', 'desc')->get();
            return view('admin.settings.staff.staff_profile', compact('data', 'roles'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function StaffProfileUpdate(Request $request, $id){
        if($request->password != $request->confirm_password){
            return redirect()->back()->with('error', "Passwords do not match");
        }

        if($request->password){
            $messages = array(
                'password' => 'Password must be be minimum 6 digit',
            );

            $this->validate($request, array(
                'password' => 'min:6',
            ), $messages);
        }

        DB::beginTransaction();

        try {
            $data = Staff::findOrFail($id);
            $data->name = $request->name;
            $data->contact_no = $request->contact_no;
            $data->email = $request->email;
            $data->address = $request->address;
            $data->password = Hash::make($request->password);
            // Store Image
            if (request()->has('image')) {
                @unlink(public_path('img/') . $data->image);
                $file = $request->file('image');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->image = $filename;
            }
            $data->update();

            $user = User::where('staff_id', $id)->first();
            $user->staff_id = $data->id;
            $user->name = $request->name;
            $user->email  = $request->email;
            $user->password = Hash::make($request->password);
            $user->update();

            DB::commit();

            return redirect()->back()->with('message', 'Data updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
