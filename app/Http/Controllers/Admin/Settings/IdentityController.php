<?php

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Settings\Identity;
use Yajra\DataTables\Facades\DataTables;

class IdentityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('admin.settings.identity.index');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //*** JSON Request
    public function idcard(Request $request)
    {
        try {
            $data = Identity::orderBy('id', 'desc')->get();
            if ($request->ajax()) {
                return Datatables::of($data)
                    ->addColumn('status', function ($data) {
                        if (Auth::user()->can('idcard_status')) {
                            $button = ' <div class="custom-control custom-switch">';
                            $button .= ' <input type="checkbox" class="custom-control-input changeStatus" id="customSwitch' . $data->id . '" getId="' . $data->id . '" name="status"';

                            if ($data->status == 1) {
                                $button .= "checked";
                            }
                            $button .= '><label for="customSwitch' . $data->id . '" class="custom-control-label" for="switch1"></label></div>';
                            return $button;
                        } else {
                            return "--";
                        }
                    })

                    ->addColumn('description', function ($data) {
                        $result = isset($data->description) ? $data->description : '--' ;
                        return Str::limit( $result, 20) ;
                    })

                    ->addColumn('action', function (Identity $data) {
                        if (Auth::user()->can('idcard_edit')) {
                            $edit =  ' <a href="' . route('admin.identity.edit', $data->id) . ' " class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';
                        } else {
                            $edit = " ";
                        }
                        if (Auth::user()->can('idcard_delete')) {
                            $delete = ' <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.identity.destroy', $data->id) . ' " title="Delete"><i class="fa fa-trash-alt"></i></button>';
                        } else {
                            $delete = " ";
                        }
                        return $edit . $delete;
                    })

                    ->rawColumns(['status', 'action', 'description'])
                    ->toJson();
            }
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
            return view('admin.settings.identity.create');
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
            'name.required' => 'Please enter ID card type',
        );

        $this->validate($request, array(
            'name' => 'required|string|unique:identities,name,NULL,id,deleted_at,NULL',
        ), $messages);

        try {
            $data = new Identity();
            $data->name = $request->name;
            $data->status = $request->status;
            $data->description = $request->description;
            $data->save();

            return redirect()->route('admin.identity.index')
                ->with('message', 'ID card type created successfully');
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
    public function edit(Identity $identity)
    {
        try {
            return view('admin.settings.identity.edit', compact('identity'));
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

    public function update(Request $request, Identity $identity)
    {
        $messages = array(
            'name.required' => 'Please enter ID card type',
        );

        $this->validate($request, array(
            'name' => 'required|unique:identities,name,' . $identity->id . ',id,deleted_at,NULL',
        ), $messages);

        try {
            $identity->name = $request->name;
            $identity->status = $request->status;
            $identity->description = $request->description;
            $identity->update();

            return redirect()->route('admin.identity.index')
                ->with('message', 'ID card type updated successfully');
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

    public function destroy(Identity $identity)
    {
        try {
            $identity->delete();
            return back()->with('message', 'ID Card Type deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function StatusChange(Request $request)
    {
        $id = $request->id;
        $status_check   = Identity::findOrFail($id);
        $status         = $status_check->status;

        if ($status == 1) {
            $status_update = 0;
        } else {
            $status_update = 1;
        }

        $data           = array();
        $data['status'] = $status_update;
        Identity::where('id', $id)->update($data);
        if ($status_update == 1) {
            return "success";
        } else {
            return "failed";
        }
    }
}
