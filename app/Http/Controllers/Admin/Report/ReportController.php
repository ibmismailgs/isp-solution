<?php

namespace App\Http\Controllers\Admin\Report;

use Illuminate\Http\Request;
use App\Models\Admin\Settings\Area;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Settings\Device;
use App\Models\Admin\Settings\Package;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Contracts\Redis\Connector;
use App\Models\Admin\Subscriber\Subscriber;
use App\Models\Admin\Settings\ConnectionType;
use App\Models\Admin\Subscriber\SubscriberCategory;

class ReportController extends Controller
{
    public function subscriber(){
        try {
            return view('admin.report.subscribers');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function subscribers(Request $request){
        try {
            if ($request->ajax()) {

                $data = Subscriber::with('connections', 'packages')->where('status', $request->subscriber_id)->orderBy('id', 'desc')->get();

                return Datatables::of($data)

                    ->addColumn('package_amount', function (Subscriber $data) {
                        $name = isset($data->packages->amount) ? $data->packages->amount : null;
                        return $name;
                    })

                    ->addColumn('package_name', function (Subscriber $data) {
                        $name = isset($data->packages->name) ? $data->packages->name : null;
                        return $name;
                    })

                    ->addColumn('action', function (Subscriber $data) {
                        return '<a href="' . route('admin.subscriber.show', $data->id) . ' " class="btn btn-sm btn-primary" title="Show"><i class="fa fa-eye"></i></a>';
                    })

                    ->addIndexColumn()
                    ->rawColumns(['action', 'package_name', 'package_amount'])
                    ->toJson();
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function package()
    {
        try {
            $data = Package::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.report.package', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function packages(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = Subscriber::with('connections', 'packages')->where('package_id', $request->package_id)->orderBy('id', 'desc')->get();

                return Datatables::of($data)

                    ->addColumn('package_amount', function (Subscriber $data) {
                        $name = isset($data->packages->amount) ? $data->packages->amount : null;
                        return $name;
                    })

                    ->addColumn('action', function (Subscriber $data) {
                        return '<a href="' . route('admin.subscriber.show', $data->id) . ' " class="btn btn-sm btn-primary" title="Show"><i class="fa fa-eye"></i></a>';
                    })

                    ->addIndexColumn()
                    ->rawColumns(['action','package_amount'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function connection()
    {
        try {
            $data = ConnectionType::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.report.connection', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function connections(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = Subscriber::with('connections', 'packages')->where('connection_id', $request->connection_id)->orderBy('id', 'desc')->get();

                return Datatables::of($data)
                    ->addColumn('package_amount', function (Subscriber $data) {
                        $name = isset($data->packages->amount) ? $data->packages->amount : null;
                        return $name;
                    })

                    ->addColumn('action', function (Subscriber $data) {
                        return '<a href="' . route('admin.subscriber.show', $data->id) . ' " class="btn btn-sm btn-primary"
                        title="Show"><i class="fa fa-eye"></i></a>';
                    })

                    ->addIndexColumn()
                    ->rawColumns(['action', 'package_amount'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function area()
    {
        try {
            $data = Area::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.report.area', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function areas(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = Subscriber::with('connections', 'packages')->where('area_id', $request->area_id)->orderBy('id', 'desc')->get();

                return Datatables::of($data)
                    ->addColumn('package_amount', function (Subscriber $data) {
                        $name = isset($data->packages->amount) ? $data->packages->amount : null;
                        return $name;
                    })

                    ->addColumn('action', function (Subscriber $data) {
                        return '<a href="' . route('admin.subscriber.show', $data->id) . ' " class="btn btn-sm btn-primary"
                        title="Show"><i class="fa fa-eye"></i></a>';
                    })

                    ->addIndexColumn()
                    ->rawColumns(['package_amount','action'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function device()
    {
        try {
            $data = Device::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.report.device', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function devices(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = Subscriber::with('devices','packages')->where('device_id', $request->device_id)->get();

                return Datatables::of($data)
                    ->addColumn('package_amount', function (Subscriber $data) {
                        $name = isset($data->packages->amount) ? $data->packages->amount : null;
                        return $name;
                    })

                    ->addColumn('action', function (Subscriber $data) {
                        return '<a href="' . route('admin.subscriber.show', $data->id) . ' " class="btn btn-sm btn-primary"
                        title="Show"><i class="fa fa-eye"></i></a>';
                    })

                    ->addIndexColumn()
                    ->rawColumns(['package_amount','action'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function category()
    {
        try {
            $data = SubscriberCategory::where('status', 1)->orderBy('id', 'desc')->get();
            return view('admin.report.client_category', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function categories(Request $request)
    {
        try {
            if ($request->ajax()) {

                $data = Subscriber::with('categories','connections', 'packages')->where('category_id', $request->category_id)->orderBy('id', 'desc')->get();

                return Datatables::of($data)
                    ->addColumn('package_amount', function (Subscriber $data) {
                        $name = isset($data->packages->amount) ? $data->packages->amount : null;
                        return $name;
                    })

                    ->addColumn('action', function (Subscriber $data) {
                        if (Auth::user()->can('access_to_report')) {
                        return '<a href="' . route('admin.subscriber.show', $data->id) . ' " class="btn btn-sm btn-primary"
                        title="Show"><i class="fa fa-eye"></i></a>';}
                        else{
                            return "--";
                        }
                    })

                    ->addIndexColumn()
                    ->rawColumns(['package_amount','action'])
                    ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
