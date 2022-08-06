<?php

namespace App\Http\Controllers\Admin\Client;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Settings\Area;
use App\Http\Controllers\Controller;
use App\Models\Admin\Settings\Package;
use App\Models\Admin\Settings\Identity;
use App\Models\Admin\Subscriber\Subscriber;
use App\Models\Admin\Settings\ConnectionType;
use Yajra\DataTables\Facades\DataTables;
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
                    ->addColumn('status', function ($data) {

                        if ($data->status == 1) {

                            return '<button class="btn btn-sm btn-primary">Active</button>';
                        }else{
                            return '<button class="btn btn-sm btn-danger">Inactive</button>';
                        }

                    })

                    ->addColumn('action', function (Subscriber $data) {
                        return '<a href="' . route('admin.client-dashboard.show', $data->id) . ' " class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>';
                    })

                    ->rawColumns(['status', 'action'])
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
        // dd($request->all());
        DB::beginTransaction();

        try {
            $subscriber = Subscriber::findOrFail($id);
            $subscriber->name = $request->name;
            $subscriber->contact_no = $request->contact_no;
            $subscriber->email = $request->email;

            // Store Image
            if (request()->has('image')) {
                @unlink(public_path('img/') . $subscriber->image);
                $file = $request->file('image');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $subscriber->image = $filename;
            }

            // $subscriber->image = $filename;

            $subscriber->update();

            $user = User::where('subscriber_id', $id)->first();
            $user->subscriber_id = $subscriber->id;
            $user->name = $request->name;
            $user->email  = $request->email;
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

    // area change request
    public function AreaUpdate(Request $request)
    {
        // dd($request->all());
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

    // area request list page
    public function AreaRequest()
    {
        try {
            return view('admin.client.area_list');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    // area request lists
    public function AreaRequests(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = ChangeRequest::with('areas', 'subscribers')->WhereNotNull('area_id')->orderBy('id', 'desc')->get();

                return Datatables::of($data)

                    ->addColumn('status', function ($data) {
                        $button = '<button type="submit" class="btn btn-sm btn-danger changeStatus" id="customSwitch' . $data->id . '" getId="' . $data->id . '" name="status">Pending</button>';

                        if ($data->status == 1) {
                            return '<button class="btn btn-sm btn-primary">Approved</button>' ;
                        }else{
                            return $button;
                        }

                    })

                    ->addColumn('current_area', function ($data) {
                        return $data->subscribers->areas->name;
                    })

                    ->rawColumns(['status', 'current_area'])
                    ->toJson(); //--- Returning Json Data To Client Side
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }


    // area status approved
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
            exit();
        } else {
            return "failed";
        }
    }
    // end change function

    // connection change request
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

    // connection request list page
    public function ConnectionRequest()
    {
        try {
            return view('admin.client.connection_list');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    // connection request lists
    public function ConnectionRequests(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = ChangeRequest::with('connections', 'subscribers')->WhereNotNull('connection_id')->orderBy('id', 'desc')->get();

                return Datatables::of($data)
                ->addColumn('status', function ($data) {
                        if ($data->status == 1) {
                            return '<button type="submit" class="btn btn-sm btn-primary" onclick="showStatusChangeAlert(' . $data->id . ')">Approved</button>';
                        } else {
                            return '<button type="submit" class="btn btn-sm btn-danger" onclick="showStatusChangeAlert(' . $data->id . ')">Pending</button>';
                        }
                    })

                    ->addColumn('current_connection', function ($data) {
                        return $data->subscribers->connections->name;
                    })

                    ->rawColumns(['status', 'current_connection'])
                    ->toJson(); //--- Returning Json Data To Client Side
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }


    // package change request
    public function PackageUpdate(Request $request)
    {
        // dd($request->all());
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

    // package request list page
    public function PackageRequest()
    {
        try {
            return view('admin.client.package_list');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    // package request lists
    public function PackageRequests(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = ChangeRequest::with('connections','packages', 'subscribers')->WhereNotNull('connection_id')->orderBy('id', 'desc')->get();

                return Datatables::of($data)

                    ->addColumn('status', function ($data) {
                        if ($data->status == 1) {
                            return '<button type="submit" class="btn btn-sm btn-primary" onclick="showStatusChangeAlert(' . $data->id . ')">Approved</button>';
                        } else {
                            return '<button type="submit" class="btn btn-sm btn-danger" onclick="showStatusChangeAlert(' . $data->id . ')">Pending</button>';
                        }
                    })

                    ->addColumn('current_connection', function ($data) {
                        return $data->subscribers->connections->name;
                    })

                    ->addColumn('current_package', function ($data) {
                        return $data->subscribers->packages->name;
                    })

                    ->rawColumns(['status', 'current_connection','current_package'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

}
