<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $user = User::factory()->make([
            'name' => 'Abigail Otwell',
            'email' => 'whateber@dksljfds.com'
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
