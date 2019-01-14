<?php

namespace Spatie\GuzzleRateLimit;

class RateLimit
{
    /** @var \Spatie\GuzzleRateLimiter\RateLimiter */
    protected $rateLimiter;

    private function __construct(RateLimiter $rateLimiter)
    {
        $this->rateLimiter = $rateLimiter;
    }

    public static function perSecond(int $limit): RateLimiter
    {
        $rateLimiter = new RateLimiter(
            $limit,
            RateLimiter::TIME_FRAME_SECOND,
            new RealTimeMachine()
        );

        return new static($rateLimiter);
    }

    public static function perMinute(int $limit): RateLimiter
    {
        $rateLimiter = new RateLimiter(
            $limit,
            RateLimiter::TIME_FRAME_SECOND,
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
