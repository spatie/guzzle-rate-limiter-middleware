<?php

namespace Spatie\GuzzleRateLimit;

interface TimeMachine
{
    public function getCurrentTime(): int;

    public function sleep(int $milliseconds);
}
