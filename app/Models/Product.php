<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category_id', 'description', 'image_path', 'slug', 'price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'image_path',
    ];

    protected $appends = [
        'image_url'
    ];

    // One-to-Many: One Product has many ProductImage(s)
    public function images() //بدي يرجع الصور للمنتج
    {
        return $this->hasMany(
            ProductImage::class,    // Related (Model) class name المودل اللي رح ترجع من الجدولين
            'product_id',           // F.k. in the realted table (product_images)
            'id'                    // P.K in the current table (products)
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // Many-to-Many: Product belongs to many tags and tags blongs to many products
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,     // Realted model
            'product_tag',  // Pivot table
            'product_id',   // F.K. for current model in pivot table
            'tag_id',       // F.K. for ralted model in pivot table
            'id',           // P.K. in current model
            'id'            // P.K. in related model
        );
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class, 'product_id', 'id');
    }

    public function orders()
    {
        return $this->belongsToMany(
            Order::class,
            'order_items', //تابل وسيط لانو نوع العلاقة ماني تو ماني
            'product_id', //gorgen pivot key
            'order_id', //related pivot key 
            'id', //local key
            'id'
        )
            ->withPivot([
                'price',
                'quantity',
                'product_name'
            ])
            ->using(OrderItem::class)
            ->as('Item');
    }




    public function reviewers()
    {
        return $this->belongsToMany(
            User::class,
            'reviews',
            'product_id',
            'user_id',
            'id',
            'id'
        )->using(Reviews::class);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            if (strpos($this->image_path, 'http://') === 0) {
                return $this->image_path;
            }
            //return asset('storage/' . $this->image_path);
            return Storage::disk('public')->url($this->image_path);
        }

        return 'https://via.placeholder.com/200x200.png?text=No+Image';
    }
    //ميثود الاكسسيور
    //1- لبرودكت مش موجود اساسا
    public function getPermalinkAttribute()
    {
        return route('show', $this->slug);
    }
    //2-لبرودكت موجود فرح تعدل عليه
    //مش رح احط هاي الميثود عشان دايما رح تعرضلي السال برايس وانا بدي البرايس برضك
    /*
    public function getPriceAttribute($value)
    {
        if ($this->sale_price) {
            return $this->sale_price;
        }
        return $value; //هنا معناها رجع البرايس الاصلي لو فشي سال برايس
    }
    */

    //حعمل هاي بدالها
    //كأني اضفت اتربيوت اسمو 
    //purchase_price
    public function getPurchasePriceAttribute()
    {
        if ($this->sale_price) {
            return $this->sale_price;
        }
        return $this->price; //هنا معناها رجع البرايس الاصلي لو فشي سال برايس
    }


    //هادا الكود رح احطو في كومبوننت كرنسي عشان دايما بستخدمو
    /*
    public function geFormattedPurchasePriceAttribute(){
           //حسب لغة الموقع
          $formatter = new NumberFormatter(App::currentLocal(),NumberFormatter::CURRENCY);
          $formatter->formatCurrency($this->purchase_price,'USD');
    }
*/
}
