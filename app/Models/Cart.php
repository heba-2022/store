<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;

class Cart extends Pivot
{
    //جدول وسيط بين اليوزر و المنتج
    use HasFactory;
    protected $table = 'carts';
    protected $keyType = 'string';

    protected static function booted(){
        static::creating( //ألفنكشن اللي رح تتنفذ عند حدوث الايفنت
            function(Cart $cart){
                //كل مرة لمى بعمل كريت للكارت بعمل الاي دي هان
               $cart->id = Str::uuid();
            });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        //عشان لو فشي يوزر اي دي 
        //withDefault();
        return $this->belongsTo(User::class)->withDefault();
    }



}
