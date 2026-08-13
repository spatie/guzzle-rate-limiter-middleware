<?php

namespace Spatie\GuzzleRateLimiterMiddleware\Tests;

use Spatie\GuzzleRateLimiterMiddleware\Deferrer;

class TestDeferrer implements Deferrer
{
    protected int $currentTime = 0;

    public function getCurrentTime(): int
    {
        return $this->currentTime;
    }

    public function sleep(int $milliseconds): void
    {
        $this->currentTime += $milliseconds;
    }
}
