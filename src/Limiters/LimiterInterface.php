<?php

namespace Silencenjoyer\RateLimit\Limiters;

use Closure;
use Silencenjoyer\RateLimit\Counters\CounterInterface;
use Silencenjoyer\RateLimit\Rates\RateInterface;

/**
 * A limiter interface that can work with different
 * {@see CounterInterface} implementations.
 *
 * @package Silencenjoyer\RateLimit
 */
interface LimiterInterface
{
    /**
     * Constructor.
     *
     * @param CounterInterface $counter
     * @param RateInterface $rate
     */
    public function __construct(CounterInterface $counter, RateInterface $rate);

    /**
     * An indication of whether the {@see RateInterface} has been exceeded.
     *
     * @return bool
     */
    public function isExceed(): bool;

    /**
     * Record the usage according to the rate limiting.
     *
     * @param int $count
     * @return void
     */
    public function collectUsage(int $count = 1): void;

    /**
     * Stretch the execution evenly according to the amount of time and<br>
     * the number of available operations.
     *
     * @param Closure $closure
     * @return mixed
     */
    public function stretch(Closure $closure);

    /**
     * Control number of executions according to the amount of time and the<br>
     * number of available operations.
     *
     * @param Closure $closure
     * @return mixed
     */
    public function control(Closure $closure);
}
