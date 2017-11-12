<?php

use App\Models\Game;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Stream::class, function (Faker\Generator $faker) {
    return [
        'stream_id'    => $faker->unique()->randomNumber(),
        'game_id'      => array_rand(Game::active()->get()->modelKeys()),
        'service'      => $faker->title,
        'viewer_count' => $faker->numberBetween(0, 100),
    ];
});
