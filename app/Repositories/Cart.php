<?php


namespace App\Repositories;

use App\Models\Cart as CartModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class Cart implements CartRepository{

    protected $items;

    public function __construct()
    {
        $this->items = collect([]);
        $this->all();
    }


    public function all(){

        if(!$this->items->count()){
            $this->items= CartModel::where('cookie_id',$this->getCartId())->get();
        }
        return $this->items;

    }
 
    function add($itam,$quantity=1){

           //هنا بدل اللي فوق
           $cart = CartModel::updateOrcreate(
            [
                'cookie_id' => $this->getCartId(),//app('cart.id'),
                'product_id' => $itam,
            ],
            [
                'id' => Str::uuid(),
                'user_id' => Auth::id(),
                'quantity' => DB::raw('quantity +' . $quantity),
            ]
        );
        $this->items->push($cart);
        return $cart;
    }

    function total(){
        return $this->all()->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }

    function empty(){
        CartModel::where('cookie_id',$this->getCartId())->delete();

    }

    protected function getCartId(){
        $cookie_id = Cookie::get('cart_cookie_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            Cookie::queue('cart_cookie_id', $cookie_id, 60 * 24 * 30);
        }
        return $cookie_id ;
     }



}
?>