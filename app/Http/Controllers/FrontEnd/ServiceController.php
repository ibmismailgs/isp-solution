<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\FrontEnd\ServiceSetting;
use Yajra\DataTables\Facades\DataTables;
use App\Models\FrontEnd\ServiceColorSetting;
class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('frontEnd.settings.service.index');
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
            return view('frontEnd.settings.service.create');
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
            'title.required' => 'Enter title',
            'description.required' => 'Write your description',
        );

        $this->validate($request, array(
            'title' => 'required',
            'description' => 'required',
        ), $messages);

        try {
            $data = new ServiceSetting();
            $data->title = $request->title;
            if ($request->file('icon')) {
                $file = $request->file('icon');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->icon = $filename;
            }
            $data->status = $request->status;
            $data->description = $request->description;
            $data->save();

            return redirect()->route('admin.service-setting.index')
                ->with('message', 'Service created successfully');
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

    public function ServiceSettingList(Request $request){
        try {
            if ($request->ajax()) {
                $data = ServiceSetting::orderBy('id', 'desc')->get();
                return Datatables::of($data)
                    ->addColumn('status', function (ServiceSetting $data) {

                        $button = ' <div class="custom-control custom-switch">';
                        $button .= ' <input type="checkbox" class="custom-control-input changeStatus" id="customSwitch' . $data->id . '" getId="' . $data->id . '" name="status"';

                        if ($data->status == 1) {
                            $button .= "checked";
                        }
                        $button .= '><label for="customSwitch' . $data->id . '" class="custom-control-label" for="switch1"></label></div>';
                        return $button;
                    })

                    ->addColumn('icon_image', function (ServiceSetting $data) {
                        $result = '<img title="Icon" height="50px" width="100px" src="'.asset('img').'/'.$data->icon.'" alt="Icon">';
                        return $result;
                    })

                    ->addColumn('description', function (ServiceSetting $data) {
                        $result = isset($data->description) ? $data->description : '--' ;
                        return Str::limit( $result, 20) ;
                    })

                    ->addColumn('action', function (ServiceSetting $data) {
                        if (Auth::user()->can('bank_edit')) {
                            $edit = '<a href="' . route('admin.service-setting.edit', $data->id) . ' " class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a>';
                        } else {
                            $edit = "";
                        }
                        if (Auth::user()->can('bank_delete')) {

                            $delete = ' <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.service-setting.destroy', $data->id) . ' " title="Delete"><i class="fa fa-trash-alt"></i></button> ';
                        } else {
                            $delete = "";
                        }
                        return $edit.$delete;
                    })

                    ->rawColumns(['status', 'action', 'description','icon_image'])
                    ->toJson();
            }
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
            $data = ServiceSetting::findOrFail($id);
            return view('frontEnd.settings.service.edit', compact('data'));
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
            'title.required' => 'Enter title',
            'description.required' => 'Write your description',
        );

        $this->validate($request, array(
            'title' => 'required',
            'description' => 'required',
        ), $messages);

        try {
            $data = ServiceSetting::findOrFail($id);
            $data->title = $request->title;
            if ($request->file('icon')) {
                $file = $request->file('icon');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->icon = $filename;
            }
            $data->status = $request->status;
            $data->description = $request->description;
            $data->update();

            return redirect()->route('admin.service-setting.index')
                ->with('message', 'Service updated successfully');
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
            $data = ServiceSetting::findOrFail($id);
            $data->delete();
            return back()->with('message', 'Service deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function StatusChange(Request $request)
    {
        $id = $request->id;
        $status_check   = ServiceSetting::findOrFail($id);
        $status         = $status_check->status;

        if ($status == 1) {
            $status_update = 0;
        } else {
            $status_update = 1;
        }

        $data           = array();
        $data['status'] = $status_update;
        ServiceSetting::where('id', $id)->update($data);
        if ($status_update == 1) {
            return "success";
        } else {
            return "failed";
        }
    }

    public function ServiceColorSetting()
    {
       try {
            $data = ServiceColorSetting::first();
            return view('frontEnd.settings.service.color_setting', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function ServiceColorStore(Request $request){
        try {
            if (!$request->id) {
                $data = new ServiceColorSetting();
            } else {
                $data = ServiceColorSetting::findOrFail($request->id);
            }

            $data->heading_color = $request->heading_color;
            $data->underline_color = $request->underline_color;
            $data->title_color = $request->title_color;
            $data->text_color = $request->text_color;
            if (!$request->id) {
                $data->save();

            return redirect()->route('admin.service-color-setting')->with('message', 'Service color  created successfull');
            } else {
            $data->update();

            return redirect()->route('admin.service-color-setting')->with('message', 'Service color updated successfull');
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
