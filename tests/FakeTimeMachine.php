<?php

namespace Spatie\GuzzleRateLimiterMiddleware\Tests;

use Exception;
use Spatie\GuzzleRateLimiterMiddleware\TimeMachine;

class FakeTimeMachine implements TimeMachine
{
    /** @var int */
    protected $currentTime = 0;

    public function getCurrentTime(): int
    {
        return $this->currentTime;
    }

    public function sleep(int $milliseconds)
    {
        $this->currentTime += $milliseconds;
    }
}
