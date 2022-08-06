<?php

namespace App\Http\Controllers\Admin\Expense;

use App\Http\Controllers\Controller;
use App\Models\Admin\Expense\ExpenseCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('admin.expense.expense_category.index');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    //*** JSON Request
    public function ExpenseCategory(Request $request)
    {
        try{
            if ($request->ajax()) {
            $data = ExpenseCategory::orderBy('id', 'desc')->get();
            return Datatables::of($data)
            ->addColumn('status', function ($data) {
                $button = ' <div class="custom-control custom-switch">';
                $button .= ' <input type="checkbox" class="custom-control-input changeStatus" id="customSwitch' . $data->id . '" StatusId="' . $data->id . '" name="status"';

                if ($data->status == 1) {

                    $button .= "checked";
                }
                $button .= '><label for="customSwitch' . $data->id . '" class="custom-control-label" for="switch1"></label></div>';
                return $button;
            })

            ->addColumn('description', function ($data) {
                return Str::limit($data->description, 20);
            })

            ->addColumn('action', function (ExpenseCategory $data) {
                return '<a href="' . route('admin.expense-category.edit', $data->id) . ' " class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>

                 <button id="messageShow" class="btn btn-sm btn-danger btn-delete" data-remote=" ' . route('admin.expense-category.destroy', $data->id) . ' " title="Delete"><i class="fas fa-trash-alt"></i></button>';
            })

            ->rawColumns(['status', 'action', 'description'])
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
        try{
            return view('admin.expense.expense_category.create');
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
        // dd($request->all());
        $messages = array(
            'name.required' => 'Please enter name',
        );

        $this->validate($request, array(
            'name' => 'required|string|unique:expense_categories,name,NULL,id,deleted_at,NULL',
        ), $messages);

        try {
            $data = new ExpenseCategory();

            $data->name = $request->name;
            $data->status = $request->status;
            $data->description = $request->description;
            $data->save();

            return redirect()->route('admin.expense-category.index')
            ->with('message', 'Expense category created successfully');
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
            $data = ExpenseCategory::findOrFail($id);
        return view('admin.expense.expense_category.edit', compact('data'));
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

    // start update function
    public function update(Request $request, $id)
    {
        $messages = array(
            'name.required' => 'Please enter name',
        );

        $this->validate($request, array(
            'name' => 'required|unique:expense_categories,name,' . $id . ',id,deleted_at,NULL',
        ), $messages);

        try {
            $data = ExpenseCategory::findOrFail($id);
            $data->name = $request->name;
            $data->status = $request->status;
            $data->description = $request->description;
            $data->update();

            return redirect()->route('admin.expense-category.index')
            ->with('message', 'Expense category updated successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    // end update function

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // start delete function
    public function destroy($id)
    {
        try {
            $data = ExpenseCategory::findOrFail($id);
            $data->delete();
            return back()->with('message', 'Data deleted successfully');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    // end delete function

    // change status function start here
    public function StatusChange(Request $request)
    {
        $id = $request->id;

        $status_check   = ExpenseCategory::findOrFail($id);
        $status         = $status_check->status;

        if ($status == 1) {
            $status_update = 0;
        } else {
            $status_update = 1;
        }

        $data           = array();
        $data['status'] = $status_update;
        ExpenseCategory::where('id', $id)->update($data);
        if ($status_update == 1) {
            return "success";
            exit();
        } else {
            return "failed";
        }
    }
    // end change function
}
