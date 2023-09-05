<?php

namespace App\Http\Controllers\Admin\Account;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Account\Account;
use App\Models\Admin\Account\BillPay;
use App\Models\Admin\Billing\Billing;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin\Account\Transaction;
use App\Models\Admin\Subscriber\Subscriber;
use App\Models\Admin\Subscriber\ChangeRequest;
use App\Models\Admin\Account\Account as AccountAccount;

class BillPayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('admin.account.bill_pay.index');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }


    public function billpay(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = BillPay::with('subscribers')->orderBy('id', 'desc');
                return Datatables::of($data)

                    ->addColumn('date', function (BillPay $data) {
                        return Carbon::parse($data->date)->format('d M Y');
                    })

                    ->addColumn('ClientId', function (BillPay $data) {
                        $client = isset($data->subscribers) ? $data->subscribers->subscriber_id : null;
                        return $client;
                    })

                    ->addColumn('action', function (BillPay $data) {
                        if (Auth::user()->can('bill_edit')) {
                            $view = '<a href="' . route('admin.bill.show', $data->id) . ' " class="btn btn-sm btn-primary" title="Show"><i class="fas fa-eye"></i> </a>';
                        }
                        else{
                            $view = "";
                        }
                        return $view;
                    })

                    ->addIndexColumn()
                    ->rawColumns(['action','date','ClientId'])
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
            $client = Billing::where('status', 0)->get();
            $accounts = Account::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.account.bill_pay.create', compact('accounts','client'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function subscribers(Request $request)
    {
        try {
            $subscriber = Subscriber::where('id', $request->id)->first();
            $client_billing_data = Billing::with('subscribers')->where('subscriber_id', $request->id)->first();

            return response()->json([
                'subscriber'=> $subscriber,
                'client_billing_data'=> $client_billing_data,
            ]);

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
            'subscriber_id.required' => 'Select Client ID',
            'date.required' => 'Enter date',
        );

        $this->validate($request, array(
            'subscriber_id' => 'required',
            'date' => 'required',
        ), $messages);

        DB::beginTransaction();

        try {
            $data = new BillPay();
            $data->client_id = $request->client_id;
            $data->subscriber_id = $request->subscriber_id;
            $data->name = $request->name;
            $data->billing_month = $request->billing_month;
            $data->amount = $request->amount;
            $data->account_id = $request->account_id;
            $data->date = Carbon::parse($request->date)->format('Y-m-d');
            $data->save();

            Billing::where('subscriber_id', $request->subscriber_id)->update(['status' => 1]);

            DB::commit();

            return redirect()->route('admin.bill-pay.index')
            ->with('message', 'Client bill paid successfully');
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function ClientBillRequest()
    {
        try {
            $user = User::with('subscribers')->where('subscriber_id', Auth::user()->subscriber_id)->first();
            $client_billing_data = Billing::with('subscribers',)->where('subscriber_id', $user->subscriber_id)->where('status', 0)->first();
            return view('admin.client.bill_pay', compact('user','client_billing_data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function ClientBillStore(Request $request)
    {
        $messages = array(
            'date.required' => 'Enter date',
        );

        $this->validate($request, array(
            'date' => 'required',
        ), $messages);

        try {
            $data = new ChangeRequest();
            $data->subscriber_id = $request->subscriber_id;
            $data->billpay_id  = $request->billpay_id ;
            $data->save();

            return redirect()->route('admin.request-bill')
                ->with('message', 'equest successfully submitted');

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
            $data = BillPay::findOrFail($id);
            $data->delete();
            return back()->with('message', 'This data deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function requestbill()
    {
        try {
            $client = Billing::where('status', 0)->get();
            $accounts = Account::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.account.bill_pay.request_bill', compact('accounts','client'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function client_bill($id)
    {
        try {
            $client = Billing::with('subscribers', 'packages')->findOrFail($id);
            $accounts = Account::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.account.bill_pay.approve_request_bill', compact('accounts','client'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function client_bill_update(Request $request, $id)
    {
        $messages = array(
            'subscriber_id.required' => 'Enter Client ID',
            'date.required' => 'Enter date',
            'account_id.required' => 'Select Account',
        );

        $this->validate($request, array(
            'subscriber_id' => 'required',
            'date' => 'required',
            'account_id' => 'required',
        ), $messages);

        DB::beginTransaction();

        try {
            $data = Billing::findOrFail($id);
            $data->subscriber_id = $request->subscriber_id;
            $data->account_id = $request->account_id;
            $data->status = 1;
            $data->issue_date = Carbon::parse($request->date)->format('Y-m-d');
            $data->update();

            $value= ChangeRequest::findOrFail($id);
            $value->subscriber_id = $request->subscriber_id;
            $value->billpay_id = $id;
            $value->status = 1;
            $value->update();

            $transaction = new Transaction();
            $transaction->account_id = $request->account_id;
            $transaction->billing_id  = $id ;
            $transaction->transaction_amount  = $request->amount ;
            $transaction->transaction_date  = $request->date ;
            $transaction->transaction_reason  = 'Bill Receive' ;
            $transaction->transaction_type   = 2 ;
            $transaction->payment_type    = 1 ;
            $transaction->save();

            DB::commit();

            return redirect()->route('admin.request-bill')
            ->with('message', 'Request Approved Successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function billpays(Request $request)
    {
        try {
            if ($request->ajax()) {

                if ((Auth::user()->type) == 2) {
                    $data = ChangeRequest::with('billings', 'subscribers')->WhereNotNull('billpay_id')->where('subscriber_id',  Auth::user()->subscriber_id)->orderBy('id', 'desc')->get();
                }else{
                    $data = ChangeRequest::with('billings', 'subscribers')->WhereNotNull('billpay_id')->orderBy('id', 'desc')->get();
                }
                return Datatables::of($data)
                    ->addColumn('status', function (ChangeRequest $data) {
                        if ((Auth::user()->type) == 2) {
                            if ($data->status == 1) {
                                return '<span class="badge badge-primary" title="Approved">Approved</span>';
                            } else {
                                return '<span class="badge badge-danger" title="Pending">Pending</span>';
                            }
                        }

                        $button = '<a href="' . route('admin.approve-request-bill', $data->id) . ' " class="btn btn-sm btn-danger" title="Pending">Pending</a>';

                        if ($data->status == 1) {
                            return '<span class="badge badge-primary" title="Approved">Approved</span>';
                        } else {
                            return $button;
                        }
                    })

                    ->addColumn('date', function (ChangeRequest $data) {
                        return Carbon::parse($data->date)->format('d M Y');
                    })

                    ->addColumn('Month', function (ChangeRequest $data) {
                        $month = isset($data->billings->billing_month) ?  $data->billings->billing_month : null;
                        return  $month;
                    })

                    ->addColumn('Amount', function (ChangeRequest $data) {
                        $month = isset($data->billings->total_amount) ?  $data->billings->total_amount : null;
                        return  $month;
                    })

                    ->addColumn('packageName', function (ChangeRequest $data) {
                        return $data->subscribers->packages->name ?? '';
                    })

                    ->addColumn('Name', function (ChangeRequest $data) {
                        return $data->subscribers->name ?? '';
                    })

                    ->addColumn('Client', function (ChangeRequest $data) {
                        return $data->subscribers->subscriber_id ?? '';
                    })

                    ->rawColumns(['status','date', 'packageName','Month','Amount','Client','Name'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function StatusChange(Request $request)
    {
        $id = $request->id;
        $status_check   = ChangeRequest::findOrFail($id);
        $status         = $status_check->status;
        $subscriber     = $status_check->subscriber_id;
        $bill_id        = $status_check->billpay_id;

        if ($status == 1) {
            $status_update = 0;
        } else {
            $status_update = 1;
        }

        $data           = array();
        $data['status'] = $status_update;
        ChangeRequest::where('id', $id)->update($data);
        Billing::where('subscriber_id', $subscriber)->where('id',  $bill_id)->update(['status' => 1]);
        if ($status_update == 1) {
            return "success";
        } else {
            return "failed";
        }
    }

    public function getAccountBalance(Request $request, $id)
    {
        if ($request->ajax()) {
           $initial_Balance =  Account::where('id',$id)->first();
            $debit = Transaction::where('account_id', $id)
                ->where('transaction_type', 1)
                ->sum('transaction_amount');
            $credit =  Transaction::where('account_id', $id)
                ->where('transaction_type', 2)
                ->sum('transaction_amount');
            $balanceDebit = $initial_Balance->initial_balance+$credit;

            $balance = $balanceDebit - $debit;
            return response()->json( $balance);
        }
    }

}
