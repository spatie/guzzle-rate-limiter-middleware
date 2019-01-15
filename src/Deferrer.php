<?php

namespace Spatie\GuzzleRateLimiterMiddleware;

interface Deferrer
{
    public function getCurrentTime(): int;

    public function sleep(int $milliseconds);
}
