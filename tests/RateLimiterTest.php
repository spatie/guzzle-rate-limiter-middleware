<?php

namespace Spatie\GuzzleRateLimiterMiddleware\Tests;

use Spatie\GuzzleRateLimiterMiddleware\RateLimiter;

class RateLimiterTest extends TestCase
{
    /** @test */
    public function it_execute_actions_below_a_limit_in_seconds()
    {
        $rateLimiter = $this->createRateLimiter(3, RateLimiter::TIME_FRAME_SECOND);

        $this->assertEquals(0, $this->deferrer->getCurrentTime());

        $rateLimiter->handle(function () {
            $this->deferrer->sleep(100);
        });

        $this->assertEquals(100, $this->deferrer->getCurrentTime());

        $rateLimiter->handle(function () {
            $this->deferrer->sleep(100);
        });

        $this->assertEquals(200, $this->deferrer->getCurrentTime());

        $rateLimiter->handle(function () {
            $this->deferrer->sleep(100);
        });

        $this->assertEquals(300, $this->deferrer->getCurrentTime());

        $this->deferrer->sleep(700);

        $rateLimiter->handle(function () {
            $this->deferrer->sleep(100);
        });

        $this->assertEquals(1100, $this->deferrer->getCurrentTime());

        $rateLimiter->handle(function () {
            $this->deferrer->sleep(100);
        });

        $this->assertEquals(1200, $this->deferrer->getCurrentTime());
    }

    /** @test */
    public function it_defers_actions_when_it_reaches_a_limit_in_seconds()
    {
        $rateLimiter = $this->createRateLimiter(3, RateLimiter::TIME_FRAME_SECOND);

        $this->assertEquals(0, $this->deferrer->getCurrentTime());

        $rateLimiter->handle(function () {
        });

        $this->assertEquals(0, $this->deferrer->getCurrentTime());

        $rateLimiter->handle(function () {
        });

        $this->assertEquals(0, $this->deferrer->getCurrentTime());

        $rateLimiter->handle(function () {
        });

        $this->assertEquals(0, $this->deferrer->getCurrentTime());

        $rateLimiter->handle(function () {
        });

        $this->assertEquals(1000, $this->deferrer->getCurrentTime());
    }

    /** @test */
    public function it_execute_actions_below_a_limit_in_minutes()
    {
        $rateLimiter = $this->createRateLimiter(3, RateLimiter::TIME_FRAME_MINUTE);

        $this->assertEquals(0, $this->deferrer->getCurrentTime());

        $rateLimiter->handle(function () {
            $this->deferrer->sleep(100);
        });

        $this->assertEquals(100, $this->deferrer->getCurrentTime());

        $rateLimiter->handle(function () {
            $this->deferrer->sleep(100);
        });

        $this->assertEquals(200, $this->deferrer->getCurrentTime());

        $rateLimiter->handle(function () {
            $this->deferrer->sleep(100);
        });

        $this->assertEquals(300, $this->deferrer->getCurrentTime());

        $this->deferrer->sleep(59700);

        $rateLimiter->handle(function () {
            $this->deferrer->sleep(100);
        });

        $this->assertEquals(60100, $this->deferrer->getCurrentTime());
    }

    /** @test */
    public function it_defers_actions_when_it_reaches_a_limit_in_minutes()
    {
        $rateLimiter = $this->createRateLimiter(3, RateLimiter::TIME_FRAME_MINUTE);

        $this->assertEquals(0, $this->deferrer->getCurrentTime());

        $rateLimiter->handle(function () {
        });

        $this->assertEquals(0, $this->deferrer->getCurrentTime());

        $rateLimiter->handle(function () {
        });

        $this->assertEquals(0, $this->deferrer->getCurrentTime());

        $rateLimiter->handle(function () {
        });

        $this->assertEquals(0, $this->deferrer->getCurrentTime());

        $rateLimiter->handle(function () {
        });

        $this->assertEquals(60000, $this->deferrer->getCurrentTime());
    }
}
