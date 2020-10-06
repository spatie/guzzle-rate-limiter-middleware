<?php

namespace Spatie\GuzzleRateLimiterMiddleware\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Spatie\GuzzleRateLimiterMiddleware\InMemoryStore;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiter;

abstract class TestCase extends BaseTestCase
{
    /** @var \Spatie\GuzzleRateLimiterMiddleware\Tests\TestDeferrer */
    protected $deferrer;

    public function setUp()
    {
        parent::setUp();

        $this->deferrer = new TestDeferrer();
    }

    public function createRateLimiter(int $limit, string $timeFrame): RateLimiter
    {
        return new RateLimiter($limit, $timeFrame, new InMemoryStore(), $this->deferrer);
    }
}
