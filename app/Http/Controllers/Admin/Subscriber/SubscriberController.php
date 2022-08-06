<?php

namespace App\Http\Controllers\Admin\Subscriber;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Settings\Area;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin\Settings\Device;
use App\Models\Admin\Settings\Package;
use App\Models\Admin\Settings\Identity;
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
            $data = Subscriber::with('idcards', 'areas', 'categories', 'connections', 'packages', 'devices')->orderBy('id', 'desc')->get();
            if ($request->ajax()) {
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

                    ->addColumn('action', function (Subscriber $data) {
                        return '<a href="' . route('admin.subscriber.show', $data->id) . ' " class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>

                        <a href="' . route('admin.subscriber.edit', $data->id) . ' " class="btn btn-sm btn-info"><i class="fa fa-edit"></i></a>

                    <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.subscriber.destroy', $data->id) . ' " title="Delete"><i class="fa fa-trash-alt"></i></button>';
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
        try{
            $sid = Subscriber::count();
            $areas = Area::orderBy('id', 'desc')->where('status', 1)->get();
            $connections = ConnectionType::orderBy('id', 'desc')->where('status', 1)->get();
            $packages = Package::orderBy('id', 'desc')->where('status', 1)->get();
            $idcards  = Identity::orderBy('id', 'desc')->where('status', 1)->get();
            $devices = Device::orderBy('id', 'desc')->where('status', 1)->get();
            $categories = SubscriberCategory::orderBy('id', 'desc')->where('status', 1)->get();
            return view('admin.subscriber.create', compact('sid','areas', 'connections', 'packages', 'idcards', 'devices' , 'categories'));
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
    //    dd($request->all());
        $messages = array(
            'name.required' => 'Enter client name',
            'initialize_date.required' => 'Enter initialize date',
            // 'birth_date.required' => 'Enter birth date',
            // 'card_type_id.required' => 'Select ID Card type',
            // 'card_no.required' => 'Enter card no',
            'area_id.required' => 'Select area',
            'address.required' => 'Enter your address',
            'contact_no.required' => 'Enter your contact number',
            'category_id.required' => 'Select subscriber category',
            'connection_id.required' => 'Select connection type',
            'package_id.required' => 'Select package',
            'device_id.required' => 'Select device type',
            // 'mac_address.required' => 'Enter mac address',
            'ip_address.required' => 'Enter ip address',
            'email.required' => 'Enter your email address',
            'password.required' => 'Create password',
        );

        $this->validate($request, array(
            'password' => 'required|min:6',
            'subscriber_id' => 'required|string|unique:subscribers,subscriber_id',
        ), $messages);

        DB::beginTransaction();

        try {
            $data = new Subscriber();

            $data->subscriber_id = $request->subscriber_id;
            $data->name = $request->name;
            $data->initialize_date = $request->initialize_date;
            $data->birth_date = $request->birth_date;
            $data->card_type_id = json_encode($request->card_type_id);
            $data->card_no = json_encode($request->card_no);
            $data->area_id = $request->area_id;
            $data->address = $request->address;
            $data->contact_no = $request->contact_no;
            $data->category_id = $request->category_id;
            $data->connection_id  = $request->connection_id;
            $data->package_id = $request->package_id;
            $data->device_id = $request->device_id;
            // $data->mac_address = $request->mac_address;
            $data->ip_address = $request->ip_address;
            $data->email = $request->email;
            $data->password = Hash::make($request->password);
            $data->status = $request->status;
            $data->description = $request->description;
            // dd($data);
            $data->save();

            $user = new User();
            $user->subscriber_id = $data->id;
            $user->name = $request->name;
            $user->type = 2;
            $user->status = 0;
            $user->email  = $request->email;
            $user->password  = Hash::make($request->password);
            $user->save();

            DB::commit();

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
            $data = Subscriber::with('idcards', 'areas', 'categories', 'connections', 'packages', 'devices')->orderBy('id', 'desc')->find($id);
            return view('admin.subscriber.show', compact('data','idcards'));
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
        try{
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
            // 'birth_date.required' => 'Enter birth date',
            // 'card_type_id.required' => 'Select ID Card type',
            // 'card_no.required' => 'Enter card No',
            'area_id.required' => 'Select area',
            'address.required' => 'Enter your address',
            'contact_no.required' => 'Enter your contact number',
            'category_id.required' => 'Select subscriber category',
            'connection_id.required' => 'Select connection type',
            'package_id.required' => 'Select package',
            'device_id.required' => 'Select device type',
            // 'mac_address.required' => 'Enter mac address',
            'ip_address.required' => 'Enter ip address',
            'email.required' => 'Enter your email address',
        );

        $this->validate($request, array(
            'name' => 'required',
            'initialize_date' => 'required',
            // 'birth_date' => 'required',
            // 'card_type_id' => 'required',
            // 'card_no' => 'required',
            'area_id' => 'required',
            'address' => 'required',
            'contact_no' => 'required',
            'category_id' => 'required',
            'connection_id' => 'required',
            'package_id' => 'required',
            'device_id' => 'required',
            // 'mac_address' => 'required',
            'ip_address' => 'required',
            'email' => 'required',
        ), $messages);

        DB::beginTransaction();

        try {
            $subscriber = Subscriber::findOrFail($id);
            // dd($subscriber);
            $subscriber->subscriber_id = $request->subscriber_id;
            $subscriber->name = $request->name;
            $subscriber->initialize_date = $request->initialize_date;
            $subscriber->birth_date = $request->birth_date;
            $subscriber->card_type_id = json_encode($request->card_type_id);
            $subscriber->card_no = json_encode($request->card_no);
            $subscriber->area_id = $request->area_id;
            $subscriber->address = $request->address;
            $subscriber->contact_no = $request->contact_no;
            $subscriber->category_id = $request->category_id;
            $subscriber->connection_id  = $request->connection_id;
            $subscriber->package_id = $request->package_id;
            $subscriber->device_id = $request->device_id;
            // $subscriber->mac_address = $request->mac_address;
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
        try{
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

    // start delete function
    public function destroy($id)
    {
        try {
            $data =  Subscriber::findOrFail($id);
            if ($data) {
                $user = User::where('subscriber_id', $id)->first();
                $user->delete();
                $data->delete();
                return redirect()->route('admin.subscriber.index')
                ->with('message', 'Subscriber deleted successfully');
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    // end delete function

    //starts status change function
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
            exit();
        } else {
            return "failed";
        }
    }
    //end status change function
}

