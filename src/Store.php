<?php

namespace Spatie\GuzzleRateLimiterMiddleware;

interface Store
{
    /** @return array<int, int> */
    public function get(): array;

    public function push(int $timestamp, int $limit);
}
