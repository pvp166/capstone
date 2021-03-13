<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Menu\MenuItem;
use Faker\Generator as Faker;

$factory->define(App\Models\Menu\MenuItem::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker -> paragraph(2,true),
        'price' => $faker->numberBetween(99,999),
        'item_type_id' => 1
    ];
});
