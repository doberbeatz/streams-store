<?php

namespace App\Http\Controllers;

use App\Http\Repositories\StreamRepository;
use App\Http\Requests\StreamRequest;
use App\Http\Resources\StreamListCollection;
use App\Http\Resources\StreamViewerCounterCollection;
use App\Http\Services\StreamFilter;
use Carbon\Carbon;

class StreamsController extends Controller
{
    protected $streams;

    public function __construct(StreamRepository $streams)
    {
        $this->streams = $streams;
    }

    /**
     * @param StreamRequest $request
     * @return StreamListCollection
     */
    public function getStreamList(StreamRequest $request)
    {
        $request->validate();
        $filter = (new StreamFilter())
            ->setGameIds((array)$request->input('game_id', []))
            ->setPeriod(
                (new Carbon($request->input('period', 'now')))
                    ->second(0)
            )
            ->setPeriodEnd(
                (new Carbon($request->input(
                    'period_end',
                    $request->input('period', 'now')
                )))->second(0)
            );

        return new StreamListCollection(
            $this->streams->getStreamList($filter)
        );
    }

    /**
     * @param StreamRequest $request
     * @return StreamViewerCounterCollection
     */
    public function getViewersCount(StreamRequest $request)
    {
        $request->validate();
        $filter = (new StreamFilter())
            ->setGameIds((array)$request->input('game_id', []))
            ->setPeriod(
                (new Carbon($request->input('period', 'now')))
                    ->second(0)
            )
            ->setPeriodEnd(
                (new Carbon($request->input(
                    'period_end',
                    $request->input('period', 'now')
                )))->second(59)
            );

        return new StreamViewerCounterCollection(
            $this->streams->getViewersCount($filter)
        );
    }
}
