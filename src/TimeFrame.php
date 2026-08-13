<?php

namespace Spatie\GuzzleRateLimiterMiddleware;

enum TimeFrame: string
{
    case Second = 'second';
    case Minute = 'minute';

    public function lengthInMilliseconds(): int
    {
        return match ($this) {
            self::Second => 1000,
            self::Minute => 60 * 1000,
        };
    }
}
