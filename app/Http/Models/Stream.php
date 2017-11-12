<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $stream_id
 * @property string $game_id
 * @property Game $game
 * @property string $service
 * @property int $viewer_count
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @method static Builder|self byGameIds(array $gameIds)
 * @method static Builder|self betweenDatetime(\DateTime $from, \DateTime $to)
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

    /**
     * @param Builder $query
     * @param array $gameIds
     * @return Builder|self
     */
    public function scopeByGameIds($query, array $gameIds)
    {
        if (empty($gameIds)) {
            return $query;
        }

        return $query->whereIn('game_id', $gameIds);
    }

    /**
     * @param Builder $query
     * @param \DateTime $from
     * @param \DateTime $to
     * @return Builder|self
     */
    public function scopeBetweenDatetime($query, \DateTime $from, \DateTime $to)
    {
        return $query->whereBetween('created_at', [$from, $to]);
    }
}
