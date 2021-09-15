<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id', 'id');
    }

    public function reviewedProducts()
    {
        return $this->belongsToMany(
            Product::class,
            'reviews',
            'user_id',
            'product_id',
            'id',
            'id'
        )->using(Review::class);
    }
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

//with defult 
// أما مع belongto او hasone
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    //البرودكت اللي في السلة 
    public function cartProduct()
    {
        return $this->belongsToMany(Product::class, 'carts') //'carts' جدول وسيط 
            ->using('Cart::class')
            ->withPivot(
                ['id', 'cookie_id', 'quantity']
            )->as('cart');
    }
}
