<?php

namespace App\Console\Commands;

use App\Services\TwitchClient;
use App\Models\Stream;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StreamsPull extends Command
{
    /** @var string The name and signature of the console command. */
    protected $signature = 'streams:pull';

    /** @var string The console command description. */
    protected $description = 'Pulling streams data from twitch.';

    /** @var  TwitchClient */
    protected $client;

    public function __construct()
    {
        parent::__construct();
        $this->client = new TwitchClient();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $streams = $this->client->getStreams();
        if ($this->insertStreams($streams)) {
            echo count($streams) . ' streams have been added.' . PHP_EOL;
            echo 'Database has been successfully updated.' . PHP_EOL;
        }
    }

    /**
     * @param array $streams
     * @return bool
     */
    protected function insertStreams(array $streams): bool
    {
        $data = [];

        foreach ($streams as $stream) {
            $data[$stream['id']] = [
                'stream_id'    => $stream['id'],
                'game_id'      => $stream['game_id'],
                'service'      => Stream::TWITCH_SERVICE,
                'viewer_count' => $stream['viewer_count'],
                'datetime'     => (new Carbon())->second(0),
            ];
        }

        return Stream::query()->insert($data);
    }
}
