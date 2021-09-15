<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')
        ->insert([
            'name' => 'Category 1',
            'slug' => 'category-1',
            'parent_id' => null,
        ]);

        Category::create([
            'name' => 'Category 2',
            'slug' => 'category-2',
            'parent_id' => 1,
        ]);    }
}
