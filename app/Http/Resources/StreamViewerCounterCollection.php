<?php

namespace App\Http\Resources;

use App\Models\Stream;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StreamViewerCounterCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection
                ->groupBy('game_id')
                ->map(function ($gameCollection) {
                    /** @var Collection $gameCollection */
                    return [
                        'game_name'         => $gameCollection->first()->game->name,
                        'viewer_count_list' => $gameCollection->map(function ($stream) {
                            /** @var Stream $stream */
                            return [
                                'time'         => $stream->datetime->format(\DateTime::W3C),
                                'viewer_count' => (int) $stream->viewer_count,
                            ];
                        }),
                    ];
                }),
        ];
    }
}
