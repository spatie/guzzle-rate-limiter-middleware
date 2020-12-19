# Changelog

All notable changes to `guzzle-rate-limiter-middleware` will be documented in this file

## 2.0.1 - 2020-12-19

- add support for PHP 8

## 2.0.0 - 2020-10-06

- Pass a `$limit` parameter in `Store::push`, the signature is now `Store::push(int $timestamp, int $limit)`
- Allow custom `Deferrer` instances to be passed to `RateLimiterMiddleware::perMinute` and `RateLimiterMiddleware::perSecond`

## 1.0.8 - 2020-07-16

- Allow Guzzle 7

## 1.0.7 - 2020-01-09

- Cast return value of SleepDeferrer to int (#7)

## 1.0.1 - 2019-10-25

- use usleep to ensure sleep actually happens (#5)

## 1.0.0 - 2019-10-08

- initial release
