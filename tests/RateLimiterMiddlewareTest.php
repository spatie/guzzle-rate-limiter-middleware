<?php

namespace Spatie\GuzzleRateLimiterMiddleware\Tests;

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
}
