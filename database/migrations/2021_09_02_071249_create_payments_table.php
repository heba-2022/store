<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->unsignedFloat('amount'); // كام قيمة الدفعة كانت المفترض تكون نفس قيمة الاردر
            $table->string('method'); //طريقة الدفع باي بال - فيزا ......
            $table->json('payload'); // تفاصيل الدفع كلها اخزنها على شكل جيسون لانو كل طريقة لها شكل في الداتا
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
        Schema::dropIfExists('payments');
    }
}
