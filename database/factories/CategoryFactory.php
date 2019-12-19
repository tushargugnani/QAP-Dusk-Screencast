<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {

    $iconArray = array('fa fa-cutlery', 'fa fa-scissors', 'fa fa-laptop', 'fa fa-briefcase', 'fa fa-glass', 'fa fa-shopping-bag');
    return [
        'name' => $faker->unique()->word,
        'icon' => $iconArray[array_rand($iconArray)]
    ];
});
