<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            //ممنوع يحذف كاتجرو تحتيه برودكت >restrictOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            //ممكن يكون null >nullable();
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            //ممنوع تكون قيمته سالبهunsignedFloat(  وبنفع يكون كسر 
            $table->unsignedFloat('price')->default(0);
            $table->unsignedFloat('sale_price')->nullable();
            $table->unsignedInteger('quantity')->default(0);
            $table->enum('status', ['in-stock', 'sold-out'])->default('in-stock');
            $table->string('sku')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
