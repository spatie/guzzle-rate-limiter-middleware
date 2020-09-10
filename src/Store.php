<?php

namespace Spatie\GuzzleRateLimiterMiddleware;

interface Store
{
    public function get(): array;

    public function push(int $timestamp, int $limit);
}
