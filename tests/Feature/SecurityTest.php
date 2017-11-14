<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\Models\User;

class SecurityTest extends TestCase
{
    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');
    }

    public function testAuthorizedStreamList()
    {
        Passport::actingAs(factory(User::class)->create());

        $response = $this->json('GET', '/api/streams/list');
        $response->assertStatus(200);
    }

    public function testAuthorizedViewerCount()
    {
        Passport::actingAs(factory(User::class)->create());

        $response = $this->json('GET', '/api/streams/viewer-count');
        $response->assertStatus(200);
    }

    public function testUnauthorizedStreamList()
    {
        $response = $this->json('GET', '/api/streams/list');
        $response->assertStatus(401);
    }

    public function testUnauthorizedViewerCountResponse()
    {
        $response = $this->json('GET', '/api/streams/viewer-count');
        $response->assertStatus(401);
    }
}
