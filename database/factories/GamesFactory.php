<?php

use App\Models\Game;
use Carbon\Carbon;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Game::class, function (Faker\Generator $faker) {
    return [
        'id'        => $faker->unique()->randomNumber(),
        'name'      => $faker->firstName,
        'is_active' => 1,
    ];
});