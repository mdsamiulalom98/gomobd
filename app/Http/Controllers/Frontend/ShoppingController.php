<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\ProductVariable;
use App\Models\Product;

class ShoppingController extends Controller
{

    public function cart_store(Request $request)
    {
        // return $request->all();
        $product = Product::select('id', 'name', 'slug', 'new_price', 'old_price', 'purchase_price', 'stock', 'category_id', 'seller_id')->where(['id' => $request->id])->first();
        $var_product = ProductVariable::where(['product_id' => $request->id, 'region' => $request->product_region, 'size' => $request->product_size])->first();

        $purchase_price = $var_product ? $var_product->purchase_price : 0;
        $old_price = $var_product ? $var_product->old_price : 0;
        $new_price = $var_product ? $var_product->new_price : 0;
        $stock = $var_product ? $var_product->stock : 0;
        $emi_amount = 0;
        $down_payment = 0;
        $monthly_installment = 0;

        if ($new_price <= 0) {
            $new_price = $old_price > 0 ? $old_price : $purchase_price;
        }
        if ($request->enable_emi == 1) {
            // EMI calculations
            $emi_amount = (($new_price * 12) / 100) + (($new_price * 10) / 100) + $new_price;
            $down_payment = ($emi_amount * 35) / 100;
            $monthly_installment = ($emi_amount - $down_payment) / 10;
            $new_price = $down_payment;
        }

        $cartitem = Cart::instance('shopping')->content()->where('id', $product->id)->first();
        if ($cartitem) {
            $cart_qty = $cartitem->qty + $request->qty ?? 1;
        } else {
            $cart_qty = $request->qty ?? 1;
        }
        if ($stock < $cart_qty) {
            Toastr::error('Product stock limit over', 'Failed!');
            return back();
        }

        $cartitems = Cart::instance('shopping')->content();
        $hasEnabledEmi = $cartitems->contains(function ($cartItem) {
            return isset($cartItem->options['enable_emi']) && $cartItem->options['enable_emi'] == 1;
        });
        if ($hasEnabledEmi) {
            Toastr::error('Some EMI product on cart. Please complete the current cart.', 'Error!');
            return back();
        }
        Cart::instance('shopping')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $request->qty ?? 1,
            'price' => $new_price,
            'weight' => 1,
            'options' => [
                'slug' => $product->slug,
                'image' => $product->image->image ?? '',
                'old_price' => round($new_price, 0),
                'purchase_price' => $purchase_price,
                'product_size' => $request->product_size,
                'product_color' => $request->product_color,
                'product_region' => $request->product_region,
                'category_id' => $product->category_id,
                'seller_id' => $product->seller_id,
                'free_shipping' => 0,
                'enable_emi' => $request->enable_emi,
                'monthly_installment' => round($monthly_installment, 0) ?? 0,
                'emi_amount' => round($emi_amount, 0) ?? 0,
                'down_payment' => round($down_payment, 0) ?? 0,
            ],
        ]);

        Toastr::success('Product successfully add to cart', 'Success!');
        if ($request->add_cart) {
            return back();
        }
        return redirect()->route('customer.checkout');
    }
    public function campaign_stock(Request $request)
    {
        $product = ProductVariable::where(['product_id' => $request->id, 'color' => $request->color, 'size' => $request->size])->first();

        $status = $product ? true : false;
        $response = [
            'status' => $status,
            'product' => $product
        ];
        return response()->json($response);
    }
    public function cart_content(Request $request)
    {
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }
    public function cart_remove(Request $request)
    {
        $remove = Cart::instance('shopping')->update($request->id, 0);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }
    public function cart_increment(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty + 1;
        $increment = Cart::instance('shopping')->update($request->id, $qty);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }
    public function cart_decrement(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty - 1;
        $decrement = Cart::instance('shopping')->update($request->id, $qty);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }
    public function cart_count(Request $request)
    {
        $data = Cart::instance('shopping')->count();
        return view('frontEnd.layouts.ajax.cart_count', compact('data'));
    }
    public function mobilecart_qty(Request $request)
    {
        $data = Cart::instance('shopping')->count();
        return view('frontEnd.layouts.ajax.mobilecart_qty', compact('data'));
    }

    public function cart_increment_camp(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty + 1;
        $increment = Cart::instance('shopping')->update($request->id, $qty);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart_camp', compact('data'));
    }
    public function cart_decrement_camp(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty - 1;
        $decrement = Cart::instance('shopping')->update($request->id, $qty);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart_camp', compact('data'));
    }
    public function cart_content_camp(Request $request)
    {
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart_camp', compact('data'));
    }
}
