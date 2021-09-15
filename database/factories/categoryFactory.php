<?php

namespace Database\Factories;

use App\Models\Category;
use Doctrine\Inflector\Rules\Word;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class categoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    //تحديد المودل1-
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $faker = \Faker\Factory::create();
$faker->addProvider(new \Bezhanov\Faker\Provider\Commerce($faker));


        $name =  $faker->department(1);//$this->faker->words(2,true);
        $status = ['active','inactive'];
        //STR -. بتجول الاسماء الى اشكال  غير لكن مطابقة
        return [

            //faker -> بترجع بيانات بشكل عشوائي
            'name' =>$name,
            'slug' => Str::slug($name),
            //هات بينات عشوائية من الكاتيجرو
            'parent_id' => Category::inRandomOrder()->limit(1)->first()->id,
            'status' => $status[random_int(0,1)],
            //برجع بشكل عشوائي روابط لصور
            'image_path'=>$this->faker->imageurl(),
            'description'=>$this->faker->words(200,true),
            //
        ];
    }
}
