<?php

namespace App\Http\Controllers\Admin\Subscriber;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\Admin\Settings\Area;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Admin\Settings\Device;
use App\Models\Admin\Settings\Package;
use App\Models\Admin\Settings\Identity;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Admin\Subscriber\Subscriber;
use App\Models\Admin\Settings\ConnectionType;
use App\Models\Admin\Subscriber\SubscriberCategory;


class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('admin.subscriber.index');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function subscribers(Request $request)
    {
        try {
            $data = Subscriber::with('idcards', 'areas', 'categories', 'connections', 'packages', 'devices')->orderBy('id', 'desc');

            if ($request->ajax()) {
                return Datatables::of($data)
                    ->addColumn('status', function (Subscriber $data) {
                        if (Auth::user()->can('client_status')) {
                            $button = ' <div class="custom-control custom-switch">';
                            $button .= ' <input type="checkbox" class="custom-control-input changeStatus" id="customSwitch' . $data->id . '" getId="' . $data->id . '" name="status"';

                            if ($data->status == 1) {

                                $button .= "checked";
                            }
                            $button .= '><label for="customSwitch' . $data->id . '" class="custom-control-label" for="switch1"></label></div>';
                            return $button;
                        } else {
                            return "--";
                        }
                    })

                    ->addColumn('description', function ($data) {
                        $result = isset($data->description) ? $data->description : '--' ;
                        return Str::limit( $result, 20) ;
                    })

                    ->addColumn('area_name', function (Subscriber $data) {
                        $name = isset($data->areas->name) ? $data->areas->name : null;
                        return $name;
                    })

                    ->addColumn('package_name', function (Subscriber $data) {
                        $name = isset($data->packages->name) ? $data->packages->name : null;
                        return $name;
                    })

                    ->addColumn('action', function (Subscriber $data) {

                        if (Auth::user()->can('access_to_client')) {
                           $details =  '<a href="' . route('admin.client-dashboard.show', $data->id) . ' " class="btn btn-sm btn-info"><i class="fa fa-user" aria-hidden="true" title="Profile"></i></a> ';
                        } else {
                                $details = " ";
                        }

                        if (Auth::user()->can('client_show')) {
                            $show = '<a href="' . route('admin.subscriber.show', $data->id) . ' " class="btn btn-sm btn-primary" title="SHow"><i class="fa fa-eye"></i></a> ';
                        } else {
                            $show  = " ";
                        }
                        if (Auth::user()->can('client_edit')) {
                            $edit = '<a href="' . route('admin.subscriber.edit', $data->id) . ' " class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a> ';
                        } else {
                            $edit = " ";
                        }
                        if (Auth::user()->can('client_delete')) {
                            $delete = ' <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.subscriber.destroy', $data->id) . ' " title="Delete"><i class="fa fa-trash-alt"></i></button>';
                        } else {
                            $delete = " ";
                        }
                        return $details.$show.$edit.$delete;
                    })

                    ->addIndexColumn()
                    ->rawColumns(['status', 'action', 'description', 'area_name', 'package_name'])
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
            $sid = Subscriber::count();
            $areas = Area::orderBy('id', 'desc')->where('status', 1)->get();
            $connections = ConnectionType::orderBy('id', 'desc')->where('status', 1)->get();
            $packages = Package::orderBy('id', 'desc')->where('status', 1)->get();
            $idcards  = Identity::orderBy('id', 'desc')->where('status', 1)->get();
            $devices = Device::orderBy('id', 'desc')->where('status', 1)->get();
            $categories = SubscriberCategory::orderBy('id', 'desc')->where('status', 1)->get();
            return view('admin.subscriber.create', compact('sid', 'areas', 'connections', 'packages', 'idcards', 'devices', 'categories'));
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
        // dd($request->card_type_id);
        $messages = array(
            'name.required' => 'Enter client name',
            'initialize_date.required' => 'Enter initialize date',
            'area_id.required' => 'Select area',
            'address.required' => 'Enter your address',
            'contact_no.required' => 'Enter your contact number',
            'category_id.required' => 'Select subscriber category',
            'connection_id.required' => 'Select connection type',
            'package_id.required' => 'Select package',
            'device_id.required' => 'Select device type',
            'ip_address.required' => 'Enter ip address',
            'email.required' => 'Enter your email address',
            'password.required' => 'Create password',
        );

        $this->validate($request, array(
            'password' => 'required|min:6',
            'subscriber_id' => 'required|string|unique:subscribers,subscriber_id',
            'email' => 'required|string|unique:subscribers,email',
            'contact_no' => 'required|string|unique:subscribers,contact_no',
        ), $messages);

        DB::beginTransaction();

        try {
            $data = new Subscriber();
            $data->subscriber_id = $request->subscriber_id;
            $data->name = $request->name;
            $data->initialize_date = Carbon::parse($request->initialize_date)->format('Y-m-d');
            $data->birth_date = Carbon::parse($request->birth_date)->format('Y-m-d');
            $data->card_type_id = json_encode($request->card_type_id);
            $data->card_no = json_encode($request->card_no);
            $data->area_id = $request->area_id;
            $data->address = $request->address;
            $data->contact_no = $request->contact_no;
            $data->category_id = $request->category_id;
            $data->connection_id  = $request->connection_id;
            $data->package_id = $request->package_id;
            $data->device_id = $request->device_id;
            $data->ip_address = $request->ip_address;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->status = $request->status;
            $data->description = $request->description;
            $data->save();

            $user = new User();
            $user->subscriber_id = $data->id;
            $user->name = $request->name;
            $user->type = 2;
            $user->status = 1;
            $user->email  = $request->email;
            $user->password  = Hash::make($request->password);
            $user->save();
            $user->assignRole($request->role);
            DB::commit();

            DB::table('model_has_roles')->insert([
                    'role_id' => 2,
                    'model_type' => 'App\\Models\\User',
                    'model_id' => $user->id,
                ]);

            return redirect()->route('admin.subscriber.index')
                ->with('message', 'Client created successfully');
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
            $idcards  = Identity::orderBy('id', 'desc')->where('status', 1)->get();
            $roles = Role::orderBy('id', 'desc')->get();
            $data = Subscriber::with('idcards', 'areas', 'categories', 'connections', 'packages', 'devices')->orderBy('id', 'desc')->find($id);
            return view('admin.subscriber.show', compact('data', 'idcards', 'roles'));
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
            $data = Subscriber::findOrFail($id);
            $areas = Area::orderBy('id', 'desc')->where('status', 1)->get();
            $connections = ConnectionType::orderBy('id', 'desc')->where('status', 1)->get();
            $packages = Package::orderBy('id', 'desc')->where('status', 1)->get();
            $idcards  = Identity::orderBy('id', 'desc')->where('status', 1)->get();
            $cards  = Identity::orderBy('id', 'desc')->where('status', 1)->get();
            $devices = Device::orderBy('id', 'desc')->where('status', 1)->get();
            $categories = SubscriberCategory::orderBy('id', 'desc')->where('status', 1)->get();
            return view('admin.subscriber.edit', compact('data', 'areas', 'connections', 'packages', 'idcards', 'devices', 'categories', 'cards'));
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
            'name.required' => 'Enter subscriber name',
            'initialize_date.required' => 'Enter initialize date',
            'area_id.required' => 'Select area',
            'address.required' => 'Enter your address',
            'contact_no.required' => 'Enter your contact number',
            'category_id.required' => 'Select subscriber category',
            'connection_id.required' => 'Select connection type',
            'package_id.required' => 'Select package',
            'device_id.required' => 'Select device type',
            'ip_address.required' => 'Enter ip address',
            'email.required' => 'Enter your email address',
        );

        $this->validate($request, array(
            'name' => 'required',
            'initialize_date' => 'required',
            'area_id' => 'required',
            'address' => 'required',
            'category_id' => 'required',
            'connection_id' => 'required',
            'package_id' => 'required',
            'device_id' => 'required',
            'ip_address' => 'required',
            'contact_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:11|unique:subscribers,contact_no,' . $id . ',id,deleted_at,NULL',

            'email' => 'required|unique:subscribers,email,' . $id . ',id,deleted_at,NULL',
        ), $messages);

        DB::beginTransaction();

        try {
            $subscriber = Subscriber::findOrFail($id);
            $subscriber->subscriber_id = $request->subscriber_id;
            $subscriber->name = $request->name;
            $subscriber->initialize_date = Carbon::parse($request->initialize_date)->format('Y-m-d');
            $subscriber->birth_date = Carbon::parse($request->birth_date)->format('Y-m-d');
            $subscriber->card_type_id = json_encode($request->card_type_id);
            $subscriber->card_no = json_encode($request->card_no);
            $subscriber->area_id = $request->area_id;
            $subscriber->address = $request->address;
            $subscriber->contact_no = $request->contact_no;
            $subscriber->category_id = $request->category_id;
            $subscriber->connection_id  = $request->connection_id;
            $subscriber->package_id = $request->package_id;
            $subscriber->device_id = $request->device_id;
            $subscriber->ip_address = $request->ip_address;
            $subscriber->email = $request->email;
            $subscriber->password = Hash::make($request->password);
            $subscriber->status = $request->status;
            $subscriber->description = $request->description;
            $subscriber->update();

            $user = User::where('subscriber_id', $id)->first();
            $user->subscriber_id = $subscriber->id;
            $user->name = $request->name;
            $user->email  = $request->email;
            $user->password  = Hash::make($request->password);
            $user->update();
            $user->syncRoles($request->role);

            DB::commit();

            return redirect()->route('admin.subscriber.index')
                ->with('message', 'Client updated successfully');
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

    public function packages(Request $request)
    {
        try {
            $package = Package::where('connection_type_id', $request->id)->orderBy('id', 'desc')->where('status', 1)->get();
            $data = [];
            foreach ($package as $key => $value) {
                $item = [];
                $item['key'] = $value->id;
                $item['value'] = $value->name;
                $item['amount'] = $value->amount;
                array_push($data, $item);
            }
            return response()->json($data);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $data =  Subscriber::findOrFail($id);
            if ($data) {
                $user = User::where('subscriber_id', $id)->first();
                DB::table('model_has_roles')->where('role_id', 2)->where('model_id', $user->id)->delete();
                $user->delete();
                $data->delete();
                return redirect()->route('admin.subscriber.index')
                    ->with('message', 'Subscriber deleted successfully');
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function StatusChange(Request $request)
    {
        $id = $request->id;
        $status_check   = Subscriber::findOrFail($id);
        $status         = $status_check->status;

        if ($status == 1) {
            $status_update = 0;
        } else {
            $status_update = 1;
        }

        $data           = array();
        $data['status'] = $status_update;
        Subscriber::where('id', $id)->update($data);
        if ($status_update == 1) {
            return "success";
        } else {
            return "failed";
        }
    }

    public function sampleExcel(){
        return Response::download('public/sample/client_sample_excel.xlsx', 'client_sample_excel.xlsx');
    }

    // import client data from excel
    public function import(Request $request)
    {
        Excel::import(new Subscriber, $request->file('import_file'));
        return back();
    }
}
