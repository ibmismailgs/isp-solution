<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\Admin\Settings\Area;
use App\Http\Controllers\Controller;
use App\Models\Admin\Settings\Staff;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Account\Account;
use App\Models\Admin\Billing\Billing;
use App\Models\Admin\Expense\Expense;
use App\Models\Admin\Account\Transaction;
use App\Models\Admin\Complaint\Complaint;
use App\Models\Admin\Subscriber\Subscriber;
use App\Models\Admin\Settings\GeneralSetting;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            if ((Auth::user()->type) == 2) {
            return redirect()->route('admin.clients-dashboard');
            }

            else if ((Auth::user()->type) == 3) {
                return redirect()->route('admin.staff-dashboard');
            }

            else{
            $start_date = date("Y") . '-' . date("m") . '-' . '01';
            $end_date = date("Y") . '-' . date("m") . '-' . date('t', mktime(0, 0, 0, date("m"), 1, date("Y")));

            $complain = Complaint::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->count();

            $total_client = Subscriber::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->count();

            $total_active_client = Subscriber::where('status', 1)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->count();

            $total_staff = Staff::where('status', 1)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->count();

            $debit = Transaction::where('transaction_type', 1)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('transaction_amount');

            $credit =  Transaction::where('transaction_type', 2)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('transaction_amount');

            $account = Account::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('initial_balance');

            $total_amount =  ($account + $credit) - $debit;

            $paid_bill = Billing::where('status', 1)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('total_amount');

            $unpaid_bill = Billing::where('status', 0)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('total_amount');

            $total_expense = Expense::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('total_amount');

            return view('admin.dashboard', compact('complain', 'total_client', 'total_active_client', 'total_staff', 'total_amount','total_expense','paid_bill', 'unpaid_bill'));
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function dashboardFilter($start_date, $end_date)
    {
        try{
            $complain = Complaint::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->count();

            $total_client = Subscriber::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->count();

            $total_active_client = Subscriber::where('status', 1)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->count();

            // total balance
            $debit = Transaction::where('transaction_type', 1)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('transaction_amount');

            $credit =  Transaction::where('transaction_type', 2)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('transaction_amount');

            $account = Account::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('initial_balance');

            $total_amount =  ($account + $credit) - $debit;

            $paid_bill = Billing::where('status', 1)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('total_amount');

            $unpaid_bill = Billing::where('status', 0)->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('total_amount');

            $total_expense = Expense::whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date)->sum('total_amount');

            $data[0] = $complain;
            $data[1] = $total_client;
            $data[2] = $total_active_client;
            $data[3] = $total_amount;
            $data[4] = $paid_bill;
            $data[5] = $unpaid_bill;
            $data[6] = $total_expense;

            return $data;
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    public function ClientDashboard(){

        try{
            $data = Subscriber::where('id',  Auth::user()->subscriber_id)->first();
            $area = $data->areas->name;
            $connection = $data->connections->name;
            $package = $data->packages->name;
            $package_spreed = $data->packages->package_spreed;

            $complain = Complaint::where('ticket_option', 1)->where('subscriber_id',  Auth::user()->subscriber_id)->count();

            $paid_bill = Billing::where('status', 1)->where('subscriber_id',  Auth::user()->subscriber_id)->sum('total_amount');

            $unpaid_bill = Billing::where('status', 0)->where('subscriber_id',  Auth::user()->subscriber_id)->sum('total_amount');

            return view('admin.client_dashboard', compact('complain','area','connection','package','paid_bill','unpaid_bill','package_spreed'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    public function StaffDashboard(){
        try{
            $data = Staff::where('id',  Auth::user()->staff_id)->first();
            $salary = $data->salary;
            $designation = $data->designation;

            $complain = Complaint::where('ticket_option', 1)->where('subscriber_id',  Auth::user()->staff_id)->count();

            return view('admin.staff_dashboard', compact('complain','salary','designation'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function GeneralSettings(){
        try {
            $data = GeneralSetting::first();
            return view('admin.settings.general_setting.general_setting', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function GeneralSettingStore(Request $request)
    {
        try {
            if (!$request->id) {
                $request->validate([
                    'name' => 'required',
                    'website' => 'required',
                    'email' => 'required',
                    'phone' => 'required',
                    'address' => 'required',
                    'favicon' => 'required',
                    'logo' => 'required',
                ]);

                $data = new GeneralSetting();
            } else {
                $data = GeneralSetting::findOrFail($request->id);
            }
            if ($request->file('logo')) {
                $file = $request->file('logo');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->logo = $filename;
            }
            if ($request->file('favicon')) {
                $file = $request->file('favicon');
                $filenamefavicon = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'),  $filenamefavicon);
                $data->favicon =  $filenamefavicon;
            }
            $data->name = $request->name;
            $data->website = $request->website;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->map = $request->map;
            $data->description = $request->description;

            if (!$request->id) {
                $data->save();
                return redirect()->route('admin.general-settings')->with('message', ' General settings created successfull');
            } else {
                $data->update();
                return redirect()->route('admin.general-settings')->with('message', 'General settings updated successfull');
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
