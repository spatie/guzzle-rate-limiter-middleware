<?php

namespace Spatie\GuzzleRateLimiterMiddleware\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Spatie\GuzzleRateLimiterMiddleware\InMemoryStore;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiter;

abstract class TestCase extends BaseTestCase
{
    /** @var \Spatie\GuzzleRateLimiterMiddleware\Tests\TestDeferrer */
    protected $deferrer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->deferrer = new TestDeferrer();
    }

    public function createRateLimiter(int $limit, int $timeInterval, string $timeUnit): RateLimiter
    {
        return new RateLimiter($limit, $timeInterval, $timeUnit, new InMemoryStore(), $this->deferrer);
    }
}
