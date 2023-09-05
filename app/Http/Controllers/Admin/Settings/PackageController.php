<?php

namespace App\Http\Controllers\Admin\Settings;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Settings\Package;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin\Settings\ConnectionType;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('admin.settings.package.index');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //*** JSON Request

    public function package(Request $request)
    {
        try {
            $data = Package::with('connections')->orderBy('id', 'desc')->get();
            if ($request->ajax()) {
                return Datatables::of($data)
                    ->addColumn('status', function ($data) {
                        if (Auth::user()->can('package_status')) {
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

                    ->addColumn('description', function ($data) {
                        $result = isset($data->description) ? $data->description : '--' ;
                        return Str::limit( $result, 20) ;
                    })

                    ->addColumn('connection_name', function ($data) {
                        $name = isset($data->connections->name) ? $data->connections->name : null;
                        return $name;
                    })

                    ->addColumn('action', function (Package $data) {
                        if (Auth::user()->can('package_status')) {
                            $edit= '<a href="' . route('admin.package.edit', $data->id) . ' " class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';}
                        else{
                            $edit = " ";
                        }
                        if (Auth::user()->can('package_status')) {
                    $delete ='<button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.package.destroy', $data->id) . ' " title="Delete"><i class="fa fa-trash-alt"></i></button>';}
                    else {
                        $delete =  " ";
                    }
                    return $edit . $delete;
                    })

                    ->rawColumns(['status', 'action', 'description', 'connection_name'])
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
        try{
            $connections = ConnectionType::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.settings.package.create', compact('connections'));
        }catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function code()
    {
       try{
        do {
            $code = random_int(10000, 99999);
        } while (Package::where("code", "=", $code)->exists());
             return $code;
        }catch (\Exception $exception) {
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
            'connection_type_id .required' => 'Please select an connection type',
            'name.required' => 'Please enter a package name',
            'code.required' => 'Please enter a package code',
            'amount.required' => 'Please enter package amount',
            'package_spreed.required' => 'Please enter package package spreed',
        );

        $this->validate($request, array(
            'name' => 'required|string|unique:packages,name,NULL,id,deleted_at,NULL',
            'code' => 'required|string|unique:packages,code,NULL,id,deleted_at,NULL',
            'amount' => 'required|numeric',
            'package_spreed' => 'required',
        ), $messages);

        try {
            $data = new Package();
            $data->connection_type_id = $request->connection_type_id;
            $data->name = $request->name;
            $data->code = $request->code;
            $data->package_spreed = $request->package_spreed;
            $data->amount = $request->amount;
            $data->status = $request->status;
            $data->description = $request->description;
            $data->save();

            return redirect()->route('admin.package.index')
                ->with('message', 'Package created successfully');
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
    public function edit(Package $package)
    {
        try{
            $connections = ConnectionType::where('status', 1)->orderBy('id', 'desc')->get();
        return view('admin.settings.package.edit', compact('package', 'connections'));
        }catch (\Exception $exception) {
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

    public function update(Request $request, Package $package)
    {
        $messages = array(
            'connection_type_id .required' => 'Please select an connection type',
            'name.required' => 'Please enter a package name',
            'code.required' => 'Please enter a package code',
            'amount.required' => 'Please enter package amount',
            'package_spreed.required' => 'Please enter package spreed',
        );

        $this->validate($request, array(
            'name' => 'required|unique:packages,name,' . $package->id . ',id,deleted_at,NULL',
            'code' => 'required|unique:packages,code,' . $package->id . ',id,deleted_at,NULL',
            'amount' => 'required|numeric',
            'package_spreed' => 'required',
        ), $messages);

        try {
            $package->connection_type_id = $request->connection_type_id;
            $package->name = $request->name;
            $package->code = $request->code;
            $package->package_spreed = $request->package_spreed;
            $package->status = $request->status;
            $package->amount = $request->amount;
            $package->description = $request->description;
            $package->update();

            return redirect()->route('admin.package.index')
                ->with('message', 'Package updated successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    // end update function

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Package $package)
    {
        try {
            $package->delete();
            return back()->with('message', 'Package deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function StatusChange(Request $request)
    {
        $id = $request->id;
        $status_check   = Package::findOrFail($id);
        $status         = $status_check->status;

        if ($status == 1) {
            $status_update = 0;
        } else {
            $status_update = 1;
        }

        $data           = array();
        $data['status'] = $status_update;
        Package::where('id', $id)->update($data);
        if ($status_update == 1) {
            return "success";
        } else {
            return "failed";
        }
    }
}
