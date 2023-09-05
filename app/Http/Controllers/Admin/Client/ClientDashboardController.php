<?php

namespace App\Http\Controllers\Admin\Client;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Settings\Area;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\Billing\Billing;
use App\Models\Admin\Settings\Package;
use App\Models\Admin\Settings\Identity;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin\Subscriber\Subscriber;
use App\Models\Admin\Settings\ConnectionType;
use App\Models\Admin\Subscriber\ChangeRequest;

class ClientDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('admin.client.client_list');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function subscribers(Request $request)
    {
        try {
            $data = Subscriber::with('areas', 'connections', 'packages')->orderBy('id', 'desc')->get();
            if ($request->ajax()) {
                return Datatables::of($data)

                    ->addColumn('area_name', function (Subscriber $data) {
                        $name = isset($data->areas->name) ? $data->areas->name : null;
                        return $name;
                    })

                    ->addColumn('package_name', function (Subscriber $data) {
                        $name = isset($data->packages->name) ? $data->packages->name : null;
                        return $name;
                    })

                    ->addColumn('status', function ($data) {
                        if (Auth::user()->can('client_status')) {
                        if ($data->status == 1) {
                            return '<button class="btn btn-sm btn-primary" title="Active">Active</button>';
                        }else{
                            return '<button class="btn btn-sm btn-danger" title="Inactive">Inactive</button>';
                        }}
                        else{
                            return "--";
                        }
                    })

                    ->addColumn('action', function (Subscriber $data) {
                        if (Auth::user()->can('access_to_client')) {
                        return '<a href="' . route('admin.client-dashboard.show', $data->id) . ' " class="btn btn-sm btn-info"><i class="fa fa-eye" title="Show"></i></a>';
                    }else{
                            return "--";
                        }
                    })
                    ->rawColumns(['area_name', 'package_name','status', 'action'])
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
        //
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
            $areas = Area::orderBy('id', 'desc')->where('status', 1)->get();
            $connections = ConnectionType::orderBy('id', 'desc')->where('status', 1)->get();
            $packages = Package::orderBy('id', 'desc')->where('status', 1)->get();
            $data = Subscriber::with('idcards', 'areas', 'categories', 'connections', 'packages', 'devices')->orderBy('id', 'desc')->find($id);
            return view('admin.client.index', compact('data', 'areas', 'connections', 'packages'));
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
        //
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
        if($request->password != $request->confirm_password){
            return redirect()->back()->with('error', "Passwords do not match");
        }

        if($request->password){
            $messages = array(
                'password' => 'Password must be be minimum 6 digit',
            );

            $this->validate($request, array(
                'password' => 'min:6',
            ), $messages);
        }

        DB::beginTransaction();

        try {
            $subscriber = Subscriber::findOrFail($id);
            $subscriber->name = $request->name;
            $subscriber->contact_no = $request->contact_no;
            $subscriber->email = $request->email;
            $subscriber->password = Hash::make($request->password);
            // Store Image
            if (request()->has('image')) {
                @unlink(public_path('img/') . $subscriber->image);
                $file = $request->file('image');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $subscriber->image = $filename;
            }
            $subscriber->update();

            $user = User::where('subscriber_id', $id)->first();
            $user->subscriber_id = $subscriber->id;
            $user->name = $request->name;
            $user->email  = $request->email;
            $user->password = Hash::make($request->password);
            $user->update();

            DB::commit();

            return redirect()->back()->with('message', 'Data updated successfully');
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
        //
    }

    public function AreaUpdate(Request $request)
    {
        if($request->area_name == $request->area_id){
            return redirect()->back()->with('error', 'You are already in this area');
        }
        try {
            $data = new ChangeRequest();
            $data->subscriber_id = $request->subscriber_id;
            $data->area_id = $request->area_id;
            $data->save();

            return redirect()->back()
                ->with('message', 'Request successfully submitted');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function AreaRequest()
    {
        try {
            return view('admin.client.area_list');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function AreaRequests(Request $request)
    {
        try {
            if ($request->ajax()) {

                if ((Auth::user()->type) == 2) {
                    $data = ChangeRequest::with('areas', 'subscribers')->WhereNotNull('area_id')->where('subscriber_id',  Auth::user()->subscriber_id)->orderBy('id', 'desc')->get();
                }else{
                    $data = ChangeRequest::with('areas', 'subscribers')->WhereNotNull('area_id')->orderBy('id', 'desc')->get();
                }

                return Datatables::of($data)

                    ->addColumn('subscriber_name', function (ChangeRequest $data) {
                        $name = isset($data->subscribers->name) ? $data->subscribers->name : null;
                        return $name;
                    })

                    ->addColumn('subscriber_ip', function (ChangeRequest $data) {
                        $name = isset($data->subscribers->ip_address) ? $data->subscribers->ip_address : null;
                        return $name;
                    })

                    ->addColumn('area_name', function (ChangeRequest $data) {
                        $name = isset($data->areas->name) ? $data->areas->name : null;
                        return $name;
                    })

                    ->addColumn('status', function (ChangeRequest $data) {

                        if ((Auth::user()->type) == 2) {
                            if ($data->status == 1) {
                                return '<span class="badge badge-primary" title="Approved">Approved</span>';
                            } else {
                                return '<span class="badge badge-danger" title="Pending">Pending</span>';
                            }
                        }

                        $button = '<button type="submit" class="badge badge-danger btn btn-sm btn-danger changeStatus" id="customSwitch' . $data->id . '" getId="' . $data->id . '" name="status">Pending</button>';

                        if ($data->status == 1) {
                            return '<span class="badge badge-primary" title="Approved">Approved</span>' ;
                        }else{
                            return $button;
                        }

                    })

                    ->addColumn('current_area', function ($data) {
                        return $data->subscribers->areas->name;
                    })

                    ->rawColumns(['status', 'current_area', 'subscriber_name', 'subscriber_ip', 'area_name'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function AreaStatusChange(Request $request )
    {
        $id = $request->id;
        $status_check   = ChangeRequest::findOrFail($id);
        $status         = $status_check->status;
        $area           = $status_check->area_id;

        if ($status == 1) {
            $status_update = 0;
        } else {
            $status_update = 1;
        }

        $data           = array();
        $data['status'] = $status_update;

        ChangeRequest::where('id', $id)->update($data);
        Subscriber::where('id', $id)->update(['area_id' => $area]);

        if ($status_update == 1) {
            return "success";
        } else {
            return "failed";
        }
    }

    public function ConnectionUpdate(Request $request)
    {
        try {
            $data = new ChangeRequest();
            $data->subscriber_id = $request->subscriber_id;
            $data->connection_id = $request->connection_id;
            $data->save();

            return redirect()->back()
                ->with('message', 'Request successfully submitted');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function ConnectionRequest()
    {
        try {
            return view('admin.client.connection_list');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function ConnectionRequests(Request $request)
    {
        try {
            if ($request->ajax()) {

                if ((Auth::user()->type) == 2) {
                    $data = ChangeRequest::with('connections', 'subscribers')->WhereNotNull('connection_id')->where('subscriber_id',  Auth::user()->subscriber_id)->orderBy('id', 'desc')->get();
                }else{
                    $data = ChangeRequest::with('connections', 'subscribers')->WhereNotNull('connection_id')->orderBy('id', 'desc')->get();
                }

                return Datatables::of($data)

                    ->addColumn('connection_name', function (ChangeRequest $data) {
                        $name = isset($data->connections->name) ? $data->connections->name : null;
                        return $name;
                    })

                    ->addColumn('subscriber_name', function (ChangeRequest $data) {
                        $name = isset($data->subscribers->name) ? $data->subscribers->name : null;
                        return $name;
                    })

                    ->addColumn('subscriber_ip', function (ChangeRequest $data) {
                        $name = isset($data->subscribers->ip_address) ? $data->subscribers->ip_address : null;
                        return $name;
                    })

                ->addColumn('status', function (ChangeRequest $data) {

                    if ((Auth::user()->type) == 2) {
                        if ($data->status == 1) {
                            return '<span class="badge badge-primary" title="Approved">Approved</span>';
                        } else {
                            return '<span class="badge badge-danger" title="Pending">Pending</span>';
                        }
                    }

                        $button = '<button type="submit" class="badge badge-danger btn btn-sm btn-danger changeStatus" id="customSwitch' . $data->id . '" getId="' . $data->id . '" name="status">Pending</button>';

                        if ($data->status == 1) {
                            return '<span class="badge badge-primary" title="Approved">Approved</span>' ;
                        }else{
                            return $button;
                        }
                    })

                    ->addColumn('current_connection', function ($data) {
                        return $data->subscribers->connections->name;
                    })

                    ->rawColumns(['status', 'current_connection', 'connection_name', 'subscriber_ip', 'subscriber_name'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function PackageUpdate(Request $request)
    {
        if($request->connection_name == $request->connection_id){
            return redirect()->back()->with('error', 'You are already using this connection & package');
        }
         try {
            $data = new ChangeRequest();
            $data->subscriber_id = $request->subscriber_id;
            $data->connection_id = $request->connection_id;
            $data->package_id = $request->package_id;
            $data->save();

            return redirect()->back()
                ->with('message', 'Request successfully submitted');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function PackageRequest()
    {
        try {
            return view('admin.client.package_list');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function PackageRequests(Request $request)
    {
        try {
            if ($request->ajax()) {

                if ((Auth::user()->type) == 2) {
                    $data = ChangeRequest::with('connections','packages', 'subscribers')->WhereNotNull('connection_id')->where('subscriber_id',  Auth::user()->subscriber_id)->orderBy('id', 'desc')->get();
                }else{
                    $data = ChangeRequest::with('connections','packages', 'subscribers')->WhereNotNull('connection_id')->orderBy('id', 'desc')->get();
                }

                $data = ChangeRequest::with('connections','packages', 'subscribers')->WhereNotNull('connection_id')->orderBy('id', 'desc')->get();

                return Datatables::of($data)

                    ->addColumn('connection_name', function (ChangeRequest $data) {
                        $name = isset($data->connections->name) ? $data->connections->name : null;
                        return $name;
                    })

                    ->addColumn('subscriber_name', function (ChangeRequest $data) {
                        $name = isset($data->subscribers->name) ? $data->subscribers->name : null;
                        return $name;
                    })

                    ->addColumn('subscriber_ip', function (ChangeRequest $data) {
                        $name = isset($data->subscribers->ip_address) ? $data->subscribers->ip_address : null;
                        return $name;
                    })

                    ->addColumn('package_name', function (ChangeRequest $data) {
                        $name = isset($data->packages->name) ? $data->packages->name : null;
                        return $name;
                    })

                    ->addColumn('current_connection', function (ChangeRequest $data) {
                        return $data->connections->name;
                    })

                    ->addColumn('current_package', function (ChangeRequest $data) {
                        return $data->packages->name;
                    })

                    ->addColumn('status', function (ChangeRequest $data) {
                        if ((Auth::user()->type) == 2) {
                            if ($data->status == 1) {
                                return '<span class="badge badge-primary" title="Approved">Approved</span>';
                            } else {
                                return '<span class="badge badge-danger" title="Pending">Pending</span>';
                            }
                        }

                        $button = '<button type="submit" class="badge badge-danger btn btn-sm btn-danger changeStatus" id="customSwitch' . $data->id . '" getId="' . $data->id . '" name="status">Pending</button>';

                        if ($data->status == 1) {
                            return '<span class="badge badge-primary" title="Approved">Approved</span>' ;
                        }else{
                            return $button;
                        }
                    })

                    ->rawColumns(['status', 'current_connection','current_package', 'connection_name', 'subscriber_name', 'subscriber_ip', 'package_name'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

     public function PackageStatusChange(Request $request )
     {
         $id = $request->id;
         $status_check   = ChangeRequest::findOrFail($id);
         $status         = $status_check->status;
         $package        = $status_check->package_id;
         $connection     = $status_check->connection_id;

         if ($status == 1) {
             $status_update = 0;
         } else {
             $status_update = 1;
         }

         $data           = array();
         $data['status'] = $status_update;

         ChangeRequest::where('id', $id)->update($data);
         Subscriber::where('id', $id)->update([
            'connection_id' => $connection,
            'package_id' => $package,
        ]);

         if ($status_update == 1) {
             return "success";
         } else {
             return "failed";
         }
     }

    public function BillingHistory($id)
    {
        try {
            $data = Billing::with('subscribers', 'packages')->findOrFail($id);
            $details = Billing::where('subscriber_id', $data->subscriber_id)->get();
            return view('admin.client.billing_history', compact('data', 'details'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function billingclient()
    {
        try {
            $data = Subscriber::with('idcards', 'areas', 'categories', 'connections', 'packages', 'devices')->orderBy('id', 'desc')->get();
            return view('admin.client.billing_client', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function billingclients(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = Billing::with('subscribers', 'packages')->where('subscriber_id',$request->subscriber_id)->orderBy('id', 'desc');

                return Datatables::of($data)
                    ->addColumn('status', function ($data) {
                        if ($data->status == 1) {
                            return 'Paid';
                        } else {
                            return 'Un-Paid';
                        }
                    })

                    ->addColumn('current_connection', function ($data) {
                        return $data->subscribers->connections->name;
                    })

                    ->addColumn('current_package', function ($data) {
                        return $data->packages->name;
                    })

                    ->rawColumns(['status', 'current_connection', 'current_package'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
