<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

//لمى استخدمو كوسيط لازم اعملو بايفت
//ألفرق بين بايفت و مودل
//Pivot كل الحقول فالابل 
//وdisaple for increment
class OrderItem extends Pivot
{
    use HasFactory;

    public $incrementing = true;
    //البايفت رح تفترض اسم التابل بدون اس فاحنا بنأكد اسم التابل هنا 
   protected $table = 'order_items';
   public $timestamps = false;

  //order_item  
    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault();
    }
}
