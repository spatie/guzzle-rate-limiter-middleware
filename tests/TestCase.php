<?php

namespace Spatie\GuzzleRateLimit\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /** @var \Spatie\GuzzleRateLimiter\Tests\FakeTimeMachine */
    protected $timeMachine;

    public function setUp()
    {
        parent::setUp();

        $this->timeMachine = new FakeTimeMachine();
    }
}
