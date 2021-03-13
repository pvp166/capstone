<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ItemType;
use Faker\Generator as Faker;

$factory->define(App\Models\Menu\ItemType::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'resto_id' => 1
    ];
});
