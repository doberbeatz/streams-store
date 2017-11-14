<?php

use App\Models\Game;
use Carbon\Carbon;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Stream::class, function (Faker\Generator $faker) {
    return [
        'stream_id'    => $faker->unique()->randomNumber(),
        'game_id'      => array_random(Game::active()->get()->modelKeys()),
        'service'      => $faker->word,
        'viewer_count' => $faker->numberBetween(0, 100),
        'datetime'     => (new Carbon())->second(0),
    ];
});