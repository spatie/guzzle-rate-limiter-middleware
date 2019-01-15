<?php

namespace Spatie\GuzzleRateLimiterMiddleware\Tests;

use Spatie\GuzzleRateLimiterMiddleware\RateLimiter;

class RateLimiterMiddlewareTest extends TestCase
{
    /** @test */
    public function it_has_named_constructors_to_create_instances()
    {
        $this->assertInstanceOf(RateLimiter::class, RateLimiter::perSecond(5));

        $this->assertInstanceOf(RateLimiter::class, RateLimiter::perMinute(5));
    }
}