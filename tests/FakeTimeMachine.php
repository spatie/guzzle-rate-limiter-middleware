<?php

namespace Spatie\GuzzleRateLimit\Tests;

use Exception;
use Spatie\GuzzleRateLimit\TimeMachine;

class FakeTimeMachine implements TimeMachine
{
    public function getCurrentTime(): int
    {
        if (empty($this->currentTimes)) {
            throw new Exception("No current time call expected.");
        }

        return array_shift($this->currentTimes);
    }

    public function expectCurrentTimeCalls(array $currentTimes)
    {
        $this->currentTimes = $currentTimes;
    }

    public function sleep(int $milliseconds)
    {
    }
}
