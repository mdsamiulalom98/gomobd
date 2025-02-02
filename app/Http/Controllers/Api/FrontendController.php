<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\GeneralSetting;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\CreatePage;
use App\Models\SocialMedia;
use App\Models\ShippingCharge;
use App\Models\Review;
use App\Models\Brand;
use App\Models\District;
use App\Models\ProductVariable;
use App\Models\Productcolor;
use App\Models\Contact;
use App\Models\ShippingDiscount;
use Carbon\Carbon;
use Response;
use Hash;
use Auth;
use Mail;
use Str;
use DB;
class FrontendController extends Controller
{
   public function appconfig()
    {
        $data = GeneralSetting::where('status',1)->select('id','name','white_logo','dark_logo','favicon')->first();
        return response()->json(['status' => 'success','message'=>'Data fatch successfully','data'=>$data]);
    }
    
    public function slider()
    {
        $data = Banner::where(['status'=>1,'category_id'=>1])->select('id','image','status','category_id','link')->get();
        return response()->json(['status' => 'success','message'=>'Data fatch successfully','data'=>$data]);
    }
    
    public function categorymenu(){
        $data = Category::where(['status'=>1])->orderBy('id','ASC')->select('id','slug','name','image')->get();
        return response()->json(['status' => 'success','message'=>'Data fatch successfully','data'=>$data]);
   }
   
    public function bestdealproduct(){
        $data = Product::where(['status'=>1])->select('id','slug','name','type','topsale','old_price','new_price')
        ->with('variable','image')
        ->limit(20)->get();
        return response()->json(['status' => 'success','message'=>'Data fatch successfully','data'=>$data]);
   }
   
    public function hotdeal_all(){
        $datas = Product::where(['status'=>1])->select('id','slug','name','type','topsale','old_price','new_price')
        ->with('variable','image')->paginate(20);
        return response()->json(['status' => 'success','message'=>'Data fatch successfully','datas'=>$datas]);
   }
   
    public function all_product(){
        $data = Product::where(['status'=>1])->select('id','slug','name','type','old_price','new_price', 'category_id')->with('variable','image')->orderBy('id','DESC')->paginate(20);
        return response()->json(['status' => 'success','message'=>'Data fatch successfully','data'=>$data]);
   }
   
   public function product_with_Category(){
       $data = Category::where(['status' => 1, 'front_view' => 1])
            ->select('id', 'slug', 'name')
            ->get()
            ->map(function ($category) {
                $category->products = $category->products()
                    ->with('image', 'variable')
                    ->take(6)
                    ->get();
                return $category;
            });



        // return 'ok';
        return response()->json(['status' => 'success','message'=>'Data fatch successfully','data'=>$data]);
   }
  
   public function socialmedia(){
        $data = SocialMedia::where(['status'=>1])->get();
        return response()->json(['status' => 'success','message'=>'Data fatch successfully','data'=>$data]);
   }
   public function contactinfo(){
        $data = Contact::where(['status'=>1])->first();
        return response()->json(['status' => 'success','message'=>'Data fatch successfully','data'=>$data]);
   }
   
   //   Home Page Function End ====================

    public function category($id){
        // return 'ok';
        $category = Category::where(['status'=>1, 'id'=>$id])->select('id','name','slug')->first();
        $data = Product::where(['status'=>1, 'category_id'=>$category->id])
        ->select('id','slug','name','type','old_price','new_price', 'category_id')
        ->with('variable','image')->orderBy('id','DESC')->paginate(20);
        return response()->json(['status' => 'success','message'=>'Data fatch successfully','data'=>$data, 'category'=>$category]);
    }
    
    
    public function productDetails($id)
    {

        $details = Product::where(['id' => $id, 'status' => 1])
            ->with('image', 'images', 'category', 'subcategory', 'childcategory')
            ->withCount('variable')
            ->firstOrFail();
            
        $products = Product::where(['category_id' => $details->category_id, 'status' => 1])
            ->with('image')
            ->select('id', 'name', 'slug', 'status', 'category_id', 'new_price', 'old_price', 'type')
            ->withCount('variable')
            ->get();
            

        $shippingcharge = ShippingCharge::where('status', 1)->get();
        
        $reviews = Review::where('product_id', $details->id)->get();

        $productcolors = Productcolor::where('product_id', $details->id)->with('color')
            ->distinct()
            ->get();
        // return $productcolors;

        $productregions = ProductVariable::where('product_id', $details->id)->where('stock', '>', 0)
            ->whereNotNull('region')
            ->select('region')
            ->distinct()
            ->get();

        $productsizes = ProductVariable::where('product_id', $details->id)->where('stock', '>', 0)
            ->whereNotNull('size')
            ->select('size')
            ->distinct()
            ->get();
            
            
        return response()->json([
            'details' => $details,
            'products' => $products,
            'shippingcharge' => $shippingcharge,
            'productcolors' => $productcolors,
            'productsizes' => $productsizes,
            'productregions' => $productregions,
            'reviews' => $reviews,
        ]);
     }
     
    public function stock_check(Request $request)
    {
        $product = ProductVariable::where(['product_id' => $request->id, 'region' => $request->region, 'size' => $request->size])->select('id', 'product_id', 'old_price', 'new_price', 'stock')->first();

        $status = $product ? true : false;

        // $new_price = $product->new_price ?? 0;
        // $emi_amount = (($new_price * 12) / 100) + (($new_price * 10) / 100) + $new_price;
        // $down_payment = ($emi_amount * 35) / 100;
        // $monthly_installment = ($emi_amount - $down_payment) / 10;

        if ($status) {
            $new_price = $product->new_price ?? 0;
            $emi_amount = (($new_price * 12) / 100) + (($new_price * 10) / 100) + $new_price;
            $down_payment = ($emi_amount * 35) / 100;
            $monthly_installment = ($emi_amount - $down_payment) / 10;
        } else {
            $new_price = 0;
            $emi_amount = 0;
            $down_payment = 0;
            $monthly_installment = 0;
        }

        $response = [
            'status' => $status,
            'product' => $product,
            'emi_amount' => round($emi_amount, 0),
            'down_payment' => round($down_payment, 0),
            'monthly_installment' => round($monthly_installment, 0)
        ];
        return response()->json($response);
    }
   


    public function livesearch(Request $request)
    {
        // Start building the query
        $products = Product::select('id', 'name', 'slug', 'new_price', 'old_price', 'type')
            ->with(['variable', 'image']) // Load relationships
            ->where('status', 1); // Only active products
    
        // Apply filters if a keyword is provided
        if ($request->keyword) {
            $products = $products->where('name', 'LIKE', '%' . $request->keyword . "%");
        }
    
        if ($request->category) {
            $products = $products->where('category_id', $request->category);
        }
    
        // If no keyword is provided, limit the result to 20 products
        if (!$request->keyword) {
            $products = $products->limit(20);
        }
    
        // Fetch the products
        $products = $products->get();
    
        // Return the response
        return response()->json(['products' => $products]);
    }


    
    
    public function shipping_charge (){
        $shippingcharges = ShippingCharge::where(['status'=>1])->get();
        return response()->json(['status'=>'success','message'=>'Data fetch successfully','shippingcharges'=>$shippingcharges]);
    }
    
    public function districts(Request $request){
        $districts = District::distinct()->select('district')->get();
        return response()->json(['status'=>'success','message'=>'Data fetch successfully','districts'=>$districts]);
    }
    public function areas(Request $request){
        $data = District::where('district',$request->district)->select('id','area_name','shippingfee','district')->get();
        return response()->json(['status'=>'success','message'=>'Data fetch successfully','data'=>$data]);
    }
    
  
    public function page()
    {
        $slug = 'order-procedure';
        $page = CreatePage::where('slug', $slug)->firstOrFail();
        return response()->json(['page'=>$page]);
    }
    
    
    public function brands(){
        // return 'ok';
       $brands = Brand::where(['status' => 1])
            ->orderBy('id', 'ASC')
            ->select('id','name','slug','image')
            ->get();
        return response()->json(['status' => 'success','message'=>'Data fatch successfully','data'=>$brands]);
    }
    
    
}












