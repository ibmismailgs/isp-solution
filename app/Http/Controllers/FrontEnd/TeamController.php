<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FrontEnd\TeamSetting;
use Illuminate\Support\Facades\Auth;
use App\Models\FrontEnd\ServiceSetting;
use Yajra\DataTables\Facades\DataTables;
use App\Models\FrontEnd\TeamColorSetting;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('frontEnd.settings.team.index');
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
            return view('frontEnd.settings.team.create');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function show($id)
    {
       try {
            $data = TeamSetting::findOrFail($id);
            return view('frontEnd.settings.team.show', compact('data'));
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
            'designation.required' => 'Enter your designation',
            'phone.required' => 'Enter your contact number',
            'email.required' => 'Enter your email',
            'address.required' => 'Enter your address',
            'facebook.required' => 'Enter facebook link',
            'twitter.required' => 'Enter twitter link',
            'instagram.required' => 'Enter instagram link',
            'linkedin.required' => 'Enter linkedin link',
            'description.required' => 'Write description',
        );

        $this->validate($request, array(
            'name' => 'required|string|',
            'designation' => 'required|',
            'address' => 'required|',
            'facebook' => 'required|',
            'twitter' => 'required|',
            'instagram' => 'required|',
            'linkedin' => 'required|',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|unique:team_settings,phone,NULL,id,deleted_at,NULL',
            'email' => 'required|string|unique:team_settings,email,NULL,id,deleted_at,NULL',
            'profile_picture.*' => 'max:2048',

        ), $messages);

        try {
            $data = new teamSetting();
            if ($request->file('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->profile_picture = $filename;
            }

            $data->name = $request->name;
            $data->designation = $request->designation;
            $data->address = $request->address;
            $data->facebook = $request->facebook;
            $data->twitter = $request->twitter;
            $data->instagram = $request->instagram;
            $data->linkedin = $request->linkedin;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->status = $request->status;
            $data->description = $request->description;
            $data->save();

            return redirect()->route('admin.team-setting.index')
                ->with('message', 'Team created successfully');
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

    public function TeamSettingList(Request $request){
        try {
            if ($request->ajax()) {
                $data = TeamSetting::orderBy('id', 'desc')->get();
                return Datatables::of($data)
                    ->addColumn('status', function (TeamSetting $data) {
                        $button = ' <div class="custom-control custom-switch">';
                        $button .= ' <input type="checkbox" class="custom-control-input changeStatus" id="customSwitch' . $data->id . '" getId="' . $data->id . '" name="status"';

                        if ($data->status == 1) {
                            $button .= "checked";
                        }
                        $button .= '><label for="customSwitch' . $data->id . '" class="custom-control-label" for="switch1"></label></div>';
                        return $button;
                    })

                    ->addColumn('action', function (TeamSetting $data) {
                        if (Auth::user()->can('staff_show')) {
                            $show = ' <a href="' . route('admin.team-setting.show', $data->id) . ' " class="btn btn-sm btn-primary" title="Show"><i class="fa fa-eye"></i></a> ';}
                            else{
                                $show = " ";
                            }
                        if (Auth::user()->can('bank_edit')) {
                            $edit = '<a href="' . route('admin.team-setting.edit', $data->id) . ' " class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a>';
                        } else {
                            $edit = "";
                        }
                        if (Auth::user()->can('bank_delete')) {

                            $delete = ' <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.team-setting.destroy', $data->id) . ' " title="Delete"><i class="fa fa-trash-alt"></i></button> ';
                        } else {
                            $delete = "";
                        }
                        return $show.$edit.$delete;
                    })

                    ->rawColumns(['status', 'action'])
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
            $data = TeamSetting::findOrFail($id);
            return view('frontEnd.settings.team.edit', compact('data'));
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
            'designation.required' => 'Enter your designation',
            'phone.required' => 'Enter your contact number',
            'email.required' => 'Enter your email',
            'address.required' => 'Enter your address',
            'facebook.required' => 'Enter facebook link',
            'twitter.required' => 'Enter twitter link',
            'instagram.required' => 'Enter instagram link',
            'linkedin.required' => 'Enter linkedin link',
            'description.required' => 'Write facebook link',
        );

        $this->validate($request, array(
            'name' => 'required|string|',
            'designation' => 'required|',
            'address' => 'required|',
            'facebook' => 'required|',
            'twitter' => 'required|',
            'instagram' => 'required|',
            'linkedin' => 'required|',
            'phone' => 'required|',
            'email' => 'required|',
            'profile_picture.*' => 'max:2048',

        ), $messages);

        try {
            $data = TeamSetting::findOrFail($id);
            if ($request->file('profile_picture')) {
                $file = $request->file('profile_picture');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->profile_picture = $filename;
            }

            $data->name = $request->name;
            $data->designation = $request->designation;
            $data->address = $request->address;
            $data->facebook = $request->facebook;
            $data->twitter = $request->twitter;
            $data->instagram = $request->instagram;
            $data->linkedin = $request->linkedin;
            $data->phone = $request->phone;
            $data->email = $request->email;
            $data->status = $request->status;
            $data->description = $request->description;
            $data->update();

            return redirect()->route('admin.team-setting.index')
                ->with('message', 'Team updated successfully');
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
            $data = TeamSetting::findOrFail($id);
            $data->delete();
            return back()->with('message', 'Team deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function StatusChange(Request $request)
    {
        $id = $request->id;
        $status_check   = TeamSetting::findOrFail($id);
        $status         = $status_check->status;

        if ($status == 1) {
            $status_update = 0;
        } else {
            $status_update = 1;
        }

        $data           = array();
        $data['status'] = $status_update;
        TeamSetting::where('id', $id)->update($data);
        if ($status_update == 1) {
            return "success";
        } else {
            return "failed";
        }
    }

    public function TeamColorSetting()
    {
       try {
            $data = TeamColorSetting::first();
            return view('frontEnd.settings.team.color_setting', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function TeamColorStore(Request $request){

        try {
            if (!$request->id) {
             $data = new TeamColorSetting();
            } else {
                $data = TeamColorSetting::findOrFail($request->id);
            }
            $data->heading_color = $request->heading_color;
            $data->name_color = $request->name_color;
            $data->designation_color = $request->designation_color;
            $data->email_color = $request->email_color;
            $data->underline_color = $request->underline_color;
            $data->text_color = $request->text_color;
            if (!$request->id) {
                $data->save();

            return redirect()->route('admin.team-color-setting')->with('message', 'Team color  created successfull');
            } else {
            $data->update();

            return redirect()->route('admin.team-color-setting')->with('message', 'Team color updated successfull');
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
