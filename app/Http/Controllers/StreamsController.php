<?php

namespace App\Http\Controllers;

use App\Http\Requests\StreamRequest;
use App\Http\Resources\StreamListCollection;
use App\Http\Resources\StreamViewerCounterCollection;
use App\Models\Stream;
use Carbon\Carbon;

class StreamsController extends Controller
{
    /**
     * @param StreamRequest $request
     * @return StreamListCollection
     */
    public function getStreamList(StreamRequest $request)
    {
        $request->validate();

        $streams = Stream::byGameIds((array) $request->input('game_id', []))
            ->betweenDatetime(
                (new Carbon($request->input('period', 'now')))->second(0),
                (new Carbon($request->input(
                    'period_end',
                    $request->input('period', 'now')
                )))->second(0)
            )
            ->select(\DB::raw('DISTINCT stream_id, game_id'))
            ->get();

        return new StreamListCollection($streams);
    }

    /**
     * @param StreamRequest $request
     * @return StreamViewerCounterCollection
     */
    public function getViewerCount(StreamRequest $request)
    {
        $request->validate();
        $streams = Stream::byGameIds((array) $request->input('game_id', []))
            ->betweenDatetime(
                (new Carbon($request->input('period', 'now')))->second(0),
                (new Carbon($request->input(
                    'period_end',
                    $request->input('period', 'now')
                )))->second(0)
            )
            ->select(\DB::raw('game_id, SUM(viewer_count) as viewer_count, datetime'))
            ->groupBy('game_id', 'datetime')
            ->get();

        return new StreamViewerCounterCollection($streams);
    }
}
