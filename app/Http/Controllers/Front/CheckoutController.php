<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Throwable;
use Symfony\Component\Intl\Countries;

class CheckoutController extends Controller
{
    public function create()
    {
        //د3 Shopping Cart - Part 4
        $cart = Cart::where('cookie_id', $this->getCookieId())->get();

        return view('front.products.checkout', [
            'cart' => $cart,
            'user' => Auth::check() ? Auth::user() : new User(),
            'countries' => Countries::getNames(App::currentLocale()),
        ]);
    }



    public function store(Request $request)
    {
        
        //د3 Shopping Cart - Part 4
        $cart = Cart::where('cookie_id', $this->getCookieId())->get();

            $request->validate([
                'billing_firstname'=> 'required',
                'billing_lastname'=> 'required',
                'billing_email'=> 'required|email',
                'billing_phone'=> 'required',
                'billing_address'=> 'required',
                'billing_city'=> 'required',
                'billing_postalcode' => 'required',
                'billing_country'=> 'required',
                ]);
                
             $request->merge([
                 'user_id'=>Auth::id(),
                //  'total' =>this->cart->total(), //repository
                 'total' => $this->total(),
             ]);

             //database اكثر من عملية على الداتا بيس في نفس الريكويست اسمو
             //اسموdatabase  transaction
             //معناها بدي تتنفذ كلها مرة وحدة لو صار فشل كلهم يفشلو
             //relation item
          
             DB::beginTransaction();
             try{
             //1-انشاء الاوردر
             $order = Order::create($request->all());
             //2-انشاء عناصر الاوردر
             foreach($cart as $item){
                   $order->items()->create([
                       'product_id' => $item->product_id,
                       'product_name' => $item->product->name,
                       'price' =>$item->product->purchase_price,
                       'quantity' =>$item->quantity,
                   ]);
             }

             //3-حذف عناصر السلة
             //ألمفروض من الريبوسيتري
             Cart::where('cookie_id',$this->getCookieId())->delete();

             DB::commit();

            }
            catch(Throwable $e){
                DB::RollBack();
                throw $e;
            }
            //المفروض ارجعو لصفحة الدفع
            return Redirect::route('home');

    }

    public function total(){

        $cart = Cart::where('cookie_id', $this->getCookieId())->get();
        return $cart->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
      }

    protected function getCookieId()
    {
        $cookie_id = Cookie::get('cart_cookie_id');

        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_cookie_id', $cookie_id, 60 * 24 * 30);
        }
        return $cookie_id;
    }
    


  
}
