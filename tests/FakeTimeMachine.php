<?php

namespace Spatie\GuzzleRateLimiter\Tests;

use Exception;
use Spatie\GuzzleRateLimiter\TimeMachine;

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
