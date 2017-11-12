<?php

namespace App\Http\Resources;

use App\Models\Stream;
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
            'data' => $this->collection->map(function ($stream) {
                /** @var Stream $stream */
                return [
                    'name'         => $stream->game->name,
                    'game_id'      => $stream->game->id,
                    'viewer_count' => $stream->viewer_count,
                ];
            }),
        ];
    }
}
