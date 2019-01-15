<?php

namespace Spatie\GuzzleRateLimiterMiddleware;

class RateLimiterMiddleware
{
    /** @var \Spatie\GuzzleRateLimiterMiddleware\RateLimiter */
    protected $rateLimiter;

    private function __construct(RateLimiter $rateLimiter)
    {
        $this->rateLimiter = $rateLimiter;
    }

    public static function perSecond(int $limit, Store $store = null): RateLimiter
    {
        $rateLimiter = new RateLimiter(
            $limit,
            RateLimiter::TIME_FRAME_SECOND,
            $store ?? new InMemoryStore(),
            new RealTimeMachine()
        );

        return new static($rateLimiter);
    }

    public static function perMinute(int $limit, Store $store = null): RateLimiter
    {
        $rateLimiter = new RateLimiter(
            $limit,
            RateLimiter::TIME_FRAME_SECOND,
            $store ?? new InMemoryStore(),
            new RealTimeMachine()
        );
    }

    public function __invoke()
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                return $this->rateLimiter->handle(function () {
                    return $handler($request, $options);
                });
            };
        };
    }
}
