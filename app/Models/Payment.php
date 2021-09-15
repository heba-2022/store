<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'amount', 'method', 'payload'];

    protected $casts = [
        'payload' => 'json'
    ];
    public function order()
    {
        //العلاقة انو هذا البيمنت تابع للاوردر هادا 
        //هيا ممكن تكون ون تو ون لكن احنا حنخليها ون تو ماني لانو ممكن يكون اكثر من بيمنت للوردرر يعني يدفع على دفعات
        return   $this->belongsTo(Order::class);
    }
}
