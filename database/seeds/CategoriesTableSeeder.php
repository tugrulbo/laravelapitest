<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker\Generator $faker)
    {
        #DB::table('categories')->truncate();
        Category::truncate();
        
        for($i=0; $i<30; $i++){

            $category_name = rtrim($faker->sentence(1),".");

            Category::create([
                'name'=> $category_name,
                'slug'=> Str::slug($category_name)
            ]);
        }
    }
}
