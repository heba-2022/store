<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            //>nullOnDelete() بحتفظ في بيانات الطلبات لامور احصائية للموقع
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            //فاتورة الكترونية 
            //عرفت النيم تاني عشان لو اليوزر مش مسجل او بدو يغير البيانات
            //حتى لو انحذف اليوزر المعلومات موجودة
            //ممكن اللي بدو يدفع غير الي بدو يستقبل الشحن

            $table->string('billing_firstname');
            $table->string('billing_lastname');
            $table->string('billing_email');
            $table->string('billing_phone');
            $table->string('billing_address');
            $table->string('billing_city');
            $table->string('billing_postalcode');
            $table->char('billing_country',2);


            $table->string('shipping_firstname')->nullable();
            $table->string('shipping_lastname')->nullable();
            $table->string('shipping_email')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_postalcode')->nullable();
            $table->char('shipping_country',2)->nullable();


            //حالة الاوردر
            //ممكن نعمل تابل واليوزر اللي يضيف الحالة
            $table->enum('status',['pending','processing','cancelled','shipped','delivered']);

            //حالة الدفع
            $table->enum('payment_status',['pending','paid','faield']);



            //لو بدي اعرف من وين اجت اضيف ......
            $table->unsignedFloat('tax')->default(0); //الضريبة
            $table->unsignedFloat('discount')->default(0);//خصم
            $table->unsignedFloat('total')->default(0); //مجموع الاوردر

            //ابعد هنا عن قصة الريلاشن واحط ككولم
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
        Schema::dropIfExists('orders');
    }
}
