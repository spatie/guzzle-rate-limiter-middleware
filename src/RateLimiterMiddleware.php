<?php

namespace Spatie\GuzzleRateLimiterMiddleware;

use Closure;
use Psr\Http\Message\RequestInterface;

class RateLimiterMiddleware
{
    private function __construct(
        protected readonly RateLimiter $rateLimiter,
    ) {
    }

    public static function perSecond(int $limit, ?Store $store = null, ?Deferrer $deferrer = null): static
    {
        return new static(new RateLimiter(
            $limit,
            TimeFrame::Second,
            $store ?? new InMemoryStore(),
            $deferrer ?? new SleepDeferrer(),
        ));
    }

    public static function perMinute(int $limit, ?Store $store = null, ?Deferrer $deferrer = null): static
    {
        return new static(new RateLimiter(
            $limit,
            TimeFrame::Minute,
            $store ?? new InMemoryStore(),
            $deferrer ?? new SleepDeferrer(),
        ));
    }

    public function __invoke(callable $handler): Closure
    {
        return fn (RequestInterface $request, array $options) => $this->rateLimiter->handle(
            fn () => $handler($request, $options),
        );
    }
}
