<?php

namespace Spatie\GuzzleRateLimiterMiddleware;

class RateLimiter
{
    const TIME_FRAME_MINUTE = 'minute';
    const TIME_FRAME_SECOND = 'second';

    /** @var int */
    protected $limit;

    /** @var string */
    protected $timeFrame;

    /** @var \Spatie\RateLimiter\Store */
    protected $store;

    /** @var \Spatie\GuzzleRateLimiterMiddleware\Deferrer */
    protected $deferrer;

    public function __construct(
        int $limit,
        string $timeFrame,
        Store $store,
        Deferrer $deferrer
    ) {
        $this->limit = $limit;
        $this->timeFrame = $timeFrame;
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
        if ($this->timeFrame === self::TIME_FRAME_MINUTE) {
            return 60 * 1000;
        }

        return 1000;
    }
}
