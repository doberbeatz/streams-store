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
    public function getStreamList(StreamFilter $filter = null)
    {
        $query = $this->model->query()
            ->select(\DB::raw('DISTINCT stream_id, game_id'));

        $filter->getGameIds() && $query->whereIn('game_id', $filter->getGameIds());

        return $query->get()
            ->mapToGroups(function ($item, $key) {
                /** @var Stream $item */
                return [$item->game->name => $item->stream_id];
            });
    }

    /**
     * @param StreamFilter|null $filter
     * @return Collection
     */
    public function getViewersCount(StreamFilter $filter = null)
    {
        $query = $this->model->query()
            ->select(\DB::raw('MAX(viewer_count) as viewer_count, game_id'));

        return $query->groupBy('game_id')->get()
            ->map(function ($stream) {
                return [$stream->game->name => $stream->viewer_count];
            });
    }
}