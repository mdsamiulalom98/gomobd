<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Productimage;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Childcategory;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Region;
use App\Models\ProductVariable;
use App\Models\Productcolor;
use App\Models\PurchaseDetails;
use App\Models\Size;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SellerProductController extends Controller
{
    public function getSubcategory(Request $request)
    {
        $subcategory = DB::table("subcategories")
            ->where("category_id", $request->category_id)
            ->pluck('name', 'id');
        return response()->json($subcategory);
    }
    public function getChildcategory(Request $request)
    {
        $childcategory = DB::table("childcategories")
            ->where("subcategory_id", $request->subcategory_id)
            ->pluck('name', 'id');
        return response()->json($childcategory);
    }

    public function index(Request $request)
    {
        $data = Product::where('seller_id', Auth::guard('seller')->user()->id)->latest()->select('id', 'name', 'category_id', 'new_price', 'topsale', 'feature_product', 'status')->with('image', 'category')->withSum('variables', 'stock');
        if ($request->keyword) {
            $data = $data->where('name', 'LIKE', '%' . $request->keyword . "%");
        }
        $data = $data->paginate(50);
        return view('frontEnd.layouts.seller.product_manage', compact('data'));
    }
    public function stock_alert()
    {
        $products = Product::select('id', 'name', 'type', 'stock', 'stock_alert')->where('type', 1)->where('stock', '<=', DB::raw('stock_alert'))->with('image')->get();
        $variables = ProductVariable::whereHas('product', function ($query) {
            $query->whereRaw('product_variables.stock <= seller.products.stock_alert');
        })->with('product', 'image')
            ->get();
        return view('backEnd.product.stock_alert', compact('products', 'variables'));
    }

    public function create(Request $request)
    {
        $categories = Category::where('status', 1)->select('id', 'name', 'status')->get();
        $brands = Brand::where('status', '1')->select('id', 'name', 'status')->get();
        $colors = Color::where('status', '1')->get();
        $sizes = Size::where('status', '1')->get();
        $regions = Region::where('status', 1)->get();
        $products = Product::where(['admin_product' => 1, 'status' => 1])->get();
        $product = Product::with('images', 'colors')->find($request->product);
        $subcategories = Subcategory::where(['category_id' => $product->category_id ?? 0, 'status' => 1])->get();
        $childcategories = Childcategory::where(['subcategory_id' => $product->subcategory_id ?? 0, 'status' => 1])->get();
        $variables = ProductVariable::where('product_id', $product->id ?? 0)->get();
        return view('frontEnd.layouts.seller.product_add', compact('products', 'categories', 'brands', 'colors', 'sizes', 'regions', 'product', 'subcategories', 'childcategories', 'variables'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
        ]);
        $product = Product::find($request->product);

        $max_id = DB::table('products')->max('id');
        $max_id = $max_id ? $max_id + 1 : '1';
        $input = $request->except(['image', 'product', 'files', 'sizes', 'proColor', 'colors', 'regions', 'purchase_prices', 'old_prices', 'new_prices', 'stocks', 'images', 'pro_barcodes']);
        $input['slug'] = strtolower(preg_replace('/[\/\s]+/', '-', $request->name . '-' . $max_id));
        $input['status'] = $request->status ? 1 : 0;
        $input['topsale'] = $request->topsale ? 1 : 0;
        $input['approval'] = 0;
        $input['seller_id'] = Auth::guard('seller')->user()->id;
        $product_variables = ProductVariable::where('product_id', $product->id)->get();
        $firstProductVariable = $product_variables->first();
        $input['purchase_price'] = $request->purchase_prices[0] ?? ($firstProductVariable->purchase_price ?? null);
        $input['old_price'] = $request->old_prices[0] ?? ($firstProductVariable->old_price ?? null);
        $input['new_price'] = $request->new_prices[0] ?? ($firstProductVariable->new_price ?? null);
        $input['stock'] = 0;
        $input['pro_barcode'] = $request->pro_barcode ?? $this->barcode_generate();
        $save_data = Product::create($input);
        $save_data->colors()->attach($request->proColor);

        foreach ($product_variables as $key => $value) {
            $variable = new ProductVariable();
            $variable->product_id = $save_data->id;
            $variable->size = $value->size;
            $variable->region = $value->region;
            $variable->purchase_price = $value->purchase_price;
            $variable->old_price = $value->old_price;
            $variable->new_price = $value->new_price;
            $variable->pro_barcode = $value->pro_barcode ?? $this->barcode_generate();
            $variable->stock = $value->stock;
            $variable->image = $value->image;
            $variable->save();
        }

        $product_images = Productimage::where('product_id', $product->id)->get();
        foreach ($product_images as $key => $value) {
            $product_image = new Productimage();
            $product_image->product_id = $save_data->id;
            $product_image->image = $value->image;
            $product_image->save();
        }

        $pro_image = $request->file('image');
        if ($pro_image) {
            foreach ($pro_image as $key => $image) {
                $name = time() . '-' . $image->getClientOriginalName();
                $name = strtolower(preg_replace('/\s+/', '-', $name));
                $uploadPath = 'public/uploads/product/';
                $image->move($uploadPath, $name);
                $imageUrl = $uploadPath . $name;
                $pimage = new Productimage();
                $pimage->product_id = $save_data->id;
                $pimage->image = $imageUrl;
                $pimage->save();
            }
        }
        if ($request->stocks) {
            $size = $request->sizes;
            $region = $request->regions;
            $stocks = array_filter($request->stocks);
            $purchase = $request->purchase_prices;
            $old_price = $request->old_prices;
            $new_price = $request->new_prices;
            $pro_barcode = $request->pro_barcodes;
            $images = $request->file('images');
            if (is_array($stocks)) {
                foreach ($stocks as $key => $stock) {
                    $imageUrl = null;

                    if (isset($images[$key]) && $images[$key] != null) {
                        $image = $images[$key];
                        $name = time() . '-' . $image->getClientOriginalName();
                        $name = strtolower(preg_replace('/\s+/', '-', $name));
                        $uploadPath = 'public/uploads/product/';
                        $image->move($uploadPath, $name);
                        $imageUrl = $uploadPath . $name;
                    }

                    $variable = new ProductVariable();
                    $variable->product_id = $save_data->id;
                    $variable->size = isset($size[$key]) ? $size[$key] : 0;
                    $variable->region = isset($region[$key]) ? $region[$key] : 0;
                    $variable->purchase_price = isset($purchase[$key]) ? $purchase[$key] : 0;
                    $variable->old_price = isset($old_price[$key]) ? $old_price[$key] : 0;
                    $variable->new_price = isset($new_price[$key]) ? $new_price[$key] : 0;
                    $variable->pro_barcode = $pro_barcode[$key] ?? $this->barcode_generate();
                    $variable->stock = $stock;
                    $variable->image = $imageUrl;
                    $variable->save();
                }
            }
        }


        Toastr::success('Success', 'Data insert successfully');
        return redirect()->route('seller.products.index');
    }


    public function edit($id)
    {
        $edit_data = Product::with('images')->find($id);
        $categories = Category::where('status', 1)->select('id', 'name', 'status')->get();
        $subcategory = Subcategory::where('category_id', '=', $edit_data->category_id)->select('id', 'name', 'category_id', 'status')->get();
        $childcategory = Childcategory::where('subcategory_id', '=', $edit_data->subcategory_id)->select('id', 'name', 'subcategory_id', 'status')->get();
        $brands = Brand::where('status', '1')->select('id', 'name', 'status')->get();
        $colors = Color::where('status', '1')->get();
        $sizes = Size::where('status', '1')->get();
        $regions = Region::where('status', 1)->get();
        $variables = ProductVariable::where('product_id', $id)->get();
        $selectcolors = Productcolor::where('product_id', $id)->get();
        return view('frontEnd.layouts.seller.product_edit', compact('edit_data', 'categories', 'subcategory', 'childcategory', 'brands', 'sizes', 'colors', 'variables', 'regions', 'selectcolors'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
        ]);

        $update_data = Product::find($request->id);
        $input = $request->except(['image', 'files', 'sizes', 'colors', 'purchase_prices', 'old_prices', 'new_prices', 'stocks', 'images', 'up_id', 'up_sizes', 'up_colors', 'up_regions', 'up_purchase_prices', 'up_old_prices', 'up_new_prices', 'up_stocks', 'up_images', 'pro_barcodes', 'up_pro_barcodes', 'proColor', 'regions']);

        $input['slug'] = strtolower(preg_replace('/[\/\s]+/', '-', $request->name . '-' . $update_data->id));
        $input['status'] = $request->status ? 1 : 0;
        $input['topsale'] = $request->topsale ? 1 : 0;
        $update_data->update($input);

        $images = $request->file('image');
        if ($images) {
            foreach ($images as $key => $image) {
                $name = time() . '-' . $image->getClientOriginalName();
                $name = strtolower(preg_replace('/\s+/', '-', $name));
                $uploadPath = 'public/uploads/product/';
                $image->move($uploadPath, $name);
                $imageUrl = $uploadPath . $name;

                $pimage = new Productimage();
                $pimage->product_id = $update_data->id;
                $pimage->image = $imageUrl;
                $pimage->save();
            }
        }

        if ($request->up_id) {
            $update_ids = array_filter($request->up_id);
            $up_region = $request->up_regions;
            $up_size = $request->up_sizes;
            $up_stock = $request->up_stocks;
            $up_purchase = $request->up_purchase_prices;
            $up_old_price = $request->up_old_prices;
            $up_new_price = $request->up_new_prices;
            $up_pro_barcode = $request->up_pro_barcodes;
            $images = $request->file('up_images');
            if ($update_ids) {
                foreach ($update_ids as $key => $update_id) {
                    $upvariable = ProductVariable::find($update_id);
                    if (isset($images[$key])) {
                        $image = $images[$key];
                        $name = time() . '-' . $image->getClientOriginalName();
                        $name = strtolower(preg_replace('/\s+/', '-', $name));
                        $uploadPath = 'public/uploads/product/';
                        $image->move($uploadPath, $name);
                        $imageUrl = $uploadPath . $name;
                    } else {
                        $imageUrl = $upvariable->image;
                    }

                    $upvariable->product_id = $update_data->id;
                    $upvariable->size = $up_size ? $up_size[$key] : NULL;
                    $upvariable->region = $up_region ? $up_region[$key] : NULL;
                    $upvariable->purchase_price = $up_purchase[$key];
                    $upvariable->old_price = $up_old_price ? $up_old_price[$key] : NULL;
                    $upvariable->new_price = $up_new_price[$key];
                    $upvariable->pro_barcode = $up_pro_barcode ? $up_pro_barcode[$key] : NULL;
                    $upvariable->stock = $up_stock[$key];
                    $upvariable->image = $imageUrl;
                    $upvariable->save();
                }
            }
        }

        if ($request->stocks) {
            $size = $request->sizes;
            $region = $request->regions;
            $stocks = array_filter($request->stocks);
            $purchase = $request->purchase_prices;
            $old_price = $request->old_prices;
            $new_price = $request->new_prices;
            $pro_barcodes = $request->pro_barcodes;
            $images = $request->file('images');
            if (is_array($stocks)) {
                foreach ($stocks as $key => $stock) {
                    if (isset($images[$key])) {
                        $image = $images[$key];
                        $name = time() . '-' . $image->getClientOriginalName();
                        $name = strtolower(preg_replace('/\s+/', '-', $name));
                        $uploadPath = 'public/uploads/product/';
                        $image->move($uploadPath, $name);
                        $imageUrl = $uploadPath . $name;
                    } else {
                        $imageUrl = NULL;
                    }

                    $variable = new ProductVariable();
                    $variable->product_id = $update_data->id;
                    $variable->size = $size ? $size[$key] : NULL;
                    $variable->region = $region ? $region[$key] : NULL;
                    $variable->purchase_price = $purchase[$key];
                    $variable->old_price = $old_price ? $old_price[$key] : NULL;
                    $variable->new_price = $new_price[$key];
                    $variable->stock = $stock;
                    $variable->pro_barcode = $pro_barcodes[$key];
                    $variable->image = $imageUrl;
                    $variable->save();
                }
            }
        }

        Toastr::success('Data update successfully', 'Success', ['positionClass' => 'toast-top-right']);
        ;
        return redirect()->route('seller.products.index');
    }

    public function inactive(Request $request)
    {
        $inactive = Product::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Data inactive successfully', 'Success', ['positionClass' => 'toast-top-center']);
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Product::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success', 'Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Product::find($request->hidden_id);
        foreach ($delete_data->variables as $variable) {
            $variable->delete();
        }
        foreach ($delete_data->images as $pimage) {
            File::delete($pimage->image);
            $pimage->delete();
        }
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');
        return redirect()->back();
    }
    public function imgdestroy(Request $request)
    {
        $delete_data = Productimage::find($request->id);
        $delete_data->delete();
        Toastr::success('Success', 'Data delete successfully');
        return redirect()->back();
    }
    public function pricedestroy(Request $request)
    {
        $delete_data = ProductVariable::find($request->id);
        $delete_data->delete();
        Toastr::success('Success', 'Product price delete successfully');
        return redirect()->back();
    }
    public function update_deals(Request $request)
    {
        Product::whereIn('id', $request->input('product_ids'))->update(['topsale' => $request->status]);
        return response()->json(['status' => 'success', 'message' => 'Hot deals product status change']);
    }
    public function update_feature(Request $request)
    {
        Product::whereIn('id', $request->input('product_ids'))->update(['feature_product' => $request->status]);
        return response()->json(['status' => 'success', 'message' => 'Feature product status change']);
    }
    public function update_status(Request $request)
    {
        Product::whereIn('id', $request->input('product_ids'))->update(['status' => $request->status]);
        return response()->json(['status' => 'success', 'message' => 'Product status change successfully']);
    }
    public function barcode_update(Request $request)
    {
        ProductVariable::whereIn('id', $request->input('product_ids'))->update(['status' => $request->status]);
        Toastr::success('Success', 'Data delete successfully');
        return redirect()->back();
    }

    public function barcodess()
    {
        $products = ProductVariable::get();
        foreach ($products as $product) {
            $product->pro_barcode = str_pad($product->id, 8, '1', STR_PAD_LEFT);
            $product->save();
        }
    }

    public function purchase_list()
    {
        $purchase = PurchaseDetails::with('product')->latest()->paginate(100);
        return view('backEnd.product.purchase_list', compact('purchase'));
    }
    public function purchase_create()
    {
        $data = Product::select('id', 'name', 'status', 'new_price', 'type')->latest()->get();
        return view('backEnd.product.purchase_create', compact('data'));
    }
    public function purchase_store(Request $request)
    {

        $product = ProductVariable::where('id', $request->product_id)->first();
        $product->stock += $request->qty;
        $product->save();

        $parchase = new PurchaseDetails();
        $parchase->product_id = $product->product_id;
        $parchase->region = $product->region;
        $parchase->size = $product->size;
        $parchase->purchase_price = $product->purchase_price;
        $parchase->old_price = $product->old_price;
        $parchase->new_price = $product->new_price;
        $parchase->stock = $request->qty;
        $parchase->save();

        Toastr::success('Success', 'Product purchase successfully');
        return redirect()->back();
    }
    public function purchase_history($id)
    {
        $purchase = PurchaseDetails::where('product_id', $id)->with('product')->latest()->get();
        return view('backEnd.product.purchase_history', compact('purchase'));
    }

    function barcode_generate()
    {
        $max_product = DB::table('products')->max(DB::raw('CAST(pro_barcode AS UNSIGNED)'));
        $max_variable = DB::table('product_variables')->max(DB::raw('CAST(pro_barcode AS UNSIGNED)'));
        $max_barcode = max($max_product, $max_variable);
        return $max_barcode ? $max_barcode + 1 : 100001;
    }

    public function price_edit()
    {
        $products = ProductVariable::select('id', 'product_id', 'size', 'color', 'purchase_price', 'old_price', 'new_price', 'stock')->get();
        return view('frontEnd.layouts.seller.price_edit', compact('products'));
    }

    public function price_update(Request $request)
    {
        $ids = $request->ids;
        $oldPrices = $request->old_price;
        $newPrices = $request->new_price;
        $stocks = $request->stock;
        foreach ($ids as $key => $id) {
            $product = ProductVariable::select('id', 'old_price', 'new_price', 'stock')->find($id);

            if ($product) {
                $product->update([
                    'old_price' => $oldPrices[$key],
                    'new_price' => $newPrices[$key],
                    'stock' => $stocks[$key],
                ]);
            }
        }
        Toastr::success('Success', 'Price update successfully');
        return redirect()->back();
    }
}
