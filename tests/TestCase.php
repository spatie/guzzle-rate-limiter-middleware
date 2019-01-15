<?php

namespace Spatie\GuzzleRateLimit\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Spatie\GuzzleRateLimit\InMemoryStore;
use Spatie\GuzzleRateLimit\RateLimiter;

abstract class TestCase extends BaseTestCase
{
    /** @var \Spatie\GuzzleRateLimiter\Tests\FakeTimeMachine */
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
