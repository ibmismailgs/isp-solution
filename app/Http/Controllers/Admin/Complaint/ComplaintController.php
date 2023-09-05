<?php

namespace App\Http\Controllers\Admin\Complaint;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Settings\Staff;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin\Complaint\Complaint;
use App\Models\Admin\Complaint\Classification;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('admin.complaint.index',);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //*** JSON Request
    public function complaints(Request $request)
    {
        try {
            if ($request->ajax()) {

                if ((Auth::user()->type) == 2) {
                    $data = Complaint::with('classifications')->where('subscriber_id',  Auth::user()->subscriber_id)->orderBy('id', 'desc')->get();
                }elseif ((Auth::user()->type) == 3) {
                    $data = Complaint::with('classifications')->where('subscriber_id',   Auth::user()->subscriber_id)->orderBy('id', 'desc')->get();
                }else{
                    $data = Complaint::with('classifications')->orderBy('id', 'desc')->get();
                }

                return Datatables::of($data)
                    ->addColumn('ticket_option', function ($data) {
                        if (Auth::user()->can('classification_status')) {
                        $button = ' <div class="custom-control custom-switch">';
                        $button .= ' <input type="checkbox" class="custom-control-input changeStatus" id="customSwitch' . $data->id . '" getId="' . $data->id . '" name="ticket_option"';

                        if ($data->ticket_option == 1) {
                            $button .= "checked";
                        }
                        $button .= '><label for="customSwitch' . $data->id . '" class="custom-control-label" for="switch1"></label></div>';
                        return $button;
                        }elseif($data->ticket_option == 0){
                         return 'Done';
                        }else {
                            return "--";
                        }

                    })

                    ->addColumn('classification_name', function (Complaint $data) {
                        $name = isset($data->classifications->name) ? $data->classifications->name : null;
                        return $name;
                    })

                    ->addColumn('action', function (Complaint $data) {

                            $show = '<a href="' . route('admin.complaint.show', $data->id) . ' " class="btn btn-sm btn-primary"><i class="fa fa-eye" title="Show"></i></a> ';

                            // $show = "";

                        if (Auth::user()->can('complain_edit')) {
                            $edit = ' <a href="' . route('admin.complaint.edit', $data->id) . ' " class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';
                        } else {
                            $edit = "";
                        }
                        if (Auth::user()->can('complain_delete')) {
                            $delete = ' <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.complaint.destroy', $data->id) . ' " title="Delete" ><i class="fa fa-trash-alt"></i></button> ';
                        } else {
                            $delete = "";
                        }
                        return $show . $edit . $delete;
                    })

                    ->rawColumns(['action', 'ticket_option', 'classification_name'])
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
            $classifications = Classification::where('status', 1)->get();
            $user = User::with('subscribers','staffs')->where('id', Auth::user()->id)->first();
            $cid = Complaint::count();
            return view('admin.complaint.create', compact('classifications', 'cid','user'));
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
            'name.required' => 'Enter complaint name',
            'classification_id.required' => 'Select ticket type',
            'address.required' => 'Enter your address',
            'contact_no.required' => 'Enter your contact number',
            'email.required' => 'Enter your email address',
        );

        $this->validate($request, array(
            'ticket_id' => 'required|string|unique:complaints,ticket_id',
        ), $messages);

        try {
            $data = new Complaint();
            $data->ticket_id = $request->ticket_id;
            $data->classification_id = $request->classification_id;
            $data->name = $request->name;
            $data->complain_date =  date('Y-m-d');
            $data->complain_time = date('H:i:s');
            $data->address = $request->address;
            $data->contact_no = $request->contact_no;
            $data->email = $request->email;
            $data->piority = $request->piority;
            $data->ticket_option = 1;
            $data->subscriber_id = $request->subscriber_id;
            $data->description = $request->description;
            $data->save();

            return redirect()->route('admin.complaint.index')
                ->with('message', 'Complain created successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors('error', $exception->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data = Complaint::with('classifications')->orderBy('id', 'desc')->findOrFail($id);
            return view('admin.complaint.show', compact('data'));
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
            $data = Complaint::findOrFail($id);
            $classifications = Classification::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.complaint.edit', compact('data', 'classifications'));
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
            'name.required' => 'Enter complaint name',
            'classification_id.required' => 'Select ticket type',
            'address.required' => 'Enter your address',
            'contact_no.required' => 'Enter your contact number',
            'email.required' => 'Enter your email address',
        );

        $this->validate($request, array(
            'ticket_id' => 'required|unique:complaints,ticket_id,' . $id . ',id,deleted_at,NULL',
        ), $messages);

        try {
            $data = Complaint::findOrFail($id);
            $data->ticket_id = $request->ticket_id;
            $data->classification_id = $request->classification_id;
            $data->name = $request->name;
            $data->complain_date =  date('Y-m-d');
            $data->complain_time = date('H:i:s');
            $data->address = $request->address;
            $data->contact_no = $request->contact_no;
            $data->email = $request->email;
            $data->piority = $request->piority;
            $data->ticket_option = 1;
            $data->subscriber_id = $request->subscriber_id;
            $data->description = $request->description;
            $data->update();

            return redirect()->route('admin.complaint.index')
                ->with('message', 'Complain updated successfully');
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
            $data = Complaint::findOrFail($id);
            $data->delete();
            return back()->with('message', 'Complain deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function StatusChange(Request $request)
    {
        $id = $request->id;
        $status_check   = Complaint::findOrFail($id);
        $status         = $status_check->ticket_option;
        if ($status == 1) {
            $status_update = 0;
        } else {
            $status_update = 1;
        }

        $data           = array();
        $data['ticket_option'] = $status_update;
        Complaint::where('id', $id)->update($data);
        if ($status_update == 1) {
            return "success";
        } else {
            return "failed";
        }
    }
}
