<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Category extends Model
{
    use HasFactory;

    //هنا تسمية المتغيرات لازم التزم فيها لانو غير هيك الارفل مارح تتعرف عليهم 
    //هنا كل القيم هيا الديفولت لكن كتبتهم عشان لو بدي اغيرهم 
    //لو بدي اغير بدل  created at  and update at باسما0ء ثانية
    const CREATE_AT = "created_at";
    const UPDATE_AT = "updated_at";
    //جميع القيم protected 
    //ماعدا $incrementing  and  $timestamps

    //لو ما استخدكت الطلبيعي اللي الارفل فاهمو لازم اوضح هذه الامور
    //الارفل افتراضي بحكي انو المودل سنجل والتابل جمع فبربطهم ببعض لكن لو كان اسماء مختلفة
    protected $table = 'categories';
    protected $connection = 'mysql';
    //الارفل افتراضي بعتبر الاي دي برايمري لكن لو غيرت لازم اعمل هيك
    protected $primaryKey = 'id';
    //الارفل افتراضي بعمل البرايمي انو انتجر لكن لو غيرت بعمل هيك
    protected $keyType = 'int';
    //لو عاملة حقل قيمته مش اوتو انكرمت لازم اوقف الخاصية
    public $incrementing = true;
    //لو ماضفت في الجدول خاصية ال timestamp
    //لو مابدي اياها بحطها فولس
    public $timestamps = true;
    //هنا بحكي للارفل اني بسمح انك تعمل كرييت من هدول الخصائص وتخزنهم لو ماكتبت هيك مش رح يقبل يخزنهم
    protected $fillable =
    ['name', 'parent_id', 'description', 'status', 'slug', 'image_path'];
    //كيف اعبي الجدول ببيانات مسبقة ؟
    //seeder ملف


    //accer method
    //انتبه لطريقة الكتابة معهمة جدا  
    // get...Attribute
    // $model->image_url == ImageUrl هذا اسم الميثود في النص
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            //return asset('storage/' . $this->image_path);
            //عشان استخدم ال storage صح
            //لازم يكون ملف  env APP_URL=http://localhost:8000
            return Storage::disk('public')->url($this->image_path);
        }
        return 'https://via.placeholder.com/250x250.png?text=NoImage';
    }


    

    // ألعلاقات 

    //1- 1 to many - > hasMany   مثل    )( الكتتجوري هاز ماني برودكت)
    //2- many to many -> belongTo many    مثل  )( الاوردر هاز مني برودكت - و البرودكت هاز مني اوردر)
   //العلاقة الثانية تحتاج تابل وسيط مثل البايفت ت تابل
    //3- many to one -> belongisTo   مثل )(الكاتجرو له واحد بارينت)
    
    
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id','id');
    }

    public function parent()
    {
        //withDefault عشان لو فشي بارينت
        return $this->belongsTo(Category::class, 'parent_id', 'id')->withDefault([
            'name' => 'No Parent'
        ]);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

}
