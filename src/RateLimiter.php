<?php

namespace Spatie\GuzzleRateLimiterMiddleware;

class RateLimiter
{
    const TIME_FRAME_MINUTE = 'minute';
    const TIME_FRAME_SECOND = 'second';

    public function __construct(
        protected int $limit,
        protected string $timeFrame,
        protected Store $store,
        protected Deferrer $deferrer,
    ) {
    }

    public function handle(callable $callback): mixed
    {
        $delayUntilNextRequest = $this->delayUntilNextRequest();

        if ($delayUntilNextRequest > 0) {
            $this->deferrer->sleep($delayUntilNextRequest);
        }

        $this->store->push(
            $this->deferrer->getCurrentTime(),
            $this->limit,
        );

        return $callback();
    }

    protected function delayUntilNextRequest(): int
    {
        $currentTimeFrameStart = $this->deferrer->getCurrentTime() - $this->timeFrameLengthInMilliseconds();

        $requestsInCurrentTimeFrame = array_values(array_filter(
            $this->store->get(),
            fn (int $timestamp) => $timestamp >= $currentTimeFrameStart,
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
        return match ($this->timeFrame) {
            self::TIME_FRAME_MINUTE => 60 * 1000,
            default => 1000,
        };
    }
}
