<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $stream_id
 * @property string $game_id
 * @property Game $game
 * @property string $service
 * @property int $viewer_count
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Stream extends Model
{
    const TABLE_NAME = 'streams';
    const TWITCH_SERVICE = 'twitch';

    /** @var string $table */
    protected $table = self::TABLE_NAME;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    protected function game()
    {
        return $this->hasOne(Game::class, 'id', 'game_id');
    }
}
