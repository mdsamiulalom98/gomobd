<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Region;

class RegionController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:region-list|region-create|region-edit|region-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:region-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:region-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:region-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $show_data = Region::orderBy('id', 'DESC')->get();
        return view('backEnd.region.index', compact('show_data'));
    }
    public function create()
    {
        return view('backEnd.region.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);

        $input = $request->all();

        Region::create($input);

        Toastr::success('Success', 'Data insert successfully');
        return redirect()->route('regions.index');
    }

    public function edit($id)
    {
        $edit_data = Region::find($id);
        return view('backEnd.region.edit', compact('edit_data'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
        ]);
        // image one
        $update_data = Region::find($request->id);
        $input = $request->all();
        $update_data->update($input);

        Toastr::success('Data update successfully', 'Success', ['positionClass' => 'toast-top-right']);;
        return redirect()->route('regions.index');
    }

    public function inactive(Request $request)
    {
        $inactive = Region::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Region::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success', 'Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Region::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');
        return redirect()->back();
    }
}
