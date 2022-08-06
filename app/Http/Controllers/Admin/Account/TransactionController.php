<?php

namespace App\Http\Controllers\Admin\Account;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            //--- Integrating This Collection Into Datatables
            if ($request->ajax()) {

                $data = Transaction::with('accounts')->orderBy('id', 'desc')->get();

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

                    ->addColumn('bank', function (Transaction $data) {
                        return $data->accounts->banks->name;
                    })

                    ->addColumn('action', function (Transaction $data) {
                        return '<a href="' . route('admin.transactions.show', $data->id) . ' " class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>

                        <a id="edit" href="' . route('admin.transactions.edit', $data->id) . ' " class="btn btn-sm btn-info edit"><i class="fa fa-edit"></i></a>

                        <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.transactions.destroy', $data->id) . ' " title="Delete"><i class="fa fa-trash-alt"></i></button>';
                    })

                    ->rawColumns(['status', 'action', 'description', 'bank'])
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
        // dd($request->all());
        $messages = array(
            'account_id.required' => 'Enter account name',
            'transaction_amount.required' => 'Enter transaction amount',
            'transaction_date.required' => 'Enter transaction date',
            'purpose.required' => 'Choose transaction purpose',
            'payment_type.required' => 'Choose payment method',
            // 'cheque_number.required' => 'Enter cheque number',
        );

        $this->validate($request, array(
            'account_id' => 'required|string|',
            'transaction_amount' => 'required|numeric',
            'transaction_date' => 'required',
            'purpose' => 'required',
            'payment_type' => 'required',
            // 'cheque_number' => 'required|string',
        ), $messages);

        try {
            $data = new Transaction();
            $data->account_id = $request->account_id;
            $data->transaction_amount = $request->transaction_amount;
            $data->transaction_date = $request->transaction_date;
            $data->purpose = $request->purpose;
            $data->payment_type = $request->payment_type;
            $data->cheque_number = $request->cheque_number;
            $data->status = $request->status;
            $data->description = $request->description;
            // dd($data);
            $data->save();

            return redirect()->route('admin.transactions.index')
                ->with('message', 'Transactions created successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }


    public function show($id)
    {
        try {
            $data = Transaction::with('accounts')->findOrFail($id);
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

    // start update function
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $messages = array(
            'account_id.required' => 'Enter account name',
            'transaction_amount.required' => 'Enter transaction amount',
            'transaction_date.required' => 'Enter transaction date',
            'purpose.required' => 'Choose transaction purpose',
            'payment_type.required' => 'Choose payment method',
            // 'cheque_number.required' => 'Enter cheque number',
        );

        $this->validate($request, array(
            'account_id' => 'required|string|',
            'transaction_amount' => 'required|numeric',
            'transaction_date' => 'required',
            'purpose' => 'required',
            'payment_type' => 'required',
            // 'cheque_number' => 'required|string',
        ), $messages);

        try {
            $data = Transaction::findOrFail($id);
            $data->account_id = $request->account_id;
            $data->transaction_amount = $request->transaction_amount;
            $data->transaction_date = $request->transaction_date;
            $data->purpose = $request->purpose;
            $data->payment_type = $request->payment_type;
            $data->cheque_number = $request->cheque_number;
            $data->status = $request->status;
            $data->description = $request->description;
            // dd($data);
            $data->update();

            return redirect()->route('admin.transactions.index')
                ->with('message', 'Transactions updated successfully');
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
            $data = Transaction::findOrFail($id);
            $data->delete();
            return back()->with('message', 'Transaction deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    // end delete function

    //starts status change function
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
            exit();
        } else {
            return "failed";
        }
    }
    //end status change function

    //balance sheet

    public function balance()
    {
        try {
            return view('admin.account.transaction.balance');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    // balance sheet data list

    public function AllBalance(Request $request)
    {
        try {
            if ($request->ajax()) {

                //$data = Transaction::with('accounts')->where('status', 1)->orderBy('id', 'desc')->get();

                $accounts = Account::with('banks', 'transactions')->where('status', 1)->get();
                // dd($accounts);
                $data = [];

                foreach ($accounts as $key => $account) {
                    $balance['bank'] = $account->banks->name;
                    $balance['name'] = $account->name;
                    $balance['account_no'] = $account->account_no;
                    $balance['initial_balance'] = $account->initial_balance;

                    $balance['credit'] = Transaction::where('account_id', $account->id)->whereIn('purpose', [3, 4])->sum('transaction_amount');

                    $balance['debit'] = Transaction::where('account_id', $account->id)->whereIn('purpose', [1, 2])->sum('transaction_amount');
                    // dd($balance['debit']);
                    array_push($data, $balance);
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

                    ->rawColumns(['bank', 'initial_balance', 'credit', 'debit', 'current_balance'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    // account statement index
    public function statement()
    {
        try {
            $accounts = Account::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.account.transaction.statement', compact('accounts'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    // account statement details
    public function statements(Request $request)
    {
        try {


            if ($request->ajax()) {

                $data = Transaction::with('accounts')->where('account_id', $request->account_id)->where('transaction_date', '>=', $request->start_date)->where('transaction_date', '<=', $request->end_date)->orderBy('transaction_date', 'desc')->get();

                // $data = Transaction::with('accounts')->where('account_id', $request->account_id)->whereBetween('transaction_date', [$request->start_date, $request->end_date])->get();

                // dd($data);

                return Datatables::of($data)

                    ->addColumn('bank', function (Transaction $data) {
                        return $data->accounts->banks->name;
                    })

                    ->addColumn('credit', function (Transaction $data) {
                        if ($data->purpose == 3 || $data->purpose == 4) {
                            return  $data->transaction_amount;
                        } else {
                            return  '<p> 00.00 </p>';
                        }
                    })

                    ->addColumn('debit', function (Transaction $data) {
                        if ($data->purpose == 1 || $data->purpose == 2) {
                            return  $data->transaction_amount;
                        } else {
                            return  '<p> 00.00 </p>';
                        }
                    })

                    ->addColumn('current_balance', function (Transaction $data) {
                        if ($data->purpose == 1 || $data->purpose == 2) {
                            return  $data->accounts->initial_balance - $data->transaction_amount;
                        } elseif ($data->purpose == 3 || $data->purpose == 4) {
                            return $data->accounts->initial_balance + $data->transaction_amount;
                        }
                    })

                    ->rawColumns(['bank', 'credit', 'debit', 'current_balance'])
                    // ->toJson();
                    ->make(true);
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
