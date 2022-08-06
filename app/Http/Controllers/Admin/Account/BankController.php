<?php

namespace App\Http\Controllers\Admin\Account;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\Account\Bank;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('admin.account.bank.index');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //*** JSON Request
    public function bank(Request $request)
    {
        try {
            //--- Integrating This Collection Into Datatables
            if ($request->ajax()) {

                $data = Bank::orderBy('id', 'desc')->get();

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

                    ->addColumn('action', function (Bank $data) {
                        return '<a href="' . route('admin.bank.edit', $data->id) . ' " class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>

                    <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.bank.destroy', $data->id) . ' " title="Delete"><i class="fa fa-trash-alt"></i></button>';
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
        try {
            return view('admin.account.bank.create');
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
            'name.required' => 'Enter bank name',
        );

        $this->validate($request, array(
            'name' => 'required|string|unique:banks,name,NULL,id,deleted_at,NULL',
        ), $messages);

        try {
            $data = new Bank();
            $data->name = $request->name;
            $data->status = $request->status;
            $data->description = $request->description;
            $data->save();

            return redirect()->route('admin.bank.index')
                ->with('message', 'Bank created successfully');
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
            $data = Bank::findOrFail($id);
            return view('admin.account.bank.edit', compact('data'));
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
            'name.required' => 'Enter a classification name',
        );

        $this->validate($request, array(
            'name' => 'required|unique:banks,name,' . $id . ',id,deleted_at,NULL',
        ), $messages);

        try {
            $data = Bank::findOrFail($id);
            $data->name = $request->name;
            $data->status = $request->status;
            $data->description = $request->description;
            $data->update();

            return redirect()->route('admin.bank.index')
                ->with('message', 'Bank updated successfully');
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
            $data = Bank::findOrFail($id);
            $data->delete();
            return back()->with('message', 'Bank deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    // end delete function

    //starts status change function
    public function StatusChange(Request $request)
    {
        $id = $request->id;

        $status_check   = Bank::findOrFail($id);
        $status         = $status_check->status;

        if ($status == 1) {
            $status_update = 0;
        } else {
            $status_update = 1;
        }

        $data           = array();
        $data['status'] = $status_update;
        Bank::where('id', $id)->update($data);
        if ($status_update == 1) {
            return "success";
            exit();
        } else {
            return "failed";
        }
    }
    //end status change function
}
