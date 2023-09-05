<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FrontEnd\FaqSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\FrontEnd\ServiceSetting;
use App\Models\FrontEnd\FaqColorSetting;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('frontEnd.settings.faq.index');
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
            return view('frontEnd.settings.faq.create');
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
            'question.required' => 'Enter question',
            'answer.required' => 'Write your answer',
        );

        $this->validate($request, array(
            'question' => 'required',
            'answer' => 'required',
        ), $messages);

        try {
            $data = new FaqSetting();
            $data->question = $request->question;
            $data->status = $request->status;
            $data->answer = $request->answer;
            $data->save();

            return redirect()->route('admin.faq-setting.index')
                ->with('message', 'Faq created successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function FaqSettingList(Request $request){
        try {
            if ($request->ajax()) {
                $data = FaqSetting::orderBy('id', 'desc')->get();
                return Datatables::of($data)
                    ->addColumn('status', function (FaqSetting $data) {

                        $button = ' <div class="custom-control custom-switch">';
                        $button .= ' <input type="checkbox" class="custom-control-input changeStatus" id="customSwitch' . $data->id . '" getId="' . $data->id . '" name="status"';

                        if ($data->status == 1) {
                            $button .= "checked";
                        }
                        $button .= '><label for="customSwitch' . $data->id . '" class="custom-control-label" for="switch1"></label></div>';
                        return $button;
                    })

                    ->addColumn('answer', function (FaqSetting $data) {
                        $result = isset($data->answer) ? $data->answer : '--' ;
                        return Str::limit( $result, 50) ;
                    })

                    ->addColumn('action', function (FaqSetting $data) {
                        if (Auth::user()->can('bank_edit')) {
                            $edit = '<a href="' . route('admin.faq-setting.edit', $data->id) . ' " class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a>';
                        } else {
                            $edit = "";
                        }
                        if (Auth::user()->can('bank_delete')) {

                            $delete = ' <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.faq-setting.destroy', $data->id) . ' " title="Delete"><i class="fa fa-trash-alt"></i></button> ';
                        } else {
                            $delete = "";
                        }
                        return $edit.$delete;
                    })

                    ->rawColumns(['status', 'action', 'answer'])
                    ->toJson();
            }
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
            $data = FaqSetting::findOrFail($id);
            return view('frontEnd.settings.faq.edit', compact('data'));
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
            'question.required' => 'Enter question',
            'answer.required' => 'Write your answer',
        );

        $this->validate($request, array(
            'question' => 'required',
            'answer' => 'required',
        ), $messages);

        try {
            $data = FaqSetting::findOrfail($id);
            $data->question = $request->question;
            $data->status = $request->status;
            $data->answer = $request->answer;
            $data->save();

            return redirect()->route('admin.faq-setting.index')
                ->with('message', 'Faq updated successfully');
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
            $data = FaqSetting::findOrFail($id);
            $data->delete();
            return back()->with('message', 'Service deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function StatusChange(Request $request)
    {
        $id = $request->id;
        $status_check   = FaqSetting::findOrFail($id);
        $status         = $status_check->status;

        if ($status == 1) {
            $status_update = 0;
        } else {
            $status_update = 1;
        }

        $data           = array();
        $data['status'] = $status_update;
        FaqSetting::where('id', $id)->update($data);
        if ($status_update == 1) {
            return "success";
        } else {
            return "failed";
        }
    }

    public function FaqColorSetting()
    {
       try {
            $data = FaqColorSetting::first();
            return view('frontEnd.settings.faq.color_setting', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function FaqColorStore(Request $request){

        try {
            if (!$request->id) {
            $data = new FaqColorSetting();
            } else {
                $data = FaqColorSetting::findOrFail($request->id);
            }
            $data->heading_color = $request->heading_color;
            $data->answer_color = $request->answer_color;
            $data->question_color = $request->question_color;
            $data->underline_color = $request->underline_color;
            if (!$request->id) {
                $data->save();

            return redirect()->route('admin.faq-color-setting')->with('message', 'Faq color  created successfull');
            } else {
            $data->update();

            return redirect()->route('admin.faq-color-setting')->with('message', 'Faq color updated successfull');
            }

        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}

