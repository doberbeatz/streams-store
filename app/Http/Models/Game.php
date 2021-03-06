<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property string $name
 *
 * @method static Builder active
 */
class Game extends Model
{
    const TABLE_NAME = 'games';

    /** @var string $table */
    protected $table = self::TABLE_NAME;

    /** @var bool $timestamps */
    public $timestamps = false;

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
