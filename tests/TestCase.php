<?php

namespace Spatie\GuzzleRateLimiterMiddleware\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiter;
use Spatie\GuzzleRateLimiterMiddleware\InMemoryStore;

abstract class TestCase extends BaseTestCase
{
    /** @var \Spatie\GuzzleRateLimiterMiddleware\Tests\FakeTimeMachine */
    protected $timeMachine;

    public function setUp()
    {
        parent::setUp();

        $this->timeMachine = new FakeTimeMachine();
    }

    public function createRateLimiter(int $limit, string $timeFrame): RateLimiter
    {
        return new RateLimiter($limit, $timeFrame, new InMemoryStore(), $this->timeMachine);
    }
}
