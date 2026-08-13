<?php

namespace Spatie\GuzzleRateLimiterMiddleware;

class InMemoryStore implements Store
{
    /** @var array<int, int> */
    protected array $timestamps = [];

    /** @return array<int, int> */
    public function get(): array
    {
        return $this->timestamps;
    }

    public function push(int $timestamp, int $limit)
    {
        $this->timestamps[] = $timestamp;
    }
}
