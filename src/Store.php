<?php

namespace Spatie\GuzzleRateLimiter;

interface Store
{
    public function get(): array;

    public function push(int $timestamp);
}
