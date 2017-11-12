<?php

namespace Tests\Feature;

use Laravel\Passport\Passport;
use Tests\TestCase;
use App\Models\User;
use App\Models\Stream;

class StreamTest extends TestCase
{
    protected $user;

    protected function setUp()
    {
        parent::setUp();

        /** @var User $user */
        $user = factory(User::class)->make();
        Passport::actingAs($user);
    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStreamsList()
    {
        $stream = factory(Stream::class)->create();

        $response = $this->json('GET', '/api/streams/list');

        $response->assertStatus(200)->assertJson($stream);
    }
}
