<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderStatus;
use App\Models\ProductVariable;
use Carbon\Carbon;
use Session;
use Toastr;
use Auth;
use DB;

class DashboardController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth')->except(['locked','unlocked']);
    }
    public function dashboard(){
        $order_statuses = OrderStatus::withCount('orders')->get();
        $total_sale = Order::where('order_status',6)->sum('amount');
        $today_order = Order::whereDate('created_at',  Carbon::today())->count();
        $today_sales = Order::where('order_status',6)->whereDate('created_at',  Carbon::today())->sum('amount');
        $current_month_sale = Order::where('order_status',6)->whereMonth('created_at', Carbon::now()->month)->sum('amount');
        $total_order = Order::count();
        $current_month_order = Order::whereMonth('created_at', Carbon::now()->month)->count();
        $total_customer = Customer::count();
        $latest_order = Order::latest()->limit(5)->with('customer','product','product.image')->get();
        $latest_customer = Customer::latest()->limit(5)->get();
        $dates = [];
        $startDate = Carbon::now()->subDays(29); // 29 days back + today = 30 days
        for ($i = 0; $i < 30; $i++) {
            $dates[] = $startDate->copy()->addDays($i)->format('Y-m-d');
        }
        $payments = Order::selectRaw('DATE(created_at) as date, SUM(amount) as total_amount')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->pluck('total_amount', 'date');

        // Prepare data: ensure every date has a payment value, defaulting to 0
        $totals = [];
        foreach ($dates as $date) {
            $totals[] = isset($payments[$date]) ? $payments[$date] : 0;
        }
        $dates_json = json_encode($dates);
        $totals_json = json_encode($totals);
        $products = Product::select('id','name','type','stock','stock_alert')->where('type',1)->where('stock', '<=', DB::raw('stock_alert'))->with('image')->limit(10)->get();
        $variables = ProductVariable::whereHas('product', function($query) {
            $query->whereRaw('product_variables.stock <= products.stock_alert');
        })->with('product','image')
        ->limit(10)->get();
        return view('backEnd.admin.dashboard',compact('order_statuses','total_sale','today_order','today_sales','current_month_sale','total_order','current_month_order','total_customer','latest_order','dates_json','totals_json','products','variables'));
        
    }
    public function changepassword()
    {
        return view('backEnd.admin.changepassword');
    }
    public function newpassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required_with:new_password|same:new_password|'
        ]);

        $user = User::find(Auth::id());
        $hashPass = $user->password;

        if (Hash::check($request->old_password, $hashPass)) {
            $user->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            Toastr::success('Success', 'Password changed successfully!');
            return redirect()->route('dashboard');
        } else {
            Toastr::error('Failed', 'Old password not match!');
            return back();
        }
    }
    public function locked()
    {
        // only if user is logged in

        Session::put('locked', true);
        return view('backEnd.auth.locked');
        return redirect()->route('login');
    }

    public function unlocked(Request $request)
    {
        if (!Auth::check())
            return redirect()->route('login');
        $password = $request->password;
        if (Hash::check($password, Auth::user()->password)) {
            Session::forget('locked');
            Toastr::success('Success', 'You are logged in successfully!');
            return redirect()->route('dashboard');
        }
        Toastr::error('Failed', 'Your password not match!');
        return back();
    }
}
