<?php

namespace App\Http\Resources;

use App\Models\Game;
use Illuminate\Http\Resources\Json\Resource;

/**
 * @see \App\Models\Stream
 * @property string $stream_id
 * @property Game $game
 * @property string $service
 * @property int $viewer_count
 */
class StreamList extends Resource
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
            'stream_id'    => $this->stream_id,
            'game'         => $this->game->name,
            'service'      => $this->service,
            'viewer_count' => $this->viewer_count,
        ];
    }
}
