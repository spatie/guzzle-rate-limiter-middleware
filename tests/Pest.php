<?php

use Spatie\GuzzleRateLimiterMiddleware\InMemoryStore;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiter;
use Spatie\GuzzleRateLimiterMiddleware\Tests\TestDeferrer;
use Spatie\GuzzleRateLimiterMiddleware\TimeFrame;

function createRateLimiter(int $limit, TimeFrame $timeFrame, TestDeferrer $deferrer): RateLimiter
{
    return new RateLimiter($limit, $timeFrame, new InMemoryStore(), $deferrer);
}
