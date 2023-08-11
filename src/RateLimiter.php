<?php

namespace Spatie\GuzzleRateLimiterMiddleware;

class RateLimiter
{
    const TIME_FRAME_DAY = 'day';
    const TIME_FRAME_HOUR = 'hour';
    const TIME_FRAME_MINUTE = 'minute';
    const TIME_FRAME_SECOND = 'second';
    const TIME_FRAME_MILLISECOND = 'millisecond';

    /** @var int */
    protected $limit;

    /** @var int */
    protected $timeInterval;

    /** @var string */
    protected $timeUnit;

    /** @var \Spatie\RateLimiter\Store */
    protected $store;

    /** @var \Spatie\GuzzleRateLimiterMiddleware\Deferrer */
    protected $deferrer;

    public function __construct(
        int $limit,
        int $timeInterval,
        string $timeUnit,
        Store $store,
        Deferrer $deferrer
    ) {
        $this->limit = $limit;
        $this->timeInterval = $timeInterval;
        $this->timeUnit = $timeUnit;
        $this->store = $store;
        $this->deferrer = $deferrer;
    }

    public function handle(callable $callback)
    {
        $delayUntilNextRequest = $this->delayUntilNextRequest();

        if ($delayUntilNextRequest > 0) {
            $this->deferrer->sleep($delayUntilNextRequest);
        }

        $this->store->push(
            $this->deferrer->getCurrentTime(),
            $this->limit
        );

        return $callback();
    }

    protected function delayUntilNextRequest(): int
    {
        $currentTimeFrameStart = $this->deferrer->getCurrentTime() - $this->timeFrameLengthInMilliseconds();

        $requestsInCurrentTimeFrame = array_values(array_filter(
            $this->store->get(),
            function (int $timestamp) use ($currentTimeFrameStart) {
                return $timestamp >= $currentTimeFrameStart;
            }
        ));

        if (count($requestsInCurrentTimeFrame) < $this->limit) {
            return 0;
        }

        $oldestRequestStartTimeRelativeToCurrentTimeFrame =
            $this->deferrer->getCurrentTime() - $requestsInCurrentTimeFrame[0];

        return $this->timeFrameLengthInMilliseconds() - $oldestRequestStartTimeRelativeToCurrentTimeFrame;
    }

    protected function timeFrameLengthInMilliseconds(): int
    {
        $unitsInMilliseconds = [
            'millisecond' => 1,
            'second' => 1000,
            'minute' => 60 * 1000,
            'hour'   => 60 * 60 * 1000,
            'day'    => 24 * 60 * 60 * 1000,
        ];

        if (! isset($unitsInMilliseconds[$this->timeUnit])) {
            throw new \Exception("Invalid time unit provided: $this->timeUnit");
        }

        return $this->timeInterval * $unitsInMilliseconds[$this->timeUnit];
    }
}
