<?php

namespace Tests\Feature;

use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\Models\User;
use App\Models\Stream;

class StreamsListTest extends TestCase
{
    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');
        Passport::actingAs(factory(User::class)->create());
    }

    public function testStructure()
    {
        factory(Game::class, 4)->create()->each(function ($game) {
            factory(Stream::class, 10)->create([
                'game_id' => $game->id,
            ]);
        });

        $response = $this->json('GET', '/api/streams/list');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'game_name',
                    'stream_list',
                ],
            ],
        ]);
    }

    public function testList()
    {
        /** @var Game $game */
        $game = factory(Game::class)->create();
        /** @var Collection $streams */
        $streams = factory(Stream::class, 10)->create([
            'game_id' => $game->id,
        ]);

        $response = $this->json('GET', '/api/streams/list');
        $response->assertJson([
            'data' => [
                $game->id => [
                    'game_name'   => $game->name,
                    'stream_list' => $streams->pluck('stream_id')->toArray(),
                ],
            ],
        ]);
    }

    public function testFilterByGame()
    {
        $gameA = factory(Game::class)->create();
        $gameB = factory(Game::class)->create();

        factory(Stream::class, 2)->create([
            'game_id' => $gameA->id,
        ]);
        factory(Stream::class, 4)->create([
            'game_id' => $gameB->id,
        ]);

        $response = $this->json('GET', '/api/streams/list', [
            'game_id' => $gameA->id,
        ]);
        $response->assertJsonCount(1, 'data');
        $this->assertEquals($gameA->name, reset($response->json()['data'])['game_name']);
    }

    public function testFilterByGames()
    {
        $gameA = factory(Game::class)->create();
        $gameB = factory(Game::class)->create();
        $gameC = factory(Game::class)->create();

        factory(Stream::class)->create([
            'game_id' => $gameA->id,
        ]);
        factory(Stream::class)->create([
            'game_id' => $gameB->id,
        ]);
        factory(Stream::class)->create([
            'game_id' => $gameC->id,
        ]);

        $response = $this->json('GET', '/api/streams/list', [
            'game_id' => [
                $gameA->id,
                $gameB->id,
            ],
        ]);
        $response->assertJsonCount(2, 'data');
    }

    public function testFilterByPeriod()
    {
        $game = factory(Game::class)->create();

        $datetime = (new Carbon())->second(0);
        factory(Stream::class, 2)->create([
            'game_id'  => $game->id,
            'datetime' => $datetime->addMinute(1),
        ]);
        factory(Stream::class, 4)->create([
            'game_id'  => $game->id,
            'datetime' => $datetime->addMinute(1),
        ]);

        $response = $this->json('GET', '/api/streams/list', [
            'period' => $datetime->format('Y-m-d H:i'),
        ]);
        $this->assertCount(4, $response->json()['data'][$game->id]['stream_list']);
    }

    public function testFilterPeriodEnd()
    {
        $game = factory(Game::class)->create();
        $datetime = (new Carbon())->second(0);
        factory(Stream::class, 2)->create([
            'game_id'  => $game->id,
            'datetime' => $datetime->addMinute(1),
        ]);
        factory(Stream::class, 4)->create([
            'game_id'  => $game->id,
            'datetime' => $datetime->addMinute(1),
        ]);
        factory(Stream::class, 6)->create([
            'game_id'  => $game->id,
            'datetime' => $datetime->addMinute(1),
        ]);

        $response = $this->json('GET', '/api/streams/list', [
            'period'     => $datetime->subMinute(1)->format('Y-m-d H:i'),
            'period_end' => $datetime->addMinute(1)->format('Y-m-d H:i'),
        ]);
        $this->assertCount(10, $response->json()['data'][$game->id]['stream_list']);
    }

    public function testEmptyList()
    {
        $response = $this->json('GET', '/api/streams/list');
        $response->assertJsonCount(0, 'data');
    }
}
