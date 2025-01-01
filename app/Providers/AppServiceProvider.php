<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\GeneralSetting;
use App\Models\Category;
use App\Models\SocialMedia;
use App\Models\Contact;
use App\Models\CreatePage;
use App\Models\OrderStatus;
use App\Models\EcomPixel;
use App\Models\GoogleTagManager;
use App\Models\CouponCode;
use App\Models\Order;
use Config;
use Session;
use Cache;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        view()->composer('*', function ($view) {

         $generalsetting = Cache::remember('generalsetting', now()->addDays(7), function () {
            return GeneralSetting::where('status', 1)->first();
         });

         $coupon = Cache::remember('coupon', now()->addDays(7), function () {
            return CouponCode::where('status', 1)->first();
         });

         $contact = Cache::remember('contact', now()->addDays(7), function () {
            return Contact::where('status', 1)->first();
         });

         $socialicons = Cache::remember('socialicons', now()->addDays(7), function () {
            return SocialMedia::where('status', 1)->get();
        });

         $pages = Cache::remember('pages', now()->addDays(7), function () {
            return CreatePage::where('status', 1)->get();
         });

        $orderstatus = Cache::remember('orderstatus', now()->addDays(7), function () {
            return OrderStatus::where('status', 1)->get();
         });

        $pixels = Cache::remember('pixels', now()->addDays(7), function () {
            return EcomPixel::where('status', 1)->get();
         });
        
        $gtm_code = Cache::remember('gtm_code', now()->addDays(7), function () {
            return GoogleTagManager::get();
         });

        $categories = Category::where('status', 1)->select('id', 'name', 'slug', 'status', 'image')->get();
        $neworder = Order::where('order_status', '1')->count();
        $pendingorder = Order::where('order_status', '1')->latest()->limit(9)->get();

           $view->with([
                'generalsetting' => $generalsetting,
                'coupon' => $coupon,
                'categories' => $categories,
                'contact' => $contact,
                'socialicons' => $socialicons,
                'pages' => $pages,
                'neworder' => $neworder,
                'pendingorder' => $pendingorder,
                'orderstatus' => $orderstatus,
                'pixels' => $pixels,
                'gtm_code' => $gtm_code,
            ]);

        });
    }
}

