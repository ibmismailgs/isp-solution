<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\substr;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\FrontEnd\AboutSetting;
use App\Models\FrontEnd\MessageStore;
use App\Models\FrontEnd\BannerSetting;
use App\Models\FrontEnd\ServiceSetting;
use Yajra\DataTables\Facades\DataTables;
use App\Models\FrontEnd\SocialMediaSetting;
use App\Models\FrontEnd\PackageColorSetting;

class FrontEndController extends Controller
{
    public function index(){
        try {
            return view('frontEnd.include.main');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function BannerSetting(){
        try {
            $data = BannerSetting::first();
            return view('frontEnd.settings.banner.banner_setting', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function BannerSettingStore(Request $request){
        try {
            if (!$request->id) {
                $request->validate([
                    'title' => 'required',
                    'sub_title' => 'required',
                    'banner_image' => 'required',
                ]);
                $data = new BannerSetting();
            } else {
                $data = BannerSetting::findOrFail($request->id);
            }
            if ($request->file('banner_image')) {
                $file = $request->file('banner_image');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->banner_image = $filename;
            }

            $data->color = $request->color;
            $data->title_color = $request->title_color;
            $data->text_color = $request->text_color;
            $data->title = $request->title;
            $data->sub_title = $request->sub_title;
            if (!$request->id) {
                $data->save();
                return redirect()->route('admin.banner-setting')->with('message', 'Banner setting created successfull');
            } else {
                $data->update();
                return redirect()->route('admin.banner-setting')->with('message', 'Banner setting updated successfull');
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function SocialLink(){
        try {
            $data = SocialMediaSetting::first();
            return view('frontEnd.settings.social.social_link', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function SocialLinkStore(Request $request){
        try {
            if (!$request->id) {
                $request->validate([
                    'facebook' => 'required',
                    'youtube' => 'required',
                    'instagram' => 'required',
                    'twitter' => 'required',
                    'linkedin' => 'required',
                    'description' => 'required',
                ]);

                $data = new SocialMediaSetting();
            } else {
                $data = SocialMediaSetting::findOrFail($request->id);
            }

            $data->facebook = $request->facebook;
            $data->youtube = $request->youtube;
            $data->linkedin = $request->linkedin;
            $data->instagram = $request->instagram;
            $data->twitter = $request->twitter;
            $data->description = $request->description;
            if (!$request->id) {
                $data->save();
                return redirect()->route('admin.social-link')->with('message', 'Social link  created successfull');
            } else {
                $data->update();
                return redirect()->route('admin.social-link')->with('message', 'Social link updated successfull');
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    public function AboutSetting(){
        try {
            $data = AboutSetting::first();
            return view('frontEnd.settings.about.about_setting', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function AboutSettingStore(Request $request){
        try {
            if (!$request->id) {
                $request->validate([
                    'description' => 'required',
                    'image' => 'required',
                ]);

                $data = new AboutSetting();
            } else {
                $data = AboutSetting::findOrFail($request->id);
            }
            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = time() . $file->getClientOriginalName();
                $file->move(public_path('/img/'), $filename);
                $data->image = $filename;
            }

            $data->description = $request->description;
            $data->heading_color = $request->heading_color;
            $data->underline_color = $request->underline_color;
            $data->text_color = $request->text_color;

            if (!$request->id) {
                $data->save();
                return redirect()->route('admin.about-setting')->with('message', 'Aboout setting created successfull');
            } else {
                $data->update();
                return redirect()->route('admin.about-setting')->with('message', 'About setting updated successfull');
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function MessageStore(Request $request)
    {
        $messages = array(
            'name.required' => 'Enter your name',
            'subject.required' => 'Write a subject',
            'email.required' => 'Enter your email address',
            'message.required' => 'Write message',
        );

        $this->validate($request, array(
            'name' => 'required',
            'subject' => 'required',
            'email' => 'required',
            'message' => 'required',
        ), $messages);

        try {
            $data = new MessageStore();
            $data->name = $request->name;
            $data->subject = $request->subject;
            $data->email = $request->email;
            $data->message = $request->message;
            $data->save();

            return response()->json([
                'status' => 200,
                'success' => 'Your message has been sent. Thank you!',
            ]);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function MessageList()
    {
        try {
            return view('frontEnd.settings.message.index');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function AllMessage(Request $request){
        try {
            if ($request->ajax()) {
                $data = MessageStore::orderBy('id', 'desc')->get();
                return Datatables::of($data)

                    ->addColumn('description', function (MessageStore $data) {
                        $result = isset($data->description) ? $data->description : '--' ;
                        return Str::words( $result, 200) ;
                    })

                    ->addColumn('action', function (MessageStore $data) {

                        if (Auth::user()->can('bank_delete')) {
                            $delete = ' <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.message-delete', $data->id) . ' " title="Delete"><i class="fa fa-trash-alt"></i></button> ';
                        } else {
                            $delete = "";
                        }
                        return $delete;
                    })

            ->addIndexColumn()
            ->rawColumns(['description','action'])
            ->toJson();
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function MessageDelete($id)
    {
        try {
            $data = MessageStore::findOrFail($id);
            $data->delete();
            return back()->with('message', 'Message deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    public function PackageColorSetting()
    {
       try {
            $data = PackageColorSetting::first();
            return view('frontEnd.settings.service.package', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function PackageColorStore(Request $request){
        try {
            if (!$request->id) {
                $data = new PackageColorSetting();
                } else {
                    $data = PackageColorSetting::findOrFail($request->id);
                }
                $data->heading_color = $request->heading_color;
                $data->underline_color = $request->underline_color;
                $data->package_color = $request->package_color;
                $data->price_color = $request->price_color;
                $data->month_color = $request->month_color;
                $data->text_color = $request->text_color;

                if (!$request->id) {
                    $data->save();
                    return redirect()->route('admin.package-color-setting')->with('message', 'Package color  created successfull');
                } else {
                $data->update();

                return redirect()->route('admin.package-color-setting')->with('message', 'Package color updated successfull');
                }

          } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
