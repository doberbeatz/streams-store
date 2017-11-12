<?php

namespace App\Http\Resources;

use App\Models\Stream;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StreamListCollection extends ResourceCollection
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
                ->mapToGroups(function ($stream) {
                    /** @var Stream $stream */
                    return [$stream->game->name => $stream->stream_id];
                }),
        ];
    }
}
