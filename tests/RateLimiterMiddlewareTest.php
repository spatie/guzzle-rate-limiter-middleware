<?php

namespace Spatie\GuzzleRateLimiterMiddleware\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Spatie\GuzzleRateLimiterMiddleware\InMemoryStore;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiterMiddleware;

class RateLimiterMiddlewareTest extends TestCase
{
    /** @test */
    public function it_has_named_constructors_to_create_instances()
    {
        $this->assertInstanceOf(
            RateLimiterMiddleware::class,
            RateLimiterMiddleware::perSecond(5)
        );

        $this->assertInstanceOf(
            RateLimiterMiddleware::class,
            RateLimiterMiddleware::perMinute(5)
        );
    }

    /** @test */
    public function it_defers_requests_sent_through_a_guzzle_client()
    {
        $stack = HandlerStack::create(new MockHandler([
            new Response(200),
            new Response(200),
            new Response(200),
            new Response(200),
        ]));

        $stack->push(RateLimiterMiddleware::perSecond(3, new InMemoryStore(), $this->deferrer));

        $client = new Client(['handler' => $stack]);

        for ($i = 0; $i < 3; $i++) {
            $this->assertEquals(200, $client->get('https://spatie.be')->getStatusCode());
        }

        $this->assertEquals(0, $this->deferrer->getCurrentTime());

        $client->get('https://spatie.be');

        $this->assertEquals(1000, $this->deferrer->getCurrentTime());
    }
}
