<?php

namespace App\Http\Controllers\Admin\Account;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Account\Account;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin\Account\Transaction;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('admin.account.transaction.index');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //*** JSON Request
    public function transactions(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Transaction::with('accounts')->orderBy('id', 'desc');
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
                        $result = isset($data->description) ? $data->description : '--' ;
                        return Str::limit( $result, 20) ;
                    })

                    ->addColumn('account_name', function ($data) {
                        return $data->accounts->name ?? '';
                    })

                    ->addColumn('account_no', function ($data) {
                        return $data->accounts->account_no ?? '';
                    })

                    ->addColumn('bank', function (Transaction $data) {
                        return $data->accounts->banks->name ?? '';
                    })

                    ->addColumn('action', function (Transaction $data) {
                        if (Auth::user()->can('deposit_withdraw_show')) {
                            $show = '<a href="' . route('admin.transactions.show', $data->id) . ' " class="btn btn-sm btn-primary" title="Show"><i class="fa fa-eye"></i></a> ';
                        } else {
                            $show = '';
                        }
                        if (Auth::user()->can('deposit_withdraw_edit')) {
                            $edit = '<a id="edit" href="' . route('admin.transactions.edit', $data->id) . ' " class="btn btn-sm btn-info edit" title="Edit"><i class="fa fa-edit"></i></a> ';
                        } else {
                            $edit = '';
                        }
                        if (Auth::user()->can('deposit_withdraw_delete')) {
                            $delete = ' <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.transactions.destroy', $data->id) . ' " title="Delete"><i class="fa fa-trash-alt"></i></button>';
                        } else {
                            $delete = '';
                        }
                        return $show . $edit . $delete;
                    })

                    ->addIndexColumn()
                    ->rawColumns(['status', 'action', 'description', 'bank', 'account_name', 'account_no'])
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
            return view('admin.account.transaction.create', compact('accounts'));
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
            'account_id.required' => 'Enter account name',
            'transaction_amount.required' => 'Enter transaction amount',
            'transaction_date.required' => 'Enter transaction date',
            'transaction_type.required' => 'Choose transaction purpose',
            'payment_type.required' => 'Choose payment method',
        );

        $this->validate($request, array(
            'account_id' => 'required|string|',
            'transaction_amount' => 'required|numeric',
            'transaction_date' => 'required',
            'transaction_type' => 'required',
            'payment_type' => 'required',
        ), $messages);

        try {
            //Account Balance Check;
            $initial_Balance =  Account::where('id', $request->account_id)->first();
            $debit = Transaction::where('account_id', $request->account_id)
                ->where('transaction_type', 1)
                ->sum('transaction_amount');
            $credit =  Transaction::where('account_id', $request->account_id)
                ->where('transaction_type', 2)
                ->sum('transaction_amount');
            $balanceDebit = $initial_Balance->initial_balance + $credit;
            $balance = $balanceDebit - $debit;
            //Account Balance Check end;
            if ($request->transaction_type == 1 && $balance < $request->transaction_amount) {
                return redirect()->back()
                    ->with('message', 'Transactions  Failed');
            } else {
                $data = new Transaction();
                $data->account_id = $request->account_id;
                $data->transaction_amount = $request->transaction_amount;
                $data->transaction_date = Carbon::parse($request->transaction_date)->format('Y-m-d');
                $data->transaction_type = $request->transaction_type;
                $data->payment_type = $request->payment_type;
                $data->cheque_number = $request->cheque_number;
                $data->description = $request->description;
                if ($request->transaction_type == 1) {
                    $data->transaction_reason = 'Withdraw'; //debit
                } else {
                    $data->transaction_reason = 'Deposit'; //credit
                }
                $data->save();

                return redirect()->route('admin.transactions.index')
                    ->with('message', 'Transactions created successfully');
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }


    public function show($id)
    {
        try {
            $data = Transaction::with('accounts','expenses')->findOrFail($id);
            return view('admin.account.transaction.show', compact('data'));
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
            $data = Transaction::findOrFail($id);
            $accounts = Account::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.account.transaction.edit', compact('data', 'accounts'));
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
            'account_id.required' => 'Enter account name',
            'transaction_amount.required' => 'Enter transaction amount',
            'transaction_date.required' => 'Enter transaction date',
            'transaction_type.required' => 'Choose transaction purpose',
            'payment_type.required' => 'Choose payment method',
        );

        $this->validate($request, array(
            'account_id' => 'required|string|',
            'transaction_amount' => 'required|numeric',
            'transaction_date' => 'required',
            'transaction_type' => 'required',
            'payment_type' => 'required',
        ), $messages);

        try {
            $initial_Balance =  Account::where('id', $request->account_id)->first();
            $debit = Transaction::where('account_id', $request->account_id)
                ->where('transaction_type', 1)
                ->sum('transaction_amount');
            $credit =  Transaction::where('account_id', $request->account_id)
                ->where('transaction_type', 2)
                ->sum('transaction_amount');
            $balanceDebit = $initial_Balance->initial_balance + $credit;
            $balance = $balanceDebit - $debit;

            if ($request->transaction_type == 1 && $balance < $request->transaction_amount) {
                return redirect()->back()
                    ->with('error', 'Transactions updated Failed');
            } else {
                $data = Transaction::findOrFail($id);
                $data->account_id = $request->account_id;
                $data->transaction_amount = $request->transaction_amount;
                $data->transaction_date = Carbon::parse($request->transaction_date)->format('Y-m-d');
                $data->transaction_type = $request->transaction_type;
                $data->payment_type = $request->payment_type;
                $data->cheque_number = $request->cheque_number;
                $data->description = $request->description;
                if ($request->purpose == 1) {
                    $data->transaction_reason = 'Withdraw'; //debit
                } else {
                    $data->transaction_reason = 'Deposit'; //credit
                }
                $data->update();

                return redirect()->route('admin.transactions.index')
                    ->with('message', 'Transactions updated successfully');
            }
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
            $data = Transaction::findOrFail($id);
            $data->delete();
            return back()->with('message', 'Transaction deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function StatusChange(Request $request)
    {
        $id = $request->id;
        $status_check   = Transaction::findOrFail($id);
        $status         = $status_check->status;

        if ($status == 1) {
            $status_update = 0;
        } else {
            $status_update = 1;
        }

        $data           = array();
        $data['status'] = $status_update;
        Transaction::where('id', $id)->update($data);
        if ($status_update == 1) {
            return "success";
        } else {
            return "failed";
        }
    }

    public function balance()
    {
        try {
            return view('admin.account.transaction.balance');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function AllBalance(Request $request)
    {
        try {
            if ($request->ajax()) {
                $accounts = Account::with('banks', 'transactions')->where('status', 1)->get();

                $data = [];

                foreach ($accounts as $key => $account) {
                    $balance['bank'] = $account->banks->name;
                    $balance['name'] = $account->name;
                    $balance['account_no'] = $account->account_no;
                    $balance['initial_balance'] = $account->initial_balance;

                    $balance['credit'] = Transaction::where('account_id', $account->id)->where('transaction_type', 2)->sum('transaction_amount');

                    $balance['debit'] = Transaction::where('account_id', $account->id)->where('transaction_type', 1)->sum('transaction_amount');
                    $data[] = $balance;
                }

                return Datatables::of($data)

                    ->addColumn('bank', function ($data) {
                        return $data['bank'];
                    })

                    ->addColumn('initial_balance', function ($data) {
                        return (number_format((float)$data['initial_balance'], 2, '.', ''));
                    })

                    ->addColumn('credit', function ($data) {
                        return (number_format((float)$data['credit'], 2, '.', ''));
                    })

                    ->addColumn('debit', function ($data) {
                        return (number_format((float)$data['debit'], 2, '.', ''));
                    })

                    ->addColumn('current_balance', function ($data) {
                        return (number_format((float)($data['initial_balance'] + $data['credit'] - $data['debit']), 2, '.', ''));
                    })

                    ->addIndexColumn()
                    ->rawColumns(['bank', 'initial_balance', 'credit', 'debit', 'current_balance'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function statement()
    {
        try {
            $accounts = Account::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.account.transaction.statement', compact('accounts'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function statements(Request $request)
    {
        try {
            if ($request->ajax()) {
                $acc = Account::findOrFail($request->account_id);
                $balance = $acc->initial_balance;

                $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
                $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

                $credit = Transaction::where('account_id', $request->account_id)
                    ->where('transaction_type', 2)
                    ->where('transaction_date', '<', $start_date)
                    ->sum('transaction_amount');

                $debit = Transaction::where('account_id', $request->account_id)
                    ->where('transaction_type', 1)
                    ->where('transaction_date', '<', $start_date)
                    ->sum('transaction_amount');

                $previous_balance = ($balance + $credit) - $debit;

                $data = Transaction::with('accounts')
                    ->where('account_id', $request->account_id)
                    ->where('transaction_date', '>=', $start_date)
                    ->where('transaction_date', '<=', $end_date)
                    ->orderBy('transaction_date', 'asc');

                return Datatables::of($data)

                    ->addColumn('credit', function (Transaction $data) {
                        if ($data->transaction_type == 2) {
                            return  $data->transaction_amount;
                        } else {
                            return  '<p> 00.00 </p>';
                        }
                    })

                    ->addColumn('debit', function (Transaction $data) {
                        if ($data->transaction_type == 1) {
                            return  $data->transaction_amount;
                        } else {
                            return  '<p> 00.00 </p>';
                        }
                    })
                    ->addColumn('transaction_reason', function (Transaction $data) {
                        if ($data->transaction_reason) {
                            return  $data->transaction_reason;
                        } else {
                            return  'Initial Balance';
                        }
                    })

                    ->addColumn('current_balance', function ($data) use (&$previous_balance) {
                        if ($data->transaction_type == 1) {
                            $previous_balance = $previous_balance - $data->transaction_amount;
                            return $previous_balance;
                        } elseif ($data->transaction_type == 2) {
                            $previous_balance = $previous_balance + $data->transaction_amount;
                            return $previous_balance;
                        }
                    })

                    ->with('prevBalance', $previous_balance)
                    ->rawColumns(['credit', 'debit', 'current_balance','transaction_reason'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function getAccountBalance(Request $request, $id)
    {
        if ($request->ajax()) {
            $initial_Balance =  Account::where('id', $id)->first();
            $debit = Transaction::where('account_id', $id)
                ->where('transaction_type', 1)
                ->sum('transaction_amount');
            $credit =  Transaction::where('account_id', $id)
                ->where('transaction_type', 2)
                ->sum('transaction_amount');
            $balanceDebit = $initial_Balance->initial_balance + $credit;

            $balance = $balanceDebit - $debit;
            return response()->json($balance);
        }
    }
    public function getAccountInitialBalance(Request $request, $id)
    {
        if ($request->ajax()) {
            $initial_Balance =  Account::find($id)->initial_balance;
            return response()->json($initial_Balance);
        }
    }
}
