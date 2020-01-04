<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\City;
use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'address' => $faker->streetAddress,
        'description' => $faker->sentence,
        'city_id' => function(){
            if(City::count() > 0)
                return City::all()->random()->id;
            else
                return factory('App\City')->create()->id;
        }
    ];
});
