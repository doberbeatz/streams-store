<?php

namespace App\Http\Controllers;

use App\Models\Game;

class GamesController extends Controller
{
    public function getList()
    {
        return Game::get();
    }
}
