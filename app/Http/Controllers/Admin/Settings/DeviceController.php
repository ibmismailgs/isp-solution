<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Admin\Settings\Device;
use Yajra\DataTables\Facades\DataTables;

class DeviceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('admin.settings.device.index');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //*** JSON Request
    public function device(Request $request)
    {
        try {
            $data = Device::orderBy('id', 'desc')->get();
            //--- Integrating This Collection Into Datatables
            if ($request->ajax()) {
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

                    ->addColumn('description', function ($data) {
                        return Str::limit($data->description, 20);
                    })

                    ->addColumn('action', function (Device $data) {
                        return '<a href="' . route('admin.device.edit', $data->id) . ' " class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>

                    <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.device.destroy', $data->id) . ' " title="Delete"><i class="fa fa-trash-alt"></i></button>

                    ';
                    })

                    ->rawColumns(['status', 'action', 'description'])
                    ->toJson(); //--- Returning Json Data To Client Side
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
        return view('admin.settings.device.create');
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
            'name.required' => 'Please enter a device name',
        );

        $this->validate($request, array(
            'name' => 'required|string|unique:devices,name,NULL,id,deleted_at,NULL',
        ), $messages);

        try {
            $data = new Device();

            $data->name = $request->name;
            $data->status = $request->status;
            $data->description = $request->description;
            $data->save();

            return redirect()->route('admin.device.index')
                ->with('message', 'Device type created successfully');
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
    public function edit(Device $device)
    {
        try{
            return view('admin.settings.device.edit', compact('device'));
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

    // start update function
    public function update(Request $request, Device $device)
    {
        $messages = array(
            'name.required' => 'Please enter a device type ',
        );

        $this->validate($request, array(
            'name' => 'required|unique:devices,name,' . $device->id . ',id,deleted_at,NULL',
        ), $messages);

        try {
            $device->name = $request->name;
            $device->status = $request->status;
            $device->description = $request->description;
            $device->update();

            return redirect()->route('admin.device.index')
                ->with('message', 'Device type updated successfully');
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

    // start delete function
    public function destroy(Device $device)
    {
        try {
            $device->delete();
            return back()->with('message', 'Device type deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    // end delete function

    //starts status change function
    public function StatusChange(Request $request)
    {
        $id = $request->id;

        $status_check   = Device::findOrFail($id);
        $status         = $status_check->status;

        if ($status == 1) {
            $status_update = 0;
        } else {
            $status_update = 1;
        }

        $data           = array();
        $data['status'] = $status_update;
        Device::where('id', $id)->update($data);
        if ($status_update == 1) {
            return "success";
            exit();
        } else {
            return "failed";
        }
    }
    //end status change function
}
