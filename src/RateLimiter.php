<?php

namespace Spatie\GuzzleRateLimiterMiddleware;

class RateLimiter
{
    public function __construct(
        protected readonly int $limit,
        protected readonly TimeFrame $timeFrame,
        protected readonly Store $store,
        protected readonly Deferrer $deferrer,
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
        $currentTimeFrameStart = $this->deferrer->getCurrentTime() - $this->timeFrame->lengthInMilliseconds();

        $requestsInCurrentTimeFrame = array_values(array_filter(
            $this->store->get(),
            fn (int $timestamp) => $timestamp >= $currentTimeFrameStart,
        ));

        if (count($requestsInCurrentTimeFrame) < $this->limit) {
            return 0;
        }

        $oldestRequestStartTimeRelativeToCurrentTimeFrame =
            $this->deferrer->getCurrentTime() - $requestsInCurrentTimeFrame[0];

        return $this->timeFrame->lengthInMilliseconds() - $oldestRequestStartTimeRelativeToCurrentTimeFrame;
    }
}
