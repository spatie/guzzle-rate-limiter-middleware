<?php

namespace Spatie\GuzzleRateLimiterMiddleware;

class SleepDeferrer implements Deferrer
{
    public function getCurrentTime(): int
    {
        return round(microtime(true) * 1000);
    }

    public function sleep(int $milliseconds)
    {
        usleep($milliseconds * 1000);
    }
}
