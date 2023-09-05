<?php

namespace App\Http\Controllers\Admin\Billing;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonPeriod;
use Faker\Provider\Biased;
use Illuminate\Http\Request;
use App\Mail\CreateBillInvoice;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin\Account\Account;
use App\Models\Admin\Billing\Billing;
use App\Models\Admin\Settings\Device;
use App\Models\Admin\Settings\Package;
use App\Models\Admin\Settings\Identity;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin\Account\Transaction;
use App\Models\Admin\Subscriber\Subscriber;
use App\Models\Admin\Settings\ConnectionType;
use App\Models\Admin\Subscriber\SubscriberCategory;

class BillingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('admin.billing.index');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function BillGenerate(Request $request)
    {
        try {
            $check = Billing::where('billing_month', $request->billing_month)->first();

            if ($check) {
                return 1;
            }
            return 0;
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function BillingMonth(Request $request)
    {
        try {
            if ($request->ajax()) {
                $billing_month = $request->billing_month;
                $month = Carbon::parse($billing_month)->format('m');
                $year = Carbon::parse($billing_month)->format('Y');
                $daysInMonth = Carbon::parse($billing_month)->daysInMonth;

                $data = Subscriber::with('packages')->where('status', 1)->whereMonth('created_at', '<=', $month)->whereYear('created_at', '<=', $year)->get();

                $accounts = Account::where('status', 1)->get();

                return Datatables::of($data)

                    ->addColumn('add_sub', function ($data) {
                        return '<select onchange="addSub(' . $data->id . ')" name="add_sub[]" id="add_sub' . $data->id . '" class="form-control"><option value="null" > Select </option><option value="1"> Addition </option> <option value="2"> Substraction </option></select>';
                    })

                    ->addColumn('status', function ($data) {
                        return '<select onchange="getAccount(' . $data->id . ')" name="status[]" id="status' . $data->id . '" class="form-control"> <option value="0"> Unpaid </option><option value="1"> Paid </option></select>';
                    })

                    ->addColumn('AccountName', function ($data){
                        $return = '<div class="form-group">
                        <select name="account_id[]" id="account_id'.$data->id.'" class="form-control">
                            <option value="">Select Account</option>
                        </select>
                        </div>';

                        return $return;
                    })

                    ->addColumn('input', function ($data) {
                        return '<input type="number" oninput="calculation(' . $data->id . ')" min="0" name="adjust_bill[]" id="adjust_bill' . $data->id . '" class="form-control adjust_bill">';
                    })

                    ->addColumn('used_day', function ($data) use ($month, $year, $daysInMonth) {
                        if ($data->created_at->month == $month && $data->created_at->year == $year) {
                            $days = ((int)$daysInMonth + 1) - (int)$data->created_at->day;
                            return '<input type="number" name="used_day[]" id="used_day' . $data->id . '" value="' . $days . '" class="form-control used_day" readonly>';
                        } else {
                            return '<input type="number" name="used_day[]" id="used_day' . $data->id . '" value="' . $daysInMonth . '" class="form-control used_day" readonly>';
                        }
                    })

                    ->addColumn('amount', function ($data) use ($month, $year, $daysInMonth) {

                        $result = $data->packages->amount;
                        $perDayCharge = ($result) / ($daysInMonth);
                        $total = (((int)$daysInMonth + 1) - (int)$data->created_at->day) * $perDayCharge;

                        if ($data->created_at->month == $month && $data->created_at->year == $year) {

                            return '<input type="number" name="total_amount[]" id="total_amount' . $data->id . '" value="' .
                                round($total, 2) . '" class="form-control total_amount" readonly>' .

                                '<input type="hidden" name="used_amount[]" id="prev_amount' . $data->id . '" value="' .      round($total, 2) . '" class="form-control prev_amount" >' .

                                '<input type="hidden" name="subscriber_id[]" id="" value="' . $data->id . '" class="form-control prev_amount" >' .

                                '<input type="hidden" name="package_id[]" id="" value="' . $data->package_id . '" class="form-control " >';
                        } else {
                            return '<input type="number" name="total_amount[]" id="total_amount' . $data->id . '" value="' . round($result, 2) . '" class="form-control total_amount" readonly>' .

                                '<input type="hidden" name="used_amount[]" id="prev_amount' . $data->id . '" value="' .      round($result, 2) . '" class="form-control" >' .

                                '<input type="hidden" name="subscriber_id[]" id="" value="' . $data->id . '" class="form-control " >' .

                                '<input type="hidden" name="package_id[]" id="" value="' . $data->package_id . '" class="form-control " >';
                        }
                    })

                    ->rawColumns(['add_sub', 'input', 'amount', 'status', 'AccountName', 'invoice', 'used_day'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function accounts(Request $request){
        $id = $request->status;
        $accounts= Account::where('status', $id)->get();
        return response()->json($accounts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $invoice = Billing::count();
            $bill_id = [];
            foreach ($request->total_amount as $key => $bill) {
                $data = new Billing;
                $data->subscriber_id = $request->subscriber_id[$key];
                $data->invoice = ++$invoice;
                $data->billing_month = $request->bill_month;
                $data->description = $request->description;
                $data->adjust_bill = $request->adjust_bill[$key];
                $data->used_day = $request->used_day[$key];
                $data->used_amount = $request->used_amount[$key];
                $data->status = $request->status[$key];
                $data->account_id = $request->account_id[$key];
                $data->add_sub = $request->add_sub[$key];
                $data->total_amount = $request->total_amount[$key];
                $data->package_id = $request->package_id[$key];
                $data->issue_date =  date('Y-m-d');
                $data->save();
                $bill_id[] = $data->id;
            }

            foreach ($request->total_amount as $key => $value) {
                if ($request->status[$key]  == 1){
                $account = new Transaction();
                $account->billing_id = $bill_id[$key];
                $account->account_id = $request->account_id[$key];
                $account->transaction_amount = $request->total_amount[$key];
                $account->transaction_type = 2;
                $account->payment_type = 1;
                $account->transaction_reason = 'Bill Receive';
                $account->transaction_date = date('Y-m-d');
                $account->save();
            }
           }

           $users = Subscriber::where('status', 1)->get();
            foreach ($users as $k => $user) {
                $details = Billing::where('subscriber_id', $user->id)->with('subscribers', 'packages')->get();
                Mail::to($user->email)->send(new CreateBillInvoice($details));
            }

            DB::commit();
            return redirect()->route('admin.bill-list')->with('message', 'Bill generated successfully');
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
        try {
            $data = Billing::with('subscribers', 'packages')->findOrFail($id);
            $issueDate = Carbon::createFromFormat('Y-m-d', $data->issue_date)->format('d M Y');
            return view('admin.billing.show', compact('data', 'issueDate'));
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
            $data = Billing::with('subscribers', 'packages', 'accounts')->findOrFail($id);
            $accounts = Account::where('status', 1)->orderby('id', 'desc')->get();
            return view('admin.billing.edit', compact('data', 'accounts'));
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors('error', $exception->getMessage());
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
        if($request->status == 1){
            $messages = array(
                'account_id.required' => 'Select account',
            );

            $this->validate($request, array(
                'account_id'=> 'required',
            ), $messages);
        }

        DB::beginTransaction();
        try {
            $data = Billing::findOrFail($id);
            $data->adjust_bill = $request->adjust_bill;
            $data->add_sub = $request->add_sub;
            $data->status = $request->status;
            $data->total_amount = $request->total_amount;
            $data->account_id = $request->account_id;
            $data->update();

            $findId = Transaction::where('billing_id', $data->id)->first();

            if($request->status == 1){
                if($findId){
                    $transaction = Transaction::findOrfail($findId->billing_id);
                    $transaction->billing_id = $data->id;
                    $transaction->account_id = $request->account_id;
                    $transaction->transaction_amount = $request->total_amount;
                    $transaction->transaction_type = 2;
                    $transaction->payment_type = 1;
                    $transaction->transaction_reason = 'Bill Receive';
                    $transaction->transaction_date = date('Y-m-d');
                    $transaction->update();
                }else{
                    $transaction = new Transaction;
                    $transaction->billing_id = $data->id;
                    $transaction->account_id = $request->account_id;
                    $transaction->transaction_amount = $request->total_amount;
                    $transaction->transaction_type = 2;
                    $transaction->payment_type = 1;
                    $transaction->transaction_reason = 'Bill Receive';
                    $transaction->transaction_date = date('Y-m-d');
                    $transaction->save();
                }
            }

            DB::commit();
            return redirect()->route('admin.bill-list')
                ->with('message', 'Billing information updated successfully');
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
            $data =  Billing::findOrFail($id);
            $data->delete();
            return redirect()->route('admin.bill-list')
                ->with('message', 'Subscriber deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function bill()
    {
        try {
            return view('admin.billing.monthly');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function monthlyBill()
    {
        try {
            if (request()->ajax()) {
                $data = Billing::with('subscribers', 'packages')->select('id', 'billing_month', DB::raw('count(*) as total'), DB::raw('SUM(total_amount) as total_amount'))->groupBy('billing_month')->orderby('billing_month', 'desc')->get();

                return Datatables::of($data)
                    ->addColumn('action', function ($data) {
                        if (Auth::user()->can('bill_show')) {
                        return '<a href="' . route('admin.monthly-bills', $data->billing_month) . ' " class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> </a>';
                        }
                        else{
                            return "--";
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function allMontlyBill($billing_month)
    {
        try {
            $billing_month = $billing_month;
            return view('admin.billing.bill_list', compact('billing_month'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function monthlyBillList(Request $request)
    {
        try {
            if (request()->ajax()) {
                $billing_month = $request->billing_month;
                $data  = Billing::with('subscribers', 'packages')->where('billing_month', $billing_month)->get();
                return Datatables::of($data)
                    ->addColumn('status', function (Billing $data) {
                        if ($data->status == 1) {
                            return ' Paid ';
                        } else {
                            return ' Unpaid ';
                        }
                    })

                    ->addColumn('action', function (Billing $data) {
                        if (Auth::user()->can('bill_invoice')) {
                            $invoice = ' <a href="' . route('admin.bill-invoice', $data->id) . ' " class="btn btn-sm btn-secondary"><i class="fas fa-file-invoice"></i></a> ';
                        } else {
                            $invoice = "";
                        }
                        if (Auth::user()->can('bill_show')) {
                            $show = '<a href="' . route('admin.bill.show', $data->id) . ' " class="btn btn-sm btn-primary" title="Show"><i class="fas fa-eye"></i> </a>';
                        } else {
                            $show = "";
                        }
                        if (Auth::user()->can('bill_edit')) {
                            $edit = ' <a href="' . route('admin.bill.edit', $data->id) . ' " class="btn btn-sm btn-info" title="Edit"><i class="fas fa-edit"></i> </a> ';
                        } else {
                            $edit = "";
                        }
                        if (Auth::user()->can('bill_delete')) {
                            $delete = ' <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.bill.destroy', $data->id) . ' " title="Delete" ><i class="fas fa-trash-alt"></i></button> ';
                        } else {
                            $delete = "";
                        }
                        return $invoice.$show.$edit.$delete;
                    })
                    ->addIndexColumn()
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function invoice($id)
    {
        try {
            $data = Billing::with('subscribers', 'packages')->findOrFail($id);
            $issueDate = Carbon::createFromFormat('Y-m-d', $data->issue_date)->format('M d, Y');
            return view('admin.billing.invoice', compact('data', 'issueDate'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function paidclient()
    {
        try {
            return view('admin.billing.paid');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function paidclients(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = Billing::with('subscribers', 'packages')->where('status', 1)->orderby('id', 'desc')->get();
                return Datatables::of($data)
                    ->addColumn('status', function (Billing $data) {
                        if ($data->status == 1) {
                            return ' Paid ';
                        }
                    })
                    ->addColumn('action', function (Billing $data) {
                        return '<a href="' . route('admin.bill.show', $data->id) . ' " class="btn btn-sm btn-primary"><i class="fas fa-eye" title="Show"></i> </a>';
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function unpaidclient()
    {
        try {
            return view('admin.billing.unpaid');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function unpaidclients(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = Billing::with('subscribers', 'packages')->where('status', 0)->orderby('id', 'desc')->get();

                return Datatables::of($data)
                    ->addColumn('status', function (Billing $data) {
                        if ($data->status == 0) {
                            return ' Un-Paid ';
                        }
                    })

                    ->addColumn('action', function (Billing $data) {
                        return '<a href="' . route('admin.bill.show', $data->id) . ' " class="btn btn-sm btn-primary"><i class="fas fa-eye" title="Show"></i> </a>';
                    })

                    ->addIndexColumn()
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
