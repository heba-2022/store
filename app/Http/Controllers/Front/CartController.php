<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CartController extends Controller
{

    /**
     * @var \App\Repositories\CartRepository
     */
    /*
    protected $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }
    */
    //الفساد  بترجع اوبجكت موجود في السيرفس كونتينتر
    //والميثود بتكون داخل الاوبجكت مش الفسا\د

    //بدي اخزن الكارد في السيرفس كونتينر
    //السيرفرس كونتينر هو انسب مكان اني اوصلو من كل مكان 
    // بسجل متغير 
    //سيرفس كونتينر- )(مخزن بحط فيه فاريبر او اوبجكت بوصلو في كل مكان)
    //سيرفس بروفايدر غير عن بعض  (البروفايدر انو اشي يتنفذ مع كل ريكويست لعملية البوت سترا)
    //دقيقة Shopping Cart - Part 3 36

    //public function index(CartRepository $cart)
    public function index()
    {


        //$cart is collection اهتم فيها وبالعمليات اللي عليها 
        //  $cart = Cart::where('cookie_id', $this->getCookieId())->get();

        //كل مرة بحتاج الكارت بطلبها من السيرفس كونتينر اللي عملناه
        $cart = app('cart');

      //$cart = App::make(CartRepository::class);


        //return $cart;
        //item بمثل عنصر جوا الكوكلش الكارد
         $total = $cart->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
        return view('front.products.cart', [
            'cart' => $cart, //$this->cart->all();
            'total' => $total, //$this->cart->total();
        ]);
    }

    /**
     * Store a  newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'product_id' => 'required|int|exists:products,id',
            'quantity' => 'int|min:1|max:10',
        ]);
        /*  
        $cart = Cart::where([
            'cookie_id' => $this->getCookieId(),
            'product_id' => $request->input('product_id'),
        ])->first();


        if($cart){
           $cart->update([
            'user_id' => Auth::id(),
            'quantity' => $cart->quantity + $request->input('quantity', 1),
               ] );
        }
        else{
        $cart = Cart::create([
            'id' => Str::uuid(),
            'cookie_id' => $this->getCookieId(),
            'user_id' => Auth::id(),
            'product_id' => $request->input('product_id'),
            'quantity' => $request->input('quantity', 1),
        ]);}
*/

        //هنا بدل اللي فوق
        Cart::updateOrcreate(
            [
                'cookie_id' => app('cart.id'),
                'product_id' => $request->input('product_id'),
            ],
            [
                'id' => Str::uuid(),
                'user_id' => Auth::id(),
                'quantity' => DB::raw('quantity +' . $request->input('quantity', 1)),
            ]
        );


         // //$item = $this->cart->add($request->input('product_id'), $request->input('quantity', 1));
        return redirect()->back()->with('success', 'product added to cart');
    }


    /*
    //بقرأها في الريكوست
    //ببعتها في الريبلاي
    protected function getCookieId()
    {

        $cookie_id = Cookie::get('cart_cookie_id');

        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_cookie_id', $cookie_id, 60 * 24 * 30);
        }
        return $cookie_id;
    }
    */
}
