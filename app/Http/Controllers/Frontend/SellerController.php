<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Seller;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Withdraw;
use App\Models\WithdrawDetails;
use App\Models\SmsGateway;
use App\Models\GeneralSetting;

class SellerController extends Controller
{
    function __construct()
    {
        $this->middleware('seller', ['except' => ['register', 'store', 'verify', 'resendotp', 'account_verify', 'login', 'signin', 'logout', 'forgot_password', 'forgot_verify', 'forgot_reset', 'forgot_store']]);
    }

    public function login()
    {
        return view('frontEnd.layouts.seller.login');
    }
    public function signin(Request $request)
    {
        $this->validate($request, [
            'phone'    => 'required',
            'password' => 'required|min:6'
        ]);
        $auth_check = Seller::where(['phone' => $request->phone,])->first();
        if ($auth_check) {
            if ($auth_check->status != 'active') {
                Toastr::error('message', 'Your account inactive now please wait');
                return redirect()->back();
            }
            if (Auth::guard('seller')->attempt(['phone' => $request->phone, 'password' => $request->password])) {
                return redirect()->intended('seller/account');
                Toastr::success('You are login successfully', 'success!');
            }
            Toastr::error('message', 'Opps! your phone or password wrong');
            return redirect()->back();
        } else {
            Toastr::error('message', 'Sorry! You have no account');
            return redirect()->back();
        }
    }

    public function register()
    {
        return view('frontEnd.layouts.seller.register');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|unique:sellers',
            'phone'    => 'required|unique:sellers',
            'email'    => 'required|unique:sellers',
            'password' => 'required|min:6|same:confirm-password'
        ]);
        $last_id = Seller::orderBy('id', 'desc')->first();
        $last_id = $last_id ? $last_id->id + 1 : 1;
        $store              = new Seller();
        $store->name        = $request->name;
        $store->slug        = strtolower(Str::slug($request->name . '-' . $last_id));
        $store->phone       = $request->phone;
        $store->email       = $request->email;
        $store->password    = bcrypt($request->password);
        $store->verify      = rand(1111,9999);
        $store->status      = 'pending';
        $store->save();

        $site_setting = GeneralSetting::where('status', 1)->first();
        $sms_gateway = SmsGateway::where('status' , '1')->first();
        if ($sms_gateway) {
            $apiUrl = "https://quicksmsapp.com/Api/sms/campaign_api";
            $quickApi = "54ab22d2b79a3ee99438438319521c8d";
            $mobile =  $request->phone;
            $msg = "প্রিয়  $request->name!\r\nআপনার ওটিপি হল $store->verify\r\n$site_setting->name এর সাথে থাকার জন্য ধন্যবাদ ";
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "$apiUrl?quick_api=$quickApi&mobile=$mobile&msg=" . urlencode($msg),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
        }


         Session::put('seller_verify',$request->phone);
        Toastr::success('Your account register successfully');
        return redirect()->route('seller.verify');
    }
    public function verify()
    {
        return view('frontEnd.layouts.seller.verify');
    }
    public function resendotp(Request $request)
    {
        $seller = Seller::where('phone', session::get('seller_verify'))->first();
        $seller->verify = rand(1111, 9999);
        $seller->save();

        $token = "105771848101705927690dd88320295e5924df7a86f71c5e85b9f";
        $message = "Dear $seller->name!\r\nYour account OTP is $seller->verify \r\nThank you for using Go Mobile BD";

        $url = "http://api.greenweb.com.bd/api.php";
        $data = array(
            'to' => $seller->phone,
            'message' => "$message",
            'token' => "$token"
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);


        Toastr::success('Success', 'Resend code send successfully');
        return redirect()->back();
    }
    public function account_verify(Request $request)
    {
        $this->validate($request, [
            'otp' => 'required',
        ]);
        $seller = Seller::where('phone', session::get('seller_verify'))->first();
        if ($seller->verify != $request->otp) {
            Toastr::error('Success', 'Your OTP not match');
            return redirect()->back();
        }

        $seller->verify = 1;
        $seller->save();

        Session::forget('seller_verify');
        Auth::guard('seller')->loginUsingId($seller->id);
        return redirect()->route('seller.account');
    }
    public function forgot_password()
    {
        return view('frontEnd.layouts.seller.forgot_password');
    }
    public function forgot_verify(Request $request)
    {
        $seller = Seller::where('phone', $request->phone)->first();
        if (!$seller) {
            Toastr::error('Your phone number not found');
            return back();
        }
        $seller->forgot = rand(1111, 9999);
        $seller->save();

        $token = "105771848101705927690dd88320295e5924df7a86f71c5e85b9f";
        $message = "Dear $seller->name!\r\nYour account forgot OTP is $seller->forgot \r\nThank you for using Go Mobile BD";

        $url = "http://api.greenweb.com.bd/api.php";
        $data = array(
            'to' => $request->phone,
            'message' => "$message",
            'token' => "$token"
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsresult = curl_exec($ch);


        session::put('seller_verify', $request->phone);
        Toastr::success('Your account register successfully');
        return redirect()->route('seller.forgot.reset');
    }
    public function forgot_reset()
    {
        if (!Session::get('seller_verify')) {
            Toastr::error('Something wrong please try again');
            return redirect()->route('seller.forgot.password');
        };
        return view('frontEnd.layouts.seller.forgot_reset');
    }
    public function forgot_store(Request $request)
    {

        $seller = Seller::where('phone', session::get('seller_verify'))->first();

        if ($seller->forgot != $request->otp) {
            Toastr::error('Opps', 'Your OTP not match');
            return redirect()->back();
        }

        $seller->forgot = 1;
        $seller->password = bcrypt($request->password);
        $seller->save();

        if (Auth::guard('seller')->attempt(['phone' => $seller->phone, 'password' => $request->password])) {
            Session::forget('seller_verify');
            Toastr::success('You are login successfully', 'success!');
            return redirect()->intended('seller/account');
        }
    }
    public function account()
    {
        $seller = Seller::with('seller_area')->find(Auth::guard('seller')->user()->id);
        $total_order = Order::where('seller_id', $seller->id)->count();
        $total_process = Order::where('seller_id', $seller->id)->whereNotIn('order_status', [1, 6, 7, 8])->count();
        $total_return = Order::where(['order_status' => 8, 'seller_id' => $seller->id])->count();
        $total_complete = Order::where(['order_status' => 6, 'seller_id' => $seller->id])->count();
        $total_amount = Order::where('seller_id', $seller->id)->sum('amount');
        $delivery_amount = Order::where(['order_status' => 6, 'seller_id' => $seller->id])->sum('amount');
        $process_amount = Order::where('seller_id', $seller->id)->whereNotIn('order_status', [1, 6,7, 8])->sum('amount');
        $return_amount = Order::where(['order_status' => 8, 'seller_id' => $seller->id])->sum('amount');
        $total_comision = Order::where(['order_status' => 6, 'seller_id' => $seller->id]) ->sum('seller_commission');
        $payable_amount = Order::where(['order_status' => 6, 'seller_id' => $seller->id,'seller_pay'=>'unpaid'])->sum('payable_amount');
        return view('frontEnd.layouts.seller.account', compact('seller', 'total_order', 'total_process', 'total_return', 'total_complete', 'total_amount', 'delivery_amount', 'process_amount', 'return_amount', 'total_comision','payable_amount'));
    }
    public function logout(Request $request)
    {
        Auth::guard('seller')->logout();
        Toastr::success('You are logout successfully', 'success!');
        return redirect()->route('seller.login');
    }
    public function orders(Request $request)
    {
        $order_status = OrderStatus::where('slug', $request->slug)->withCount('orders')->first();
        if ($request->slug == 'all') {
            $orders = Order::where('seller_id', Auth::guard('seller')->user()->id)->with('orderdetails')->get();
            //return $orders;
        }else{
        $orders = Order::where('order_status', $order_status->id)->where('seller_id', Auth::guard('seller')->user()->id)->get();
        }
        return view('frontEnd.layouts.seller.orders', compact('orders'));
    }
    public function payable_order(Request $request)
    {
        $order_status = OrderStatus::where('slug', $request->slug)->withCount('orders')->first();
        if ($request->slug == 'all') {
            $orders = Order::where(['seller_id'=> Auth::guard('seller')->user()->id,'order_status'=>6,'seller_pay'=>'unpaid'])->with('orderdetails')->get();
            //return $orders;
        }else{
        $orders = Order::where(['seller_id'=> Auth::guard('seller')->user()->id,'order_status'=>6,'seller_pay'=>'unpaid'])->get();
        }
        return view('frontEnd.layouts.seller.payable_order', compact('orders'));
    }

    public function commission(){
        $orders = Order::where(['order_status' => '6', 'seller_id' => Auth::guard('seller')->user()->id])->get();
        return view('frontEnd.layouts.seller.commission', compact('orders'));
    }

    public function invoice($id) {
        $order = Order::where('seller_id', Auth::guard('seller')->user()->id)->with('orderdetails', 'payment', 'shipping', 'customer')->find($id);
        //return $order;
        return view('frontEnd.layouts.seller.invoice', compact('order'));
    }

    public function withdraw(){
        $withdraw = Withdraw::where('seller_id', Auth::guard('seller')->user()->id)->with('withdrawdetails')->get();
        return view('frontEnd.layouts.seller.withdraw', compact('withdraw'));
    }

    public function withdraw_request(Request $request){
        $this->validate($request, [
            'payment_method' => 'required',
        ]);

        $orders = Order::where(['seller_id'=> Auth::guard('seller')->user()->id, 'order_status'=>6,'seller_pay'=>'unpaid']);
        $balance = ($orders->sum('payable_amount'));
        //return $balance_check;
        if ($balance < 1) {
            Toastr::error('Withdraw balance unsificient', 'Low Balance');
            return redirect()->back();
        }

        $withdraw                   = new Withdraw();
        $withdraw->invoice_id       = $this->invoiceIdGenerate();
        $withdraw->seller_id        = Auth::guard('seller')->user()->id;
        $withdraw->amount           = $balance;
        $withdraw->bank_name        = $request->bank_name;
        $withdraw->account_number   = $request->account_number;
        $withdraw->routing_number   = $request->routing_number;
        $withdraw->receive_number   = $request->receive_number;
        $withdraw->payment_method   = $request->payment_method;
        $withdraw->status           = 'pending';
        $withdraw->save();

        foreach($orders->get() as $order){
            $withdraw_details                    = new WithdrawDetails();
            $withdraw_details->withdraw_id       = $withdraw->id;
            $withdraw_details->order_id          = $order->id;
            $withdraw_details->amount               = $order->amount;
            $withdraw_details->commision         = $order->seller_commission;
            $withdraw_details->shipping_charge   = $order->shipping_charge;
            $withdraw_details->payable_amount    = $order->payable_amount;
            $withdraw_details->save();
            $order->seller_pay = 'processing';
            $order->save();
        }

        Toastr::success('Withdraw request send successfully', 'success');
        return redirect()->back();
    }

    public function profile(Request $request)
    {
        $seller = Seller::where(['id' => Auth::guard('seller')->user()->id])->with('seller_area')->firstOrFail();
        return view('frontEnd.layouts.seller.profile', compact('seller'));
    }
    public function profile_edit(Request $request)
    {
        $profile_edit = Seller::where(['id' => Auth::guard('seller')->user()->id])->firstOrFail();
        $districts = District::distinct()->select('district')->get();
        $areas = District::where(['district' => $profile_edit->district])->select('area_name', 'id')->get();
        return view('frontEnd.layouts.seller.profile_edit', compact('profile_edit', 'districts', 'areas'));
    }
    public function profile_update(Request $request)
    {
        // Fetch the current seller data
        $update_data = Seller::where(['id' => Auth::guard('seller')->user()->id])->firstOrFail();
        $district = District::where('district',$request->district)->first();

        // Handle profile image upload
        $image = $request->file('image');
        if (is_array($image)) {
            $image = $image[0]; // Get the first file if it's an array
        }

        if ($image) {
            // Process profile image with Intervention
            $name = time() . '-' . $image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name);
            $name = strtolower(Str::slug($name));
            $uploadpath = 'public/uploads/seller/';
            $imageUrl = $uploadpath . $name;

            $img = Image::make($image->getRealPath());
            $img->encode('webp', 90);

            // Resize the image to 120x120
            $width = 120;
            $height = 120;
            $img->resize($width, $height);
            $img->save($imageUrl);
        } else {
            // Retain the current profile image if none uploaded
            $imageUrl = $update_data->image;
        }

        // Handle nid1 image upload (e.g., national ID card)
        $image2 = $request->file('nid1');
        if ($image2) {
            $name2 = time() . '-' . $image2->getClientOriginalName();
            $name2 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name2);
            $name2 = strtolower(preg_replace('/\s+/', '-', $name2));
            $uploadpath2 = 'public/uploads/settings/';
            $image2Url = $uploadpath2 . $name2;

            $img2 = Image::make($image2->getRealPath());
            $img2->encode('webp', 90);

            // Dynamic resizing for nid1
            $width2 = '';
            $height2 = '';
            $img2->height() > $img2->width() ? $width2 = null : $height2 = null;

            $img2->resize($width2, $height2);
            $img2->save($image2Url);
        }else{
            $image2Url = $update_data->nid1;
        }


        $image3 = $request->file('nid2');
        if ($image3) {
            $name3 = time() . '-' . $image3->getClientOriginalName();
            $name3 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name3);
            $name3 = strtolower(preg_replace('/\s+/', '-', $name3));
            $uploadpath2 = 'public/uploads/settings/';
            $image3Url = $uploadpath2 . $name3;

            $img3 = Image::make($image3->getRealPath());
            $img3->encode('webp', 90);

            $width3 = '';
            $height3 = '';
            $img3->height() > $img3->width() ? $width3 = null : $height3 = null;

            $img3->resize($width3, $height3);
            //return $img3;
            $img3->save($image3Url);
        }else{
            $image3Url = $update_data->nid2;
        }

        $update_data->owner_name = $request->owner_name;
        $update_data->name      = $request->name;
        $update_data->phone     = $request->phone;
        $update_data->email     = $request->email;
        $update_data->address   = $request->address;
        $update_data->nidnum    = $request->nidnum;
        $update_data->district  = $district->id;
        $update_data->area      = $request->area;
        $update_data->image     = $imageUrl;
        $update_data->nid1      = $image2Url;
        $update_data->nid2      = $image3Url;
        $update_data->save();

        // Flash success message and redirect
        Toastr::success('Your profile has been updated successfully', 'Success!');
        return redirect()->route('seller.profile');
    }

    public function change_pass()
    {
        return view('frontEnd.layouts.seller.change_password');
    }
    public function password_update(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required_with:new_password|same:new_password|'
        ]);

        $customer = Seller::find(Auth::guard('seller')->user()->id);
        $hashPass = $customer->password;

        if (Hash::check($request->old_password, $hashPass)) {

            $customer->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            Toastr::success('Success', 'Password changed successfully!');
            return redirect()->route('seller.account');
        } else {
            Toastr::error('Failed', 'Old password not match!');
            return redirect()->back();
        }
    }
    public function process(Request $request)
    {
        $process = Order::find($request->hidden_id);
        $process->order_status = 2;
        $process->save();
        Toastr::success('Success','Data process successfully');
        return redirect()->back();
    }
    public function cancel(Request $request)
    {
        $cancel = Order::find($request->hidden_id);
        $cancel->order_status = 7;
        $cancel->save();
        Toastr::success('Success','Data cancel successfully');
        return redirect()->back();
    }
    function invoiceIdGenerate(){
        do {
            $uniqueId = 'INV-'.date('dmy').Str::upper(Str::random(6));
            $exists = Withdraw::where('invoice_id', $uniqueId)->exists();
        }while ($exists);

        return $uniqueId;
    }
}
