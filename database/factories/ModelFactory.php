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

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'about' => $faker->text,
        'address' => $faker->streetAddress,
        'phone' => $faker->phoneNumber,
        'mobile' => $faker->phoneNumber,
        'birth_date' => $faker->date('Y-m-d'),
        'birth_city' => $faker->city,
    ];
});
