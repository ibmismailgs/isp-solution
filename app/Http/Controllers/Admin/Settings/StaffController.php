<?php

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Settings\Staff;
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
            return view('admin.settings.staff.create');
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
        // dd($request->all());
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
            'name' => 'required|string|',
            'birth_date' => 'required|',
            'join_date' => 'required|',
            'gender' => 'required|',
            'designation' => 'required|',
            'salary' => 'required|',
            'contact_no' => 'required|',
            'email' => 'required|',
            'image.*' => 'max:2048'
        ), $messages);

        try {
            $data = new Staff();
            $data->name = $request->name;
            $data->birth_date = $request->birth_date;
            $data->join_date = $request->join_date;
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
            $data->email = $request->email;
            $data->address = $request->address;
            $data->status = $request->status;
            $data->description = $request->description;
            // dd($data);
            $data->save();

            return redirect()->route('admin.staff.index')
            ->with('message', 'Staff created successfully');
        } catch (\Exception $exception) {
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
            //--- Integrating This Collection Into Datatables
            if ($request->ajax()) {

                $data = Staff::orderBy('id', 'desc')->get();

                return Datatables::of($data)
                    ->addColumn('status', function ($data) {
                        $button = ' <div class="custom-control custom-switch">';
                        $button .= ' <input type="checkbox" class="custom-control-input changeStatus" id="customSwitch' . $data->id . '" getId="' . $data->id . '" name="status"';

                        if ($data->status == 1) {

                            $button .= "checked";
                        }
                        $button .= '><label for="customSwitch' . $data->id . '" class="custom-control-label" for="switch1"></label></div>';
                        return $button;
                    })

                    ->addColumn('gender', function (Staff $data) {
                        if ($data->gender == 1) {
                            return '<p">
                                        Male
                                    </p>';
                        } else {
                            return '<p">
                                   Female
                               </p>';
                        }
                    })

                    ->addColumn('action', function (Staff $data) {
                        return ' <a href="' . route('admin.staff.show', $data->id) . ' " class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>

                       <a href="' . route('admin.staff.edit', $data->id) . ' " class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>

                    <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.staff.destroy', $data->id) . ' " title="Delete" ><i class="fa fa-trash-alt"></i></button>';
                    })

                    ->rawColumns(['status', 'action', 'gender'])
                    ->toJson(); //--- Returning Json Data To Client Side
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = Staff::findOrFail($id);
            return view('admin.settings.staff.show', compact('data'));
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
            return view('admin.settings.staff.edit', compact('data'));
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
        // dd($request->all());
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
            'name' => 'required|string|',
            'birth_date' => 'required|',
            'join_date' => 'required|',
            'gender' => 'required|',
            'designation' => 'required|',
            'salary' => 'required|',
            'contact_no' => 'required|',
            'email' => 'required|',
            'image.*' => 'max:2048'
        ), $messages);

        try {
            $data = Staff::findOrFail($id);
            $data->name = $request->name;
            $data->birth_date = $request->birth_date;
            $data->join_date = $request->join_date;
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
            $data->address = $request->address;
            $data->status = $request->status;
            $data->description = $request->description;
            // dd($data);
            $data->update();

            return redirect()->route('admin.staff.index')
            ->with('message', 'Staff updated successfully');
        } catch (\Exception $exception) {
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
            $data = Staff::findOrFail($id);
            $data->delete();
            return back()->with('message', 'Data deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    // change status function start here
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
            exit();
        } else {
            return "failed";
        }
    }
    // end change function
}
