<?php

namespace Spatie\GuzzleRateLimiterMiddleware;

class InMemoryStore implements Store
{
    /** @var int[] */
    protected $timestamps = [];

    public function get(): array
    {
        return $this->timestamps;
    }

    public function push(int $timestamp, int $limit)
    {
        $this->timestamps[] = $timestamp;
    }
}
