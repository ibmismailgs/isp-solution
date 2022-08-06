<?php

namespace App\Http\Controllers\Admin\Report;

use Illuminate\Http\Request;
use App\Models\Admin\Settings\Area;
use App\Http\Controllers\Controller;
use App\Models\Admin\Settings\Device;
use App\Models\Admin\Settings\Package;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Contracts\Redis\Connector;
use App\Models\Admin\Subscriber\Subscriber;
use App\Models\Admin\Settings\ConnectionType;
use App\Models\Admin\Subscriber\SubscriberCategory;

class ReportController extends Controller
{
    //client index page
    public function subscriber(){
        try {
            return view('admin.report.subscribers');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //client list
    public function subscribers(Request $request){
        try {
            if ($request->ajax()) {

                $data = Subscriber::with('connections', 'packages')->where('status', $request->subscriber_id)->orderBy('id', 'desc')->get();

                return Datatables::of($data)
                    ->addColumn('action', function (Subscriber $data) {
                        return '<a href="' . route('admin.subscriber.show', $data->id) . ' " class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>';
                    })

                    ->rawColumns(['action'])
                    ->toJson();
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //packages index pade
    public function package()
    {
        try {
            $data = Package::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.report.package', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //client list by packages
    public function packages(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = Subscriber::with('connections', 'packages')->where('package_id', $request->package_id)->orderBy('id', 'desc')->get();

                return Datatables::of($data)
                    ->addColumn('action', function (Subscriber $data) {
                        return '<a href="' . route('admin.subscriber.show', $data->id) . ' " class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>';
                    })

                    ->rawColumns(['action'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //connection index pade
    public function connection()
    {
        try {
            $data = ConnectionType::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.report.connection', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //client list by connection
    public function connections(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = Subscriber::with('connections', 'packages')->where('connection_id', $request->connection_id)->orderBy('id', 'desc')->get();

                return Datatables::of($data)
                    ->addColumn('action', function (Subscriber $data) {
                        return '<a href="' . route('admin.subscriber.show', $data->id) . ' " class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>';
                    })

                    ->rawColumns(['action'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //area index pade
    public function area()
    {
        try {
            $data = Area::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.report.area', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //client list by area
    public function areas(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = Subscriber::with('connections', 'packages')->where('area_id', $request->area_id)->orderBy('id', 'desc')->get();

                return Datatables::of($data)
                    ->addColumn('action', function (Subscriber $data) {
                        return '<a href="' . route('admin.subscriber.show', $data->id) . ' " class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>';
                    })

                    ->rawColumns(['action'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //area index pade
    public function device()
    {
        try {
            $data = Device::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.report.device', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //client list by area
    public function devices(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = Subscriber::with('devices','packages')->where('device_id', $request->device_id)->orderBy('id', 'desc')->get();

                return Datatables::of($data)
                    ->addColumn('action', function (Subscriber $data) {
                        return '<a href="' . route('admin.subscriber.show', $data->id) . ' " class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>';
                    })

                    ->rawColumns(['action'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //category index pade
    public function category()
    {
        try {
            $data = SubscriberCategory::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.report.client_category', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //client list by client categories
    public function categories(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = Subscriber::with('categories','connections', 'packages')->where('category_id', $request->category_id)->orderBy('id', 'desc')->get();

                return Datatables::of($data)
                    ->addColumn('action', function (Subscriber $data) {
                        return '<a href="' . route('admin.subscriber.show', $data->id) . ' " class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>';
                    })

                    ->rawColumns(['action'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
