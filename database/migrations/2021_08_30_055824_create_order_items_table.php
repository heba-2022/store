<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //بهمني هان اسم المنتج وسعره
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
           // $table->foreignId('product_id')->constrained('products')->restrictOnDelete();//ممنوع يحذف المنتج
           //واذا حذفو بدي احفظ الاسم قبل



        //لو بدي احفظ الاسم بحيث لو حذفو يضل اسم المنتج 
        //لكن مش رح اقدر ارجعو لنفس صفحة المنتج لو حذفه بس الاسم 
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();//ممنوع يحذف المنتج
           $table->string('product_name');



            $table->unsignedFloat('price');
            $table->unsignedInteger('quantity');

            $table->unique(['order_id','product_id']);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
