<?php

namespace App\Http\Controllers\Admin\Account;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\Account\Bank;
use App\Http\Controllers\Controller;
use App\Models\Admin\Account\Account;
use App\Models\Admin\Account\AccountType;
use Yajra\DataTables\Facades\DataTables;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('admin.account.index');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //*** JSON Request
    public function account(Request $request)
    {
        try {
            //--- Integrating This Collection Into Datatables
            if ($request->ajax()) {

                $data = Account::with('banks', 'types')->orderBy('id', 'desc')->get();

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

                    ->addColumn('action', function (Account $data) {
                        return '<a href="' . route('admin.account.show', $data->id) . ' " class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>

                        <a href="' . route('admin.account.edit', $data->id) . ' " class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>

                        <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.account.destroy', $data->id) . ' " title="Delete"><i class="fa fa-trash-alt"></i></button>';
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
            $banks = Bank::where('status', 1)->orderBy('id', 'desc')->get();
            $account_types = AccountType::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.account.create', compact('account_types','banks'));
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
            'name.required' => 'Enter account name',
            'bank_id.required' => 'Select bank',
            'account_type_id.required' => 'Select account type',
            'account_no.required' => 'Enter account no',
            'branch_name.required' => 'Enter bank branch name',
            'branch_address.required' => 'Enter bank address',
            'initial_balance.required' => 'Enter initial balance',
        );

        $this->validate($request, array(
            'name' => 'required|string|',
            'bank_id' => 'required',
            'account_type_id' => 'required',
            'account_no' => 'required|string|unique:accounts,account_no,NULL,id,deleted_at,NULL',
            'branch_name' => 'required|string',
            'branch_address' => 'required|string',
            'initial_balance' => 'required|numeric',
        ), $messages);

        // dd('ismail');

        try {
            $data = new Account();
            $data->account_type_id = $request->account_type_id;
            $data->name = $request->name;
            $data->account_no = $request->account_no;
            $data->bank_id = $request->bank_id;
            $data->branch_name = $request->branch_name;
            $data->branch_address = $request->branch_address;
            $data->initial_balance = $request->initial_balance;
            $data->status = $request->status;
            $data->description = $request->description;
            // dd($data);
            $data->save();

            return redirect()->route('admin.account.index')
                ->with('message', 'Account created successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }


    public function show($id)
    {
        try {
            $data = Account::with('banks','types')->orderBy('id', 'desc')->findOrFail($id);
            return view('admin.account.show', compact('data'));
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
            $data = Account::findOrFail($id);
            $banks = Bank::where('status', 1)->orderBy('id', 'desc')->get();
            $account_types = AccountType::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.account.edit', compact('account_types', 'banks','data'));
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
        // dd($request->all());
        $messages = array(
            'name.required' => 'Enter account name',
            'bank_id.required' => 'Select bank',
            'account_type_id.required' => 'Select account type',
            'account_no.required' => 'Enter account no',
            'branch_name.required' => 'Enter bank branch name',
            'branch_address.required' => 'Enter bank address',
            'initial_balance.required' => 'Enter initial balance',
        );

        // dd('ismail');

        $this->validate($request, array(
            'name' => 'required|string|',
            'bank_id' => 'required',
            'account_type_id' => 'required',
            'account_no' => 'required|string|unique:accounts,account_no,'.$id.',id,deleted_at,NULL',
            'branch_name' => 'required|string',
            'branch_address' => 'required|string',
            'initial_balance' => 'required|numeric',
        ), $messages);

        // dd('ismailh');

        try {
            $data = Account::findOrFail($id);
            $data->account_type_id = $request->account_type_id;
            $data->name = $request->name;
            $data->account_no = $request->account_no;
            $data->bank_id = $request->bank_id;
            $data->branch_name = $request->branch_name;
            $data->branch_address = $request->branch_address;
            $data->initial_balance = $request->initial_balance;
            $data->status = $request->status;
            $data->description = $request->description;
            // dd($data);
            $data->update();

            return redirect()->route('admin.account.index')
            ->with('message', 'Account updated successfully');
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
            $data = Account::findOrFail($id);
            $data->delete();
            return back()->with('message', 'Account deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    // end delete function

    //starts status change function
    public function StatusChange(Request $request)
    {
        $id = $request->id;

        $status_check   = Account::findOrFail($id);
        $status         = $status_check->status;

        if ($status == 1) {
            $status_update = 0;
        } else {
            $status_update = 1;
        }

        $data           = array();
        $data['status'] = $status_update;
        Account::where('id', $id)->update($data);
        if ($status_update == 1) {
            return "success";
            exit();
        } else {
            return "failed";
        }
    }
    //end status change function
}
