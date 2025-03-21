<?php

namespace Silencenjoyer\RateLimit\Counters;

use Silencenjoyer\RateLimit\Intervals\IntervalInterface;
use Silencenjoyer\RateLimit\Intervals\Interval;

/**
 * Class ArrayCounter
 *
 * @package Silencenjoyer\RateLimit\Counters
 */
class LocalCounter implements CounterInterface
{
    protected int $value;
    protected int $expiry;

    protected function getCurrentTimeInMilliseconds(): int
    {
        return (int) (microtime(true) * IntervalInterface::MILLISECONDS_IN_SECOND);
    }

    protected function cleanExpired(): void
    {
        if (!isset($this->value, $this->expiry)) {
            return;
        }

        $now = $this->getCurrentTimeInMilliseconds();

        if ($this->expiry <= $now) {
            $this->unsetCount();
        }
    }

    protected function unsetCount()
    {
        unset($this->value, $this->expiry);
    }

    public function current(): ?int
    {
        $this->cleanExpired();

        if (!isset($this->value)) {
            return null;
        }

        return $this->value;
    }

    public function increment(int $incr, IntervalInterface $interval): void
    {
        $this->cleanExpired();

        $now = $this->getCurrentTimeInMilliseconds();
        $ttl = $interval->toMilliseconds();

        if (!isset($this->value)) {
            $this->value = 0;
            $this->expiry = $now + $ttl;
        }

        $this->value += $incr;
    }

    public function getRemainingInterval(): IntervalInterface
    {
        $this->cleanExpired();

        if (!isset($this->value)) {
            return new Interval('PT0S');
        }

        $remaining = max(
            0,
            $this->expiry - $this->getCurrentTimeInMilliseconds()
        );

        $interval = new Interval('PT0S');
        $interval->f = $remaining * IntervalInterface::MILLISECONDS_IN_SECOND;
        return $interval;
    }
}
