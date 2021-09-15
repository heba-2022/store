<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema is facade class عشان هيك بقدر استخدمها باسمها ولها alice
        //categories اسم التابل
        Schema::create('categories', function (Blueprint $table) {
            //داخل الفنكشن بعرف ال attribute

            //$table->id();==id bigint unsigned auto_increment primary key
            //النوع ثم الاسم بالداخل
            // $table->id();==$table->bigInteger('id')->unsigned()->autoIncrement()->primary();
            $table->id();

            //nullable(); عشان الكاتجرو الرئيسي ماالو اب
            //parent_id بدل ما اعمل جدول لل subCatigory
            $table->unsignedBigInteger('parent_id')->nullable();


            $table->foreign('parent_id')->references('id')->on('categories')->nullOnDelete();

            //cascadeOnDelete()->cascade on delete-> معناها لو حذفت الكاتجرو الاب رح ينحذفو كل الابناء
            //nullOnDelete();->null on delete ->معناها انو لو حذفت الاب الابناء رح يصير الاب تبعهم نل 
            //restrictOnDelete() -> is defult معناها يمنع الحذف للاب اذا كان هناك ابناء


            //string = varchar(255) لا يحجز 255 فقط يسمح اكثر اشي ب 255
            //char(255) بحجز ال255 فبتروح المساحة
            $table->string('name', 100);

            //slug ->معناها انو بحط هذا الاشي في الرابط تبع الURL
            //unique() -> لا يمكن ان يكون null
            $table->string('slug')->unique();

            //nullable يعني ممكن يكون null
            $table->text('description')->nullable();

            //nullable يعني ممكن يكون null (opthinal)
            $table->string('image_path')->nullable();

            //enum ->حقل قيمه لازم تكون محددة  اما كذا او كذا ة
            //status اسم الحقل
            // active','inactive ->القيم الممكنة للحقل 
            //default value ->active
            $table->enum('status', ['active', 'inactive'])->default('active');


            //create_at timestamp null
            //update_at timestamp null
            //$table->timestamps();== $table->timestamps('create_at')->nullable();

            $table->timestamps(); ///==create_at timestamp null and update_at timestamp null


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
