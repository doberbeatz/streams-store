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

class StreamsViewerCountTest extends TestCase
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

        $response = $this->json('GET', '/api/streams/viewer-count');
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'game_name',
                    'viewer_count_list' => [
                        '*' => [
                            'time',
                            'viewer_count',
                        ],
                    ],
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

        $response = $this->json('GET', '/api/streams/viewer-count');
        $response->assertJson([
            'data' => [
                $game->id => [
                    'game_name'         => $game->name,
                    'viewer_count_list' => [
                        [
                            'time'         => $streams->first()->datetime->format(\DateTime::W3C),
                            'viewer_count' => array_sum(
                                $streams->pluck('viewer_count')->toArray()
                            ),
                        ],
                    ],
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

        $response = $this->json('GET', '/api/streams/viewer-count', [
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

        $response = $this->json('GET', '/api/streams/viewer-count', [
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
        /** @var Collection $streams */
        $streams = factory(Stream::class, 4)->create([
            'game_id'  => $game->id,
            'datetime' => $datetime->addMinute(1),
        ]);

        $response = $this->json('GET', '/api/streams/viewer-count', [
            'period' => $datetime->format('Y-m-d H:i'),
        ]);
        $this->assertCount(1, $response->json()['data'][$game->id]['viewer_count_list']);
        $this->assertEquals(
            $datetime->format(\DateTime::W3C),
            reset($response->json()['data'][$game->id]['viewer_count_list'])['time']
        );
        $this->assertEquals(
            $streams->pluck('viewer_count')->sum(),
            reset($response->json()['data'][$game->id]['viewer_count_list'])['viewer_count']
        );
    }

    public function testFilterPeriodEnd()
    {
        $game = factory(Game::class)->create();
        $datetime = (new Carbon())->second(0);
        factory(Stream::class, 2)->create([
            'game_id'  => $game->id,
            'datetime' => $datetime->addMinute(1),
        ]);
        $streamsB = factory(Stream::class, 4)->create([
            'game_id'  => $game->id,
            'datetime' => $datetime->addMinute(1),
        ]);
        $streamsC = factory(Stream::class, 6)->create([
            'game_id'  => $game->id,
            'datetime' => $datetime->addMinute(1),
        ]);

        $response = $this->json('GET', '/api/streams/viewer-count', [
            'period'     => $datetime->subMinute(1)->format('Y-m-d H:i'),
            'period_end' => $datetime->addMinute(1)->format('Y-m-d H:i'),
        ]);
        $this->assertCount(2, $response->json()['data'][$game->id]['viewer_count_list']);
        $this->assertEquals(
            $datetime->subMinute(1)->format(\DateTime::W3C),
            $response->json()['data'][$game->id]['viewer_count_list'][0]['time']
        );
        $this->assertEquals(
            $datetime->addMinute(1)->format(\DateTime::W3C),
            $response->json()['data'][$game->id]['viewer_count_list'][1]['time']
        );
        $this->assertEquals(
            $streamsB->pluck('viewer_count')->sum(),
            $response->json()['data'][$game->id]['viewer_count_list'][0]['viewer_count']
        );
        $this->assertEquals(
            $streamsC->pluck('viewer_count')->sum(),
            $response->json()['data'][$game->id]['viewer_count_list'][1]['viewer_count']
        );
    }

    public function testEmptyData()
    {
        $response = $this->json('GET', '/api/streams/viewer-count');
        $response->assertJsonCount(0, 'data');
    }
}
