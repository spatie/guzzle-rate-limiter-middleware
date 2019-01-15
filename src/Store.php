<?php

namespace Spatie\GuzzleRateLimit;

interface Store
{
    public function get(): array;

    public function push(int $timestamp);
}
