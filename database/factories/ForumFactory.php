<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/** @var $factory */

$factory->define(App\Thread::class, function (Faker $faker) {
    return [
        'user_id'      => function() {
            return App\User::all()->random()->id;
        },
        'channel_id'    => function() {
            return App\Channel::all()->random()->id;
        },
        'title'     => $faker->sentence,
        'body'      => $faker->paragraph,
    ];
});

$factory->define(App\Reply::class, function (Faker $faker) {
    return [
        'user_id'      => function() {
            return App\User::all()->random()->id;
        },
        'thread_id'      => function() {
            return App\Thread::all()->random()->id;
        },
        'body'      => $faker->paragraph,
    ];
});
$factory->define(App\Channel::class, function (Faker $faker) {
    $name = $faker->word;
    return [
        'name'  => $name,
        'slug'  => $name,
    ];
});


