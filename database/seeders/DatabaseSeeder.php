<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        
        //لازم المودل يكون عامل 
        //has Facroty عشان اقدر استعملو 
        //لتنفيذ الفاكتوري
  //  Category::factory(19)->create();

       Product::factory(199)->create();
       //Tag::factory(15)->create();

        //هنا بستدعي السيدر عشان انفذو
     //   $this->call(CategoriesTableSeeder::class);

     /*
     Category::factory(10)
        ->has(Category::factory(5)
              ->has(Product::factory(15),'products')
              ,'children')
        ->create();
*/

    }
}
