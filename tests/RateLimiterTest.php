<?php

namespace Spatie\GuzzleRateLimit\Tests;

use Spatie\GuzzleRateLimit\RateLimiter;


class RateLimiterTest extends TestCase
{
    /** @test */
    public function it_executes_actions_when_below_the_limit()
    {
        $rateLimiter = new RateLimiter(10, RateLimiter::TIME_FRAME_MINUTE, $this->timeMachine);

        $this->timeMachine->expectCurrentTimeCalls([
            microtime(true) * 1000,
        ]);

        $handled = false;

        $rateLimiter->handle(function () use (&$handled) {
            $handled = true;
        });

        $this->assertTrue($handled);
    }
}
