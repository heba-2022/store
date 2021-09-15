<?php

namespace App\View\Components;

use App\Models\Cart;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\Component;
use Illuminate\Support\Str;
class CartMenu extends Component
{
    public $cart;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Cart $cart)
    {
        //
        $cart = Cart::where('cookie_id', $this->getCookieId())->get();

        $this->cart = $cart;
        

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

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.cart-menu');
    }
}
