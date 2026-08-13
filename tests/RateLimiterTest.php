<?php

use Spatie\GuzzleRateLimiterMiddleware\RateLimiter;
use Spatie\GuzzleRateLimiterMiddleware\Tests\TestDeferrer;

it('executes actions below a limit in seconds', function () {
    $deferrer = new TestDeferrer();
    $rateLimiter = createRateLimiter(3, RateLimiter::TIME_FRAME_SECOND, $deferrer);

    expect($deferrer->getCurrentTime())->toBe(0);

    $rateLimiter->handle(fn () => $deferrer->sleep(100));

    expect($deferrer->getCurrentTime())->toBe(100);

    $rateLimiter->handle(fn () => $deferrer->sleep(100));

    expect($deferrer->getCurrentTime())->toBe(200);

    $rateLimiter->handle(fn () => $deferrer->sleep(100));

    expect($deferrer->getCurrentTime())->toBe(300);

    $deferrer->sleep(700);

    $rateLimiter->handle(fn () => $deferrer->sleep(100));

    expect($deferrer->getCurrentTime())->toBe(1100);

    $rateLimiter->handle(fn () => $deferrer->sleep(100));

    expect($deferrer->getCurrentTime())->toBe(1200);
});

it('defers actions when it reaches a limit in seconds', function () {
    $deferrer = new TestDeferrer();
    $rateLimiter = createRateLimiter(3, RateLimiter::TIME_FRAME_SECOND, $deferrer);

    expect($deferrer->getCurrentTime())->toBe(0);

    $rateLimiter->handle(fn () => null);

    expect($deferrer->getCurrentTime())->toBe(0);

    $rateLimiter->handle(fn () => null);

    expect($deferrer->getCurrentTime())->toBe(0);

    $rateLimiter->handle(fn () => null);

    expect($deferrer->getCurrentTime())->toBe(0);

    $rateLimiter->handle(fn () => null);

    expect($deferrer->getCurrentTime())->toBe(1000);
});

it('executes actions below a limit in minutes', function () {
    $deferrer = new TestDeferrer();
    $rateLimiter = createRateLimiter(3, RateLimiter::TIME_FRAME_MINUTE, $deferrer);

    expect($deferrer->getCurrentTime())->toBe(0);

    $rateLimiter->handle(fn () => $deferrer->sleep(100));

    expect($deferrer->getCurrentTime())->toBe(100);

    $rateLimiter->handle(fn () => $deferrer->sleep(100));

    expect($deferrer->getCurrentTime())->toBe(200);

    $rateLimiter->handle(fn () => $deferrer->sleep(100));

    expect($deferrer->getCurrentTime())->toBe(300);

    $deferrer->sleep(59700);

    $rateLimiter->handle(fn () => $deferrer->sleep(100));

    expect($deferrer->getCurrentTime())->toBe(60100);
});

it('defers actions when it reaches a limit in minutes', function () {
    $deferrer = new TestDeferrer();
    $rateLimiter = createRateLimiter(3, RateLimiter::TIME_FRAME_MINUTE, $deferrer);

    expect($deferrer->getCurrentTime())->toBe(0);

    $rateLimiter->handle(fn () => null);

    expect($deferrer->getCurrentTime())->toBe(0);

    $rateLimiter->handle(fn () => null);

    expect($deferrer->getCurrentTime())->toBe(0);

    $rateLimiter->handle(fn () => null);

    expect($deferrer->getCurrentTime())->toBe(0);

    $rateLimiter->handle(fn () => null);

    expect($deferrer->getCurrentTime())->toBe(60000);
});
