<?php

namespace Spatie\GuzzleRateLimit;

class InMemoryStore implements Store
{
    /** @var int[] */
    protected $timestamps = [];

    public function get(): array
    {
        return $this->timestamps;
    }

    public function push(int $timestamp)
    {
        $this->timestamps[] = $timestamp;
    }
}
