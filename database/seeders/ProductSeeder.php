<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('products')->insert([
        //     'code' => '67860',
        //     'nama' => 'laptop',
        //     'stock' => '6',
        //     'varian' => 'exclusive',
        //     'keterangan' => 'masih ada',
        // ]);
        $faker = Faker::create();
        foreach (range(1, 100) as $value) {
            DB::table('products')->insert([
                'code' => $faker->unique()->randomNumber,
                'nama' => $faker->sentence(5),
                'stock' => $faker->randomDigit,
                'varian' => $faker->text(10),
                'keterangan' => $faker->paragraph(10),
                'created_at' => $faker->dateTimeBetween('-2 years', 'now'),
                'category_id' => rand(1, 7),
                'harga' => $faker->numberBetween(50000, 5000000),
                'image' => $faker->numberBetween(1, 12) . '.jpg',
            ]);
        }
    }
}
