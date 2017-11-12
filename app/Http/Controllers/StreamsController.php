<?php

namespace App\Http\Controllers;

use App\Http\Repositories\StreamRepository;
use App\Http\Requests\StreamRequest;
use App\Http\Services\StreamFilter;

class StreamsController extends Controller
{
    protected $streams;

    public function __construct(StreamRepository $streams)
    {
        $this->streams = $streams;
    }

    /**
     * @param StreamRequest $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getStreamList(StreamRequest $request)
    {
        $request->validate();

        $filter = (new StreamFilter())
            ->setGameIds((array) $request->input('game_id', []))
            ->setPeriodFrom(new \DateTime($request->input('period_from', 'now')))
            ->setPeriodTo(new \DateTime($request->input('period_to', 'now')));

        return $this->streams->getStreamList($filter);
    }

    /**
     * @param StreamRequest $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getViewersCount(StreamRequest $request)
    {
        $request->validate();

        $filter = new StreamFilter();

        return $this->streams->getViewersCount($filter);
    }
}
