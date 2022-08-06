<?php

namespace App\Http\Controllers\Admin\Complaint;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            return view('admin.complaint.index', );
            } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //*** JSON Request
    public function complaints(Request $request)
    {
        try {
            //--- Integrating This Collection Into Datatables
            if ($request->ajax()) {

                $data = Complaint::with('classifications')->orderBy('id', 'desc')->get();

                return Datatables::of($data)

                    ->addColumn('ticket_option', function ($data) {
                        if($data->ticket_option == 1){
                            return 'Open';
                        }else{
                            return 'Close';
                        }
                    })

                    ->addColumn('action', function (Complaint $data) {
                        return '<a href="' . route('admin.complaint.show', $data->id) . ' " class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>

                        <a href="' . route('admin.complaint.edit', $data->id) . ' " class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>

                    <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.complaint.destroy', $data->id) . ' " title="Delete" ><i class="fa fa-trash-alt"></i></button>';
                    })

                    ->rawColumns(['action', 'ticket_option'])
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
            $classifications = Classification::all();
            $cid = Complaint::count();
            return view('admin.complaint.create', compact('classifications', 'cid'));
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
            'name.required' => 'Enter complaint name',
            'classification_id.required' => 'Select ticket type',
            'address.required' => 'Enter your address',
            'contact_no.required' => 'Enter your contact number',
            'email.required' => 'Enter your email address',
            'operator_name.required' => 'Enter operator name',
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
            $data->ticket_option = $request->ticket_option;
            $data->operator_name = $request->operator_name;
            $data->description = $request->description;
            // dd($data);
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
        try{
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

    // start update function
    public function update(Request $request, $id)
    {
        $messages = array(
            'name.required' => 'Enter complaint name',
            'classification_id.required' => 'Select ticket type',
            'address.required' => 'Enter your address',
            'contact_no.required' => 'Enter your contact number',
            'email.required' => 'Enter your email address',
            'operator_name.required' => 'Enter operator name',
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
            $data->ticket_option = $request->ticket_option;
            $data->operator_name = $request->operator_name;
            $data->description = $request->description;
            $data->update();

            return redirect()->route('admin.complaint.index')
                ->with('message', 'Complain updated successfully');
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
    // end delete function

    //starts status change function
    public function StatusChange(Request $request)
    {
        $id = $request->id;

        $status_check   = Complaint::findOrFail($id);
        $status         = $status_check->status;

        if ($status == 1) {
            $status_update = 0;
        } else {
            $status_update = 1;
        }

        $data           = array();
        $data['status'] = $status_update;
        Complaint::where('id', $id)->update($data);
        if ($status_update == 1) {
            return "success";
            exit();
        } else {
            return "failed";
        }
    }
    //end status change function
}
