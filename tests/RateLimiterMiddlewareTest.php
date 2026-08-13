<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Spatie\GuzzleRateLimiterMiddleware\InMemoryStore;
use Spatie\GuzzleRateLimiterMiddleware\RateLimiterMiddleware;
use Spatie\GuzzleRateLimiterMiddleware\Tests\TestDeferrer;

it('has named constructors to create instances', function () {
    expect(RateLimiterMiddleware::perSecond(5))->toBeInstanceOf(RateLimiterMiddleware::class);

    expect(RateLimiterMiddleware::perMinute(5))->toBeInstanceOf(RateLimiterMiddleware::class);
});

it('defers requests sent through a guzzle client', function () {
    $deferrer = new TestDeferrer();

    $stack = HandlerStack::create(new MockHandler([
        new Response(200),
        new Response(200),
        new Response(200),
        new Response(200),
    ]));

    $stack->push(RateLimiterMiddleware::perSecond(3, new InMemoryStore(), $deferrer));

    $client = new Client(['handler' => $stack]);

    foreach (range(1, 3) as $ignored) {
        expect($client->get('https://spatie.be')->getStatusCode())->toBe(200);
    }

    expect($deferrer->getCurrentTime())->toBe(0);

    $client->get('https://spatie.be');

    expect($deferrer->getCurrentTime())->toBe(1000);
});
