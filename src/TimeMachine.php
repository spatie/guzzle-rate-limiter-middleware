<?php

namespace Spatie\GuzzleRateLimiter;

interface TimeMachine
{
    public function getCurrentTime(): int;

    public function sleep(int $milliseconds);
}
