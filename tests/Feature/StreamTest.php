<?php

namespace Tests\Feature;

use App\Models\Game;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\Models\User;
use App\Models\Stream;

class StreamTest extends TestCase
{
    /** @var  User $user */
    protected $user;

    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');

        /** @var User $user */
        $user = factory(User::class)->create();
        Passport::actingAs($user);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStreamsList()
    {
        /** @var Stream $stream */
        factory(Game::class, 4)->create();
        $stream = factory(Stream::class)->create();

        $response = $this->json('GET', '/api/streams/list');
        $response->assertStatus(200)->assertJson([
            'data' => [
                $stream->game_id => [
                    'game_name' => $stream->game->name,
                    'stream_list' => [
                        $stream->stream_id,
                    ]
                ]
            ]
        ]);
    }
}
