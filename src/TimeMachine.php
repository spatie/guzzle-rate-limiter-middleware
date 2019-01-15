<?php

namespace Spatie\GuzzleRateLimiterMiddleware;

interface TimeMachine
{
    public function getCurrentTime(): int;

    public function sleep(int $milliseconds);
}
