<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ApiPingTest extends TestCase
{
    #[Test]
    public function it_returns_pong_from_api_ping(): void
    {
        $response = $this->getJson('/api/ping');

        $response->assertOk()
            ->assertJson(['message' => 'pong']);
    }
}
