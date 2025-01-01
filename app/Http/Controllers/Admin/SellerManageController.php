<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\OrderDetails;
use App\Models\District;
use App\Models\Product;
use App\Models\Seller;
use App\Models\WithdrawDetails;
use App\Models\Withdraw;
use Toastr;
use Image;
use File;
use Hash;
use Auth;

class SellerManageController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:seller-list', ['only' => ['index']]);
        // $this->middleware('permission:seller-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:seller-profile', ['only' => ['profile']]);
        // $this->middleware('permission:seller-products', ['only' => ['products']]);
        // $this->middleware('permission:seller-pending-products', ['only' => ['pending_product']]);
        // $this->middleware('permission:seller-product-approval', ['only' => ['product_approve']]);
        // $this->middleware('permission:seller-withdraw', ['only' => ['withdraw']]);
        // $this->middleware('permission:seller-login', ['only' => ['adminlog']]);
    }
    public function index(Request $request)
    {
        $show_data = Seller::where(['status' => $request->status])->get();
        return view('backEnd.seller.index', compact('show_data'));
    }

    public function edit($id)
    {
        $edit_data = Seller::find($id);
        $districts = District::distinct()
            ->select('district')
            ->get();
        $areas = District::where(['district' => $edit_data->district])
            ->select('area_name', 'id')
            ->get();
        return view('backEnd.seller.edit', compact('edit_data', 'districts', 'areas'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        // new password
        $input = $request->except('hidden_id');
        $update_data = Seller::find($request->hidden_id);
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, ['password']);
        }
        // new image
        $image = $request->file('image');
        if ($image) {
            // image with intervention
            $name = time() . '-' . $image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name);
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadpath = 'public/uploads/customer/';
            $imageUrl = $uploadpath . $name;
            $img = Image::make($image->getRealPath());
            $img->encode('webp', 90);
            $width = 100;
            $height = 100;
            $img->height() > $img->width() ? ($width = null) : ($height = null);
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($imageUrl);
            $input['image'] = $imageUrl;
            File::delete($update_data->image);
        } else {
            $input['image'] = $update_data->image;
        }
        $input['status'] = $request->status ? $request->status : 'inactive';
        $update_data->update($input);

        Toastr::success('Success', 'Data update successfully');
        return redirect()->back();
    }

    public function inactive(Request $request)
    {
        $inactive = Seller::find($request->hidden_id);
        $inactive->status = 'inactive';
        $inactive->save();
        Toastr::success('Success', 'Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Seller::find($request->hidden_id);
        $active->status = 'active';
        $active->save();
        Toastr::success('Success', 'Data active successfully');
        return redirect()->back();
    }
    

    public function profile(Request $request)
    {
        $profile = Seller::with('orders', 'withdraws','seller_area')->find($request->id);
       // return $profile;
        return view('backEnd.seller.profile', compact('profile'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'note' => 'required',
        ]);
        $input = $request->all();
        $seller = Seller::find($request->seller_id);
        $seller->balance -= $request->amount;
        $seller->save();

        $input['amount'] = $request->amount;
        $input['note']   = $request->note;
        $input['status'] = 'pending';
        //return $input;
        Sellerdeduct::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->back();
    }

    public function change(Request $request)
    {
        $sellerId = Auth::guard('seller')->user()->id;

        $change = Sellerdeduct::where('seller_id', $sellerId)
                          ->where('status', 'pending')
                          ->first();
        if ($change) {
            $change->status = 'active';
            $change->save();
            Toastr::success('Success', 'Data activated successfully');
        } else {
            Toastr::error('Error', 'Record not found');
        }
        return redirect()->back();
    }
    
    public function products(Request $request)
    {
        $data = Product::where(['seller_id' => $request->id])->get();
        $seller = Seller::select('id', 'name', 'status')->find($request->id);
        return view('backEnd.seller.products', compact('data', 'seller'));
    }
    public function adminlog(Request $request)
    {
        $seller = Seller::find($request->hidden_id);
        Auth::guard('seller')->loginUsingId($seller->id);
        return redirect()->route('seller.account');
    }
    public function seller_products($id) {
        $data = Product::where(['seller_id' => $id])->get();
        $seller = Seller::find($id);
        return view('backEnd.seller.products', compact('data','seller'));
    }
    public function pending_product(Request $request)
    {
        $data = Product::where(['approval' => 0])->get();
        return view('backEnd.seller.pending_product', compact('data'));
    }

    public function product_details($id)
    {
        $details = Product::with('images')->find($id);
        return view('backEnd.seller.product_details', compact('details'));
    }

    public function product_status(Request $request){
        $update_data = Product::select('id','status','approval')->find($request->id);
        $update_data->status = $request->status;
        $update_data->approval = $request->status;
        $update_data->save();
        Toastr::success('Success', 'Product approval change successfully');
        return redirect()->route('sellers.pending_product');
    }
    public function withdraw(Request $request){
        $withdraws = Withdraw::latest();
        if($request->status){
            $withdraws = $withdraws->where('status',$request->status);
        }
        if($request->start_date && $request->end_date){
            $withdraws = $withdraws->whereBetween('created_at', [$request->start_date,$request->end_date]);
        }
        if($request->seller_id){
            $withdraws = $withdraws->where('seller_id',$request->seller_id);
        }
        $withdraws = $withdraws->with('seller')->paginate(100);
        return view('backEnd.seller.withdraw',compact('withdraws'));
    }
    public function invoice($id){
        $withdraw = Withdraw::where(['id'=>$id])->with('withdrawdetails.order')->first();
        // return $withdraw;
        return view('backEnd.seller.invoice',compact('withdraw'));
    }
    public function withdraw_status(Request $request){
        $this->validate($request, [
            'payment_status' => 'required',
            'admin_note' => 'required'
        ]);
        $withdraw                = Withdraw::where(['id'=>$request->id])->first();
        $withdraw->admin_note    = $request->admin_note;
        $withdraw->status        = $request->payment_status;
        $withdraw->save();
        Toastr::success('Success','Payment information update successfully');
        return back();
    }
}
