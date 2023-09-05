<?php

namespace App\Http\Controllers\Admin\Account;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Account\Account;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin\Account\Transaction;
use App\Models\Admin\Account\FundTransfer;

class FundTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('admin.account.fund_transfer.index');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function FundTransfer(Request $request)
    {
        try {

            if ($request->ajax()) {

                $data = FundTransfer::with('accounts', 'FundTransfers')->orderBy('id', 'desc');

                return Datatables::of($data)

                    ->addColumn('FromAccount', function (FundTransfer $data) {
                        return $data->accounts->name;
                    })

                    ->addColumn('ToAccount', function (FundTransfer $data) {
                        return $data->FundTransfers->name;
                    })

                    ->addColumn('action', function (FundTransfer $data) {

                        if (Auth::user()->can('balance_transfer_edit')) {
                            $edit = ' <a href="' . route('admin.fund-transfer.edit', $data->id) . ' " class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';
                        } else {
                            $edit = " ";
                        }
                        if (Auth::user()->can('balance_transfer_delete')) {
                            $delete = ' <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.fund-transfer.destroy', $data->id) . ' " title="Delete"><i class="fa fa-trash-alt"></i></button>';
                        } else {
                            $delete = " ";
                        }
                        return $edit.$delete;
                    })

                    ->addIndexColumn()
                    ->rawColumns(['action', 'FromAccount', 'ToAccount'])
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
            $accounts = Account::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.account.fund_transfer.create', compact('accounts'));
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
        if ($request->from_account_id == $request->to_account_id) {
            return redirect()->back()->with('error', 'Both account can not be same');
        }

        $initial_balance = Account::findOrFail($request->from_account_id)->initial_balance;

        $credit_amount = Transaction::where('account_id', $request->id)->where('transaction_type', 2)->sum('transaction_amount');

        $total_credit = (float)$initial_balance + (float)$credit_amount;

        $debit_amount = Transaction::where('account_id', $request->id)->where('transaction_type', 1)->sum('transaction_amount');
        $total_amount = (float)$total_credit - (float)$debit_amount;

        if ($total_amount < $request->amount) {
            return redirect()->back()->with('error', "You don't have sufficient balance.");
        }

        $messages = array(
            'date.required' => 'Enter date',
            'from_account_id.required' => 'Select From Account',
            'to_account_id.required' => 'Select To Account',
            'amount.required' => 'Enter transfer amount',
        );

        $this->validate($request, array(
            'date' => 'required',
            'from_account_id' => 'required',
            'to_account_id' => 'required',
            'amount' => 'required',
        ), $messages);

        DB::beginTransaction();

        try {
            $data = new FundTransfer();
            $data->from_account_id = $request->from_account_id;
            $data->to_account_id = $request->to_account_id;
            $data->date = Carbon::parse($request->date)->format('Y-m-d');
            $data->amount = $request->amount;
            $data->description = $request->description;
            $data->save();

            if ($data) {
                $account = new Transaction();
                $account->fund_transfer_id  = $data->id;
                $account->account_id  = $data->from_account_id;
                $account->transaction_amount = $data->amount;
                $account->transaction_date = Carbon::parse($request->date)->format('Y-m-d');
                $account->transaction_type = 1;
                $account->payment_type = 1;
                $account->transaction_reason = 'Fund Transfer';
                $account->save();
            }

            if ($data) {
                $account = new Transaction();
                $account->fund_transfer_id  = $data->id;
                $account->account_id  = $data->to_account_id;
                $account->transaction_amount = $data->amount;
                $account->transaction_date = Carbon::parse($request->date)->format('Y-m-d');
                $account->transaction_type = 2;
                $account->payment_type = 1;
                $account->transaction_reason = 'Fund Transfer';
                $account->save();
            }

            DB::commit();

            return redirect()->route('admin.fund-transfer.index')
                ->with('message', 'Fund-transfer successfully done');
        } catch (\Exception $exception) {
            DB::rollback();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            $data = FundTransfer::findOrFail($id);
            $accounts = Account::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.account.fund_transfer.edit', compact('accounts', 'data'));
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
        if ($request->from_account_id == $request->to_account_id) {
            return redirect()->back()->with('error', 'Both account can not be same');
        }

        $initial_balance = Account::findOrFail($request->from_account_id)->initial_balance;

        $credit_amount = Transaction::where('account_id', $request->id)->where('transaction_type', 2)->sum('transaction_amount');

        $total_credit = (float)$initial_balance + (float)$credit_amount;

        $debit_amount = Transaction::where('account_id', $request->id)->where('transaction_type', 1)->sum('transaction_amount');
        $total_amount = (float)$total_credit - (float)$debit_amount;

        if ($total_amount < $request->amount) {
            return redirect()->back()->with('error', "You don't have sufficient balance.");
        }

        $messages = array(
            'transaction_date.required' => 'Enter date',
            'from_account_id.required' => 'Select From Account',
            'to_account_id.required' => 'Select To Account',
            'amount.required' => 'Enter transfer amount',
        );

        $this->validate($request, array(
            'transaction_date' => 'required',
            'from_account_id' => 'required',
            'to_account_id' => 'required',
            'amount' => 'required',
        ), $messages);

        DB::beginTransaction();

        try {
            $data = FundTransfer::findOrFail($id);
            $data->from_account_id = $request->from_account_id;
            $data->to_account_id = $request->to_account_id;
            $data->date = Carbon::parse($request->date)->format('Y-m-d');
            $data->amount = $request->amount;
            $data->description = $request->description;
            $data->update();

            if ($data) {
                $transaction = Transaction::where('fund_transfer_id', $id)->get();
                foreach ($transaction as $key => $value) {
                    if ($value->transaction_type == 1) {
                        $value->account_id = $request->from_account_id;
                    } else {
                        $value->account_id = $request->to_account_id;
                    }
                    $value->transaction_date = Carbon::parse($request->date)->format('Y-m-d');
                    $value->transaction_amount = $request->amount;
                    $value->update();
                }
            }

            DB::commit();

            return redirect()->route('admin.fund-transfer.index')
                ->with('message', 'Fund-transfer successfully updated');
        } catch (\Exception $exception) {
            DB::rollback();
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
            $data = FundTransfer::findOrFail($id);
            Transaction::where('fund_transfer_id', $data->id)->delete();
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Fund-transfer deleted successfully.',
            ]);
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return response()->json([
                'success' => false,
                'message' => $bug,
            ]);
        }
    }
}
