<?php

namespace App\Http\Repositories;

use App\Http\Services\StreamFilter;
use App\Models\Stream;
use Illuminate\Database\Eloquent\Collection;

class StreamRepository
{
    /** @var  Stream */
    protected $model;

    public function __construct()
    {
        $this->model = new Stream();
    }

    /**
     * @param StreamFilter|null $filter
     * @return Collection
     */
    public function getStreamList(StreamFilter $filter)
    {
        return $this->model
            ->byGameIds($filter->getGameIds())
            ->betweenDatetime($filter->getPeriod(), $filter->getPeriodEnd())
            ->select(\DB::raw('DISTINCT stream_id, game_id'))
            ->get();
    }

    /**
     * @param StreamFilter|null $filter
     * @return Collection
     */
    public function getViewersCount(StreamFilter $filter)
    {
        return $this->model
            ->byGameIds($filter->getGameIds())
            ->betweenDatetime($filter->getPeriod(), $filter->getPeriodEnd())
            ->select(\DB::raw('MAX(viewer_count) as viewer_count, game_id'))
            ->groupBy('game_id')
            ->get();
    }
}