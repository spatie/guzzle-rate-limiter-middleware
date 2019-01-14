<?php

namespace Spatie\GuzzleRateLimit;

class RateLimiter
{
    const TIME_FRAME_MINUTE = 'minute';
    const TIME_FRAME_SECOND = 'second';

    /** @var int */
    protected $limit;

    /** @var string */
    protected $timeFrame;

    /** @var float[] */
    protected $log = [];

    /** @var \Spatie\GuzzleRateLimiter\TimeMachine */
    protected $timeMachine;

    public function __construct(int $limit, string $timeFrame, TimeMachine $timeMachine) {
        $this->limit = $limit;
        $this->timeFrame = $timeFrame;
        $this->timeMachine = $timeMachine;
    }

    public function handle(callable $callback)
    {
        if (! $this->allowsMoreActionsInCurrentTimeFrame()) {
            $this->timeMachine->sleep($this->timeUntilNextTimeFrame());
        }

        $this->log[] = $this->timeMachine->getCurrentTime();

        $callback();
    }

    protected function allowsMoreActionsInCurrentTimeFrame(): bool
    {
        $currentTimeFrameStart = $this->timeMachine->getCurrentTime() - $this->timeFrameInMilliseconds();

        $actionsInCurrentTimeFrame = array_filter($this->log, function (int $timestamp) use ($currentTimeFrameStart) {
            return $timestamp >= $currentTimeFrameStart;
        });

        return $actionsInCurrentTimeFrame < $this->limit;
    }

    protected function timeUntilNextTimeFrame(): int
    {
        // Todo

        return array_slice($this->log, -1 * $this->limit)[0] + $this->timeFrameInMilliseconds();
    }

    protected function timeFrameInMilliseconds(): int
    {
        if ($this->timeFrame === self::TIME_FRAME_MINUTE) {
            return 60 * 1000;
        }

        return 1000;
    }
}
