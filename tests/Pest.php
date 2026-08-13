<?php

use Spatie\GuzzleRateLimiterMiddleware\InMemoryStore;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiter;
use Spatie\GuzzleRateLimiterMiddleware\Tests\TestDeferrer;

function createRateLimiter(int $limit, string $timeFrame, TestDeferrer $deferrer): RateLimiter
{
    return new RateLimiter($limit, $timeFrame, new InMemoryStore(), $deferrer);
}
