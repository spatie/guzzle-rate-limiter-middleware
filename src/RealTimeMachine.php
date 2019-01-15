<?php

namespace Spatie\GuzzleRateLimiterMiddleware;

class RealTimeMachine implements TimeMachine
{
    public function getCurrentTime(): int
    {
        return round(microtime(true) * 1000);
    }

    public function sleep(int $milliseconds)
    {
        sleep($milliseconds / 1000);
    }
}
