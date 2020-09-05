<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Product;
use App\Seller;
use App\Transaction;
use App\User;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => Str::random(10),
        'verified' => $verificado = $faker->randomElement([User::VERIFIED_USER, User::UNVERIFIED_USER]),
        'verification_token' => $verificado == User::VERIFIED_USER ? null  : User::verificationTokenGenerator(),
        'admin' => $faker->randomElement([User::VERIFIED_USER, User::UNVERIFIED_USER]),
    ];
});


$factory->define(Category::class, function (Faker\Generator $faker) {
   

    return [
        'name' => $faker->word,
       'description' => $faker->paragraph(1),
    ];
});

$factory->define(Product::class, function (Faker\Generator $faker) {
   

    return [
        'name' => $faker->word,
       'description' => $faker->paragraph(1),
       'quantity' => $faker->numberBetween(1,10),
       'status' => $faker->randomElement([Product::PRODUCT_UNAVAILABLE,Product::PRODUCT_AVAILABLE]),
       'image' => $faker->randomElement(['1.jpg','2.jpg','3.jpg']),
        //'seller_id' => User::inRandomOrder()->first()->id,
        'seller_id' => User::all()->random()->id,
    ];
});

$factory->define(Transaction::class, function (Faker\Generator $faker) {
   #el vendedor no puede comprar sus mismos productos
   $vendedor = Seller::has('products')->get()->random();
   $comprador = User::all()->except($vendedor->id)->random();

    return [
       'quantity' => $faker->numberBetween(1,10),
       'buyer_id'=> $comprador->id,
       'product_id' => $vendedor->products->random()->id
    ];
});