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

$factory->define(Domain\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Domain\Country::class, function (Faker\Generator $faker) {
    $continents = Domain\Continent::all();

    return [
        'name' => $faker->country,
        'continent_id' => $continents->random(1)->id,
        'code' => str_random(2),
    ];
});

$factory->define(Domain\Continent::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->country,
    ];
});

$factory->define(Domain\State::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->country,
        'code' => str_random(5),
    ];
});
