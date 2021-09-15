<?php

namespace App\Providers;

use App\Models\Cart;
use App\Repositories\Cart as RepositoriesCart;
use App\Repositories\CartRepository;
use App\View\Components\Currency;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    /*    
        $this->app->bind(CartRepository::class, function ($app) {
            return new RepositoriesCart(); //انتبه لطريقة الكتابة في دقيقة 57Shopping Cart - Part 3
        });
*/

new Currency(10);
        
        //app هو نفسه السيرفس بروفايدر
        //عشان اضيف قيمة في كل الابلكيشن وهذه اشهر الطرق
        // او بالسيرفس كونتينر
        //كل مرة بحتاج الكارت بطلبها من السيرفس كونتينر اللي عملناه
        $this->app->bind('cart',function ($app) {

                $cart = Cart::where('cookie_id',$app->make('cart.id'))->get();
                return $cart;
            }
        );
    

    $this->app->bind('cart.id',function ($app) {
            $cookie_id = Cookie::get('cart_cookie_id');
            if (!$cookie_id) {
                $cookie_id = Str::uuid();
                Cookie::queue('cart_cookie_id', $cookie_id, 60 * 24 * 30);
            }
            return $cookie_id ;
        }
    );
    
        //CartRepository::class حترجع اسم الانترفيس نفسو
  
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Paginator::useBootstrap();
    }
}
